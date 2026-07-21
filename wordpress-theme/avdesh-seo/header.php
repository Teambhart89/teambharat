<?php
/**
 * Header
 *
 * @package Avdesh_SEO
 */

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

<header class="site-header">
	<div class="container header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> home">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="brand-mark">AK</span>
				<span>Avdesh Kumar
					<small><?php echo esc_html( avdesh_opt( 'avdesh_tagline', 'SEO & AI Search Specialist' ) ); ?></small>
				</span>
			<?php endif; ?>
		</a>

		<div class="site-nav-wrap">
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
		</div>

		<div class="header-cta">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Free Consultation</a>
			<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'avdesh-seo' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="content" class="site-content">
