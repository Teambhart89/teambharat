<?php
/**
 * CIHS Theme functions and definitions.
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CIHS_VERSION', '1.2.0' );

/* --------------------------------------------------------------------------
 * Theme setup
 * ------------------------------------------------------------------------ */
function cihs_setup() {
	load_theme_textdomain( 'cihs', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 360,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'cihs' ),
			'footer'  => __( 'Footer Menu', 'cihs' ),
			'legal'   => __( 'Legal Menu', 'cihs' ),
		)
	);

	add_image_size( 'cihs-card', 640, 360, true );

	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'CIHS Navy', 'cihs' ), 'slug' => 'cihs-navy', 'color' => '#14213d' ),
			array( 'name' => __( 'CIHS Saffron', 'cihs' ), 'slug' => 'cihs-saffron', 'color' => '#e8963a' ),
			array( 'name' => __( 'CIHS Ivory', 'cihs' ), 'slug' => 'cihs-ivory', 'color' => '#faf7f0' ),
			array( 'name' => __( 'CIHS Ink', 'cihs' ), 'slug' => 'cihs-ink', 'color' => '#232733' ),
			array( 'name' => __( 'White', 'cihs' ), 'slug' => 'cihs-white', 'color' => '#ffffff' ),
		)
	);
}
add_action( 'after_setup_theme', 'cihs_setup' );

function cihs_content_width() {
	$GLOBALS['content_width'] = 840;
}
add_action( 'after_setup_theme', 'cihs_content_width', 0 );

/* --------------------------------------------------------------------------
 * Scripts & styles
 * ------------------------------------------------------------------------ */
function cihs_scripts() {
	wp_enqueue_style( 'cihs-style', get_stylesheet_uri(), array(), CIHS_VERSION );
	wp_enqueue_script( 'cihs-main', get_template_directory_uri() . '/assets/js/main.js', array(), CIHS_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cihs_scripts' );

/* --------------------------------------------------------------------------
 * Widget areas
 * ------------------------------------------------------------------------ */
function cihs_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'cihs' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Shown next to analysis articles and archives.', 'cihs' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer Column', 'cihs' ),
			'id'            => 'footer-1',
			'description'   => __( 'Optional extra footer widgets.', 'cihs' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'cihs_widgets_init' );

/* --------------------------------------------------------------------------
 * Custom post types & taxonomies
 * ------------------------------------------------------------------------ */
function cihs_register_post_types() {

	// Publications: research papers, reports, issue briefs.
	register_post_type(
		'cihs_publication',
		array(
			'labels'       => array(
				'name'          => __( 'Publications', 'cihs' ),
				'singular_name' => __( 'Publication', 'cihs' ),
				'add_new_item'  => __( 'Add New Publication', 'cihs' ),
				'edit_item'     => __( 'Edit Publication', 'cihs' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'publications' ),
			'menu_icon'    => 'dashicons-media-document',
			'menu_position'=> 5,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'cihs_publication_type',
		'cihs_publication',
		array(
			'labels'       => array(
				'name'          => __( 'Publication Types', 'cihs' ),
				'singular_name' => __( 'Publication Type', 'cihs' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'publication-type' ),
			'show_in_rest' => true,
		)
	);

	register_taxonomy(
		'cihs_focus_area',
		array( 'cihs_publication', 'post' ),
		array(
			'labels'       => array(
				'name'          => __( 'Focus Areas', 'cihs' ),
				'singular_name' => __( 'Focus Area', 'cihs' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'focus-area' ),
			'show_in_rest' => true,
		)
	);

	// Events: seminars, lectures, round tables.
	register_post_type(
		'cihs_event',
		array(
			'labels'       => array(
				'name'          => __( 'Events', 'cihs' ),
				'singular_name' => __( 'Event', 'cihs' ),
				'add_new_item'  => __( 'Add New Event', 'cihs' ),
				'edit_item'     => __( 'Edit Event', 'cihs' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'events' ),
			'menu_icon'    => 'dashicons-calendar-alt',
			'menu_position'=> 6,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'show_in_rest' => true,
		)
	);

	// Job openings shown on the Careers page.
	register_post_type(
		'cihs_career',
		array(
			'labels'       => array(
				'name'          => __( 'Job Openings', 'cihs' ),
				'singular_name' => __( 'Job Opening', 'cihs' ),
				'add_new_item'  => __( 'Add New Job Opening', 'cihs' ),
				'edit_item'     => __( 'Edit Job Opening', 'cihs' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'openings' ),
			'menu_icon'    => 'dashicons-businessperson',
			'menu_position'=> 8,
			'supports'     => array( 'title', 'editor', 'excerpt' ),
			'show_in_rest' => true,
		)
	);

	// Impact gallery items (image + short caption) shown on the homepage.
	register_post_type(
		'cihs_impact',
		array(
			'labels'       => array(
				'name'          => __( 'Impact Gallery', 'cihs' ),
				'singular_name' => __( 'Impact Item', 'cihs' ),
				'add_new_item'  => __( 'Add New Impact Item', 'cihs' ),
				'edit_item'     => __( 'Edit Impact Item', 'cihs' ),
				'featured_image'=> __( 'Impact Image', 'cihs' ),
			),
			'public'             => true,
			'publicly_queryable' => false,
			'exclude_from_search'=> true,
			'has_archive'        => false,
			'menu_icon'          => 'dashicons-format-gallery',
			'menu_position'      => 9,
			'supports'           => array( 'title', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest'       => true,
		)
	);

	// Team members.
	register_post_type(
		'cihs_team',
		array(
			'labels'       => array(
				'name'          => __( 'Team', 'cihs' ),
				'singular_name' => __( 'Team Member', 'cihs' ),
				'add_new_item'  => __( 'Add New Team Member', 'cihs' ),
				'edit_item'     => __( 'Edit Team Member', 'cihs' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'team' ),
			'menu_icon'    => 'dashicons-groups',
			'menu_position'=> 7,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'cihs_register_post_types' );

/**
 * Event meta boxes (date, time, venue, registration link).
 */
function cihs_event_meta_box() {
	add_meta_box( 'cihs_event_details', __( 'Event Details', 'cihs' ), 'cihs_event_meta_box_html', 'cihs_event', 'side' );
	add_meta_box( 'cihs_team_details', __( 'Member Details', 'cihs' ), 'cihs_team_meta_box_html', 'cihs_team', 'side' );
	add_meta_box( 'cihs_career_details', __( 'Opening Details', 'cihs' ), 'cihs_career_meta_box_html', 'cihs_career', 'side' );
}
add_action( 'add_meta_boxes', 'cihs_event_meta_box' );

function cihs_event_meta_box_html( $post ) {
	wp_nonce_field( 'cihs_meta_save', 'cihs_meta_nonce' );
	$date  = get_post_meta( $post->ID, '_cihs_event_date', true );
	$time  = get_post_meta( $post->ID, '_cihs_event_time', true );
	$venue = get_post_meta( $post->ID, '_cihs_event_venue', true );
	$link  = get_post_meta( $post->ID, '_cihs_event_link', true );
	?>
	<p><label for="cihs_event_date"><strong><?php esc_html_e( 'Date', 'cihs' ); ?></strong></label>
	<input type="date" id="cihs_event_date" name="cihs_event_date" value="<?php echo esc_attr( $date ); ?>" style="width:100%"></p>
	<p><label for="cihs_event_time"><strong><?php esc_html_e( 'Time', 'cihs' ); ?></strong></label>
	<input type="text" id="cihs_event_time" name="cihs_event_time" value="<?php echo esc_attr( $time ); ?>" style="width:100%" placeholder="10:00 AM – 1:00 PM"></p>
	<p><label for="cihs_event_venue"><strong><?php esc_html_e( 'Venue', 'cihs' ); ?></strong></label>
	<input type="text" id="cihs_event_venue" name="cihs_event_venue" value="<?php echo esc_attr( $venue ); ?>" style="width:100%" placeholder="Vigyan Bhawan, New Delhi"></p>
	<p><label for="cihs_event_link"><strong><?php esc_html_e( 'Registration Link', 'cihs' ); ?></strong></label>
	<input type="url" id="cihs_event_link" name="cihs_event_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%"></p>
	<?php
}

function cihs_team_meta_box_html( $post ) {
	wp_nonce_field( 'cihs_meta_save', 'cihs_meta_nonce' );
	$role = get_post_meta( $post->ID, '_cihs_team_role', true );
	?>
	<p><label for="cihs_team_role"><strong><?php esc_html_e( 'Role / Designation', 'cihs' ); ?></strong></label>
	<input type="text" id="cihs_team_role" name="cihs_team_role" value="<?php echo esc_attr( $role ); ?>" style="width:100%" placeholder="Senior Research Fellow"></p>
	<?php
}

function cihs_career_meta_box_html( $post ) {
	wp_nonce_field( 'cihs_meta_save', 'cihs_meta_nonce' );
	$location = get_post_meta( $post->ID, '_cihs_career_location', true );
	$type     = get_post_meta( $post->ID, '_cihs_career_type', true );
	$deadline = get_post_meta( $post->ID, '_cihs_career_deadline', true );
	?>
	<p><label for="cihs_career_location"><strong><?php esc_html_e( 'Location', 'cihs' ); ?></strong></label>
	<input type="text" id="cihs_career_location" name="cihs_career_location" value="<?php echo esc_attr( $location ); ?>" style="width:100%" placeholder="Noida / New Delhi"></p>
	<p><label for="cihs_career_type"><strong><?php esc_html_e( 'Engagement Type', 'cihs' ); ?></strong></label>
	<select id="cihs_career_type" name="cihs_career_type" style="width:100%">
		<?php foreach ( array( 'Full-time', 'Part-time', 'Internship', 'Fellowship', 'Volunteer' ) as $opt ) : ?>
			<option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $type, $opt ); ?>><?php echo esc_html( $opt ); ?></option>
		<?php endforeach; ?>
	</select></p>
	<p><label for="cihs_career_deadline"><strong><?php esc_html_e( 'Application Deadline', 'cihs' ); ?></strong></label>
	<input type="date" id="cihs_career_deadline" name="cihs_career_deadline" value="<?php echo esc_attr( $deadline ); ?>" style="width:100%"></p>
	<?php
}

function cihs_save_meta( $post_id ) {
	if ( ! isset( $_POST['cihs_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['cihs_meta_nonce'] ), 'cihs_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$fields = array(
		'cihs_event_date'  => '_cihs_event_date',
		'cihs_event_time'  => '_cihs_event_time',
		'cihs_event_venue' => '_cihs_event_venue',
		'cihs_event_link'      => '_cihs_event_link',
		'cihs_team_role'       => '_cihs_team_role',
		'cihs_career_location' => '_cihs_career_location',
		'cihs_career_type'     => '_cihs_career_type',
		'cihs_career_deadline' => '_cihs_career_deadline',
	);
	foreach ( $fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post', 'cihs_save_meta' );

/* --------------------------------------------------------------------------
 * Includes
 * ------------------------------------------------------------------------ */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/block-patterns.php';
require get_template_directory() . '/inc/contact-form.php';
require get_template_directory() . '/inc/careers-donations.php';
require get_template_directory() . '/inc/setup-content.php';

/* --------------------------------------------------------------------------
 * SEO: meta description, Open Graph, JSON-LD organization schema
 * ------------------------------------------------------------------------ */
function cihs_seo_head() {
	$description = get_bloginfo( 'description' );
	if ( is_singular() ) {
		$post_obj = get_queried_object();
		if ( $post_obj && ! empty( $post_obj->post_excerpt ) ) {
			$description = wp_strip_all_tags( $post_obj->post_excerpt );
		} elseif ( $post_obj ) {
			$description = wp_trim_words( wp_strip_all_tags( $post_obj->post_content ), 30 );
		}
	}
	$description = esc_attr( wp_trim_words( $description, 32 ) );

	echo '<meta name="description" content="' . $description . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . $description . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '">' . "\n";
	if ( is_singular() && has_post_thumbnail() ) {
		echo '<meta property="og:image" content="' . esc_url( get_the_post_thumbnail_url( null, 'large' ) ) . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	if ( is_front_page() ) {
		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Organization',
			'name'        => get_bloginfo( 'name' ),
			'url'         => home_url( '/' ),
			'description' => get_bloginfo( 'description' ),
			'address'     => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => get_theme_mod( 'cihs_address', '903, Ground Floor, Sector 29' ),
				'addressLocality' => get_theme_mod( 'cihs_city', 'Noida' ),
				'postalCode'      => get_theme_mod( 'cihs_postcode', '201301' ),
				'addressCountry'  => 'IN',
			),
			'telephone'   => get_theme_mod( 'cihs_phone', '011-46698734' ),
			'email'       => get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ),
		);
		$socials = array_filter(
			array(
				get_theme_mod( 'cihs_social_twitter', 'https://x.com/cihs_india' ),
				get_theme_mod( 'cihs_social_facebook', 'https://www.facebook.com/CIHSofficial/' ),
				get_theme_mod( 'cihs_social_youtube', 'https://www.youtube.com/@CIHS_India' ),
				get_theme_mod( 'cihs_social_linkedin', 'https://in.linkedin.com/company/centre-for-integrated-and-holistic-studies' ),
			)
		);
		if ( $socials ) {
			$schema['sameAs'] = array_values( $socials );
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'cihs_seo_head', 5 );

/* --------------------------------------------------------------------------
 * Misc quality-of-life
 * ------------------------------------------------------------------------ */
function cihs_excerpt_length( $length ) {
	return 26;
}
add_filter( 'excerpt_length', 'cihs_excerpt_length' );

function cihs_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cihs_excerpt_more' );

function cihs_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'cihs_body_classes' );

/**
 * Show publications and events in main archives ordering; events sorted by date meta on archive.
 */
function cihs_event_archive_order( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'cihs_event' ) ) {
		$query->set( 'meta_key', '_cihs_event_date' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'cihs_event_archive_order' );
