<?php
/**
 * SaltStayz theme — booking system, guest emails, feedback.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SSZ_VERSION', '1.0.0' );

require get_template_directory() . '/inc/emails.php';

/* -------------------------------------------------------------
 * Setup
 * ---------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'saltstayz', get_stylesheet_uri(), array(), SSZ_VERSION );
} );

function ssz_properties() {
	return array(
		'Saltstayz Express — Golf Course Road & DLF Phase-1',
		'Saltstayz Select — Galleria Market & Golf Course Road',
		'Saltstayz Premier — Golf Course Road & Sector 42',
		'Saltstayz Premier — Golf Course Extension Road',
		'Saltstayz Studio Apartment — Sohna Road',
	);
}

function ssz_apartments() {
	return array( 'Deluxe Room', 'Executive Studio', '1 BHK Serviced Apartment', 'Premium Suite' );
}

/* -------------------------------------------------------------
 * Post types: bookings + feedback (admin-only UI)
 * ---------------------------------------------------------- */
add_action( 'init', function () {
	register_post_type( 'ssz_booking', array(
		'labels'       => array(
			'name'          => 'Bookings',
			'singular_name' => 'Booking',
			'menu_name'     => 'SaltStayz Bookings',
			'edit_item'     => 'Booking details',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-building',
		'supports'     => array( 'title' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );

	register_post_type( 'ssz_feedback', array(
		'labels'       => array(
			'name'          => 'Guest Feedback',
			'singular_name' => 'Feedback',
			'menu_name'     => 'Guest Feedback',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-star-filled',
		'supports'     => array( 'title' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );
} );

/* Booking meta helper */
function ssz_booking_data( $post_id ) {
	return array(
		'id'        => get_post_meta( $post_id, '_ssz_ref', true ),
		'name'      => get_post_meta( $post_id, '_ssz_name', true ),
		'email'     => get_post_meta( $post_id, '_ssz_email', true ),
		'phone'     => get_post_meta( $post_id, '_ssz_phone', true ),
		'property'  => get_post_meta( $post_id, '_ssz_property', true ),
		'apartment' => get_post_meta( $post_id, '_ssz_apartment', true ),
		'check_in'  => get_post_meta( $post_id, '_ssz_check_in', true ),
		'check_out' => get_post_meta( $post_id, '_ssz_check_out', true ),
		'guests'    => get_post_meta( $post_id, '_ssz_guests', true ),
		'notes'     => get_post_meta( $post_id, '_ssz_notes', true ),
		'status'    => get_post_meta( $post_id, '_ssz_status', true ),
		'token'     => get_post_meta( $post_id, '_ssz_token', true ),
	);
}

function ssz_send_html_mail( $to, $mail ) {
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	return wp_mail( $to, $mail['subject'], $mail['html'], $headers );
}

/* -------------------------------------------------------------
 * Public: booking form submission
 * ---------------------------------------------------------- */
function ssz_handle_public_booking() {
	if ( ! isset( $_POST['ssz_book_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ssz_book_nonce'] ), 'ssz_book' ) ) {
		wp_safe_redirect( add_query_arg( 'ssz_error', rawurlencode( 'Your session expired — please try again.' ), home_url( '/' ) ) . '#book' );
		exit;
	}

	$name      = sanitize_text_field( wp_unslash( $_POST['ssz_name'] ?? '' ) );
	$email     = sanitize_email( wp_unslash( $_POST['ssz_email'] ?? '' ) );
	$phone     = sanitize_text_field( wp_unslash( $_POST['ssz_phone'] ?? '' ) );
	$property  = sanitize_text_field( wp_unslash( $_POST['ssz_property'] ?? '' ) );
	$apartment = sanitize_text_field( wp_unslash( $_POST['ssz_apartment'] ?? '' ) );
	$check_in  = sanitize_text_field( wp_unslash( $_POST['ssz_check_in'] ?? '' ) );
	$check_out = sanitize_text_field( wp_unslash( $_POST['ssz_check_out'] ?? '' ) );
	$guests    = max( 1, min( 10, (int) ( $_POST['ssz_guests'] ?? 1 ) ) );
	$notes     = sanitize_textarea_field( wp_unslash( $_POST['ssz_notes'] ?? '' ) );

	$errors = array();
	if ( strlen( $name ) < 2 ) {
		$errors[] = 'Please enter the guest\'s full name.';
	}
	if ( ! is_email( $email ) ) {
		$errors[] = 'Please enter a valid email address.';
	}
	if ( strlen( preg_replace( '/\D/', '', $phone ) ) < 10 ) {
		$errors[] = 'Please enter a valid phone number.';
	}
	if ( ! in_array( $property, ssz_properties(), true ) ) {
		$errors[] = 'Please choose a property.';
	}
	if ( ! in_array( $apartment, ssz_apartments(), true ) ) {
		$errors[] = 'Please choose an apartment type.';
	}
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $check_in ) || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $check_out ) ) {
		$errors[] = 'Please pick check-in and check-out dates.';
	} elseif ( strtotime( $check_out ) <= strtotime( $check_in ) ) {
		$errors[] = 'Check-out must be after check-in.';
	}

	if ( $errors ) {
		wp_safe_redirect( add_query_arg( 'ssz_error', rawurlencode( implode( ' ', $errors ) ), home_url( '/' ) ) . '#book' );
		exit;
	}

	$ref     = 'SSZ-' . strtoupper( wp_generate_password( 6, false, false ) );
	$post_id = wp_insert_post( array(
		'post_type'   => 'ssz_booking',
		'post_status' => 'publish',
		'post_title'  => $ref . ' — ' . $name,
	), true );

	if ( is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'ssz_error', rawurlencode( 'Could not save your booking — please try again.' ), home_url( '/' ) ) . '#book' );
		exit;
	}

	update_post_meta( $post_id, '_ssz_ref', $ref );
	update_post_meta( $post_id, '_ssz_name', $name );
	update_post_meta( $post_id, '_ssz_email', $email );
	update_post_meta( $post_id, '_ssz_phone', $phone );
	update_post_meta( $post_id, '_ssz_property', $property );
	update_post_meta( $post_id, '_ssz_apartment', $apartment );
	update_post_meta( $post_id, '_ssz_check_in', $check_in );
	update_post_meta( $post_id, '_ssz_check_out', $check_out );
	update_post_meta( $post_id, '_ssz_guests', $guests );
	update_post_meta( $post_id, '_ssz_notes', $notes );
	update_post_meta( $post_id, '_ssz_status', 'pending' );
	update_post_meta( $post_id, '_ssz_token', wp_generate_password( 24, false, false ) );

	ssz_send_html_mail( $email, ssz_email_received( ssz_booking_data( $post_id ) ) );

	wp_safe_redirect( add_query_arg( 'ssz_booked', rawurlencode( $ref ), home_url( '/' ) ) . '#book' );
	exit;
}
add_action( 'admin_post_nopriv_ssz_book', 'ssz_handle_public_booking' );
add_action( 'admin_post_ssz_book', 'ssz_handle_public_booking' );

/* -------------------------------------------------------------
 * Admin: bookings list — columns + action buttons
 * ---------------------------------------------------------- */
add_filter( 'manage_ssz_booking_posts_columns', function ( $columns ) {
	return array(
		'cb'          => $columns['cb'],
		'title'       => 'Booking',
		'ssz_contact' => 'Contact',
		'ssz_stay'    => 'Stay',
		'ssz_dates'   => 'Dates',
		'ssz_status'  => 'Status',
		'ssz_actions' => 'Actions',
	);
} );

add_action( 'manage_ssz_booking_posts_custom_column', function ( $column, $post_id ) {
	$b = ssz_booking_data( $post_id );
	switch ( $column ) {
		case 'ssz_contact':
			echo esc_html( $b['email'] ) . '<br><span style="color:#666;">' . esc_html( $b['phone'] ) . '</span>';
			break;
		case 'ssz_stay':
			echo esc_html( $b['property'] ) . '<br><span style="color:#666;">' . esc_html( $b['apartment'] ) . ' · ' . esc_html( $b['guests'] ) . ' guest(s)</span>';
			break;
		case 'ssz_dates':
			echo esc_html( ssz_fmt_date( $b['check_in'] ) ) . ' →<br>' . esc_html( ssz_fmt_date( $b['check_out'] ) );
			break;
		case 'ssz_status':
			$labels = array(
				'pending'     => array( 'Pending', '#fdf0d5', '#7a5200' ),
				'confirmed'   => array( 'Confirmed', '#e7efdf', '#3a5426' ),
				'checked_out' => array( 'Checked out', '#e3e7f5', '#2c3a74' ),
				'cancelled'   => array( 'Cancelled', '#fdf3f4', '#a4262c' ),
			);
			$s = $labels[ $b['status'] ] ?? array( $b['status'], '#eee', '#333' );
			printf(
				'<span style="display:inline-block;padding:2px 12px;border-radius:9999px;font-weight:600;background:%s;color:%s;">%s</span>',
				esc_attr( $s[1] ),
				esc_attr( $s[2] ),
				esc_html( $s[0] )
			);
			break;
		case 'ssz_actions':
			$buttons = array();
			if ( 'pending' === $b['status'] ) {
				$buttons[] = array( 'confirm', 'Confirm ✉', 'button button-primary' );
				$buttons[] = array( 'cancel', 'Cancel', 'button' );
			} elseif ( 'confirmed' === $b['status'] ) {
				$buttons[] = array( 'checkout', 'Check out ✉✉', 'button button-primary' );
				$buttons[] = array( 'cancel', 'Cancel', 'button' );
			}
			if ( ! $buttons ) {
				echo '<span style="color:#666;">—</span>';
				break;
			}
			foreach ( $buttons as $btn ) {
				$url = wp_nonce_url(
					admin_url( 'admin-post.php?action=ssz_booking_action&act=' . $btn[0] . '&booking=' . $post_id ),
					'ssz_booking_action_' . $post_id
				);
				printf(
					'<a href="%s" class="%s" style="margin:2px 4px 2px 0;">%s</a>',
					esc_url( $url ),
					esc_attr( $btn[2] ),
					esc_html( $btn[1] )
				);
			}
			break;
	}
}, 10, 2 );

/* Admin: confirm / checkout / cancel actions */
add_action( 'admin_post_ssz_booking_action', function () {
	$post_id = (int) ( $_GET['booking'] ?? 0 );
	$act     = sanitize_key( $_GET['act'] ?? '' );

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( 'You are not allowed to manage bookings.' );
	}
	check_admin_referer( 'ssz_booking_action_' . $post_id );

	$b    = ssz_booking_data( $post_id );
	$back = admin_url( 'edit.php?post_type=ssz_booking' );

	if ( 'confirm' === $act && 'pending' === $b['status'] ) {
		update_post_meta( $post_id, '_ssz_status', 'confirmed' );
		ssz_send_html_mail( $b['email'], ssz_email_confirmed( ssz_booking_data( $post_id ) ) );
		$back = add_query_arg( 'ssz_msg', 'confirmed', $back );
	} elseif ( 'checkout' === $act && 'confirmed' === $b['status'] ) {
		update_post_meta( $post_id, '_ssz_status', 'checked_out' );
		$fresh        = ssz_booking_data( $post_id );
		$feedback_url = add_query_arg( 'ssz_feedback', $fresh['token'], home_url( '/' ) );
		ssz_send_html_mail( $b['email'], ssz_email_checkout( $fresh ) );
		ssz_send_html_mail( $b['email'], ssz_email_thanks( $fresh, $feedback_url ) );
		$back = add_query_arg( 'ssz_msg', 'checkedout', $back );
	} elseif ( 'cancel' === $act && 'checked_out' !== $b['status'] ) {
		update_post_meta( $post_id, '_ssz_status', 'cancelled' );
		$back = add_query_arg( 'ssz_msg', 'cancelled', $back );
	}

	wp_safe_redirect( $back );
	exit;
} );

/* Admin notices after actions */
add_action( 'admin_notices', function () {
	if ( empty( $_GET['ssz_msg'] ) ) {
		return;
	}
	$messages = array(
		'confirmed'  => 'Booking confirmed — confirmation email sent to the guest.',
		'checkedout' => 'Guest checked out — check-out summary and thank-you/feedback emails sent.',
		'cancelled'  => 'Booking cancelled.',
	);
	$key = sanitize_key( $_GET['ssz_msg'] );
	if ( isset( $messages[ $key ] ) ) {
		printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $messages[ $key ] ) );
	}
} );

/* Booking details metabox (read-only summary) */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'ssz_booking_details', 'Booking details', function ( $post ) {
		$b    = ssz_booking_data( $post->ID );
		$rows = array(
			'Reference' => $b['id'],
			'Guest'     => $b['name'],
			'Email'     => $b['email'],
			'Phone'     => $b['phone'],
			'Property'  => $b['property'],
			'Apartment' => $b['apartment'],
			'Check-in'  => ssz_fmt_date( $b['check_in'] ),
			'Check-out' => ssz_fmt_date( $b['check_out'] ),
			'Guests'    => $b['guests'],
			'Status'    => $b['status'],
			'Notes'     => $b['notes'] ?: '—',
		);
		echo '<table class="widefat striped">';
		foreach ( $rows as $k => $v ) {
			echo '<tr><td style="width:30%;"><strong>' . esc_html( $k ) . '</strong></td><td>' . esc_html( $v ) . '</td></tr>';
		}
		echo '</table>';
	}, 'ssz_booking', 'normal', 'high' );
} );

/* Feedback list columns */
add_filter( 'manage_ssz_feedback_posts_columns', function ( $columns ) {
	return array(
		'cb'           => $columns['cb'],
		'title'        => 'Feedback',
		'ssz_rating'   => 'Rating',
		'ssz_comments' => 'Comments',
		'date'         => $columns['date'],
	);
} );

add_action( 'manage_ssz_feedback_posts_custom_column', function ( $column, $post_id ) {
	if ( 'ssz_rating' === $column ) {
		$rating = (int) get_post_meta( $post_id, '_ssz_rating', true );
		echo '<span style="color:#e8a807;letter-spacing:2px;font-size:16px;">'
			. esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ) . '</span>';
	}
	if ( 'ssz_comments' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_ssz_comments', true ) ?: '—' );
	}
}, 10, 2 );

/* -------------------------------------------------------------
 * Public: feedback page (tokenized) — rendered on ?ssz_feedback=TOKEN
 * ---------------------------------------------------------- */
function ssz_find_booking_by_token( $token ) {
	if ( ! $token ) {
		return null;
	}
	$found = get_posts( array(
		'post_type'      => 'ssz_booking',
		'posts_per_page' => 1,
		'meta_key'       => '_ssz_token',
		'meta_value'     => $token,
		'fields'         => 'ids',
	) );
	return $found ? $found[0] : null;
}

add_action( 'template_redirect', function () {
	if ( ! isset( $_GET['ssz_feedback'] ) ) {
		return;
	}
	$token   = sanitize_text_field( wp_unslash( $_GET['ssz_feedback'] ) );
	$post_id = ssz_find_booking_by_token( $token );

	status_header( 200 );
	get_header();

	echo '<main id="main" class="page" tabindex="-1"><div class="narrow-card card">';
	echo '<h2 style="font-size:22px;margin-bottom:14px;">How was your stay?</h2>';

	if ( ! $post_id ) {
		echo '<div class="alert alert-error">This feedback link is invalid or has expired. Please use the link from your thank-you email.</div>';
	} else {
		$b    = ssz_booking_data( $post_id );
		$done = (bool) get_post_meta( $post_id, '_ssz_feedback_done', true );
		if ( isset( $_GET['ssz_thanks'] ) || $done ) {
			echo '<div class="alert alert-success">Thank you, ' . esc_html( $b['name'] ) . '! Your feedback has been shared with the team. We hope to host you again soon. 🌿</div>';
		} else {
			if ( isset( $_GET['ssz_fb_error'] ) ) {
				echo '<div class="alert alert-error">' . esc_html( rawurldecode( sanitize_text_field( wp_unslash( $_GET['ssz_fb_error'] ) ) ) ) . '</div>';
			}
			echo '<p style="margin-bottom:16px;">Hi <strong>' . esc_html( $b['name'] ) . '</strong> — thanks for staying at <strong>'
				. esc_html( $b['property'] ) . '</strong> (' . esc_html( $b['id'] ) . '). How did we do?</p>';
			echo '<form class="form-grid" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
			echo '<input type="hidden" name="action" value="ssz_feedback">';
			echo '<input type="hidden" name="ssz_token" value="' . esc_attr( $token ) . '">';
			wp_nonce_field( 'ssz_feedback', 'ssz_feedback_nonce' );
			echo '<fieldset class="field" style="border:0;"><legend style="font-weight:600;margin-bottom:8px;">Your rating</legend><div class="star-row" id="ssz-stars">';
			for ( $i = 1; $i <= 5; $i++ ) {
				echo '<input type="radio" name="ssz_rating" value="' . $i . '" id="ssz-r' . $i . '" ' . ( 5 === $i ? 'required' : '' ) . '>'
					. '<label for="ssz-r' . $i . '" aria-label="' . $i . ' star' . ( $i > 1 ? 's' : '' ) . '">★</label>';
			}
			echo '</div><p class="rating-caption" id="ssz-caption" aria-live="polite"></p></fieldset>';
			echo '<div class="field"><label for="ssz-comments">Tell us more <span style="font-weight:400;">(optional)</span></label>'
				. '<textarea id="ssz-comments" name="ssz_comments" maxlength="1000" placeholder="What did we get right? What should we improve?"></textarea></div>';
			echo '<button type="submit" class="btn btn-primary">Submit feedback</button>';
			echo '</form>';
			?>
			<script>
			(function () {
				var row = document.getElementById("ssz-stars");
				var captions = { 1: "We're sorry — tell us what went wrong.", 2: "Below par — we want to fix this.", 3: "Okay stay — room to improve.", 4: "Great — thanks!", 5: "Excellent — you made our day!" };
				row.addEventListener("change", function () {
					var checked = row.querySelector("input:checked");
					var value = checked ? Number(checked.value) : 0;
					row.querySelectorAll("label").forEach(function (label, i) { label.classList.toggle("lit", i < value); });
					document.getElementById("ssz-caption").textContent = value ? captions[value] : "";
				});
			})();
			</script>
			<?php
		}
	}

	echo '<p style="margin-top:16px;"><a class="btn btn-secondary btn-sm" href="' . esc_url( home_url( '/' ) ) . '">← Back to the website</a></p>';
	echo '</div></main>';

	get_footer();
	exit;
} );

/* Public: feedback submission */
function ssz_handle_feedback() {
	$token = sanitize_text_field( wp_unslash( $_POST['ssz_token'] ?? '' ) );
	$base  = add_query_arg( 'ssz_feedback', $token, home_url( '/' ) );

	if ( ! isset( $_POST['ssz_feedback_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ssz_feedback_nonce'] ), 'ssz_feedback' ) ) {
		wp_safe_redirect( add_query_arg( 'ssz_fb_error', rawurlencode( 'Your session expired — please try again.' ), $base ) );
		exit;
	}

	$post_id = ssz_find_booking_by_token( $token );
	$rating  = max( 0, min( 5, (int) ( $_POST['ssz_rating'] ?? 0 ) ) );

	if ( ! $post_id || get_post_meta( $post_id, '_ssz_feedback_done', true ) ) {
		wp_safe_redirect( $base );
		exit;
	}
	if ( ! $rating ) {
		wp_safe_redirect( add_query_arg( 'ssz_fb_error', rawurlencode( 'Please choose a star rating before submitting.' ), $base ) );
		exit;
	}

	$b     = ssz_booking_data( $post_id );
	$fb_id = wp_insert_post( array(
		'post_type'   => 'ssz_feedback',
		'post_status' => 'publish',
		'post_title'  => $b['id'] . ' — ' . $b['name'] . ' (' . $b['property'] . ')',
	), true );

	if ( ! is_wp_error( $fb_id ) ) {
		update_post_meta( $fb_id, '_ssz_rating', $rating );
		update_post_meta( $fb_id, '_ssz_comments', sanitize_textarea_field( wp_unslash( $_POST['ssz_comments'] ?? '' ) ) );
		update_post_meta( $fb_id, '_ssz_booking', $post_id );
		update_post_meta( $post_id, '_ssz_feedback_done', 1 );
	}

	wp_safe_redirect( add_query_arg( 'ssz_thanks', '1', $base ) );
	exit;
}
add_action( 'admin_post_nopriv_ssz_feedback', 'ssz_handle_feedback' );
add_action( 'admin_post_ssz_feedback', 'ssz_handle_feedback' );
