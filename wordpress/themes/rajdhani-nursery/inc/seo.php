<?php
/**
 * SEO features: meta descriptions, Open Graph tags and JSON-LD schema
 * (LocalBusiness, Service and FAQPage) for classic and AI powered search.
 *
 * @package Rajdhani_Nursery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta description for the current page.
 * Pages seeded by the theme carry a hand written description in post meta.
 */
function rn_get_meta_description() {
	if ( is_front_page() ) {
		return 'Book maali online in Delhi with Rajdhani Nursery. Mali on rent for 1 hour to full day, verified gardeners, weekly and monthly plans from Rs 1,499. Serving all Delhi NCR.';
	}
	if ( is_singular() ) {
		$custom = get_post_meta( get_the_ID(), '_rn_meta_description', true );
		if ( $custom ) {
			return $custom;
		}
		$excerpt = wp_strip_all_tags( get_the_excerpt() );
		return wp_trim_words( $excerpt, 28, '' );
	}
	return get_bloginfo( 'description' );
}

/**
 * Print meta description, Open Graph and canonical tags.
 */
function rn_print_meta_tags() {
	$description = esc_attr( rn_get_meta_description() );
	$title       = esc_attr( wp_get_document_title() );
	$url         = esc_url( is_singular() ? get_permalink() : home_url( add_query_arg( array() ) ) );

	echo '<meta name="description" content="' . $description . '">' . "\n";
	echo '<meta property="og:title" content="' . $title . '">' . "\n";
	echo '<meta property="og:description" content="' . $description . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:url" content="' . $url . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:locale" content="en_IN">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="theme-color" content="#1b7a3d">' . "\n";
}
add_action( 'wp_head', 'rn_print_meta_tags', 1 );

/**
 * LocalBusiness schema, printed on every page.
 */
function rn_local_business_schema() {
	$schema = array(
		'@context'          => 'https://schema.org',
		'@type'             => 'LocalBusiness',
		'@id'               => home_url( '/#business' ),
		'name'              => 'Rajdhani Nursery',
		'description'       => 'Plant nursery in Delhi providing mali on rent, gardener on rent and online maali booking services across Delhi NCR. Hourly bookings and weekly or monthly garden care plans.',
		'url'               => home_url( '/' ),
		'telephone'         => rn_get_option( 'phone' ),
		'email'             => rn_get_option( 'email' ),
		'priceRange'        => '₹₹',
		'image'             => home_url( '/' ),
		'address'           => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => rn_get_option( 'address' ),
			'addressLocality' => 'New Delhi',
			'addressRegion'   => 'Delhi',
			'postalCode'      => '110001',
			'addressCountry'  => 'IN',
		),
		'geo'               => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => '28.6139',
			'longitude' => '77.2090',
		),
		'openingHoursSpecification' => array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
			'opens'     => '07:00',
			'closes'    => '19:00',
		),
		'areaServed'        => array_map(
			function ( $area ) {
				return array( '@type' => 'Place', 'name' => $area );
			},
			rn_get_areas()
		),
		'makesOffer'        => array_map(
			function ( $plan ) {
				return array(
					'@type'       => 'Offer',
					'name'        => $plan['name'],
					'description' => $plan['visits'] . ', ' . $plan['duration'],
					'price'       => str_replace( ',', '', $plan['price'] ),
					'priceCurrency' => 'INR',
				);
			},
			rn_get_plans()
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rn_local_business_schema', 5 );

/**
 * FAQPage schema on the front page and the FAQs page.
 */
function rn_faq_schema() {
	if ( ! is_front_page() && ! is_page( 'faqs' ) ) {
		return;
	}

	$items = array();
	foreach ( rn_get_faqs() as $faq ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $items,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rn_faq_schema', 6 );

/**
 * Service schema on seeded service pages.
 */
function rn_service_schema() {
	if ( ! is_page() ) {
		return;
	}
	$service_name = get_post_meta( get_the_ID(), '_rn_service_schema_name', true );
	if ( ! $service_name ) {
		return;
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'name'        => $service_name,
		'description' => rn_get_meta_description(),
		'url'         => get_permalink(),
		'provider'    => array( '@id' => home_url( '/#business' ) ),
		'areaServed'  => array( '@type' => 'City', 'name' => 'Delhi' ),
		'serviceType' => 'Gardening Service',
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rn_service_schema', 7 );

/**
 * BreadcrumbList schema on inner pages.
 */
function rn_breadcrumb_schema() {
	if ( ! is_page() || is_front_page() ) {
		return;
	}
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'Home',
				'item'     => home_url( '/' ),
			),
			array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			),
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'rn_breadcrumb_schema', 8 );
