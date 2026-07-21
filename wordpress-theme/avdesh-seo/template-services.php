<?php
/**
 * Template Name: Services Overview
 *
 * @package Avdesh_SEO
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Services</span></nav>
		<span class="eyebrow">What I offer</span>
		<h1>SEO, AI Search, GEO &amp; Google Ads Services</h1>
		<p>A complete, white-hat service suite to grow your organic traffic, rankings and revenue across Google and modern AI search platforms, on any platform, in any market.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-3">
			<?php foreach ( array_keys( avdesh_services() ) as $slug ) {
				avdesh_service_card( $slug );
			} ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band(); ?>
<?php get_footer(); ?>
