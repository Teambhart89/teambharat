<?php
/**
 * Header template.
 *
 * @package Avdesh_SEO
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main">Skip to content</a>

<header class="site-header">
	<div class="container">
		<nav class="nav" aria-label="Primary">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					$name = avseo_info( 'name' );
					echo esc_html( $name ) . '<span class="brand-dot">.</span>';
				}
				?>
			</a>

			<button class="nav-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'avdesh-seo' ); ?>">
				<span></span><span></span><span></span>
			</button>

			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'depth'          => 2,
				) );
			} else {
				avseo_fallback_menu();
			}
			?>

			<div class="nav-cta">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Free SEO Audit</a>
			</div>
		</nav>
	</div>
</header>

<main id="main">
