<?php
/**
 * Site header: top bar, branding, primary navigation.
 *
 * @package CIHS
 */
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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'cihs' ); ?></a>

	<div class="cihs-topbar">
		<div class="cihs-container">
			<div class="cihs-topbar__contact">
				<span>&#9742; <?php echo esc_html( get_theme_mod( 'cihs_phone', '011-46698734' ) ); ?></span>
				<span>&#9993; <a href="mailto:<?php echo esc_attr( get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ) ); ?></a></span>
			</div>
			<div class="cihs-topbar__social">
				<?php cihs_social_links(); ?>
			</div>
		</div>
	</div>

	<header id="masthead" class="site-header">
		<div class="cihs-container">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				}
				?>
				<div>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php $cihs_description = get_bloginfo( 'description', 'display' ); ?>
					<?php if ( $cihs_description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo esc_html( $cihs_description ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
				<?php esc_html_e( 'Menu ☰', 'cihs' ); ?>
			</button>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'cihs' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => 'wp_page_menu',
					)
				);
				?>
			</nav>
		</div>
	</header>
