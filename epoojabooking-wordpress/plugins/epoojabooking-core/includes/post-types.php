<?php
/**
 * Custom post types: pujas catalogue and bookings.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register post types.
 */
function epb_register_post_types() {
	register_post_type( 'epb_puja', array(
		'labels' => array(
			'name'          => __( 'Pujas', 'epoojabooking-core' ),
			'singular_name' => __( 'Puja', 'epoojabooking-core' ),
			'add_new_item'  => __( 'Add New Puja', 'epoojabooking-core' ),
			'edit_item'     => __( 'Edit Puja', 'epoojabooking-core' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'pujas' ),
		'menu_icon'    => 'dashicons-star-filled',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'epb_temple', array(
		'labels' => array(
			'name'          => __( 'Temples', 'epoojabooking-core' ),
			'singular_name' => __( 'Temple', 'epoojabooking-core' ),
			'add_new_item'  => __( 'Add New Temple', 'epoojabooking-core' ),
			'edit_item'     => __( 'Edit Temple', 'epoojabooking-core' ),
		),
		'public'       => true,
		'has_archive'  => 'temples',
		'rewrite'      => array( 'slug' => 'temples' ),
		'menu_icon'    => 'dashicons-admin-multisite',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'show_in_rest' => true,
	) );

	register_post_type( 'epb_booking', array(
		'labels' => array(
			'name'          => __( 'Bookings', 'epoojabooking-core' ),
			'singular_name' => __( 'Booking', 'epoojabooking-core' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'menu_icon'           => 'dashicons-calendar-alt',
		'supports'            => array( 'title', 'custom-fields' ),
		'capability_type'     => 'post',
		'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'        => true,
	) );
}
add_action( 'init', 'epb_register_post_types' );

/**
 * Admin columns for bookings.
 *
 * @param array $columns Columns.
 * @return array
 */
function epb_booking_columns( $columns ) {
	return array(
		'cb'          => $columns['cb'],
		'title'       => __( 'Booking', 'epoojabooking-core' ),
		'epb_service' => __( 'Service', 'epoojabooking-core' ),
		'epb_date'    => __( 'Preferred Date', 'epoojabooking-core' ),
		'epb_phone'   => __( 'Phone / WhatsApp', 'epoojabooking-core' ),
		'epb_status'  => __( 'Payment', 'epoojabooking-core' ),
		'date'        => __( 'Received', 'epoojabooking-core' ),
	);
}
add_filter( 'manage_epb_booking_posts_columns', 'epb_booking_columns' );

/**
 * Render booking columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function epb_booking_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'epb_service':
			echo esc_html( get_post_meta( $post_id, 'epb_service', true ) );
			break;
		case 'epb_date':
			echo esc_html( get_post_meta( $post_id, 'epb_preferred_date', true ) );
			break;
		case 'epb_phone':
			echo esc_html( get_post_meta( $post_id, 'epb_phone', true ) );
			break;
		case 'epb_status':
			$status = get_post_meta( $post_id, 'epb_payment_status', true );
			echo esc_html( $status ? $status : __( 'pending', 'epoojabooking-core' ) );
			break;
	}
}
add_action( 'manage_epb_booking_posts_custom_column', 'epb_booking_column_content', 10, 2 );

/**
 * Temple details metabox.
 */
function epb_temple_metabox() {
	add_meta_box( 'epb-temple-details', __( 'Temple Details', 'epoojabooking-core' ), 'epb_temple_metabox_render', 'epb_temple', 'side' );
}
add_action( 'add_meta_boxes', 'epb_temple_metabox' );

/**
 * Render the temple details metabox.
 *
 * @param WP_Post $post Current post.
 */
function epb_temple_metabox_render( $post ) {
	wp_nonce_field( 'epb_temple_details', 'epb_temple_nonce' );
	$fields = array(
		'epb_city'            => __( 'City', 'epoojabooking-core' ),
		'epb_state'           => __( 'State', 'epoojabooking-core' ),
		'epb_deity'           => __( 'Main Deity', 'epoojabooking-core' ),
		'epb_darshan_timings' => __( 'Darshan Timings', 'epoojabooking-core' ),
		'epb_aarti_timings'   => __( 'Aarti Timings', 'epoojabooking-core' ),
	);
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p><label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br>';
		echo '<input type="text" class="widefat" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"></p>';
	}
}

/**
 * Save temple details.
 *
 * @param int $post_id Post ID.
 */
function epb_temple_metabox_save( $post_id ) {
	if ( ! isset( $_POST['epb_temple_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['epb_temple_nonce'] ), 'epb_temple_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array( 'epb_city', 'epb_state', 'epb_deity', 'epb_darshan_timings', 'epb_aarti_timings' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_epb_temple', 'epb_temple_metabox_save' );
