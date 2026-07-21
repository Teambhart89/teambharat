<?php
/**
 * SEO: meta tags, Open Graph, Twitter cards and Schema.org JSON-LD.
 *
 * Lightweight and self-contained so the theme is AI-search ready out of the box.
 * If you install a dedicated SEO plugin (Yoast, Rank Math), you can disable this
 * block by defining AVDESH_DISABLE_SEO in wp-config.php to avoid duplicate tags.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Current page slug helper. */
function avdesh_current_slug() {
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			return $post->post_name;
		}
	}
	return '';
}

/** Use service meta titles where available. */
function avdesh_document_title( $title ) {
	if ( defined( 'AVDESH_DISABLE_SEO' ) ) {
		return $title;
	}
	$s = avdesh_get_service( avdesh_current_slug() );
	if ( $s && ! empty( $s['meta_title'] ) ) {
		return $s['meta_title'];
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'avdesh_document_title', 20 );

/** Resolved meta description for the current view. */
function avdesh_meta_description() {
	$s = avdesh_get_service( avdesh_current_slug() );
	if ( $s && ! empty( $s['meta_desc'] ) ) {
		return $s['meta_desc'];
	}
	if ( is_front_page() ) {
		return 'Avdesh Kumar is an SEO and AI Search Optimization Specialist in Delhi, India, with 8 years of experience driving organic traffic, higher rankings and real ROI through white-hat SEO, GEO and Google Ads.';
	}
	if ( is_singular() ) {
		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			return wp_strip_all_tags( $excerpt );
		}
	}
	$desc = get_bloginfo( 'description' );
	return $desc ? $desc : 'SEO and AI Search Optimization Specialist based in Delhi, India.';
}

/** Print meta, Open Graph and Twitter tags. */
function avdesh_head_meta() {
	if ( defined( 'AVDESH_DISABLE_SEO' ) ) {
		return;
	}
	$desc  = avdesh_meta_description();
	$title = wp_get_document_title();
	$url   = ( is_front_page() ) ? home_url( '/' ) : get_permalink();
	$og    = avdesh_opt( 'avdesh_img_og', '' );
	if ( ! $og && has_post_thumbnail() ) {
		$og = get_the_post_thumbnail_url( null, 'large' );
	}
	echo "\n<!-- Avdesh SEO meta -->\n";
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );

	// Open Graph.
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular() ? 'article' : 'website' );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	if ( $og ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $og ) );
	}
	// Twitter.
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $desc ) );
	if ( $og ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $og ) );
	}
}
add_action( 'wp_head', 'avdesh_head_meta', 1 );

/** Print JSON-LD structured data. */
function avdesh_schema() {
	if ( defined( 'AVDESH_DISABLE_SEO' ) ) {
		return;
	}
	$site   = get_bloginfo( 'name' );
	$home   = home_url( '/' );
	$email  = avdesh_opt( 'avdesh_email', '' );
	$phone  = avdesh_opt( 'avdesh_phone', '' );
	$loc    = avdesh_opt( 'avdesh_location', 'Delhi, India' );
	$img    = avdesh_opt( 'avdesh_img_hero', '' );
	$socials = array_filter(
		array(
			avdesh_opt( 'avdesh_linkedin', '' ),
			avdesh_opt( 'avdesh_instagram', '' ),
			avdesh_opt( 'avdesh_facebook', '' ),
			avdesh_opt( 'avdesh_twitter', '' ),
			avdesh_opt( 'avdesh_youtube', '' ),
		)
	);

	$graph = array();

	// Person entity (great for AI knowledge graph).
	$person = array(
		'@type'       => 'Person',
		'@id'         => $home . '#person',
		'name'        => 'Avdesh Kumar',
		'jobTitle'    => 'SEO & AI Search Optimization Specialist',
		'description' => 'SEO, GEO and Google Ads specialist with 8 years of experience delivering organic traffic growth, higher rankings and measurable ROI.',
		'url'         => $home,
		'knowsAbout'  => array( 'Search Engine Optimization', 'Generative Engine Optimization', 'AI Search Optimization', 'Technical SEO', 'On-Page SEO', 'Link Building', 'Local SEO', 'Google Ads', 'Content Marketing' ),
		'address'     => array( '@type' => 'PostalAddress', 'addressLocality' => $loc, 'addressCountry' => 'IN' ),
	);
	if ( $img ) { $person['image'] = $img; }
	if ( $email ) { $person['email'] = $email; }
	if ( $phone ) { $person['telephone'] = $phone; }
	if ( $socials ) { $person['sameAs'] = array_values( $socials ); }
	$graph[] = $person;

	// Professional service / business.
	$graph[] = array(
		'@type'        => 'ProfessionalService',
		'@id'          => $home . '#business',
		'name'         => $site,
		'image'        => $img ? $img : '',
		'url'          => $home,
		'telephone'    => $phone,
		'email'        => $email,
		'priceRange'   => '$$',
		'areaServed'   => array( 'India', 'United Arab Emirates', 'United Kingdom', 'United States', 'Australia' ),
		'address'      => array( '@type' => 'PostalAddress', 'addressLocality' => $loc, 'addressCountry' => 'IN' ),
		'founder'      => array( '@id' => $home . '#person' ),
		'sameAs'       => array_values( $socials ),
	);

	// WebSite entity.
	$graph[] = array(
		'@type' => 'WebSite',
		'@id'   => $home . '#website',
		'url'   => $home,
		'name'  => $site,
		'publisher' => array( '@id' => $home . '#person' ),
	);

	// Per-service Service + FAQ schema.
	$s = avdesh_get_service( avdesh_current_slug() );
	if ( $s ) {
		$graph[] = array(
			'@type'       => 'Service',
			'name'        => $s['h1'],
			'serviceType' => $s['menu'],
			'description' => $s['meta_desc'],
			'provider'    => array( '@id' => $home . '#person' ),
			'areaServed'  => array( 'India', 'United Arab Emirates', 'United Kingdom', 'United States', 'Australia' ),
			'url'         => get_permalink(),
		);
		if ( ! empty( $s['faq'] ) ) {
			$faqs = array();
			foreach ( $s['faq'] as $f ) {
				$faqs[] = array(
					'@type'          => 'Question',
					'name'           => $f['q'],
					'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f['a'] ),
				);
			}
			$graph[] = array(
				'@type'      => 'FAQPage',
				'mainEntity' => $faqs,
			);
		}
	}

	$data = array( '@context' => 'https://schema.org', '@graph' => $graph );
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'avdesh_schema', 5 );
