<?php
/**
 * The one click setup screen.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin screen and AJAX handlers.
 */
class PGC_Admin {

	/**
	 * Hook everything up.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'wp_ajax_pgc_run_step', array( __CLASS__, 'ajax_run_step' ) );
		add_action( 'admin_init', array( __CLASS__, 'maybe_redirect' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( PLANTGIFT_CORE_FILE ), array( __CLASS__, 'action_links' ) );
	}

	/**
	 * Add the settings link on the plugins screen.
	 *
	 * @param array $links Existing links.
	 * @return array
	 */
	public static function action_links( $links ) {
		array_unshift(
			$links,
			'<a href="' . esc_url( admin_url( 'admin.php?page=plantgift-setup' ) ) . '">' . esc_html__( 'Setup', 'plantgift-core' ) . '</a>'
		);
		return $links;
	}

	/**
	 * Send the user to the setup screen right after activation.
	 */
	public static function maybe_redirect() {
		if ( ! get_transient( 'plantgift_core_activation_redirect' ) ) {
			return;
		}
		delete_transient( 'plantgift_core_activation_redirect' );
		if ( isset( $_GET['activate-multi'] ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		wp_safe_redirect( admin_url( 'admin.php?page=plantgift-setup' ) );
		exit;
	}

	/**
	 * Register the menu item.
	 */
	public static function menu() {
		add_menu_page(
			__( 'PlantGift Setup', 'plantgift-core' ),
			__( 'PlantGift', 'plantgift-core' ),
			'manage_options',
			'plantgift-setup',
			array( __CLASS__, 'render' ),
			'dashicons-palmtree',
			56
		);
	}

	/**
	 * Load the setup screen script and styles.
	 *
	 * @param string $hook Current admin page.
	 */
	public static function assets( $hook ) {
		if ( 'toplevel_page_plantgift-setup' !== $hook ) {
			return;
		}

		wp_register_script( 'pgc-setup', '', array(), PLANTGIFT_CORE_VERSION, true );
		wp_enqueue_script( 'pgc-setup' );
		wp_localize_script(
			'pgc-setup',
			'pgcSetup',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'pgc_setup' ),
				'i18n'    => array(
					'running'  => __( 'Running', 'plantgift-core' ),
					'done'     => __( 'Done', 'plantgift-core' ),
					'failed'   => __( 'Failed', 'plantgift-core' ),
					'confirm'  => __( 'This deletes the generated categories, products and pages. Continue?', 'plantgift-core' ),
					'allDone'  => __( 'Setup complete. Visit your site to see the store.', 'plantgift-core' ),
				),
			)
		);
		wp_add_inline_script( 'pgc-setup', self::script() );

		wp_register_style( 'pgc-setup', false, array(), PLANTGIFT_CORE_VERSION );
		wp_enqueue_style( 'pgc-setup' );
		wp_add_inline_style( 'pgc-setup', self::style() );
	}

	/**
	 * The setup screen markup.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to view this page.', 'plantgift-core' ) );
		}

		$state    = get_option( 'plantgift_core_setup_state', array() );
		$has_woo  = class_exists( 'WooCommerce' );
		$theme_ok = 'plantgift-pro' === get_template();

		$steps = array(
			'attributes' => array(
				__( 'Pot attributes', 'plantgift-core' ),
				__( 'Creates pot size, pot material, pot design, plant type, light requirement and packaging as global attributes with all their options.', 'plantgift-core' ),
			),
			'categories' => array(
				__( 'Gift categories', 'plantgift-core' ),
				__( 'Creates 18 product categories with SEO friendly slugs, search snippets, intro copy and long form body content with a full heading structure.', 'plantgift-core' ),
			),
			'products'   => array(
				__( 'Plant catalogue', 'plantgift-core' ),
				__( 'Builds the variable products and every pot size, material and design combination. This step runs in batches and takes the longest.', 'plantgift-core' ),
			),
			'pages'      => array(
				__( 'Service and core pages', 'plantgift-core' ),
				__( 'Creates ten service pages with ten questions and answers each, plus home, about, contact, FAQ, journal and policy pages.', 'plantgift-core' ),
			),
			'menus'      => array(
				__( 'Navigation menus', 'plantgift-core' ),
				__( 'Builds the primary menu with shop and service dropdowns, three footer columns and a legal menu, then assigns them to theme locations.', 'plantgift-core' ),
			),
			'settings'   => array(
				__( 'Permalinks and options', 'plantgift-core' ),
				__( 'Sets post name permalinks, short WooCommerce bases, catalogue defaults and seeds the shop sidebar with category and filter widgets.', 'plantgift-core' ),
			),
		);
		?>
		<div class="wrap pgc-wrap">
			<h1><?php esc_html_e( 'PlantGift store setup', 'plantgift-core' ); ?></h1>
			<p class="pgc-lede"><?php esc_html_e( 'Run the steps in order. Each one is safe to run again, so you can rebuild a single step without touching the rest.', 'plantgift-core' ); ?></p>

			<?php if ( ! $has_woo ) : ?>
				<div class="notice notice-error inline"><p>
					<?php esc_html_e( 'WooCommerce is not active. Install and activate it before running setup.', 'plantgift-core' ); ?>
				</p></div>
			<?php endif; ?>

			<?php if ( ! $theme_ok ) : ?>
				<div class="notice notice-warning inline"><p>
					<?php esc_html_e( 'The PlantGift Pro theme is not active. Setup still works, but service page layouts and the shop design need that theme.', 'plantgift-core' ); ?>
				</p></div>
			<?php endif; ?>

			<div class="pgc-actions">
				<button type="button" class="button button-primary button-hero" id="pgc-run-all" <?php disabled( ! $has_woo ); ?>>
					<?php esc_html_e( 'Run every step', 'plantgift-core' ); ?>
				</button>
				<span class="pgc-global-status" id="pgc-global-status"></span>
			</div>

			<ol class="pgc-steps">
				<?php foreach ( $steps as $key => $step ) : ?>
					<li class="pgc-step" data-step="<?php echo esc_attr( $key ); ?>">
						<div class="pgc-step__head">
							<h2><?php echo esc_html( $step[0] ); ?></h2>
							<span class="pgc-badge <?php echo empty( $state[ $key ] ) ? 'is-pending' : 'is-done'; ?>" data-badge>
								<?php echo empty( $state[ $key ] ) ? esc_html__( 'Not run', 'plantgift-core' ) : esc_html__( 'Done', 'plantgift-core' ); ?>
							</span>
						</div>
						<p><?php echo esc_html( $step[1] ); ?></p>
						<div class="pgc-step__foot">
							<button type="button" class="button" data-run <?php disabled( ! $has_woo ); ?>>
								<?php esc_html_e( 'Run this step', 'plantgift-core' ); ?>
							</button>
							<span class="pgc-msg" data-msg></span>
						</div>
						<div class="pgc-bar" data-bar hidden><span></span></div>
					</li>
				<?php endforeach; ?>
			</ol>

			<h2><?php esc_html_e( 'After setup', 'plantgift-core' ); ?></h2>
			<ol class="pgc-after">
				<li><?php esc_html_e( 'Replace the generated placeholder images with your own photography in Media and on each product.', 'plantgift-core' ); ?></li>
				<li><?php esc_html_e( 'Open Appearance then Customize to set the logo, phone number, email address and business details used in structured data.', 'plantgift-core' ); ?></li>
				<li><?php esc_html_e( 'Set your currency, tax rules, shipping zones and payment gateways in WooCommerce settings.', 'plantgift-core' ); ?></li>
				<li><?php esc_html_e( 'Review the prices generated for each pot combination and adjust them to your real costs.', 'plantgift-core' ); ?></li>
				<li><?php esc_html_e( 'Submit your sitemap to Google Search Console once the site is live.', 'plantgift-core' ); ?></li>
			</ol>

			<h2><?php esc_html_e( 'Start over', 'plantgift-core' ); ?></h2>
			<p><?php esc_html_e( 'Removes the generated categories, products and pages so you can run setup from scratch. Attributes, menus and settings are left alone.', 'plantgift-core' ); ?></p>
			<p><button type="button" class="button button-link-delete" id="pgc-reset"><?php esc_html_e( 'Delete generated content', 'plantgift-core' ); ?></button></p>
		</div>
		<?php
	}

	/**
	 * Handle a step request.
	 */
	public static function ajax_run_step() {
		check_ajax_referer( 'pgc_setup', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'plantgift-core' ) ), 403 );
		}

		$step   = isset( $_POST['step'] ) ? sanitize_key( wp_unslash( $_POST['step'] ) ) : '';
		$offset = isset( $_POST['offset'] ) ? absint( wp_unslash( $_POST['offset'] ) ) : 0;

		// Long running batches should not be cut short by a default time limit.
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 120 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		}

		switch ( $step ) {
			case 'attributes':
				$result = PGC_Installer::install_attributes();
				break;
			case 'categories':
				$result = PGC_Installer::install_categories();
				break;
			case 'products':
				$result = PGC_Installer::install_products( $offset );
				break;
			case 'pages':
				$result = PGC_Installer::install_pages();
				break;
			case 'menus':
				$result = PGC_Installer::install_menus();
				break;
			case 'settings':
				$result = PGC_Installer::install_settings();
				break;
			case 'reset':
				$result = PGC_Installer::reset_content();
				break;
			default:
				wp_send_json_error( array( 'message' => __( 'Unknown step.', 'plantgift-core' ) ), 400 );
		}

		wp_send_json_success( $result );
	}

	/**
	 * Inline script for the setup screen.
	 *
	 * @return string
	 */
	private static function script() {
		return <<<'JS'
( function () {
	'use strict';

	function post( step, offset ) {
		var body = new URLSearchParams();
		body.append( 'action', 'pgc_run_step' );
		body.append( 'nonce', pgcSetup.nonce );
		body.append( 'step', step );
		body.append( 'offset', offset || 0 );

		return fetch( pgcSetup.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString()
		} ).then( function ( r ) { return r.json(); } );
	}

	function runStep( li ) {
		var step = li.getAttribute( 'data-step' );
		var msg = li.querySelector( '[data-msg]' );
		var badge = li.querySelector( '[data-badge]' );
		var bar = li.querySelector( '[data-bar]' );
		var fill = bar ? bar.querySelector( 'span' ) : null;
		var button = li.querySelector( '[data-run]' );

		badge.className = 'pgc-badge is-running';
		badge.textContent = pgcSetup.i18n.running;
		msg.textContent = '';
		button.disabled = true;

		return new Promise( function ( resolve, reject ) {
			function loop( offset ) {
				post( step, offset ).then( function ( res ) {
					if ( ! res || ! res.success ) {
						badge.className = 'pgc-badge is-failed';
						badge.textContent = pgcSetup.i18n.failed;
						msg.textContent = res && res.data ? res.data.message : '';
						button.disabled = false;
						reject();
						return;
					}

					var data = res.data;
					msg.textContent = data.message || '';

					if ( typeof data.progress === 'number' && bar && fill ) {
						bar.hidden = false;
						fill.style.width = data.progress + '%';
					}

					if ( data.done ) {
						badge.className = 'pgc-badge is-done';
						badge.textContent = pgcSetup.i18n.done;
						button.disabled = false;
						resolve();
					} else {
						loop( data.offset );
					}
				} ).catch( function () {
					badge.className = 'pgc-badge is-failed';
					badge.textContent = pgcSetup.i18n.failed;
					button.disabled = false;
					reject();
				} );
			}
			loop( 0 );
		} );
	}

	document.querySelectorAll( '.pgc-step [data-run]' ).forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			runStep( button.closest( '.pgc-step' ) );
		} );
	} );

	var runAll = document.getElementById( 'pgc-run-all' );
	if ( runAll ) {
		runAll.addEventListener( 'click', function () {
			var steps = Array.prototype.slice.call( document.querySelectorAll( '.pgc-step' ) );
			var status = document.getElementById( 'pgc-global-status' );
			runAll.disabled = true;

			steps.reduce( function ( chain, li ) {
				return chain.then( function () { return runStep( li ); } );
			}, Promise.resolve() ).then( function () {
				status.textContent = pgcSetup.i18n.allDone;
				runAll.disabled = false;
			} ).catch( function () {
				runAll.disabled = false;
			} );
		} );
	}

	var reset = document.getElementById( 'pgc-reset' );
	if ( reset ) {
		reset.addEventListener( 'click', function () {
			if ( ! window.confirm( pgcSetup.i18n.confirm ) ) {
				return;
			}
			reset.disabled = true;
			post( 'reset', 0 ).then( function () {
				window.location.reload();
			} );
		} );
	}
} )();
JS;
	}

	/**
	 * Inline styles for the setup screen.
	 *
	 * @return string
	 */
	private static function style() {
		return '
		.pgc-wrap { max-width: 860px; }
		.pgc-lede { font-size: 15px; max-width: 62ch; }
		.pgc-actions { display: flex; align-items: center; gap: 16px; margin: 20px 0 28px; flex-wrap: wrap; }
		.pgc-global-status { color: #1f5136; font-weight: 600; }
		.pgc-steps { counter-reset: pgc; list-style: none; margin: 0; padding: 0; display: grid; gap: 14px; }
		.pgc-step { background: #fff; border: 1px solid #dcdcde; border-left: 4px solid #2f8055; border-radius: 6px; padding: 16px 18px; }
		.pgc-step__head { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
		.pgc-step h2 { margin: 0; font-size: 15px; }
		.pgc-step p { color: #50575e; margin: 6px 0 12px; max-width: 70ch; }
		.pgc-step__foot { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
		.pgc-msg { color: #50575e; font-size: 13px; }
		.pgc-badge { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; padding: 3px 10px; border-radius: 999px; white-space: nowrap; }
		.pgc-badge.is-pending { background: #f0f0f1; color: #646970; }
		.pgc-badge.is-running { background: #fcf3d7; color: #8a6116; }
		.pgc-badge.is-done { background: #dcefe3; color: #1f5136; }
		.pgc-badge.is-failed { background: #fbeaea; color: #8a1f11; }
		.pgc-bar { margin-top: 12px; height: 6px; background: #f0f0f1; border-radius: 999px; overflow: hidden; }
		.pgc-bar span { display: block; height: 100%; width: 0; background: #2f8055; transition: width .25s ease; }
		.pgc-after { max-width: 70ch; color: #50575e; }
		';
	}
}
