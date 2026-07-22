<?php
/**
 * One-time setup on theme activation.
 *
 * Creates every page with an SEO-friendly slug, assigns the right template,
 * sets the homepage and blog page, builds the primary navigation menu, and
 * switches permalinks to /%postname%/.
 *
 * Safe to re-run: existing pages (matched by slug) are reused, not duplicated.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Create a page if one with the slug does not already exist. */
function avdesh_ensure_page( $slug, $title, $template = '', $content = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		if ( $template ) {
			update_post_meta( $existing->ID, '_wp_page_template', $template );
		}
		return $existing->ID;
	}
	$id = wp_insert_post(
		array(
			'post_title'     => $title,
			'post_name'      => $slug,
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_content'   => $content,
			'comment_status' => 'closed',
		)
	);
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return ( is_wp_error( $id ) ) ? 0 : $id;
}

/** Add one menu item; returns its ID. */
function avdesh_add_menu_item( $menu_id, $page_id, $title, $parent = 0 ) {
	return wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => $title,
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent,
		)
	);
}

/**
 * Ensure every page exists and the front/blog/permalink options are set.
 * Idempotent and menu-safe: it never touches the navigation menu, so it is
 * also used to self-heal after a theme update without clobbering menu edits.
 *
 * @return array [ $ids, $service_ids ]
 */
function avdesh_ensure_pages() {
	// 1. Core pages (Home uses front-page.php automatically).
	$ids = array();
	$ids['home']       = avdesh_ensure_page( 'home', 'Home', '', 'Homepage for Avdesh Kumar.' );
	$ids['about']      = avdesh_ensure_page( 'about', 'About', 'template-about.php' );
	$ids['services']   = avdesh_ensure_page( 'services', 'Services', 'template-services.php' );
	$ids['case']       = avdesh_ensure_page( 'case-studies', 'Case Studies', 'template-case-studies.php' );
	$ids['results']    = avdesh_ensure_page( 'seo-results', 'SEO Results', 'template-seo-results.php' );
	$ids['portfolio']  = avdesh_ensure_page( 'portfolio', 'Portfolio', 'template-portfolio.php' );
	$ids['testi']      = avdesh_ensure_page( 'testimonials', 'Testimonials', 'template-testimonials.php' );
	$ids['industries'] = avdesh_ensure_page( 'industries', 'Industries', 'template-industries.php' );
	$ids['pricing']    = avdesh_ensure_page( 'pricing', 'Pricing', 'template-pricing.php' );
	$ids['faqs']       = avdesh_ensure_page( 'faqs', 'FAQs', 'template-faqs.php' );
	$ids['audit']      = avdesh_ensure_page( 'book-free-seo-audit', 'Book a Free SEO Audit', 'template-book-audit.php' );
	$ids['contact']    = avdesh_ensure_page( 'contact', 'Contact', 'template-contact.php' );
	$ids['blog']       = avdesh_ensure_page( 'blog', 'Blog', '' );

	// 2. Service pages (SEO-friendly slugs = data keys).
	$service_ids = array();
	foreach ( avdesh_services() as $slug => $data ) {
		$service_ids[ $slug ] = avdesh_ensure_page( $slug, $data['menu'], 'template-service.php', $data['card_desc'] );
	}

	// 3. Front + blog pages.
	if ( $ids['home'] ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}
	if ( $ids['blog'] ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}

	// 4. SEO-friendly permalink structure (rewrite rules flushed by the caller).
	update_option( 'permalink_structure', '/%postname%/' );
	global $wp_rewrite;
	if ( isset( $wp_rewrite ) ) {
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}

	return array( $ids, $service_ids );
}

/** Flush rewrite rules so pretty permalinks (/case-studies/ etc.) resolve. */
function avdesh_flush_rewrites() {
	global $wp_rewrite;
	update_option( 'permalink_structure', '/%postname%/' );
	if ( isset( $wp_rewrite ) ) {
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$wp_rewrite->flush_rules();
	} else {
		flush_rewrite_rules( false );
	}
}

/** Full setup on activation: pages + permalinks + navigation menu. */
function avdesh_setup_pages() {
	list( $ids, $service_ids ) = avdesh_ensure_pages();
	avdesh_flush_rewrites();

	// 5. Primary navigation menu.
	$menu_name = 'Avdesh Primary Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu->term_id;
		$items   = wp_get_nav_menu_items( $menu_id );
		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}

	if ( $menu_id && ! is_wp_error( $menu_id ) ) {
		avdesh_add_menu_item( $menu_id, $ids['home'], 'Home' );

		$about_parent = avdesh_add_menu_item( $menu_id, $ids['about'], 'About' );
		avdesh_add_menu_item( $menu_id, $ids['industries'], 'Industries', $about_parent );
		avdesh_add_menu_item( $menu_id, $ids['faqs'], 'FAQs', $about_parent );

		$services_parent = avdesh_add_menu_item( $menu_id, $ids['services'], 'Services' );
		foreach ( avdesh_services() as $slug => $data ) {
			if ( ! empty( $service_ids[ $slug ] ) ) {
				avdesh_add_menu_item( $menu_id, $service_ids[ $slug ], $data['menu'], $services_parent );
			}
		}

		$results_parent = avdesh_add_menu_item( $menu_id, $ids['case'], 'Case Studies' );
		avdesh_add_menu_item( $menu_id, $ids['results'], 'SEO Results', $results_parent );
		avdesh_add_menu_item( $menu_id, $ids['portfolio'], 'Portfolio', $results_parent );
		avdesh_add_menu_item( $menu_id, $ids['testi'], 'Testimonials', $results_parent );

		avdesh_add_menu_item( $menu_id, $ids['pricing'], 'Pricing' );
		avdesh_add_menu_item( $menu_id, $ids['blog'], 'Blog' );
		avdesh_add_menu_item( $menu_id, $ids['contact'], 'Contact' );

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// 6. Friendly site identity if still default.
	if ( ! get_option( 'blogname' ) || 'My WordPress Site' === get_option( 'blogname' ) ) {
		update_option( 'blogname', 'Avdesh Kumar' );
	}
	update_option( 'blogdescription', 'SEO & AI Search Optimization Consultant' );

	update_option( 'avdesh_setup_version', AVDESH_VER );
}
add_action( 'after_switch_theme', 'avdesh_setup_pages' );

/**
 * Self-heal after a theme UPDATE (not just activation).
 *
 * Re-uploading the theme ZIP overwrites files but does not fire
 * after_switch_theme, so newly added pages would 404 and rewrite rules would
 * go stale. On the next admin page load after a version change we make sure
 * every page exists and flush the rewrite rules. The navigation menu is left
 * untouched so any manual menu edits are preserved.
 */
function avdesh_maybe_heal() {
	if ( get_option( 'avdesh_setup_version' ) === AVDESH_VER ) {
		return;
	}
	avdesh_ensure_pages();
	avdesh_flush_rewrites();
	update_option( 'avdesh_setup_version', AVDESH_VER );
}
add_action( 'admin_init', 'avdesh_maybe_heal' );
