<?php
/**
 * Homepage template. Layout mirrors the reference portfolio design:
 * hero, stats, service ticker, about, services, approach, case studies,
 * tools, brands, testimonials and a closing call to action.
 *
 * @package Avdesh_SEO
 */
get_header();

$name          = avseo_info( 'name' );
$hero_tagline  = avseo_opt( 'home_hero_tagline', 'I help businesses grow organic traffic, improve rankings and generate qualified leads and sales with proven white hat SEO, GEO and Google Ads.' );
$home_id       = (int) get_option( 'page_on_front' );
$home_content  = $home_id ? apply_filters( 'the_content', get_post_field( 'post_content', $home_id ) ) : '';
?>

<!-- ============ HERO ============ -->
<section class="hero">
	<div class="container">
		<div class="hero-inner">
			<span class="hello-pill">Hello!</span>
			<h1>I'm <span class="name"><?php echo esc_html( $name ); ?></span> 👋</h1>
			<div class="hero-sub"><?php echo esc_html( avseo_info( 'role' ) ); ?></div>
			<p class="lead mx-auto" style="max-width:640px;">
				<?php echo esc_html( $hero_tagline ); ?>
			</p>

			<div class="hero-actions">
				<span class="hire-btn">
					<a class="portfolio" href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Portfolio <span class="arw">&#8599;</span></a>
					<a class="hireme" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Hire me</a>
				</span>
			</div>

			<div class="hero-photo-wrap">
				<span class="hero-tag t1"><span class="tdot">●</span>On-Page SEO</span>
				<span class="hero-tag t2"><span class="tdot">●</span>AI Search (GEO)</span>
				<span class="hero-tag t3"><span class="tdot">●</span>Technical SEO</span>
				<span class="hero-tag t4"><span class="tdot">●</span>Link Building</span>
				<span class="hero-tag t5"><span class="tdot">●</span>Local SEO</span>
				<span class="hero-tag t6"><span class="tdot">●</span>Google Ads</span>
				<div class="hero-years">
					<div class="big">8+ Years</div>
					<small>SEO &amp; Search Growth</small>
				</div>
				<div class="hero-photo">
					<div class="hero-photo-glow"></div>
					<?php avseo_image_slot( 'img_hero', 'Add your hero portrait', $name . ' - SEO Specialist', 'hero-slot', '800 x 900 px' ); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ============ STATS BAR ============ -->
<section class="stats-bar" style="padding:0;">
	<div class="stats-grid">
		<?php
		$icons = array( '📈', '⏱️', '🏆', '✅', '🌍' );
		for ( $i = 1; $i <= 5; $i++ ) :
			$num   = avseo_opt( 'stat_' . $i . '_num', '' );
			$label = avseo_opt( 'stat_' . $i . '_label', '' );
			?>
			<div class="stat">
				<span class="sicon"><?php echo esc_html( $icons[ $i - 1 ] ); ?></span>
				<span class="snum"><?php echo esc_html( $num ); ?></span>
				<span class="slabel"><?php echo esc_html( $label ); ?></span>
			</div>
		<?php endfor; ?>
	</div>
</section>

<!-- ============ SERVICE TICKER ============ -->
<div class="ticker" aria-hidden="true">
	<div class="ticker-track">
		<span class="ticker-item">SEO SERVICES <span class="sp">✦</span> TECHNICAL SEO <span class="sp">✦</span> ON-PAGE SEO <span class="sp">✦</span> LINK BUILDING <span class="sp">✦</span> LOCAL SEO <span class="sp">✦</span> AI SEARCH OPTIMIZATION <span class="sp">✦</span> GOOGLE ADS <span class="sp">✦</span></span>
	</div>
</div>

<!-- ============ ABOUT ============ -->
<section class="bg-cream" id="about">
	<div class="container">
		<div class="about-grid">
			<div>
				<h2 class="section-title">about<span class="dot">.</span></h2>
				<div class="entry-content">
					<?php
					// Editable from Pages > Home in the dashboard. Falls back to default copy if empty.
					if ( trim( wp_strip_all_tags( $home_content ) ) ) {
						echo wp_kses_post( $home_content );
					} else {
						echo '<p class="lead">Hi, I\'m ' . esc_html( $name ) . ', an SEO and AI Search Optimization Specialist based in Delhi, India with 8 years of hands-on experience across highly competitive markets.</p>';
					}
					?>
				</div>
				<div style="margin-top:8px;">
					<span class="chip">SEO Strategy</span>
					<span class="chip">Generative Engine Optimization</span>
					<span class="chip">Google Ads</span>
					<span class="chip">Content &amp; Keyword Research</span>
					<span class="chip">Analytics</span>
				</div>
				<div style="margin-top:22px;">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">More about me</a>
				</div>
			</div>
			<div>
				<?php avseo_image_slot( 'img_about', 'Add your about photo', $name . ' at work', 'about-photo', '700 x 800 px' ); ?>
			</div>
		</div>
	</div>
</section>

<!-- ============ WHAT I DO ============ -->
<section class="bg-white" id="services">
	<div class="container">
		<?php avseo_section_title( 'what i do', 'End to end SEO and search growth built around strategy, data and content that ranks and converts.' ); ?>
		<div class="cards-grid">
			<?php
			$services = array(
				array( '01', '🔍', 'SEO Services', 'A complete SEO strategy that grows organic traffic, rankings and revenue.', '/seo-services/' ),
				array( '02', '⚙️', 'Technical SEO', 'Fast, crawlable, indexable websites that pass Core Web Vitals.', '/technical-seo-services/' ),
				array( '03', '📝', 'On-Page SEO', 'Keyword mapped content, headings and metadata that rank and convert.', '/on-page-seo-services/' ),
				array( '04', '🔗', 'Off-Page SEO', 'White hat link building that grows authority and trust.', '/off-page-seo-link-building/' ),
				array( '05', '📍', 'Local SEO', 'Google Business Profile and map pack rankings that drive local leads.', '/local-seo-services/' ),
				array( '06', '🛒', 'eCommerce SEO', 'Product and category rankings that grow qualified traffic and sales.', '/ecommerce-seo-services/' ),
				array( '07', '🤖', 'AI Search Optimization', 'Visibility inside AI Overviews, ChatGPT, Gemini and Perplexity.', '/ai-search-optimization/' ),
				array( '08', '🎯', 'Google Ads', 'High intent search campaigns with a lower cost per lead.', '/google-ads-management/' ),
			);
			foreach ( $services as $s ) : ?>
				<div class="svc-card">
					<div class="card-top">
						<span class="num"><?php echo esc_html( $s[0] ); ?></span>
						<span class="card-ico"><?php echo esc_html( $s[1] ); ?></span>
					</div>
					<h3><?php echo esc_html( $s[2] ); ?></h3>
					<p><?php echo esc_html( $s[3] ); ?></p>
					<a class="card-link" href="<?php echo esc_url( home_url( $s[4] ) ); ?>">Learn more &rarr;</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ APPROACH / PROCESS ============ -->
<section class="bg-cream">
	<div class="container">
		<div class="two-col">
			<div>
				<h2 class="section-title">my approach<span class="dot">.</span></h2>
				<p class="section-intro" style="margin-bottom:24px;">A clear, repeatable process that turns search visibility into revenue.<span class="rule"></span></p>
				<div class="panel">
					<ul class="timeline">
						<li>
							<div class="when">Step 01</div>
							<h4>Research &amp; Audit</h4>
							<div class="where">Keyword research, competitor analysis and a full technical and content audit.</div>
						</li>
						<li>
							<div class="when">Step 02</div>
							<h4>Strategy &amp; Roadmap</h4>
							<div class="where">A prioritised plan mapping keywords to SEO friendly URLs and content.</div>
						</li>
						<li>
							<div class="when">Step 03</div>
							<h4>Optimize &amp; Build</h4>
							<div class="where">On-page, technical and off-page execution plus AI search optimization.</div>
						</li>
						<li>
							<div class="when">Step 04</div>
							<h4>Measure &amp; Scale</h4>
							<div class="where">Track rankings, traffic and leads, then double down on what drives ROI.</div>
						</li>
					</ul>
				</div>
			</div>
			<div>
				<h2 class="section-title">why me<span class="dot">.</span></h2>
				<p class="section-intro" style="margin-bottom:24px;">8 years of measurable growth across India, Dubai, the UK, the USA and Australia.<span class="rule"></span></p>
				<div class="panel">
					<ul class="check-list">
						<li>AI-first search strategy across Google and modern LLM platforms</li>
						<li>100% white hat, sustainable methods that protect your brand</li>
						<li>Focus on qualified traffic, leads and sales, not vanity metrics</li>
						<li>Experience across WordPress, Shopify, Wix and Squarespace</li>
						<li>Transparent reporting tied to real revenue growth</li>
						<li>SEO, GEO and Google Ads under one roof</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ============ CASE STUDIES ============ -->
<section class="bg-white">
	<div class="container">
		<?php avseo_section_title( 'case studies', 'A showcase of the brands and campaigns behind real growth in traffic, rankings and revenue.' ); ?>
		<div class="grid-4">
			<?php
			$cases = array(
				array( 'img_case_1', 'Case study 1', 'Project One', 'Organic Growth' ),
				array( 'img_case_2', 'Case study 2', 'Project Two', 'Local SEO' ),
				array( 'img_case_3', 'Case study 3', 'Project Three', 'eCommerce SEO' ),
				array( 'img_case_4', 'Case study 4', 'Project Four', 'AI Search' ),
			);
			foreach ( $cases as $c ) : ?>
				<div>
					<?php avseo_image_slot( $c[0], $c[1], $c[2], '', '600 x 400 px' ); ?>
					<div style="text-align:center;margin-top:12px;">
						<strong style="font-family:var(--font-head);color:var(--navy);display:block;"><?php echo esc_html( $c[2] ); ?></strong>
						<small style="color:var(--muted);"><?php echo esc_html( $c[3] ); ?></small>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ TOOLS & PLATFORMS ============ -->
<section class="bg-cream">
	<div class="container">
		<?php avseo_section_title( 'tools &amp; platforms', 'The tools I use to research, execute, optimize and measure every SEO campaign.' ); ?>
		<div class="tools-grid">
			<?php
			$tools = array(
				array( '🔎', 'Google Search Console' ),
				array( '📊', 'Google Analytics 4' ),
				array( '🧭', 'Ahrefs' ),
				array( '🧪', 'Semrush' ),
				array( '🕷️', 'Screaming Frog' ),
				array( '🎯', 'Google Ads' ),
				array( '📝', 'WordPress' ),
				array( '🛍️', 'Shopify' ),
				array( '🟦', 'Wix' ),
				array( '⬛', 'Squarespace' ),
				array( '🤖', 'ChatGPT' ),
				array( '✳️', 'Surfer / Clearscope' ),
			);
			foreach ( $tools as $t ) : ?>
				<div class="tool">
					<span class="tico"><?php echo esc_html( $t[0] ); ?></span>
					<span><?php echo esc_html( $t[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ INDUSTRIES I SERVE ============ -->
<section class="bg-white">
	<div class="container">
		<?php avseo_section_title( 'industries i serve', 'Proven SEO and AI search experience across a wide range of industries and business models.' ); ?>
		<div class="grid-4">
			<?php
			$industries = array(
				array( '🏥', 'Healthcare &amp; Clinics', 'Local SEO and content that builds trust and brings patient enquiries.' ),
				array( '🛍️', 'eCommerce &amp; Retail', 'Product and category SEO that grows qualified traffic and online sales.' ),
				array( '🏠', 'Real Estate &amp; Interiors', 'Local and content SEO that generates high intent property leads.' ),
				array( '💼', 'Professional Services', 'Authority content and rankings for legal, finance and consulting firms.' ),
				array( '💻', 'SaaS &amp; Technology', 'Search and AI visibility strategies that drive sign ups and demos.' ),
				array( '💇', 'Salons &amp; Beauty', 'Google Business Profile and local SEO that fill your appointment book.' ),
				array( '🍽️', 'Restaurants &amp; Hospitality', 'Local search visibility that drives bookings and footfall.' ),
				array( '🎓', 'Education &amp; Coaching', 'Content and SEO that grow enrolments and course sign ups.' ),
			);
			foreach ( $industries as $ind ) : ?>
				<div class="svc-card">
					<span class="card-ico" style="font-size:1.8rem;"><?php echo $ind[0]; ?></span>
					<h3 style="font-size:1.1rem;margin-top:.4em;"><?php echo wp_kses_post( $ind[1] ); ?></h3>
					<p><?php echo wp_kses_post( $ind[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<?php
$testimonials = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$quote = avseo_opt( "testi_{$i}_quote", '' );
	if ( trim( $quote ) === '' ) {
		continue;
	}
	$testimonials[] = array(
		'photo' => avseo_opt( "testi_{$i}_photo", avseo_sample_default( "testi_{$i}_photo" ) ),
		'quote' => $quote,
		'name'  => avseo_opt( "testi_{$i}_name", '' ),
		'role'  => avseo_opt( "testi_{$i}_role", '' ),
	);
}
if ( ! empty( $testimonials ) ) :
	?>
	<section class="bg-white">
		<div class="container">
			<?php avseo_section_title( 'client love', 'Real results and relationships from businesses I have helped grow with SEO and AI search.' ); ?>
			<div class="grid-3">
				<?php foreach ( $testimonials as $t ) : ?>
					<div class="quote-card">
						<div class="stars">★★★★★</div>
						<p>&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p>
						<div class="who-row">
							<?php if ( $t['photo'] ) : ?>
								<img class="who-photo" src="<?php echo esc_url( $t['photo'] ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>" loading="lazy" />
							<?php elseif ( $t['name'] ) : ?>
								<span class="who-photo who-initials"><?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?></span>
							<?php endif; ?>
							<div class="who"><?php echo esc_html( $t['name'] ); ?><small><?php echo esc_html( $t['role'] ); ?></small></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ FEATURED BRANDS ============ -->
<section class="bg-cream">
	<div class="container">
		<?php avseo_section_title( 'featured brands', avseo_opt( 'brands_heading', 'Brands I have worked with across multiple industries.' ) ); ?>
		<div class="logo-grid">
			<?php
			for ( $i = 1; $i <= 12; $i++ ) :
				$logo = avseo_opt( "brand_{$i}", avseo_sample_default( "brand_{$i}" ) );
				?>
				<div class="logo-cell">
					<?php if ( $logo ) : ?>
						<img src="<?php echo esc_url( $logo ); ?>" alt="Client brand logo <?php echo esc_attr( $i ); ?>" loading="lazy" />
					<?php else : ?>
						<span class="logo-empty">+ Add logo<br><small>200 x 100 px</small></span>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
		<p class="center" style="color:var(--muted);margin-top:22px;font-size:.9rem;">Upload your client logos in Appearance &rarr; Customize &rarr; Brand Logos.</p>
	</div>
</section>

<?php avseo_cta_band(); ?>
<?php get_footer(); ?>
