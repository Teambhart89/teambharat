<?php
/**
 * Plugin Name:       PlantGift Core
 * Plugin URI:        https://example.com/plantgift-core
 * Description:       Builds and runs a corporate plant gifting store on WooCommerce. Installs the category tree, pot attributes, variable products, service pages and FAQ content, and adds Product, Service, FAQ and Breadcrumb structured data.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            PlantGift Pro
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       plantgift-core
 * Domain Path:       /languages
 * WC requires at least: 7.0
 * WC tested up to:   9.5
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

define( 'PLANTGIFT_CORE_VERSION', '1.0.0' );
define( 'PLANTGIFT_CORE_FILE', __FILE__ );
define( 'PLANTGIFT_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLANTGIFT_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin classes once WordPress is ready.
 */
function plantgift_core_bootstrap() {
	load_plugin_textdomain( 'plantgift-core', false, dirname( plugin_basename( PLANTGIFT_CORE_FILE ) ) . '/languages' );

	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-installer.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-admin.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-meta.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-schema.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-seo.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-shortcodes.php';
	require_once PLANTGIFT_CORE_DIR . 'includes/class-pgc-leads.php';

	PGC_Admin::init();
	PGC_Meta::init();
	PGC_Schema::init();
	PGC_SEO::init();
	PGC_Shortcodes::init();
	PGC_Leads::init();
}
add_action( 'plugins_loaded', 'plantgift_core_bootstrap', 20 );

/**
 * Warn if WooCommerce is missing. The plugin still loads so the admin notice shows.
 */
function plantgift_core_dependency_notice() {
	if ( class_exists( 'WooCommerce' ) ) {
		return;
	}
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>PlantGift Core</strong> ';
	esc_html_e( 'needs WooCommerce to build the store. Install and activate WooCommerce, then open PlantGift Setup.', 'plantgift-core' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'plantgift_core_dependency_notice' );

/**
 * Declare compatibility with WooCommerce High Performance Order Storage.
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', PLANTGIFT_CORE_FILE, true );
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', PLANTGIFT_CORE_FILE, true );
		}
	}
);

/**
 * On activation, record the version and flag that setup has not run yet.
 */
function plantgift_core_activate() {
	if ( ! get_option( 'plantgift_core_setup_state' ) ) {
		add_option(
			'plantgift_core_setup_state',
			array(
				'attributes' => 0,
				'categories' => 0,
				'products'   => 0,
				'pages'      => 0,
				'menus'      => 0,
				'settings'   => 0,
			)
		);
	}
	update_option( 'plantgift_core_version', PLANTGIFT_CORE_VERSION );
	set_transient( 'plantgift_core_activation_redirect', 1, 60 );
}
register_activation_hook( __FILE__, 'plantgift_core_activate' );

/**
 * Flush rewrite rules on deactivation so permalinks stay clean.
 */
function plantgift_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'plantgift_core_deactivate' );

/**
 * Convenience wrapper so the theme can print FAQ structured data.
 *
 * @param array $faqs Array of arrays with q and a keys.
 */
function plantgift_core_faq_schema( $faqs ) {
	if ( class_exists( 'PGC_Schema' ) ) {
		PGC_Schema::print_faq_schema( $faqs );
	}
}

/**
 * Read one of the bundled data files.
 *
 * @param string $name File name without the extension.
 * @return array
 */
function plantgift_core_data( $name ) {
	$file = PLANTGIFT_CORE_DIR . 'data/' . sanitize_file_name( $name ) . '.php';
	if ( ! file_exists( $file ) ) {
		return array();
	}
	$data = require $file;
	return is_array( $data ) ? $data : array();
}
