<?php
/**
 * Booking form shortcode and AJAX handlers.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Service choices offered in the form.
 *
 * @return array
 */
function epb_service_choices() {
	return array(
		'online-puja'      => __( 'Online Puja at Temple', 'epoojabooking-core' ),
		'chadhava'         => __( 'Chadhava / Temple Offering', 'epoojabooking-core' ),
		'abhishek'         => __( 'Abhishek (Rudrabhishek, Dudh Abhishek)', 'epoojabooking-core' ),
		'havan'            => __( 'Havan / Homam', 'epoojabooking-core' ),
		'pandit'           => __( 'Pandit Ji for Puja at Home', 'epoojabooking-core' ),
		'astrology'        => __( 'Astrology Consultation', 'epoojabooking-core' ),
		'festival-special' => __( 'Festival Special Puja', 'epoojabooking-core' ),
	);
}

/**
 * [epb_booking_form] shortcode.
 *
 * @return string
 */
function epb_booking_form_shortcode() {
	wp_enqueue_style( 'epb-booking' );
	wp_enqueue_script( 'epb-booking' );
	if ( epb_razorpay_enabled() ) {
		wp_enqueue_script( 'epb-razorpay' );
	}

	$services = epb_service_choices();

	ob_start();
	?>
	<form class="epb-form epb-booking-form" novalidate>
		<div class="epb-form-msg" role="status" aria-live="polite" hidden></div>

		<p class="epb-field">
			<label for="epb-service"><?php esc_html_e( 'Select Seva', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
			<select id="epb-service" name="service" required>
				<?php foreach ( $services as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<div class="epb-form-row">
			<p class="epb-field">
				<label for="epb-name"><?php esc_html_e( 'Devotee Name', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
				<input id="epb-name" name="name" type="text" autocomplete="name" required>
			</p>
			<p class="epb-field">
				<label for="epb-date"><?php esc_html_e( 'Preferred Date', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
				<input id="epb-date" name="preferred_date" type="date" required>
			</p>
		</div>

		<div class="epb-form-row">
			<p class="epb-field">
				<label for="epb-email"><?php esc_html_e( 'Email', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
				<input id="epb-email" name="email" type="email" autocomplete="email" required>
			</p>
			<p class="epb-field">
				<label for="epb-phone"><?php esc_html_e( 'Phone / WhatsApp', 'epoojabooking-core' ); ?> <span class="epb-required" aria-hidden="true">*</span></label>
				<input id="epb-phone" name="phone" type="tel" autocomplete="tel" required>
				<span class="epb-help"><?php esc_html_e( 'Include country code for international numbers.', 'epoojabooking-core' ); ?></span>
			</p>
		</div>

		<div class="epb-form-row">
			<p class="epb-field">
				<label for="epb-gotra"><?php esc_html_e( 'Gotra', 'epoojabooking-core' ); ?></label>
				<input id="epb-gotra" name="gotra" type="text">
				<span class="epb-help"><?php esc_html_e( 'Leave blank if unknown. Kashyap gotra is used as per tradition.', 'epoojabooking-core' ); ?></span>
			</p>
			<p class="epb-field">
				<label for="epb-nakshatra"><?php esc_html_e( 'Nakshatra', 'epoojabooking-core' ); ?></label>
				<input id="epb-nakshatra" name="nakshatra" type="text">
			</p>
		</div>

		<p class="epb-field">
			<label for="epb-sankalp"><?php esc_html_e( 'Sankalp / Prayer Intention', 'epoojabooking-core' ); ?></label>
			<textarea id="epb-sankalp" name="sankalp" rows="3"></textarea>
			<span class="epb-help"><?php esc_html_e( 'Tell us the wish or purpose for this puja, for example health, career or family harmony.', 'epoojabooking-core' ); ?></span>
		</p>

		<p class="epb-field">
			<label for="epb-address"><?php esc_html_e( 'Prasad Delivery Address', 'epoojabooking-core' ); ?></label>
			<textarea id="epb-address" name="prasad_address" rows="3" autocomplete="street-address"></textarea>
			<span class="epb-help"><?php esc_html_e( 'We deliver prasad across India and internationally.', 'epoojabooking-core' ); ?></span>
		</p>

		<p class="epb-check">
			<input id="epb-live" name="live_stream" type="checkbox" value="yes">
			<label for="epb-live"><?php esc_html_e( 'I would like a live streaming link to watch my puja', 'epoojabooking-core' ); ?></label>
		</p>

		<p class="epb-hp" aria-hidden="true"><label>Leave this field empty<input type="text" name="epb_website" tabindex="-1" autocomplete="off"></label></p>

		<button type="submit" class="epb-btn epb-btn-primary"><?php esc_html_e( 'Request Booking', 'epoojabooking-core' ); ?></button>
		<p class="epb-help epb-secure-note"><?php esc_html_e( 'Secure booking. Payments via UPI, cards and net banking. Details are shared after confirmation.', 'epoojabooking-core' ); ?></p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'epb_booking_form', 'epb_booking_form_shortcode' );

/**
 * AJAX: create a booking.
 */
function epb_ajax_create_booking() {
	check_ajax_referer( 'epb_booking', 'nonce' );

	// Honeypot.
	if ( ! empty( $_POST['epb_website'] ) ) {
		wp_send_json_error( array( 'message' => 'Invalid submission.' ), 400 );
	}

	$services = epb_service_choices();

	$service   = isset( $_POST['service'] ) ? sanitize_key( wp_unslash( $_POST['service'] ) ) : '';
	$name      = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone     = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$date      = isset( $_POST['preferred_date'] ) ? sanitize_text_field( wp_unslash( $_POST['preferred_date'] ) ) : '';
	$gotra     = isset( $_POST['gotra'] ) ? sanitize_text_field( wp_unslash( $_POST['gotra'] ) ) : '';
	$nakshatra = isset( $_POST['nakshatra'] ) ? sanitize_text_field( wp_unslash( $_POST['nakshatra'] ) ) : '';
	$sankalp   = isset( $_POST['sankalp'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sankalp'] ) ) : '';
	$address   = isset( $_POST['prasad_address'] ) ? sanitize_textarea_field( wp_unslash( $_POST['prasad_address'] ) ) : '';
	$live      = isset( $_POST['live_stream'] ) && 'yes' === $_POST['live_stream'] ? 'yes' : 'no';

	if ( ! isset( $services[ $service ] ) || ! $name || ! is_email( $email ) || ! $phone || ! $date ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields with valid details.', 'epoojabooking-core' ) ), 400 );
	}

	$booking_id = wp_insert_post( array(
		'post_type'   => 'epb_booking',
		'post_status' => 'private',
		'post_title'  => sprintf( '%s – %s – %s', $services[ $service ], $name, $date ),
	), true );

	if ( is_wp_error( $booking_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Could not save the booking. Please try again.', 'epoojabooking-core' ) ), 500 );
	}

	$meta = array(
		'epb_service'        => $services[ $service ],
		'epb_service_key'    => $service,
		'epb_name'           => $name,
		'epb_email'          => $email,
		'epb_phone'          => $phone,
		'epb_preferred_date' => $date,
		'epb_gotra'          => $gotra,
		'epb_nakshatra'      => $nakshatra,
		'epb_sankalp'        => $sankalp,
		'epb_prasad_address' => $address,
		'epb_live_stream'    => $live,
		'epb_payment_status' => 'pending',
	);
	foreach ( $meta as $key => $value ) {
		update_post_meta( $booking_id, $key, $value );
	}

	// Notify admin.
	$notify = epb_get_option( 'notify_email', get_option( 'admin_email' ) );
	$lines  = array();
	foreach ( $meta as $key => $value ) {
		$lines[] = str_replace( 'epb_', '', $key ) . ': ' . $value;
	}
	wp_mail(
		$notify,
		sprintf( '[epoojabooking] New booking: %s', $services[ $service ] ),
		implode( "\n", $lines )
	);

	// Confirm to devotee.
	wp_mail(
		$email,
		__( 'Namaste! We received your booking request', 'epoojabooking-core' ),
		sprintf(
			/* translators: 1: name, 2: service, 3: date */
			__( "Namaste %1\$s,\n\nThank you for choosing epoojabooking. We have received your request for %2\$s on %3\$s.\n\nOur team will confirm your booking on WhatsApp and email shortly. If you selected live streaming, the link will be shared before the puja.\n\nHar Har Mahadev,\nTeam epoojabooking\nhttps://epoojabooking.com", 'epoojabooking-core' ),
			$name,
			$services[ $service ],
			$date
		)
	);

	$payload = array(
		'message'    => __( 'Booking received.', 'epoojabooking-core' ),
		'booking_id' => $booking_id,
		'payment'    => 'none',
	);

	// Optional Razorpay order if configured.
	if ( epb_razorpay_enabled() ) {
		$amount = (int) apply_filters( 'epb_booking_amount_paise', 0, $service );
		if ( $amount > 0 ) {
			$order = epb_razorpay_create_order( $amount, 'epb_' . $booking_id );
			if ( ! is_wp_error( $order ) ) {
				update_post_meta( $booking_id, 'epb_razorpay_order_id', $order['id'] );
				$payload['payment'] = 'razorpay';
				$payload['order']   = array(
					'id'       => $order['id'],
					'amount'   => $order['amount'],
					'currency' => $order['currency'],
				);
				$payload['customer'] = array(
					'name'  => $name,
					'email' => $email,
					'phone' => $phone,
				);
			}
		}
	}

	wp_send_json_success( $payload );
}
add_action( 'wp_ajax_epb_create_booking', 'epb_ajax_create_booking' );
add_action( 'wp_ajax_nopriv_epb_create_booking', 'epb_ajax_create_booking' );

/**
 * AJAX: verify a Razorpay payment.
 */
function epb_ajax_verify_payment() {
	check_ajax_referer( 'epb_booking', 'nonce' );

	$booking_id = isset( $_POST['booking_id'] ) ? absint( $_POST['booking_id'] ) : 0;
	$order_id   = isset( $_POST['razorpay_order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['razorpay_order_id'] ) ) : '';
	$payment_id = isset( $_POST['razorpay_payment_id'] ) ? sanitize_text_field( wp_unslash( $_POST['razorpay_payment_id'] ) ) : '';
	$signature  = isset( $_POST['razorpay_signature'] ) ? sanitize_text_field( wp_unslash( $_POST['razorpay_signature'] ) ) : '';

	$stored_order = get_post_meta( $booking_id, 'epb_razorpay_order_id', true );

	if ( ! $booking_id || ! $stored_order || $stored_order !== $order_id ) {
		wp_send_json_error( array( 'message' => __( 'Booking not found.', 'epoojabooking-core' ) ), 400 );
	}

	if ( ! epb_razorpay_verify_signature( $order_id, $payment_id, $signature ) ) {
		update_post_meta( $booking_id, 'epb_payment_status', 'failed-verification' );
		wp_send_json_error( array( 'message' => __( 'Payment verification failed. Please contact support.', 'epoojabooking-core' ) ), 400 );
	}

	update_post_meta( $booking_id, 'epb_payment_status', 'paid' );
	update_post_meta( $booking_id, 'epb_razorpay_payment_id', $payment_id );

	wp_send_json_success( array( 'message' => __( 'Payment confirmed.', 'epoojabooking-core' ) ) );
}
add_action( 'wp_ajax_epb_verify_payment', 'epb_ajax_verify_payment' );
add_action( 'wp_ajax_nopriv_epb_verify_payment', 'epb_ajax_verify_payment' );
