<?php
/**
 * Service enquiry form with online document upload.
 *
 * Shortcode: [ktn_service_form]  (auto detects the current service)
 * Handles submission via admin-post, stores an Enquiry post, attaches
 * uploaded documents to the media library and emails the admin.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KTN_MAX_FILES', 5 );
define( 'KTN_MAX_FILE_MB', 10 );

function ktn_allowed_upload_mimes() {
	return array(
		'pdf'          => 'application/pdf',
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'doc'          => 'application/msword',
		'docx'         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'xls'          => 'application/vnd.ms-excel',
		'xlsx'         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'zip'          => 'application/zip',
	);
}

/**
 * Render the enquiry and document upload form.
 */
function ktn_service_form_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'service' => '',
			'title'   => __( 'Get Started Now', 'ktn-core' ),
		),
		$atts,
		'ktn_service_form'
	);

	$service_name = $atts['service'];
	if ( '' === $service_name && is_singular( 'service' ) ) {
		$service_name = get_the_title();
	}

	$services = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);

	$status = isset( $_GET['ktn_status'] ) ? sanitize_key( $_GET['ktn_status'] ) : '';

	ob_start();
	?>
	<div class="ktn-form-card" id="ktn-enquiry-form">
		<h3 class="ktn-form-title"><?php echo esc_html( $atts['title'] ); ?></h3>
		<p class="ktn-form-sub"><?php esc_html_e( 'Fill in your details, upload your documents and our expert will call you back the same day.', 'ktn-core' ); ?></p>

		<?php if ( 'success' === $status ) : ?>
			<div class="ktn-alert ktn-alert-success" role="status">
				<?php esc_html_e( 'Thank you. Your details and documents have been received. Our team will contact you shortly.', 'ktn-core' ); ?>
			</div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="ktn-alert ktn-alert-error" role="alert">
				<?php esc_html_e( 'Something went wrong. Please check the form and try again, or WhatsApp us your documents directly.', 'ktn-core' ); ?>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data" class="ktn-form" novalidate>
			<input type="hidden" name="action" value="ktn_submit_enquiry">
			<input type="hidden" name="ktn_redirect" value="<?php echo esc_url( get_permalink() ); ?>">
			<?php wp_nonce_field( 'ktn_enquiry', 'ktn_enquiry_nonce' ); ?>
			<p class="ktn-hp" aria-hidden="true"><label>Leave this field empty<input type="text" name="ktn_website" tabindex="-1" autocomplete="off"></label></p>

			<div class="ktn-field">
				<label for="ktn-name"><?php esc_html_e( 'Full Name', 'ktn-core' ); ?> <span>*</span></label>
				<input type="text" id="ktn-name" name="ktn_name" required autocomplete="name" placeholder="<?php esc_attr_e( 'Your full name', 'ktn-core' ); ?>">
			</div>
			<div class="ktn-field-row">
				<div class="ktn-field">
					<label for="ktn-phone"><?php esc_html_e( 'Mobile Number', 'ktn-core' ); ?> <span>*</span></label>
					<input type="tel" id="ktn-phone" name="ktn_phone" required autocomplete="tel" inputmode="numeric" pattern="[0-9+ ]{10,15}" placeholder="98XXXXXX00">
				</div>
				<div class="ktn-field">
					<label for="ktn-email"><?php esc_html_e( 'Email Address', 'ktn-core' ); ?></label>
					<input type="email" id="ktn-email" name="ktn_email" autocomplete="email" placeholder="you@example.com">
				</div>
			</div>
			<div class="ktn-field">
				<label for="ktn-service"><?php esc_html_e( 'Service Required', 'ktn-core' ); ?> <span>*</span></label>
				<select id="ktn-service" name="ktn_service" required>
					<option value=""><?php esc_html_e( 'Select a service', 'ktn-core' ); ?></option>
					<?php foreach ( $services as $service ) : ?>
						<option value="<?php echo esc_attr( $service->post_title ); ?>" <?php selected( $service_name, $service->post_title ); ?>><?php echo esc_html( $service->post_title ); ?></option>
					<?php endforeach; ?>
					<option value="Other" <?php selected( $service_name, '' ); ?>><?php esc_html_e( 'Other / Not sure', 'ktn-core' ); ?></option>
				</select>
			</div>
			<div class="ktn-field">
				<label for="ktn-city"><?php esc_html_e( 'City / State', 'ktn-core' ); ?></label>
				<input type="text" id="ktn-city" name="ktn_city" placeholder="<?php esc_attr_e( 'e.g. Delhi', 'ktn-core' ); ?>">
			</div>
			<div class="ktn-field">
				<label for="ktn-message"><?php esc_html_e( 'Your Requirement', 'ktn-core' ); ?></label>
				<textarea id="ktn-message" name="ktn_message" rows="3" placeholder="<?php esc_attr_e( 'Tell us briefly what you need help with', 'ktn-core' ); ?>"></textarea>
			</div>
			<div class="ktn-field">
				<label for="ktn-files"><?php esc_html_e( 'Upload Documents (PDF, JPG, PNG, DOC, XLS, ZIP)', 'ktn-core' ); ?></label>
				<div class="ktn-upload-box">
					<input type="file" id="ktn-files" name="ktn_files[]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.zip">
					<p class="ktn-upload-hint"><?php echo esc_html( sprintf( __( 'Up to %1$d files, %2$d MB each. Your documents stay private and secure.', 'ktn-core' ), KTN_MAX_FILES, KTN_MAX_FILE_MB ) ); ?></p>
					<ul class="ktn-file-list" aria-live="polite"></ul>
				</div>
			</div>
			<div class="ktn-field ktn-consent">
				<label><input type="checkbox" name="ktn_consent" value="1" required> <?php esc_html_e( 'I agree to be contacted about my enquiry.', 'ktn-core' ); ?></label>
			</div>
			<button type="submit" class="ktn-btn ktn-btn-primary ktn-btn-block"><?php esc_html_e( 'Submit Details and Documents', 'ktn-core' ); ?></button>
		</form>

		<div class="ktn-form-or"><span><?php esc_html_e( 'or', 'ktn-core' ); ?></span></div>
		<?php echo ktn_whatsapp_button( $service_name, 'block' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ktn_service_form', 'ktn_service_form_shortcode' );

/**
 * Handle form submission (logged in and guests).
 */
function ktn_handle_enquiry() {
	$redirect = isset( $_POST['ktn_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['ktn_redirect'] ) ) : home_url( '/' );

	$fail = function () use ( $redirect ) {
		wp_safe_redirect( add_query_arg( 'ktn_status', 'error', $redirect ) . '#ktn-enquiry-form' );
		exit;
	};

	if ( ! isset( $_POST['ktn_enquiry_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ktn_enquiry_nonce'] ), 'ktn_enquiry' ) ) {
		$fail();
	}
	// Honeypot: real users never fill this.
	if ( ! empty( $_POST['ktn_website'] ) ) {
		$fail();
	}

	$name    = isset( $_POST['ktn_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ktn_name'] ) ) : '';
	$phone   = isset( $_POST['ktn_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['ktn_phone'] ) ) : '';
	$email   = isset( $_POST['ktn_email'] ) ? sanitize_email( wp_unslash( $_POST['ktn_email'] ) ) : '';
	$service = isset( $_POST['ktn_service'] ) ? sanitize_text_field( wp_unslash( $_POST['ktn_service'] ) ) : '';
	$city    = isset( $_POST['ktn_city'] ) ? sanitize_text_field( wp_unslash( $_POST['ktn_city'] ) ) : '';
	$message = isset( $_POST['ktn_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ktn_message'] ) ) : '';

	if ( '' === $name || '' === $phone || '' === $service ) {
		$fail();
	}

	$enquiry_id = wp_insert_post(
		array(
			'post_type'   => 'ktn_enquiry',
			'post_status' => 'private',
			'post_title'  => sprintf( '%s - %s (%s)', $service, $name, current_time( 'd M Y H:i' ) ),
		),
		true
	);
	if ( is_wp_error( $enquiry_id ) ) {
		$fail();
	}

	update_post_meta( $enquiry_id, '_ktn_name', $name );
	update_post_meta( $enquiry_id, '_ktn_phone', $phone );
	update_post_meta( $enquiry_id, '_ktn_email', $email );
	update_post_meta( $enquiry_id, '_ktn_service', $service );
	update_post_meta( $enquiry_id, '_ktn_city', $city );
	update_post_meta( $enquiry_id, '_ktn_message', $message );

	// Handle document uploads.
	$attachment_urls = array();
	if ( ! empty( $_FILES['ktn_files'] ) && is_array( $_FILES['ktn_files']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$files = $_FILES['ktn_files']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$count = min( count( $files['name'] ), KTN_MAX_FILES );

		for ( $i = 0; $i < $count; $i++ ) {
			if ( empty( $files['name'][ $i ] ) || UPLOAD_ERR_OK !== $files['error'][ $i ] ) {
				continue;
			}
			if ( $files['size'][ $i ] > KTN_MAX_FILE_MB * 1024 * 1024 ) {
				continue;
			}
			$file = array(
				'name'     => sanitize_file_name( $files['name'][ $i ] ),
				'type'     => $files['type'][ $i ],
				'tmp_name' => $files['tmp_name'][ $i ],
				'error'    => $files['error'][ $i ],
				'size'     => $files['size'][ $i ],
			);
			$check = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], ktn_allowed_upload_mimes() );
			if ( empty( $check['ext'] ) || empty( $check['type'] ) ) {
				continue;
			}
			$_FILES['ktn_single'] = $file;
			$attach_id            = media_handle_upload(
				'ktn_single',
				$enquiry_id,
				array( 'post_title' => $name . ' - ' . $file['name'] ),
				array( 'test_form' => false, 'mimes' => ktn_allowed_upload_mimes() )
			);
			if ( ! is_wp_error( $attach_id ) ) {
				$attachment_urls[] = wp_get_attachment_url( $attach_id );
			}
		}
	}
	update_post_meta( $enquiry_id, '_ktn_documents', $attachment_urls );

	// Notify admin.
	$to      = ktn_get_option( 'email', get_option( 'admin_email' ) );
	$subject = sprintf( '[Krishna TaxNova] New enquiry: %s from %s', $service, $name );
	$lines   = array(
		'New enquiry received on the website.',
		'',
		'Service : ' . $service,
		'Name    : ' . $name,
		'Phone   : ' . $phone,
		'Email   : ' . ( $email ? $email : 'Not provided' ),
		'City    : ' . ( $city ? $city : 'Not provided' ),
		'Message : ' . ( $message ? $message : 'Not provided' ),
		'',
	);
	if ( $attachment_urls ) {
		$lines[] = 'Uploaded documents:';
		foreach ( $attachment_urls as $url ) {
			$lines[] = ' - ' . $url;
		}
	} else {
		$lines[] = 'No documents uploaded.';
	}
	$lines[] = '';
	$lines[] = 'View in dashboard: ' . admin_url( 'edit.php?post_type=ktn_enquiry' );
	wp_mail( $to, $subject, implode( "\n", $lines ) );

	wp_safe_redirect( add_query_arg( 'ktn_status', 'success', $redirect ) . '#ktn-enquiry-form' );
	exit;
}
add_action( 'admin_post_ktn_submit_enquiry', 'ktn_handle_enquiry' );
add_action( 'admin_post_nopriv_ktn_submit_enquiry', 'ktn_handle_enquiry' );

/**
 * Enquiry admin columns.
 */
function ktn_enquiry_columns( $columns ) {
	return array(
		'cb'        => $columns['cb'],
		'title'     => __( 'Enquiry', 'ktn-core' ),
		'ktn_phone' => __( 'Phone', 'ktn-core' ),
		'ktn_email' => __( 'Email', 'ktn-core' ),
		'ktn_docs'  => __( 'Documents', 'ktn-core' ),
		'date'      => __( 'Date', 'ktn-core' ),
	);
}
add_filter( 'manage_ktn_enquiry_posts_columns', 'ktn_enquiry_columns' );

function ktn_enquiry_column_content( $column, $post_id ) {
	if ( 'ktn_phone' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_ktn_phone', true ) );
	}
	if ( 'ktn_email' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_ktn_email', true ) );
	}
	if ( 'ktn_docs' === $column ) {
		$docs = get_post_meta( $post_id, '_ktn_documents', true );
		if ( is_array( $docs ) && $docs ) {
			foreach ( $docs as $index => $url ) {
				printf( '<a href="%s" target="_blank" rel="noopener">File %d</a><br>', esc_url( $url ), (int) $index + 1 );
			}
		} else {
			echo '&mdash;';
		}
	}
}
add_action( 'manage_ktn_enquiry_posts_custom_column', 'ktn_enquiry_column_content', 10, 2 );
