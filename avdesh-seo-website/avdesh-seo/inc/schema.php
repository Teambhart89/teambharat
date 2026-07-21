<?php
/**
 * Structured data (schema.org JSON-LD) and meta tags.
 *
 * Structured data helps search engines and generative AI answer engines
 * (Google AI Overviews, ChatGPT, Gemini, Perplexity) understand who this
 * site is about and what services are offered. This directly supports
 * GEO (Generative Engine Optimization) and AEO (Answer Engine Optimization).
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output Open Graph + Twitter meta and a meta description in the head.
 */
function avseo_head_meta() {
	$desc = '';
	if ( is_singular() ) {
		$desc = get_the_excerpt();
	}
	if ( ! $desc ) {
		$desc = get_bloginfo( 'description' );
	}
	$desc = wp_strip_all_tags( $desc );
	$desc = mb_substr( $desc, 0, 160 );

	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$img   = avseo_opt( 'img_profile', '' );
	if ( ! $img ) {
		$img = avseo_opt( 'img_hero', '' );
	}

	echo "\n<!-- Avdesh SEO meta -->\n";
	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	if ( $img ) {
		echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	if ( $img ) {
		echo '<meta name="twitter:image" content="' . esc_url( $img ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'avseo_head_meta', 5 );

/**
 * Person + ProfessionalService schema on every page.
 */
function avseo_person_schema() {
	$name     = avseo_info( 'name' );
	$role     = avseo_info( 'role' );
	$location = avseo_info( 'location' );
	$email    = avseo_info( 'email' );
	$phone    = avseo_info( 'phone' );
	$linkedin = avseo_info( 'linkedin' );

	$same_as = array();
	if ( $linkedin && '#' !== $linkedin ) {
		$same_as[] = $linkedin;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'ProfessionalService',
		'name'     => $name . ' - ' . $role,
		'description' => 'SEO, AI Search Optimization (GEO) and Google Ads services that grow organic traffic, improve rankings and deliver measurable ROI.',
		'url'      => home_url( '/' ),
		'areaServed' => array( 'India', 'United Arab Emirates', 'United Kingdom', 'United States', 'Australia' ),
		'knowsAbout' => array( 'Search Engine Optimization', 'Technical SEO', 'On-Page SEO', 'Off-Page SEO', 'Local SEO', 'eCommerce SEO', 'AI Search Optimization', 'Generative Engine Optimization', 'Google Ads', 'Keyword Research' ),
		'provider' => array(
			'@type'    => 'Person',
			'name'     => $name,
			'jobTitle' => $role,
			'email'    => $email,
			'telephone'=> $phone,
			'address'  => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => $location,
			),
		),
	);
	if ( ! empty( $same_as ) ) {
		$schema['provider']['sameAs'] = $same_as;
	}

	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'avseo_person_schema', 20 );

/**
 * Breadcrumb + Service schema on service pages.
 */
function avseo_page_schema() {
	if ( ! is_page() ) {
		return;
	}
	$crumbs = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => home_url( '/' ),
		),
	);
	$post = get_post();
	$pos  = 2;
	if ( $post && $post->post_parent ) {
		$parent   = get_post( $post->post_parent );
		$crumbs[] = array(
			'@type'    => 'ListItem',
			'position' => $pos,
			'name'     => get_the_title( $parent ),
			'item'     => get_permalink( $parent ),
		);
		$pos++;
	}
	$crumbs[] = array(
		'@type'    => 'ListItem',
		'position' => $pos,
		'name'     => get_the_title(),
		'item'     => get_permalink(),
	);

	$bc = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $crumbs,
	);
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $bc, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'avseo_page_schema', 21 );

/**
 * FAQ schema, built from questions registered by avseo_faq_block().
 * Printed in the footer once the page content has run.
 */
function avseo_faq_schema() {
	global $avseo_faq_store;
	if ( empty( $avseo_faq_store ) || ! is_array( $avseo_faq_store ) ) {
		return;
	}
	$items = array();
	foreach ( $avseo_faq_store as $f ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $f['q'] ),
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $f['a'] ),
			),
		);
	}
	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $items,
	);
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_footer', 'avseo_faq_schema', 30 );
