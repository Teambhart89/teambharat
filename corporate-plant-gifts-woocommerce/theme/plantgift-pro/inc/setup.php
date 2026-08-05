<?php
/**
 * Theme setup, menus, sidebars and image sizes.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports.
 */
function plantgift_pro_setup() {
	load_theme_textdomain( 'plantgift-pro', PLANTGIFT_PRO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// WooCommerce.
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 480,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_rows'    => 4,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary'  => __( 'Primary Menu', 'plantgift-pro' ),
			'shop'     => __( 'Shop Categories Menu', 'plantgift-pro' ),
			'footer_1' => __( 'Footer Column One', 'plantgift-pro' ),
			'footer_2' => __( 'Footer Column Two', 'plantgift-pro' ),
			'footer_3' => __( 'Footer Column Three', 'plantgift-pro' ),
			'legal'    => __( 'Legal Menu', 'plantgift-pro' ),
		)
	);

	add_image_size( 'plantgift-card', 640, 640, true );
	add_image_size( 'plantgift-wide', 1280, 720, true );
}
add_action( 'after_setup_theme', 'plantgift_pro_setup' );

/**
 * Content width for embeds.
 */
function plantgift_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'plantgift_pro_content_width', 780 );
}
add_action( 'after_setup_theme', 'plantgift_pro_content_width', 0 );

/**
 * Widget areas.
 */
function plantgift_pro_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'plantgift-pro' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'Shown beside blog posts and archives.', 'plantgift-pro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Shop Sidebar', 'plantgift-pro' ),
			'id'            => 'sidebar-shop',
			'description'   => __( 'Filters and navigation shown on shop and category pages.', 'plantgift-pro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Notice', 'plantgift-pro' ),
			'id'            => 'footer-notice',
			'description'   => __( 'A short block above the footer columns.', 'plantgift-pro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'plantgift_pro_widgets_init' );

/**
 * Add useful classes to the body tag.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function plantgift_pro_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
		$classes[] = 'pg-shop-context';
	}
	if ( is_page_template( 'page-templates/template-service.php' ) ) {
		$classes[] = 'pg-service-page';
	}
	return $classes;
}
add_filter( 'body_class', 'plantgift_pro_body_classes' );

/**
 * Give the excerpt a readable length and a natural ending.
 *
 * @return int
 */
function plantgift_pro_excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', 'plantgift_pro_excerpt_length' );

/**
 * Replace the default excerpt ellipsis.
 *
 * @return string
 */
function plantgift_pro_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'plantgift_pro_excerpt_more' );
