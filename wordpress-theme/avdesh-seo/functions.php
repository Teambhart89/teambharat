<?php
/**
 * Avdesh SEO — theme functions
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AVDESH_VER', '1.0.0' );
define( 'AVDESH_DIR', get_template_directory() );
define( 'AVDESH_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 *  Theme setup
 * ---------------------------------------------------------------------- */
function avdesh_setup() {
	load_theme_textdomain( 'avdesh-seo', AVDESH_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'avdesh-seo' ),
			'footer'  => __( 'Footer Menu', 'avdesh-seo' ),
		)
	);
}
add_action( 'after_setup_theme', 'avdesh_setup' );

function avdesh_content_width() {
	$GLOBALS['content_width'] = 1180;
}
add_action( 'after_setup_theme', 'avdesh_content_width', 0 );

/* -------------------------------------------------------------------------
 *  Assets
 * ---------------------------------------------------------------------- */
function avdesh_assets() {
	// Google Fonts: Poppins (UI) + Caveat (script accent) — matches the portfolio.
	wp_enqueue_style(
		'avdesh-fonts',
		'https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'avdesh-main', AVDESH_URI . '/assets/css/main.css', array(), AVDESH_VER );
	// style.css (theme header + base fallbacks).
	wp_enqueue_style( 'avdesh-style', get_stylesheet_uri(), array( 'avdesh-main' ), AVDESH_VER );

	wp_enqueue_script( 'avdesh-main', AVDESH_URI . '/assets/js/main.js', array(), AVDESH_VER, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'avdesh_assets' );

/* -------------------------------------------------------------------------
 *  Includes
 * ---------------------------------------------------------------------- */
require AVDESH_DIR . '/inc/customizer.php';
require AVDESH_DIR . '/inc/services-data.php';
require AVDESH_DIR . '/inc/template-helpers.php';
require AVDESH_DIR . '/inc/seo-schema.php';
require AVDESH_DIR . '/inc/setup-pages.php';

/* -------------------------------------------------------------------------
 *  Fallback primary menu (used until a menu is assigned)
 * ---------------------------------------------------------------------- */
function avdesh_fallback_menu() {
	$items = array(
		home_url( '/' )                       => __( 'Home', 'avdesh-seo' ),
		home_url( '/about/' )                 => __( 'About', 'avdesh-seo' ),
		home_url( '/seo-services/' )          => __( 'Services', 'avdesh-seo' ),
		home_url( '/ai-search-optimization/' )=> __( 'AI Search', 'avdesh-seo' ),
		home_url( '/portfolio/' )             => __( 'Portfolio', 'avdesh-seo' ),
		home_url( '/contact/' )               => __( 'Contact', 'avdesh-seo' ),
	);
	echo '<ul id="primary-menu" class="nav">';
	foreach ( $items as $url => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/* -------------------------------------------------------------------------
 *  Small utilities
 * ---------------------------------------------------------------------- */

/** Get a theme option (Customizer mod) with default. */
function avdesh_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Render an image area that the user can populate from the Customizer.
 * If no image is set, a clearly marked "upload here" placeholder is shown.
 *
 * @param string $mod_key   Customizer setting key holding an attachment URL.
 * @param string $label     Placeholder helper text.
 * @param string $classes   Extra classes on the wrapper.
 * @param string $alt       Image alt text (SEO).
 */
function avdesh_image_area( $mod_key, $label = 'Upload / replace image', $classes = '', $alt = '' ) {
	$url = avdesh_opt( $mod_key, '' );
	echo '<div class="img-ph ' . esc_attr( $classes ) . '">';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $url ), esc_attr( $alt ) );
	} else {
		echo '<span class="badge">📷 ' . esc_html( $label ) . '</span>';
	}
	echo '</div>';
}

/** Excerpt limiter. */
function avdesh_trim( $text, $words = 26 ) {
	return wp_trim_words( wp_strip_all_tags( $text ), $words, '…' );
}
