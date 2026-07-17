<?php
/**
 * ePoojaBooking theme functions.
 *
 * @package epoojabooking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EPB_THEME_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function epb_theme_setup() {
	load_theme_textdomain( 'epoojabooking', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 64,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'woocommerce' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'epoojabooking' ),
		'footer'  => __( 'Footer Menu', 'epoojabooking' ),
	) );
}
add_action( 'after_setup_theme', 'epb_theme_setup' );

/**
 * Enqueue styles and scripts.
 */
function epb_enqueue_assets() {
	// Self-hosted friendly Google Fonts request, swapped for fast paint.
	wp_enqueue_style(
		'epb-fonts',
		'https://fonts.googleapis.com/css2?family=Rozha+One&family=Mukta:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'epb-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'epb-fonts' ),
		EPB_THEME_VERSION
	);

	wp_enqueue_script(
		'epb-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		EPB_THEME_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'epb_enqueue_assets' );

/**
 * Preconnect for Google Fonts.
 *
 * @param array  $urls          Resource hints.
 * @param string $relation_type Relation type.
 * @return array
 */
function epb_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'epb_resource_hints', 10, 2 );

/**
 * Meta description fallback when no SEO plugin is active.
 */
function epb_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
		return;
	}

	$description = '';

	if ( is_front_page() ) {
		$description = get_bloginfo( 'description', 'display' );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$custom = get_post_meta( $post->ID, 'epb_meta_description', true );
			if ( $custom ) {
				$description = $custom;
			} elseif ( has_excerpt( $post ) ) {
				$description = get_the_excerpt( $post );
			}
		}
	}

	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'epb_meta_description', 1 );

/**
 * Open Graph basics when no SEO plugin is active.
 */
function epb_open_graph() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
		return;
	}
	if ( ! is_singular() && ! is_front_page() ) {
		return;
	}

	$title = is_front_page() ? get_bloginfo( 'name' ) : get_the_title();
	$url   = is_front_page() ? home_url( '/' ) : get_permalink();

	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";

	if ( is_singular() && has_post_thumbnail() ) {
		$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
		if ( $img ) {
			echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'epb_open_graph', 2 );

/**
 * Fallback menu: pulls the core service pages when no menu is assigned.
 */
function epb_fallback_menu() {
	$links = array(
		'online-puja-booking'            => __( 'Book Puja', 'epoojabooking' ),
		'online-chadhava-offering'       => __( 'Chadhava', 'epoojabooking' ),
		'online-astrology-consultation'  => __( 'Astrology', 'epoojabooking' ),
		'online-havan-booking'           => __( 'Havan', 'epoojabooking' ),
		'book-pandit-online'             => __( 'Pandit Ji', 'epoojabooking' ),
		'faq'                            => __( 'FAQ', 'epoojabooking' ),
	);

	echo '<ul class="epb-nav-list">';
	if ( post_type_exists( 'epb_puja' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'epb_puja' ) ) . '">' . esc_html__( 'Puja', 'epoojabooking' ) . '</a></li>';
	}
	if ( post_type_exists( 'epb_temple' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'epb_temple' ) ) . '">' . esc_html__( 'Temples', 'epoojabooking' ) . '</a></li>';
	}
	foreach ( $links as $slug => $label ) {
		$page = get_page_by_path( $slug );
		$url  = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Breadcrumbs.
 */
function epb_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="epb-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'epoojabooking' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'epoojabooking' ) . '</a>';
	echo '<span aria-hidden="true"> › </span>';
	if ( is_singular() ) {
		echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} else {
		echo '<span aria-current="page">' . esc_html( wp_get_document_title() ) . '</span>';
	}
	echo '</nav>';
}

/**
 * Inline SVG icons (Lucide-inspired strokes, consistent 1.5px weight).
 *
 * @param string $name Icon name.
 */
function epb_the_icon( $name ) {
	$attrs = 'viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';

	$icons = array(
		'flame' => '<path d="M12 3c-2.5 3-5 5.5-5 8.5a5 5 0 0 0 10 0C17 8.5 14.5 6 12 3Z"/><path d="M12 13a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 12 18a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 12 13Z"/>',
		'lotus' => '<path d="M12 20c-4 0-8-2.5-9-6 2-.5 3.5-.3 5 .5C7 11 8.5 8 12 5c3.5 3 5 6 4 9.5 1.5-.8 3-1 5-.5-1 3.5-5 6-9 6Z"/><path d="M12 20c-1.5-2-2-4.5-1-7"/><path d="M12 20c1.5-2 2-4.5 1-7"/>',
		'star'  => '<path d="M12 3l2.4 5.4 5.6.6-4.2 3.9 1.2 5.6L12 15.6 7 18.5l1.2-5.6L4 9l5.6-.6Z"/>',
		'kalash'=> '<path d="M8 8h8l-1 9a3 3 0 0 1-3 3 3 3 0 0 1-3-3Z"/><path d="M7 8c0-2 2.5-3 5-3s5 1 5 3"/><path d="M12 5V3"/><path d="M9.5 3.5 12 3l2.5.5"/>',
		'fire'  => '<path d="M4 21h16"/><path d="M6 21l2-4h8l2 4"/><path d="M12 4c-2 2.5-3.5 4.5-3.5 7a3.5 3.5 0 0 0 7 0C15.5 8.5 14 6.5 12 4Z"/>',
		'bell'  => '<path d="M12 3a1.5 1.5 0 0 1 1.5 1.5V5a6 6 0 0 1 4.5 5.8V15l1.5 2H4.5L6 15v-4.2A6 6 0 0 1 10.5 5v-.5A1.5 1.5 0 0 1 12 3Z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
		'user'  => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
		'shield'=> '<path d="M12 3l7 3v5c0 5-3 8.5-7 10-4-1.5-7-5-7-10V6Z"/><path d="M9 12l2 2 4-4"/>',
		'calendar' => '<rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 3v4"/><path d="M16 3v4"/><path d="M4 10h16"/>',
	);

	if ( isset( $icons[ $name ] ) ) {
		echo '<svg ' . $attrs . '>' . $icons[ $name ] . '</svg>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

require get_template_directory() . '/inc/schema.php';
