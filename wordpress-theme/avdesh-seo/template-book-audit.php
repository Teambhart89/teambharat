<?php
/**
 * Template Name: Book Free SEO Audit
 *
 * @package Avdesh_SEO
 */

get_header();

$email    = avdesh_opt( 'avdesh_email', '' );
$whatsapp = avdesh_opt( 'avdesh_whatsapp', '' );
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Free SEO Audit</span></nav>
		<span class="eyebrow">🎁 100% free, no obligation</span>
		<h1>Book Your Free SEO Audit</h1>
		<p>Get a clear, personalised breakdown of what's holding your rankings back and exactly how to fix it. No jargon, no pressure, just actionable insight.</p>
	</div>
</section>

<section class="section">
	<div class="container two-col" style="grid-template-columns:1fr 1fr;">
		<div class="reveal">
			<h2>What you'll get</h2>
			<div class="grid" style="gap:20px;margin-top:22px;">
				<div class="feat"><div class="fic">🔍</div><div><h4>Technical health check</h4><p>Site speed, Core Web Vitals, crawlability and indexation issues.</p></div></div>
				<div class="feat"><div class="fic">🔑</div><div><h4>Keyword &amp; ranking review</h4><p>Where you rank now and the highest-value opportunities you're missing.</p></div></div>
				<div class="feat"><div class="fic">📄</div><div><h4>On-page &amp; content gaps</h4><p>What to fix and create to rank for terms your buyers use.</p></div></div>
				<div class="feat"><div class="fic">🤖</div><div><h4>AI search visibility</h4><p>How visible you are in AI answers, and how to improve it.</p></div></div>
				<div class="feat"><div class="fic">🗺️</div><div><h4>A prioritized action plan</h4><p>Clear next steps ranked by impact, yours to keep either way.</p></div></div>
			</div>
			<div class="callout" style="margin-top:24px;">Prefer to talk first?
				<?php if ( $whatsapp ) : ?><a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $whatsapp ) ); ?>" style="color:var(--primary);font-weight:600;">Message me on WhatsApp →</a><?php else : ?><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color:var(--primary);font-weight:600;">Contact me →</a><?php endif; ?>
			</div>
		</div>

		<div class="reveal">
			<div class="card">
				<h2 style="font-size:1.5rem;">Request your free audit</h2>
				<p style="color:var(--muted);font-size:.92rem;">I'll review your site and reply within 1 to 2 business days.</p>
				<?php
				$shortcode = avdesh_opt( 'avdesh_audit_shortcode', '' );
				if ( ! $shortcode ) {
					$shortcode = avdesh_opt( 'avdesh_form_shortcode', '' );
				}
				if ( $shortcode ) {
					echo do_shortcode( $shortcode );
				} else {
					// Built-in form: saves to Leads in the dashboard + emails you.
					avdesh_lead_form( 'audit', 'Get my free audit →' );
				}
				?>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">How it works</span>
			<h2 class="sec-title">Three simple steps</h2>
		</div>
		<div class="grid grid-3 steps reveal" style="margin-top:36px;">
			<div class="step"><div class="snum">1</div><h3>Submit your site</h3><p>Share your website and main goal using the form above.</p></div>
			<div class="step"><div class="snum">2</div><h3>I review it</h3><p>I analyse your technical health, rankings, content and AI visibility.</p></div>
			<div class="step"><div class="snum">3</div><h3>Get your plan</h3><p>You receive a clear, prioritized action plan, yours to keep.</p></div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
