<?php
/**
 * Careers (job openings list + application form) and Donations
 * (pledge form + bank/UPI details). Both are plugin-free: shortcodes
 * render the forms and admin-post handlers email the submissions.
 *
 * Shortcodes:
 *   [cihs_job_openings]     – grid of open positions (cihs_career CPT)
 *   [cihs_job_application]  – application form with position dropdown
 *   [cihs_donation_form]    – donation pledge form with preset amounts
 *   [cihs_donation_details] – bank / UPI details card (from Customizer)
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* --------------------------------------------------------------------------
 * Careers: openings grid
 * ------------------------------------------------------------------------ */
function cihs_job_openings_shortcode() {
	$jobs = get_posts(
		array(
			'post_type'      => 'cihs_career',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	ob_start();
	if ( ! $jobs ) {
		echo '<p>' . esc_html__( 'There are no open positions right now. We still welcome exceptional profiles — use the application form below and choose “General Application”.', 'cihs' ) . '</p>';
	} else {
		echo '<div class="cihs-grid cihs-grid--2">';
		foreach ( $jobs as $job ) {
			$location = get_post_meta( $job->ID, '_cihs_career_location', true );
			$type     = get_post_meta( $job->ID, '_cihs_career_type', true );
			$deadline = get_post_meta( $job->ID, '_cihs_career_deadline', true );
			?>
			<div class="cihs-job-card cihs-reveal">
				<div class="cihs-job-card__badges">
					<?php if ( $type ) : ?><span class="cihs-badge"><?php echo esc_html( $type ); ?></span><?php endif; ?>
					<?php if ( $location ) : ?><span class="cihs-badge cihs-badge--ghost"><?php echo esc_html( $location ); ?></span><?php endif; ?>
				</div>
				<h3><a href="<?php echo esc_url( get_permalink( $job ) ); ?>"><?php echo esc_html( get_the_title( $job ) ); ?></a></h3>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $job ), 24 ) ); ?></p>
				<?php if ( $deadline ) : ?>
					<p class="cihs-job-card__deadline"><strong><?php esc_html_e( 'Apply by:', 'cihs' ); ?></strong> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $deadline ) ) ); ?></p>
				<?php endif; ?>
				<a class="cihs-btn cihs-btn--ghost" href="<?php echo esc_url( get_permalink( $job ) ); ?>"><?php esc_html_e( 'View & Apply', 'cihs' ); ?></a>
			</div>
			<?php
		}
		echo '</div>';
	}
	return ob_get_clean();
}
add_shortcode( 'cihs_job_openings', 'cihs_job_openings_shortcode' );

/* --------------------------------------------------------------------------
 * Careers: application form
 * ------------------------------------------------------------------------ */
function cihs_job_application_shortcode() {
	$status = isset( $_GET['cihs_apply'] ) ? sanitize_key( $_GET['cihs_apply'] ) : '';
	$jobs   = get_posts(
		array(
			'post_type'      => 'cihs_career',
			'posts_per_page' => -1,
		)
	);
	ob_start();

	if ( 'ok' === $status ) {
		echo '<div class="cihs-notice cihs-notice--ok" role="status">' . esc_html__( 'Thank you — your application has been received. Shortlisted candidates will hear from us within three weeks.', 'cihs' ) . '</div>';
	} elseif ( 'err' === $status ) {
		echo '<div class="cihs-notice cihs-notice--err" role="alert">' . esc_html__( 'Sorry, your application could not be submitted. Please try again or email us directly.', 'cihs' ) . '</div>';
	}
	?>
	<form class="cihs-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="apply">
		<input type="hidden" name="action" value="cihs_apply_submit">
		<?php wp_nonce_field( 'cihs_apply_form', 'cihs_apply_nonce' ); ?>
		<p class="screen-reader-text" aria-hidden="true">
			<label for="cihs_ahp"><?php esc_html_e( 'Leave this field empty', 'cihs' ); ?></label>
			<input type="text" name="cihs_hp" id="cihs_ahp" tabindex="-1" autocomplete="off">
		</p>
		<div class="cihs-form-grid">
			<div class="cihs-form-row">
				<label for="cihs_a_name"><?php esc_html_e( 'Full Name *', 'cihs' ); ?></label>
				<input type="text" id="cihs_a_name" name="cihs_name" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_a_email"><?php esc_html_e( 'Email Address *', 'cihs' ); ?></label>
				<input type="email" id="cihs_a_email" name="cihs_email" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_a_phone"><?php esc_html_e( 'Phone *', 'cihs' ); ?></label>
				<input type="tel" id="cihs_a_phone" name="cihs_phone" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_a_position"><?php esc_html_e( 'Position *', 'cihs' ); ?></label>
				<select id="cihs_a_position" name="cihs_position" required>
					<?php foreach ( $jobs as $job ) : ?>
						<option value="<?php echo esc_attr( get_the_title( $job ) ); ?>"><?php echo esc_html( get_the_title( $job ) ); ?></option>
					<?php endforeach; ?>
					<option value="General Application"><?php esc_html_e( 'General Application', 'cihs' ); ?></option>
				</select>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_a_cv"><?php esc_html_e( 'CV / Resume Link *', 'cihs' ); ?></label>
				<input type="url" id="cihs_a_cv" name="cihs_cv_link" placeholder="https://drive.google.com/…" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_a_portfolio"><?php esc_html_e( 'LinkedIn / Portfolio', 'cihs' ); ?></label>
				<input type="url" id="cihs_a_portfolio" name="cihs_portfolio">
			</div>
		</div>
		<div class="cihs-form-row">
			<label for="cihs_a_message"><?php esc_html_e( 'Statement of Interest *', 'cihs' ); ?></label>
			<textarea id="cihs_a_message" name="cihs_message" rows="6" required placeholder="<?php esc_attr_e( 'Tell us why you want to work with CIHS and include a link to a writing sample if available.', 'cihs' ); ?>"></textarea>
		</div>
		<button type="submit" class="cihs-btn"><?php esc_html_e( 'Submit Application', 'cihs' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cihs_job_application', 'cihs_job_application_shortcode' );

function cihs_apply_submit() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/careers-internships/' );
	$redirect = remove_query_arg( 'cihs_apply', $redirect );

	if (
		! isset( $_POST['cihs_apply_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( $_POST['cihs_apply_nonce'] ), 'cihs_apply_form' ) ||
		! empty( $_POST['cihs_hp'] )
	) {
		wp_safe_redirect( add_query_arg( 'cihs_apply', 'err', $redirect ) );
		exit;
	}

	$name      = isset( $_POST['cihs_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_name'] ) ) : '';
	$email     = isset( $_POST['cihs_email'] ) ? sanitize_email( wp_unslash( $_POST['cihs_email'] ) ) : '';
	$phone     = isset( $_POST['cihs_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_phone'] ) ) : '';
	$position  = isset( $_POST['cihs_position'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_position'] ) ) : '';
	$cv        = isset( $_POST['cihs_cv_link'] ) ? esc_url_raw( wp_unslash( $_POST['cihs_cv_link'] ) ) : '';
	$portfolio = isset( $_POST['cihs_portfolio'] ) ? esc_url_raw( wp_unslash( $_POST['cihs_portfolio'] ) ) : '';
	$message   = isset( $_POST['cihs_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cihs_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message || ! $cv ) {
		wp_safe_redirect( add_query_arg( 'cihs_apply', 'err', $redirect ) );
		exit;
	}

	$to   = get_theme_mod( 'cihs_email', get_option( 'admin_email' ) );
	$body = sprintf(
		"New job application via the CIHS website.\n\nPosition: %s\nName: %s\nEmail: %s\nPhone: %s\nCV: %s\nPortfolio: %s\n\nStatement of Interest:\n%s\n",
		$position,
		$name,
		$email,
		$phone,
		$cv,
		$portfolio,
		$message
	);
	$sent = wp_mail( $to, '[CIHS Careers] ' . $position . ' — ' . $name, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( 'cihs_apply', $sent ? 'ok' : 'err', $redirect ) . '#apply' );
	exit;
}
add_action( 'admin_post_cihs_apply_submit', 'cihs_apply_submit' );
add_action( 'admin_post_nopriv_cihs_apply_submit', 'cihs_apply_submit' );

/* --------------------------------------------------------------------------
 * Donations: bank / UPI details card
 * ------------------------------------------------------------------------ */
function cihs_donation_details_shortcode() {
	ob_start();
	?>
	<div class="cihs-grid cihs-grid--2">
		<div class="cihs-contact-card">
			<h3><?php esc_html_e( 'Bank Transfer (NEFT / IMPS / RTGS)', 'cihs' ); ?></h3>
			<p><strong><?php esc_html_e( 'Account Name:', 'cihs' ); ?></strong> <?php echo esc_html( get_theme_mod( 'cihs_don_account_name', 'Centre for Integrated and Holistic Studies' ) ); ?></p>
			<p><strong><?php esc_html_e( 'Bank & Branch:', 'cihs' ); ?></strong> <?php echo esc_html( get_theme_mod( 'cihs_don_bank', 'Add bank name and branch' ) ); ?></p>
			<p><strong><?php esc_html_e( 'Account Number:', 'cihs' ); ?></strong> <?php echo esc_html( get_theme_mod( 'cihs_don_account_no', 'Add account number' ) ); ?></p>
			<p><strong><?php esc_html_e( 'IFSC:', 'cihs' ); ?></strong> <?php echo esc_html( get_theme_mod( 'cihs_don_ifsc', 'Add IFSC code' ) ); ?></p>
		</div>
		<div class="cihs-contact-card">
			<h3><?php esc_html_e( 'UPI', 'cihs' ); ?></h3>
			<p><strong><?php esc_html_e( 'UPI ID:', 'cihs' ); ?></strong> <?php echo esc_html( get_theme_mod( 'cihs_don_upi', 'Add UPI ID' ) ); ?></p>
			<p><?php echo esc_html( get_theme_mod( 'cihs_don_note', 'Donations to CIHS may be eligible for tax exemption. A receipt is issued for every contribution.' ) ); ?></p>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cihs_donation_details', 'cihs_donation_details_shortcode' );

/* --------------------------------------------------------------------------
 * Donations: pledge form with preset amounts
 * ------------------------------------------------------------------------ */
function cihs_donation_form_shortcode() {
	$status = isset( $_GET['cihs_donate'] ) ? sanitize_key( $_GET['cihs_donate'] ) : '';
	ob_start();

	if ( 'ok' === $status ) {
		echo '<div class="cihs-notice cihs-notice--ok" role="status">' . esc_html__( 'Thank you for supporting CIHS! We have received your pledge — our team will email you the payment confirmation steps and your receipt details shortly.', 'cihs' ) . '</div>';
	} elseif ( 'err' === $status ) {
		echo '<div class="cihs-notice cihs-notice--err" role="alert">' . esc_html__( 'Sorry, your pledge could not be recorded. Please try again or contact us directly.', 'cihs' ) . '</div>';
	}
	?>
	<form class="cihs-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="donate">
		<input type="hidden" name="action" value="cihs_donate_submit">
		<?php wp_nonce_field( 'cihs_donate_form', 'cihs_donate_nonce' ); ?>
		<p class="screen-reader-text" aria-hidden="true">
			<label for="cihs_dhp"><?php esc_html_e( 'Leave this field empty', 'cihs' ); ?></label>
			<input type="text" name="cihs_hp" id="cihs_dhp" tabindex="-1" autocomplete="off">
		</p>

		<div class="cihs-form-row">
			<label><?php esc_html_e( 'Choose an amount (₹) *', 'cihs' ); ?></label>
			<div class="cihs-amounts" role="group" aria-label="<?php esc_attr_e( 'Preset donation amounts', 'cihs' ); ?>">
				<button type="button" class="cihs-amount-btn" data-amount="500">₹500</button>
				<button type="button" class="cihs-amount-btn" data-amount="1000">₹1,000</button>
				<button type="button" class="cihs-amount-btn" data-amount="2500">₹2,500</button>
				<button type="button" class="cihs-amount-btn" data-amount="5000">₹5,000</button>
				<button type="button" class="cihs-amount-btn" data-amount="10000">₹10,000</button>
			</div>
			<label class="screen-reader-text" for="cihs_d_amount"><?php esc_html_e( 'Donation amount in rupees', 'cihs' ); ?></label>
			<input type="number" id="cihs_d_amount" name="cihs_amount" min="1" step="1" placeholder="<?php esc_attr_e( 'Or enter a custom amount', 'cihs' ); ?>" required>
		</div>

		<div class="cihs-form-grid">
			<div class="cihs-form-row">
				<label for="cihs_d_name"><?php esc_html_e( 'Full Name *', 'cihs' ); ?></label>
				<input type="text" id="cihs_d_name" name="cihs_name" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_d_email"><?php esc_html_e( 'Email Address *', 'cihs' ); ?></label>
				<input type="email" id="cihs_d_email" name="cihs_email" required>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_d_phone"><?php esc_html_e( 'Phone', 'cihs' ); ?></label>
				<input type="tel" id="cihs_d_phone" name="cihs_phone">
			</div>
			<div class="cihs-form-row">
				<label for="cihs_d_pan"><?php esc_html_e( 'PAN (for tax receipt, optional)', 'cihs' ); ?></label>
				<input type="text" id="cihs_d_pan" name="cihs_pan" maxlength="10" autocomplete="off">
			</div>
			<div class="cihs-form-row">
				<label for="cihs_d_mode"><?php esc_html_e( 'Preferred Payment Mode *', 'cihs' ); ?></label>
				<select id="cihs_d_mode" name="cihs_mode" required>
					<option value="UPI"><?php esc_html_e( 'UPI', 'cihs' ); ?></option>
					<option value="Bank Transfer"><?php esc_html_e( 'Bank Transfer (NEFT/IMPS)', 'cihs' ); ?></option>
					<option value="Cheque / DD"><?php esc_html_e( 'Cheque / Demand Draft', 'cihs' ); ?></option>
				</select>
			</div>
			<div class="cihs-form-row">
				<label for="cihs_d_purpose"><?php esc_html_e( 'Direct my support towards', 'cihs' ); ?></label>
				<select id="cihs_d_purpose" name="cihs_purpose">
					<option value="Where it is needed most"><?php esc_html_e( 'Where it is needed most', 'cihs' ); ?></option>
					<option value="Research & Publications"><?php esc_html_e( 'Research & Publications', 'cihs' ); ?></option>
					<option value="Events & Lectures"><?php esc_html_e( 'Events & Lectures', 'cihs' ); ?></option>
					<option value="Fellowships & Internships"><?php esc_html_e( 'Fellowships & Internships', 'cihs' ); ?></option>
				</select>
			</div>
		</div>
		<div class="cihs-form-row">
			<label for="cihs_d_message"><?php esc_html_e( 'Message (optional)', 'cihs' ); ?></label>
			<textarea id="cihs_d_message" name="cihs_message" rows="3"></textarea>
		</div>
		<button type="submit" class="cihs-btn"><?php esc_html_e( 'Pledge My Support', 'cihs' ); ?></button>
		<p class="cihs-form-note"><?php esc_html_e( 'After you submit, use the bank/UPI details above to complete the transfer. Our team confirms every donation by email and issues a receipt.', 'cihs' ); ?></p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cihs_donation_form', 'cihs_donation_form_shortcode' );

function cihs_donate_submit() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/support-cihs/' );
	$redirect = remove_query_arg( 'cihs_donate', $redirect );

	if (
		! isset( $_POST['cihs_donate_nonce'] ) ||
		! wp_verify_nonce( sanitize_key( $_POST['cihs_donate_nonce'] ), 'cihs_donate_form' ) ||
		! empty( $_POST['cihs_hp'] )
	) {
		wp_safe_redirect( add_query_arg( 'cihs_donate', 'err', $redirect ) );
		exit;
	}

	$amount  = isset( $_POST['cihs_amount'] ) ? absint( $_POST['cihs_amount'] ) : 0;
	$name    = isset( $_POST['cihs_name'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_name'] ) ) : '';
	$email   = isset( $_POST['cihs_email'] ) ? sanitize_email( wp_unslash( $_POST['cihs_email'] ) ) : '';
	$phone   = isset( $_POST['cihs_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_phone'] ) ) : '';
	$pan     = isset( $_POST['cihs_pan'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_pan'] ) ) : '';
	$mode    = isset( $_POST['cihs_mode'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_mode'] ) ) : '';
	$purpose = isset( $_POST['cihs_purpose'] ) ? sanitize_text_field( wp_unslash( $_POST['cihs_purpose'] ) ) : '';
	$message = isset( $_POST['cihs_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cihs_message'] ) ) : '';

	if ( ! $amount || ! $name || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'cihs_donate', 'err', $redirect ) );
		exit;
	}

	$to   = get_theme_mod( 'cihs_email', get_option( 'admin_email' ) );
	$body = sprintf(
		"New donation pledge via the CIHS website.\n\nAmount: Rs. %s\nName: %s\nEmail: %s\nPhone: %s\nPAN: %s\nPayment Mode: %s\nPurpose: %s\n\nMessage:\n%s\n",
		number_format_i18n( $amount ),
		$name,
		$email,
		$phone,
		$pan ? $pan : '—',
		$mode,
		$purpose,
		$message
	);
	$sent = wp_mail( $to, sprintf( '[CIHS Donation] Rs. %s pledge — %s', number_format_i18n( $amount ), $name ), $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	// Acknowledge the donor too.
	if ( $sent ) {
		wp_mail(
			$email,
			__( 'Thank you for supporting CIHS', 'cihs' ),
			sprintf(
				"Dear %s,\n\nThank you for pledging Rs. %s to the Centre for Integrated and Holistic Studies. Please complete your %s transfer using the details on %s — our team will confirm receipt and share your donation receipt by email.\n\nWarm regards,\nCIHS Team",
				$name,
				number_format_i18n( $amount ),
				$mode,
				home_url( '/support-cihs/' )
			)
		);
	}

	wp_safe_redirect( add_query_arg( 'cihs_donate', $sent ? 'ok' : 'err', $redirect ) . '#donate' );
	exit;
}
add_action( 'admin_post_cihs_donate_submit', 'cihs_donate_submit' );
add_action( 'admin_post_nopriv_cihs_donate_submit', 'cihs_donate_submit' );
