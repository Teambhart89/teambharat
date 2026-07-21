<?php
/**
 * Template helpers: render service pages, reusable UI blocks and data-viz.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a full service page (H1 -> H2 -> H3 -> H4 + FAQ) from the data library.
 *
 * @param string $slug Service slug.
 */
function avdesh_render_service( $slug ) {
	$s = avdesh_get_service( $slug );
	if ( ! $s ) {
		echo '<div class="container section"><p>' . esc_html__( 'Service not found.', 'avdesh-seo' ) . '</p></div>';
		return;
	}
	$contact = home_url( '/contact/' );
	$audit   = home_url( '/book-free-seo-audit/' );
	?>
	<section class="page-hero">
		<div class="container">
			<nav class="crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a><span class="sep">/</span>
				<span><?php echo esc_html( $s['menu'] ); ?></span>
			</nav>
			<span class="eyebrow"><?php echo esc_html( $s['icon'] . ' ' . $s['menu'] ); ?></span>
			<h1><?php echo esc_html( $s['h1'] ); ?></h1>
			<p class="lead"><?php echo esc_html( $s['tagline'] ); ?></p>
			<div class="hero-actions" style="margin-top:24px;">
				<a class="btn btn-primary" href="<?php echo esc_url( $audit ); ?>">Book a free SEO audit</a>
				<a class="btn btn-ghost-light" href="<?php echo esc_url( $contact ); ?>">Talk to Avdesh</a>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="container two-col">
			<div class="prose reveal">

				<h2><?php echo esc_html( $s['intro']['h2'] ); ?></h2>
				<?php foreach ( $s['intro']['paras'] as $p ) : ?>
					<p><?php echo esc_html( $p ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $s['intro']['callout'] ) ) : ?>
					<div class="callout"><?php echo esc_html( $s['intro']['callout'] ); ?></div>
				<?php endif; ?>

				<h2><?php echo esc_html( $s['includes']['h2'] ); ?></h2>
				<div class="grid grid-2" style="margin-top:20px;">
					<?php foreach ( $s['includes']['items'] as $it ) : ?>
						<div class="card">
							<h3><?php echo esc_html( $it['h3'] ); ?></h3>
							<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $it['p'] ); ?></p>
							<div class="feat" style="margin-top:14px;">
								<div class="fic">✓</div>
								<div>
									<h4><?php echo esc_html( $it['h4'] ); ?></h4>
									<p><?php echo esc_html( $it['h4p'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<h2 style="margin-top:48px;"><?php echo esc_html( $s['process']['h2'] ); ?></h2>
				<div class="steps" style="margin-top:20px;">
					<?php $n = 1; foreach ( $s['process']['steps'] as $st ) : ?>
						<div class="step">
							<div class="snum"><?php echo esc_html( $n ); ?></div>
							<h3><?php echo esc_html( $st['h3'] ); ?></h3>
							<p><?php echo esc_html( $st['p'] ); ?></p>
						</div>
					<?php $n++; endforeach; ?>
				</div>

				<?php if ( ! empty( $s['platforms'] ) ) : ?>
					<h2 style="margin-top:48px;"><?php echo esc_html( $s['platforms']['h2'] ); ?></h2>
					<p><?php echo esc_html( $s['platforms']['para'] ); ?></p>
					<div class="grid grid-3" style="margin-top:20px;">
						<?php foreach ( $s['platforms']['items'] as $pl ) : ?>
							<div class="card">
								<h3 style="font-size:1.12rem;"><?php echo esc_html( $pl['h3'] ); ?></h3>
								<p style="margin:0;color:var(--muted);font-size:.9rem;"><?php echo esc_html( $pl['p'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<h2 style="margin-top:48px;"><?php echo esc_html( $s['why']['h2'] ); ?></h2>
				<div class="grid grid-2" style="margin-top:20px;">
					<?php foreach ( $s['why']['items'] as $b ) : ?>
						<div class="feat">
							<div class="fic">★</div>
							<div>
								<h4><?php echo esc_html( $b['h4'] ); ?></h4>
								<p><?php echo esc_html( $b['p'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<h2 style="margin-top:48px;">Frequently asked questions</h2>
				<div class="faq" style="margin-top:20px;">
					<?php foreach ( $s['faq'] as $f ) : ?>
						<details>
							<summary><h3 style="font-size:1.02rem;margin:0;display:inline;font-family:var(--display);"><?php echo esc_html( $f['q'] ); ?></h3></summary>
							<p><?php echo esc_html( $f['a'] ); ?></p>
						</details>
					<?php endforeach; ?>
				</div>
			</div>

			<aside>
				<div class="side-card grad reveal">
					<h3>Get a free SEO audit</h3>
					<p style="color:#AEB6DA;font-size:.93rem;">See exactly what's holding your rankings back and how to fix it, with a clear action plan.</p>
					<a class="btn btn-primary btn-block" style="margin:16px 0;" href="<?php echo esc_url( $audit ); ?>">Request my audit</a>
					<h3 style="margin-top:10px;">Related services</h3>
					<ul>
						<?php foreach ( $s['related'] as $rel ) :
							$r = avdesh_get_service( $rel );
							if ( ! $r ) { continue; } ?>
							<li><a href="<?php echo esc_url( home_url( '/' . $rel . '/' ) ); ?>">→ <?php echo esc_html( $r['menu'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</aside>
		</div>
	</section>

	<?php avdesh_cta_band(); ?>
	<?php
}

/**
 * Service card for grids.
 *
 * @param string $slug Service slug.
 */
function avdesh_service_card( $slug, $num = '' ) {
	$s = avdesh_get_service( $slug );
	if ( ! $s ) {
		return;
	}
	?>
	<a class="card svc-card reveal" href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>">
		<div class="ic"><?php echo esc_html( $s['icon'] ); ?></div>
		<h3><?php echo esc_html( $s['menu'] ); ?></h3>
		<p><?php echo esc_html( $s['card_desc'] ); ?></p>
		<span class="more">Learn more →</span>
	</a>
	<?php
}

/** Reusable gradient CTA band. */
function avdesh_cta_band( $title = '', $text = '' ) {
	$title = $title ? $title : 'Ready to grow your traffic, leads and revenue?';
	$text  = $text ? $text : 'Book a free SEO audit and get a clear, no-obligation plan to increase your organic visibility across Google and AI search.';
	$phone = avdesh_opt( 'avdesh_phone', '' );
	?>
	<section class="section">
		<div class="container">
			<div class="cta-band reveal">
				<h2><?php echo esc_html( $title ); ?></h2>
				<p><?php echo esc_html( $text ); ?></p>
				<div class="cta-actions">
					<a class="btn btn-primary btn-lg" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>">Book a free SEO audit</a>
					<?php if ( $phone ) : ?>
						<a class="btn btn-ghost-light btn-lg" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">Call <?php echo esc_html( $phone ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/** Sticky floating contact buttons (WhatsApp / Book / Email). */
function avdesh_float_contact() {
	$whatsapp = preg_replace( '/[^0-9]/', '', avdesh_opt( 'avdesh_whatsapp', '' ) );
	$email    = avdesh_opt( 'avdesh_email', '' );
	?>
	<div class="float-contact" aria-label="Quick contact">
		<?php if ( $whatsapp ) : ?>
			<a class="fc-wa" href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">💬<span class="tip">Chat on WhatsApp</span></a>
		<?php endif; ?>
		<a class="fc-book" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>" aria-label="Book a free SEO audit">📈<span class="tip">Free SEO audit</span></a>
		<?php if ( $email ) : ?>
			<a class="fc-mail" href="mailto:<?php echo esc_attr( $email ); ?>" aria-label="Email">✉<span class="tip">Email me</span></a>
		<?php endif; ?>
	</div>
	<?php
}

/* =========================================================
   Extended section data + renderers (v3.1)
   ========================================================= */

/** Small multi-colour Google "G" mark. */
function avdesh_google_g( $size = 17 ) {
	return '<svg width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 48 48" aria-hidden="true" focusable="false">'
		. '<path fill="#4285F4" d="M45.12 24.5c0-1.56-.14-3.06-.4-4.5H24v8.51h11.84c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.56-9.47 6.56-16.17z"/>'
		. '<path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.31-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>'
		. '<path fill="#FBBC05" d="M11.69 28.18C11.25 26.86 11 25.45 11 24s.25-2.86.69-4.18v-5.7H4.34C2.85 17.09 2 20.45 2 24s.85 6.91 2.34 9.88l7.35-5.7z"/>'
		. '<path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.35 5.7c1.73-5.2 6.58-9.07 12.31-9.07z"/>'
		. '</svg>';
}

/** Industries data. Edit labels/icons here. */
function avdesh_industries_data() {
	return array(
		array( '🏘️', 'Real Estate' ), array( '🏥', 'Healthcare' ), array( '🚗', 'Automotive' ), array( '🛋️', 'Interior & Fitouts' ),
		array( '🧾', 'Tax & Accounting' ), array( '🎓', 'Education' ), array( '✈️', 'Travel & Tourism' ), array( '🛒', 'eCommerce' ),
		array( '🍽️', 'F&B / Restaurants' ), array( '🎬', 'Events & Production' ), array( '💼', 'Professional Services' ), array( '💆', 'Beauty & Wellness' ),
		array( '🏗️', 'Construction' ), array( '🪵', 'Flooring' ), array( '🌸', 'Fragrance' ), array( '💻', 'SaaS & Technology' ),
	);
}

/** Render the industries grid. */
function avdesh_industries_section( $heading = 'Industries I have worked in', $sub = '', $limit = 0 ) {
	$items = avdesh_industries_data();
	if ( $limit > 0 ) {
		$items = array_slice( $items, 0, $limit );
	}
	?>
	<div class="sec-head center reveal">
		<span class="eyebrow">Industries served</span>
		<h2 class="sec-title"><?php echo esc_html( $heading ); ?></h2>
		<?php if ( $sub ) : ?><p class="sec-sub"><?php echo esc_html( $sub ); ?></p><?php endif; ?>
	</div>
	<div class="ind-grid reveal" style="margin-top:40px;">
		<?php foreach ( $items as $ind ) : ?>
			<div class="ind-tile"><div class="it-ic"><?php echo esc_html( $ind[0] ); ?></div><h4><?php echo esc_html( $ind[1] ); ?></h4></div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Testimonials data (edit with your real Google reviews). */
function avdesh_testimonials_data() {
	return array(
		'stat_pct'   => '98%',
		'stat_text'  => 'of clients recommend my SEO &amp; AI search services',
		'featured'   => array(
			'quote' => 'Working with Avdesh, we have seen measurable improvements in our website traffic, better Google rankings and, most importantly, more qualified leads.',
			'name'  => 'Keerthi Vinod',
			'role'  => 'Marketing Manager',
		),
		'reviews'    => array(
			array( 'S. Mehta', 'SaaS Founder', '2 months ago', 'I was able to build the ideal SEO plan with Avdesh\'s help. Undoubtedly brilliant and has a great range of experience across industries.' ),
			array( 'A. Khan', 'eCommerce Director', '3 months ago', 'I am very much satisfied with his work. I trust the quality of his SEO and he is truly one of the best consultants I have worked with.' ),
			array( 'Sindhu Sunny', 'Local Business Owner', '4 months ago', 'His communication is very simple and easy to understand. He explains the strategy clearly and delivers real results.' ),
			array( 'Prince J', 'Agency Lead', '5 months ago', 'One of the best professionals I have worked with. Gets the work done in limited time with great quality and brought in a lot of clients.' ),
		),
	);
}

/** Render the testimonials section (97% card + featured + Google review cards). */
function avdesh_testimonials_section( $heading = 'See what clients have to say' ) {
	$t = avdesh_testimonials_data();
	$g = avdesh_google_g( 15 );
	?>
	<div class="sec-head center reveal">
		<span class="eyebrow">Testimonials</span>
		<h2 class="sec-title"><?php echo esc_html( $heading ); ?></h2>
	</div>

	<div class="testi-hero reveal" style="margin-top:40px;">
		<div class="testi-stat">
			<span class="lbl">Testimonials</span>
			<span class="big"><?php echo esc_html( $t['stat_pct'] ); ?></span>
			<p><?php echo wp_kses_post( $t['stat_text'] ); ?></p>
		</div>
		<div class="testi-featured">
			<div class="tf-img"><?php avdesh_image_area( 'avdesh_img_testimonial', 'Client photo', '', 'Happy SEO client' ); ?></div>
			<div class="tf-body">
				<div class="stars">★★★★★</div>
				<blockquote>"<?php echo esc_html( $t['featured']['quote'] ); ?>"</blockquote>
				<span class="tf-name"><?php echo esc_html( $t['featured']['name'] ); ?></span>
				<span class="tf-role"><?php echo esc_html( $t['featured']['role'] ); ?></span>
			</div>
		</div>
	</div>

	<div class="review-grid reveal">
		<?php foreach ( $t['reviews'] as $r ) : ?>
			<div class="review-card">
				<div class="rc-top"><span class="stars">★★★★★</span><span class="verified" title="Verified">✔</span></div>
				<p><?php echo esc_html( $r[3] ); ?></p>
				<span class="rc-more">Read more</span>
				<div class="rc-foot">
					<span class="rc-av"><?php echo esc_html( strtoupper( substr( $r[0], 0, 1 ) ) ); ?><span class="rc-g"><?php echo $g; // phpcs:ignore ?></span></span>
					<span class="rc-who"><b><?php echo esc_html( $r[0] ); ?></b><span><?php echo esc_html( $r[2] ); ?></span></span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Top ranking keywords data (edit with your real client wins). */
function avdesh_ranking_keywords_data() {
	return array(
		array(
			'country' => 'India', 'client' => 'Client A', 'year' => '2024-2026',
			'rows' => array(
				array( 'seo expert in delhi', '1' ),
				array( 'seo services india', '1' ),
				array( 'ai search optimization', '2' ),
				array( 'freelance seo consultant', '1' ),
			),
		),
		array(
			'country' => 'UAE', 'client' => 'Client B', 'year' => '2023-2025',
			'rows' => array(
				array( 'seo agency dubai', '2' ),
				array( 'ecommerce seo uae', '1' ),
				array( 'local seo dubai', '1' ),
				array( 'google ads dubai', '3' ),
			),
		),
		array(
			'country' => 'UK / USA', 'client' => 'Client C', 'year' => '2022-2025',
			'rows' => array(
				array( 'saas seo consultant', '1' ),
				array( 'generative engine optimization', '1' ),
				array( 'international seo services', '2' ),
				array( 'technical seo expert', '1' ),
			),
		),
	);
}

/** Render the top ranking keywords section. */
function avdesh_ranking_keywords_section( $heading = 'Top ranking keywords I have delivered' ) {
	$data = avdesh_ranking_keywords_data();
	?>
	<div class="sec-head center reveal">
		<span class="eyebrow">Top ranking keywords</span>
		<h2 class="sec-title"><?php echo esc_html( $heading ); ?></h2>
		<p class="sec-sub">A selection of keywords I have ranked on page one for clients through strategic, white-hat SEO. Replace with your own client data.</p>
	</div>
	<div class="kw-grid reveal" style="margin-top:40px;">
		<?php foreach ( $data as $c ) : ?>
			<div class="kw-card">
				<div class="kw-panel">
					<div class="kw-head">
						<span class="kw-loc"><?php echo avdesh_google_g( 18 ); // phpcs:ignore ?> <?php echo esc_html( $c['country'] ); ?></span>
						<span class="kw-cli"><b><?php echo esc_html( $c['client'] ); ?></b><span><?php echo esc_html( $c['year'] ); ?></span></span>
					</div>
					<div class="kw-table">
						<div class="kw-th"><span>Keyword</span><span>Position</span></div>
						<?php foreach ( $c['rows'] as $row ) : ?>
							<div class="kw-tr"><span><?php echo esc_html( $row[0] ); ?></span><span class="kw-pos">#<?php echo esc_html( $row[1] ); ?></span></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Render a two-column FAQ accordion from a list of q/a pairs. */
function avdesh_faq_grid( $faqs, $open_first = true ) {
	$half = (int) ceil( count( $faqs ) / 2 );
	$cols = array( array_slice( $faqs, 0, $half ), array_slice( $faqs, $half ) );
	echo '<div class="faq-2col reveal">';
	foreach ( $cols as $ci => $col ) {
		echo '<div class="faq-col">';
		foreach ( $col as $i => $f ) {
			$open = ( $open_first && 0 === $ci && 0 === $i ) ? ' open' : '';
			echo '<details' . esc_attr( $open ) . '>';
			echo '<summary><span>' . esc_html( $f['q'] ) . '</span><span class="qbtn">+</span></summary>';
			echo '<p>' . esc_html( $f['a'] ) . '</p>';
			echo '</details>';
		}
		echo '</div>';
	}
	echo '</div>';
}

/** Site-wide FAQ list (used by the FAQs page and FAQPage schema). */
function avdesh_faq_list() {
	return array(
		array( 'q' => 'What SEO services do you offer?', 'a' => 'I offer full-funnel SEO including technical SEO, on-page SEO, local SEO, eCommerce SEO, international SEO, link building, keyword research, content strategy, website migration, Core Web Vitals, plus AI Search Optimization (AISO), GEO and Google Ads management.' ),
		array( 'q' => 'How much do your SEO services cost?', 'a' => 'Packages start from an indicative monthly rate, with custom pricing for larger eCommerce, SaaS and international projects. Every project is scoped to your goals. See the pricing page or book a free audit for a tailored quote.' ),
		array( 'q' => 'How long does SEO take to show results?', 'a' => 'Most projects see early movement within 8 to 12 weeks, with stronger, compounding results from month four onward. Google Ads can generate leads within days, which is why I often combine both.' ),
		array( 'q' => 'Do you use white-hat SEO only?', 'a' => 'Yes, 100%. Every method follows search engine guidelines. White-hat SEO protects your domain and delivers rankings that last, rather than short-term spikes that risk penalties.' ),
		array( 'q' => 'What is AI Search Optimization (AISO) and GEO?', 'a' => 'AI Search Optimization and Generative Engine Optimization make your brand visible inside AI answers from ChatGPT, Gemini, Claude, Perplexity and Google AI Overviews, so you get cited and recommended where buyers now research.' ),
		array( 'q' => 'Which platforms and countries do you work with?', 'a' => 'WordPress, Shopify, Wix, Squarespace, WooCommerce and custom builds, for clients across India, the USA, UK, Canada, Australia, UAE and Europe.' ),
		array( 'q' => 'Do you offer a free consultation?', 'a' => 'Yes. Book a free SEO audit and I will show you exactly what is holding your rankings back and how to fix it, with a clear action plan and no obligation.' ),
		array( 'q' => 'Will you lose my rankings during a redesign or migration?', 'a' => 'Not with a proper plan. I manage migrations carefully with full redirect mapping, QA and post-launch monitoring to protect your rankings and often improve them.' ),
		array( 'q' => 'Do you provide reports?', 'a' => 'Yes. You get transparent monthly reporting on rankings, traffic and conversions, so you always know what you are getting for your investment.' ),
		array( 'q' => 'Can you handle both SEO and Google Ads?', 'a' => 'Absolutely. Running SEO, GEO and Google Ads together lets you capture demand now while building durable, lower-cost organic visibility for the long term.' ),
	);
}

/**
 * Inline SVG area chart for "traffic growth" (decorative, accessible).
 *
 * @param array $points Y values (0-100 scale). Emerald growth line.
 */
function avdesh_traffic_chart( $points = array( 8, 14, 12, 22, 30, 28, 40, 52, 60, 72, 84, 96 ) ) {
	$w = 520; $h = 240; $pad = 8;
	$n = count( $points );
	$step = ( $w - $pad * 2 ) / ( $n - 1 );
	$coords = array();
	foreach ( $points as $i => $p ) {
		$x = $pad + $i * $step;
		$y = $h - $pad - ( $p / 100 ) * ( $h - $pad * 2 );
		$coords[] = array( round( $x, 1 ), round( $y, 1 ) );
	}
	$line = '';
	foreach ( $coords as $i => $c ) {
		$line .= ( 0 === $i ? 'M' : 'L' ) . $c[0] . ' ' . $c[1] . ' ';
	}
	$area = $line . 'L' . $coords[ $n - 1 ][0] . ' ' . ( $h - $pad ) . ' L' . $coords[0][0] . ' ' . ( $h - $pad ) . ' Z';
	ob_start();
	?>
	<svg viewBox="0 0 <?php echo esc_attr( $w . ' ' . $h ); ?>" width="100%" role="img" aria-label="Organic traffic growth trending upward over 12 months">
		<defs>
			<linearGradient id="tgFill" x1="0" y1="0" x2="0" y2="1">
				<stop offset="0%" stop-color="#10B981" stop-opacity="0.28"/>
				<stop offset="100%" stop-color="#10B981" stop-opacity="0"/>
			</linearGradient>
		</defs>
		<?php for ( $g = 1; $g <= 3; $g++ ) : $gy = $pad + $g * ( $h - $pad * 2 ) / 4; ?>
			<line x1="<?php echo esc_attr( $pad ); ?>" y1="<?php echo esc_attr( $gy ); ?>" x2="<?php echo esc_attr( $w - $pad ); ?>" y2="<?php echo esc_attr( $gy ); ?>" stroke="#E6E8F2" stroke-width="1"/>
		<?php endfor; ?>
		<path d="<?php echo esc_attr( $area ); ?>" fill="url(#tgFill)"/>
		<path d="<?php echo esc_attr( trim( $line ) ); ?>" fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
		<?php $last = $coords[ $n - 1 ]; ?>
		<circle cx="<?php echo esc_attr( $last[0] ); ?>" cy="<?php echo esc_attr( $last[1] ); ?>" r="5" fill="#10B981" stroke="#fff" stroke-width="2"/>
	</svg>
	<?php
	return ob_get_clean();
}

/**
 * Inline SVG "before / after" ranking bars (lower is better -> shown as growth).
 */
function avdesh_ranking_chart() {
	$rows = array(
		array( 'Primary keyword', 42, 3 ),
		array( 'Secondary term', 68, 5 ),
		array( 'Buyer keyword', 55, 2 ),
		array( 'Local term', 31, 1 ),
	);
	ob_start();
	echo '<div style="display:grid;gap:16px;">';
	foreach ( $rows as $r ) {
		$before_w = min( 100, $r[1] ); // position -> width (higher position = longer bar = worse)
		$after_w  = min( 100, $r[2] * 2 + 6 );
		echo '<div>';
		echo '<div style="display:flex;justify-content:space-between;font-size:.82rem;color:var(--muted);margin-bottom:6px;"><span>' . esc_html( $r[0] ) . '</span><span><b style="color:var(--muted);">#' . esc_html( $r[1] ) . '</b> → <b style="color:var(--accent-d);">#' . esc_html( $r[2] ) . '</b></span></div>';
		echo '<div style="height:10px;background:var(--bg-2);border-radius:50px;position:relative;overflow:hidden;">';
		echo '<div style="position:absolute;left:0;top:0;bottom:0;width:' . esc_attr( $before_w ) . '%;background:#C7CAF0;border-radius:50px;"></div>';
		echo '<div style="position:absolute;left:0;top:0;bottom:0;width:' . esc_attr( $after_w ) . '%;background:linear-gradient(90deg,#4F46E5,#10B981);border-radius:50px;"></div>';
		echo '</div></div>';
	}
	echo '</div>';
	return ob_get_clean();
}
