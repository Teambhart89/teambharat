<?php
/**
 * Site header.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#pg-main"><?php esc_html_e( 'Skip to main content', 'plantgift-pro' ); ?></a>

<div id="page" class="pg-site">

	<?php
	$phone   = get_theme_mod( 'plantgift_phone', '+91 00000 00000' );
	$email   = get_theme_mod( 'plantgift_email', 'gifting@example.com' );
	$promo   = get_theme_mod( 'plantgift_topbar_text', __( 'Free design mockup on orders above 100 units', 'plantgift-pro' ) );
	?>
	<div class="pg-topbar">
		<div class="pg-wrap pg-topbar__inner">
			<p style="margin:0;"><?php echo esc_html( $promo ); ?></p>
			<ul class="pg-topbar__list">
				<?php if ( $phone ) : ?>
					<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php plantgift_pro_the_icon( 'phone', 14 ); ?> <?php echo esc_html( $phone ); ?></a></li>
				<?php endif; ?>
				<?php if ( $email ) : ?>
					<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php plantgift_pro_the_icon( 'mail', 14 ); ?> <?php echo esc_html( $email ); ?></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<header id="masthead" class="pg-header">
		<div class="pg-wrap pg-header__inner">

			<?php plantgift_pro_brand(); ?>

			<nav id="site-navigation" class="pg-nav" data-pg-nav data-open="false" aria-label="<?php esc_attr_e( 'Primary navigation', 'plantgift-pro' ); ?>">
				<button class="pg-icon-btn pg-nav-close" data-pg-nav-close type="button">
					<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'plantgift-pro' ); ?></span>
					<?php plantgift_pro_the_icon( 'close', 20 ); ?>
				</button>
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => 'div',
							'depth'          => 3,
							'fallback_cb'    => false,
						)
					);
				} else {
					echo '<div><ul>';
					wp_list_pages( array( 'title_li' => '', 'depth' => 2 ) );
					echo '</ul></div>';
				}
				?>
			</nav>

			<div class="pg-header__actions">
				<a class="pg-icon-btn" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Search the store', 'plantgift-pro' ); ?>">
					<?php plantgift_pro_the_icon( 'search', 20 ); ?>
				</a>

				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a class="pg-icon-btn" href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" aria-label="<?php esc_attr_e( 'My account', 'plantgift-pro' ); ?>">
						<?php plantgift_pro_the_icon( 'user', 20 ); ?>
					</a>
					<a class="pg-icon-btn pg-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'View cart', 'plantgift-pro' ); ?>">
						<?php plantgift_pro_the_icon( 'cart', 20 ); ?>
						<span class="pg-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
					</a>
				<?php endif; ?>

				<?php
				$cta_url  = get_theme_mod( 'plantgift_header_cta_url', home_url( '/corporate-plant-gifting/' ) );
				$cta_text = get_theme_mod( 'plantgift_header_cta_text', __( 'Request a quote', 'plantgift-pro' ) );
				if ( $cta_text ) :
					?>
					<a class="pg-btn pg-btn--action pg-header__cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
				<?php endif; ?>

				<button class="pg-icon-btn pg-burger" data-pg-nav-toggle type="button" aria-expanded="false" aria-controls="site-navigation">
					<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'plantgift-pro' ); ?></span>
					<?php plantgift_pro_the_icon( 'menu', 20 ); ?>
				</button>
			</div>

		</div>
	</header>

	<div class="pg-scrim" data-pg-scrim data-open="false" hidden></div>

	<?php plantgift_pro_breadcrumbs(); ?>

	<main id="pg-main" class="pg-main">
