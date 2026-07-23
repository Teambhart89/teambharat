<?php
/**
 * Avdesh SEO theme functions and definitions.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'AVSEO_VERSION', '1.5.0' );

/**
 * Theme setup.
 */
function avseo_setup() {
	load_theme_textdomain( 'avdesh-seo', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'avdesh-seo' ),
		'footer'  => __( 'Footer Menu', 'avdesh-seo' ),
	) );
}
add_action( 'after_setup_theme', 'avseo_setup' );

/**
 * Enqueue styles and scripts.
 */
function avseo_assets() {
	// Google Fonts: Poppins (matches the reference design weights).
	wp_enqueue_style(
		'avseo-fonts',
		'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'avseo-style', get_stylesheet_uri(), array(), AVSEO_VERSION );
	wp_enqueue_style( 'avseo-main', get_template_directory_uri() . '/assets/css/main.css', array( 'avseo-style' ), AVSEO_VERSION );

	wp_enqueue_script( 'avseo-main', get_template_directory_uri() . '/assets/js/main.js', array(), AVSEO_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'avseo_assets' );

/**
 * Register a widget area for the footer.
 */
function avseo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Extra', 'avdesh-seo' ),
		'id'            => 'footer-extra',
		'description'   => __( 'Optional widgets shown in the footer.', 'avdesh-seo' ),
		'before_widget' => '<div class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'avseo_widgets_init' );

/**
 * Load helper modules.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/content.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/schema.php';
require get_template_directory() . '/inc/activation.php';

/**
 * Fallback menu when no primary menu is assigned.
 */
function avseo_fallback_menu() {
	echo '<ul id="primary-menu" class="nav-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">About</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/services/' ) ) . '">Services</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/case-studies/' ) ) . '">Case Studies</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a></li>';
	echo '</ul>';
}

/**
 * Trim default excerpt length for cleaner cards.
 */
function avseo_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'avseo_excerpt_length' );

/**
 * Add a "…" more string.
 */
function avseo_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'avseo_excerpt_more' );
