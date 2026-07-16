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

	// Team members shown on the homepage team section.
	register_post_type(
		'ktn_team',
		array(
			'labels'              => array(
				'name'          => __( 'Team Members', 'ktn-core' ),
				'singular_name' => __( 'Team Member', 'ktn-core' ),
				'add_new_item'  => __( 'Add Team Member', 'ktn-core' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'menu_icon'           => 'dashicons-groups',
			'menu_position'       => 7,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			'exclude_from_search' => true,
		)
	);

	// Client testimonials shown in the homepage slider.
	register_post_type(
		'ktn_testimonial',
		array(
			'labels'              => array(
				'name'          => __( 'Testimonials', 'ktn-core' ),
				'singular_name' => __( 'Testimonial', 'ktn-core' ),
				'add_new_item'  => __( 'Add Testimonial', 'ktn-core' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'menu_icon'           => 'dashicons-format-quote',
			'menu_position'       => 8,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'exclude_from_search' => true,
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
	add_meta_box( 'ktn_team_details', __( 'Member Details', 'ktn-core' ), 'ktn_team_metabox', 'ktn_team', 'normal', 'high' );
	add_meta_box( 'ktn_testimonial_details', __( 'Client Details', 'ktn-core' ), 'ktn_testimonial_metabox', 'ktn_testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ktn_add_service_metaboxes' );

/**
 * Testimonial metabox: title is the client name, editor is the quote.
 */
function ktn_testimonial_metabox( $post ) {
	wp_nonce_field( 'ktn_testimonial_meta', 'ktn_testimonial_meta_nonce' );
	$role   = get_post_meta( $post->ID, '_ktn_role', true );
	$rating = (int) get_post_meta( $post->ID, '_ktn_rating', true );
	if ( $rating < 1 || $rating > 5 ) {
		$rating = 5;
	}
	printf(
		'<p><label for="_ktn_role"><strong>%s</strong></label></p><input type="text" class="large-text" id="_ktn_role" name="_ktn_role" value="%s" placeholder="%s">',
		esc_html__( 'Designation and company / city', 'ktn-core' ),
		esc_attr( $role ),
		esc_attr__( 'e.g. Founder, Aarav Foods, Delhi', 'ktn-core' )
	);
	echo '<p><label for="_ktn_rating"><strong>' . esc_html__( 'Star rating', 'ktn-core' ) . '</strong></label></p><select id="_ktn_rating" name="_ktn_rating">';
	for ( $i = 5; $i >= 1; $i-- ) {
		printf( '<option value="%1$d" %2$s>%1$d / 5</option>', (int) $i, selected( $rating, $i, false ) );
	}
	echo '</select><p class="description">' . esc_html__( 'The quote goes in the main editor above. An optional client photo can be set as the Featured Image; otherwise an initials avatar is shown.', 'ktn-core' ) . '</p>';
}

function ktn_save_testimonial_meta( $post_id ) {
	if ( ! isset( $_POST['ktn_testimonial_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ktn_testimonial_meta_nonce'] ), 'ktn_testimonial_meta' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['_ktn_role'] ) ) {
		update_post_meta( $post_id, '_ktn_role', sanitize_text_field( wp_unslash( $_POST['_ktn_role'] ) ) );
	}
	if ( isset( $_POST['_ktn_rating'] ) ) {
		update_post_meta( $post_id, '_ktn_rating', max( 1, min( 5, (int) $_POST['_ktn_rating'] ) ) );
	}
}
add_action( 'save_post_ktn_testimonial', 'ktn_save_testimonial_meta' );

/**
 * Team member metabox: designation shown under the name.
 */
function ktn_team_metabox( $post ) {
	wp_nonce_field( 'ktn_team_meta', 'ktn_team_meta_nonce' );
	$role = get_post_meta( $post->ID, '_ktn_role', true );
	printf(
		'<p><label for="_ktn_role"><strong>%s</strong></label></p><input type="text" class="large-text" id="_ktn_role" name="_ktn_role" value="%s" placeholder="%s"><p class="description">%s</p>',
		esc_html__( 'Designation', 'ktn-core' ),
		esc_attr( $role ),
		esc_attr__( 'e.g. Founder and Managing Partner', 'ktn-core' ),
		esc_html__( 'Set the photo using the Featured Image box. Without a photo, an initials avatar is shown automatically.', 'ktn-core' )
	);
}

function ktn_save_team_meta( $post_id ) {
	if ( ! isset( $_POST['ktn_team_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ktn_team_meta_nonce'] ), 'ktn_team_meta' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['_ktn_role'] ) ) {
		update_post_meta( $post_id, '_ktn_role', sanitize_text_field( wp_unslash( $_POST['_ktn_role'] ) ) );
	}
}
add_action( 'save_post_ktn_team', 'ktn_save_team_meta' );

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
