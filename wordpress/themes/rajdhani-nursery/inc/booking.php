<?php
/**
 * Online maali booking system.
 *
 * Registers the booking post type, the front end booking form shortcode
 * and the AJAX handler that saves bookings and emails the site admin.
 *
 * @package Rajdhani_Nursery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Maali Bookings post type (admin only, not public).
 */
function rn_register_booking_cpt() {
	register_post_type(
		'rn_booking',
		array(
			'labels'       => array(
				'name'          => __( 'Maali Bookings', 'rajdhani-nursery' ),
				'singular_name' => __( 'Maali Booking', 'rajdhani-nursery' ),
				'menu_name'     => __( 'Maali Bookings', 'rajdhani-nursery' ),
				'all_items'     => __( 'All Bookings', 'rajdhani-nursery' ),
				'edit_item'     => __( 'View Booking', 'rajdhani-nursery' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-calendar-alt',
			'supports'     => array( 'title' ),
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
		)
	);
}
add_action( 'init', 'rn_register_booking_cpt' );

/**
 * Booking form shortcode: [maali_booking_form]
 */
function rn_booking_form_shortcode() {
	$durations = rn_get_durations();
	$slots     = rn_get_time_slots();
	$min_date  = gmdate( 'Y-m-d', current_time( 'timestamp' ) + DAY_IN_SECONDS );

	ob_start();
	?>
	<div class="rn-booking-wrap" id="book-maali">
		<h3><?php esc_html_e( 'Book Your Maali Online', 'rajdhani-nursery' ); ?></h3>
		<p style="color:var(--rn-gray);font-size:.95rem;">
			<?php esc_html_e( 'Fill in the details below, choose your duration, then pick a date and time. We confirm every booking on call or WhatsApp.', 'rajdhani-nursery' ); ?>
		</p>
		<form id="rn-booking-form" novalidate>
			<div class="rn-form-grid">
				<div class="rn-form-field">
					<label for="rn-name"><?php esc_html_e( 'Full Name', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<input type="text" id="rn-name" name="name" required autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'rajdhani-nursery' ); ?>">
				</div>
				<div class="rn-form-field">
					<label for="rn-phone"><?php esc_html_e( 'Mobile Number', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<input type="tel" id="rn-phone" name="phone" required autocomplete="tel" inputmode="numeric" placeholder="10 digit mobile number" pattern="[0-9]{10}">
					<span class="rn-hint"><?php esc_html_e( 'We confirm your booking on this number.', 'rajdhani-nursery' ); ?></span>
				</div>
				<div class="rn-form-field">
					<label for="rn-email"><?php esc_html_e( 'Email (optional)', 'rajdhani-nursery' ); ?></label>
					<input type="email" id="rn-email" name="email" autocomplete="email" placeholder="you@example.com">
				</div>
				<div class="rn-form-field">
					<label for="rn-area"><?php esc_html_e( 'Area / Locality', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<input type="text" id="rn-area" name="area" required placeholder="<?php esc_attr_e( 'e.g. Saket, Dwarka, Noida', 'rajdhani-nursery' ); ?>">
				</div>
				<div class="rn-form-field rn-form-field-full">
					<label for="rn-address"><?php esc_html_e( 'Full Address', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<input type="text" id="rn-address" name="address" required autocomplete="street-address" placeholder="<?php esc_attr_e( 'House number, street, landmark', 'rajdhani-nursery' ); ?>">
				</div>
				<div class="rn-form-field rn-form-field-full">
					<label><?php esc_html_e( 'Choose Duration', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<div class="rn-duration-pills">
						<?php $first = true; foreach ( $durations as $key => $d ) : ?>
							<label class="rn-duration-pill">
								<input type="radio" name="duration" value="<?php echo esc_attr( $key ); ?>" <?php checked( $first ); ?>>
								<span><?php echo esc_html( $d['label'] ); ?><small>&#8377;<?php echo esc_html( number_format( $d['price'] ) ); ?></small></span>
							</label>
						<?php $first = false; endforeach; ?>
					</div>
					<div class="rn-price-preview" id="rn-price-preview"></div>
				</div>
				<div class="rn-form-field">
					<label for="rn-date"><?php esc_html_e( 'Select Date', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<input type="date" id="rn-date" name="date" required min="<?php echo esc_attr( $min_date ); ?>">
					<span class="rn-hint"><?php esc_html_e( 'Bookings open from tomorrow onwards.', 'rajdhani-nursery' ); ?></span>
				</div>
				<div class="rn-form-field">
					<label for="rn-time"><?php esc_html_e( 'Select Time Slot', 'rajdhani-nursery' ); ?> <span class="req">*</span></label>
					<select id="rn-time" name="time" required>
						<option value=""><?php esc_html_e( 'Choose a time', 'rajdhani-nursery' ); ?></option>
						<?php foreach ( $slots as $slot ) : ?>
							<option value="<?php echo esc_attr( $slot ); ?>"><?php echo esc_html( $slot ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="rn-form-field">
					<label for="rn-garden"><?php esc_html_e( 'Garden Type', 'rajdhani-nursery' ); ?></label>
					<select id="rn-garden" name="garden_type">
						<option value="Balcony / Terrace"><?php esc_html_e( 'Balcony / Terrace Garden', 'rajdhani-nursery' ); ?></option>
						<option value="Home Garden with Lawn"><?php esc_html_e( 'Home Garden with Lawn', 'rajdhani-nursery' ); ?></option>
						<option value="Farmhouse"><?php esc_html_e( 'Farmhouse', 'rajdhani-nursery' ); ?></option>
						<option value="Society / Apartment"><?php esc_html_e( 'Society / Apartment', 'rajdhani-nursery' ); ?></option>
						<option value="Office / Commercial"><?php esc_html_e( 'Office / Commercial', 'rajdhani-nursery' ); ?></option>
					</select>
				</div>
				<div class="rn-form-field">
					<label for="rn-service"><?php esc_html_e( 'Main Work Needed', 'rajdhani-nursery' ); ?></label>
					<select id="rn-service" name="service_needed">
						<option value="General Garden Care"><?php esc_html_e( 'General Garden Care', 'rajdhani-nursery' ); ?></option>
						<option value="Lawn Mowing"><?php esc_html_e( 'Lawn Mowing & Maintenance', 'rajdhani-nursery' ); ?></option>
						<option value="Pruning & Trimming"><?php esc_html_e( 'Pruning & Trimming', 'rajdhani-nursery' ); ?></option>
						<option value="Repotting & Soil Work"><?php esc_html_e( 'Repotting & Soil Work', 'rajdhani-nursery' ); ?></option>
						<option value="New Garden Setup"><?php esc_html_e( 'New Garden Setup', 'rajdhani-nursery' ); ?></option>
					</select>
				</div>
				<div class="rn-form-field rn-form-field-full">
					<label for="rn-notes"><?php esc_html_e( 'Any Special Instructions (optional)', 'rajdhani-nursery' ); ?></label>
					<textarea id="rn-notes" name="notes" rows="3" placeholder="<?php esc_attr_e( 'Tell us about your garden, number of pots, or anything specific', 'rajdhani-nursery' ); ?>"></textarea>
				</div>
			</div>
			<div style="margin-top:22px;">
				<button type="submit" class="rn-btn" id="rn-booking-submit"><?php esc_html_e( 'Confirm My Booking', 'rajdhani-nursery' ); ?></button>
			</div>
			<div class="rn-form-msg" id="rn-booking-msg" role="status" aria-live="polite"></div>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'maali_booking_form', 'rn_booking_form_shortcode' );

/**
 * AJAX handler: save the booking and notify the admin.
 */
function rn_handle_booking() {
	check_ajax_referer( 'rn_booking_nonce', 'nonce' );

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$phone   = preg_replace( '/\D/', '', sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$area    = sanitize_text_field( wp_unslash( $_POST['area'] ?? '' ) );
	$address = sanitize_text_field( wp_unslash( $_POST['address'] ?? '' ) );
	$date    = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
	$time    = sanitize_text_field( wp_unslash( $_POST['time'] ?? '' ) );
	$garden  = sanitize_text_field( wp_unslash( $_POST['garden_type'] ?? '' ) );
	$service = sanitize_text_field( wp_unslash( $_POST['service_needed'] ?? '' ) );
	$notes   = sanitize_textarea_field( wp_unslash( $_POST['notes'] ?? '' ) );

	$durations = rn_get_durations();
	$duration  = sanitize_text_field( wp_unslash( $_POST['duration'] ?? '' ) );

	if ( ! $name || ! $area || ! $address ) {
		wp_send_json_error( array( 'message' => __( 'Please fill your name, area and address.', 'rajdhani-nursery' ) ) );
	}
	if ( strlen( $phone ) < 10 ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid 10 digit mobile number.', 'rajdhani-nursery' ) ) );
	}
	if ( ! isset( $durations[ $duration ] ) ) {
		wp_send_json_error( array( 'message' => __( 'Please choose a booking duration.', 'rajdhani-nursery' ) ) );
	}
	if ( ! $time ) {
		wp_send_json_error( array( 'message' => __( 'Please choose a time slot.', 'rajdhani-nursery' ) ) );
	}

	$date_obj = $date ? DateTime::createFromFormat( 'Y-m-d', $date ) : false;
	$today    = new DateTime( current_time( 'Y-m-d' ) );
	if ( ! $date_obj || $date_obj <= $today ) {
		wp_send_json_error( array( 'message' => __( 'Please choose a valid date from tomorrow onwards.', 'rajdhani-nursery' ) ) );
	}

	$duration_label = $durations[ $duration ]['label'];
	$price          = $durations[ $duration ]['price'];
	$nice_date      = $date_obj->format( 'd M Y (l)' );

	$booking_id = wp_insert_post(
		array(
			'post_type'   => 'rn_booking',
			'post_status' => 'publish',
			'post_title'  => sprintf( '%s | %s | %s %s', $name, $duration_label, $nice_date, $time ),
			'meta_input'  => array(
				'_rn_name'     => $name,
				'_rn_phone'    => $phone,
				'_rn_email'    => $email,
				'_rn_area'     => $area,
				'_rn_address'  => $address,
				'_rn_date'     => $date,
				'_rn_time'     => $time,
				'_rn_duration' => $duration_label,
				'_rn_price'    => $price,
				'_rn_garden'   => $garden,
				'_rn_service'  => $service,
				'_rn_notes'    => $notes,
				'_rn_status'   => 'pending',
			),
		),
		true
	);

	if ( is_wp_error( $booking_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Something went wrong. Please try again or message us on WhatsApp.', 'rajdhani-nursery' ) ) );
	}

	// Notify the site admin by email.
	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( __( 'New Maali Booking #%1$d from %2$s', 'rajdhani-nursery' ), $booking_id, $name );
	$body        = sprintf(
		"New maali booking received on %s\n\nName: %s\nPhone: %s\nEmail: %s\nArea: %s\nAddress: %s\nDate: %s\nTime: %s\nDuration: %s\nEstimated Price: Rs %s\nGarden Type: %s\nWork Needed: %s\nNotes: %s\n\nView in dashboard: %s",
		get_bloginfo( 'name' ), $name, $phone, $email ? $email : 'Not given', $area, $address,
		$nice_date, $time, $duration_label, number_format( $price ), $garden, $service,
		$notes ? $notes : 'None',
		admin_url( 'edit.php?post_type=rn_booking' )
	);
	wp_mail( $admin_email, $subject, $body );

	$wa_message = sprintf(
		'Hello Rajdhani Nursery, I just booked a maali online. Booking ID %d, Name %s, %s on %s at %s. Please confirm.',
		$booking_id, $name, $duration_label, $nice_date, $time
	);

	wp_send_json_success(
		array(
			'message' => sprintf(
				/* translators: 1: booking id, 2: duration, 3: date, 4: time */
				__( 'Booking received! Your booking ID is #%1$d for %2$s on %3$s at %4$s. Our team will call you shortly to confirm.', 'rajdhani-nursery' ),
				$booking_id, $duration_label, $nice_date, $time
			),
			'waLink'  => rn_whatsapp_link( $wa_message ),
		)
	);
}
add_action( 'wp_ajax_rn_book_maali', 'rn_handle_booking' );
add_action( 'wp_ajax_nopriv_rn_book_maali', 'rn_handle_booking' );

/**
 * Admin list columns for bookings.
 */
function rn_booking_columns( $columns ) {
	return array(
		'cb'          => $columns['cb'],
		'title'       => __( 'Booking', 'rajdhani-nursery' ),
		'rn_phone'    => __( 'Phone', 'rajdhani-nursery' ),
		'rn_area'     => __( 'Area', 'rajdhani-nursery' ),
		'rn_datetime' => __( 'Visit Date & Time', 'rajdhani-nursery' ),
		'rn_duration' => __( 'Duration', 'rajdhani-nursery' ),
		'rn_price'    => __( 'Price', 'rajdhani-nursery' ),
		'date'        => __( 'Received', 'rajdhani-nursery' ),
	);
}
add_filter( 'manage_rn_booking_posts_columns', 'rn_booking_columns' );

function rn_booking_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'rn_phone':
			$phone = get_post_meta( $post_id, '_rn_phone', true );
			printf( '<a href="tel:%1$s">%1$s</a>', esc_html( $phone ) );
			break;
		case 'rn_area':
			echo esc_html( get_post_meta( $post_id, '_rn_area', true ) );
			break;
		case 'rn_datetime':
			echo esc_html( get_post_meta( $post_id, '_rn_date', true ) . ' at ' . get_post_meta( $post_id, '_rn_time', true ) );
			break;
		case 'rn_duration':
			echo esc_html( get_post_meta( $post_id, '_rn_duration', true ) );
			break;
		case 'rn_price':
			echo '&#8377;' . esc_html( number_format( (float) get_post_meta( $post_id, '_rn_price', true ) ) );
			break;
	}
}
add_action( 'manage_rn_booking_posts_custom_column', 'rn_booking_column_content', 10, 2 );

/**
 * Booking details metabox on the booking edit screen.
 */
function rn_booking_metabox() {
	add_meta_box( 'rn_booking_details', __( 'Booking Details', 'rajdhani-nursery' ), 'rn_booking_metabox_render', 'rn_booking', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'rn_booking_metabox' );

function rn_booking_metabox_render( $post ) {
	$fields = array(
		'_rn_name'     => __( 'Name', 'rajdhani-nursery' ),
		'_rn_phone'    => __( 'Phone', 'rajdhani-nursery' ),
		'_rn_email'    => __( 'Email', 'rajdhani-nursery' ),
		'_rn_area'     => __( 'Area', 'rajdhani-nursery' ),
		'_rn_address'  => __( 'Address', 'rajdhani-nursery' ),
		'_rn_date'     => __( 'Date', 'rajdhani-nursery' ),
		'_rn_time'     => __( 'Time', 'rajdhani-nursery' ),
		'_rn_duration' => __( 'Duration', 'rajdhani-nursery' ),
		'_rn_price'    => __( 'Estimated Price (Rs)', 'rajdhani-nursery' ),
		'_rn_garden'   => __( 'Garden Type', 'rajdhani-nursery' ),
		'_rn_service'  => __( 'Work Needed', 'rajdhani-nursery' ),
		'_rn_notes'    => __( 'Notes', 'rajdhani-nursery' ),
	);
	echo '<table class="widefat striped">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf( '<tr><th style="width:200px;text-align:left;">%s</th><td>%s</td></tr>', esc_html( $label ), esc_html( $value ? $value : 'Not given' ) );
	}
	echo '</table>';
}
