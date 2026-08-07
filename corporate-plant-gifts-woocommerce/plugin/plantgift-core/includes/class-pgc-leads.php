<?php
/**
 * Bulk enquiry capture.
 *
 * The whole corporate gifting landing page exists to produce one of these, so
 * the form stores every submission in the database as well as emailing it. If
 * the mail server ever fails silently, the leads are still there.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lead capture.
 */
class PGC_Leads {

	const POST_TYPE = 'pg_lead';
	const NONCE     = 'pgc_lead_form';

	/**
	 * Hook in.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'admin_post_nopriv_pgc_lead', array( __CLASS__, 'handle' ) );
		add_action( 'admin_post_pgc_lead', array( __CLASS__, 'handle' ) );
		add_shortcode( 'plantgift_quote_form', array( __CLASS__, 'render_form' ) );

		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
	}

	/**
	 * Store enquiries as a private post type.
	 */
	public static function register_post_type() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'          => array(
					'name'          => __( 'Gifting Enquiries', 'plantgift-core' ),
					'singular_name' => __( 'Enquiry', 'plantgift-core' ),
					'menu_name'     => __( 'Enquiries', 'plantgift-core' ),
					'all_items'     => __( 'All Enquiries', 'plantgift-core' ),
					'search_items'  => __( 'Search Enquiries', 'plantgift-core' ),
					'not_found'     => __( 'No enquiries yet.', 'plantgift-core' ),
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-email-alt',
				'menu_position'   => 57,
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
				'supports'        => array( 'title' ),
				'has_archive'     => false,
				'rewrite'         => false,
				'exclude_from_search' => true,
			)
		);
	}

	/**
	 * Fields the form collects. Everything else is derived.
	 *
	 * @return array
	 */
	public static function fields() {
		return array(
			'name'     => array( 'label' => __( 'Your name', 'plantgift-core' ), 'type' => 'text', 'required' => true, 'autocomplete' => 'name' ),
			'company'  => array( 'label' => __( 'Company', 'plantgift-core' ), 'type' => 'text', 'required' => true, 'autocomplete' => 'organization' ),
			'email'    => array( 'label' => __( 'Work email', 'plantgift-core' ), 'type' => 'email', 'required' => true, 'autocomplete' => 'email' ),
			'phone'    => array( 'label' => __( 'Phone', 'plantgift-core' ), 'type' => 'tel', 'required' => true, 'autocomplete' => 'tel' ),
			'quantity' => array(
				'label'    => __( 'Approximate quantity', 'plantgift-core' ),
				'type'     => 'select',
				'required' => true,
				'options'  => array(
					''            => __( 'Select a range', 'plantgift-core' ),
					'under-25'    => __( 'Under 25 units', 'plantgift-core' ),
					'25-49'       => __( '25 to 49 units', 'plantgift-core' ),
					'50-99'       => __( '50 to 99 units', 'plantgift-core' ),
					'100-249'     => __( '100 to 249 units', 'plantgift-core' ),
					'250-499'     => __( '250 to 499 units', 'plantgift-core' ),
					'500-plus'    => __( '500 units and above', 'plantgift-core' ),
				),
			),
			'occasion' => array(
				'label'    => __( 'Occasion', 'plantgift-core' ),
				'type'     => 'select',
				'required' => false,
				'options'  => array(
					''             => __( 'Select an occasion', 'plantgift-core' ),
					'onboarding'   => __( 'Employee onboarding', 'plantgift-core' ),
					'anniversary'  => __( 'Work anniversary', 'plantgift-core' ),
					'client'       => __( 'Client appreciation', 'plantgift-core' ),
					'festive'      => __( 'Diwali or festive round', 'plantgift-core' ),
					'event'        => __( 'Event or conference', 'plantgift-core' ),
					'office'       => __( 'Office greening', 'plantgift-core' ),
					'other'        => __( 'Something else', 'plantgift-core' ),
				),
			),
			'budget'   => array( 'label' => __( 'Budget per gift', 'plantgift-core' ), 'type' => 'text', 'required' => false, 'placeholder' => __( 'For example 500 to 800', 'plantgift-core' ) ),
			'city'     => array( 'label' => __( 'Delivery city or cities', 'plantgift-core' ), 'type' => 'text', 'required' => false ),
			'message'  => array( 'label' => __( 'Anything else we should know', 'plantgift-core' ), 'type' => 'textarea', 'required' => false ),
		);
	}

	/**
	 * Render the enquiry form.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render_form( $atts = array() ) {
		$atts = shortcode_atts(
			array(
				'title'   => __( 'Get a bulk gifting quote', 'plantgift-core' ),
				'intro'   => __( 'Tell us the headcount and the budget. We reply with a shortlist, real photos and a landed cost within one working day.', 'plantgift-core' ),
				'button'  => __( 'Request my quote', 'plantgift-core' ),
				'compact' => 'no',
				'id'      => 'quote',
			),
			$atts,
			'plantgift_quote_form'
		);

		$compact = 'yes' === $atts['compact'];
		$fields  = self::fields();

		if ( $compact ) {
			$fields = array_intersect_key( $fields, array_flip( array( 'name', 'company', 'email', 'phone', 'quantity' ) ) );
		}

		$sent  = isset( $_GET['pg_sent'] ) ? sanitize_key( wp_unslash( $_GET['pg_sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$uid   = 'pgq-' . wp_unique_id();

		ob_start();
		?>
		<div class="pg-quote-form" id="<?php echo esc_attr( $atts['id'] ); ?>">

			<?php if ( 'ok' === $sent ) : ?>
				<div class="pg-quote-form__done" role="status">
					<span class="pg-quote-form__tick" aria-hidden="true"></span>
					<h3><?php esc_html_e( 'Thank you, that is with our gifting desk', 'plantgift-core' ); ?></h3>
					<p><?php esc_html_e( 'You will hear back within one working day, usually sooner. If it is urgent, call the number in the header and quote your company name.', 'plantgift-core' ); ?></p>
				</div>
			<?php else : ?>

				<?php if ( $atts['title'] ) : ?>
					<h2 class="pg-quote-form__title"><?php echo esc_html( $atts['title'] ); ?></h2>
				<?php endif; ?>
				<?php if ( $atts['intro'] ) : ?>
					<p class="pg-quote-form__intro"><?php echo esc_html( $atts['intro'] ); ?></p>
				<?php endif; ?>

				<?php if ( 'error' === $sent ) : ?>
					<p class="pg-quote-form__error" role="alert">
						<?php esc_html_e( 'Something was missing. Check the required fields and send it again.', 'plantgift-core' ); ?>
					</p>
				<?php endif; ?>

				<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="pg-quote-form__form<?php echo $compact ? ' is-compact' : ''; ?>">
					<input type="hidden" name="action" value="pgc_lead">
					<?php wp_nonce_field( self::NONCE, 'pgc_lead_nonce' ); ?>
					<input type="hidden" name="pg_source" value="<?php echo esc_attr( self::current_url() ); ?>">

					<?php // Honeypot. Real people never fill this in, bots usually do. ?>
					<div class="pg-hp" aria-hidden="true">
						<label for="<?php echo esc_attr( $uid ); ?>-website"><?php esc_html_e( 'Leave this field empty', 'plantgift-core' ); ?></label>
						<input type="text" id="<?php echo esc_attr( $uid ); ?>-website" name="pg_website" tabindex="-1" autocomplete="off">
					</div>
					<input type="hidden" name="pg_started" value="<?php echo esc_attr( time() ); ?>">

					<div class="pg-quote-form__grid">
						<?php foreach ( $fields as $key => $field ) : ?>
							<?php
							$id   = $uid . '-' . $key;
							$wide = in_array( $key, array( 'message' ), true );
							?>
							<div class="pg-field<?php echo $wide ? ' pg-field--wide' : ''; ?>">
								<label for="<?php echo esc_attr( $id ); ?>">
									<?php echo esc_html( $field['label'] ); ?>
									<?php if ( ! empty( $field['required'] ) ) : ?>
										<span class="pg-req" aria-hidden="true">*</span>
									<?php endif; ?>
								</label>

								<?php if ( 'select' === $field['type'] ) : ?>
									<select id="<?php echo esc_attr( $id ); ?>" name="pg_<?php echo esc_attr( $key ); ?>" <?php echo ! empty( $field['required'] ) ? 'required' : ''; ?>>
										<?php foreach ( $field['options'] as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>

								<?php elseif ( 'textarea' === $field['type'] ) : ?>
									<textarea id="<?php echo esc_attr( $id ); ?>" name="pg_<?php echo esc_attr( $key ); ?>" rows="3"></textarea>

								<?php else : ?>
									<input
										type="<?php echo esc_attr( $field['type'] ); ?>"
										id="<?php echo esc_attr( $id ); ?>"
										name="pg_<?php echo esc_attr( $key ); ?>"
										<?php echo ! empty( $field['autocomplete'] ) ? 'autocomplete="' . esc_attr( $field['autocomplete'] ) . '"' : ''; ?>
										<?php echo ! empty( $field['placeholder'] ) ? 'placeholder="' . esc_attr( $field['placeholder'] ) . '"' : ''; ?>
										<?php echo ! empty( $field['required'] ) ? 'required' : ''; ?>>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<button type="submit" class="pg-btn pg-btn--action pg-btn--lg pg-btn--block">
						<?php echo esc_html( $atts['button'] ); ?>
					</button>

					<p class="pg-quote-form__note">
						<?php esc_html_e( 'No obligation. We never share your details, and one email is all you get unless you reply.', 'plantgift-core' ); ?>
					</p>
				</form>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * The URL the form was submitted from.
	 *
	 * @return string
	 */
	private static function current_url() {
		global $wp;
		return home_url( add_query_arg( array(), $wp->request ) );
	}

	/**
	 * Validate, store and notify.
	 */
	public static function handle() {
		$referer = wp_get_referer() ? wp_get_referer() : home_url( '/' );

		if ( ! isset( $_POST['pgc_lead_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['pgc_lead_nonce'] ) ), self::NONCE ) ) {
			wp_safe_redirect( add_query_arg( 'pg_sent', 'error', $referer ) );
			exit;
		}

		// Honeypot filled, or the form was submitted implausibly fast.
		$trap    = isset( $_POST['pg_website'] ) ? trim( wp_unslash( $_POST['pg_website'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$started = isset( $_POST['pg_started'] ) ? absint( wp_unslash( $_POST['pg_started'] ) ) : 0;
		if ( '' !== $trap || ( $started && ( time() - $started ) < 3 ) ) {
			// Behave as though it worked so the bot does not retry.
			wp_safe_redirect( add_query_arg( 'pg_sent', 'ok', $referer ) . '#quote' );
			exit;
		}

		$data   = array();
		$errors = array();

		foreach ( self::fields() as $key => $field ) {
			$raw = isset( $_POST[ 'pg_' . $key ] ) ? wp_unslash( $_POST[ 'pg_' . $key ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

			if ( 'email' === $field['type'] ) {
				$value = sanitize_email( $raw );
				if ( $value && ! is_email( $value ) ) {
					$errors[] = $key;
					$value    = '';
				}
			} elseif ( 'textarea' === $field['type'] ) {
				$value = sanitize_textarea_field( $raw );
			} else {
				$value = sanitize_text_field( $raw );
			}

			if ( ! empty( $field['required'] ) && '' === $value ) {
				$errors[] = $key;
			}

			$data[ $key ] = $value;
		}

		if ( $errors ) {
			wp_safe_redirect( add_query_arg( 'pg_sent', 'error', $referer ) . '#quote' );
			exit;
		}

		$source = isset( $_POST['pg_source'] ) ? esc_url_raw( wp_unslash( $_POST['pg_source'] ) ) : '';

		$lead_id = wp_insert_post(
			array(
				'post_type'   => self::POST_TYPE,
				'post_status' => 'publish',
				'post_title'  => sprintf(
					/* translators: 1: company, 2: quantity range. */
					__( '%1$s, %2$s', 'plantgift-core' ),
					$data['company'],
					self::quantity_label( $data['quantity'] )
				),
			)
		);

		if ( ! is_wp_error( $lead_id ) && $lead_id ) {
			foreach ( $data as $key => $value ) {
				update_post_meta( $lead_id, '_pg_' . $key, $value );
			}
			update_post_meta( $lead_id, '_pg_source', $source );
			self::notify( $data, $source, $lead_id );
		}

		wp_safe_redirect( add_query_arg( 'pg_sent', 'ok', $referer ) . '#quote' );
		exit;
	}

	/**
	 * Readable label for a stored quantity key.
	 *
	 * @param string $key Stored value.
	 * @return string
	 */
	private static function quantity_label( $key ) {
		$fields = self::fields();
		$map    = $fields['quantity']['options'];
		return isset( $map[ $key ] ) && $map[ $key ] ? $map[ $key ] : $key;
	}

	/**
	 * Email the gifting desk.
	 *
	 * @param array  $data    Submitted values.
	 * @param string $source  Page the form was on.
	 * @param int    $lead_id Stored post id.
	 */
	private static function notify( $data, $source, $lead_id ) {
		$to = get_theme_mod( 'plantgift_email', '' );
		if ( ! $to || ! is_email( $to ) ) {
			$to = get_option( 'admin_email' );
		}

		$lines = array();
		foreach ( self::fields() as $key => $field ) {
			$value = $data[ $key ];
			if ( 'quantity' === $key ) {
				$value = self::quantity_label( $value );
			}
			if ( '' === $value ) {
				continue;
			}
			$lines[] = $field['label'] . ': ' . $value;
		}

		if ( $source ) {
			$lines[] = '';
			$lines[] = __( 'Submitted from:', 'plantgift-core' ) . ' ' . $source;
		}
		$lines[] = __( 'View in admin:', 'plantgift-core' ) . ' ' . admin_url( 'post.php?post=' . $lead_id . '&action=edit' );

		$subject = sprintf(
			/* translators: 1: company name, 2: quantity. */
			__( 'Gifting enquiry: %1$s, %2$s', 'plantgift-core' ),
			$data['company'],
			self::quantity_label( $data['quantity'] )
		);

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		if ( is_email( $data['email'] ) ) {
			$headers[] = 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>';
		}

		wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
	}

	/**
	 * Admin list columns.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public static function columns( $columns ) {
		return array(
			'cb'       => isset( $columns['cb'] ) ? $columns['cb'] : '',
			'title'    => __( 'Enquiry', 'plantgift-core' ),
			'contact'  => __( 'Contact', 'plantgift-core' ),
			'quantity' => __( 'Quantity', 'plantgift-core' ),
			'occasion' => __( 'Occasion', 'plantgift-core' ),
			'date'     => __( 'Received', 'plantgift-core' ),
		);
	}

	/**
	 * Admin list column output.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Lead id.
	 */
	public static function column( $column, $post_id ) {
		switch ( $column ) {
			case 'contact':
				$email = get_post_meta( $post_id, '_pg_email', true );
				$phone = get_post_meta( $post_id, '_pg_phone', true );
				echo esc_html( get_post_meta( $post_id, '_pg_name', true ) ) . '<br>';
				if ( $email ) {
					printf( '<a href="mailto:%1$s">%1$s</a><br>', esc_attr( $email ) );
				}
				echo esc_html( $phone );
				break;
			case 'quantity':
				echo esc_html( self::quantity_label( get_post_meta( $post_id, '_pg_quantity', true ) ) );
				break;
			case 'occasion':
				echo esc_html( get_post_meta( $post_id, '_pg_occasion', true ) );
				break;
		}
	}

	/**
	 * Detail box on a single enquiry.
	 */
	public static function meta_box() {
		add_meta_box(
			'pgc_lead_detail',
			__( 'Enquiry detail', 'plantgift-core' ),
			array( __CLASS__, 'meta_box_html' ),
			self::POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Render the detail box.
	 *
	 * @param WP_Post $post Lead.
	 */
	public static function meta_box_html( $post ) {
		echo '<table class="widefat striped"><tbody>';
		foreach ( self::fields() as $key => $field ) {
			$value = get_post_meta( $post->ID, '_pg_' . $key, true );
			if ( 'quantity' === $key ) {
				$value = self::quantity_label( $value );
			}
			printf(
				'<tr><th style="width:220px;">%s</th><td>%s</td></tr>',
				esc_html( $field['label'] ),
				esc_html( $value )
			);
		}
		$source = get_post_meta( $post->ID, '_pg_source', true );
		if ( $source ) {
			printf(
				'<tr><th>%s</th><td><a href="%s" target="_blank" rel="noopener">%s</a></td></tr>',
				esc_html__( 'Submitted from', 'plantgift-core' ),
				esc_url( $source ),
				esc_html( $source )
			);
		}
		echo '</tbody></table>';
	}
}
