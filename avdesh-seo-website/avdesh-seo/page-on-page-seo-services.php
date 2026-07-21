<?php
/**
 * On-Page SEO page (slug: on-page-seo-services).
 *
 * @package Avdesh_SEO
 */
get_header();
?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<span class="eyebrow">On-Page SEO</span>
		<h1>On-Page SEO Services That Help Pages Rank and Convert</h1>
		<p class="lead">
			On-page SEO is where rankings are won. I optimize your content, headings, keywords and metadata so each page
			matches search intent, earns higher rankings and turns visitors into customers.
		</p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<div class="content-cols">
			<div class="prose">
				<p>
					On-page SEO is everything you can optimize on a page itself to help it rank and convert. Done well, it
					connects your content to what people are really searching for, then guides them toward taking action.
				</p>

				<div class="takeaway">
					<h4>Quick answer</h4>
					<p>
						On-page SEO covers keyword targeting, content quality, title tags, meta descriptions, header structure,
						internal linking and user experience, all aligned with search intent.
					</p>
				</div>

				<h2>What my on-page SEO services include</h2>

				<h3>Keyword targeting and search intent</h3>
				<p>
					I map a primary keyword and supporting terms to every page, then match the content format to the intent
					behind the search, whether the visitor wants to learn, compare or buy.
				</p>

				<h3>Content optimization that readers love</h3>
				<p>
					Search engines reward content that genuinely helps people. I create and refine content that is clear,
					useful and easy to read, uses your keywords naturally, and gives visitors a reason to trust your business.
				</p>
				<h4>Heading structure done right</h4>
				<p>
					Every page uses a clean, logical heading hierarchy. A single H1 states the topic, H2 tags break the page
					into sections, and H3 and H4 tags organise the details. This helps readers scan and helps search engines
					understand your content.
				</p>

				<h3>Title tags and meta descriptions</h3>
				<p>
					I write compelling, keyword focused title tags and meta descriptions that improve click through rate from
					search results, so more of your rankings turn into actual visits.
				</p>

				<h3>Internal linking</h3>
				<p>
					Smart internal links pass authority to your priority pages and keep visitors moving through your site. I
					build a linking structure that supports your most valuable keywords and improves the user journey.
				</p>

				<h3>Images, media and accessibility</h3>
				<p>
					I optimize image file names, alt text and sizes so pages load fast, rank in image search and stay accessible
					to every visitor.
				</p>

				<h2>SEO friendly content and structure</h2>
				<ul class="check-list" style="margin:20px 0;">
					<li>One clear H1 per page, supported by H2, H3 and H4 headings</li>
					<li>Natural keyword use that reads well and avoids stuffing</li>
					<li>Content written for real readers and optimized for search</li>
					<li>Structured data to support rich results and AI answers</li>
				</ul>

				<h2>On-page SEO FAQs</h2>
				<?php
				avseo_faq_block( array(
					array(
						'q' => 'What is on-page SEO?',
						'a' => 'On-page SEO is the process of optimizing the content and HTML elements of a page, such as keywords, headings, title tags, meta descriptions and internal links, so it ranks higher and serves the searcher better.',
					),
					array(
						'q' => 'Why are H1 to H4 headings important?',
						'a' => 'Headings give your page a clear structure. A single H1 defines the topic while H2, H3 and H4 tags organise the sections and details. This helps readers scan the page and helps search engines understand it.',
					),
					array(
						'q' => 'Do you write the content or optimize existing pages?',
						'a' => 'Both. I can create new SEO content from scratch or optimize your existing pages, depending on what will bring the fastest results for your goals.',
					),
				) );
				?>
			</div>

			<?php get_template_part( 'template-parts/service-sidebar' ); ?>
		</div>
	</div>
</section>

<?php avseo_cta_band( 'Want pages that rank and convert?', 'Book a free consultation and I will show you exactly how to optimize your key pages for search and for readers.' ); ?>
<?php get_footer(); ?>
