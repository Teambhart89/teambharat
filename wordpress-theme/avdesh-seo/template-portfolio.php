<?php
/**
 * Template Name: Portfolio
 *
 * @package Avdesh_SEO
 */

get_header();

$projects = array(
	array( 'Organic Growth Campaign', 'SEO & Content', array( '+312% traffic', '250+ keywords' ) ),
	array( 'Technical SEO Overhaul', 'Technical SEO', array( '95 PageSpeed', '+120% clicks' ) ),
	array( 'AI Search Visibility', 'GEO / AISO', array( 'AI cited', 'Rich results' ) ),
	array( 'Local SEO Domination', 'Local SEO', array( 'Map pack #1', '5x calls' ) ),
	array( 'eCommerce SEO Scale', 'Shopify SEO', array( '+150% sales', 'Lower ad spend' ) ),
	array( 'Google Ads ROI', 'Google Ads', array( '-40% CPL', '2.5x ROAS' ) ),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Portfolio</span></nav>
		<span class="eyebrow">Portfolio</span>
		<h1>SEO &amp; AI Search Portfolio</h1>
		<p>A visual selection of projects showcasing strategy, execution and measurable business growth. Replace the details and images with your own work.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-3">
			<?php foreach ( $projects as $p ) : ?>
				<article class="cs-card reveal">
					<div class="cs-top"><div class="img-ph" style="min-height:180px;border-radius:0;border:0;"><span class="badge">📷 Project image</span></div><span class="cs-tag"><?php echo esc_html( $p[1] ); ?></span></div>
					<div class="cs-body">
						<h3><?php echo esc_html( $p[0] ); ?></h3>
						<p>A short summary of the challenge, the strategy used and the measurable outcome for this project.</p>
						<div class="cs-metrics"><?php foreach ( $p[2] as $m ) : ?><span><?php echo esc_html( $m ); ?></span><?php endforeach; ?></div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Want results like these?', 'Book a free SEO audit and get a clear plan to grow your organic traffic, leads and revenue.' ); ?>
<?php get_footer(); ?>
