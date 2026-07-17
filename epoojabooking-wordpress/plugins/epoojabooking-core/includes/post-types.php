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

	// Filterable attributes for pujas.
	$epb_taxonomies = array(
		'epb_deity'    => array( __( 'Deities', 'epoojabooking-core' ), __( 'Deity', 'epoojabooking-core' ), 'puja-deity' ),
		'epb_tithi'    => array( __( 'Tithis', 'epoojabooking-core' ), __( 'Tithi', 'epoojabooking-core' ), 'puja-tithi' ),
		'epb_dosha'    => array( __( 'Doshas', 'epoojabooking-core' ), __( 'Dosha', 'epoojabooking-core' ), 'puja-dosha' ),
		'epb_benefit'  => array( __( 'Benefits', 'epoojabooking-core' ), __( 'Benefit', 'epoojabooking-core' ), 'puja-benefit' ),
		'epb_location' => array( __( 'Locations', 'epoojabooking-core' ), __( 'Location', 'epoojabooking-core' ), 'puja-location' ),
	);
	foreach ( $epb_taxonomies as $taxonomy => $labels ) {
		register_taxonomy( $taxonomy, 'epb_puja', array(
			'labels' => array(
				'name'          => $labels[0],
				'singular_name' => $labels[1],
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => $labels[2] ),
		) );
	}

	register_post_type( 'epb_banner', array(
		'labels' => array(
			'name'          => __( 'Banners', 'epoojabooking-core' ),
			'singular_name' => __( 'Banner', 'epoojabooking-core' ),
			'add_new_item'  => __( 'Add New Banner', 'epoojabooking-core' ),
			'edit_item'     => __( 'Edit Banner', 'epoojabooking-core' ),
			'featured_image'        => __( 'Banner Image', 'epoojabooking-core' ),
			'set_featured_image'    => __( 'Set banner image', 'epoojabooking-core' ),
			'remove_featured_image' => __( 'Remove banner image', 'epoojabooking-core' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'menu_icon'           => 'dashicons-images-alt2',
		'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
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

/**
 * Banner and Special Puja metaboxes.
 */
function epb_banner_puja_metaboxes() {
	add_meta_box( 'epb-banner-details', __( 'Banner Content', 'epoojabooking-core' ), 'epb_banner_metabox_render', 'epb_banner', 'normal' );
	add_meta_box( 'epb-puja-details', __( 'Special Puja Details', 'epoojabooking-core' ), 'epb_puja_metabox_render', 'epb_puja', 'side' );
}
add_action( 'add_meta_boxes', 'epb_banner_puja_metaboxes' );

/**
 * Banner metabox fields.
 *
 * @param WP_Post $post Current post.
 */
function epb_banner_metabox_render( $post ) {
	wp_nonce_field( 'epb_banner_details', 'epb_banner_nonce' );
	$subtitle = get_post_meta( $post->ID, 'epb_subtitle', true );
	$btn_text = get_post_meta( $post->ID, 'epb_btn_text', true );
	$btn_url  = get_post_meta( $post->ID, 'epb_btn_url', true );
	?>
	<p><em><?php esc_html_e( 'The banner title above is the big headline. Set the background photo with the Banner Image box. Order slides with the Order attribute.', 'epoojabooking-core' ); ?></em></p>
	<p><label for="epb_subtitle"><strong><?php esc_html_e( 'Supporting Text', 'epoojabooking-core' ); ?></strong></label>
	<textarea class="widefat" rows="2" id="epb_subtitle" name="epb_subtitle"><?php echo esc_textarea( $subtitle ); ?></textarea></p>
	<p><label for="epb_btn_text"><strong><?php esc_html_e( 'Button Label', 'epoojabooking-core' ); ?></strong></label>
	<input type="text" class="widefat" id="epb_btn_text" name="epb_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="Book Puja"></p>
	<p><label for="epb_btn_url"><strong><?php esc_html_e( 'Button Link', 'epoojabooking-core' ); ?></strong></label>
	<input type="text" class="widefat" id="epb_btn_url" name="epb_btn_url" value="<?php echo esc_attr( $btn_url ); ?>" placeholder="/online-puja-booking/"></p>
	<?php
}

/**
 * Special puja metabox fields.
 *
 * @param WP_Post $post Current post.
 */
function epb_puja_metabox_render( $post ) {
	wp_nonce_field( 'epb_puja_details', 'epb_puja_nonce' );
	$fields = array(
		'epb_badge'       => array( __( 'Badge Label', 'epoojabooking-core' ), __( 'e.g. Shravan Special', 'epoojabooking-core' ) ),
		'epb_temple_name' => array( __( 'Temple / Location', 'epoojabooking-core' ), __( 'e.g. Mahakaleshwar, Ujjain', 'epoojabooking-core' ) ),
		'epb_event_date'  => array( __( 'Puja Date', 'epoojabooking-core' ), __( 'e.g. 21 July, Tuesday', 'epoojabooking-core' ) ),
		'epb_price'       => array( __( 'Starting Price', 'epoojabooking-core' ), __( 'e.g. ₹1,100', 'epoojabooking-core' ) ),
	);
	echo '<p><em>' . esc_html__( 'Set the card photo using the Featured Image box.', 'epoojabooking-core' ) . '</em></p>';
	foreach ( $fields as $key => $labels ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p><label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $labels[0] ) . '</strong></label><br>';
		echo '<input type="text" class="widefat" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $labels[1] ) . '"></p>';
	}
}

/**
 * Save banner fields.
 *
 * @param int $post_id Post ID.
 */
function epb_banner_metabox_save( $post_id ) {
	if ( ! isset( $_POST['epb_banner_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['epb_banner_nonce'] ), 'epb_banner_details' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['epb_subtitle'] ) ) {
		update_post_meta( $post_id, 'epb_subtitle', sanitize_textarea_field( wp_unslash( $_POST['epb_subtitle'] ) ) );
	}
	if ( isset( $_POST['epb_btn_text'] ) ) {
		update_post_meta( $post_id, 'epb_btn_text', sanitize_text_field( wp_unslash( $_POST['epb_btn_text'] ) ) );
	}
	if ( isset( $_POST['epb_btn_url'] ) ) {
		update_post_meta( $post_id, 'epb_btn_url', sanitize_text_field( wp_unslash( $_POST['epb_btn_url'] ) ) );
	}
}
add_action( 'save_post_epb_banner', 'epb_banner_metabox_save' );

/**
 * Save special puja fields.
 *
 * @param int $post_id Post ID.
 */
function epb_puja_metabox_save( $post_id ) {
	if ( ! isset( $_POST['epb_puja_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['epb_puja_nonce'] ), 'epb_puja_details' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array( 'epb_badge', 'epb_temple_name', 'epb_event_date', 'epb_price' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_epb_puja', 'epb_puja_metabox_save' );
