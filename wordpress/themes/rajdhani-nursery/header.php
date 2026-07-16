<?php
/**
 * Theme header.
 *
 * @package Rajdhani_Nursery
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="rn-topbar">
	<div class="rn-container">
		<span>🕖 <?php echo esc_html( rn_get_option( 'hours' ) ); ?></span>
		<span>
			📞 <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', rn_get_option( 'phone' ) ) ); ?>"><?php echo esc_html( rn_get_option( 'phone' ) ); ?></a>
			&nbsp;|&nbsp;
			✉️ <a href="mailto:<?php echo esc_attr( rn_get_option( 'email' ) ); ?>"><?php echo esc_html( rn_get_option( 'email' ) ); ?></a>
		</span>
	</div>
</div>

<header class="rn-header">
	<div class="rn-container rn-header-inner">
		<div class="rn-logo">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="rn-logo-mark" aria-hidden="true">🌱</span>
			<?php endif; ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
				<small><?php esc_html_e( 'Mali On Rent & Gardening Services, Delhi', 'rajdhani-nursery' ); ?></small>
			</a>
		</div>

		<nav class="rn-nav" id="rn-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'rajdhani-nursery' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => 'rn_fallback_menu',
				)
			);
			?>
		</nav>

		<div class="rn-header-cta">
			<a class="rn-btn rn-btn-sm" href="<?php echo esc_url( home_url( '/book-maali-online/' ) ); ?>"><?php esc_html_e( 'Book Maali', 'rajdhani-nursery' ); ?></a>
			<button class="rn-nav-toggle" id="rn-nav-toggle" aria-expanded="false" aria-controls="rn-nav">☰ <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'rajdhani-nursery' ); ?></span></button>
		</div>
	</div>
</header>
