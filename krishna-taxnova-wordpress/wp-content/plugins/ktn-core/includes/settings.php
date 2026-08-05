<?php
/**
 * Eaccountingcart settings page: contact details, WhatsApp number, email.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ktn_register_settings_page() {
	add_menu_page(
		__( 'Eaccountingcart', 'ktn-core' ),
		__( 'Eaccountingcart', 'ktn-core' ),
		'manage_options',
		'ktn-settings',
		'ktn_render_settings_page',
		'dashicons-admin-site-alt3',
		3
	);
}
add_action( 'admin_menu', 'ktn_register_settings_page' );

function ktn_register_settings() {
	register_setting( 'ktn_settings_group', 'ktn_settings', 'ktn_sanitize_settings' );
}
add_action( 'admin_init', 'ktn_register_settings' );

function ktn_sanitize_settings( $input ) {
	$clean = array();
	$keys  = array( 'phone', 'whatsapp', 'email', 'address', 'hours', 'gst_number', 'facebook', 'instagram', 'linkedin', 'twitter', 'youtube', 'map_embed' );
	foreach ( $keys as $key ) {
		if ( ! isset( $input[ $key ] ) ) {
			continue;
		}
		if ( 'email' === $key ) {
			$clean[ $key ] = sanitize_email( $input[ $key ] );
		} elseif ( 'map_embed' === $key ) {
			$clean[ $key ] = wp_kses( $input[ $key ], array( 'iframe' => array( 'src' => true, 'width' => true, 'height' => true, 'style' => true, 'loading' => true, 'allowfullscreen' => true, 'referrerpolicy' => true, 'title' => true ) ) );
		} else {
			$clean[ $key ] = sanitize_text_field( $input[ $key ] );
		}
	}
	// WhatsApp number: keep digits only, expects country code, e.g. 919876543210.
	if ( ! empty( $clean['whatsapp'] ) ) {
		$clean['whatsapp'] = preg_replace( '/\D+/', '', $clean['whatsapp'] );
	}
	return $clean;
}

function ktn_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$fields = array(
		'phone'      => array( __( 'Phone number', 'ktn-core' ), __( 'Shown in the header and footer, e.g. +91 98XXXXXX00', 'ktn-core' ) ),
		'whatsapp'   => array( __( 'WhatsApp number', 'ktn-core' ), __( 'Digits only with country code, e.g. 919876543210. Used for all WhatsApp buttons.', 'ktn-core' ) ),
		'email'      => array( __( 'Email address', 'ktn-core' ), __( 'Enquiry notifications are sent here.', 'ktn-core' ) ),
		'address'    => array( __( 'Office address', 'ktn-core' ), __( 'Displayed in the footer and contact page.', 'ktn-core' ) ),
		'hours'      => array( __( 'Working hours', 'ktn-core' ), __( 'E.g. Mon to Sat, 10:00 AM to 7:00 PM', 'ktn-core' ) ),
		'gst_number' => array( __( 'GSTIN (optional)', 'ktn-core' ), '' ),
		'facebook'   => array( __( 'Facebook URL', 'ktn-core' ), '' ),
		'instagram'  => array( __( 'Instagram URL', 'ktn-core' ), '' ),
		'linkedin'   => array( __( 'LinkedIn URL', 'ktn-core' ), '' ),
		'twitter'    => array( __( 'X / Twitter URL', 'ktn-core' ), '' ),
		'youtube'    => array( __( 'YouTube URL', 'ktn-core' ), '' ),
	);
	$options = get_option( 'ktn_settings', array() );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Eaccountingcart Settings', 'ktn-core' ); ?></h1>
		<p><?php esc_html_e( 'Business contact details used across the website, forms and WhatsApp buttons.', 'ktn-core' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'ktn_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( $fields as $key => $labels ) : ?>
					<tr>
						<th scope="row"><label for="ktn-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $labels[0] ); ?></label></th>
						<td>
							<input type="text" class="regular-text" id="ktn-<?php echo esc_attr( $key ); ?>" name="ktn_settings[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( isset( $options[ $key ] ) ? $options[ $key ] : '' ); ?>">
							<?php if ( ! empty( $labels[1] ) ) : ?>
								<p class="description"><?php echo esc_html( $labels[1] ); ?></p>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<th scope="row"><label for="ktn-map_embed"><?php esc_html_e( 'Google Map embed (iframe)', 'ktn-core' ); ?></label></th>
					<td><textarea class="large-text" rows="4" id="ktn-map_embed" name="ktn_settings[map_embed]"><?php echo esc_textarea( isset( $options['map_embed'] ) ? $options['map_embed'] : '' ); ?></textarea></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
