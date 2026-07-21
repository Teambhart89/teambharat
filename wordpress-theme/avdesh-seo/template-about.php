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
		<h1>Avdesh Kumar, SEO &amp; AI Search Optimization Specialist</h1>
		<p class="lead">8 years of hands-on experience helping businesses in India and worldwide grow organic traffic, rankings and real revenue.</p>
	</div>
</section>

<section class="section">
	<div class="container two-col" style="grid-template-columns:1fr .8fr;">
		<div class="prose reveal">
			<h2>My story<span class="dot">.</span></h2>
			<p>I'm Avdesh Kumar, an SEO and AI Search Optimization Specialist based in Delhi, India. Over the past 8 years I've helped businesses in highly competitive markets turn search into a dependable source of leads and sales.</p>
			<p>I specialise in on-page, technical and overall SEO strategy across platforms like WordPress, Shopify, Wix and Squarespace. My work spans SEO, Generative Engine Optimization (GEO) and Google Ads, so clients can grow across organic and paid search with one accountable specialist.</p>
			<p>What sets my approach apart is that it's AI-first. I help businesses increase visibility across Google and modern LLM platforms such as ChatGPT, Gemini and Perplexity, with a strong emphasis on long-term, sustainable revenue growth. I focus on what truly drives performance, qualified traffic, leads and sales, not vanity rankings.</p>

			<div class="callout">Every project I take on uses proven, white-hat methods designed to grow visibility safely and sustainably.</div>

			<h2>What I specialise in<span class="dot">.</span></h2>
			<ul class="ticks">
				<li>Technical SEO, site speed and Core Web Vitals</li>
				<li>On-page SEO and reader-friendly content optimization</li>
				<li>AI Search Optimization and Generative Engine Optimization (GEO)</li>
				<li>White-hat link building and off-page authority</li>
				<li>Local SEO and Google Business Profile optimization</li>
				<li>Google Ads management focused on ROI</li>
			</ul>

			<h2>Experience<span class="dot">.</span></h2>
			<div class="timeline" style="margin-top:16px;">
				<div class="tl-item"><span class="yr">2022 — Present</span><h4>SEO &amp; AI Search Optimization Specialist</h4><p>Leading SEO, GEO and paid search strategy for brands across India, the UAE, the UK, the USA and Australia.</p></div>
				<div class="tl-item"><span class="yr">2019 — 2022</span><h4>Senior SEO Consultant</h4><p>Delivered organic growth and technical SEO for competitive B2B and e-commerce clients.</p></div>
				<div class="tl-item"><span class="yr">2017 — 2019</span><h4>SEO Executive</h4><p>Built the foundations: keyword research, on-page optimization and content strategy.</p></div>
			</div>

			<h2>Certifications<span class="dot">.</span></h2>
			<p>Continuous learning across SEO, analytics and advertising keeps my strategies current with every algorithm and AI update.</p>
			<div class="grid grid-3" style="margin-top:14px;">
				<div class="logo-cell">Google Analytics</div>
				<div class="logo-cell">Google Ads</div>
				<div class="logo-cell">SEO &amp; Content</div>
			</div>
			<p style="margin-top:12px;font-size:.9rem;color:var(--muted);">Replace these with your own certification badges from the Customizer or media library.</p>
		</div>

		<aside class="reveal">
			<div class="hero-photo" style="aspect-ratio:4/4.6;margin-bottom:22px;">
				<?php avdesh_image_area( 'avdesh_img_about2', 'Upload your photo', '', 'Avdesh Kumar, SEO specialist in Delhi' ); ?>
			</div>
			<div class="side-card" style="position:static;">
				<h3>At a glance</h3>
				<ul style="display:grid;gap:10px;">
					<li>📍 Based in Delhi, India</li>
					<li>🌍 Serving clients worldwide</li>
					<li>⭐ 8 years of experience</li>
					<li>✅ White-hat methods only</li>
					<li>🤖 AI-first search approach</li>
				</ul>
				<p style="margin-top:16px;"><a class="btn btn-primary" style="width:100%;justify-content:center;" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Work with me</a></p>
			</div>
		</aside>
	</div>
</section>

<?php avdesh_cta_band( 'Let\'s grow your search visibility together', 'Whether you need SEO, AI search optimization or Google Ads, I\'ll build a strategy around your revenue goals.' ); ?>
<?php get_footer(); ?>
