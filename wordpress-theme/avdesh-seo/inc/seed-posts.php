<?php
/**
 * Seed starter SEO blog posts on theme activation.
 *
 * Six long-tail, keyword-targeted articles that internally link to the service
 * pages (good for topical authority and lead flow). Runs once; existing posts
 * (matched by slug) are never duplicated.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Helper: internal link to a path. */
function avdesh_ilink( $path, $label ) {
	return '<a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $label ) . '</a>';
}

/** Build the starter post definitions (content built at runtime for correct URLs). */
function avdesh_seed_post_data() {
	$audit = avdesh_ilink( '/book-free-seo-audit/', 'book a free SEO audit' );
	$cta   = '<p><strong>Want help applying this to your site?</strong> ' . $audit . ' and get a clear, prioritized action plan.</p>';

	return array(

		array(
			'slug'    => 'what-is-generative-engine-optimization-geo',
			'title'   => 'What Is Generative Engine Optimization (GEO) and Why It Matters in 2026',
			'excerpt' => 'GEO makes your brand visible inside AI answers from ChatGPT, Gemini and Perplexity. Here is what it is and how to get started.',
			'body'    => '<p>Generative Engine Optimization (GEO) is the practice of optimizing your content so AI answer engines like ChatGPT, Gemini, Claude, Perplexity and Google AI Overviews quote and recommend your brand. As more people ask an AI assistant instead of scrolling search results, GEO is quickly becoming as important as classic SEO.</p>'
				. '<h2>How GEO differs from traditional SEO</h2>'
				. '<p>Traditional SEO helps you rank in a list of links. GEO helps you become the answer the AI actually gives. The good news is that the fundamentals overlap: clear structure, genuine expertise and trustworthy content help you win in both.</p>'
				. '<h3>What AI engines look for</h3>'
				. '<ul><li>Clear definitions and direct answers near the top of each section</li><li>Logical headings and FAQ blocks that are easy to parse</li><li>Structured data (schema) that removes ambiguity</li><li>A consistent brand entity and trusted third-party mentions</li></ul>'
				. '<h2>How to start with GEO</h2>'
				. '<p>Begin by auditing how AI engines currently describe your brand, then restructure key pages to answer real buyer questions clearly. My ' . avdesh_ilink( '/ai-search-optimization/', 'AI Search Optimization service' ) . ' covers this end to end, and strong ' . avdesh_ilink( '/seo-content-writing/', 'SEO content writing' ) . ' gives the engines quotable material to work with.</p>'
				. $cta,
		),

		array(
			'slug'    => 'seo-vs-ai-search-stay-visible-chatgpt-gemini-perplexity',
			'title'   => 'SEO vs AI Search: How to Stay Visible in ChatGPT, Gemini and Perplexity',
			'excerpt' => 'Search is splitting between Google and AI assistants. Here is how to stay visible across both without starting over.',
			'body'    => '<p>Search behaviour is changing fast. Some buyers still Google, while others ask an AI assistant and act on the single answer it gives. To stay visible, your brand needs to show up in both places, and the two goals reinforce each other more than they compete.</p>'
				. '<h2>Why you should not abandon SEO</h2>'
				. '<p>Traditional search still drives the majority of discovery today, and the signals that help you rank, relevance, authority and structure, are the same signals AI models rely on. Classic SEO remains your foundation.</p>'
				. '<h2>What to add for AI search</h2>'
				. '<h3>Structure content for answers</h3>'
				. '<p>Lead with a clear, quotable answer, then expand. Use FAQ sections and schema so engines can lift your content confidently.</p>'
				. '<h3>Build a strong entity</h3>'
				. '<p>Consistent naming, bios and structured data help AI models understand who you are and what you are known for.</p>'
				. '<p>A connected ' . avdesh_ilink( '/content-strategy-services/', 'content strategy' ) . ' plus dedicated ' . avdesh_ilink( '/ai-search-optimization/', 'AI search optimization' ) . ' is the most reliable way to cover both channels.</p>'
				. $cta,
		),

		array(
			'slug'    => 'how-long-does-seo-take-to-show-results',
			'title'   => 'How Long Does SEO Take to Show Results?',
			'excerpt' => 'A realistic timeline for SEO results, what affects it, and how to see early wins faster.',
			'body'    => '<p>The honest answer: most websites see early movement within 8 to 12 weeks, with stronger, compounding results from around month four onward. SEO is an investment that keeps paying back, not an overnight switch.</p>'
				. '<h2>What affects your SEO timeline</h2>'
				. '<ul><li><strong>Competition:</strong> more competitive niches take longer</li><li><strong>Starting point:</strong> established sites move faster than brand-new ones</li><li><strong>Technical health:</strong> a clean site ranks quicker</li><li><strong>Content and links:</strong> consistent quality speeds everything up</li></ul>'
				. '<h2>How to see wins sooner</h2>'
				. '<h3>Start with an audit</h3>'
				. '<p>A ' . avdesh_ilink( '/seo-audit-services/', 'thorough SEO audit' ) . ' usually surfaces quick wins, fixes that lift rankings within weeks.</p>'
				. '<h3>Optimize what you already have</h3>'
				. '<p>Improving existing pages often ranks faster than creating new ones. A structured ' . avdesh_ilink( '/seo-services/', 'SEO service' ) . ' sequences quick wins first, then builds long-term growth.</p>'
				. $cta,
		),

		array(
			'slug'    => 'technical-seo-issues-hurting-your-rankings',
			'title'   => '10 Technical SEO Issues That Are Quietly Hurting Your Rankings',
			'excerpt' => 'Technical problems can cap your rankings no matter how good your content is. Here are ten common culprits and fixes.',
			'body'    => '<p>Great content cannot rank if search engines struggle to crawl, render or index it. These technical issues silently hold sites back until they are found and fixed.</p>'
				. '<h2>The usual suspects</h2>'
				. '<ol><li>Slow pages and failing Core Web Vitals</li><li>Poor mobile performance</li><li>Blocked pages in robots.txt</li><li>Missing or messy XML sitemaps</li><li>Duplicate content and thin pages</li><li>Broken internal links and redirect chains</li><li>Incorrect canonical tags</li><li>Missing structured data</li><li>Orphan pages with no internal links</li><li>Indexation bloat from low-value URLs</li></ol>'
				. '<h2>Where to focus first</h2>'
				. '<h3>Speed and Core Web Vitals</h3>'
				. '<p>Speed is both a ranking factor and a conversion factor. My ' . avdesh_ilink( '/core-web-vitals-optimization/', 'Core Web Vitals optimization' ) . ' targets LCP, INP and CLS directly.</p>'
				. '<h3>Crawl and index health</h3>'
				. '<p>A full ' . avdesh_ilink( '/technical-seo-services/', 'technical SEO service' ) . ' fixes crawlability and indexation so your best pages actually get ranked.</p>'
				. $cta,
		),

		array(
			'slug'    => 'local-seo-checklist-rank-in-google-map-pack',
			'title'   => 'Local SEO Checklist: How to Rank in the Google Map Pack',
			'excerpt' => 'A practical local SEO checklist to help your business rank in Google Maps and the local pack.',
			'body'    => '<p>Local searches carry strong buying intent. People searching "near me" are often minutes from choosing a business. Ranking in the map pack, the block of three local results, drives calls, visits and bookings.</p>'
				. '<h2>Your local SEO checklist</h2>'
				. '<ul><li>Fully optimize your Google Business Profile</li><li>Keep your name, address and phone consistent everywhere</li><li>Build accurate local citations</li><li>Earn and respond to genuine reviews</li><li>Create location and service pages targeting local terms</li><li>Add local business schema</li></ul>'
				. '<h2>Why consistency wins</h2>'
				. '<h3>Trust signals</h3>'
				. '<p>Matching business details across the web reassure Google that your business is legitimate, which helps rankings.</p>'
				. '<p>Done well, ' . avdesh_ilink( '/local-seo-services/', 'local SEO' ) . ' can put smaller businesses ahead of bigger national brands in their own area.</p>'
				. $cta,
		),

		array(
			'slug'    => 'ecommerce-seo-get-product-pages-to-rank',
			'title'   => 'eCommerce SEO: How to Get Your Product Pages to Rank and Sell',
			'excerpt' => 'Turn your online store into a search engine that sells with these eCommerce SEO essentials.',
			'body'    => '<p>eCommerce SEO helps your product and category pages rank for the searches shoppers use with real buying intent, so you grow sales without paying for every click.</p>'
				. '<h2>eCommerce SEO essentials</h2>'
				. '<h3>Optimize category and product pages</h3>'
				. '<p>Clear titles, unique descriptions and helpful content help these pages rank and convert. Start from solid ' . avdesh_ilink( '/keyword-research-services/', 'keyword research' ) . ' so you target terms with genuine demand.</p>'
				. '<h3>Fix store-specific technical issues</h3>'
				. '<p>Duplicate content, faceted navigation and thin pages are common on stores. Product schema unlocks rich results with prices and ratings.</p>'
				. '<h2>Compounding, high-margin growth</h2>'
				. '<p>Organic search is often the highest-margin channel for a store because rankings keep delivering sales long after the work is done. My ' . avdesh_ilink( '/ecommerce-seo-services/', 'eCommerce SEO service' ) . ' covers Shopify, WooCommerce and more.</p>'
				. $cta,
		),
	);
}

/** Create the starter posts once. */
function avdesh_seed_posts() {
	if ( get_option( 'avdesh_posts_seeded' ) ) {
		return;
	}

	// Ensure a category exists.
	$cat = get_category_by_slug( 'seo-insights' );
	$cat_id = $cat ? $cat->term_id : wp_create_category( 'SEO Insights' );

	foreach ( avdesh_seed_post_data() as $p ) {
		if ( get_page_by_path( $p['slug'], OBJECT, 'post' ) ) {
			continue; // already exists.
		}
		wp_insert_post(
			array(
				'post_title'    => $p['title'],
				'post_name'     => $p['slug'],
				'post_content'  => $p['body'],
				'post_excerpt'  => $p['excerpt'],
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_category' => $cat_id ? array( $cat_id ) : array(),
			)
		);
	}

	update_option( 'avdesh_posts_seeded', 1 );
}
add_action( 'after_switch_theme', 'avdesh_seed_posts', 20 );
