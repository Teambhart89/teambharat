<?php
/**
 * Site header.
 *
 * @package epoojabooking
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="epb-skip-link" href="#epb-main"><?php esc_html_e( 'Skip to content', 'epoojabooking' ); ?></a>

<header class="epb-header" id="epb-header">
	<div class="epb-container epb-header-inner">
		<div class="epb-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="epb-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="epoojabooking home">
					<svg class="epb-logo-mark" viewBox="0 0 32 32" width="34" height="34" aria-hidden="true" focusable="false">
						<circle cx="16" cy="16" r="15" fill="none" stroke="currentColor" stroke-width="1.5"/>
						<path d="M16 5 L19 12 L26 12.5 L20.5 17 L22.5 24 L16 20 L9.5 24 L11.5 17 L6 12.5 L13 12 Z" fill="currentColor" opacity="0.15"/>
						<path d="M16 8 c-3 3 -5 5.5 -5 8.5 a5 5 0 0 0 10 0 C21 13.5 19 11 16 8 Z" fill="currentColor"/>
					</svg>
					<span class="epb-logo-text">epooja<span>booking</span></span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="epb-nav" id="epb-nav" aria-label="<?php esc_attr_e( 'Primary', 'epoojabooking' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'epb-nav-list',
				'container'      => false,
				'fallback_cb'    => 'epb_fallback_menu',
			) );
			?>
		</nav>

		<div class="epb-header-actions">
			<a class="epb-btn epb-btn-primary epb-header-cta" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>">
				<?php esc_html_e( 'Book Puja Now', 'epoojabooking' ); ?>
			</a>
			<button class="epb-nav-toggle" aria-expanded="false" aria-controls="epb-nav" aria-label="<?php esc_attr_e( 'Open menu', 'epoojabooking' ); ?>">
				<span class="epb-nav-toggle-bar" aria-hidden="true"></span>
				<span class="epb-nav-toggle-bar" aria-hidden="true"></span>
				<span class="epb-nav-toggle-bar" aria-hidden="true"></span>
			</button>
		</div>
	</div>
</header>

<main id="epb-main" class="epb-main">
