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
		'img_hero'     => 'Hero portrait, homepage top (recommended 800 x 900 px, PNG transparent)',
		'img_about'    => 'About section photo (recommended 700 x 800 px)',
		'img_profile'  => 'Contact / footer profile photo (recommended 600 x 600 px)',
		'img_case_1'   => 'Case study image 1 (recommended 600 x 400 px)',
		'img_case_2'   => 'Case study image 2 (recommended 600 x 400 px)',
		'img_case_3'   => 'Case study image 3 (recommended 600 x 400 px)',
		'img_case_4'   => 'Case study image 4 (recommended 600 x 400 px)',
		'img_result_1' => 'Results / campaign image 1 (recommended 800 x 600 px)',
		'img_result_2' => 'Results / campaign image 2 (recommended 800 x 600 px)',
	);

	foreach ( $image_fields as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => avseo_sample_default( $key ),
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
			'label'   => $label,
			'section' => 'avseo_images',
		) ) );
	}

	/* -------------------------------------------------
	 * Section: Homepage hero text
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_hero', array(
		'title'       => __( 'Homepage Hero Text', 'avdesh-seo' ),
		'description' => __( 'The name and title come from Business Details. Edit the hero tagline below. The About paragraphs are edited in Pages > Home.', 'avdesh-seo' ),
		'priority'    => 32,
	) );
	$wp_customize->add_setting( 'home_hero_tagline', array(
		'default'           => 'I help businesses grow organic traffic, improve rankings and generate qualified leads and sales with proven white hat SEO, GEO and Google Ads.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'home_hero_tagline', array(
		'label'   => __( 'Hero tagline', 'avdesh-seo' ),
		'section' => 'avseo_hero',
		'type'    => 'textarea',
	) );

	/* -------------------------------------------------
	 * Section: Hero stats
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_stats', array(
		'title'    => __( 'Homepage Stats Bar', 'avdesh-seo' ),
		'priority' => 33,
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

	/* -------------------------------------------------
	 * Section: Case Study Metrics
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_case_metrics', array(
		'title'       => __( 'Case Study Metrics', 'avdesh-seo' ),
		'description' => __( 'The headline results shown on the Case Studies page. Case study images are uploaded under the Images section.', 'avdesh-seo' ),
		'priority'    => 33,
	) );
	$case_metrics = array(
		'case_metric_1_num'   => array( 'Metric 1 number', '+312%' ),
		'case_metric_1_label' => array( 'Metric 1 label', 'Organic Traffic' ),
		'case_metric_2_num'   => array( 'Metric 2 number', '3.5X' ),
		'case_metric_2_label' => array( 'Metric 2 label', 'Qualified Leads' ),
		'case_metric_3_num'   => array( 'Metric 3 number', '120+' ),
		'case_metric_3_label' => array( 'Metric 3 label', 'Page 1 Keywords' ),
		'case_metric_4_num'   => array( 'Metric 4 number', '18' ),
		'case_metric_4_label' => array( 'Metric 4 label', 'Brands Grown' ),
	);
	foreach ( $case_metrics as $key => $data ) {
		$wp_customize->add_setting( $key, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $key, array( 'label' => $data[0], 'section' => 'avseo_case_metrics', 'type' => 'text' ) );
	}

	/* -------------------------------------------------
	 * Section: Testimonials (with photo upload)
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_testimonials', array(
		'title'       => __( 'Testimonials', 'avdesh-seo' ),
		'description' => __( 'Add up to 6 client reviews with an optional photo. Leave a quote empty to hide that testimonial. Recommended photo size 200 x 200 px (square).', 'avdesh-seo' ),
		'priority'    => 34,
	) );

	$testi_defaults = array(
		1 => array( 'Our organic traffic grew steadily month after month and we finally rank for the keywords that bring real customers.', 'Rahul Sharma', 'Founder, SaaS Company' ),
		2 => array( 'A clear strategy, honest reporting and rankings that turned into actual leads and sales for our store.', 'Priya Nair', 'Owner, eCommerce Brand' ),
		3 => array( 'The AI search work put us inside answers on ChatGPT and Google AI Overviews. Genuinely ahead of the curve.', 'James Miller', 'Marketing Head, Local Business' ),
		4 => array( '', '', '' ),
		5 => array( '', '', '' ),
		6 => array( '', '', '' ),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$wp_customize->add_setting( "testi_{$i}_photo", array( 'default' => avseo_sample_default( "testi_{$i}_photo" ), 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "testi_{$i}_photo", array(
			'label'   => "Testimonial {$i}: photo (200 x 200 px)",
			'section' => 'avseo_testimonials',
		) ) );

		$wp_customize->add_setting( "testi_{$i}_quote", array( 'default' => $testi_defaults[ $i ][0], 'sanitize_callback' => 'sanitize_textarea_field' ) );
		$wp_customize->add_control( "testi_{$i}_quote", array(
			'label'   => "Testimonial {$i}: quote",
			'section' => 'avseo_testimonials',
			'type'    => 'textarea',
		) );

		$wp_customize->add_setting( "testi_{$i}_name", array( 'default' => $testi_defaults[ $i ][1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "testi_{$i}_name", array(
			'label'   => "Testimonial {$i}: name",
			'section' => 'avseo_testimonials',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "testi_{$i}_role", array( 'default' => $testi_defaults[ $i ][2], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "testi_{$i}_role", array(
			'label'   => "Testimonial {$i}: role / company",
			'section' => 'avseo_testimonials',
			'type'    => 'text',
		) );
	}

	/* -------------------------------------------------
	 * Section: Brand Logos (upload)
	 * ------------------------------------------------- */
	$wp_customize->add_section( 'avseo_brands', array(
		'title'       => __( 'Brand Logos', 'avdesh-seo' ),
		'description' => __( 'Upload logos of brands you have worked with. Recommended size 200 x 100 px, PNG with a transparent background. Empty slots show an "Add logo" placeholder on the site.', 'avdesh-seo' ),
		'priority'    => 35,
	) );

	$wp_customize->add_setting( 'brands_heading', array(
		'default'           => 'Brands I have worked with',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'brands_heading', array(
		'label'   => __( 'Section intro text', 'avdesh-seo' ),
		'section' => 'avseo_brands',
		'type'    => 'text',
	) );

	for ( $i = 1; $i <= 12; $i++ ) {
		$wp_customize->add_setting( "brand_{$i}", array( 'default' => avseo_sample_default( "brand_{$i}" ), 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "brand_{$i}", array(
			'label'   => "Brand logo {$i} (200 x 100 px)",
			'section' => 'avseo_brands',
		) ) );
	}
}
add_action( 'customize_register', 'avseo_customize_register' );
