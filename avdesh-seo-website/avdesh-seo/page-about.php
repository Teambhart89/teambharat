<?php
/**
 * About page template (slug: about).
 *
 * @package Avdesh_SEO
 */
get_header();
$name = avseo_info( 'name' );
?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<span class="eyebrow">About</span>
		<h1>SEO &amp; AI Search Optimization Specialist in Delhi, India</h1>
		<p class="lead">
			I'm <?php echo esc_html( $name ); ?>. For 8 years I have helped businesses turn search visibility into
			qualified traffic, leads and real revenue across India, Dubai, the UK, the USA and Australia.
		</p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<div class="about-grid">
			<div class="prose">
				<h2>Who I am</h2>
				<p>
					I am an SEO and AI Search Optimization Specialist with a simple belief: search should grow your revenue,
					not just your rankings. Over the last 8 years I have worked across highly competitive markets, building
					white hat strategies that hold up over time and keep delivering results long after the work is done.
				</p>
				<p>
					My approach is AI-first. Search is changing fast, and buyers now find answers inside Google AI Overviews,
					ChatGPT, Gemini and Perplexity as well as classic search results. I help brands stay visible everywhere
					their customers look, while keeping a firm focus on long-term, sustainable growth.
				</p>

				<h2>What I specialise in</h2>
				<h3>Search Engine Optimization</h3>
				<p>
					On-page, technical and off-page SEO that improves rankings and grows organic traffic. I work comfortably
					across WordPress, Shopify, Wix, Squarespace and custom platforms.
				</p>
				<h3>AI Search Optimization and GEO</h3>
				<p>
					Generative Engine Optimization that helps your brand get cited and recommended inside AI answers, so you
					win visibility on the platforms shaping the next decade of search.
				</p>
				<h3>Google Ads</h3>
				<p>
					High intent paid search campaigns that lower cost per lead and complement your organic growth, giving you
					qualified traffic while your SEO compounds.
				</p>

				<div class="takeaway">
					<h4>In one line</h4>
					<p>
						I help businesses generate qualified traffic, leads and sales by focusing on what truly drives
						performance: real ROI, not vanity rankings.
					</p>
				</div>
			</div>
			<div>
				<?php avseo_image_slot( 'img_about', 'Add your about photo', $name, 'about-photo' ); ?>
			</div>
		</div>
	</div>
</section>

<section class="bg-white">
	<div class="container">
		<div class="two-col">
			<div>
				<h2 class="section-title">experience<span class="dot">.</span></h2>
				<div class="panel" style="margin-top:22px;">
					<ul class="timeline">
						<li>
							<div class="when">2019 - Present</div>
							<h4>SEO &amp; AI Search Specialist</h4>
							<div class="where">Freelance &amp; Consulting. Driving organic growth for brands across multiple countries.</div>
						</li>
						<li>
							<div class="when">Ongoing</div>
							<h4>Generative Engine Optimization</h4>
							<div class="where">Helping brands earn visibility inside AI answer engines and LLM platforms.</div>
						</li>
						<li>
							<div class="when">Ongoing</div>
							<h4>Google Ads Management</h4>
							<div class="where">High intent paid search that supports and accelerates organic results.</div>
						</li>
					</ul>
				</div>
			</div>
			<div>
				<h2 class="section-title">skills<span class="dot">.</span></h2>
				<div class="panel" style="margin-top:22px;">
					<ul class="check-list">
						<li>Technical SEO and Core Web Vitals</li>
						<li>On-page SEO and content optimization</li>
						<li>Keyword research and search intent mapping</li>
						<li>White hat link building and digital PR</li>
						<li>Local SEO and Google Business Profile</li>
						<li>eCommerce SEO for Shopify and WooCommerce</li>
						<li>AI search optimization (GEO and AEO)</li>
						<li>Google Ads and conversion tracking</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php avseo_cta_band(); ?>
<?php get_footer(); ?>
