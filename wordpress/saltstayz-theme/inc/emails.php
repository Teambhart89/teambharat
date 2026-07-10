<?php
/**
 * SaltStayz — branded HTML guest emails.
 * Each function returns array( 'subject' => string, 'html' => string ).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ssz_fmt_date( $iso ) {
	$ts = strtotime( $iso );
	return $ts ? date_i18n( 'D, j M Y', $ts ) : $iso;
}

function ssz_nights( $check_in, $check_out ) {
	$a = strtotime( $check_in );
	$b = strtotime( $check_out );
	if ( ! $a || ! $b ) {
		return 1;
	}
	$n = (int) round( ( $b - $a ) / DAY_IN_SECONDS );
	return max( 1, $n );
}

function ssz_email_layout( $title, $body_html ) {
	$site = esc_html( get_bloginfo( 'name' ) );
	$home = esc_url( home_url( '/' ) );
	return '<!DOCTYPE html><html lang="en"><body style="margin:0;padding:0;background:#f5f3ec;font-family:Calibri,Carlito,\'Trebuchet MS\',\'Segoe UI\',sans-serif;color:#1a1a1a;">'
		. '<div style="max-width:560px;margin:0 auto;padding:20px;">'
		. '<div style="background:#4f7134;border-radius:16px 16px 0 0;padding:20px;text-align:center;">'
		. '<span style="font-size:22px;font-weight:bold;color:#ffffff;letter-spacing:2px;">' . esc_html( strtoupper( get_bloginfo( 'name' ) ?: 'SALTSTAYZ' ) ) . '</span><br>'
		. '<span style="font-size:12px;color:#f5f3ec;letter-spacing:1px;">SERVICED APARTMENTS &amp; STUDIOS</span></div>'
		. '<div style="background:#ffffff;border-radius:0 0 16px 16px;padding:24px;line-height:24px;font-size:16px;">'
		. '<h1 style="font-size:22px;margin:0 0 14px;color:#1a1a1a;">' . esc_html( $title ) . '</h1>'
		. $body_html
		. '<p style="margin:20px 0 0;">Warm regards,<br><strong>Team ' . $site . '</strong><br>'
		. '<a href="' . $home . '" style="color:#4f7134;">' . esc_html( wp_parse_url( $home, PHP_URL_HOST ) ) . '</a></p>'
		. '</div>'
		. '<p style="text-align:center;font-size:12px;color:#5f5f5f;margin-top:14px;">You are receiving this email about your reservation.</p>'
		. '</div></body></html>';
}

function ssz_email_details_table( $b ) {
	$rows = array(
		'Booking ID' => $b['id'],
		'Guest'      => $b['name'],
		'Property'   => $b['property'],
		'Apartment'  => $b['apartment'],
		'Check-in'   => ssz_fmt_date( $b['check_in'] ),
		'Check-out'  => ssz_fmt_date( $b['check_out'] ),
		'Guests'     => $b['guests'],
		'Nights'     => ssz_nights( $b['check_in'], $b['check_out'] ),
	);
	$html = '<table style="width:100%;border-collapse:collapse;font-size:15px;margin:14px 0;">';
	foreach ( $rows as $k => $v ) {
		$html .= '<tr><td style="padding:8px 10px;background:#f5f3ec;font-weight:bold;border-bottom:2px solid #ffffff;width:40%;">' . esc_html( $k ) . '</td>'
			. '<td style="padding:8px 10px;background:#f5f3ec;border-bottom:2px solid #ffffff;">' . esc_html( $v ) . '</td></tr>';
	}
	return $html . '</table>';
}

/* 1. Booking request received */
function ssz_email_received( $b ) {
	$body = '<p>Hi ' . esc_html( $b['name'] ) . ',</p>'
		. '<p>Thanks for choosing us. We\'ve received your booking request and our team is reviewing availability. You\'ll get a confirmation email shortly.</p>'
		. ssz_email_details_table( $b )
		. '<p>Need to change anything? Just reply to this email.</p>';
	return array(
		'subject' => sprintf( "We've received your booking request — %s", $b['id'] ),
		'html'    => ssz_email_layout( 'Thanks — your request is in!', $body ),
	);
}

/* 2. Booking confirmed */
function ssz_email_confirmed( $b ) {
	$body = '<p>Hi ' . esc_html( $b['name'] ) . ',</p>'
		. '<p>Great news — your booking is <strong style="color:#4f7134;">confirmed</strong>. We look forward to hosting you.</p>'
		. ssz_email_details_table( $b )
		. '<div style="background:#f5f3ec;border-radius:12px;padding:14px 16px;margin:14px 0;"><strong>Good to know</strong>'
		. '<ul style="margin:8px 0 0;padding-left:18px;">'
		. '<li>Check-in from 1:00 PM, check-out by 11:00 AM</li>'
		. '<li>Free high-speed Wi-Fi, housekeeping and 24×7 front desk</li>'
		. '<li>Carry a government-issued photo ID for check-in</li>'
		. '</ul></div><p>See you soon!</p>';
	return array(
		'subject' => sprintf( 'Booking confirmed ✔ %s, %s — %s', $b['property'], ssz_fmt_date( $b['check_in'] ), $b['id'] ),
		'html'    => ssz_email_layout( 'Your booking is confirmed!', $body ),
	);
}

/* 3. Check-out summary */
function ssz_email_checkout( $b ) {
	$body = '<p>Hi ' . esc_html( $b['name'] ) . ',</p>'
		. '<p>This confirms your check-out from <strong>' . esc_html( $b['property'] ) . '</strong>. Here\'s a summary of your stay:</p>'
		. ssz_email_details_table( $b )
		. '<p>If you left anything behind or have a billing question, reply to this email and we\'ll sort it out right away.</p>';
	return array(
		'subject' => sprintf( 'Checked out — summary of your stay %s', $b['id'] ),
		'html'    => ssz_email_layout( "You're all checked out", $body ),
	);
}

/* 4. Thanks for staying + feedback link */
function ssz_email_thanks( $b, $feedback_url ) {
	$url  = esc_url( $feedback_url );
	$body = '<p>Hi ' . esc_html( $b['name'] ) . ',</p>'
		. '<p>It was a pleasure hosting you at <strong>' . esc_html( $b['property'] ) . '</strong>. We hope your stay felt like home — that\'s what we aim for, every single time.</p>'
		. '<p>Could you spare 60 seconds to tell us how we did? Your feedback directly shapes how we improve.</p>'
		. '<p style="text-align:center;margin:22px 0;"><a href="' . $url . '" style="background:#4f7134;color:#ffffff;text-decoration:none;padding:12px 28px;border-radius:9999px;font-weight:bold;display:inline-block;">Share your feedback</a></p>'
		. '<p style="font-size:13px;color:#5f5f5f;">Or copy this link: <a href="' . $url . '" style="color:#4f7134;">' . $url . '</a></p>'
		. '<p>We\'d love to welcome you back.</p>';
	return array(
		'subject' => sprintf( 'Thank you for staying with us, %s! 🌿', $b['name'] ),
		'html'    => ssz_email_layout( 'Thank you for staying with us', $body ),
	);
}
