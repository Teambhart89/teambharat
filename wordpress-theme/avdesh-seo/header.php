<?php
/**
 * Header
 *
 * @package Avdesh_SEO
 */

$phone    = avdesh_opt( 'avdesh_phone', '' );
$email    = avdesh_opt( 'avdesh_email', '' );
$location = avdesh_opt( 'avdesh_location', 'Delhi, India' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Top bar -->
<div class="topbar">
	<div class="container topbar-inner">
		<div class="tb-left">
			<span class="avail"><span class="dot"></span> Available for freelance SEO projects</span>
			<span class="hide-sm">📍 <?php echo esc_html( $location ); ?></span>
		</div>
		<div class="tb-right">
			<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">✆ <?php echo esc_html( $phone ); ?></a><?php endif; ?>
			<?php if ( $email ) : ?><a class="hide-sm" href="mailto:<?php echo esc_attr( $email ); ?>">✉ <?php echo esc_html( $email ); ?></a><?php endif; ?>
		</div>
	</div>
</div>

<header class="site-header">
	<div class="container header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="brand-mark">AK</span>
				<span>Avdesh Kumar
					<small><?php echo esc_html( avdesh_opt( 'avdesh_tagline', 'SEO & AI Search Consultant' ) ); ?></small>
				</span>
			<?php endif; ?>
		</a>

		<nav class="site-nav-wrap" aria-label="Primary">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'nav',
						'depth'          => 2,
					)
				);
			} else {
				avdesh_fallback_menu();
			}
			?>
		</nav>

		<div class="header-cta">
			<?php $wa = avdesh_whatsapp_url(); if ( $wa ) : ?>
				<a class="wa-btn" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
					<?php echo avdesh_whatsapp_svg( 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="wa-label">WhatsApp</span>
				</a>
			<?php endif; ?>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>">Free SEO Audit</a>
			<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'avdesh-seo' ); ?>" aria-expanded="false" aria-controls="primary-menu">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="content" class="site-content">
