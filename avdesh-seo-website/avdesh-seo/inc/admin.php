<?php
/**
 * Admin tools: one-click content reset and setup.
 *
 * Adds a "Avdesh SEO" screen under Tools where the site owner can reset any
 * page or the blog posts back to the latest content shipped with the theme,
 * or re-run the automatic setup to create anything that is missing.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the admin page under Tools.
 */
function avseo_admin_menu() {
	add_management_page(
		__( 'Avdesh SEO Content', 'avdesh-seo' ),
		__( 'Avdesh SEO', 'avdesh-seo' ),
		'manage_options',
		'avseo-content',
		'avseo_admin_page'
	);
}
add_action( 'admin_menu', 'avseo_admin_menu' );

/**
 * Render the admin page and handle its actions.
 */
function avseo_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$notice = '';

	if ( isset( $_POST['avseo_action'] ) && check_admin_referer( 'avseo_tools', 'avseo_nonce' ) ) {
		$action = sanitize_text_field( wp_unslash( $_POST['avseo_action'] ) );
		$notice = avseo_handle_admin_action( $action );
	}

	$map = function_exists( 'avseo_page_map' ) ? avseo_page_map() : array();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Avdesh SEO Content Tools', 'avdesh-seo' ); ?></h1>

		<?php if ( $notice ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $notice ); ?></p></div>
		<?php endif; ?>

		<p><?php esc_html_e( 'Use these tools to load the latest content that ships with the theme. This is handy after a theme update.', 'avdesh-seo' ); ?></p>

		<div class="card" style="max-width:820px;padding:8px 20px 20px;">
			<h2><?php esc_html_e( 'Reset page content to the latest version', 'avdesh-seo' ); ?></h2>
			<p style="color:#b32d2e;">
				<strong><?php esc_html_e( 'Warning:', 'avdesh-seo' ); ?></strong>
				<?php esc_html_e( 'This replaces the current content of the selected pages with the latest theme content. Any edits you made to those pages will be overwritten. It does not touch your images, menus or settings.', 'avdesh-seo' ); ?>
			</p>
			<form method="post" onsubmit="return confirm('This will overwrite the content of the selected pages with the latest theme content. Continue?');">
				<?php wp_nonce_field( 'avseo_tools', 'avseo_nonce' ); ?>
				<input type="hidden" name="avseo_action" value="reset_pages">
				<table class="widefat striped" style="max-width:640px;margin:12px 0;">
					<thead><tr><th style="width:32px;"><input type="checkbox" checked onclick="document.querySelectorAll('.avseo-page-cb').forEach(function(c){c.checked=this.checked}.bind(this))"></th><th><?php esc_html_e( 'Page', 'avdesh-seo' ); ?></th><th><?php esc_html_e( 'URL', 'avdesh-seo' ); ?></th></tr></thead>
					<tbody>
					<?php foreach ( $map as $slug => $data ) : ?>
						<?php if ( 'blog' === $slug ) { continue; } ?>
						<tr>
							<td><input class="avseo-page-cb" type="checkbox" name="pages[]" value="<?php echo esc_attr( $slug ); ?>" checked></td>
							<td><strong><?php echo esc_html( $data['title'] ); ?></strong></td>
							<td><code>/<?php echo esc_html( 'home' === $slug ? '' : $slug . '/' ); ?></code></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php submit_button( __( 'Reset selected pages to latest content', 'avdesh-seo' ), 'primary', 'submit', false ); ?>
			</form>
		</div>

		<div class="card" style="max-width:820px;padding:8px 20px 20px;margin-top:20px;">
			<h2><?php esc_html_e( 'Reset the starter blog posts', 'avdesh-seo' ); ?></h2>
			<p><?php esc_html_e( 'Restores the three sample SEO articles to their latest version. Posts you wrote yourself are not affected.', 'avdesh-seo' ); ?></p>
			<form method="post" onsubmit="return confirm('Reset the three starter blog posts to the latest theme content?');">
				<?php wp_nonce_field( 'avseo_tools', 'avseo_nonce' ); ?>
				<input type="hidden" name="avseo_action" value="reset_posts">
				<?php submit_button( __( 'Reset starter blog posts', 'avdesh-seo' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>

		<div class="card" style="max-width:820px;padding:8px 20px 20px;margin-top:20px;">
			<h2><?php esc_html_e( 'Re-run automatic setup', 'avdesh-seo' ); ?></h2>
			<p><?php esc_html_e( 'Creates any pages, posts, menu items or permalinks that are missing. Existing content is left as it is.', 'avdesh-seo' ); ?></p>
			<form method="post">
				<?php wp_nonce_field( 'avseo_tools', 'avseo_nonce' ); ?>
				<input type="hidden" name="avseo_action" value="full_setup">
				<?php submit_button( __( 'Create anything missing', 'avdesh-seo' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Handle an admin action and return a message.
 *
 * @param string $action Action key.
 * @return string Result message.
 */
function avseo_handle_admin_action( $action ) {
	$map = function_exists( 'avseo_page_map' ) ? avseo_page_map() : array();

	if ( 'reset_pages' === $action ) {
		$requested = isset( $_POST['pages'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['pages'] ) ) : array();
		$count     = 0;
		foreach ( $requested as $slug ) {
			if ( ! isset( $map[ $slug ] ) ) {
				continue; // Only allow known theme pages.
			}
			$page = get_page_by_path( $slug );
			if ( ! $page ) {
				continue;
			}
			$content = function_exists( 'avseo_default_content' ) ? avseo_default_content( $slug ) : '';
			$update  = array( 'ID' => $page->ID );
			if ( '' !== $content ) {
				$update['post_content'] = $content;
			}
			if ( ! empty( $map[ $slug ]['excerpt'] ) ) {
				$update['post_excerpt'] = $map[ $slug ]['excerpt'];
			}
			if ( count( $update ) > 1 ) {
				wp_update_post( $update );
				$count++;
			}
		}
		/* translators: %d: number of pages updated. */
		return sprintf( _n( '%d page reset to the latest content.', '%d pages reset to the latest content.', $count, 'avdesh-seo' ), $count );
	}

	if ( 'reset_posts' === $action ) {
		if ( ! function_exists( 'avseo_default_posts' ) ) {
			return __( 'No starter posts available.', 'avdesh-seo' );
		}
		$count = 0;
		foreach ( avseo_default_posts() as $post ) {
			$existing = get_posts( array(
				'name'        => $post['slug'],
				'post_type'   => 'post',
				'post_status' => 'any',
				'numberposts' => 1,
			) );
			if ( empty( $existing ) ) {
				continue;
			}
			wp_update_post( array(
				'ID'           => $existing[0]->ID,
				'post_content' => $post['content'],
				'post_excerpt' => $post['excerpt'],
			) );
			$count++;
		}
		/* translators: %d: number of posts updated. */
		return sprintf( _n( '%d starter post reset.', '%d starter posts reset.', $count, 'avdesh-seo' ), $count );
	}

	if ( 'full_setup' === $action ) {
		if ( function_exists( 'avseo_activate_setup' ) ) {
			avseo_activate_setup();
			return __( 'Setup finished. Any missing pages, posts, menu items and permalinks were created.', 'avdesh-seo' );
		}
	}

	return __( 'Nothing to do.', 'avdesh-seo' );
}

/**
 * Show a friendly pointer to the tools page right after the theme is activated.
 */
function avseo_admin_activate_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! get_transient( 'avseo_just_activated' ) ) {
		return;
	}
	delete_transient( 'avseo_just_activated' );
	$url = admin_url( 'tools.php?page=avseo-content' );
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<strong><?php esc_html_e( 'Avdesh SEO is ready.', 'avdesh-seo' ); ?></strong>
			<?php esc_html_e( 'Your pages, menu and demo content have been created.', 'avdesh-seo' ); ?>
			<a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Open content tools', 'avdesh-seo' ); ?></a>
			<?php esc_html_e( 'to reset content to the latest version any time.', 'avdesh-seo' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'avseo_admin_activate_notice' );
