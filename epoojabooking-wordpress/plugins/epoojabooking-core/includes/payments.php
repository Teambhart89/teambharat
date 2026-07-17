<?php
/**
 * Razorpay payment helpers.
 *
 * Creates orders through the Razorpay REST API and verifies payment
 * signatures. Stripe and PayPal can be added through WooCommerce or a
 * dedicated gateway plugin; this module covers the primary Indian flow.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Razorpay is configured.
 *
 * @return bool
 */
function epb_razorpay_enabled() {
	return (bool) ( epb_get_option( 'razorpay_key_id' ) && epb_get_option( 'razorpay_key_secret' ) );
}

/**
 * Create a Razorpay order.
 *
 * @param int    $amount_paise Amount in the smallest currency unit.
 * @param string $receipt      Receipt reference.
 * @return array|WP_Error     Order payload or error.
 */
function epb_razorpay_create_order( $amount_paise, $receipt ) {
	$key    = epb_get_option( 'razorpay_key_id' );
	$secret = epb_get_option( 'razorpay_key_secret' );

	$response = wp_remote_post( 'https://api.razorpay.com/v1/orders', array(
		'timeout' => 20,
		'headers' => array(
			'Authorization' => 'Basic ' . base64_encode( $key . ':' . $secret ),
			'Content-Type'  => 'application/json',
		),
		'body'    => wp_json_encode( array(
			'amount'   => (int) $amount_paise,
			'currency' => epb_get_option( 'currency', 'INR' ),
			'receipt'  => $receipt,
		) ),
	) );

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$code = wp_remote_retrieve_response_code( $response );
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( 200 !== $code || empty( $body['id'] ) ) {
		return new WP_Error( 'epb_razorpay', __( 'Could not create the payment order.', 'epoojabooking-core' ) );
	}

	return $body;
}

/**
 * Verify a Razorpay payment signature.
 *
 * @param string $order_id   Razorpay order id.
 * @param string $payment_id Razorpay payment id.
 * @param string $signature  Signature from checkout.
 * @return bool
 */
function epb_razorpay_verify_signature( $order_id, $payment_id, $signature ) {
	$secret   = epb_get_option( 'razorpay_key_secret' );
	$expected = hash_hmac( 'sha256', $order_id . '|' . $payment_id, $secret );
	return hash_equals( $expected, $signature );
}
