<?php
/**
 * One-time setup that runs when the theme is activated.
 *
 * This makes the theme "ready to use" the moment it is switched on:
 * it creates every page with a clean SEO friendly URL, sets the homepage,
 * builds the navigation menu and turns on pretty permalinks.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The full page map. Slugs double as the SEO friendly URL and as the
 * template lookup (page-{slug}.php).
 */
function avseo_page_map() {
	return array(
		'home' => array(
			'title'  => 'Home',
			'parent' => '',
			'excerpt'=> 'SEO and AI Search Optimization Specialist in Delhi, India helping businesses grow organic traffic, improve rankings and generate qualified leads and sales.',
		),
		'about' => array(
			'title'  => 'About',
			'parent' => '',
			'excerpt'=> 'Meet Avdesh Kumar, an SEO, GEO and Google Ads specialist with 8 years of hands-on experience delivering measurable growth in competitive markets.',
		),
		'services' => array(
			'title'  => 'Services',
			'parent' => '',
			'excerpt'=> 'End to end SEO services: technical SEO, on-page SEO, link building, local SEO, eCommerce SEO, AI search optimization and Google Ads.',
		),
		'seo-services' => array(
			'title'  => 'SEO Services',
			'parent' => 'services',
			'excerpt'=> 'Result driven SEO services that grow organic traffic, improve keyword rankings and deliver real ROI using proven white hat methods.',
		),
		'technical-seo-services' => array(
			'title'  => 'Technical SEO',
			'parent' => 'services',
			'excerpt'=> 'Technical SEO services that fix crawlability, indexing, site speed and Core Web Vitals so search engines can rank your website with confidence.',
		),
		'on-page-seo-services' => array(
			'title'  => 'On-Page SEO',
			'parent' => 'services',
			'excerpt'=> 'On-page SEO services covering keyword mapping, content optimization, headings, internal links and metadata that help pages rank and convert.',
		),
		'off-page-seo-link-building' => array(
			'title'  => 'Off-Page SEO & Link Building',
			'parent' => 'services',
			'excerpt'=> 'White hat link building and off-page SEO that build authority, trust and rankings with high quality, relevant backlinks.',
		),
		'local-seo-services' => array(
			'title'  => 'Local SEO',
			'parent' => 'services',
			'excerpt'=> 'Local SEO services that grow your Google Business Profile, map pack rankings and local leads across your service area.',
		),
		'ecommerce-seo-services' => array(
			'title'  => 'eCommerce SEO',
			'parent' => 'services',
			'excerpt'=> 'eCommerce SEO for Shopify, WooCommerce and more that grows product and category rankings, qualified traffic and online sales.',
		),
		'ai-search-optimization' => array(
			'title'  => 'AI Search Optimization (GEO)',
			'parent' => 'services',
			'excerpt'=> 'Generative Engine Optimization that grows your visibility inside Google AI Overviews, ChatGPT, Gemini and Perplexity answers.',
		),
		'google-ads-management' => array(
			'title'  => 'Google Ads Management',
			'parent' => 'services',
			'excerpt'=> 'Google Ads management that lowers cost per lead and grows conversions with tightly targeted, high intent search campaigns.',
		),
		'case-studies' => array(
			'title'  => 'Case Studies',
			'parent' => '',
			'excerpt'=> 'Real SEO and AI search results: the brands, campaigns and metrics behind measurable growth in traffic, rankings and revenue.',
		),
		'contact' => array(
			'title'  => 'Contact',
			'parent' => '',
			'excerpt'=> 'Get in touch for a free SEO consultation. Let us build a strategy that brings qualified traffic, leads and sales to your business.',
		),
		'blog' => array(
			'title'  => 'Blog',
			'parent' => '',
			'excerpt'=> 'SEO, AI search and digital marketing insights, tips and guides.',
		),
	);
}

/**
 * Create pages, set homepage and blog, build the menu and enable pretty permalinks.
 */
function avseo_activate_setup() {
	$map = avseo_page_map();
	$ids = array();

	// First pass: create top level and standalone pages.
	foreach ( $map as $slug => $data ) {
		$ids[ $slug ] = avseo_ensure_page( $slug, $data['title'], $data['excerpt'] );
	}

	// Backfill editable content for any page that is still empty (handles
	// upgrades from an earlier version where pages were created blank).
	foreach ( $map as $slug => $data ) {
		if ( empty( $ids[ $slug ] ) ) {
			continue;
		}
		$existing_content = get_post_field( 'post_content', $ids[ $slug ] );
		if ( '' === trim( (string) $existing_content ) ) {
			$default = avseo_default_content( $slug );
			$update  = array( 'ID' => $ids[ $slug ] );
			if ( '' !== $default ) {
				$update['post_content'] = $default;
			}
			if ( '' === trim( (string) get_post_field( 'post_excerpt', $ids[ $slug ] ) ) && ! empty( $data['excerpt'] ) ) {
				$update['post_excerpt'] = $data['excerpt'];
			}
			if ( count( $update ) > 1 ) {
				wp_update_post( $update );
			}
		}
	}

	// Second pass: set parents for child pages.
	foreach ( $map as $slug => $data ) {
		if ( ! empty( $data['parent'] ) && isset( $ids[ $data['parent'] ] ) && $ids[ $slug ] ) {
			wp_update_post( array(
				'ID'          => $ids[ $slug ],
				'post_parent' => $ids[ $data['parent'] ],
			) );
		}
	}

	// Static front page + blog page.
	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}
	if ( ! empty( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}

	// SEO friendly permalinks: /%postname%/.
	if ( '/%postname%/' !== get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		update_option( 'permalink_structure', '/%postname%/' );
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$wp_rewrite->flush_rules();
	}

	// Seed the starter blog posts.
	avseo_create_sample_posts();

	// Build primary navigation menu.
	avseo_build_menu( $ids );
}
add_action( 'after_switch_theme', 'avseo_activate_setup' );

/**
 * Create the sample blog posts (once) under an "SEO Insights" category.
 */
function avseo_create_sample_posts() {
	if ( ! function_exists( 'avseo_default_posts' ) ) {
		return;
	}
	// Ensure a category exists.
	$cat_id = 0;
	$term   = term_exists( 'SEO Insights', 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( 'SEO Insights', 'category', array( 'slug' => 'seo-insights' ) );
	}
	if ( ! is_wp_error( $term ) && ! empty( $term['term_id'] ) ) {
		$cat_id = (int) $term['term_id'];
	}

	$offset = 0;
	foreach ( avseo_default_posts() as $post ) {
		// Skip if a post with this slug already exists.
		$existing = get_posts( array(
			'name'        => $post['slug'],
			'post_type'   => 'post',
			'post_status' => 'any',
			'numberposts' => 1,
			'fields'      => 'ids',
		) );
		if ( ! empty( $existing ) ) {
			continue;
		}
		$post_id = wp_insert_post( array(
			'post_title'   => $post['title'],
			'post_name'    => $post['slug'],
			'post_content' => $post['content'],
			'post_excerpt' => $post['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( "-{$offset} days" ) ),
		) );
		if ( $post_id && ! is_wp_error( $post_id ) && $cat_id ) {
			wp_set_post_categories( $post_id, array( $cat_id ) );
		}
		$offset += 5;
	}
}

/**
 * Create a page if one with the slug does not already exist.
 *
 * @return int Page ID.
 */
function avseo_ensure_page( $slug, $title, $excerpt = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}
	$id = wp_insert_post( array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_content' => avseo_default_content( $slug ),
		'post_excerpt' => $excerpt,
		'comment_status' => 'closed',
	) );
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Create the primary menu with a Services dropdown.
 */
function avseo_build_menu( $ids ) {
	$menu_name = 'Primary Navigation';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu->term_id;
		// Avoid duplicating items on re-activation.
		$items = wp_get_nav_menu_items( $menu_id );
		if ( $items ) {
			return;
		}
	}
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$order = array( 'home', 'about', 'services', 'case-studies', 'contact' );
	$parent_item_ids = array();

	foreach ( $order as $slug ) {
		if ( empty( $ids[ $slug ] ) ) {
			continue;
		}
		$item_id = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'     => get_the_title( $ids[ $slug ] ),
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $ids[ $slug ],
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		) );
		$parent_item_ids[ $slug ] = $item_id;
	}

	// Add service pages as children of the Services menu item.
	if ( ! empty( $parent_item_ids['services'] ) ) {
		$children = array(
			'seo-services',
			'technical-seo-services',
			'on-page-seo-services',
			'off-page-seo-link-building',
			'local-seo-services',
			'ecommerce-seo-services',
			'ai-search-optimization',
			'google-ads-management',
		);
		foreach ( $children as $slug ) {
			if ( empty( $ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => get_the_title( $ids[ $slug ] ),
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent_item_ids['services'],
			) );
		}
	}

	// Assign to the primary location.
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
