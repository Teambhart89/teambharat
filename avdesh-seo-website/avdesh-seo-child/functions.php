<?php
/**
 * Avdesh SEO Child theme functions.
 *
 * Add your own custom PHP below the enqueue function. Because this is a child
 * theme, your changes here are kept safe when the parent theme is updated.
 *
 * @package Avdesh_SEO_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the parent theme stylesheet, then the child stylesheet.
 */
function avseo_child_enqueue() {
	$parent = 'avseo-main'; // Parent theme's main stylesheet handle.

	wp_enqueue_style(
		'avseo-child-style',
		get_stylesheet_uri(),
		array( $parent ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'avseo_child_enqueue', 20 );

/*
 * Example customisations you can uncomment and edit:
 *
 * // Change the number of blog posts per page.
 * add_action( 'pre_get_posts', function ( $q ) {
 *     if ( ! is_admin() && $q->is_main_query() && $q->is_home() ) {
 *         $q->set( 'posts_per_page', 9 );
 *     }
 * } );
 */
