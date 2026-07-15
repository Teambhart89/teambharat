<?php
/**
 * Structured data (JSON-LD): Organization/ProfessionalService, Service,
 * BreadcrumbList and FAQPage. Helps rich results and AI search visibility.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ktn_output_schema() {
	$graph = array();

	// Organization / ProfessionalService (site wide).
	$org = array(
		'@type'       => array( 'Organization', 'ProfessionalService' ),
		'@id'         => home_url( '/#organization' ),
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
		'areaServed'  => 'IN',
	);
	$phone   = ktn_get_option( 'phone' );
	$email   = ktn_get_option( 'email' );
	$address = ktn_get_option( 'address' );
	if ( $phone ) {
		$org['telephone'] = $phone;
	}
	if ( $email ) {
		$org['email'] = $email;
	}
	if ( $address ) {
		$org['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => 'New Delhi',
			'addressCountry'  => 'IN',
		);
	}
	$socials = array_filter(
		array(
			ktn_get_option( 'facebook' ),
			ktn_get_option( 'instagram' ),
			ktn_get_option( 'linkedin' ),
			ktn_get_option( 'twitter' ),
			ktn_get_option( 'youtube' ),
		)
	);
	if ( $socials ) {
		$org['sameAs'] = array_values( $socials );
	}
	$graph[] = $org;

	// WebSite with sitelinks search box.
	$graph[] = array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'url'             => home_url( '/' ),
		'name'            => get_bloginfo( 'name' ),
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	if ( is_singular( 'service' ) ) {
		$post_id = get_queried_object_id();

		// Service schema.
		$service_schema = array(
			'@type'       => 'Service',
			'name'        => get_the_title( $post_id ),
			'url'         => get_permalink( $post_id ),
			'description' => get_post_meta( $post_id, '_ktn_meta_description', true ),
			'provider'    => array( '@id' => home_url( '/#organization' ) ),
			'areaServed'  => 'IN',
			'serviceType' => get_the_title( $post_id ),
		);
		$terms = get_the_terms( $post_id, 'service_category' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$service_schema['category'] = $terms[0]->name;
		}
		$graph[] = $service_schema;

		// BreadcrumbList.
		$crumbs = array(
			array( 'name' => 'Home', 'item' => home_url( '/' ) ),
		);
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term_link = get_term_link( $terms[0] );
			if ( ! is_wp_error( $term_link ) ) {
				$crumbs[] = array( 'name' => $terms[0]->name, 'item' => $term_link );
			}
		}
		$crumbs[]   = array( 'name' => get_the_title( $post_id ), 'item' => get_permalink( $post_id ) );
		$positions  = array();
		foreach ( $crumbs as $index => $crumb ) {
			$positions[] = array(
				'@type'    => 'ListItem',
				'position' => $index + 1,
				'name'     => $crumb['name'],
				'item'     => $crumb['item'],
			);
		}
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $positions,
		);

		// FAQPage.
		$faqs = ktn_get_service_faqs( $post_id );
		if ( $faqs ) {
			$faq_items = array();
			foreach ( $faqs as $faq ) {
				$faq_items[] = array(
					'@type'          => 'Question',
					'name'           => $faq['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $faq['a'] ),
					),
				);
			}
			$graph[] = array(
				'@type'      => 'FAQPage',
				'mainEntity' => $faq_items,
			);
		}
	}

	// Front page FAQ schema comes from the theme's home FAQ option.
	if ( is_front_page() ) {
		$home_faqs = get_option( 'ktn_home_faqs', array() );
		if ( is_array( $home_faqs ) && $home_faqs ) {
			$faq_items = array();
			foreach ( $home_faqs as $faq ) {
				if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
					continue;
				}
				$faq_items[] = array(
					'@type'          => 'Question',
					'name'           => $faq['q'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $faq['a'] ),
					),
				);
			}
			if ( $faq_items ) {
				$graph[] = array(
					'@type'      => 'FAQPage',
					'mainEntity' => $faq_items,
				);
			}
		}
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ktn_output_schema', 20 );
