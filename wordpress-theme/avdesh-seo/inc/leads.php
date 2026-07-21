<?php
/**
 * Built-in lead capture.
 *
 * Saves Contact and Free-Audit form submissions to the database as a private
 * "Lead" post type and emails the site admin. No third-party plugin required.
 * A form-plugin shortcode set in the Customizer will override the built-in form.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 *  Register the Lead post type (admin-only, private).
 * ---------------------------------------------------------------------- */
function avdesh_register_leads() {
	register_post_type(
		'avdesh_lead',
		array(
			'labels'            => array(
				'name'          => __( 'Leads', 'avdesh-seo' ),
				'singular_name' => __( 'Lead', 'avdesh-seo' ),
				'menu_name'     => __( 'Leads', 'avdesh-seo' ),
				'all_items'     => __( 'All Leads', 'avdesh-seo' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => false,
			'menu_icon'         => 'dashicons-email-alt',
			'menu_position'     => 26,
			'capability_type'   => 'post',
			'capabilities'      => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'      => true,
			'supports'          => array( 'title' ),
			'has_archive'       => false,
			'rewrite'           => false,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'avdesh_register_leads' );

/* -------------------------------------------------------------------------
 *  Admin list columns.
 * ---------------------------------------------------------------------- */
function avdesh_lead_columns( $cols ) {
	return array(
		'cb'         => $cols['cb'],
		'title'      => __( 'Name', 'avdesh-seo' ),
		'lead_email' => __( 'Email', 'avdesh-seo' ),
		'lead_type'  => __( 'Type', 'avdesh-seo' ),
		'lead_svc'   => __( 'Interest', 'avdesh-seo' ),
		'date'       => __( 'Received', 'avdesh-seo' ),
	);
}
add_filter( 'manage_avdesh_lead_posts_columns', 'avdesh_lead_columns' );

function avdesh_lead_column_data( $col, $post_id ) {
	if ( 'lead_email' === $col ) {
		$e = get_post_meta( $post_id, '_lead_email', true );
		echo $e ? '<a href="mailto:' . esc_attr( $e ) . '">' . esc_html( $e ) . '</a>' : '—';
	} elseif ( 'lead_type' === $col ) {
		echo esc_html( ucfirst( get_post_meta( $post_id, '_lead_type', true ) ?: 'contact' ) );
	} elseif ( 'lead_svc' === $col ) {
		echo esc_html( get_post_meta( $post_id, '_lead_service', true ) ?: '—' );
	}
}
add_action( 'manage_avdesh_lead_posts_custom_column', 'avdesh_lead_column_data', 10, 2 );

/** Show the submission details on the edit screen. */
function avdesh_lead_metabox() {
	add_meta_box( 'avdesh_lead_details', __( 'Lead details', 'avdesh-seo' ), 'avdesh_lead_metabox_html', 'avdesh_lead', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'avdesh_lead_metabox' );

function avdesh_lead_metabox_html( $post ) {
	$fields = array(
		'Name'     => '_lead_name',
		'Email'    => '_lead_email',
		'Website'  => '_lead_website',
		'Interest' => '_lead_service',
		'Type'     => '_lead_type',
		'Source'   => '_lead_source',
		'Received' => '_lead_time',
	);
	echo '<table class="widefat striped"><tbody>';
	foreach ( $fields as $label => $key ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<tr><th style="width:140px;">' . esc_html( $label ) . '</th><td>' . esc_html( $val ) . '</td></tr>';
	}
	$msg = get_post_meta( $post->ID, '_lead_message', true );
	echo '<tr><th>Message</th><td>' . nl2br( esc_html( $msg ) ) . '</td></tr>';
	echo '</tbody></table>';
}

/* -------------------------------------------------------------------------
 *  Handle the submission (admin-post.php).
 * ---------------------------------------------------------------------- */
function avdesh_handle_lead() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	// Nonce.
	if ( ! isset( $_POST['avdesh_lead_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['avdesh_lead_nonce'] ) ), 'avdesh_lead' ) ) {
		wp_safe_redirect( add_query_arg( 'avdesh_sent', 'error', $redirect ) );
		exit;
	}

	// Honeypot: if the hidden field is filled, silently treat as success (drop it).
	if ( ! empty( $_POST['avdesh_hp'] ) ) {
		wp_safe_redirect( add_query_arg( 'avdesh_sent', '1', $redirect ) . '#lead-form' );
		exit;
	}

	$name    = isset( $_POST['lead_name'] ) ? sanitize_text_field( wp_unslash( $_POST['lead_name'] ) ) : '';
	$email   = isset( $_POST['lead_email'] ) ? sanitize_email( wp_unslash( $_POST['lead_email'] ) ) : '';
	$website = isset( $_POST['lead_website'] ) ? esc_url_raw( wp_unslash( $_POST['lead_website'] ) ) : '';
	$service = isset( $_POST['lead_service'] ) ? sanitize_text_field( wp_unslash( $_POST['lead_service'] ) ) : '';
	$message = isset( $_POST['lead_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['lead_message'] ) ) : '';
	$type    = isset( $_POST['lead_type'] ) ? sanitize_key( wp_unslash( $_POST['lead_type'] ) ) : 'contact';
	$source  = isset( $_POST['lead_source'] ) ? esc_url_raw( wp_unslash( $_POST['lead_source'] ) ) : '';

	if ( empty( $name ) || empty( $email ) || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'avdesh_sent', 'error', $redirect ) . '#lead-form' );
		exit;
	}

	// Save the lead.
	$post_id = wp_insert_post(
		array(
			'post_type'   => 'avdesh_lead',
			'post_status' => 'publish',
			'post_title'  => $name . ( $service ? ' — ' . $service : '' ),
		),
		true
	);

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_lead_name', $name );
		update_post_meta( $post_id, '_lead_email', $email );
		update_post_meta( $post_id, '_lead_website', $website );
		update_post_meta( $post_id, '_lead_service', $service );
		update_post_meta( $post_id, '_lead_message', $message );
		update_post_meta( $post_id, '_lead_type', $type );
		update_post_meta( $post_id, '_lead_source', $source );
		update_post_meta( $post_id, '_lead_time', current_time( 'mysql' ) );

		// Notify the admin / consultant.
		$to      = avdesh_opt( 'avdesh_email', get_option( 'admin_email' ) );
		$subject = sprintf( '[%s] New %s lead: %s', get_bloginfo( 'name' ), $type, $name );
		$body    = "You have a new lead from your website.\n\n"
			. "Name: {$name}\n"
			. "Email: {$email}\n"
			. "Website: {$website}\n"
			. "Interest: {$service}\n"
			. "Type: {$type}\n"
			. "Source: {$source}\n\n"
			. "Message:\n{$message}\n";
		$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
		wp_mail( $to, $subject, $body, $headers );
	}

	wp_safe_redirect( add_query_arg( 'avdesh_sent', '1', $redirect ) . '#lead-form' );
	exit;
}
add_action( 'admin_post_nopriv_avdesh_lead', 'avdesh_handle_lead' );
add_action( 'admin_post_avdesh_lead', 'avdesh_handle_lead' );

/* -------------------------------------------------------------------------
 *  Render the built-in lead form.
 *
 *  @param string $type    'contact' or 'audit'.
 *  @param string $submit  Button label.
 * ---------------------------------------------------------------------- */
function avdesh_lead_form( $type = 'contact', $submit = 'Send message →' ) {
	// Success / error notice.
	if ( isset( $_GET['avdesh_sent'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$state = sanitize_key( wp_unslash( $_GET['avdesh_sent'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( '1' === $state ) {
			echo '<div class="callout" id="lead-form" style="border-left-color:var(--accent);background:var(--accent-soft);">✅ <strong>Thank you!</strong> Your message has been received. I\'ll get back to you within 1 to 2 business days.</div>';
		} elseif ( 'error' === $state ) {
			echo '<div class="callout" id="lead-form" style="border-left-color:#e11d48;background:#fee2e2;">⚠️ Sorry, something went wrong. Please check your name and email and try again.</div>';
		}
	}

	$is_audit = ( 'audit' === $type );
	?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" style="margin-top:18px;">
		<input type="hidden" name="action" value="avdesh_lead">
		<input type="hidden" name="lead_type" value="<?php echo esc_attr( $type ); ?>">
		<input type="hidden" name="lead_source" value="<?php echo esc_url( ( is_ssl() ? 'https://' : 'http://' ) . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ) ); ?>">
		<?php wp_nonce_field( 'avdesh_lead', 'avdesh_lead_nonce' ); ?>
		<!-- Honeypot (hidden from humans) -->
		<div style="position:absolute;left:-9999px;" aria-hidden="true"><label>Leave this empty <input type="text" name="avdesh_hp" tabindex="-1" autocomplete="off"></label></div>

		<div class="field"><label for="lf-name">Your name</label><input id="lf-name" type="text" name="lead_name" required></div>
		<div class="field"><label for="lf-email">Email address</label><input id="lf-email" type="email" name="lead_email" required></div>
		<div class="field"><label for="lf-site">Website URL</label><input id="lf-site" type="url" name="lead_website" placeholder="https://" <?php echo $is_audit ? 'required' : ''; ?>></div>
		<div class="field">
			<label for="lf-svc"><?php echo $is_audit ? 'Main goal' : 'Service needed'; ?></label>
			<select id="lf-svc" name="lead_service">
				<?php if ( $is_audit ) : ?>
					<option>More organic traffic</option>
					<option>More leads / sales</option>
					<option>Better rankings</option>
					<option>AI search visibility</option>
					<option>Fix a traffic drop</option>
					<option>Site migration / redesign</option>
				<?php else : ?>
					<?php foreach ( avdesh_services() as $srv ) : ?>
						<option><?php echo esc_html( $srv['menu'] ); ?></option>
					<?php endforeach; ?>
					<option>Not sure yet</option>
				<?php endif; ?>
			</select>
		</div>
		<div class="field"><label for="lf-msg"><?php echo $is_audit ? 'Anything else? (optional)' : 'Your message'; ?></label><textarea id="lf-msg" name="lead_message" rows="<?php echo $is_audit ? '4' : '5'; ?>" <?php echo $is_audit ? '' : 'required'; ?>></textarea></div>
		<button class="btn btn-primary btn-block<?php echo $is_audit ? ' btn-lg' : ''; ?>" type="submit"><?php echo esc_html( $submit ); ?></button>
	</form>
	<p style="font-size:.82rem;color:var(--muted);margin-top:12px;text-align:center;">🔒 Your details are stored securely and never shared. Submissions appear under <strong>Leads</strong> in your dashboard and are emailed to you.</p>
	<?php
}
