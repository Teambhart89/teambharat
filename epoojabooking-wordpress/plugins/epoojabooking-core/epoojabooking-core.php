<?php
/**
 * Plugin Name: ePoojaBooking Core
 * Plugin URI: https://epoojabooking.com
 * Description: Booking engine for epoojabooking.com. Adds the puja booking form with devotee details, gotra, nakshatra, sankalp, prasad delivery and live streaming options, Razorpay payments, booking management and one-click import of all SEO-ready service pages.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: epoojabooking
 * License: GPL-2.0-or-later
 * Text Domain: epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EPB_CORE_VERSION', '1.1.0' );
define( 'EPB_CONTENT_VERSION', '4' );
define( 'EPB_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'EPB_CORE_URL', plugin_dir_url( __FILE__ ) );

require EPB_CORE_DIR . 'includes/post-types.php';
require EPB_CORE_DIR . 'includes/settings.php';
require EPB_CORE_DIR . 'includes/payments.php';
require EPB_CORE_DIR . 'includes/booking-form.php';
require EPB_CORE_DIR . 'includes/demo-content.php';
require EPB_CORE_DIR . 'includes/temples-content.php';
require EPB_CORE_DIR . 'includes/banners-pujas-content.php';
require EPB_CORE_DIR . 'includes/astro-tools.php';

/**
 * Activation: register types, import pages, flush rewrite rules.
 */
function epb_core_activate() {
	epb_register_post_types();
	epb_import_site_content();
	epb_import_temples();
	epb_import_banners_and_pujas();
	flush_rewrite_rules();
	update_option( 'epb_content_version', EPB_CONTENT_VERSION );
}
register_activation_hook( __FILE__, 'epb_core_activate' );

/**
 * Upgrade routine: when plugin files are replaced with a newer version,
 * WordPress does not fire the activation hook. Import any new content
 * (pages, temples, pujas, banners, menu items) automatically instead.
 * All importers skip content that already exists, so this is safe.
 */
function epb_core_maybe_upgrade() {
	if ( get_option( 'epb_content_version' ) === EPB_CONTENT_VERSION ) {
		return;
	}
	epb_import_site_content();
	epb_import_temples();
	epb_import_banners_and_pujas();
	flush_rewrite_rules();
	update_option( 'epb_content_version', EPB_CONTENT_VERSION );
}
add_action( 'init', 'epb_core_maybe_upgrade', 20 );

/**
 * Deactivation: flush rewrite rules.
 */
function epb_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'epb_core_deactivate' );

/**
 * Front-end assets for the booking form.
 */
function epb_core_assets() {
	wp_register_style( 'epb-booking', EPB_CORE_URL . 'assets/booking.css', array(), EPB_CORE_VERSION );
	wp_register_style( 'epb-astro', EPB_CORE_URL . 'assets/astro.css', array(), EPB_CORE_VERSION );
	wp_register_script( 'epb-astro', EPB_CORE_URL . 'assets/astro.js', array(), EPB_CORE_VERSION, true );
	wp_register_script( 'epb-razorpay', 'https://checkout.razorpay.com/v1/checkout.js', array(), null, true );
	wp_register_script( 'epb-booking', EPB_CORE_URL . 'assets/booking.js', array(), EPB_CORE_VERSION, true );

	wp_localize_script( 'epb-booking', 'epbBooking', array(
		'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		'nonce'       => wp_create_nonce( 'epb_booking' ),
		'razorpayKey' => epb_get_option( 'razorpay_key_id' ),
		'currency'    => epb_get_option( 'currency', 'INR' ),
		'brandName'   => 'epoojabooking',
		'brandColor'  => '#E85D04',
		'i18n'        => array(
			'submitting' => __( 'Submitting your booking…', 'epoojabooking-core' ),
			'success'    => __( 'Booking received. We have emailed your confirmation. Our team will contact you on WhatsApp shortly.', 'epoojabooking-core' ),
			'paid'       => __( 'Payment successful. Your puja booking is confirmed. A receipt has been emailed to you.', 'epoojabooking-core' ),
			'error'      => __( 'Something went wrong. Please try again or contact us on WhatsApp.', 'epoojabooking-core' ),
		),
	) );
}
add_action( 'wp_enqueue_scripts', 'epb_core_assets' );
