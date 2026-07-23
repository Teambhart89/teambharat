<?php
/**
 * Services overview / hub page (slug: services). Intro and closing copy are
 * editable in Pages; the service cards are generated for consistent design.
 *
 * @package Avdesh_SEO
 */
get_header();
while ( have_posts() ) :
	the_post();
	?>

	<section class="page-hero">
		<div class="container">
			<?php avseo_breadcrumbs(); ?>
			<span class="eyebrow">Services</span>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
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

	<?php if ( trim( get_the_content() ) ) : ?>
	<section class="bg-white">
		<div class="container">
			<div class="prose entry-content mx-auto">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php
endwhile;
avseo_cta_band();
get_footer();
