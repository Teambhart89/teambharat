<?php
/**
 * Site header.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to main content', 'saltstayz' ); ?></a>

<header class="site-header">
	<div class="header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home">
			<span class="brand-mark" aria-hidden="true">S</span>
			<?php echo esc_html( get_bloginfo( 'name' ) ?: 'SaltStayz' ); ?>
		</a>
		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'saltstayz' ); ?>">
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#apartments' ) ); ?>">Apartments</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#locations' ) ); ?>">Locations</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#amenities' ) ); ?>">Amenities</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#book' ) ); ?>">Book Now</a></li>
			</ul>
		</nav>
		<div class="header-actions">
			<a class="btn btn-ghost" href="<?php echo esc_url( admin_url( 'edit.php?post_type=ssz_booking' ) ); ?>">Operator login</a>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#book' ) ); ?>">Book your stay</a>
		</div>
	</div>
</header>
