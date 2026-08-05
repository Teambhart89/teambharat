<?php
/**
 * Asset loading. Everything is local so the site has no third party requests.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Front end styles and scripts.
 */
function plantgift_pro_assets() {
	$css = PLANTGIFT_PRO_DIR . '/assets/css/main.css';
	$js  = PLANTGIFT_PRO_DIR . '/assets/js/main.js';

	wp_enqueue_style(
		'plantgift-pro',
		PLANTGIFT_PRO_URI . '/assets/css/main.css',
		array(),
		file_exists( $css ) ? filemtime( $css ) : PLANTGIFT_PRO_VERSION
	);

	// The theme stylesheet header is required by WordPress, so keep it in the chain.
	wp_enqueue_style( 'plantgift-pro-base', get_stylesheet_uri(), array( 'plantgift-pro' ), PLANTGIFT_PRO_VERSION );

	if ( class_exists( 'WooCommerce' ) ) {
		$shop_css = PLANTGIFT_PRO_DIR . '/assets/css/woocommerce.css';
		wp_enqueue_style(
			'plantgift-pro-woo',
			PLANTGIFT_PRO_URI . '/assets/css/woocommerce.css',
			array( 'plantgift-pro' ),
			file_exists( $shop_css ) ? filemtime( $shop_css ) : PLANTGIFT_PRO_VERSION
		);
	}

	wp_enqueue_script(
		'plantgift-pro',
		PLANTGIFT_PRO_URI . '/assets/js/main.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : PLANTGIFT_PRO_VERSION,
		true
	);

	wp_localize_script(
		'plantgift-pro',
		'plantgiftPro',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'isRtl'    => is_rtl(),
			'i18n'     => array(
				'openMenu'   => __( 'Open menu', 'plantgift-pro' ),
				'closeMenu'  => __( 'Close menu', 'plantgift-pro' ),
				'openFilter' => __( 'Show filters', 'plantgift-pro' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'plantgift_pro_assets' );

/**
 * Load the small block editor stylesheet in the admin.
 */
function plantgift_pro_editor_assets() {
	wp_enqueue_style(
		'plantgift-pro-editor',
		PLANTGIFT_PRO_URI . '/assets/css/editor.css',
		array(),
		PLANTGIFT_PRO_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'plantgift_pro_editor_assets' );

/**
 * Preload the main stylesheet and the variable font stack fallback.
 */
function plantgift_pro_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		return $urls;
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'plantgift_pro_resource_hints', 10, 2 );
