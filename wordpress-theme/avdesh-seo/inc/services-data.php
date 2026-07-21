<?php
/**
 * Service content library.
 *
 * Every service page is generated from this data by inc/template-helpers.php,
 * so all pages share one consistent, SEO-optimized structure:
 *   H1 (page title)  ->  H2 (each section)  ->  H3 (features / steps / FAQ)  ->  H4 (detail).
 *
 * Content is written to be reader-friendly, white-hat, and quotable by AI
 * answer engines (clear definitions and direct answers near the top).
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function avdesh_services() {
	static $services = null;
	if ( null !== $services ) {
		return $services;
	}

	$services = array(

		/* ============================================================= 1 */
		'seo-services' => array(
			'menu'       => 'SEO Services',
			'icon'       => '🔍',
			'card_desc'  => 'Full-funnel search engine optimization that turns organic visibility into qualified leads and real revenue.',
			'h1'         => 'SEO Services in Delhi, India',
			'tagline'    => 'White-hat SEO built around revenue, not vanity rankings. On-page, technical, and off-page work that compounds month after month.',
			'meta_title' => 'SEO Services in Delhi, India | Avdesh Kumar',
			'meta_desc'  => 'Professional white-hat SEO services by Avdesh Kumar, SEO specialist in Delhi. Drive organic traffic, higher rankings and real ROI across every platform.',
			'intro'      => array(
				'h2'      => 'Professional SEO services that grow revenue',
				'paras'   => array(
					'SEO is the practice of earning steady, qualified traffic from search engines without paying for every click. My SEO services help your business rank for the terms your buyers actually type, then turn that visibility into leads and sales you can measure.',
					'I take an AI-first approach to search. That means your pages are built to satisfy both Google and modern answer engines like ChatGPT, Google AI Overviews, Gemini and Perplexity, so your brand stays visible as search behaviour shifts.',
				),
				'callout' => 'Every engagement is white-hat and sustainable. No spam, no shortcuts, no tactics that put your domain at risk.',
			),
			'includes'   => array(
				'h2'    => 'What my SEO services include',
				'items' => array(
					array( 'h3' => 'Keyword research and mapping', 'p' => 'I find the searches with real commercial value, then map each one to the right page so nothing competes with itself.', 'h4' => 'Intent-first targeting', 'h4p' => 'Keywords are grouped by search intent so buyers land on pages built to convert them.' ),
					array( 'h3' => 'On-page optimization', 'p' => 'Titles, headings, content, internal links and schema are tuned on every priority page for clarity and relevance.', 'h4' => 'Content that reads naturally', 'h4p' => 'Copy is written for people first and search engines second, so it earns trust and links.' ),
					array( 'h3' => 'Technical SEO', 'p' => 'I fix crawl, indexing, speed and Core Web Vitals issues that quietly hold your rankings back.', 'h4' => 'Clean, crawlable foundations', 'h4p' => 'A healthy site structure lets search engines find and rank your best pages faster.' ),
					array( 'h3' => 'Authority and link building', 'p' => 'I earn relevant, high-quality backlinks that build genuine domain authority over time.', 'h4' => 'Quality over quantity', 'h4p' => 'A few trusted links move rankings more than hundreds of low-value ones.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My SEO process',
				'steps' => array(
					array( 'h3' => 'Audit and discovery', 'p' => 'I review your site, competitors and current rankings to find the fastest paths to growth.' ),
					array( 'h3' => 'Strategy and roadmap', 'p' => 'You get a clear, prioritized plan tied to business goals and realistic timelines.' ),
					array( 'h3' => 'Execution', 'p' => 'On-page, technical and content work is implemented in focused monthly sprints.' ),
					array( 'h3' => 'Measure and scale', 'p' => 'I track rankings, traffic and conversions, then double down on what drives ROI.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why work with me',
				'items' => array(
					array( 'h4' => '8 years of hands-on experience', 'p' => 'Proven results in highly competitive markets across India, Dubai, the UK, the USA and Australia.' ),
					array( 'h4' => 'Revenue-focused reporting', 'p' => 'You see traffic, leads and sales, not just keyword positions that look good on a slide.' ),
					array( 'h4' => 'AI-first and future-proof', 'p' => 'Your content is optimized for Google and the LLM platforms buyers increasingly use to research.' ),
					array( 'h4' => 'Platform flexible', 'p' => 'Comfortable across WordPress, Shopify, Wix, Squarespace and custom builds.' ),
				),
			),
			'platforms'  => array(
				'h2'    => 'SEO for every platform',
				'para'  => 'Your CMS should never limit your rankings. I deliver clean, effective SEO on all major platforms and adapt the technical work to each one.',
				'items' => array(
					array( 'h3' => 'WordPress SEO', 'p' => 'Speed, schema and content structure tuned for the most flexible CMS.' ),
					array( 'h3' => 'Shopify SEO', 'p' => 'Product, collection and blog optimization built for e-commerce growth.' ),
					array( 'h3' => 'Wix and Squarespace SEO', 'p' => 'Practical, platform-aware fixes that get these builders ranking properly.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'How long does SEO take to show results?', 'a' => 'Most projects see early movement within 8 to 12 weeks, with stronger, compounding results from month four onward. Timelines depend on competition, your starting point and how quickly changes are approved.' ),
				array( 'q' => 'Do you use white-hat SEO only?', 'a' => 'Yes. Every method I use follows search engine guidelines. White-hat SEO protects your domain and delivers rankings that last, rather than short-term spikes that get penalised.' ),
				array( 'q' => 'Do you work with businesses outside Delhi?', 'a' => 'Absolutely. I am based in Delhi, India, and work with clients across the UK, USA, UAE, Australia and beyond, remotely and reliably.' ),
				array( 'q' => 'Can you handle both SEO and Google Ads?', 'a' => 'Yes. I offer SEO, GEO and Google Ads, so you can grow organic and paid channels together with one accountable specialist.' ),
			),
			'related'    => array( 'ai-search-optimization', 'technical-seo-services', 'on-page-seo-services' ),
		),

		/* ============================================================= 2 */
		'ai-search-optimization' => array(
			'menu'       => 'AI Search Optimization',
			'icon'       => '🤖',
			'card_desc'  => 'Get your brand found, cited and recommended inside ChatGPT, Google AI Overviews, Gemini and Perplexity.',
			'h1'         => 'AI Search Optimization (GEO) Services',
			'tagline'    => 'Generative Engine Optimization that makes your brand the answer AI assistants give, not just a link buried on page two.',
			'meta_title' => 'AI Search Optimization & GEO Services | Avdesh Kumar',
			'meta_desc'  => 'Generative Engine Optimization (GEO) by Avdesh Kumar. Get your brand cited by ChatGPT, Gemini, Perplexity and Google AI Overviews. AI-first search strategy.',
			'intro'      => array(
				'h2'      => 'What is AI search optimization',
				'paras'   => array(
					'AI search optimization, also called Generative Engine Optimization or GEO, is the practice of making your brand visible inside AI-generated answers. When someone asks ChatGPT, Gemini, Perplexity or Google AI Overviews a question, GEO helps ensure your business is the one being quoted and recommended.',
					'Search is no longer only a list of blue links. Buyers now ask an AI assistant and act on the answer it gives. If your content is not structured for these engines, you are invisible in the exact moment a decision is made.',
				),
				'callout' => 'GEO is where SEO is heading. Getting there early is one of the biggest visibility advantages a brand can hold right now.',
			),
			'includes'   => array(
				'h2'    => 'What AI search optimization includes',
				'items' => array(
					array( 'h3' => 'Answer-ready content structure', 'p' => 'I rewrite key pages with clear definitions and direct answers that LLMs can lift and cite confidently.', 'h4' => 'Quotable by design', 'h4p' => 'Concise, factual passages near the top of each section are exactly what AI engines pull into answers.' ),
					array( 'h3' => 'Entity and knowledge-graph building', 'p' => 'I strengthen how search engines and AI models understand who you are and what you are known for.', 'h4' => 'Consistent brand identity', 'h4p' => 'Uniform naming, bios and structured data build a stable entity AI can trust.' ),
					array( 'h3' => 'Structured data and schema', 'p' => 'FAQ, Article, Product and Organization schema make your content machine-readable and eligible for rich, AI-driven results.', 'h4' => 'Signals machines can parse', 'h4p' => 'Schema removes guesswork so engines cite you accurately.' ),
					array( 'h3' => 'Citation and mention building', 'p' => 'I grow trusted third-party mentions that LLMs use as evidence when deciding who to recommend.', 'h4' => 'Trust from many sources', 'h4p' => 'AI models weigh what the wider web says about you, not just your own site.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My GEO process',
				'steps' => array(
					array( 'h3' => 'AI visibility audit', 'p' => 'I test how ChatGPT, Gemini and Perplexity currently talk about your brand and your competitors.' ),
					array( 'h3' => 'Gap and prompt mapping', 'p' => 'I identify the buyer questions where you should be the answer but are not.' ),
					array( 'h3' => 'Content and entity work', 'p' => 'Pages are restructured, schema added and authority signals strengthened.' ),
					array( 'h3' => 'Track and improve', 'p' => 'I monitor AI mentions and citations, then refine to grow your share of answers.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why GEO matters now',
				'items' => array(
					array( 'h4' => 'Buyers trust AI answers', 'p' => 'People increasingly act on the single answer an assistant gives rather than scrolling results.' ),
					array( 'h4' => 'Early movers win', 'p' => 'Brands that structure content for AI now are being cited while competitors are still catching up.' ),
					array( 'h4' => 'It strengthens classic SEO', 'p' => 'The same clarity and structure that help LLMs also improve Google rankings and snippets.' ),
					array( 'h4' => 'Measurable authority', 'p' => 'You build a durable presence across both traditional and generative search.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'What is the difference between SEO and GEO?', 'a' => 'SEO optimizes your pages to rank in traditional search results. GEO, or Generative Engine Optimization, optimizes your content so AI assistants quote and recommend your brand in their answers. The two work best together.' ),
				array( 'q' => 'Can you really influence what ChatGPT says about a brand?', 'a' => 'You cannot control an AI model, but you can strongly influence it. Clear, well-structured, well-cited content and a consistent entity give these models the accurate, trustworthy information they prefer to use.' ),
				array( 'q' => 'Does GEO replace SEO?', 'a' => 'No, it extends it. Classic SEO still drives most discovery today, and the fundamentals overlap. GEO ensures you stay visible as more searches move into AI answer engines.' ),
				array( 'q' => 'How do you measure AI search visibility?', 'a' => 'I track how often your brand is mentioned and cited across major AI platforms for your priority questions, and monitor how that share grows over time.' ),
			),
			'related'    => array( 'seo-services', 'seo-content-writing', 'on-page-seo-services' ),
		),

		/* ============================================================= 3 */
		'technical-seo-services' => array(
			'menu'       => 'Technical SEO',
			'icon'       => '⚙️',
			'card_desc'  => 'Fast, crawlable, indexable websites. I fix the technical issues that quietly cap your rankings.',
			'h1'         => 'Technical SEO Services',
			'tagline'    => 'A clean technical foundation so search engines and AI crawlers can find, understand and rank your best pages.',
			'meta_title' => 'Technical SEO Services | Core Web Vitals & Site Speed',
			'meta_desc'  => 'Technical SEO services by Avdesh Kumar. Improve site speed, Core Web Vitals, crawlability and indexation so your pages rank to their full potential.',
			'intro'      => array(
				'h2'      => 'What is technical SEO',
				'paras'   => array(
					'Technical SEO is the work that helps search engines crawl, render and index your site correctly. It covers site speed, mobile performance, Core Web Vitals, structured data, crawl efficiency and clean site architecture.',
					'Great content cannot rank if crawlers struggle to reach it or your pages load slowly. I remove those technical roadblocks so every other SEO effort performs at its full potential.',
				),
				'callout' => 'Most sites lose rankings to fixable technical issues they never knew existed. A single audit often uncovers quick wins.',
			),
			'includes'   => array(
				'h2'    => 'What my technical SEO service covers',
				'items' => array(
					array( 'h3' => 'Site speed and Core Web Vitals', 'p' => 'I improve loading, interactivity and visual stability to meet the metrics Google rewards.', 'h4' => 'Faster pages, better rankings', 'h4p' => 'Speed improves both rankings and conversion rates at the same time.' ),
					array( 'h3' => 'Crawlability and indexation', 'p' => 'I audit robots rules, sitemaps, redirects and canonicals so the right pages get indexed.', 'h4' => 'No wasted crawl budget', 'h4p' => 'Search engines spend their time on the pages that actually matter to you.' ),
					array( 'h3' => 'Site architecture', 'p' => 'A logical structure and internal linking help authority flow to your priority pages.', 'h4' => 'Clear paths to key pages', 'h4p' => 'Shallow, well-linked structures get important pages found and ranked faster.' ),
					array( 'h3' => 'Structured data', 'p' => 'Schema markup makes your content machine-readable for rich results and AI answers.', 'h4' => 'Rich, eligible results', 'h4p' => 'Correct schema unlocks enhanced listings and better AI understanding.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My technical SEO process',
				'steps' => array(
					array( 'h3' => 'Full technical crawl', 'p' => 'I crawl your site the way search engines do to surface every blocking issue.' ),
					array( 'h3' => 'Prioritized fix list', 'p' => 'Issues are ranked by impact and effort so we tackle the highest-value work first.' ),
					array( 'h3' => 'Implementation', 'p' => 'I implement or guide the fixes carefully, without breaking your live site.' ),
					array( 'h3' => 'Validation and monitoring', 'p' => 'I confirm fixes in search tools and watch for new issues over time.' ),
				),
			),
			'why'        => array(
				'h2'    => 'The benefits of technical SEO',
				'items' => array(
					array( 'h4' => 'Higher rankings', 'p' => 'Removing technical barriers lets your content compete on merit.' ),
					array( 'h4' => 'Better user experience', 'p' => 'Fast, stable pages keep visitors engaged and reduce bounce.' ),
					array( 'h4' => 'More pages indexed', 'p' => 'Clean crawling means more of your content actually appears in search.' ),
					array( 'h4' => 'AI crawler ready', 'p' => 'Well-structured sites are easier for AI engines to read and cite.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'How do I know if my site has technical SEO problems?', 'a' => 'A technical audit will tell you quickly. Common signs include slow pages, dropping rankings, pages missing from Google, or crawl errors in Search Console. I run a full audit before recommending any work.' ),
				array( 'q' => 'What are Core Web Vitals?', 'a' => 'They are Google metrics for loading speed, interactivity and visual stability. Passing them improves both rankings and the experience real visitors have on your site.' ),
				array( 'q' => 'Will technical fixes break my website?', 'a' => 'No. I work carefully, test changes and prioritise safe, well-documented fixes so your live site stays stable throughout.' ),
			),
			'related'    => array( 'seo-services', 'seo-audit-services', 'on-page-seo-services' ),
		),

		/* ============================================================= 4 */
		'on-page-seo-services' => array(
			'menu'       => 'On-Page SEO',
			'icon'       => '📄',
			'card_desc'  => 'Titles, headings, content and internal links tuned on every page so search engines and readers both connect instantly.',
			'h1'         => 'On-Page SEO Services',
			'tagline'    => 'Optimized titles, headings, content and structure that make each page clear to readers, search engines and AI answer engines alike.',
			'meta_title' => 'On-Page SEO Services | Content & Meta Optimization',
			'meta_desc'  => 'On-page SEO services by Avdesh Kumar. Optimized titles, meta tags, headings, content and internal links that lift rankings and engage real readers.',
			'intro'      => array(
				'h2'      => 'What is on-page SEO',
				'paras'   => array(
					'On-page SEO is the optimization of everything on a page itself: the title, meta description, heading structure, content, images and internal links. Done well, it tells search engines exactly what a page is about and helps readers find what they need fast.',
					'I write and optimize content that reads naturally for people while sending clear relevance signals to search engines and AI models. The goal is pages that rank and pages visitors actually enjoy.',
				),
				'callout' => 'On-page SEO is often the fastest lever available. Small, precise changes to existing pages can lift rankings within weeks.',
			),
			'includes'   => array(
				'h2'    => 'What my on-page SEO service includes',
				'items' => array(
					array( 'h3' => 'Title tags and meta descriptions', 'p' => 'Compelling, keyword-aware titles and descriptions that improve rankings and click-through rate.', 'h4' => 'More clicks from the same ranking', 'h4p' => 'A stronger title can raise clicks without moving position at all.' ),
					array( 'h3' => 'Heading structure', 'p' => 'A clean H1 to H4 hierarchy that organises content for readers, search engines and AI parsers.', 'h4' => 'Logical, scannable pages', 'h4p' => 'Proper headings help every reader and crawler follow your argument.' ),
					array( 'h3' => 'Content optimization', 'p' => 'Existing and new content refined for relevance, depth, readability and search intent.', 'h4' => 'Written for humans first', 'h4p' => 'Natural, valuable copy earns time on page, trust and links.' ),
					array( 'h3' => 'Internal linking', 'p' => 'Smart internal links that spread authority and guide visitors toward conversion.', 'h4' => 'Every page pulls its weight', 'h4p' => 'Internal links surface related pages and strengthen your key targets.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My on-page SEO process',
				'steps' => array(
					array( 'h3' => 'Page and keyword mapping', 'p' => 'I match each page to a primary keyword and clear search intent.' ),
					array( 'h3' => 'Content and meta optimization', 'p' => 'Titles, headings, copy and metadata are refined page by page.' ),
					array( 'h3' => 'Internal link build-out', 'p' => 'I connect related pages to strengthen relevance and flow.' ),
					array( 'h3' => 'Review and refine', 'p' => 'I track performance and iterate on the pages with the most upside.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why on-page SEO matters',
				'items' => array(
					array( 'h4' => 'Faster wins', 'p' => 'Improving pages you already have often ranks quicker than building new ones.' ),
					array( 'h4' => 'Higher click-through', 'p' => 'Better titles and descriptions earn more clicks from every impression.' ),
					array( 'h4' => 'Stronger relevance', 'p' => 'Clear structure and content help you rank for more related terms.' ),
					array( 'h4' => 'AI-friendly pages', 'p' => 'Well-structured content is easier for AI engines to summarise and cite.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'What is the difference between on-page and off-page SEO?', 'a' => 'On-page SEO covers everything you control on the page itself, such as content, titles and headings. Off-page SEO covers external signals like backlinks and mentions. Both are needed for strong rankings.' ),
				array( 'q' => 'Do you write the content or just optimize it?', 'a' => 'Both. I can optimize your existing pages or write new, reader-friendly content that is built to rank and to convert.' ),
				array( 'q' => 'How many keywords should one page target?', 'a' => 'Each page should have one clear primary keyword plus a natural set of closely related terms. Trying to target unrelated keywords on a single page weakens all of them.' ),
			),
			'related'    => array( 'seo-content-writing', 'technical-seo-services', 'seo-services' ),
		),

		/* ============================================================= 5 */
		'off-page-seo-link-building' => array(
			'menu'       => 'Off-Page SEO & Links',
			'icon'       => '🔗',
			'card_desc'  => 'Relevant, high-quality backlinks and brand mentions that build genuine authority the safe, white-hat way.',
			'h1'         => 'Off-Page SEO & Link Building Services',
			'tagline'    => 'Earned authority through relevant backlinks and trusted brand mentions. Real link building, never spam.',
			'meta_title' => 'Off-Page SEO & Link Building Services | White Hat',
			'meta_desc'  => 'White-hat link building and off-page SEO by Avdesh Kumar. Earn relevant, high-quality backlinks and brand mentions that build lasting domain authority.',
			'intro'      => array(
				'h2'      => 'What is off-page SEO',
				'paras'   => array(
					'Off-page SEO covers the signals that happen away from your website but shape how much search engines and AI models trust you. The biggest is backlinks: links from other reputable sites that act as votes of confidence.',
					'I focus on earning relevant, high-quality links and mentions through genuine outreach and valuable content. No link farms, no risky schemes, only authority that holds up over time.',
				),
				'callout' => 'A handful of trusted, relevant links will outperform hundreds of low-quality ones, and they will never put your site at risk.',
			),
			'includes'   => array(
				'h2'    => 'What my link building service includes',
				'items' => array(
					array( 'h3' => 'Backlink audit', 'p' => 'I review your current link profile and disavow or address anything toxic dragging you down.', 'h4' => 'A clean starting point', 'h4p' => 'Removing harmful links protects rankings before we build new authority.' ),
					array( 'h3' => 'Digital PR and outreach', 'p' => 'I earn links from relevant publications and sites through genuine, value-led outreach.', 'h4' => 'Relevance first', 'h4p' => 'Links from sites in your niche carry far more weight than generic ones.' ),
					array( 'h3' => 'Guest content and mentions', 'p' => 'Well-placed articles and brand mentions build both links and visibility.', 'h4' => 'Authority and awareness', 'h4p' => 'The right placements grow rankings and put your brand in front of buyers.' ),
					array( 'h3' => 'Citation building', 'p' => 'Consistent business citations strengthen trust signals, especially for local search.', 'h4' => 'Consistent everywhere', 'h4p' => 'Matching business details across the web reinforce your credibility.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My link building process',
				'steps' => array(
					array( 'h3' => 'Profile and competitor analysis', 'p' => 'I map your links against competitors to find realistic, high-value opportunities.' ),
					array( 'h3' => 'Prospecting', 'p' => 'I build a list of relevant, trustworthy sites worth earning links from.' ),
					array( 'h3' => 'Outreach and placement', 'p' => 'I pitch genuine value so links are earned, not bought from bad neighbourhoods.' ),
					array( 'h3' => 'Report and repeat', 'p' => 'Every link is documented, and momentum builds month over month.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why off-page SEO matters',
				'items' => array(
					array( 'h4' => 'Authority and trust', 'p' => 'Quality links are still one of the strongest ranking signals in search.' ),
					array( 'h4' => 'Competitive edge', 'p' => 'In tough niches, a stronger link profile is often what breaks a tie.' ),
					array( 'h4' => 'Referral traffic', 'p' => 'Good placements send interested visitors, not just link value.' ),
					array( 'h4' => 'Safe and lasting', 'p' => 'White-hat links protect your domain and keep rankings stable.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Are backlinks still important in 2026?', 'a' => 'Yes. Relevant, high-quality backlinks remain one of the most influential ranking signals, and they also feed the trust signals AI models rely on when recommending brands.' ),
				array( 'q' => 'Do you buy links?', 'a' => 'No. Bought links from low-quality networks are risky and can trigger penalties. I earn links through genuine outreach, digital PR and valuable content.' ),
				array( 'q' => 'How many links do I need?', 'a' => 'It depends on your niche and competition. The right question is not how many, but how relevant and trustworthy. I focus on quality that moves rankings safely.' ),
			),
			'related'    => array( 'seo-services', 'local-seo-services', 'seo-audit-services' ),
		),

		/* ============================================================= 6 */
		'local-seo-services' => array(
			'menu'       => 'Local SEO',
			'icon'       => '📍',
			'card_desc'  => 'Rank in the map pack and local results so nearby customers find and choose your business first.',
			'h1'         => 'Local SEO Services',
			'tagline'    => 'Own your local market. Rank in Google Maps, the local pack and near me searches that bring ready-to-buy customers.',
			'meta_title' => 'Local SEO Services | Google Business Profile & Map Pack',
			'meta_desc'  => 'Local SEO services by Avdesh Kumar. Rank in Google Maps and the local pack, optimize your Google Business Profile and win more nearby customers.',
			'intro'      => array(
				'h2'      => 'What is local SEO',
				'paras'   => array(
					'Local SEO helps your business appear when nearby customers search for what you offer. It targets the map pack, Google Maps and near me searches, the results that drive calls, visits and bookings from people ready to act.',
					'From your Google Business Profile to local citations and reviews, I optimize the signals Google uses to decide which local businesses to show first.',
				),
				'callout' => 'Local searches carry strong buying intent. People searching near me are often minutes away from choosing a business.',
			),
			'includes'   => array(
				'h2'    => 'What my local SEO service includes',
				'items' => array(
					array( 'h3' => 'Google Business Profile optimization', 'p' => 'I fully optimize your profile so it ranks well and earns clicks, calls and directions.', 'h4' => 'Your most valuable local asset', 'h4p' => 'A complete, active profile is the backbone of local visibility.' ),
					array( 'h3' => 'Local keyword targeting', 'p' => 'I optimize pages for the city and service terms your customers actually search.', 'h4' => 'Right place, right search', 'h4p' => 'Location-aware content helps you rank exactly where your buyers are.' ),
					array( 'h3' => 'Citations and consistency', 'p' => 'I build and correct business listings so your name, address and phone match everywhere.', 'h4' => 'Trust through consistency', 'h4p' => 'Consistent details reassure Google that your business is legitimate.' ),
					array( 'h3' => 'Reviews and reputation', 'p' => 'I help you earn and manage reviews that boost rankings and win trust.', 'h4' => 'Social proof that converts', 'h4p' => 'Strong reviews lift both rankings and the decision to choose you.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My local SEO process',
				'steps' => array(
					array( 'h3' => 'Local audit', 'p' => 'I assess your profile, listings, reviews and local rankings against competitors.' ),
					array( 'h3' => 'Profile and page optimization', 'p' => 'I optimize your Google Business Profile and location pages.' ),
					array( 'h3' => 'Citation and review build', 'p' => 'I strengthen listings and set up a steady flow of genuine reviews.' ),
					array( 'h3' => 'Track local rankings', 'p' => 'I monitor map pack positions and refine to grow your local share.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why local SEO matters',
				'items' => array(
					array( 'h4' => 'High-intent customers', 'p' => 'Local searchers are often ready to call, visit or buy right away.' ),
					array( 'h4' => 'Map pack visibility', 'p' => 'The top local results capture the majority of clicks and calls.' ),
					array( 'h4' => 'Less competition', 'p' => 'Local targeting lets smaller businesses outrank bigger national brands nearby.' ),
					array( 'h4' => 'Trust and reviews', 'p' => 'A strong local presence builds credibility before a customer even calls.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'What is the map pack?', 'a' => 'The map pack is the block of three local businesses Google shows with a map for location-based searches. Ranking there drives a large share of local calls and visits.' ),
				array( 'q' => 'How important are Google reviews?', 'a' => 'Very. Reviews influence both your local rankings and whether customers choose you. I help you earn more genuine reviews and respond to them well.' ),
				array( 'q' => 'Can local SEO work for service-area businesses?', 'a' => 'Yes. Even without a storefront, I can optimize your profile and pages to rank across the areas you serve.' ),
			),
			'related'    => array( 'seo-services', 'off-page-seo-link-building', 'google-ads-management' ),
		),

		/* ============================================================= 7 */
		'ecommerce-seo-services' => array(
			'menu'       => 'E-commerce SEO',
			'icon'       => '🛒',
			'card_desc'  => 'Rank product and collection pages, win high-intent shoppers and grow store revenue on Shopify, WooCommerce and more.',
			'h1'         => 'E-commerce SEO Services',
			'tagline'    => 'Turn your online store into a search engine that sells. Optimized product and category pages built to convert.',
			'meta_title' => 'E-commerce SEO Services | Shopify & WooCommerce SEO',
			'meta_desc'  => 'E-commerce SEO by Avdesh Kumar. Rank product and collection pages on Shopify, WooCommerce and more, and grow store revenue with high-intent organic traffic.',
			'intro'      => array(
				'h2'      => 'What is e-commerce SEO',
				'paras'   => array(
					'E-commerce SEO is the optimization of an online store so its product and category pages rank for the searches shoppers use with real buying intent. It combines keyword strategy, on-page work, technical health and content to grow sales without paying for every click.',
					'Online stores have unique challenges: large catalogues, duplicate content, faceted navigation and thin product pages. I solve these so your best products get found and bought.',
				),
				'callout' => 'Organic search is often the highest-margin channel for a store, because it keeps delivering sales long after the work is done.',
			),
			'includes'   => array(
				'h2'    => 'What my e-commerce SEO service includes',
				'items' => array(
					array( 'h3' => 'Product and collection SEO', 'p' => 'I optimize titles, descriptions and structure so category and product pages rank and convert.', 'h4' => 'Pages built to sell', 'h4p' => 'Clear, keyword-aware product content earns rankings and trust from shoppers.' ),
					array( 'h3' => 'Technical store health', 'p' => 'I fix duplicate content, faceted navigation, indexing and speed issues common to stores.', 'h4' => 'A store crawlers love', 'h4p' => 'Clean architecture ensures your money pages get indexed, not buried.' ),
					array( 'h3' => 'Product schema', 'p' => 'Structured data unlocks rich results with prices, ratings and availability.', 'h4' => 'Stand out in results', 'h4p' => 'Rich product listings attract more qualified clicks.' ),
					array( 'h3' => 'Content and buying guides', 'p' => 'Helpful guides capture research-stage shoppers and funnel them toward purchase.', 'h4' => 'Win the whole journey', 'h4p' => 'Content earns trust early so you are the store they buy from later.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My e-commerce SEO process',
				'steps' => array(
					array( 'h3' => 'Store audit', 'p' => 'I review catalogue structure, technical health and rankings to find growth levers.' ),
					array( 'h3' => 'Keyword and category strategy', 'p' => 'I map buyer keywords to the right collection and product pages.' ),
					array( 'h3' => 'Optimization and content', 'p' => 'I optimize pages, add schema and build supporting content.' ),
					array( 'h3' => 'Measure revenue impact', 'p' => 'I track rankings, traffic and, most importantly, sales.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why e-commerce SEO matters',
				'items' => array(
					array( 'h4' => 'High-intent traffic', 'p' => 'Shoppers searching for products are close to buying.' ),
					array( 'h4' => 'Lower cost per sale', 'p' => 'Organic sales do not carry the ongoing cost of paid ads.' ),
					array( 'h4' => 'Compounding growth', 'p' => 'Rankings you earn keep working month after month.' ),
					array( 'h4' => 'Platform expertise', 'p' => 'Comfortable across Shopify, WooCommerce, WordPress and more.' ),
				),
			),
			'platforms'  => array(
				'h2'    => 'Platforms I optimize',
				'para'  => 'I tailor e-commerce SEO to the strengths and quirks of each platform so your store performs at its best.',
				'items' => array(
					array( 'h3' => 'Shopify SEO', 'p' => 'Collection, product and blog optimization plus technical fixes unique to Shopify.' ),
					array( 'h3' => 'WooCommerce SEO', 'p' => 'Full control over speed, schema and structure on WordPress stores.' ),
					array( 'h3' => 'Wix and Squarespace stores', 'p' => 'Practical optimization that gets these builders selling through search.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Which is better for SEO, Shopify or WooCommerce?', 'a' => 'Both can rank well. Shopify is simple and fast to launch, while WooCommerce offers deeper technical control. I optimize whichever platform you use, so choose the one that fits your business.' ),
				array( 'q' => 'How do you handle large product catalogues?', 'a' => 'I prioritise your highest-value categories and products, fix duplicate content and faceted navigation, and use templates and schema to scale optimization across the catalogue.' ),
				array( 'q' => 'Can SEO reduce my ad spend?', 'a' => 'Often, yes. As organic rankings grow, many stores rely less on paid ads for the same sales, improving overall margins.' ),
			),
			'related'    => array( 'seo-services', 'technical-seo-services', 'google-ads-management' ),
		),

		/* ============================================================= 8 */
		'google-ads-management' => array(
			'menu'       => 'Google Ads',
			'icon'       => '🎯',
			'card_desc'  => 'Profitable Google Ads campaigns that capture demand today while your SEO compounds for the long term.',
			'h1'         => 'Google Ads Management Services',
			'tagline'    => 'Search, Shopping and Performance Max campaigns built for ROI. Get qualified leads and sales while your organic growth builds.',
			'meta_title' => 'Google Ads Management Services | PPC for ROI',
			'meta_desc'  => 'Google Ads management by Avdesh Kumar. Profitable PPC campaigns across Search, Shopping and Performance Max, optimized for qualified leads and real ROI.',
			'intro'      => array(
				'h2'      => 'Google Ads that pay for themselves',
				'paras'   => array(
					'Google Ads puts your business at the top of search results the moment someone is looking for what you sell. Managed well, it delivers qualified leads and sales you can measure from day one.',
					'I build and optimize campaigns around profit, not clicks. Every rupee or dollar is aimed at the searches most likely to convert, so your budget works as hard as possible.',
				),
				'callout' => 'Paid and organic work best together. Ads capture demand now while SEO and GEO build durable, lower-cost visibility over time.',
			),
			'includes'   => array(
				'h2'    => 'What my Google Ads management includes',
				'items' => array(
					array( 'h3' => 'Campaign strategy and setup', 'p' => 'I build Search, Shopping and Performance Max campaigns structured for control and profit.', 'h4' => 'Built on buyer intent', 'h4p' => 'Budget focuses on the searches most likely to turn into customers.' ),
					array( 'h3' => 'Keyword and audience targeting', 'p' => 'Tight targeting and negative keywords stop wasted spend before it happens.', 'h4' => 'Spend only where it counts', 'h4p' => 'Negatives and precise audiences protect your budget from junk clicks.' ),
					array( 'h3' => 'Ad copy and creative', 'p' => 'Compelling, relevant ads that lift Quality Score and click-through rate.', 'h4' => 'Better ads, lower costs', 'h4p' => 'Higher Quality Score means more clicks for the same budget.' ),
					array( 'h3' => 'Conversion tracking and optimization', 'p' => 'Accurate tracking and ongoing tuning drive down cost per result over time.', 'h4' => 'Decisions from real data', 'h4p' => 'Proper tracking shows what truly drives leads and sales.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My Google Ads process',
				'steps' => array(
					array( 'h3' => 'Goals and tracking', 'p' => 'I define clear goals and set up conversion tracking before a rupee is spent.' ),
					array( 'h3' => 'Build and launch', 'p' => 'I structure campaigns, write ads and launch with tight targeting.' ),
					array( 'h3' => 'Optimize', 'p' => 'I refine bids, keywords, audiences and creative to lower cost per result.' ),
					array( 'h3' => 'Report and scale', 'p' => 'Clear reporting shows ROI, and winning campaigns are scaled with confidence.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why choose me for Google Ads',
				'items' => array(
					array( 'h4' => 'Immediate visibility', 'p' => 'Reach ready-to-buy customers at the top of search right away.' ),
					array( 'h4' => 'ROI focus', 'p' => 'Every campaign is judged on leads and sales, not vanity metrics.' ),
					array( 'h4' => 'Full-funnel view', 'p' => 'I align ads with your SEO so channels support each other.' ),
					array( 'h4' => 'Transparent reporting', 'p' => 'You always know what you spend and what it returns.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'How much should I budget for Google Ads?', 'a' => 'It depends on your industry, competition and goals. I recommend starting with a controlled budget to gather data, then scaling what proves profitable. I will suggest a realistic starting point for your niche.' ),
				array( 'q' => 'Should I do SEO or Google Ads?', 'a' => 'Ideally both. Ads deliver leads quickly while SEO and GEO build lasting, lower-cost visibility. Together they cover the whole customer journey, and I can manage both.' ),
				array( 'q' => 'How soon will I see results from Google Ads?', 'a' => 'Ads can drive traffic and leads within days of launch. The first few weeks are used to gather data and optimize toward your lowest cost per result.' ),
			),
			'related'    => array( 'seo-services', 'ecommerce-seo-services', 'local-seo-services' ),
		),

		/* ============================================================= 9 */
		'seo-content-writing' => array(
			'menu'       => 'SEO Content Writing',
			'icon'       => '✍️',
			'card_desc'  => 'Reader-friendly, AI-optimized content that ranks in Google, earns trust and gets quoted by answer engines.',
			'h1'         => 'SEO Content Writing Services',
			'tagline'    => 'Content that ranks and reads well. Written for people, optimized for search engines, and structured to be cited by AI.',
			'meta_title' => 'SEO Content Writing Services | AI-Optimized Content',
			'meta_desc'  => 'SEO content writing by Avdesh Kumar. Reader-friendly, keyword-optimized content structured to rank in search and get cited by AI answer engines.',
			'intro'      => array(
				'h2'      => 'Content that ranks and connects',
				'paras'   => array(
					'SEO content writing creates pages and articles that rank in search while genuinely helping the reader. The best SEO content answers real questions clearly, so it earns rankings, time on page and trust at the same time.',
					'I write content that is optimized for both traditional search and generative engines. Clear structure, direct answers and natural keyword use mean your pages perform in Google and get quoted by AI assistants.',
				),
				'callout' => 'Content written only for search engines no longer works. Content written for people, structured for machines, wins on both fronts.',
			),
			'includes'   => array(
				'h2'    => 'What my content service includes',
				'items' => array(
					array( 'h3' => 'Keyword-driven briefs', 'p' => 'Every piece starts from research so it targets terms with real demand and intent.', 'h4' => 'Purpose before words', 'h4p' => 'A solid brief keeps content focused, relevant and rank-worthy.' ),
					array( 'h3' => 'Reader-first writing', 'p' => 'Clear, natural, valuable copy that keeps visitors engaged and builds trust.', 'h4' => 'Connection over keyword stuffing', 'h4p' => 'Content people enjoy earns the signals that actually lift rankings.' ),
					array( 'h3' => 'AI and GEO optimization', 'p' => 'Definitions, direct answers and FAQ blocks make your content easy for LLMs to cite.', 'h4' => 'Quotable structure', 'h4p' => 'Well-structured passages are what AI answer engines pull into results.' ),
					array( 'h3' => 'On-page and schema ready', 'p' => 'Proper headings, internal links and markup so content performs from day one.', 'h4' => 'Optimized end to end', 'h4p' => 'Content ships ready to rank, not needing rework later.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My content process',
				'steps' => array(
					array( 'h3' => 'Research and brief', 'p' => 'I identify topics and keywords worth ranking for and build a clear brief.' ),
					array( 'h3' => 'Write and optimize', 'p' => 'I write reader-friendly content structured for search and AI engines.' ),
					array( 'h3' => 'Edit and enhance', 'p' => 'I refine for clarity, add internal links and structured data.' ),
					array( 'h3' => 'Publish and track', 'p' => 'I monitor performance and update content to keep it ranking.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why my content works',
				'items' => array(
					array( 'h4' => 'Ranks in search', 'p' => 'Keyword and intent research means content targets real demand.' ),
					array( 'h4' => 'Cited by AI', 'p' => 'Clear, structured answers get pulled into AI-generated results.' ),
					array( 'h4' => 'Builds authority', 'p' => 'Helpful content positions your brand as the trusted expert.' ),
					array( 'h4' => 'Drives action', 'p' => 'Content is written to move readers toward becoming customers.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Is AI-written content good for SEO?', 'a' => 'Content quality matters more than how it is produced. I combine research, human editing and clear structure so your content is accurate, valuable and optimized, whatever tools support the process.' ),
				array( 'q' => 'How is content optimized for AI answer engines?', 'a' => 'By leading with clear definitions and direct answers, using logical headings, and adding FAQ and schema markup. This structure is exactly what LLMs look for when choosing what to quote.' ),
				array( 'q' => 'Do you write for any industry?', 'a' => 'Yes. I research each topic thoroughly and can adapt tone and depth to your audience, from technical B2B to consumer brands.' ),
			),
			'related'    => array( 'on-page-seo-services', 'ai-search-optimization', 'seo-services' ),
		),

		/* ============================================================= 10 */
		'seo-audit-services' => array(
			'menu'       => 'SEO Audit',
			'icon'       => '📊',
			'card_desc'  => 'A deep, actionable SEO audit that shows exactly what is holding your rankings back and how to fix it.',
			'h1'         => 'SEO Audit Services',
			'tagline'    => 'Know precisely what is limiting your rankings. A clear, prioritized audit with a roadmap you can act on immediately.',
			'meta_title' => 'SEO Audit Services | Website & Technical Audit',
			'meta_desc'  => 'Comprehensive SEO audit by Avdesh Kumar. Uncover technical, on-page and off-page issues holding your site back, with a prioritized roadmap to fix them.',
			'intro'      => array(
				'h2'      => 'What is an SEO audit',
				'paras'   => array(
					'An SEO audit is a full health check of your website that reveals why it is not ranking as well as it could. It examines technical health, on-page optimization, content quality and your backlink profile, then turns the findings into a clear action plan.',
					'My audits are practical, not just a long list of problems. You get prioritized recommendations tied to impact, so you know exactly what to fix first for the biggest gains.',
				),
				'callout' => 'You cannot fix what you cannot see. A proper audit often uncovers quick wins that lift rankings within weeks.',
			),
			'includes'   => array(
				'h2'    => 'What my SEO audit covers',
				'items' => array(
					array( 'h3' => 'Technical audit', 'p' => 'Crawlability, indexation, speed, Core Web Vitals and mobile performance.', 'h4' => 'The foundation', 'h4p' => 'Technical issues silently cap rankings until they are found and fixed.' ),
					array( 'h3' => 'On-page audit', 'p' => 'Titles, headings, content depth, keyword targeting and internal linking.', 'h4' => 'Relevance and clarity', 'h4p' => 'On-page gaps are often the fastest wins in the whole report.' ),
					array( 'h3' => 'Content and gap analysis', 'p' => 'Where your content underperforms and which topics competitors own.', 'h4' => 'Opportunities you are missing', 'h4p' => 'Content gaps show exactly where new pages can win traffic.' ),
					array( 'h3' => 'Backlink and off-page review', 'p' => 'Link profile quality, toxic links and authority compared to competitors.', 'h4' => 'Trust and risk check', 'h4p' => 'I flag harmful links and the authority gap you need to close.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My SEO audit process',
				'steps' => array(
					array( 'h3' => 'Data gathering', 'p' => 'I crawl your site and pull data from search and analytics tools.' ),
					array( 'h3' => 'Analysis', 'p' => 'I diagnose the issues limiting rankings and traffic across every area.' ),
					array( 'h3' => 'Prioritized report', 'p' => 'You receive findings ranked by impact and effort, in plain language.' ),
					array( 'h3' => 'Action roadmap', 'p' => 'A clear plan of what to fix first, with the option to implement it together.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why start with an audit',
				'items' => array(
					array( 'h4' => 'Clarity', 'p' => 'You learn exactly what is holding your site back, with no guesswork.' ),
					array( 'h4' => 'Quick wins', 'p' => 'Audits usually surface fixes that lift rankings fast.' ),
					array( 'h4' => 'Smart spending', 'p' => 'You invest effort where it delivers the most return.' ),
					array( 'h4' => 'A real roadmap', 'p' => 'You leave with a prioritized plan, not just a problem list.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'How long does an SEO audit take?', 'a' => 'A thorough audit typically takes a few days to a week, depending on the size of your site. You receive a clear, prioritized report and a walkthrough of the findings.' ),
				array( 'q' => 'Do I have to hire you to implement the fixes?', 'a' => 'No. The audit is yours to act on with any team. That said, many clients ask me to implement the roadmap because I already understand their site.' ),
				array( 'q' => 'How often should I audit my website?', 'a' => 'A full audit once or twice a year is sensible for most sites, plus a fresh audit after any major redesign, migration or ranking drop.' ),
			),
			'related'    => array( 'technical-seo-services', 'seo-services', 'on-page-seo-services' ),
		),

		/* ============================================================= 11 */
		'international-seo-services' => array(
			'menu'       => 'International SEO',
			'icon'       => '🌍',
			'card_desc'  => 'Rank in multiple countries and languages with hreflang, geo-targeting and localized content that wins global markets.',
			'h1'         => 'International SEO Services',
			'tagline'    => 'Expand into new countries the right way. Multi-region, multi-language SEO that captures demand across the USA, UK, Canada, Australia, UAE, Europe and beyond.',
			'meta_title' => 'International SEO Services | Multi-Country & Multilingual',
			'meta_desc'  => 'International SEO services by Avdesh Kumar. Rank across countries and languages with hreflang, geo-targeting and localized content built for global growth.',
			'intro'      => array(
				'h2'      => 'What is international SEO',
				'paras'   => array(
					'International SEO is the practice of optimizing your website so it ranks in the right language and country for each of your target markets. It combines hreflang tags, geo-targeting, localized content and the correct site structure so search engines serve the right version to the right audience.',
					'Getting this wrong causes duplicate content, wrong-country rankings and lost traffic. I set up your international presence cleanly so every market sees the version built for them.',
				),
				'callout' => 'A single global site can quietly cannibalize itself. Correct international structure turns that confusion into compounding growth in every market.',
			),
			'includes'   => array(
				'h2'    => 'What my international SEO service includes',
				'items' => array(
					array( 'h3' => 'Hreflang and structure', 'p' => 'Correct hreflang, canonical and URL structure so each country and language version ranks where it should.', 'h4' => 'The right page, the right market', 'h4p' => 'Clean signals stop the wrong version outranking the one built for that audience.' ),
					array( 'h3' => 'Market and keyword research', 'p' => 'Local keyword research per country, because buyers search differently in each language and region.', 'h4' => 'Local intent, not translation', 'h4p' => 'Real local research beats direct translation for rankings and relevance.' ),
					array( 'h3' => 'Content localization', 'p' => 'Content adapted to local language, culture, currency and buying habits, not just translated.', 'h4' => 'Content that converts locally', 'h4p' => 'Localized content earns trust and turns visitors into customers.' ),
					array( 'h3' => 'Technical geo-targeting', 'p' => 'Search Console geo-targeting, ccTLD or subfolder strategy and server considerations handled correctly.', 'h4' => 'Foundations for scale', 'h4p' => 'The right architecture makes adding new markets simple later.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My international SEO process',
				'steps' => array(
					array( 'h3' => 'Market strategy', 'p' => 'I define target countries, languages and the best URL structure for your goals.' ),
					array( 'h3' => 'Technical setup', 'p' => 'I implement hreflang, geo-targeting and a clean, scalable structure.' ),
					array( 'h3' => 'Localization', 'p' => 'I guide local keyword research and content adaptation per market.' ),
					array( 'h3' => 'Measure per market', 'p' => 'I track rankings and traffic country by country and refine each one.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why international SEO matters',
				'items' => array(
					array( 'h4' => 'Reach new markets', 'p' => 'Tap demand in high-value countries you are not visible in yet.' ),
					array( 'h4' => 'Avoid costly mistakes', 'p' => 'Correct setup prevents duplicate content and wrong-country rankings.' ),
					array( 'h4' => 'Localized trust', 'p' => 'Buyers convert more when content speaks their language and context.' ),
					array( 'h4' => 'Scalable growth', 'p' => 'A clean structure lets you add markets without rebuilding.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Should I use ccTLDs, subfolders or subdomains?', 'a' => 'It depends on your resources and goals. Subfolders on one strong domain are often the most efficient for concentrating authority, while ccTLDs suit large brands committed to each market. I recommend the right structure for your situation.' ),
				array( 'q' => 'Is translation enough for international SEO?', 'a' => 'No. Direct translation misses local search terms, culture and intent. I focus on true localization with local keyword research so each market gets content that ranks and converts.' ),
				array( 'q' => 'How does hreflang help?', 'a' => 'Hreflang tells search engines which language and region each page targets, so the correct version is shown to each user. Done wrong, it causes serious ranking issues, so it needs careful implementation.' ),
			),
			'related'    => array( 'technical-seo-services', 'seo-services', 'content-strategy-services' ),
		),

		/* ============================================================= 12 */
		'keyword-research-services' => array(
			'menu'       => 'Keyword Research',
			'icon'       => '🔑',
			'card_desc'  => 'Data-driven keyword research that finds the searches with real commercial value and maps them to the right pages.',
			'h1'         => 'Keyword Research Services',
			'tagline'    => 'The foundation of every winning SEO campaign. I find the keywords your buyers actually use and turn them into a clear, rankable content plan.',
			'meta_title' => 'Keyword Research Services | SEO Keyword Strategy',
			'meta_desc'  => 'Professional keyword research by Avdesh Kumar. Find high-value, high-intent keywords and get a clear content map built to rank and convert.',
			'intro'      => array(
				'h2'      => 'Why keyword research comes first',
				'paras'   => array(
					'Keyword research is the process of finding the exact searches your potential customers use, then measuring their demand, difficulty and intent. It is the foundation every other SEO decision is built on.',
					'I go beyond search volume. I prioritise keywords by commercial intent and realistic ranking potential, then map each one to the right page so your effort targets terms that actually drive revenue.',
				),
				'callout' => 'The wrong keywords waste months of effort. The right ones make every other SEO investment pay off faster.',
			),
			'includes'   => array(
				'h2'    => 'What my keyword research includes',
				'items' => array(
					array( 'h3' => 'Seed and competitor analysis', 'p' => 'I expand from your core topics and mine competitor keywords for proven opportunities.', 'h4' => 'Learn from what already ranks', 'h4p' => 'Competitor gaps reveal the fastest, most realistic wins.' ),
					array( 'h3' => 'Intent classification', 'p' => 'Every keyword is tagged by intent so buyers reach pages built to convert them.', 'h4' => 'Match the moment', 'h4p' => 'Aligning intent to page type lifts both rankings and conversions.' ),
					array( 'h3' => 'Difficulty and priority', 'p' => 'I balance demand against difficulty to sequence quick wins and long-term targets.', 'h4' => 'A realistic roadmap', 'h4p' => 'You focus effort where it pays off soonest.' ),
					array( 'h3' => 'Keyword-to-page mapping', 'p' => 'Each keyword is assigned to a specific page so nothing competes with itself.', 'h4' => 'No cannibalization', 'h4p' => 'Clear mapping stops your own pages fighting each other.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My keyword research process',
				'steps' => array(
					array( 'h3' => 'Discovery', 'p' => 'I learn your business, offers and best customers to anchor the research.' ),
					array( 'h3' => 'Research and expansion', 'p' => 'I build a full keyword universe from seeds, competitors and search tools.' ),
					array( 'h3' => 'Prioritize and map', 'p' => 'I score by intent, difficulty and value, then map keywords to pages.' ),
					array( 'h3' => 'Deliver the plan', 'p' => 'You get a clear content map and priority list ready to execute.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why my keyword research works',
				'items' => array(
					array( 'h4' => 'Revenue focus', 'p' => 'I prioritise commercial intent, not just high traffic.' ),
					array( 'h4' => 'Realistic targets', 'p' => 'Difficulty scoring keeps the plan achievable.' ),
					array( 'h4' => 'Ready to execute', 'p' => 'You leave with a clear content map, not a raw list.' ),
					array( 'h4' => 'AI-aware', 'p' => 'I include the questions buyers ask AI engines, not just Google.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'How many keywords will I get?', 'a' => 'Quality matters more than quantity. You receive a prioritized, mapped set focused on the terms most likely to drive traffic and revenue, rather than a bloated list of low-value keywords.' ),
				array( 'q' => 'Do you research keywords for AI search too?', 'a' => 'Yes. I include the natural-language questions people ask AI assistants, so your content is ready for both Google and generative engines.' ),
				array( 'q' => 'Can I use this for content and ads?', 'a' => 'Absolutely. A solid keyword map informs your SEO content, site structure and Google Ads targeting all at once.' ),
			),
			'related'    => array( 'content-strategy-services', 'seo-services', 'on-page-seo-services' ),
		),

		/* ============================================================= 13 */
		'content-strategy-services' => array(
			'menu'       => 'Content Strategy',
			'icon'       => '🗺️',
			'card_desc'  => 'Topic clusters and editorial planning that build topical authority and rank you across entire subject areas.',
			'h1'         => 'SEO Content Strategy Services',
			'tagline'    => 'A clear plan for what to publish and why. Topic clusters and content roadmaps that build authority and rank you across your whole niche.',
			'meta_title' => 'SEO Content Strategy Services | Topic Clusters & Planning',
			'meta_desc'  => 'SEO content strategy by Avdesh Kumar. Topic clusters, content calendars and editorial planning that build topical authority and drive organic growth.',
			'intro'      => array(
				'h2'      => 'What is SEO content strategy',
				'paras'   => array(
					'SEO content strategy is the plan that decides what content to create, in what order, and how it connects, so your site builds authority around the topics that matter to your business. It turns scattered blog posts into a structured system that ranks.',
					'I design pillar and cluster structures that signal genuine expertise to both Google and AI answer engines, then map them to a realistic publishing calendar you can actually follow.',
				),
				'callout' => 'Random posts rarely rank. A connected content strategy compounds, with each new piece strengthening the rest.',
			),
			'includes'   => array(
				'h2'    => 'What my content strategy includes',
				'items' => array(
					array( 'h3' => 'Topic cluster architecture', 'p' => 'Pillar pages and supporting clusters that build topical authority across your niche.', 'h4' => 'Authority by design', 'h4p' => 'Clusters tell search engines you truly own a subject.' ),
					array( 'h3' => 'Content gap analysis', 'p' => 'I find the valuable topics competitors rank for and you are missing.', 'h4' => 'Capture missed demand', 'h4p' => 'Gaps are ready-made opportunities to win new traffic.' ),
					array( 'h3' => 'Editorial calendar', 'p' => 'A prioritized publishing plan tied to keywords, intent and business goals.', 'h4' => 'A plan you can follow', 'h4p' => 'Clear priorities keep content consistent and on-strategy.' ),
					array( 'h3' => 'Internal linking plan', 'p' => 'A linking blueprint so authority flows to your most important pages.', 'h4' => 'Every piece supports the goal', 'h4p' => 'Smart internal links turn content into a ranking engine.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My content strategy process',
				'steps' => array(
					array( 'h3' => 'Audit and research', 'p' => 'I review existing content, competitors and keyword opportunities.' ),
					array( 'h3' => 'Cluster design', 'p' => 'I map pillars, clusters and the internal links that connect them.' ),
					array( 'h3' => 'Calendar and briefs', 'p' => 'I prioritise topics and can provide briefs ready for writers.' ),
					array( 'h3' => 'Review and adapt', 'p' => 'I track performance and evolve the plan as you grow.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why strategy beats random posting',
				'items' => array(
					array( 'h4' => 'Compounding results', 'p' => 'Connected content builds authority that lifts every page.' ),
					array( 'h4' => 'Topical authority', 'p' => 'Owning a topic is how you rank for its most competitive terms.' ),
					array( 'h4' => 'Efficient effort', 'p' => 'You publish with purpose instead of guessing.' ),
					array( 'h4' => 'AI visibility', 'p' => 'Well-structured topics are easier for AI engines to cite.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'What are topic clusters?', 'a' => 'A topic cluster is a central pillar page on a broad subject, supported by detailed cluster pages on related subtopics, all interlinked. This structure signals expertise and helps you rank across an entire topic.' ),
				array( 'q' => 'Do you write the content too?', 'a' => 'I can provide the strategy and briefs, and write the content, or work alongside your existing writers. The strategy works either way.' ),
				array( 'q' => 'How often should I publish?', 'a' => 'Consistency beats volume. I set a realistic cadence you can sustain, because steady, quality publishing outperforms occasional bursts.' ),
			),
			'related'    => array( 'seo-content-writing', 'keyword-research-services', 'ai-search-optimization' ),
		),

		/* ============================================================= 14 */
		'website-migration-services' => array(
			'menu'       => 'Website Migration',
			'icon'       => '🚚',
			'card_desc'  => 'Redesign, replatform or move domains without losing rankings or traffic. Safe, carefully managed SEO migrations.',
			'h1'         => 'Website Migration SEO Services',
			'tagline'    => 'Redesigning, replatforming or changing domain? I protect your rankings and traffic through a carefully planned, low-risk migration.',
			'meta_title' => 'Website Migration SEO Services | Safe Replatforming',
			'meta_desc'  => 'Website migration SEO by Avdesh Kumar. Redesign, replatform or move domains without losing rankings or traffic, with a safe, carefully managed process.',
			'intro'      => array(
				'h2'      => 'Protect your rankings during a migration',
				'paras'   => array(
					'A website migration is any major change to your site: a redesign, a new platform, a new domain or a restructure of URLs. Handled poorly, migrations are one of the fastest ways to lose years of hard-won rankings and traffic overnight.',
					'I plan and manage the SEO side of your migration end to end, from redirect mapping to post-launch monitoring, so you keep your rankings and often come out stronger.',
				),
				'callout' => 'Most traffic drops after a redesign are avoidable. A proper migration plan is the difference between keeping your rankings and rebuilding them.',
			),
			'includes'   => array(
				'h2'    => 'What my migration service includes',
				'items' => array(
					array( 'h3' => 'Pre-migration audit', 'p' => 'I benchmark rankings, traffic and every URL so nothing is lost in the move.', 'h4' => 'Know what to protect', 'h4p' => 'A full baseline lets us verify success afterward.' ),
					array( 'h3' => 'Redirect mapping', 'p' => 'A complete 301 redirect map so every old URL points to the right new one.', 'h4' => 'No broken equity', 'h4p' => 'Correct redirects preserve rankings and link value.' ),
					array( 'h3' => 'Technical QA', 'p' => 'I check metadata, structure, schema and crawlability before and after launch.', 'h4' => 'Launch with confidence', 'h4p' => 'Careful QA catches issues before search engines do.' ),
					array( 'h3' => 'Post-launch monitoring', 'p' => 'I watch rankings, errors and indexing closely to fix any issues fast.', 'h4' => 'Catch problems early', 'h4p' => 'Quick post-launch fixes prevent small dips becoming big losses.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My migration process',
				'steps' => array(
					array( 'h3' => 'Plan and benchmark', 'p' => 'I document the current site and build the migration and redirect plan.' ),
					array( 'h3' => 'Pre-launch checks', 'p' => 'I QA the new site on staging against the SEO checklist.' ),
					array( 'h3' => 'Launch support', 'p' => 'I oversee go-live, redirects and indexing signals.' ),
					array( 'h3' => 'Monitor and recover', 'p' => 'I track performance and resolve any issues quickly.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why migrations need an SEO',
				'items' => array(
					array( 'h4' => 'Avoid traffic loss', 'p' => 'A planned migration protects the rankings you have earned.' ),
					array( 'h4' => 'Peace of mind', 'p' => 'You launch knowing the SEO risks are handled.' ),
					array( 'h4' => 'Opportunity to improve', 'p' => 'Migrations are the perfect time to fix old technical debt.' ),
					array( 'h4' => 'Fast recovery', 'p' => 'Close monitoring means any issues are caught and fixed early.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Will I lose rankings when I redesign my site?', 'a' => 'Not with a proper plan. Ranking drops usually come from missing redirects, changed URLs or lost content. A managed migration protects your rankings and often improves them.' ),
				array( 'q' => 'When should you be involved in a migration?', 'a' => 'As early as possible, ideally before design and development are finalised. Early involvement prevents the mistakes that are hardest to fix after launch.' ),
				array( 'q' => 'How long does recovery take if there is a dip?', 'a' => 'With correct redirects and quick fixes, most sites stabilise within a few weeks. Early monitoring is key to a fast recovery.' ),
			),
			'related'    => array( 'technical-seo-services', 'seo-audit-services', 'core-web-vitals-optimization' ),
		),

		/* ============================================================= 15 */
		'core-web-vitals-optimization' => array(
			'menu'       => 'Core Web Vitals',
			'icon'       => '⚡',
			'card_desc'  => 'Faster, more stable pages that pass Core Web Vitals, lift rankings and improve conversion rates.',
			'h1'         => 'Core Web Vitals Optimization Services',
			'tagline'    => 'Speed is a ranking factor and a conversion factor. I make your pages fast, stable and Core Web Vitals compliant.',
			'meta_title' => 'Core Web Vitals Optimization | Site Speed & Page Experience',
			'meta_desc'  => 'Core Web Vitals optimization by Avdesh Kumar. Improve LCP, INP and CLS, pass Google page experience and boost both rankings and conversions.',
			'intro'      => array(
				'h2'      => 'What are Core Web Vitals',
				'paras'   => array(
					'Core Web Vitals are Google metrics that measure real-world page experience: loading speed (LCP), interactivity (INP) and visual stability (CLS). They are a confirmed ranking signal and a major influence on how visitors experience your site.',
					'Slow, unstable pages lose both rankings and customers. I diagnose exactly what is slowing your site down and fix it, so you pass Core Web Vitals and give visitors a fast, smooth experience.',
				),
				'callout' => 'Every second of load time costs you rankings and conversions. Fixing Core Web Vitals improves both at once.',
			),
			'includes'   => array(
				'h2'    => 'What my Core Web Vitals service includes',
				'items' => array(
					array( 'h3' => 'Performance audit', 'p' => 'I measure LCP, INP and CLS with lab and field data to find the real bottlenecks.', 'h4' => 'Fix the right things', 'h4p' => 'Real-user data ensures effort goes where it actually helps.' ),
					array( 'h3' => 'Speed optimization', 'p' => 'Image, code, caching and server improvements that cut load times.', 'h4' => 'Faster on every device', 'h4p' => 'Optimizations target mobile, where most visitors and rankings are decided.' ),
					array( 'h3' => 'Stability fixes', 'p' => 'I eliminate layout shifts and slow interactions that frustrate users.', 'h4' => 'Smooth, stable pages', 'h4p' => 'No jumping content or laggy taps means happier visitors.' ),
					array( 'h3' => 'Ongoing validation', 'p' => 'I confirm passing scores in Search Console and guard against regressions.', 'h4' => 'Stay in the green', 'h4p' => 'Monitoring keeps your scores healthy as the site changes.' ),
				),
			),
			'process'    => array(
				'h2'    => 'My Core Web Vitals process',
				'steps' => array(
					array( 'h3' => 'Measure', 'p' => 'I gather lab and field data to see how real users experience your site.' ),
					array( 'h3' => 'Diagnose', 'p' => 'I pinpoint what harms LCP, INP and CLS on your key templates.' ),
					array( 'h3' => 'Optimize', 'p' => 'I implement or guide the fixes across images, code, caching and hosting.' ),
					array( 'h3' => 'Validate', 'p' => 'I confirm passing scores and set up monitoring to keep them.' ),
				),
			),
			'why'        => array(
				'h2'    => 'Why Core Web Vitals matter',
				'items' => array(
					array( 'h4' => 'Ranking boost', 'p' => 'Passing scores support higher rankings, especially on mobile.' ),
					array( 'h4' => 'Higher conversions', 'p' => 'Faster pages keep visitors and increase sales and leads.' ),
					array( 'h4' => 'Lower bounce', 'p' => 'Speed and stability keep people engaged instead of leaving.' ),
					array( 'h4' => 'Better ad performance', 'p' => 'Fast landing pages also improve Google Ads Quality Score.' ),
				),
			),
			'faq'        => array(
				array( 'q' => 'Do Core Web Vitals really affect rankings?', 'a' => 'Yes. They are part of Google page experience signals. While content relevance matters most, strong Core Web Vitals give you an edge, particularly in competitive niches and on mobile.' ),
				array( 'q' => 'My site is slow. Where do you start?', 'a' => 'With measurement. I gather real-user and lab data to find the biggest bottlenecks, then fix those first for the fastest, most meaningful gains.' ),
				array( 'q' => 'Will this work on WordPress and Shopify?', 'a' => 'Yes. I optimize Core Web Vitals across WordPress, Shopify, WooCommerce and custom sites, tailoring the fixes to each platform.' ),
			),
			'related'    => array( 'technical-seo-services', 'seo-audit-services', 'website-migration-services' ),
		),
	);

	return $services;
}

/** Get a single service by slug. */
function avdesh_get_service( $slug ) {
	$all = avdesh_services();
	return isset( $all[ $slug ] ) ? $all[ $slug ] : null;
}
