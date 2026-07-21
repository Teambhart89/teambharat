<?php
/**
 * Template helpers: render service pages and reusable UI blocks.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a full service page body from the services data library.
 * Produces a clean H1 -> H2 -> H3 -> H4 hierarchy on every page.
 *
 * @param string $slug Service slug (matches the page slug).
 */
function avdesh_render_service( $slug ) {
	$s = avdesh_get_service( $slug );
	if ( ! $s ) {
		echo '<div class="container section"><p>' . esc_html__( 'Service not found.', 'avdesh-seo' ) . '</p></div>';
		return;
	}
	$contact = home_url( '/contact/' );

	/* ---- Page hero with H1 + breadcrumb ---- */
	?>
	<section class="page-hero">
		<div class="container">
			<nav class="crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span class="sep">/</span>
				<a href="<?php echo esc_url( home_url( '/seo-services/' ) ); ?>">Services</a>
				<span class="sep">/</span>
				<span><?php echo esc_html( $s['menu'] ); ?></span>
			</nav>
			<span class="eyebrow"><?php echo esc_html( $s['icon'] . '  ' . $s['menu'] ); ?></span>
			<h1><?php echo esc_html( $s['h1'] ); ?></h1>
			<p class="lead"><?php echo esc_html( $s['tagline'] ); ?></p>
			<p style="margin-top:20px;"><a class="btn btn-primary" href="<?php echo esc_url( $contact ); ?>">Get a free consultation →</a></p>
		</div>
	</section>

	<section class="section">
		<div class="container two-col">
			<div class="prose reveal">

				<?php /* ---- Intro (H2) ---- */ ?>
				<h2><?php echo esc_html( $s['intro']['h2'] ); ?><span class="dot">.</span></h2>
				<?php foreach ( $s['intro']['paras'] as $p ) : ?>
					<p><?php echo esc_html( $p ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $s['intro']['callout'] ) ) : ?>
					<div class="callout"><?php echo esc_html( $s['intro']['callout'] ); ?></div>
				<?php endif; ?>

				<?php /* ---- Includes (H2 + H3 + H4) ---- */ ?>
				<h2><?php echo esc_html( $s['includes']['h2'] ); ?><span class="dot">.</span></h2>
				<div class="grid grid-2" style="margin-top:18px;">
					<?php foreach ( $s['includes']['items'] as $it ) : ?>
						<div class="card feat">
							<h3><?php echo esc_html( $it['h3'] ); ?></h3>
							<p><?php echo esc_html( $it['p'] ); ?></p>
							<h4><span class="tick">✔</span> <?php echo esc_html( $it['h4'] ); ?></h4>
							<p style="margin:0;"><?php echo esc_html( $it['h4p'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>

				<?php /* ---- Process (H2 + H3) ---- */ ?>
				<h2 style="margin-top:44px;"><?php echo esc_html( $s['process']['h2'] ); ?><span class="dot">.</span></h2>
				<div class="steps" style="margin-top:18px;">
					<?php foreach ( $s['process']['steps'] as $st ) : ?>
						<div class="step">
							<h3><?php echo esc_html( $st['h3'] ); ?></h3>
							<p><?php echo esc_html( $st['p'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>

				<?php /* ---- Platforms (optional) (H2 + H3) ---- */ ?>
				<?php if ( ! empty( $s['platforms'] ) ) : ?>
					<h2 style="margin-top:44px;"><?php echo esc_html( $s['platforms']['h2'] ); ?><span class="dot">.</span></h2>
					<p><?php echo esc_html( $s['platforms']['para'] ); ?></p>
					<div class="grid grid-3" style="margin-top:18px;">
						<?php foreach ( $s['platforms']['items'] as $pl ) : ?>
							<div class="card">
								<h3 style="font-size:1.15rem;"><?php echo esc_html( $pl['h3'] ); ?></h3>
								<p style="margin:0;color:var(--muted);font-size:.92rem;"><?php echo esc_html( $pl['p'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php /* ---- Why / Benefits (H2 + H4) ---- */ ?>
				<h2 style="margin-top:44px;"><?php echo esc_html( $s['why']['h2'] ); ?><span class="dot">.</span></h2>
				<ul class="ticks" style="margin-top:16px;">
					<?php foreach ( $s['why']['items'] as $b ) : ?>
						<li>
							<h4 style="display:inline;"><?php echo esc_html( $b['h4'] ); ?>.</h4>
							<span style="color:var(--muted);"> <?php echo esc_html( $b['p'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php /* ---- FAQ (H2 + H3) ---- */ ?>
				<h2 style="margin-top:44px;">Frequently asked questions<span class="dot">.</span></h2>
				<div class="faq" style="margin-top:18px;text-align:left;">
					<?php foreach ( $s['faq'] as $f ) : ?>
						<details>
							<summary><h3 style="font-size:1.02rem;margin:0;display:inline;"><?php echo esc_html( $f['q'] ); ?></h3></summary>
							<p><?php echo esc_html( $f['a'] ); ?></p>
						</details>
					<?php endforeach; ?>
				</div>

			</div>

			<?php /* ---- Sticky sidebar ---- */ ?>
			<aside>
				<div class="side-card reveal">
					<h3>Ready to grow?</h3>
					<p style="color:var(--muted);font-size:.93rem;">Let's turn search into a reliable source of leads and revenue for your business.</p>
					<p style="margin:16px 0;"><a class="btn btn-primary" style="width:100%;justify-content:center;" href="<?php echo esc_url( $contact ); ?>">Book a free call</a></p>
					<h3 style="margin-top:8px;">Related services</h3>
					<ul>
						<?php foreach ( $s['related'] as $rel ) :
							$r = avdesh_get_service( $rel );
							if ( ! $r ) { continue; } ?>
							<li><a href="<?php echo esc_url( home_url( '/' . $rel . '/' ) ); ?>"><span style="color:var(--orange);">→</span> <?php echo esc_html( $r['menu'] ); ?></a></li>
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
 * Homepage / services-grid card for one service.
 *
 * @param string $slug Service slug.
 * @param string $num  Two-digit number label.
 */
function avdesh_service_card( $slug, $num = '01' ) {
	$s = avdesh_get_service( $slug );
	if ( ! $s ) {
		return;
	}
	?>
	<a class="card svc-card reveal" href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>">
		<span class="num"><?php echo esc_html( $num ); ?></span>
		<div class="ic"><?php echo esc_html( $s['icon'] ); ?></div>
		<h3><?php echo esc_html( $s['menu'] ); ?></h3>
		<p><?php echo esc_html( $s['card_desc'] ); ?></p>
		<span class="more">Learn more →</span>
	</a>
	<?php
}

/** Reusable dark CTA band. */
function avdesh_cta_band( $title = '', $text = '' ) {
	$title = $title ? $title : 'Ready to grow your organic traffic and revenue?';
	$text  = $text ? $text : 'Let\'s build an SEO and AI search strategy that turns visibility into qualified leads and real ROI for your business.';
	$phone = avdesh_opt( 'avdesh_phone', '' );
	?>
	<section class="section">
		<div class="container">
			<div class="cta-band reveal">
				<h2><?php echo esc_html( $title ); ?></h2>
				<p><?php echo esc_html( $text ); ?></p>
				<div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a project</a>
					<?php if ( $phone ) : ?>
						<a class="btn btn-light" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">Call <?php echo esc_html( $phone ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
