<?php
/**
 * WhatsApp integration: floating button, per service "WhatsApp us your
 * documents" button and click to chat helpers.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a wa.me click to chat URL with a prefilled message.
 */
function ktn_whatsapp_url( $service_name = '' ) {
	$number = ktn_get_option( 'whatsapp', '919999999999' );
	if ( $service_name ) {
		$message = sprintf(
			'Hello Krishna TaxNova, I am interested in %s. I would like to share my documents and get a quote.',
			$service_name
		);
	} else {
		$message = 'Hello Krishna TaxNova, I need help with a tax or compliance service. Can we chat?';
	}
	return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $message );
}

/**
 * WhatsApp SVG icon (inline, no external requests).
 */
function ktn_whatsapp_icon() {
	return '<svg viewBox="0 0 32 32" width="22" height="22" aria-hidden="true" fill="currentColor"><path d="M16 3C9.4 3 4 8.3 4 14.9c0 2.6.8 5 2.3 7L4 29l7.3-2.2c1.9 1 4 1.6 6.2 1.6h.5c6.6 0 12-5.3 12-11.9C30 8.3 22.6 3 16 3zm7 16.9c-.3.8-1.7 1.6-2.4 1.7-.6.1-1.4.1-2.2-.1-.5-.2-1.2-.4-2-.8-3.6-1.5-5.9-5.1-6.1-5.4-.2-.2-1.5-1.9-1.5-3.7s.9-2.6 1.3-3c.3-.4.7-.5 1-.5h.7c.2 0 .5-.1.8.6.3.8 1.1 2.6 1.2 2.8.1.2.2.4 0 .7-.1.2-.2.4-.4.6l-.6.7c-.2.2-.4.4-.2.8.2.4 1 1.7 2.2 2.7 1.5 1.3 2.8 1.8 3.2 2 .4.2.6.1.9-.1.2-.3 1-1.2 1.3-1.6.3-.4.5-.3.9-.2.4.1 2.2 1 2.6 1.2.4.2.6.3.7.5.1.2.1.9-.4 1.9z"/></svg>';
}

/**
 * Render a WhatsApp button. Style: "inline" or "block".
 */
function ktn_whatsapp_button( $service_name = '', $style = 'inline' ) {
	$class = 'block' === $style ? 'ktn-btn ktn-btn-whatsapp ktn-btn-block' : 'ktn-btn ktn-btn-whatsapp';
	$label = $service_name
		? __( 'WhatsApp Us Your Documents', 'ktn-core' )
		: __( 'Chat on WhatsApp', 'ktn-core' );
	return sprintf(
		'<a class="%1$s" href="%2$s" target="_blank" rel="noopener nofollow">%3$s <span>%4$s</span></a>',
		esc_attr( $class ),
		esc_url( ktn_whatsapp_url( $service_name ) ),
		ktn_whatsapp_icon(),
		esc_html( $label )
	);
}

/**
 * Floating WhatsApp button on every page.
 */
function ktn_floating_whatsapp() {
	$service = is_singular( 'service' ) ? get_the_title() : '';
	printf(
		'<a class="ktn-wa-float" href="%1$s" target="_blank" rel="noopener nofollow" aria-label="%2$s">%3$s<span class="ktn-wa-float-label">%4$s</span></a>',
		esc_url( ktn_whatsapp_url( $service ) ),
		esc_attr__( 'Chat with Krishna TaxNova on WhatsApp', 'ktn-core' ),
		ktn_whatsapp_icon(), // phpcs:ignore WordPress.Security.EscapeOutput
		esc_html__( 'WhatsApp Us', 'ktn-core' )
	);
}
add_action( 'wp_footer', 'ktn_floating_whatsapp' );
