<?php
/**
 * Front page (homepage) — premium international SEO agency layout.
 *
 * @package Avdesh_SEO
 */

get_header();

$audit   = home_url( '/book-free-seo-audit/' );
$cases   = home_url( '/case-studies/' );
$contact = home_url( '/contact/' );
$expertise = array( 'SEO', 'AI Search Optimization', 'GEO', 'Technical SEO', 'Local SEO', 'eCommerce SEO', 'International SEO', 'Google Ads' );
?>

<!-- ===================== HERO ===================== -->
<section class="hero">
	<div class="container">
		<div class="hero-grid">
			<div class="hero-copy reveal">
				<span class="rating-badge"><span class="stars">★★★★★</span> Trusted by 500+ businesses worldwide</span>
				<h1>I help brands <span class="gradient-text">rank higher</span> and grow revenue with SEO &amp; AI Search</h1>
				<p class="role">I'm <strong>Avdesh Kumar</strong>, a freelance SEO, AI Search Optimization (AISO), GEO &amp; Google Ads consultant in Delhi, India, with 8+ years turning organic visibility into qualified leads and measurable revenue.</p>
				<div class="hero-badges">
					<?php foreach ( $expertise as $e ) : ?>
						<span class="pill"><span class="pd"></span> <?php echo esc_html( $e ); ?></span>
					<?php endforeach; ?>
				</div>
				<div class="hero-actions">
					<a class="btn btn-primary btn-lg" href="<?php echo esc_url( $audit ); ?>">Book a free SEO audit</a>
					<a class="btn btn-outline btn-lg" href="<?php echo esc_url( $cases ); ?>">View case studies</a>
				</div>
				<div class="hero-trust">
					<div class="avatars">
						<span class="av">A</span><span class="av">S</span><span class="av">M</span><span class="av">+</span>
					</div>
					<span>Ethical, white-hat SEO for clients across India, USA, UK, Canada, Australia, UAE &amp; Europe.</span>
				</div>
			</div>

			<div class="hero-media reveal">
				<div class="hero-photo">
					<?php avdesh_image_area( 'avdesh_img_hero', 'Upload your professional photo', '', 'Avdesh Kumar, freelance SEO & AI Search consultant in Delhi, India' ); ?>
				</div>
				<div class="metric-card m1"><div class="mc-ic gr">📈</div><div><b>+312%</b><span>Organic traffic</span></div></div>
				<div class="metric-card m2"><div class="mc-ic gp">🔑</div><div><b>250+</b><span>Keywords on page 1</span></div></div>
				<div class="metric-card m3"><div class="mc-ic gd">⭐</div><div><b>#1</b><span>Rankings delivered</span></div></div>
			</div>
		</div>

		<!-- Animated stat strip -->
		<div class="stat-strip reveal">
			<div class="stat"><b><span class="u" data-count="8" data-suffix="+">8+</span></b><span>Years of experience</span></div>
			<div class="stat"><b><span class="u" data-count="500" data-suffix="+">500+</span></b><span>Businesses helped</span></div>
			<div class="stat"><b><span class="u" data-count="250" data-suffix="+">250+</span></b><span>Keywords ranked #1</span></div>
			<div class="stat"><b><span class="u" data-count="10" data-suffix="+">10+</span></b><span>Countries served</span></div>
		</div>
	</div>
</section>

<!-- ===================== TRUST BAR ===================== -->
<section class="trust-bar">
	<div class="container">
		<p>Experience across every major platform &amp; industry</p>
		<div class="trust-logos">
			<?php foreach ( array( 'WordPress', 'Shopify', 'Wix', 'Squarespace', 'WooCommerce', 'SaaS', 'Local Business', 'eCommerce' ) as $t ) : ?>
				<div class="tl"><?php echo esc_html( $t ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ===================== SERVICES ===================== -->
<section class="section" id="services">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">What I do</span>
			<h2 class="sec-title">Full-funnel <span class="gradient-text">SEO &amp; AI search</span> services</h2>
			<p class="sec-sub">From technical foundations to AI search visibility, every service is engineered to turn organic reach into leads, sales and long-term revenue.</p>
		</div>
		<div class="grid grid-3" style="margin-top:40px;">
			<?php
			$home_services = array(
				'seo-services', 'ai-search-optimization', 'technical-seo-services',
				'local-seo-services', 'ecommerce-seo-services', 'international-seo-services',
				'google-ads-management', 'seo-audit-services', 'core-web-vitals-optimization',
			);
			foreach ( $home_services as $slug ) {
				avdesh_service_card( $slug );
			}
			?>
		</div>
		<div style="text-align:center;margin-top:40px;">
			<a class="btn btn-outline btn-lg" href="<?php echo esc_url( home_url( '/services/' ) ); ?>">See all 15 services →</a>
		</div>
	</div>
</section>

<!-- ===================== WHY HIRE ME ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="two-col" style="grid-template-columns:1fr 1fr;align-items:center;">
			<div class="reveal">
				<span class="eyebrow">Why hire me</span>
				<h2 class="sec-title">A results-driven partner, not just another freelancer</h2>
				<p class="lead" style="margin:12px 0 26px;">I focus on what truly moves the needle: qualified traffic, leads and revenue, using ethical white-hat methods that build durable, penalty-proof growth.</p>
				<div class="grid" style="gap:22px;">
					<div class="feat"><div class="fic">🎯</div><div><h4>Revenue over vanity metrics</h4><p>I optimize for leads and sales, not rankings that look good but don't convert.</p></div></div>
					<div class="feat"><div class="fic">🤖</div><div><h4>AI-first &amp; future-proof</h4><p>Your brand is optimized for Google and AI engines like ChatGPT, Gemini and Perplexity.</p></div></div>
					<div class="feat"><div class="fic">🛡️</div><div><h4>100% white-hat</h4><p>Sustainable strategies that protect your domain and keep rankings for the long term.</p></div></div>
					<div class="feat"><div class="fic">🌍</div><div><h4>Global &amp; multi-platform</h4><p>WordPress, Shopify, Wix, Squarespace and custom builds, for clients worldwide.</p></div></div>
				</div>
			</div>
			<div class="reveal">
				<div class="chart-card">
					<span class="badge-up">▲ +312% in 12 months</span>
					<h3 style="margin-top:14px;">Organic traffic growth</h3>
					<p class="csub">Representative client result, monthly organic sessions</p>
					<?php echo avdesh_traffic_chart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="chart-legend"><span><i style="background:#10B981;"></i> Organic sessions</span><span><i style="background:#E6E8F2;"></i> Baseline</span></div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ===================== PROCESS ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">How I work</span>
			<h2 class="sec-title">A proven SEO process</h2>
			<p class="sec-sub">A clear, transparent path from audit to measurable growth, with reporting at every step.</p>
		</div>
		<div class="grid grid-4 steps reveal" style="margin-top:40px;">
			<div class="step"><div class="snum">1</div><h3>Audit &amp; research</h3><p>Deep site audit and keyword research to find the fastest routes to growth.</p></div>
			<div class="step"><div class="snum">2</div><h3>Strategy</h3><p>A prioritized roadmap tied to your revenue goals and realistic timelines.</p></div>
			<div class="step"><div class="snum">3</div><h3>Execution</h3><p>On-page, technical, content and off-page work delivered in focused sprints.</p></div>
			<div class="step"><div class="snum">4</div><h3>Measure &amp; scale</h3><p>Track rankings, traffic and conversions, then scale what drives ROI.</p></div>
		</div>
	</div>
</section>

<!-- ===================== RESULTS (dark) ===================== -->
<section class="section section--dark">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Proven results</span>
			<h2 class="sec-title" style="color:#fff;">Real growth, measurable outcomes</h2>
			<p class="sec-sub" style="color:#AEB6DA;">Representative results from SEO, GEO and paid campaigns. Replace the graphs and numbers with your own Search Console and Analytics screenshots.</p>
		</div>

		<div class="grid grid-4 reveal" style="margin-top:40px;">
			<div class="result-tile"><b data-count="312" data-prefix="+" data-suffix="%">+312%</b><span>Organic traffic growth</span></div>
			<div class="result-tile"><b data-count="250" data-suffix="+">250+</b><span>Keywords on page one</span></div>
			<div class="result-tile"><b data-count="68" data-suffix="%">68%</b><span>More qualified leads</span></div>
			<div class="result-tile"><b data-count="40" data-suffix="%">40%</b><span>Lower cost per lead</span></div>
		</div>

		<div class="grid grid-2 reveal" style="margin-top:26px;">
			<div class="chart-card">
				<span class="badge-up">▲ Rankings improved</span>
				<h3 style="margin-top:14px;">Before &amp; after rankings</h3>
				<p class="csub">Average keyword position, before vs after</p>
				<div style="margin-top:16px;"><?php echo avdesh_ranking_chart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<div class="chart-legend"><span><i style="background:#C7CAF0;"></i> Before</span><span><i style="background:linear-gradient(90deg,#4F46E5,#10B981);"></i> After</span></div>
			</div>
			<div class="chart-card" style="display:flex;flex-direction:column;">
				<h3>Search Console &amp; Analytics</h3>
				<p class="csub">Upload your real growth screenshots here</p>
				<div class="img-ph" style="flex:1;min-height:200px;margin-top:6px;"><span class="badge">📊 GSC clicks &amp; impressions screenshot</span></div>
			</div>
		</div>
		<div style="text-align:center;margin-top:36px;">
			<a class="btn btn-light btn-lg" href="<?php echo esc_url( home_url( '/seo-results/' ) ); ?>">See detailed SEO results →</a>
		</div>
	</div>
</section>

<!-- ===================== INDUSTRIES ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Industries served</span>
			<h2 class="sec-title">Experience across industries</h2>
			<p class="sec-sub">I've helped businesses of every size and sector grow through search.</p>
		</div>
		<div class="grid grid-4 reveal" style="margin-top:40px;">
			<?php
			$industries = array(
				array( '🛒', 'eCommerce & Retail' ), array( '💻', 'SaaS & Tech' ),
				array( '🏥', 'Healthcare' ), array( '🏘️', 'Real Estate' ),
				array( '⚖️', 'Legal & Finance' ), array( '🏨', 'Travel & Hospitality' ),
				array( '🎓', 'Education' ), array( '🔧', 'Local Services' ),
			);
			foreach ( $industries as $ind ) : ?>
				<div class="ind-card"><div class="ii"><?php echo esc_html( $ind[0] ); ?></div><h4><?php echo esc_html( $ind[1] ); ?></h4></div>
			<?php endforeach; ?>
		</div>
		<div style="text-align:center;margin-top:32px;">
			<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/industries/' ) ); ?>">Explore industries →</a>
		</div>
	</div>
</section>

<!-- ===================== TOOLS ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Tools &amp; tech</span>
			<h2 class="sec-title">The stack I use every day</h2>
			<p class="sec-sub">Enterprise-grade SEO, analytics and AI tools to plan, execute and measure growth.</p>
		</div>
		<div class="reveal" style="display:flex;flex-wrap:wrap;gap:14px;justify-content:center;margin-top:36px;">
			<?php foreach ( array( 'Google Search Console', 'Google Analytics 4', 'Ahrefs', 'SEMrush', 'Screaming Frog', 'Google Ads', 'Looker Studio', 'ChatGPT', 'Claude', 'AI SEO tools' ) as $tool ) : ?>
				<div class="tool-pill"><span class="tdot"></span> <?php echo esc_html( $tool ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Testimonials</span>
			<h2 class="sec-title">What clients say</h2>
			<p class="sec-sub">Replace these with your real client testimonials and results.</p>
		</div>
		<div class="grid grid-3 reveal" style="margin-top:40px;">
			<?php
			$tst = array(
				array( 'Avdesh transformed our organic traffic. We went from page three to the top three for our main keywords in under six months, and leads followed.', 'S. Mehta', 'Founder, SaaS Startup', 'S' ),
				array( 'Professional, transparent and genuinely results-focused. Our eCommerce revenue from organic search more than doubled.', 'A. Khan', 'Director, eCommerce Brand', 'A' ),
				array( 'The AI search work put us ahead of competitors. We now show up in AI answers where our rivals don\'t. Highly recommended.', 'M. Sharma', 'Marketing Lead, Agency', 'M' ),
			);
			foreach ( $tst as $t ) : ?>
				<div class="tcard">
					<div class="stars">★★★★★</div>
					<blockquote>"<?php echo esc_html( $t[0] ); ?>"</blockquote>
					<div class="who"><span class="av"><?php echo esc_html( $t[3] ); ?></span><div><b><?php echo esc_html( $t[1] ); ?></b><span><?php echo esc_html( $t[2] ); ?></span></div></div>
				</div>
			<?php endforeach; ?>
		</div>
		<div style="text-align:center;margin-top:32px;"><a class="btn btn-outline" href="<?php echo esc_url( home_url( '/testimonials/' ) ); ?>">Read more testimonials →</a></div>
	</div>
</section>

<!-- ===================== CASE STUDIES ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Case studies</span>
			<h2 class="sec-title">Selected client wins</h2>
			<p class="sec-sub">Strategy, execution and measurable growth. Replace with your own projects.</p>
		</div>
		<div class="grid grid-3 reveal" style="margin-top:40px;">
			<?php
			$cs = array(
				array( 'SaaS Organic Growth', 'SaaS / SEO', array( '+312% traffic', '250+ keywords' ) ),
				array( 'eCommerce SEO Scale', 'Shopify / eCommerce', array( '+150% revenue', '2.4x ROAS' ) ),
				array( 'Local SEO Domination', 'Local / GBP', array( 'Map pack #1', '5x calls' ) ),
			);
			foreach ( $cs as $c ) : ?>
				<article class="cs-card">
					<div class="cs-top"><div class="img-ph" style="min-height:180px;border-radius:0;border:0;"><span class="badge">📷 Project image</span></div><span class="cs-tag"><?php echo esc_html( $c[1] ); ?></span></div>
					<div class="cs-body">
						<h3><?php echo esc_html( $c[0] ); ?></h3>
						<p>A short summary of the challenge, strategy and outcome for this project.</p>
						<div class="cs-metrics"><?php foreach ( $c[2] as $m ) : ?><span><?php echo esc_html( $m ); ?></span><?php endforeach; ?></div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<div style="text-align:center;margin-top:36px;"><a class="btn btn-primary btn-lg" href="<?php echo esc_url( $cases ); ?>">View all case studies →</a></div>
	</div>
</section>

<!-- ===================== CERTIFICATIONS ===================== -->
<section class="section">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Certifications</span>
			<h2 class="sec-title">Qualified &amp; always learning</h2>
			<p class="sec-sub">Continuous learning keeps my strategies current with every algorithm and AI update. Replace with your badges.</p>
		</div>
		<div class="grid grid-4 reveal" style="margin-top:36px;">
			<?php foreach ( array( 'Google Analytics', 'Google Ads', 'SEO Certification', 'Content Marketing' ) as $cert ) : ?>
				<div class="tl" style="min-height:80px;"><?php echo esc_html( $cert ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">FAQ</span>
			<h2 class="sec-title">Common questions</h2>
		</div>
		<div class="faq reveal" style="margin-top:36px;">
			<details open><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">What makes your SEO approach different?</h3></summary><p>I take an AI-first, revenue-focused approach. Your content is optimized to rank on Google and to be cited by AI answer engines like ChatGPT, Gemini and Perplexity. Everything is white-hat and measured on leads and sales, not vanity rankings.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">Which platforms and countries do you work with?</h3></summary><p>WordPress, Shopify, Wix, Squarespace, WooCommerce and custom builds, for clients across India, USA, UK, Canada, Australia, UAE and Europe.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">How soon will I see results?</h3></summary><p>SEO usually shows early movement in 8 to 12 weeks and compounds from there. Google Ads can deliver leads within days. I recommend combining both for short and long-term growth.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">Do you offer a free consultation?</h3></summary><p>Yes. Book a free SEO audit and I'll show you exactly what's holding your rankings back and how to fix it, with no obligation.</p></details>
		</div>
		<div style="text-align:center;margin-top:28px;"><a class="btn btn-outline" href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>">See all FAQs →</a></div>
	</div>
</section>

<?php avdesh_cta_band(); ?>

<?php get_footer(); ?>
