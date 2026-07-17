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
