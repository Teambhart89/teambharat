<?php
/**
 * Service post type, service category taxonomy and enquiry post type.
 *
 * URL structure (SEO friendly):
 *  - Single service:   /services/gst-registration/
 *  - Category archive: /ca-services/gst-services/  (redirect friendly, short, keyword rich)
 *  - All services:     /services/
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ktn_register_post_types() {

	register_taxonomy(
		'service_category',
		array( 'service' ),
		array(
			'labels'            => array(
				'name'          => __( 'Service Categories', 'ktn-core' ),
				'singular_name' => __( 'Service Category', 'ktn-core' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'ca-services',
				'with_front' => false,
			),
		)
	);

	register_post_type(
		'service',
		array(
			'labels'       => array(
				'name'          => __( 'Services', 'ktn-core' ),
				'singular_name' => __( 'Service', 'ktn-core' ),
				'add_new_item'  => __( 'Add New Service', 'ktn-core' ),
				'edit_item'     => __( 'Edit Service', 'ktn-core' ),
			),
			'public'       => true,
			'menu_icon'    => 'dashicons-portfolio',
			'menu_position'=> 5,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'has_archive'  => 'services',
			'show_in_rest' => true,
			'rewrite'      => array(
				'slug'       => 'services',
				'with_front' => false,
			),
		)
	);

	// Enquiries submitted from service forms. Not public.
	register_post_type(
		'ktn_enquiry',
		array(
			'labels'              => array(
				'name'          => __( 'Enquiries', 'ktn-core' ),
				'singular_name' => __( 'Enquiry', 'ktn-core' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 6,
			'supports'            => array( 'title' ),
			'capability_type'     => 'post',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'ktn_register_post_types' );

/**
 * Service meta boxes: SEO fields, FAQ list, quick facts.
 */
function ktn_add_service_metaboxes() {
	add_meta_box( 'ktn_service_seo', __( 'SEO and Service Details', 'ktn-core' ), 'ktn_service_seo_metabox', 'service', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ktn_add_service_metaboxes' );

function ktn_service_seo_metabox( $post ) {
	wp_nonce_field( 'ktn_service_meta', 'ktn_service_meta_nonce' );
	$fields = array(
		'_ktn_meta_title'       => __( 'Meta title (max 60 characters)', 'ktn-core' ),
		'_ktn_meta_description' => __( 'Meta description (max 160 characters)', 'ktn-core' ),
		'_ktn_focus_keywords'   => __( 'Focus keywords (comma separated)', 'ktn-core' ),
		'_ktn_timeline'         => __( 'Typical timeline (e.g. 5 to 7 working days)', 'ktn-core' ),
		'_ktn_authority'        => __( 'Governing authority (e.g. MCA, CBIC)', 'ktn-core' ),
		'_ktn_price_note'       => __( 'Price note shown on page (optional)', 'ktn-core' ),
	);
	echo '<table class="form-table">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input type="text" class="large-text" id="%1$s" name="%1$s" value="%3$s"></td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	$faqs = get_post_meta( $post->ID, '_ktn_faqs', true );
	printf(
		'<tr><th scope="row"><label for="_ktn_faqs">%s</label></th><td><textarea class="large-text" rows="12" id="_ktn_faqs" name="_ktn_faqs">%s</textarea><p class="description">%s</p></td></tr>',
		esc_html__( 'FAQs (JSON array of {"q":"...","a":"..."})', 'ktn-core' ),
		esc_textarea( is_string( $faqs ) ? $faqs : wp_json_encode( $faqs, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) ),
		esc_html__( 'These render as an accordion with FAQPage structured data.', 'ktn-core' )
	);
	echo '</table>';
}

function ktn_save_service_meta( $post_id ) {
	if ( ! isset( $_POST['ktn_service_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ktn_service_meta_nonce'] ), 'ktn_service_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$text_fields = array( '_ktn_meta_title', '_ktn_meta_description', '_ktn_focus_keywords', '_ktn_timeline', '_ktn_authority', '_ktn_price_note' );
	foreach ( $text_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
	if ( isset( $_POST['_ktn_faqs'] ) ) {
		$raw     = trim( wp_unslash( $_POST['_ktn_faqs'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$decoded = json_decode( $raw, true );
		if ( is_array( $decoded ) ) {
			$clean = array();
			foreach ( $decoded as $faq ) {
				if ( ! empty( $faq['q'] ) && ! empty( $faq['a'] ) ) {
					$clean[] = array(
						'q' => sanitize_text_field( $faq['q'] ),
						'a' => wp_kses_post( $faq['a'] ),
					);
				}
			}
			update_post_meta( $post_id, '_ktn_faqs', $clean );
		}
	}
}
add_action( 'save_post_service', 'ktn_save_service_meta' );

/**
 * Helper: FAQs for a service as array.
 */
function ktn_get_service_faqs( $post_id ) {
	$faqs = get_post_meta( $post_id, '_ktn_faqs', true );
	if ( is_string( $faqs ) ) {
		$faqs = json_decode( $faqs, true );
	}
	return is_array( $faqs ) ? $faqs : array();
}
