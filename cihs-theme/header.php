<?php
/**
 * Site header.
 *
 * Layout (matching the CIHS reference design):
 *  Row 1 — Date/Time on the left, centred logo, search + MailUs on the right.
 *  Row 2 — primary navigation bar (menu names come from Appearance → Menus).
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

	<header id="masthead" class="site-header">

		<div class="cihs-header-top">
			<div class="cihs-container cihs-header-top__grid">

				<div class="cihs-header-datetime">
					<?php esc_html_e( 'Date/Time:', 'cihs' ); ?>
					<span id="cihs-datetime" data-server-time="<?php echo esc_attr( wp_date( 'd.m.Y H:i' ) ); ?>"><?php echo esc_html( wp_date( 'd.m.Y H:i' ) ); ?></span>
				</div>

				<div class="site-branding">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a class="cihs-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/cihs-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="430" height="92">
						</a>
					<?php endif; ?>
					<p class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				</div>

				<div class="cihs-header-tools">
					<button class="cihs-search-toggle" aria-controls="cihs-header-search" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open search', 'cihs' ); ?>">
						<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.2" y2="16.2"></line></svg>
					</button>
					<a class="cihs-mailus" href="mailto:<?php echo esc_attr( get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ) ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m2 7 10 6 10-6"></path></svg>
						<span><?php esc_html_e( 'MailUs', 'cihs' ); ?></span>
					</a>
				</div>

			</div>
		</div>

		<div class="cihs-header-nav">
			<div class="cihs-container cihs-header-nav__inner">
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

				<a class="cihs-btn cihs-btn--donate" href="<?php echo esc_url( home_url( '/support-cihs/' ) ); ?>"><?php esc_html_e( 'Donate', 'cihs' ); ?></a>
			</div>
		</div>

		<div id="cihs-header-search" class="cihs-header-search" hidden>
			<div class="cihs-container">
				<form role="search" method="get" class="cihs-header-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="cihs-header-search-field"><?php esc_html_e( 'Search the site', 'cihs' ); ?></label>
					<input type="search" id="cihs-header-search-field" name="s" placeholder="<?php esc_attr_e( 'Search publications, events, analysis…', 'cihs' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
					<button type="submit" class="cihs-btn"><?php esc_html_e( 'Search', 'cihs' ); ?></button>
				</form>
			</div>
		</div>

	</header>
