<?php
/**
 * Template Name: About Page
 *
 * @package Avdesh_SEO
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>About</span></nav>
		<span class="eyebrow">About me</span>
		<h1>Avdesh Kumar, SEO &amp; AI Search Consultant</h1>
		<p>8+ years of professional experience helping 500+ businesses in India and worldwide grow organic traffic, leads and revenue with ethical, white-hat strategies.</p>
	</div>
</section>

<section class="section">
	<div class="container two-col" style="grid-template-columns:1fr .8fr;">
		<div class="prose reveal">
			<h2>My story</h2>
			<p>I'm Avdesh Kumar, a freelance SEO, AI Search Optimization (AISO), GEO and Google Ads consultant based in Delhi, India. Over the past 8+ years I've helped more than 500 businesses, from startups and local brands to eCommerce stores, SaaS companies and international agencies, turn search into a dependable source of leads and revenue.</p>
			<p>I specialise in on-page, technical and international SEO across platforms like WordPress, Shopify, Wix, Squarespace and custom builds. My work spans classic SEO, Generative Engine Optimization (GEO), AI search visibility and Google Ads, so clients can grow across organic and paid channels with one accountable partner.</p>
			<p>What sets my approach apart is that it's AI-first and revenue-focused. I help businesses stay visible across Google and modern LLM platforms such as ChatGPT, Gemini, Claude and Perplexity, while always optimizing for what truly matters: qualified traffic, leads and sales, not vanity rankings.</p>

			<div class="callout">Every project uses proven, 100% white-hat methods designed to grow visibility safely and sustainably, with full transparency and reporting.</div>

			<h2>What I specialise in</h2>
			<ul class="ticks">
				<li>Technical SEO, site speed and Core Web Vitals</li>
				<li>On-page SEO and reader-friendly, AI-optimized content</li>
				<li>AI Search Optimization (AISO) and Generative Engine Optimization (GEO)</li>
				<li>Local, eCommerce and International SEO</li>
				<li>White-hat link building and off-page authority</li>
				<li>Keyword research, content strategy and website migrations</li>
				<li>Google Ads management focused on ROI</li>
			</ul>

			<h2>Experience</h2>
			<div class="timeline" style="margin-top:18px;">
				<div class="tl-item"><span class="yr">2022 — Present</span><h4>Freelance SEO &amp; AI Search Consultant</h4><p>Leading SEO, GEO and paid search strategy for brands across India, the UAE, the UK, the USA, Canada, Australia and Europe.</p></div>
				<div class="tl-item"><span class="yr">2019 — 2022</span><h4>Senior SEO Consultant</h4><p>Delivered organic growth and technical SEO for competitive B2B, SaaS and eCommerce clients.</p></div>
				<div class="tl-item"><span class="yr">2017 — 2019</span><h4>SEO Specialist</h4><p>Built the foundations: keyword research, on-page optimization and content strategy.</p></div>
			</div>

			<h2>Certifications</h2>
			<p>Continuous learning across SEO, analytics, advertising and AI keeps my strategies current with every algorithm and platform update.</p>
			<div class="grid grid-3" style="margin-top:16px;">
				<div class="tl" style="min-height:70px;">Google Analytics</div>
				<div class="tl" style="min-height:70px;">Google Ads</div>
				<div class="tl" style="min-height:70px;">SEO &amp; Content</div>
			</div>
			<p style="margin-top:12px;font-size:.9rem;color:var(--muted);">Replace these with your own certification badges from the media library.</p>
		</div>

		<aside class="reveal">
			<div class="hero-photo" style="aspect-ratio:4/4.6;margin-bottom:24px;">
				<?php avdesh_image_area( 'avdesh_img_about2', 'Upload your photo', '', 'Avdesh Kumar, SEO consultant in Delhi' ); ?>
			</div>
			<div class="side-card grad">
				<h3>At a glance</h3>
				<ul style="display:grid;gap:11px;list-style:none;color:#C7CCE6;">
					<li>📍 Based in Delhi, India</li>
					<li>🌍 Serving clients worldwide</li>
					<li>⭐ 8+ years of experience</li>
					<li>🤝 500+ businesses helped</li>
					<li>🛡️ 100% white-hat methods</li>
					<li>🤖 AI-first search approach</li>
				</ul>
				<a class="btn btn-primary btn-block" style="margin-top:18px;" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>">Work with me</a>
			</div>
		</aside>
	</div>
</section>

<?php avdesh_cta_band( 'Let\'s grow your search visibility together', 'Whether you need SEO, AI search optimization, GEO or Google Ads, I\'ll build a strategy around your revenue goals.' ); ?>
<?php get_footer(); ?>
