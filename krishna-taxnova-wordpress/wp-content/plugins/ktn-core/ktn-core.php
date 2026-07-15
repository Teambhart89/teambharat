<?php
/**
 * Plugin Name:       Krishna TaxNova Core
 * Plugin URI:        https://krishnataxnova.in
 * Description:       Core functionality for the Krishna TaxNova website: services post type, service categories, enquiry and document upload forms, WhatsApp integration, SEO meta, structured data and one click demo content importer.
 * Version:           1.0.0
 * Author:            Krishna TaxNova
 * License:           GPL-2.0-or-later
 * Text Domain:       ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KTN_CORE_VERSION', '1.0.0' );
define( 'KTN_CORE_FILE', __FILE__ );
define( 'KTN_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'KTN_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once KTN_CORE_DIR . 'includes/cpt.php';
require_once KTN_CORE_DIR . 'includes/settings.php';
require_once KTN_CORE_DIR . 'includes/forms.php';
require_once KTN_CORE_DIR . 'includes/whatsapp.php';
require_once KTN_CORE_DIR . 'includes/seo.php';
require_once KTN_CORE_DIR . 'includes/schema.php';
require_once KTN_CORE_DIR . 'includes/importer.php';

/**
 * Flush rewrite rules on activation so /services/ URLs work immediately.
 */
function ktn_core_activate() {
	ktn_register_post_types();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ktn_core_activate' );

function ktn_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'ktn_core_deactivate' );

/**
 * Front end assets.
 */
function ktn_core_assets() {
	wp_enqueue_style( 'ktn-core', KTN_CORE_URL . 'assets/css/ktn.css', array(), KTN_CORE_VERSION );
	wp_enqueue_script( 'ktn-core', KTN_CORE_URL . 'assets/js/ktn.js', array(), KTN_CORE_VERSION, true );
	wp_localize_script(
		'ktn-core',
		'ktnCore',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'maxFiles' => 5,
			'maxSize'  => 10, // MB per file.
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ktn_core_assets' );

/**
 * Helper: get a plugin option with default.
 */
function ktn_get_option( $key, $default = '' ) {
	$options = get_option( 'ktn_settings', array() );
	return isset( $options[ $key ] ) && '' !== $options[ $key ] ? $options[ $key ] : $default;
}
