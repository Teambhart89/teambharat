<?php
/**
 * One-time setup on theme activation.
 *
 * Creates every page with an SEO-friendly slug, assigns the right template,
 * sets the homepage and blog page, builds the primary navigation menu, and
 * switches permalinks to /%postname%/ so URLs are clean and keyword-rich.
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
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
			'comment_status' => 'closed',
		)
	);
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return ( is_wp_error( $id ) ) ? 0 : $id;
}

/** Run the full setup once when the theme is activated. */
function avdesh_setup_pages() {

	// 1. Core pages.
	// Home uses front-page.php automatically (via the template hierarchy),
	// so no page template is assigned here.
	$home_id    = avdesh_ensure_page( 'home', 'Home', '', 'Homepage for Avdesh Kumar, SEO & AI Search Optimization Specialist.' );
	$about_id   = avdesh_ensure_page( 'about', 'About', 'template-about.php' );
	$services_id= avdesh_ensure_page( 'services', 'Services', 'template-services.php' );
	$portfolio_id = avdesh_ensure_page( 'portfolio', 'Portfolio', 'template-portfolio.php' );
	$contact_id = avdesh_ensure_page( 'contact', 'Contact', 'template-contact.php' );
	$blog_id    = avdesh_ensure_page( 'blog', 'Blog', '' );

	// 2. Service pages (SEO-friendly slugs come straight from the data keys).
	$service_ids = array();
	foreach ( avdesh_services() as $slug => $data ) {
		$service_ids[ $slug ] = avdesh_ensure_page( $slug, $data['menu'], 'template-service.php', $data['card_desc'] );
	}

	// 3. Front page + blog page.
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	if ( $blog_id ) {
		update_option( 'page_for_posts', $blog_id );
	}

	// 4. SEO-friendly permalinks (/%postname%/).
	global $wp_rewrite;
	update_option( 'permalink_structure', '/%postname%/' );
	if ( isset( $wp_rewrite ) ) {
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		$wp_rewrite->flush_rules();
	}

	// 5. Primary navigation menu with a Services dropdown.
	$menu_name = 'Avdesh Primary Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = $menu->term_id;
		// Clear existing items to avoid duplicates on re-activation.
		$items = wp_get_nav_menu_items( $menu_id );
		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}
	}

	if ( $menu_id && ! is_wp_error( $menu_id ) ) {
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Home', 'menu-item-object' => 'page', 'menu-item-object-id' => $home_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'About', 'menu-item-object' => 'page', 'menu-item-object-id' => $about_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );

		$services_parent = wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Services', 'menu-item-object' => 'page', 'menu-item-object-id' => $services_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );

		foreach ( avdesh_services() as $slug => $data ) {
			if ( empty( $service_ids[ $slug ] ) ) {
				continue;
			}
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $data['menu'],
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $service_ids[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $services_parent,
				)
			);
		}

		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Portfolio', 'menu-item-object' => 'page', 'menu-item-object-id' => $portfolio_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Blog', 'menu-item-object' => 'page', 'menu-item-object-id' => $blog_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Contact', 'menu-item-object' => 'page', 'menu-item-object-id' => $contact_id, 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );

		// Assign menu to the primary location.
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// 6. Set a friendly site title/tagline if still on defaults.
	if ( get_option( 'blogname' ) === 'My WordPress Site' || ! get_option( 'blogname' ) ) {
		update_option( 'blogname', 'Avdesh Kumar' );
	}
	update_option( 'blogdescription', 'SEO & AI Search Optimization Specialist' );
}
add_action( 'after_switch_theme', 'avdesh_setup_pages' );
