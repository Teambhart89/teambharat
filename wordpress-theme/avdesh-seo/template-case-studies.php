<?php
/**
 * Template Name: Case Studies
 *
 * @package Avdesh_SEO
 */

get_header();

$cases = array(
	array(
		'title'   => 'SaaS Startup: 312% Organic Growth in 12 Months',
		'tag'     => 'SaaS • SEO + Content',
		'challenge' => 'A B2B SaaS startup was stuck on page three for its core keywords with flat organic growth and a heavy reliance on paid ads.',
		'strategy'  => 'Technical fixes, a topic-cluster content strategy, on-page optimization and white-hat link building, aligned to buyer intent.',
		'result'    => 'Organic sessions grew 312%, 250+ keywords reached page one and cost per lead dropped as organic replaced paid.',
		'metrics' => array( '+312% traffic', '250+ page-1 keywords', '-38% CPL' ),
	),
	array(
		'title'   => 'eCommerce Brand: Doubled Revenue from Search',
		'tag'     => 'Shopify • eCommerce SEO',
		'challenge' => 'A Shopify store had thin product pages, duplicate content and low visibility for high-intent shopping terms.',
		'strategy'  => 'Collection and product optimization, product schema, technical clean-up and buying-guide content.',
		'result'    => 'Organic revenue more than doubled with a 2.4x return, while dependence on paid ads fell.',
		'metrics' => array( '+150% revenue', '2.4x ROAS', '300+ products optimized' ),
	),
	array(
		'title'   => 'Local Business: #1 in the Map Pack',
		'tag'     => 'Local • GBP + Reviews',
		'challenge' => 'A multi-location service business was invisible in local search and losing calls to competitors.',
		'strategy'  => 'Google Business Profile optimization, local citations, review generation and location pages.',
		'result'    => 'Ranked #1 in the map pack across service areas, with a 5x increase in calls from search.',
		'metrics' => array( 'Map pack #1', '5x calls', '4.9★ reviews' ),
	),
	array(
		'title'   => 'Agency Client: Visible in AI Search',
		'tag'     => 'GEO • AI Search Optimization',
		'challenge' => 'A brand was absent from AI answers while competitors were being recommended by ChatGPT and Perplexity.',
		'strategy'  => 'Answer-ready content structure, entity building, schema and citation growth for generative engines.',
		'result'    => 'Now cited across major AI platforms for priority questions, growing share of AI-driven visibility.',
		'metrics' => array( 'AI cited', '+40% answer share', 'FAQ rich results' ),
	),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Case Studies</span></nav>
		<span class="eyebrow">Case studies</span>
		<h1>SEO Case Studies &amp; Client Wins</h1>
		<p>Real challenges, clear strategies and measurable outcomes. Replace these examples with your own projects, screenshots and numbers.</p>
	</div>
</section>

<section class="section">
	<div class="container" style="display:grid;gap:30px;">
		<?php foreach ( $cases as $c ) : ?>
			<article class="card reveal" style="padding:0;overflow:hidden;">
				<div class="two-col" style="grid-template-columns:.8fr 1.2fr;gap:0;align-items:stretch;">
					<div class="img-ph" style="border-radius:0;border:0;min-height:280px;"><span class="badge">📷 Result screenshot</span></div>
					<div style="padding:34px;">
						<span class="cs-tag" style="position:static;display:inline-block;margin-bottom:14px;"><?php echo esc_html( $c['tag'] ); ?></span>
						<h2 style="font-size:1.55rem;margin-bottom:16px;"><?php echo esc_html( $c['title'] ); ?></h2>
						<h3 style="font-size:.92rem;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Challenge</h3>
						<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $c['challenge'] ); ?></p>
						<h3 style="font-size:.92rem;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;margin:14px 0 4px;">Strategy</h3>
						<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $c['strategy'] ); ?></p>
						<h3 style="font-size:.92rem;color:var(--accent-d);text-transform:uppercase;letter-spacing:.08em;margin:14px 0 4px;">Result</h3>
						<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $c['result'] ); ?></p>
						<div class="cs-metrics" style="margin-top:16px;"><?php foreach ( $c['metrics'] as $m ) : ?><span><?php echo esc_html( $m ); ?></span><?php endforeach; ?></div>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<?php avdesh_cta_band( 'Ready to be the next success story?', 'Book a free SEO audit and I\'ll show you the fastest path to results for your business.' ); ?>
<?php get_footer(); ?>
