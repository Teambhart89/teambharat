<?php
/**
 * Theme Customizer: image upload sections and business details.
 *
 * Every picture that appears in the design can be uploaded or replaced from
 * Appearance > Customize, so the site owner never has to touch code.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function avseo_customize_register( $wp_customize ) {

	/* -------------------------------------------------
	 * Panel: Business Details
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_contact', array(
		'title'    => __( 'Business Details', 'avdesh-seo' ),
		'priority' => 30,
	) );

	$text_fields = array(
		'contact_name'       => array( 'Full name', 'Avdesh Kumar' ),
		'contact_role'       => array( 'Professional title', 'SEO & AI Search Optimization Specialist' ),
		'contact_phone'      => array( 'Phone (display)', '+91 00000 00000' ),
		'contact_phone_link' => array( 'Phone (dialable, no spaces)', '+910000000000' ),
		'contact_email'      => array( 'Email address', 'hello@avdeshseo.com' ),
		'contact_location'   => array( 'Location', 'Delhi, India' ),
		'social_linkedin'    => array( 'LinkedIn URL', '#' ),
		'social_whatsapp'    => array( 'WhatsApp link', '#' ),
	);

	foreach ( $text_fields as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $data[0],
			'section' => 'avseo_contact',
			'type'    => ( false !== strpos( $key, 'email' ) ) ? 'email' : 'text',
		) );
	}

	/* -------------------------------------------------
	 * Section: Images (upload / replace)
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_images', array(
		'title'       => __( 'Images (upload / replace)', 'avdesh-seo' ),
		'description' => __( 'Upload your own photos here. Anywhere a dashed placeholder appears on the site, add the matching image below.', 'avdesh-seo' ),
		'priority'    => 31,
	) );

	$image_fields = array(
		'img_hero'        => 'Hero portrait (homepage top)',
		'img_about'       => 'About section photo',
		'img_profile'     => 'Contact / footer profile photo',
		'img_case_1'      => 'Case study image 1',
		'img_case_2'      => 'Case study image 2',
		'img_case_3'      => 'Case study image 3',
		'img_case_4'      => 'Case study image 4',
		'img_result_1'    => 'Results / campaign image 1',
		'img_result_2'    => 'Results / campaign image 2',
		'img_seo_service' => 'SEO services page banner image',
		'img_technical'   => 'Technical SEO page image',
		'img_ai_search'   => 'AI search optimization page image',
	);

	foreach ( $image_fields as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
			'label'   => $label,
			'section' => 'avseo_images',
		) ) );
	}

	/* -------------------------------------------------
	 * Section: Hero stats
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_stats', array(
		'title'    => __( 'Homepage Stats Bar', 'avdesh-seo' ),
		'priority' => 32,
	) );

	$stats = array(
		'stat_1_num'   => array( 'Stat 1 number', '500%' ),
		'stat_1_label' => array( 'Stat 1 label', 'Traffic Growth' ),
		'stat_2_num'   => array( 'Stat 2 number', '8+' ),
		'stat_2_label' => array( 'Stat 2 label', 'Years Experience' ),
		'stat_3_num'   => array( 'Stat 3 number', '#1' ),
		'stat_3_label' => array( 'Stat 3 label', 'Keyword Rankings' ),
		'stat_4_num'   => array( 'Stat 4 number', '150+' ),
		'stat_4_label' => array( 'Stat 4 label', 'Projects Delivered' ),
		'stat_5_num'   => array( 'Stat 5 number', '6' ),
		'stat_5_label' => array( 'Stat 5 label', 'Countries Served' ),
	);
	foreach ( $stats as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $data[0],
			'section' => 'avseo_stats',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'avseo_customize_register' );
