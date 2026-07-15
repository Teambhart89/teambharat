<?php
/**
 * Lightweight SEO output: title tag, meta description, canonical, Open Graph.
 * Steps aside automatically when Yoast SEO or Rank Math is active.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ktn_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' );
}

/**
 * Custom document title.
 */
function ktn_document_title( $title ) {
	if ( ktn_seo_plugin_active() ) {
		return $title;
	}
	if ( is_singular() ) {
		$meta_title = get_post_meta( get_queried_object_id(), '_ktn_meta_title', true );
		if ( $meta_title ) {
			$title['title'] = $meta_title;
			unset( $title['site'] );
		}
	}
	return $title;
}
add_filter( 'document_title_parts', 'ktn_document_title' );

/**
 * Meta description, canonical and Open Graph tags.
 */
function ktn_seo_head() {
	if ( ktn_seo_plugin_active() ) {
		return;
	}

	$description = '';
	$url         = '';

	if ( is_front_page() ) {
		$description = get_bloginfo( 'description' );
		$url         = home_url( '/' );
	} elseif ( is_singular() ) {
		$post_id     = get_queried_object_id();
		$description = get_post_meta( $post_id, '_ktn_meta_description', true );
		if ( ! $description ) {
			$description = wp_strip_all_tags( get_the_excerpt( $post_id ) );
		}
		$url = get_permalink( $post_id );
	} elseif ( is_tax( 'service_category' ) ) {
		$term        = get_queried_object();
		$description = wp_strip_all_tags( term_description( $term ) );
		$description = wp_trim_words( $description, 26, '' );
		$url         = get_term_link( $term );
	}

	$description = trim( (string) $description );
	if ( strlen( $description ) > 165 ) {
		$description = substr( $description, 0, 162 ) . '...';
	}

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $url && ! is_wp_error( $url ) ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	}
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_front_page() ? 'website' : 'article' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	if ( is_singular() && has_post_thumbnail() ) {
		$img = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
		if ( $img ) {
			printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $img ) );
		}
	}
}
add_action( 'wp_head', 'ktn_seo_head', 1 );
