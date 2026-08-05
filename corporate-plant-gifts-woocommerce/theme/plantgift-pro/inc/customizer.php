<?php
/**
 * Customizer settings for contact details, hero copy and social links.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register panels, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function plantgift_pro_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_panel(
		'plantgift_panel',
		array(
			'title'    => __( 'PlantGift Pro options', 'plantgift-pro' ),
			'priority' => 30,
		)
	);

	/* Contact ---------------------------------------------------------- */

	$wp_customize->add_section(
		'plantgift_contact',
		array(
			'title' => __( 'Contact details', 'plantgift-pro' ),
			'panel' => 'plantgift_panel',
		)
	);

	$contact_fields = array(
		'plantgift_phone'        => array( __( 'Phone number', 'plantgift-pro' ), '+91 00000 00000', 'text' ),
		'plantgift_email'        => array( __( 'Email address', 'plantgift-pro' ), 'gifting@example.com', 'email' ),
		'plantgift_hours'        => array( __( 'Working hours', 'plantgift-pro' ), 'Monday to Saturday, 9.30am to 6.30pm', 'text' ),
		'plantgift_address'      => array( __( 'Postal address', 'plantgift-pro' ), '', 'textarea' ),
		'plantgift_topbar_text'  => array( __( 'Top bar message', 'plantgift-pro' ), 'Free design mockup on orders above 100 units', 'text' ),
	);

	foreach ( $contact_fields as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $field[1],
				'sanitize_callback' => 'textarea' === $field[2] ? 'sanitize_textarea_field' : ( 'email' === $field[2] ? 'sanitize_email' : 'sanitize_text_field' ),
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $field[0],
				'section' => 'plantgift_contact',
				'type'    => 'textarea' === $field[2] ? 'textarea' : 'text',
			)
		);
	}

	/* Hero ------------------------------------------------------------- */

	$wp_customize->add_section(
		'plantgift_hero',
		array(
			'title' => __( 'Home page hero', 'plantgift-pro' ),
			'panel' => 'plantgift_panel',
		)
	);

	$wp_customize->add_setting(
		'plantgift_hero_title',
		array(
			'default'           => __( 'Corporate Plant Gifts for Colleagues, Employees, Events and Clients', 'plantgift-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'plantgift_hero_title',
		array(
			'label'       => __( 'Hero heading (the H1)', 'plantgift-pro' ),
			'description' => __( 'Keep the main keyword near the front and stay under 70 characters where possible.', 'plantgift-pro' ),
			'section'     => 'plantgift_hero',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'plantgift_hero_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'plantgift_hero_text',
		array(
			'label'   => __( 'Hero paragraph', 'plantgift-pro' ),
			'section' => 'plantgift_hero',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'plantgift_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'plantgift_hero_image',
			array(
				'label'       => __( 'Hero image', 'plantgift-pro' ),
				'description' => __( 'Use a 1200 by 960 pixel photo of potted plants. Compress it before uploading.', 'plantgift-pro' ),
				'section'     => 'plantgift_hero',
			)
		)
	);

	$wp_customize->add_setting(
		'plantgift_header_cta_text',
		array(
			'default'           => __( 'Request a quote', 'plantgift-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'plantgift_header_cta_text',
		array(
			'label'   => __( 'Header button text', 'plantgift-pro' ),
			'section' => 'plantgift_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'plantgift_header_cta_url',
		array(
			'default'           => home_url( '/corporate-plant-gifting/' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'plantgift_header_cta_url',
		array(
			'label'   => __( 'Header button link', 'plantgift-pro' ),
			'section' => 'plantgift_hero',
			'type'    => 'url',
		)
	);

	/* Footer ----------------------------------------------------------- */

	$wp_customize->add_section(
		'plantgift_footer',
		array(
			'title' => __( 'Footer and social', 'plantgift-pro' ),
			'panel' => 'plantgift_panel',
		)
	);

	$wp_customize->add_setting(
		'plantgift_footer_about',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'plantgift_footer_about',
		array(
			'label'   => __( 'Footer description', 'plantgift-pro' ),
			'section' => 'plantgift_footer',
			'type'    => 'textarea',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting(
			'plantgift_footer_title_' . $i,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'plantgift_footer_title_' . $i,
			array(
				/* translators: %d: footer column number. */
				'label'   => sprintf( __( 'Footer column %d heading', 'plantgift-pro' ), $i ),
				'section' => 'plantgift_footer',
				'type'    => 'text',
			)
		);
	}

	foreach ( array( 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook' ) as $key => $label ) {
		$wp_customize->add_setting(
			'plantgift_social_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'plantgift_social_' . $key,
			array(
				'label'   => $label,
				'section' => 'plantgift_footer',
				'type'    => 'url',
			)
		);
	}

	/* Business schema -------------------------------------------------- */

	$wp_customize->add_section(
		'plantgift_schema',
		array(
			'title'       => __( 'Business information for search engines', 'plantgift-pro' ),
			'description' => __( 'These values feed the Organization and LocalBusiness structured data output.', 'plantgift-pro' ),
			'panel'       => 'plantgift_panel',
		)
	);

	$schema_fields = array(
		'plantgift_biz_legal_name' => __( 'Registered business name', 'plantgift-pro' ),
		'plantgift_biz_locality'   => __( 'City', 'plantgift-pro' ),
		'plantgift_biz_region'     => __( 'State', 'plantgift-pro' ),
		'plantgift_biz_postcode'   => __( 'Postal code', 'plantgift-pro' ),
		'plantgift_biz_country'    => __( 'Country code, for example IN', 'plantgift-pro' ),
		'plantgift_biz_price'      => __( 'Price range, for example 250 to 3500', 'plantgift-pro' ),
	);

	foreach ( $schema_fields as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $label,
				'section' => 'plantgift_schema',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'plantgift_pro_customize_register' );

/**
 * Live preview script for the title and tagline.
 */
function plantgift_pro_customize_preview_js() {
	wp_add_inline_script(
		'customize-preview',
		"( function( api ) {
			api( 'blogname', function( value ) {
				value.bind( function( to ) {
					var el = document.querySelector( '.pg-brand__name' );
					if ( el ) { el.textContent = to; }
				} );
			} );
			api( 'blogdescription', function( value ) {
				value.bind( function( to ) {
					var el = document.querySelector( '.pg-brand__tag' );
					if ( el ) { el.textContent = to; }
				} );
			} );
			api( 'plantgift_hero_title', function( value ) {
				value.bind( function( to ) {
					var el = document.querySelector( '.pg-hero h1' );
					if ( el ) { el.textContent = to; }
				} );
			} );
		} )( wp.customize );"
	);
}
add_action( 'customize_preview_init', 'plantgift_pro_customize_preview_js' );
