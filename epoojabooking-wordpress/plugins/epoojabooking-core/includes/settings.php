<?php
/**
 * Plugin settings: payments, notifications, WhatsApp.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a plugin option.
 *
 * @param string $key     Option key.
 * @param mixed  $default Default value.
 * @return mixed
 */
function epb_get_option( $key, $default = '' ) {
	$options = get_option( 'epb_settings', array() );
	return isset( $options[ $key ] ) && '' !== $options[ $key ] ? $options[ $key ] : $default;
}

/**
 * Register settings screen.
 */
function epb_settings_menu() {
	add_options_page(
		__( 'ePoojaBooking', 'epoojabooking-core' ),
		__( 'ePoojaBooking', 'epoojabooking-core' ),
		'manage_options',
		'epb-settings',
		'epb_settings_page'
	);
}
add_action( 'admin_menu', 'epb_settings_menu' );

/**
 * Register the settings group.
 */
function epb_register_settings() {
	register_setting( 'epb_settings_group', 'epb_settings', array(
		'type'              => 'array',
		'sanitize_callback' => 'epb_sanitize_settings',
	) );
}
add_action( 'admin_init', 'epb_register_settings' );

/**
 * Sanitize settings.
 *
 * @param array $input Raw input.
 * @return array
 */
function epb_sanitize_settings( $input ) {
	$clean = array();
	$keys  = array( 'razorpay_key_id', 'razorpay_key_secret', 'notify_email', 'whatsapp_number', 'currency' );
	foreach ( $keys as $key ) {
		$clean[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
	}
	if ( $clean['notify_email'] ) {
		$clean['notify_email'] = sanitize_email( $clean['notify_email'] );
	}
	return $clean;
}

/**
 * Settings page markup.
 */
function epb_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'ePoojaBooking Settings', 'epoojabooking-core' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'epb_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="epb-razorpay-key"><?php esc_html_e( 'Razorpay Key ID', 'epoojabooking-core' ); ?></label></th>
					<td>
						<input id="epb-razorpay-key" class="regular-text" type="text" name="epb_settings[razorpay_key_id]" value="<?php echo esc_attr( epb_get_option( 'razorpay_key_id' ) ); ?>">
						<p class="description"><?php esc_html_e( 'From the Razorpay dashboard. Leave blank to collect bookings without online payment.', 'epoojabooking-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="epb-razorpay-secret"><?php esc_html_e( 'Razorpay Key Secret', 'epoojabooking-core' ); ?></label></th>
					<td><input id="epb-razorpay-secret" class="regular-text" type="password" name="epb_settings[razorpay_key_secret]" value="<?php echo esc_attr( epb_get_option( 'razorpay_key_secret' ) ); ?>" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="epb-currency"><?php esc_html_e( 'Currency', 'epoojabooking-core' ); ?></label></th>
					<td>
						<select id="epb-currency" name="epb_settings[currency]">
							<?php foreach ( array( 'INR', 'USD', 'GBP', 'CAD', 'AUD', 'AED', 'SGD' ) as $cur ) : ?>
								<option value="<?php echo esc_attr( $cur ); ?>" <?php selected( epb_get_option( 'currency', 'INR' ), $cur ); ?>><?php echo esc_html( $cur ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="epb-notify-email"><?php esc_html_e( 'Notification Email', 'epoojabooking-core' ); ?></label></th>
					<td>
						<input id="epb-notify-email" class="regular-text" type="email" name="epb_settings[notify_email]" value="<?php echo esc_attr( epb_get_option( 'notify_email' ) ); ?>">
						<p class="description"><?php esc_html_e( 'Where new booking alerts are sent. Defaults to the site admin email.', 'epoojabooking-core' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="epb-whatsapp"><?php esc_html_e( 'WhatsApp Number', 'epoojabooking-core' ); ?></label></th>
					<td>
						<input id="epb-whatsapp" class="regular-text" type="text" name="epb_settings[whatsapp_number]" value="<?php echo esc_attr( epb_get_option( 'whatsapp_number' ) ); ?>" placeholder="919999999999">
						<p class="description"><?php esc_html_e( 'With country code, digits only. Used for the floating WhatsApp chat button.', 'epoojabooking-core' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Floating WhatsApp chat button.
 */
function epb_whatsapp_button() {
	$number = preg_replace( '/\D/', '', (string) epb_get_option( 'whatsapp_number' ) );
	if ( ! $number ) {
		return;
	}
	$text = rawurlencode( __( 'Namaste, I would like help with a puja booking.', 'epoojabooking-core' ) );
	?>
	<a class="epb-whatsapp-fab" href="<?php echo esc_url( 'https://wa.me/' . $number . '?text=' . $text ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'epoojabooking-core' ); ?>">
		<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2a9.9 9.9 0 0 0-8.6 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm0 18.1a8 8 0 0 1-4.1-1.1l-.3-.2-3.1.8.8-3-.2-.3A8.1 8.1 0 1 1 12 20.1Zm4.5-6c-.2-.1-1.4-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.6.1a6.6 6.6 0 0 1-3.3-2.9c-.2-.4.2-.4.6-1.2a.5.5 0 0 0 0-.5c0-.1-.6-1.4-.8-1.9s-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 2.9 2.9 0 0 0-.9 2.2 5.1 5.1 0 0 0 1 2.7 11.7 11.7 0 0 0 4.5 4 5.2 5.2 0 0 0 3.2.7 2.7 2.7 0 0 0 1.8-1.3 2.2 2.2 0 0 0 .2-1.3c-.1-.1-.3-.2-.5-.3Z"/></svg>
	</a>
	<style>
		.epb-whatsapp-fab{position:fixed;right:18px;bottom:18px;z-index:1500;display:flex;align-items:center;justify-content:center;width:54px;height:54px;border-radius:50%;background:#25D366;color:#fff;box-shadow:0 8px 24px rgba(0,0,0,.25);transition:transform .2s ease-out}
		.epb-whatsapp-fab:hover{transform:scale(1.06);color:#fff}
	</style>
	<?php
}
add_action( 'wp_footer', 'epb_whatsapp_button' );
