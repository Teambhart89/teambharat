<?php
/**
 * Template Name: Portfolio
 *
 * @package Avdesh_SEO
 */

get_header();

$projects = array(
	array( 'Organic Growth Campaign', 'SEO & Content', 'Grew organic sessions 3X in 6 months for a competitive service business.', array( '3X traffic', '180+ keywords', '2X leads' ) ),
	array( 'Technical SEO Overhaul', 'Technical SEO', 'Fixed Core Web Vitals and indexation to recover lost rankings.', array( '95 PageSpeed', '2X indexed', '+120% clicks' ) ),
	array( 'AI Search Visibility', 'GEO / AI SEO', 'Structured content to earn citations in AI answer engines.', array( 'AI cited', '+40% share', 'FAQ rich results' ) ),
	array( 'Local SEO Domination', 'Local SEO', 'Ranked in the map pack across multiple service areas.', array( 'Map pack #1', '5X calls', '4.9★ reviews' ) ),
	array( 'E-commerce SEO', 'Shopify SEO', 'Optimized product and collection pages to grow store revenue.', array( '+150% sales', '300+ products', 'Lower ad spend' ) ),
	array( 'Google Ads ROI', 'Google Ads', 'Restructured campaigns to cut cost per lead while scaling volume.', array( '-40% CPL', '2.5X ROAS', '+90% leads' ) ),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Portfolio</span></nav>
		<span class="eyebrow">Case studies</span>
		<h1>SEO &amp; AI Search Portfolio</h1>
		<p class="lead">A selection of projects showcasing strategy, execution and measurable business growth. Replace the details and images below with your own case studies.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-3">
			<?php foreach ( $projects as $p ) : ?>
				<article class="card reveal">
					<div class="img-ph" style="min-height:170px;margin-bottom:18px;"><span class="badge">📷 Project image</span></div>
					<span class="eyebrow" style="margin:0;"><?php echo esc_html( $p[1] ); ?></span>
					<h3 style="margin:6px 0 8px;"><?php echo esc_html( $p[0] ); ?></h3>
					<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $p[2] ); ?></p>
					<div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:14px;">
						<?php foreach ( $p[3] as $stat ) : ?>
							<span style="background:var(--orange-tint);color:var(--orange-dark);font-weight:600;font-size:.8rem;padding:6px 12px;border-radius:50px;"><?php echo esc_html( $stat ); ?></span>
						<?php endforeach; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Trusted by</span>
			<h2 class="sec-title">brands I've worked with<span class="dot">.</span></h2>
			<p class="sec-sub">Replace these cells with your client logos from the media library.</p>
		</div>
		<div class="logo-grid reveal" style="margin-top:30px;">
			<?php for ( $b = 1; $b <= 12; $b++ ) : ?>
				<div class="logo-cell">Logo <?php echo esc_html( $b ); ?></div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Want results like these?', 'Let\'s build a search strategy that delivers measurable growth for your business.' ); ?>
<?php get_footer(); ?>
