<?php
/**
 * Front page (homepage) — portfolio-style layout.
 *
 * @package Avdesh_SEO
 */

get_header();

$tagline = avdesh_opt( 'avdesh_tagline', 'SEO & AI Search Optimization Specialist' );
$stats   = array(
	array( avdesh_opt( 'avdesh_stat1_n', '8+' ),  avdesh_opt( 'avdesh_stat1_l', 'Years Experience' ) ),
	array( avdesh_opt( 'avdesh_stat2_n', '250+' ), avdesh_opt( 'avdesh_stat2_l', 'Keywords Ranked #1' ) ),
	array( avdesh_opt( 'avdesh_stat3_n', '120+' ), avdesh_opt( 'avdesh_stat3_l', 'Projects Delivered' ) ),
	array( avdesh_opt( 'avdesh_stat4_n', '3X' ),   avdesh_opt( 'avdesh_stat4_l', 'Avg. Traffic Growth' ) ),
	array( avdesh_opt( 'avdesh_stat5_n', '6+' ),   avdesh_opt( 'avdesh_stat5_l', 'Countries Served' ) ),
);
?>

<!-- ===================== HERO ===================== -->
<section class="hero">
	<div class="container">
		<div class="hero-grid">
			<div class="hero-copy reveal">
				<span class="hello">Hello 👋</span>
				<h1>I'm Avdesh Kumar,<br>an <span class="hl">SEO &amp; AI Search</span> Specialist</h1>
				<p class="role"><?php echo esc_html( $tagline ); ?> in Delhi, India. I drive organic traffic, higher rankings and real ROI with proven white-hat methods across Google and modern AI platforms.</p>
				<div class="hero-actions">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Get a free consultation</a>
					<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/seo-services/' ) ); ?>">View services</a>
				</div>
			</div>

			<div class="hero-media reveal">
				<div class="hero-photo">
					<?php avdesh_image_area( 'avdesh_img_hero', 'Upload your portrait', '', 'Avdesh Kumar, SEO & AI Search Optimization Specialist in Delhi' ); ?>
				</div>
				<span class="float-tag t1"><span class="d"></span> SEO</span>
				<span class="float-tag t2"><span class="d"></span> AI Search / GEO</span>
				<span class="float-tag t3"><span class="d"></span> Google Ads</span>
			</div>
		</div>

		<!-- Stats bar -->
		<div class="stats-bar reveal">
			<?php foreach ( $stats as $st ) : ?>
				<div class="stat">
					<b><?php echo esc_html( $st[0] ); ?></b>
					<span><?php echo esc_html( $st[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ===================== TAG STRIP ===================== -->
<section style="padding:26px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:var(--cream-2);">
	<div class="container">
		<div class="tag-strip">
			<span>SEO</span><span class="sep">◆</span>
			<span>AI SEARCH OPTIMIZATION</span><span class="sep">◆</span>
			<span>GENERATIVE ENGINE OPTIMIZATION</span><span class="sep">◆</span>
			<span>TECHNICAL SEO</span><span class="sep">◆</span>
			<span>GOOGLE ADS</span><span class="sep">◆</span>
			<span>CONTENT STRATEGY</span>
		</div>
	</div>
</section>

<!-- ===================== ABOUT ===================== -->
<section class="section" id="about">
	<div class="container">
		<div class="two-col" style="grid-template-columns:.9fr 1.3fr;align-items:center;">
			<div class="reveal">
				<div class="hero-photo" style="aspect-ratio:4/4.2;">
					<?php avdesh_image_area( 'avdesh_img_about', 'Upload about photo', '', 'Avdesh Kumar SEO specialist at work' ); ?>
				</div>
			</div>
			<div class="reveal">
				<span class="eyebrow">About me</span>
				<h2 class="sec-title">about<span class="dot">.</span></h2>
				<p class="lead" style="margin-top:10px;">I'm Avdesh Kumar, an SEO and AI Search Optimization Specialist based in Delhi, India, with 8 years of hands-on experience in highly competitive markets.</p>
				<p>I specialise in on-page, technical and overall SEO strategy across platforms like WordPress, Shopify, Wix and Squarespace. I take an AI-first approach to search, helping businesses grow visibility on Google and modern LLM platforms such as ChatGPT, Gemini and Perplexity.</p>
				<p>My focus is simple: qualified traffic, leads and sales. I optimize for what truly drives performance and long-term revenue, not vanity rankings. Every project uses proven, white-hat methods built to last.</p>
				<div class="grid grid-2" style="margin-top:22px;gap:14px;">
					<div class="feat"><h4><span class="tick">✔</span> White-hat &amp; sustainable</h4></div>
					<div class="feat"><h4><span class="tick">✔</span> AI-first search strategy</h4></div>
					<div class="feat"><h4><span class="tick">✔</span> ROI over vanity metrics</h4></div>
					<div class="feat"><h4><span class="tick">✔</span> Works across all platforms</h4></div>
				</div>
				<p style="margin-top:24px;"><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">More about me →</a></p>
			</div>
		</div>
	</div>
</section>

<!-- ===================== WHAT I DO ===================== -->
<section class="section section--tint" id="services">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Services</span>
			<h2 class="sec-title">what i do<span class="dot">.</span></h2>
			<p class="sec-sub">Full-funnel search growth. From technical foundations to AI search visibility, every service is built to turn organic reach into revenue.</p>
		</div>
		<div class="grid grid-3" style="margin-top:36px;">
			<?php
			$home_services = array(
				'seo-services', 'ai-search-optimization', 'technical-seo-services',
				'on-page-seo-services', 'off-page-seo-link-building', 'local-seo-services',
			);
			$i = 1;
			foreach ( $home_services as $slug ) {
				avdesh_service_card( $slug, sprintf( '%02d', $i ) );
				$i++;
			}
			?>
		</div>
		<div style="text-align:center;margin-top:34px;">
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/seo-services/' ) ); ?>">See all services →</a>
		</div>
	</div>
</section>

<!-- ===================== PROCESS ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">How I work</span>
			<h2 class="sec-title">my process<span class="dot">.</span></h2>
			<p class="sec-sub">A clear, proven path from audit to measurable growth.</p>
		</div>
		<div class="grid grid-4 reveal" style="margin-top:36px;">
			<div class="step" style="padding-left:24px;padding-top:56px;"><h3>Audit &amp; research</h3><p>Deep keyword research and a full site audit to find the fastest routes to growth.</p></div>
			<div class="step" style="padding-left:24px;padding-top:56px;"><h3>Strategy</h3><p>A prioritized roadmap tied to your revenue goals and realistic timelines.</p></div>
			<div class="step" style="padding-left:24px;padding-top:56px;"><h3>Execution</h3><p>On-page, technical, content and off-page work delivered in focused sprints.</p></div>
			<div class="step" style="padding-left:24px;padding-top:56px;"><h3>Measure &amp; scale</h3><p>Track rankings, traffic and conversions, then scale what drives ROI.</p></div>
		</div>
	</div>
</section>

<!-- ===================== RESULTS ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Impact</span>
			<h2 class="sec-title">results that matter<span class="dot">.</span></h2>
			<p class="sec-sub">Representative outcomes from SEO, GEO and paid campaigns. Update these with your own figures.</p>
		</div>
		<div class="results reveal" style="margin-top:34px;">
			<div class="result"><b>3X</b><span>Organic traffic growth</span></div>
			<div class="result"><b>250+</b><span>Page-one keywords</span></div>
			<div class="result"><b>68%</b><span>More qualified leads</span></div>
			<div class="result"><b>40%</b><span>Lower cost per lead</span></div>
		</div>
	</div>
</section>

<!-- ===================== CASE STUDIES ===================== -->
<section class="section" id="case-studies">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Portfolio</span>
			<h2 class="sec-title">case studies<span class="dot">.</span></h2>
			<p class="sec-sub">Selected projects showcasing strategy, execution and measurable growth. Replace with your own case studies.</p>
		</div>
		<div class="case-grid reveal" style="margin-top:34px;">
			<?php
			$cases = array(
				array( 'Project One', 'SEO & Content' ),
				array( 'Project Two', 'Technical SEO' ),
				array( 'Project Three', 'Local SEO' ),
				array( 'Project Four', 'Google Ads' ),
			);
			foreach ( $cases as $c ) : ?>
				<div class="case">
					<div class="logo-ph"><?php echo esc_html( strtoupper( substr( $c[0], 0, 1 ) ) ); ?></div>
					<h4><?php echo esc_html( $c[0] ); ?></h4>
					<span><?php echo esc_html( $c[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<div style="text-align:center;margin-top:34px;">
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>">View full portfolio →</a>
		</div>
	</div>
</section>

<!-- ===================== TOOLS ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Toolkit</span>
			<h2 class="sec-title">tools &amp; platforms<span class="dot">.</span></h2>
			<p class="sec-sub">The stack I use to plan, execute and measure search growth.</p>
		</div>
		<div class="logo-grid reveal" style="margin-top:30px;">
			<?php foreach ( array( 'Google Search Console', 'GA4', 'Ahrefs', 'SEMrush', 'Screaming Frog', 'Google Ads', 'ChatGPT', 'Perplexity', 'WordPress', 'Shopify', 'Wix', 'Squarespace' ) as $tool ) : ?>
				<div class="logo-cell"><?php echo esc_html( $tool ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ===================== BRANDS ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Trusted by</span>
			<h2 class="sec-title">featured brands<span class="dot">.</span></h2>
			<p class="sec-sub">Brands and businesses I've helped grow. Replace these cells with client logos.</p>
		</div>
		<div class="logo-grid reveal" style="margin-top:30px;">
			<?php for ( $b = 1; $b <= 12; $b++ ) : ?>
				<div class="logo-cell">Logo <?php echo esc_html( $b ); ?></div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">FAQ</span>
			<h2 class="sec-title">common questions<span class="dot">.</span></h2>
		</div>
		<div class="faq reveal" style="margin-top:30px;">
			<details open><summary><h3 style="display:inline;font-size:1.02rem;margin:0;">What makes your SEO approach different?</h3></summary><p>I take an AI-first approach. Your content is optimized to rank on Google and to be cited by AI answer engines like ChatGPT, Gemini and Perplexity, so you stay visible as search behaviour changes. Everything is white-hat and focused on revenue, not vanity rankings.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;">Which platforms do you work with?</h3></summary><p>WordPress, Shopify, Wix, Squarespace, WooCommerce and custom builds. I adapt the technical work to each platform so your CMS never limits your rankings.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;">Do you work with international clients?</h3></summary><p>Yes. I'm based in Delhi, India, and work with clients across the UK, USA, UAE, Australia and beyond, remotely and reliably.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;">How soon will I see results?</h3></summary><p>SEO usually shows early movement in 8 to 12 weeks and compounds from there. Google Ads can deliver leads within days. I recommend combining both for short and long-term growth.</p></details>
		</div>
	</div>
</section>

<?php avdesh_cta_band(); ?>

<?php get_footer(); ?>
