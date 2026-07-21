<?php
/**
 * Template Name: Services Overview
 *
 * A hub page listing every service with a card grid.
 *
 * @package Avdesh_SEO
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Services</span></nav>
		<span class="eyebrow">What I offer</span>
		<h1>SEO, AI Search &amp; Google Ads Services</h1>
		<p class="lead">A complete set of white-hat services to grow your organic traffic, rankings and revenue across Google and modern AI search platforms.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-3">
			<?php
			$i = 1;
			foreach ( array_keys( avdesh_services() ) as $slug ) {
				avdesh_service_card( $slug, sprintf( '%02d', $i ) );
				$i++;
			}
			?>
		</div>
	</div>
</section>

<?php avdesh_cta_band(); ?>
<?php get_footer(); ?>
