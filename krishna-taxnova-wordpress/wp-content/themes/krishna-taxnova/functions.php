<?php
/**
 * Krishna TaxNova theme setup.
 *
 * @package krishna-taxnova
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KTN_THEME_VERSION', '1.3.0' );

function ktn_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 220, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'automatic-feed-links' );
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu (optional, mega menu is automatic)', 'krishna-taxnova' ),
			'footer'  => __( 'Footer Menu', 'krishna-taxnova' ),
		)
	);
}
add_action( 'after_setup_theme', 'ktn_theme_setup' );

function ktn_theme_assets() {
	wp_enqueue_style( 'ktn-theme', get_template_directory_uri() . '/assets/css/main.css', array(), KTN_THEME_VERSION );
	wp_enqueue_script( 'ktn-theme', get_template_directory_uri() . '/assets/js/main.js', array(), KTN_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'ktn_theme_assets' );

/**
 * Keep the front end lean: no emoji scripts, no jQuery migrate on front.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );

/**
 * Service categories with their services, cached per request. Used by the
 * automatic mega menu, homepage grid and footer.
 */
function ktn_get_service_tree() {
	static $tree = null;
	if ( null !== $tree ) {
		return $tree;
	}
	$tree = array();
	if ( ! taxonomy_exists( 'service_category' ) ) {
		return $tree;
	}
	$terms = get_terms(
		array(
			'taxonomy'   => 'service_category',
			'hide_empty' => false,
			'orderby'    => 'term_id',
		)
	);
	if ( is_wp_error( $terms ) ) {
		return $tree;
	}
	foreach ( $terms as $term ) {
		$services = get_posts(
			array(
				'post_type'      => 'service',
				'posts_per_page' => 30,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
				'post_status'    => 'publish',
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'service_category',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					),
				),
			)
		);
		$tree[] = array(
			'term'     => $term,
			'services' => $services,
		);
	}
	return $tree;
}

/**
 * Customizer: homepage showcase images and copy.
 * Appearance -> Customize -> Homepage Showcase lets the owner change the
 * two photos, the heading and the intro text without touching code.
 */
function ktn_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'ktn_showcase',
		array(
			'title'    => __( 'Homepage Showcase', 'krishna-taxnova' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting( 'ktn_showcase_heading', array( 'default' => 'Your Trusted Experts for Every Tax and Compliance Matter', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'ktn_showcase_heading', array( 'label' => __( 'Heading', 'krishna-taxnova' ), 'section' => 'ktn_showcase', 'type' => 'text' ) );

	$wp_customize->add_setting( 'ktn_showcase_text', array( 'default' => 'We simplify complex tax and compliance rules into clear guidance and fixed price plans that fit your business. One qualified team, accountable end to end.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'ktn_showcase_text', array( 'label' => __( 'Intro text', 'krishna-taxnova' ), 'section' => 'ktn_showcase', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'ktn_showcase_img1', array( 'default' => '', 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'ktn_showcase_img1',
			array(
				'label'     => __( 'Large photo (portrait works best)', 'krishna-taxnova' ),
				'section'   => 'ktn_showcase',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting( 'ktn_showcase_img2', array( 'default' => '', 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'ktn_showcase_img2',
			array(
				'label'     => __( 'Small photo (landscape works best)', 'krishna-taxnova' ),
				'section'   => 'ktn_showcase',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'ktn_customize_register' );

/**
 * Showcase image helper: returns an img tag for the customizer image, or a
 * branded placeholder panel until a photo is uploaded.
 */
function ktn_showcase_image( $setting, $size = 'large' ) {
	$attachment_id = (int) get_theme_mod( $setting );
	if ( $attachment_id ) {
		$img = wp_get_attachment_image( $attachment_id, $size, false, array( 'class' => 'ktn-showcase-photo' ) );
		if ( $img ) {
			return $img;
		}
	}
	return '<span class="ktn-showcase-placeholder" aria-hidden="true">'
		. '<svg viewBox="0 0 24 24" width="42" height="42" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.35-4.35a1.5 1.5 0 0 0-2.12 0L5 20"/></svg>'
		. '<em>' . esc_html__( 'Add photo in Customizer', 'krishna-taxnova' ) . '</em></span>';
}

/**
 * Grouped navigation: the 10 service categories are organised into five
 * clear top level groups so the header stays clean and balanced. Any new
 * category not listed here automatically appears under "More Services".
 */
function ktn_get_menu_groups() {
	$map = array(
		__( 'Start a Business', 'krishna-taxnova' )   => array( 'company-registration', 'ngo-services' ),
		__( 'Tax & GST', 'krishna-taxnova' )          => array( 'gst-services', 'income-tax' ),
		__( 'Compliance & IPR', 'krishna-taxnova' )   => array( 'mca-compliance', 'trademark-ipr' ),
		__( 'Licenses', 'krishna-taxnova' )           => array( 'licenses-registrations', 'environmental-epr' ),
		__( 'Finance & Advisory', 'krishna-taxnova' ) => array( 'accounting-finance', 'nbfc-fintech' ),
	);

	$by_slug = array();
	foreach ( ktn_get_service_tree() as $branch ) {
		$by_slug[ $branch['term']->slug ] = $branch;
	}

	$groups = array();
	foreach ( $map as $label => $slugs ) {
		$branches = array();
		foreach ( $slugs as $slug ) {
			if ( isset( $by_slug[ $slug ] ) ) {
				$branches[] = $by_slug[ $slug ];
				unset( $by_slug[ $slug ] );
			}
		}
		if ( $branches ) {
			$groups[] = array( 'label' => $label, 'branches' => $branches );
		}
	}
	if ( $by_slug ) {
		$groups[] = array( 'label' => __( 'More Services', 'krishna-taxnova' ), 'branches' => array_values( $by_slug ) );
	}
	return $groups;
}

/**
 * Inline SVG icon set for categories.
 */
function ktn_icon( $key ) {
	$icons = array(
		'building'  => '<path d="M3 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16M7 7h2m-2 4h2m-2 4h2m6-8h4a2 2 0 0 1 2 2v12M17 11h2m-2 4h2M1 21h22"/>',
		'percent'   => '<path d="M19 5 5 19M6.5 9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Zm11 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>',
		'rupee'     => '<path d="M6 3h12M6 8h12M14.5 21 6 13h3a5 5 0 0 0 0-10"/>',
		'shield'    => '<path d="M12 22s8-3.5 8-10V5l-8-3-8 3v7c0 6.5 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
		'clipboard' => '<path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2m-7 7h6m-6 4h6"/>',
		'license'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h6m-6 4h4m5.5 4.5L15 15a2.5 2.5 0 1 1 3-3"/>',
		'heart'     => '<path d="M19 14c1.5-1.4 3-3.1 3-5.3A4.7 4.7 0 0 0 17.3 4c-1.9 0-3.4 1-4.3 2.6l-1-.02C11.1 5 9.6 4 7.7 4A4.7 4.7 0 0 0 3 8.7c0 2.2 1.5 3.9 3 5.3l6 5.5 7-5.5Z"/>',
		'bank'      => '<path d="m3 9 9-6 9 6M4 9v11m16-11v11M2 20h20M8 12v5m4-5v5m4-5v5"/>',
		'leaf'      => '<path d="M11 20A7 7 0 0 1 4 13c0-5 4-9 10-10 3.5-.5 6 0 6 0s.5 2.5 0 6c-1 6-5 10-10 10Z"/><path d="M6 18c3-3 6-5 10-7"/>',
		'chart'     => '<path d="M3 3v18h18M8 17v-6m4 6V7m4 10v-4"/>',
		'briefcase' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m-6 6h20"/>',
	);
	$path = isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['briefcase'];
	return '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

/**
 * Breadcrumbs (visible; JSON-LD comes from the core plugin).
 */
function ktn_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="ktn-crumbs" aria-label="Breadcrumb"><div class="wrap"><a href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
	if ( is_singular( 'service' ) ) {
		$terms = get_the_terms( get_the_ID(), 'service_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$link = get_term_link( $terms[0] );
			if ( ! is_wp_error( $link ) ) {
				echo ' <span>&rsaquo;</span> <a href="' . esc_url( $link ) . '">' . esc_html( $terms[0]->name ) . '</a>';
			}
		}
		echo ' <span>&rsaquo;</span> <span class="ktn-crumb-current">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_tax( 'service_category' ) ) {
		echo ' <span>&rsaquo;</span> <a href="' . esc_url( get_post_type_archive_link( 'service' ) ) . '">Services</a>';
		echo ' <span>&rsaquo;</span> <span class="ktn-crumb-current">' . esc_html( single_term_title( '', false ) ) . '</span>';
	} elseif ( is_post_type_archive( 'service' ) ) {
		echo ' <span>&rsaquo;</span> <span class="ktn-crumb-current">Services</span>';
	} elseif ( is_singular() ) {
		echo ' <span>&rsaquo;</span> <span class="ktn-crumb-current">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_search() ) {
		echo ' <span>&rsaquo;</span> <span class="ktn-crumb-current">Search results</span>';
	}
	echo '</div></nav>';
}

/**
 * FAQ accordion markup from an array of q/a pairs.
 */
function ktn_render_faqs( $faqs, $heading = 'Frequently Asked Questions' ) {
	if ( empty( $faqs ) ) {
		return;
	}
	echo '<section class="ktn-faq-section"><h2>' . esc_html( $heading ) . '</h2><div class="ktn-faqs">';
	foreach ( $faqs as $faq ) {
		$q = isset( $faq['q'] ) ? $faq['q'] : ( isset( $faq[0] ) ? $faq[0] : '' );
		$a = isset( $faq['a'] ) ? $faq['a'] : ( isset( $faq[1] ) ? $faq[1] : '' );
		if ( ! $q || ! $a ) {
			continue;
		}
		echo '<details class="ktn-faq"><summary><h3>' . esc_html( $q ) . '</h3></summary><div class="ktn-faq-a"><p>' . wp_kses_post( $a ) . '</p></div></details>';
	}
	echo '</div></section>';
}

/**
 * Fallback helpers when the core plugin is not active, so the theme
 * never fatals.
 */
if ( ! function_exists( 'ktn_get_option' ) ) {
	function ktn_get_option( $key, $default = '' ) {
		return $default;
	}
}
if ( ! function_exists( 'ktn_whatsapp_button' ) ) {
	function ktn_whatsapp_button( $service = '', $style = 'inline' ) {
		return '';
	}
}
if ( ! function_exists( 'ktn_whatsapp_url' ) ) {
	function ktn_whatsapp_url( $service = '' ) {
		return '#';
	}
}
if ( ! function_exists( 'ktn_get_service_faqs' ) ) {
	function ktn_get_service_faqs( $post_id ) {
		return array();
	}
}

/**
 * Excerpt length for cards.
 */
function ktn_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'ktn_excerpt_length' );
