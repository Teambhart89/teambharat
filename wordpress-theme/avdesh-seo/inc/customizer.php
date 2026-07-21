<?php
/**
 * Customizer: contact details, social links, and replaceable images.
 * Everything the client edits regularly lives here, so no code changes are needed.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function avdesh_customize_register( $wp_customize ) {

	/* ---------------- Contact & Identity panel ---------------- */
	$wp_customize->add_section(
		'avdesh_contact',
		array(
			'title'    => __( 'Contact & Identity', 'avdesh-seo' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'avdesh_tagline'   => array( 'Short tagline', 'SEO & AI Search Optimization Specialist' ),
		'avdesh_phone'     => array( 'Phone number', '+91 00000 00000' ),
		'avdesh_whatsapp'  => array( 'WhatsApp number (digits only, e.g. 9100000000)', '910000000000' ),
		'avdesh_email'     => array( 'Email address', 'hello@avdeshkumar.com' ),
		'avdesh_location'  => array( 'Location', 'Delhi, India' ),
		'avdesh_calendly'  => array( 'Booking / call link (optional)', '' ),
	);
	foreach ( $fields as $key => $data ) {
		$wp_customize->add_setting( $key, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $key, array( 'label' => $data[0], 'section' => 'avdesh_contact', 'type' => 'text' ) );
	}

	// Optional contact-form shortcodes (WPForms, Contact Form 7, etc.).
	foreach ( array(
		'avdesh_form_shortcode'  => 'Contact form shortcode (optional)',
		'avdesh_audit_shortcode' => 'Free-audit form shortcode (optional)',
	) as $key => $label ) {
		$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control( $key, array( 'label' => __( $label, 'avdesh-seo' ), 'section' => 'avdesh_contact', 'type' => 'text' ) );
	}

	/* ---------------- Pricing ---------------- */
	$wp_customize->add_section( 'avdesh_pricing', array( 'title' => __( 'Pricing', 'avdesh-seo' ), 'priority' => 34 ) );
	$price_fields = array(
		'avdesh_price_currency' => array( 'Currency symbol', '$' ),
		'avdesh_price_1'        => array( 'Starter price', '499' ),
		'avdesh_price_2'        => array( 'Growth price', '999' ),
	);
	foreach ( $price_fields as $key => $data ) {
		$wp_customize->add_setting( $key, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $key, array( 'label' => $data[0], 'section' => 'avdesh_pricing', 'type' => 'text' ) );
	}

	/* ---------------- Social links ---------------- */
	$wp_customize->add_section(
		'avdesh_social',
		array(
			'title'    => __( 'Social Links', 'avdesh-seo' ),
			'priority' => 31,
		)
	);
	$socials = array(
		'avdesh_linkedin'  => 'LinkedIn URL',
		'avdesh_instagram' => 'Instagram URL',
		'avdesh_facebook'  => 'Facebook URL',
		'avdesh_twitter'   => 'X / Twitter URL',
		'avdesh_youtube'   => 'YouTube URL',
	);
	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( $key, array( 'label' => $label, 'section' => 'avdesh_social', 'type' => 'url' ) );
	}

	/* ---------------- Replaceable images ---------------- */
	$wp_customize->add_section(
		'avdesh_images',
		array(
			'title'       => __( 'Site Images', 'avdesh-seo' ),
			'description' => __( 'Upload your own photos here. Anywhere the site shows a dashed "upload image" box, set the matching image below.', 'avdesh-seo' ),
			'priority'    => 32,
		)
	);
	$images = array(
		'avdesh_img_hero'    => 'Hero portrait (home top)',
		'avdesh_img_about'   => 'About section photo',
		'avdesh_img_about2'  => 'About page secondary photo',
		'avdesh_img_cta'     => 'CTA / results background (optional)',
		'avdesh_img_testimonial' => 'Featured testimonial photo',
		'avdesh_img_og'      => 'Social share image (Open Graph, 1200x630)',
	);
	foreach ( $images as $key => $label ) {
		$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$key,
				array( 'label' => $label, 'section' => 'avdesh_images' )
			)
		);
	}

	/* ---------------- Homepage stats ---------------- */
	$wp_customize->add_section(
		'avdesh_stats',
		array(
			'title'    => __( 'Homepage Stats Bar', 'avdesh-seo' ),
			'priority' => 33,
		)
	);
	$stats = array(
		'avdesh_stat1_n' => array( 'Stat 1 number', '8+' ),
		'avdesh_stat1_l' => array( 'Stat 1 label', 'Years Experience' ),
		'avdesh_stat2_n' => array( 'Stat 2 number', '250+' ),
		'avdesh_stat2_l' => array( 'Stat 2 label', 'Keywords Ranked #1' ),
		'avdesh_stat3_n' => array( 'Stat 3 number', '120+' ),
		'avdesh_stat3_l' => array( 'Stat 3 label', 'Projects Delivered' ),
		'avdesh_stat4_n' => array( 'Stat 4 number', '3X' ),
		'avdesh_stat4_l' => array( 'Stat 4 label', 'Avg. Traffic Growth' ),
		'avdesh_stat5_n' => array( 'Stat 5 number', '6+' ),
		'avdesh_stat5_l' => array( 'Stat 5 label', 'Countries Served' ),
	);
	foreach ( $stats as $key => $data ) {
		$wp_customize->add_setting( $key, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $key, array( 'label' => $data[0], 'section' => 'avdesh_stats', 'type' => 'text' ) );
	}
}
add_action( 'customize_register', 'avdesh_customize_register' );
