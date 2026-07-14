<?php
/**
 * Customizer settings: contact details, social links, hero slides.
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cihs_customize_register( $wp_customize ) {

	/* ---------- Contact details ---------- */
	$wp_customize->add_section(
		'cihs_contact',
		array(
			'title'    => __( 'CIHS: Contact Details', 'cihs' ),
			'priority' => 30,
		)
	);

	$contact_fields = array(
		'cihs_address'  => array( __( 'Street Address', 'cihs' ), '903, Ground Floor, Sector 29' ),
		'cihs_city'     => array( __( 'City', 'cihs' ), 'Noida' ),
		'cihs_postcode' => array( __( 'Postcode', 'cihs' ), '201301' ),
		'cihs_region'   => array( __( 'Region label', 'cihs' ), 'New Delhi NCR, India' ),
		'cihs_phone'    => array( __( 'Phone', 'cihs' ), '011-46698734' ),
		'cihs_email'    => array( __( 'Email', 'cihs' ), 'contact@cihs.org.in' ),
		'cihs_hours'    => array( __( 'Office Hours', 'cihs' ), 'Mon – Fri, 9:30 AM – 6:00 PM IST' ),
	);
	foreach ( $contact_fields as $key => $data ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $data[1],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $data[0],
				'section' => 'cihs_contact',
				'type'    => 'text',
			)
		);
	}

	/* ---------- Social links ---------- */
	$wp_customize->add_section(
		'cihs_social',
		array(
			'title'    => __( 'CIHS: Social Links', 'cihs' ),
			'priority' => 31,
		)
	);

	$social_fields = array(
		'cihs_social_twitter'  => array( __( 'X (Twitter) URL', 'cihs' ), 'https://x.com/cihs_india' ),
		'cihs_social_facebook' => array( __( 'Facebook URL', 'cihs' ), 'https://www.facebook.com/CIHSofficial/' ),
		'cihs_social_youtube'  => array( __( 'YouTube URL', 'cihs' ), 'https://www.youtube.com/@CIHS_India' ),
		'cihs_social_linkedin' => array( __( 'LinkedIn URL', 'cihs' ), 'https://in.linkedin.com/company/centre-for-integrated-and-holistic-studies' ),
	);
	foreach ( $social_fields as $key => $data ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $data[1],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $data[0],
				'section' => 'cihs_social',
				'type'    => 'url',
			)
		);
	}

	/* ---------- Hero slides (3) ---------- */
	$wp_customize->add_section(
		'cihs_hero',
		array(
			'title'       => __( 'CIHS: Homepage Hero Slides', 'cihs' ),
			'description' => __( 'Up to three rotating hero slides on the front page. Leave a title empty to hide that slide.', 'cihs' ),
			'priority'    => 32,
		)
	);

	$defaults = cihs_hero_defaults();
	for ( $i = 1; $i <= 3; $i++ ) {
		foreach ( array( 'kicker', 'title', 'text', 'button_label', 'button_url' ) as $part ) {
			$key = "cihs_hero_{$i}_{$part}";
			$wp_customize->add_setting(
				$key,
				array(
					'default'           => isset( $defaults[ $i ][ $part ] ) ? $defaults[ $i ][ $part ] : '',
					'sanitize_callback' => 'button_url' === $part ? 'esc_url_raw' : 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				$key,
				array(
					/* translators: 1: slide number, 2: field name. */
					'label'   => sprintf( __( 'Slide %1$d — %2$s', 'cihs' ), $i, ucwords( str_replace( '_', ' ', $part ) ) ),
					'section' => 'cihs_hero',
					'type'    => 'text' === $part ? 'textarea' : 'text',
				)
			);
		}
	}
}
add_action( 'customize_register', 'cihs_customize_register' );

/**
 * Default hero slide content.
 *
 * @return array
 */
function cihs_hero_defaults() {
	return array(
		1 => array(
			'kicker'       => __( 'Independent · Non-Partisan · Research-Driven', 'cihs' ),
			'title'        => __( 'Holistic Research for an Evolving Bharat and World', 'cihs' ),
			'text'         => __( 'CIHS is an independent think tank headquartered in New Delhi, fostering informed public debate and sound policy through interdisciplinary, solution-oriented research.', 'cihs' ),
			'button_label' => __( 'Explore Our Research', 'cihs' ),
			'button_url'   => '/publications/',
		),
		2 => array(
			'kicker'       => __( 'Vasudhaiva Kutumbakam', 'cihs' ),
			'title'        => __( 'Ideas Rooted in Civilisation, Focused on the Future', 'cihs' ),
			'text'         => __( 'From geopolitics and security to technology and culture, our scholars connect India’s civilisational wisdom with the pressing questions of the 21st century.', 'cihs' ),
			'button_label' => __( 'Our Focus Areas', 'cihs' ),
			'button_url'   => '/research/',
		),
		3 => array(
			'kicker'       => __( 'Dialogue · Lectures · Round Tables', 'cihs' ),
			'title'        => __( 'Join the Conversation That Shapes Policy', 'cihs' ),
			'text'         => __( 'CIHS convenes thought leaders, scholars and practitioners through lectures, seminars and interaction series across India.', 'cihs' ),
			'button_label' => __( 'Upcoming Events', 'cihs' ),
			'button_url'   => '/events/',
		),
	);
}

/**
 * Resolved hero slides (customizer values over defaults).
 *
 * @return array
 */
function cihs_get_hero_slides() {
	$slides   = array();
	$defaults = cihs_hero_defaults();
	for ( $i = 1; $i <= 3; $i++ ) {
		$slide = array();
		foreach ( array( 'kicker', 'title', 'text', 'button_label', 'button_url' ) as $part ) {
			$default        = isset( $defaults[ $i ][ $part ] ) ? $defaults[ $i ][ $part ] : '';
			$slide[ $part ] = get_theme_mod( "cihs_hero_{$i}_{$part}", $default );
		}
		if ( ! empty( $slide['title'] ) ) {
			$slides[] = $slide;
		}
	}
	return $slides;
}
