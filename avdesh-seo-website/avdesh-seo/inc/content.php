<?php
/**
 * Default editable page content.
 *
 * This copy is seeded into each page on theme activation so the pages look
 * complete out of the box AND stay fully editable from Pages in the WordPress
 * dashboard. The design (hero, sidebar, colours, typography) is handled by the
 * templates, while everything returned here appears inside the normal page
 * editor as ordinary headings and paragraphs.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the default HTML content for a page slug.
 *
 * @param string $slug Page slug.
 * @return string HTML content (empty string if none).
 */
function avseo_default_content( $slug ) {
	$c = array();

	/* -------------------- HOMEPAGE (about section text) -------------------- */
	$c['home'] = '
<p>Hi, I\'m Avdesh Kumar, an SEO and AI Search Optimization Specialist based in Delhi, India with 8 years of hands-on experience across highly competitive markets.</p>
<p>I take an AI-first approach to search, helping businesses increase visibility across Google and modern LLM platforms while keeping a strong focus on long-term, sustainable revenue growth. My work spans on-page, technical and off-page SEO across platforms like WordPress, Shopify, Wix and Squarespace.</p>
<p>I focus on what truly drives performance: qualified traffic, leads and sales, not vanity rankings. Every strategy uses proven white hat methods that build lasting authority and real ROI.</p>';

	/* -------------------- ABOUT -------------------- */
	$c['about'] = '
<h2>Who I am</h2>
<p>I am an SEO and AI Search Optimization Specialist with a simple belief: search should grow your revenue, not just your rankings. Over the last 8 years I have worked across highly competitive markets, building white hat strategies that hold up over time and keep delivering results long after the work is done.</p>
<p>My approach is AI-first. Search is changing fast, and buyers now find answers inside Google AI Overviews, ChatGPT, Gemini and Perplexity as well as classic search results. I help brands stay visible everywhere their customers look, while keeping a firm focus on long-term, sustainable growth.</p>

<h2>What I specialise in</h2>
<h3>Search Engine Optimization</h3>
<p>On-page, technical and off-page SEO that improves rankings and grows organic traffic. I work comfortably across WordPress, Shopify, Wix, Squarespace and custom platforms.</p>
<h3>AI Search Optimization and GEO</h3>
<p>Generative Engine Optimization that helps your brand get cited and recommended inside AI answers, so you win visibility on the platforms shaping the next decade of search.</p>
<h3>Google Ads</h3>
<p>High intent paid search campaigns that lower cost per lead and complement your organic growth, giving you qualified traffic while your SEO compounds.</p>

<h2>My experience</h2>
<p>Eight years of measurable growth across India, Dubai, the UK, the USA and Australia, covering technical SEO, on-page SEO, keyword research, link building, local SEO, eCommerce SEO, AI search optimization and Google Ads.</p>

<blockquote><p><strong>In one line:</strong> I help businesses generate qualified traffic, leads and sales by focusing on what truly drives performance, real ROI, not vanity rankings.</p></blockquote>';

	/* -------------------- SERVICES HUB -------------------- */
	$c['services'] = '
<h2>How the services work together</h2>
<p>Great results rarely come from a single tactic. A strong technical SEO foundation lets search engines crawl and index your site. On-page SEO then aligns your content with real search intent, while off-page SEO builds the authority that pushes those pages up the rankings.</p>
<p>Local SEO and eCommerce SEO tailor the strategy to how your customers actually search and buy. On top of that, AI search optimization makes sure your brand shows up inside the AI answers that more and more buyers now rely on, and Google Ads brings qualified traffic while your organic results compound.</p>
<blockquote><p><strong>Not sure where to start?</strong> Book a free consultation. I will review your website, your market and your goals, then recommend the exact mix of services that will bring the fastest, most sustainable return.</p></blockquote>';

	/* -------------------- SEO SERVICES -------------------- */
	$c['seo-services'] = '
<p>Search is where your customers start. Whether they type a query into Google or ask an AI assistant, your business needs to show up with a helpful answer at the exact moment they are ready to act. My SEO services are built to make that happen, then to keep it happening month after month.</p>
<blockquote><p><strong>What you get in one line:</strong> A complete SEO strategy covering technical SEO, on-page SEO, content and link building, backed by keyword research and AI search optimization, focused on measurable business growth.</p></blockquote>

<h2>What is included in my SEO services</h2>
<p>Every engagement is tailored to your website, your market and your goals. A typical SEO program brings the following pieces together into one clear roadmap.</p>
<h3>Keyword research and search intent mapping</h3>
<p>I start with deep keyword research to find the terms your customers actually use, then map each keyword to the right page and the right stage of the buying journey. This makes sure we target searches that bring qualified traffic and revenue, not just impressions.</p>
<h3>Technical SEO</h3>
<p>I make your website easy for search engines to crawl, render and index. That covers site speed and Core Web Vitals, mobile usability, crawl budget, structured data, canonical tags, XML sitemaps and a clean site architecture that spreads authority to the pages that matter.</p>
<h3>On-page SEO and content</h3>
<p>I optimize titles, meta descriptions, headings and body content around each target keyword, and I create content that genuinely helps readers. Clear H1, H2, H3 and H4 structure, natural keyword use and strong internal links help both people and search engines understand every page.</p>
<h3>Off-page SEO and link building</h3>
<p>I build authority with high quality, relevant backlinks using white hat outreach and digital PR. Trust and authority are what push competitive keywords onto page one and keep them there.</p>
<h3>AI search optimization</h3>
<p>Buyers now find answers inside Google AI Overviews, ChatGPT, Gemini and Perplexity. I optimize your content and structured data so your brand gets cited and recommended in those AI answers, giving you visibility your competitors are missing.</p>

<h2>Platforms I work with</h2>
<p>I deliver SEO across every major platform, so you get the same results whether you run a blog, a store or a custom build. This includes WordPress SEO, Shopify and WooCommerce SEO, Wix SEO, Squarespace SEO and custom or headless websites.</p>

<h2>My SEO process</h2>
<h3>1. Audit and research</h3>
<p>I review your technical health, content and backlinks, study your competitors and build your keyword map.</p>
<h3>2. Strategy and roadmap</h3>
<p>You get a prioritised plan that ties every keyword to an SEO friendly URL and a clear content brief.</p>
<h3>3. Optimize and build</h3>
<p>I execute the technical fixes, on-page work, content and link building, plus AI search optimization.</p>
<h3>4. Measure and scale</h3>
<p>I track rankings, traffic and leads, report transparently, then double down on what drives the most ROI.</p>

<h2>Frequently asked questions about SEO services</h2>
<h3>How long does SEO take to show results?</h3>
<p>Most websites start to see meaningful movement in rankings and organic traffic within three to six months, with compounding growth after that. Timelines depend on your competition, your current authority and how quickly changes are implemented.</p>
<h3>Do you use white hat SEO methods?</h3>
<p>Yes. Every strategy uses proven white hat methods that follow search engine guidelines. This protects your website from penalties and builds authority that lasts.</p>
<h3>Which platforms do you support?</h3>
<p>I work across WordPress, Shopify, WooCommerce, Wix, Squarespace and custom built websites, so the strategy fits whatever technology you use.</p>
<h3>Do you also optimize for AI search and ChatGPT?</h3>
<p>Yes. Alongside traditional SEO I offer AI search optimization, also called Generative Engine Optimization, so your brand appears inside answers on Google AI Overviews, ChatGPT, Gemini and Perplexity.</p>';

	/* -------------------- TECHNICAL SEO -------------------- */
	$c['technical-seo-services'] = '
<p>Technical SEO is the work that makes your website easy for Google and AI search engines to understand. When the foundation is solid, your content ranks faster, your pages load quickly and your visitors get a smooth experience that turns into leads and sales.</p>
<blockquote><p><strong>Quick answer:</strong> Technical SEO improves crawlability, indexing, site speed, Core Web Vitals, mobile usability and structured data, so search engines can rank your website with confidence.</p></blockquote>

<h2>What my technical SEO services cover</h2>
<h3>Crawlability and indexing</h3>
<p>I make sure search engines can reach every important page and skip the ones that waste crawl budget. This includes fixing broken links, redirect chains, orphan pages, robots.txt rules, canonical tags and your XML sitemap.</p>
<h3>Site speed and Core Web Vitals</h3>
<p>Speed is a ranking factor and a conversion factor. I improve Largest Contentful Paint, Interaction to Next Paint and Cumulative Layout Shift through image optimization, caching, code cleanup and better hosting recommendations.</p>
<h4>Common speed fixes I implement</h4>
<ul>
<li>Compress and lazy load images, and serve modern formats</li>
<li>Minify and defer render blocking CSS and JavaScript</li>
<li>Enable caching and a content delivery network</li>
<li>Reduce unused code and third party scripts</li>
</ul>
<h3>Mobile usability</h3>
<p>With mobile-first indexing, Google evaluates the mobile version of your site first. I make sure your pages are fully responsive, easy to tap and free of layout issues on every screen size.</p>
<h3>Structured data and schema markup</h3>
<p>I add schema markup so search engines and AI answer engines understand your content. This can earn rich results such as FAQs, reviews and breadcrumbs, and it helps your brand get cited in AI generated answers.</p>
<h3>Site architecture and internal linking</h3>
<p>A clean, logical structure spreads authority to your most important pages and helps users find what they need. I plan SEO friendly URLs, a sensible hierarchy and internal links that support your priority keywords.</p>

<h2>Technical SEO FAQs</h2>
<h3>What is technical SEO?</h3>
<p>Technical SEO is the practice of optimizing your website so search engines can crawl, render and index it efficiently. It covers site speed, Core Web Vitals, mobile usability, structured data, crawlability and site architecture.</p>
<h3>How is technical SEO different from on-page SEO?</h3>
<p>Technical SEO focuses on the foundation that lets search engines access and understand your site. On-page SEO focuses on the content and keywords on each page. Both are needed for strong rankings.</p>
<h3>Do you provide a technical SEO audit?</h3>
<p>Yes. Every technical SEO engagement starts with a full audit that identifies crawl issues, speed problems, indexing gaps and structured data opportunities, with a prioritised list of fixes.</p>';

	/* -------------------- ON-PAGE SEO -------------------- */
	$c['on-page-seo-services'] = '
<p>On-page SEO is everything you can optimize on a page itself to help it rank and convert. Done well, it connects your content to what people are really searching for, then guides them toward taking action.</p>
<blockquote><p><strong>Quick answer:</strong> On-page SEO covers keyword targeting, content quality, title tags, meta descriptions, header structure, internal linking and user experience, all aligned with search intent.</p></blockquote>

<h2>What my on-page SEO services include</h2>
<h3>Keyword targeting and search intent</h3>
<p>I map a primary keyword and supporting terms to every page, then match the content format to the intent behind the search, whether the visitor wants to learn, compare or buy.</p>
<h3>Content optimization that readers love</h3>
<p>Search engines reward content that genuinely helps people. I create and refine content that is clear, useful and easy to read, uses your keywords naturally, and gives visitors a reason to trust your business.</p>
<h4>Heading structure done right</h4>
<p>Every page uses a clean, logical heading hierarchy. A single H1 states the topic, H2 tags break the page into sections, and H3 and H4 tags organise the details. This helps readers scan and helps search engines understand your content.</p>
<h3>Title tags and meta descriptions</h3>
<p>I write compelling, keyword focused title tags and meta descriptions that improve click through rate from search results, so more of your rankings turn into actual visits.</p>
<h3>Internal linking</h3>
<p>Smart internal links pass authority to your priority pages and keep visitors moving through your site. I build a linking structure that supports your most valuable keywords and improves the user journey.</p>
<h3>Images, media and accessibility</h3>
<p>I optimize image file names, alt text and sizes so pages load fast, rank in image search and stay accessible to every visitor.</p>

<h2>On-page SEO FAQs</h2>
<h3>What is on-page SEO?</h3>
<p>On-page SEO is the process of optimizing the content and HTML elements of a page, such as keywords, headings, title tags, meta descriptions and internal links, so it ranks higher and serves the searcher better.</p>
<h3>Why are H1 to H4 headings important?</h3>
<p>Headings give your page a clear structure. A single H1 defines the topic while H2, H3 and H4 tags organise the sections and details. This helps readers scan the page and helps search engines understand it.</p>
<h3>Do you write the content or optimize existing pages?</h3>
<p>Both. I can create new SEO content from scratch or optimize your existing pages, depending on what will bring the fastest results for your goals.</p>';

	/* -------------------- OFF-PAGE SEO -------------------- */
	$c['off-page-seo-link-building'] = '
<p>Off-page SEO is everything that happens away from your website to build its reputation. The most important part is link building, because search engines treat quality backlinks as votes of confidence in your brand.</p>
<blockquote><p><strong>Quick answer:</strong> Off-page SEO builds your site authority through high quality backlinks, brand mentions and digital PR, all earned with white hat outreach that protects your website long term.</p></blockquote>

<h2>What my off-page SEO services include</h2>
<h3>White hat link building</h3>
<p>I earn links from relevant, trusted websites through genuine outreach, guest content and digital PR. Quality always comes before quantity, because a handful of strong, relevant links outperform hundreds of weak ones.</p>
<h4>Link building methods I use</h4>
<ul>
<li>Editorial links from relevant industry websites</li>
<li>Guest articles that add real value for readers</li>
<li>Digital PR and data driven content that earns coverage</li>
<li>Niche directories and trusted business listings</li>
<li>Reclaiming lost links and fixing broken backlinks</li>
</ul>
<h3>Brand mentions and authority signals</h3>
<p>Search engines and AI answer engines notice when your brand is talked about across the web. I help you build mentions, citations and a consistent presence that reinforces your expertise and trust.</p>
<h3>Backlink audit and cleanup</h3>
<p>If your site has picked up spammy or toxic links, I audit your profile and disavow anything harmful, so your authority is built on a clean, healthy foundation.</p>
<h3>Anchor text strategy</h3>
<p>I keep your anchor text natural and varied, which looks organic to search engines and avoids the patterns that trigger penalties.</p>

<h2>Off-page SEO FAQs</h2>
<h3>What is off-page SEO?</h3>
<p>Off-page SEO covers the activities outside your website that build its authority and reputation, mainly high quality backlinks, brand mentions and digital PR.</p>
<h3>Are your backlinks safe and white hat?</h3>
<p>Yes. I only build links through genuine, white hat outreach on relevant, trusted websites. This keeps your site safe from penalties and builds authority that lasts.</p>
<h3>How many backlinks do I need?</h3>
<p>There is no magic number. A few strong, relevant links from trusted sites are worth far more than a large volume of low quality links. The right amount depends on your competition.</p>';

	/* -------------------- LOCAL SEO -------------------- */
	$c['local-seo-services'] = '
<p>Local SEO helps your business show up when nearby customers search for what you offer. It is one of the highest return marketing channels for any business that serves a city, region or service area.</p>
<blockquote><p><strong>Quick answer:</strong> Local SEO optimizes your Google Business Profile, local keywords, citations and reviews so you rank in the map pack and local search results for nearby, ready to buy customers.</p></blockquote>

<h2>What my local SEO services include</h2>
<h3>Google Business Profile optimization</h3>
<p>Your Google Business Profile is the heart of local SEO. I optimize your categories, services, description, photos and posts, and set up the signals Google uses to rank you in the local map pack.</p>
<h3>Local keyword research</h3>
<p>I target the exact phrases your local customers use, including service plus location searches and near me queries, then map them to the right pages on your site.</p>
<h3>Local landing pages</h3>
<p>For businesses serving multiple areas, I build SEO friendly location pages with genuine, helpful content for each city or service area, structured with clear H1, H2, H3 and H4 headings.</p>
<h3>Citations and NAP consistency</h3>
<p>I make sure your name, address and phone number are accurate and consistent across directories and listings, which builds trust with search engines and customers.</p>
<h3>Reviews and reputation</h3>
<p>Reviews influence both rankings and buying decisions. I help you build a steady flow of genuine reviews and a simple process to respond to them.</p>

<h2>Local SEO FAQs</h2>
<h3>What is local SEO?</h3>
<p>Local SEO is the practice of optimizing your online presence to attract customers from local searches. It focuses on your Google Business Profile, local keywords, citations and reviews so you rank in the map pack and nearby results.</p>
<h3>How do I rank in the Google map pack?</h3>
<p>Ranking in the map pack depends on relevance, distance and prominence. That means a fully optimized Google Business Profile, consistent citations, local content and genuine reviews, which are all part of my local SEO service.</p>
<h3>Can you help a business with multiple locations?</h3>
<p>Yes. I build a scalable local SEO strategy with optimized profiles and dedicated location pages for each area you serve.</p>';

	/* -------------------- ECOMMERCE SEO -------------------- */
	$c['ecommerce-seo-services'] = '
<p>eCommerce SEO is the art of getting your products in front of shoppers at the exact moment they are ready to buy. It combines technical SEO, keyword strategy and content built specifically for online stores.</p>
<blockquote><p><strong>Quick answer:</strong> eCommerce SEO optimizes product pages, category pages, site structure and technical health so your store ranks for high intent shopping keywords and grows organic sales.</p></blockquote>

<h2>What my eCommerce SEO services include</h2>
<h3>Product page optimization</h3>
<p>I optimize product titles, descriptions, images and structured data so each product ranks for the keywords real shoppers use, and so it earns rich results such as price and review stars.</p>
<h3>Category page SEO</h3>
<p>Category pages often bring the most valuable traffic. I optimize them with helpful content, clear headings and internal links, turning them into powerful landing pages for competitive shopping searches.</p>
<h3>Keyword research for shopping intent</h3>
<p>I target commercial and transactional keywords, the searches that signal a shopper is ready to buy, and map them to the right products and categories.</p>
<h3>Technical eCommerce SEO</h3>
<p>Stores face unique technical challenges. I handle faceted navigation, duplicate content from filters and variants, pagination, canonical tags, site speed and a clean URL structure.</p>
<h4>Platforms I support</h4>
<ul>
<li>Shopify SEO for fast growing direct to consumer brands</li>
<li>WooCommerce SEO for WordPress powered stores</li>
<li>Magento, BigCommerce and custom eCommerce builds</li>
</ul>
<h3>Content and buying guides</h3>
<p>I create helpful buying guides and blog content that capture shoppers earlier in their journey and build topical authority around your products.</p>

<h2>eCommerce SEO FAQs</h2>
<h3>What is eCommerce SEO?</h3>
<p>eCommerce SEO is the process of optimizing an online store so its product and category pages rank higher in search results for shopping keywords, bringing more qualified traffic and sales.</p>
<h3>Do you optimize Shopify stores?</h3>
<p>Yes. I provide Shopify SEO as well as WooCommerce SEO and support for other platforms, handling both the technical setup and the content that drives rankings.</p>
<h3>How do you handle duplicate content from product filters?</h3>
<p>I use canonical tags, smart indexing rules and a clean URL strategy to manage faceted navigation and variants, so filters do not create duplicate content that dilutes your rankings.</p>';

	/* -------------------- AI SEARCH OPTIMIZATION -------------------- */
	$c['ai-search-optimization'] = '
<p>Search has changed. Instead of only clicking blue links, people now read complete answers generated by AI. Generative Engine Optimization, also called GEO, is the practice of making your brand the source those AI answers trust and cite.</p>
<blockquote><p><strong>Quick answer:</strong> AI search optimization, or GEO, structures and strengthens your content so AI answer engines such as Google AI Overviews, ChatGPT, Gemini and Perplexity mention and recommend your brand.</p></blockquote>

<h2>Why AI search optimization matters now</h2>
<p>AI answer engines are becoming the first stop for research and buying decisions. If your brand is missing from those answers, you lose visibility before the customer ever reaches a search results page. Getting in early gives you an advantage that compounds as adoption grows.</p>

<h2>What my AI search optimization services include</h2>
<h3>Answer ready content structure</h3>
<p>AI engines favour content that answers questions clearly and directly. I structure your pages with clear headings, concise answers and a logical H1 to H4 hierarchy that both readers and language models can parse.</p>
<h3>Generative AI optimized copy</h3>
<p>I write content that is natural and genuinely useful for people, while including the facts, definitions and context that AI models look for when they choose which sources to cite.</p>
<h4>Techniques I use</h4>
<ul>
<li>Clear question and answer formatting for common queries</li>
<li>Concise, factual statements that are easy to quote</li>
<li>Entities, definitions and context that build topical authority</li>
<li>Structured data and schema markup for machine readability</li>
<li>Strong brand mentions and citations across the web</li>
</ul>
<h3>Structured data and entity SEO</h3>
<p>I use schema markup and consistent entity signals so AI engines understand exactly who you are, what you offer and why you are a trustworthy source.</p>
<h3>Authority and trust signals</h3>
<p>AI models weigh reputation heavily. I strengthen the mentions, reviews and external signals that tell these engines your brand is credible and worth recommending.</p>

<h2>SEO, GEO and AEO working together</h2>
<p>AI search optimization does not replace SEO, it extends it. Traditional SEO earns rankings, GEO earns citations inside AI answers, and Answer Engine Optimization, or AEO, wins featured snippets and voice results. I combine all three into one strategy that keeps you visible everywhere your customers search.</p>

<h2>AI search optimization FAQs</h2>
<h3>What is AI search optimization?</h3>
<p>AI search optimization, also known as Generative Engine Optimization or GEO, is the practice of optimizing your content and structured data so AI answer engines such as Google AI Overviews, ChatGPT, Gemini and Perplexity cite and recommend your brand.</p>
<h3>How is GEO different from SEO?</h3>
<p>SEO focuses on ranking in traditional search results, while GEO focuses on being mentioned inside AI generated answers. The two work together, and a strong SEO foundation makes GEO more effective.</p>
<h3>Can you get my brand mentioned in ChatGPT and Google AI Overviews?</h3>
<p>I optimize your content, structure and authority signals to maximise the chance of being cited in AI answers. AI engines are constantly evolving, so I focus on the durable factors that consistently influence which sources they trust.</p>';

	/* -------------------- GOOGLE ADS -------------------- */
	$c['google-ads-management'] = '
<p>Google Ads puts your business at the top of search results for the keywords that matter most. Done right, it is one of the fastest ways to generate leads and sales, and it pairs perfectly with a long term SEO strategy.</p>
<blockquote><p><strong>Quick answer:</strong> Google Ads management covers keyword research, campaign structure, ad copy, bidding and conversion tracking, all optimized to lower your cost per lead and grow qualified conversions.</p></blockquote>

<h2>What my Google Ads services include</h2>
<h3>Campaign strategy and structure</h3>
<p>I build a clean account structure with tightly themed ad groups, so every search sees a highly relevant ad. This improves Quality Score, which lowers your cost per click and stretches your budget further.</p>
<h3>Keyword research and match types</h3>
<p>I target high intent keywords and use match types and negative keywords carefully, so your budget goes to searches from real buyers instead of wasted clicks.</p>
<h3>Ad copy and extensions</h3>
<p>I write responsive search ads that speak to your customer and stand out in the results, supported by extensions that add trust, links and information.</p>
<h4>Campaign types I manage</h4>
<ul>
<li>Search campaigns for high intent keywords</li>
<li>Performance Max for broad reach across Google</li>
<li>Display and remarketing to bring visitors back</li>
<li>Local campaigns to drive calls and store visits</li>
</ul>
<h3>Conversion tracking and optimization</h3>
<p>I set up accurate conversion tracking, then optimize bids, budgets and targeting based on real performance data. You always know what each lead and sale actually costs.</p>
<h3>Landing page alignment</h3>
<p>Great ads need great landing pages. I make sure your ads point to pages that match the search and are built to convert, so more of your clicks turn into customers.</p>

<h2>Google Ads FAQs</h2>
<h3>How much should I spend on Google Ads?</h3>
<p>Your budget depends on your industry, your goals and the cost per click in your market. I help you start at a sensible level, prove the return, then scale spend as the campaigns deliver profitable leads.</p>
<h3>How do you lower cost per lead?</h3>
<p>I improve Quality Score through tight campaign structure and relevant ads, cut wasted spend with negative keywords, and continuously optimize bids and targeting based on conversion data.</p>
<h3>Should I run Google Ads and SEO at the same time?</h3>
<p>Yes. Google Ads brings qualified traffic right away while SEO builds lasting organic visibility. Together they cover more of the search results and generate more total leads.</p>';

	return isset( $c[ $slug ] ) ? trim( $c[ $slug ] ) : '';
}
