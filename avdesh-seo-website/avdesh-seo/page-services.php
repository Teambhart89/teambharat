<?php
/**
 * Services overview / hub page (slug: services).
 *
 * @package Avdesh_SEO
 */
get_header();
?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<span class="eyebrow">Services</span>
		<h1>SEO, AI Search &amp; Google Ads Services That Grow Revenue</h1>
		<p class="lead">
			Every service below is built to do one thing: turn search visibility into qualified traffic, leads and sales.
			Choose a single service or combine them into a full growth strategy.
		</p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<div class="cards-grid">
			<?php
			$services = array(
				array( '01', '🔍', 'SEO Services', 'A complete, ROI focused SEO strategy that grows organic traffic and rankings.', '/seo-services/' ),
				array( '02', '⚙️', 'Technical SEO', 'Crawlable, indexable, fast websites that pass Core Web Vitals.', '/technical-seo-services/' ),
				array( '03', '📝', 'On-Page SEO', 'Keyword mapped content, headings and metadata that rank and convert.', '/on-page-seo-services/' ),
				array( '04', '🔗', 'Off-Page SEO &amp; Link Building', 'White hat backlinks that build authority, trust and rankings.', '/off-page-seo-link-building/' ),
				array( '05', '📍', 'Local SEO', 'Google Business Profile and map pack rankings that drive local leads.', '/local-seo-services/' ),
				array( '06', '🛒', 'eCommerce SEO', 'Product and category rankings that grow qualified traffic and sales.', '/ecommerce-seo-services/' ),
				array( '07', '🤖', 'AI Search Optimization', 'Visibility inside AI Overviews, ChatGPT, Gemini and Perplexity.', '/ai-search-optimization/' ),
				array( '08', '🎯', 'Google Ads Management', 'High intent paid search with a lower cost per lead.', '/google-ads-management/' ),
			);
			foreach ( $services as $s ) : ?>
				<div class="svc-card">
					<div class="card-top">
						<span class="num"><?php echo esc_html( $s[0] ); ?></span>
						<span class="card-ico"><?php echo esc_html( $s[1] ); ?></span>
					</div>
					<h3><?php echo wp_kses_post( $s[2] ); ?></h3>
					<p><?php echo wp_kses_post( $s[3] ); ?></p>
					<a class="card-link" href="<?php echo esc_url( home_url( $s[4] ) ); ?>">Learn more &rarr;</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="bg-white">
	<div class="container">
		<div class="prose mx-auto">
			<h2>How the services work together</h2>
			<p>
				Great results rarely come from a single tactic. A strong <strong>technical SEO</strong> foundation lets search
				engines crawl and index your site. <strong>On-page SEO</strong> then aligns your content with real search
				intent, while <strong>off-page SEO</strong> builds the authority that pushes those pages up the rankings.
			</p>
			<p>
				<strong>Local SEO</strong> and <strong>eCommerce SEO</strong> tailor the strategy to how your customers actually
				search and buy. On top of that, <strong>AI search optimization</strong> makes sure your brand shows up inside the
				AI answers that more and more buyers now rely on, and <strong>Google Ads</strong> brings qualified traffic while
				your organic results compound.
			</p>

			<div class="takeaway">
				<h4>Not sure where to start?</h4>
				<p>
					Book a free consultation. I will review your website, your market and your goals, then recommend the exact
					mix of services that will bring the fastest, most sustainable return.
				</p>
			</div>
		</div>
	</div>
</section>

<?php avseo_cta_band(); ?>
<?php get_footer(); ?>
