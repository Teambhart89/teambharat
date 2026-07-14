<?php
/**
 * Built-in contact form: shortcode [cihs_contact_form] + mail handler.
 * No plugin required; honeypot + nonce protected.
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the contact form.
 */
function cihs_contact_form_shortcode() {
	$status = isset( $_GET['cihs_contact'] ) ? sanitize_key( $_GET['cihs_contact'] ) : '';
	ob_start();

	if ( 'ok' === $status ) {
		echo '<div class="cihs-notice cihs-notice--ok" role="status">' . esc_html__( 'Thank you — your message has been sent. Our team will respond shortly.', 'cihs' ) . '</div>';
	} elseif ( 'err' === $status ) {
		echo '<div class="cihs-notice cihs-notice--err" role="alert">' . esc_html__( 'Sorry, your message could not be sent. Please try again or email us directly.', 'cihs' ) . '</div>';
	}
	?>
	<form class="cihs-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="cihs_contact_submit">
		<?php wp_nonce_field( 'cihs_contact_form', 'cihs_contact_nonce' ); ?>
		<p class="screen-reader-text" aria-hidden="true">
			<label for="cihs_hp"><?php esc_html_e( 'Leave this field empty', 'cihs' ); ?></label>
			<input type="text" name="cihs_hp" id="cihs_hp" tabindex="-1" autocomplete="off">
		</p>
		<div class="cihs-form-grid">
			<div class="cihs-form-row">
				<label for="cihs_name"><?php esc_html_e( 'Full Name *', 'cihs' ); ?></label>
				<input type="text" id="cihs_name" name="cihs_name" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_email"><?php esc_html_e( 'Email Address *', 'cihs' ); ?></label>
				<input type="email" id="cihs_email" name="cihs_email" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_phone"><?php esc_html_e( 'Phone', 'cihs' ); ?></label>
				<input type="tel" id="cihs_phone" name="cihs_phone">
			</div>
			<div class="cihs-form-row">
				<label for="cihs_subject"><?php esc_html_e( 'Subject *', 'cihs' ); ?></label>
				<select id="cihs_subject" name="cihs_subject" required>
					<option value="General Enquiry"><?php esc_html_e( 'General Enquiry', 'cihs' ); ?></option>
					<option value="Research Collaboration"><?php esc_html_e( 'Research Collaboration', 'cihs' ); ?></option>
					<option value="Media / Press"><?php esc_html_e( 'Media / Press', 'cihs' ); ?></option>
					<option value="Events & Speaking"><?php esc_html_e( 'Events & Speaking', 'cihs' ); ?></option>
					<option value="Internships & Careers"><?php esc_html_e( 'Internships & Careers', 'cihs' ); ?></option>
				</select>
			</div>
		</div>
		<div class="cihs-form-row">
			<label for="cihs_message"><?php esc_html_e( 'Message *', 'cihs' ); ?></label>
			<textarea id="cihs_message" name="cihs_message" rows="6" required></textarea>
		</div>
		<button type="submit" class="cihs-btn"><?php esc_html_e( 'Send Message', 'cihs' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cihs_contact_form', 'cihs_contact_form_shortcode' );

/**
 * Handle submission and redirect back with a status flag.
 */
function cihs_contact_submit() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );
	$redirect = remove_query_arg( 'cihs_contact', $redirect );

	if (
		! isset( $_POST['cihs_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( $_POST['cihs_contact_nonce'] ), 'cihs_contact_form' ) ||
		! empty( $_POST['cihs_hp'] ) // Honeypot tripped.
	) {
		wp_safe_redirect( add_query_arg( 'cihs_contact', 'err', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['cihs_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_name'] ) ) : '';
	$email   = isset( $_POST['cihs_email'] ) ? sanitize_email( wp_unslash( $_POST['cihs_email'] ) ) : '';
	$phone   = isset( $_POST['cihs_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_phone'] ) ) : '';
	$subject = isset( $_POST['cihs_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_subject'] ) ) : '';
	$message = isset( $_POST['cihs_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cihs_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'cihs_contact', 'err', $redirect ) );
		exit;
	}

	$to   = get_theme_mod( 'cihs_email', get_option( 'admin_email' ) );
	$body = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s\n",
		$name,
		$email,
		$phone,
		$subject,
		$message
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, '[CIHS Website] ' . $subject . ' — ' . $name, $body, $headers );

	wp_safe_redirect( add_query_arg( 'cihs_contact', $sent ? 'ok' : 'err', $redirect ) );
	exit;
}
add_action( 'admin_post_cihs_contact_submit', 'cihs_contact_submit' );
add_action( 'admin_post_nopriv_cihs_contact_submit', 'cihs_contact_submit' );
