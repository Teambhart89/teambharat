<?php
/**
 * Template Name: SEO Results
 *
 * @package Avdesh_SEO
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>SEO Results</span></nav>
		<span class="eyebrow">Proven results</span>
		<h1>SEO Results That Drive Revenue</h1>
		<p>Traffic growth, ranking improvements and lead generation from real campaigns. Replace the charts and placeholders with your own Search Console and Analytics screenshots.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-4 reveal">
			<div class="result-tile"><b data-count="312" data-prefix="+" data-suffix="%">+312%</b><span>Organic traffic growth</span></div>
			<div class="result-tile"><b data-count="250" data-suffix="+">250+</b><span>Keywords on page one</span></div>
			<div class="result-tile"><b data-count="500" data-suffix="+">500+</b><span>Businesses helped</span></div>
			<div class="result-tile"><b data-count="40" data-suffix="%">40%</b><span>Lower cost per lead</span></div>
		</div>

		<div class="grid grid-2 reveal" style="margin-top:30px;">
			<div class="chart-card">
				<span class="badge-up">▲ +312% in 12 months</span>
				<h3 style="margin-top:14px;">Organic traffic growth</h3>
				<p class="csub">Monthly organic sessions, representative client</p>
				<?php echo avdesh_traffic_chart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div class="chart-legend"><span><i style="background:#10B981;"></i> Organic sessions</span></div>
			</div>
			<div class="chart-card">
				<span class="badge-up">▲ Rankings improved</span>
				<h3 style="margin-top:14px;">Before &amp; after rankings</h3>
				<p class="csub">Average keyword position, before vs after</p>
				<div style="margin-top:16px;"><?php echo avdesh_ranking_chart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<div class="chart-legend"><span><i style="background:#C7CAF0;"></i> Before</span><span><i style="background:linear-gradient(90deg,#4F46E5,#10B981);"></i> After</span></div>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<?php avdesh_ranking_keywords_section( 'Trusted clients — top ranking keywords' ); ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Proof, not promises</span>
			<h2 class="sec-title">Google Search Console &amp; Analytics</h2>
			<p class="sec-sub">Upload your real growth screenshots so prospects can see verified results.</p>
		</div>
		<div class="grid grid-2 reveal" style="margin-top:36px;">
			<div class="card"><h3 style="margin-bottom:12px;">Search Console: clicks &amp; impressions</h3><div class="img-ph" style="min-height:240px;"><span class="badge">📊 Upload GSC performance screenshot</span></div></div>
			<div class="card"><h3 style="margin-bottom:12px;">Analytics: organic sessions</h3><div class="img-ph" style="min-height:240px;"><span class="badge">📈 Upload GA4 organic traffic screenshot</span></div></div>
			<div class="card"><h3 style="margin-bottom:12px;">Keyword growth over time</h3><div class="img-ph" style="min-height:240px;"><span class="badge">🔑 Upload keyword ranking screenshot</span></div></div>
			<div class="card"><h3 style="margin-bottom:12px;">Conversions &amp; leads</h3><div class="img-ph" style="min-height:240px;"><span class="badge">🎯 Upload conversions screenshot</span></div></div>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Want results like these for your business?', 'Book a free SEO audit and get a clear, data-backed plan to grow your organic visibility.' ); ?>
<?php get_footer(); ?>
