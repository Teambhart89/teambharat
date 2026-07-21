<?php
/**
 * Template Name: Industries Served
 *
 * @package Avdesh_SEO
 */

get_header();

$industries = array(
	array( '🛒', 'eCommerce & Retail', 'Product and collection SEO, schema and buying-guide content that grow store revenue on Shopify, WooCommerce and more.' ),
	array( '💻', 'SaaS & Technology', 'Topic authority, technical SEO and content strategy to lower CAC and grow product-led organic pipelines.' ),
	array( '🏥', 'Healthcare & Clinics', 'Trustworthy, compliant content and local SEO that bring in patients from search.' ),
	array( '🏘️', 'Real Estate', 'Local and long-tail SEO that captures high-intent buyer and seller searches.' ),
	array( '⚖️', 'Legal & Finance', 'Authoritative content and technical SEO for competitive, high-value keywords.' ),
	array( '🏨', 'Travel & Hospitality', 'Destination and booking-intent SEO that fills calendars year round.' ),
	array( '🎓', 'Education & Coaching', 'Content and course SEO that grow enrolments and organic reach.' ),
	array( '🔧', 'Local & Home Services', 'Google Business Profile, reviews and local pages that win the map pack.' ),
	array( '🏭', 'B2B & Manufacturing', 'Technical and long-tail SEO that generate qualified B2B enquiries.' ),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Industries</span></nav>
		<span class="eyebrow">Industries served</span>
		<h1>SEO Expertise Across Industries</h1>
		<p>From startups and local businesses to eCommerce, SaaS and international brands, I tailor SEO strategy to the realities of each industry.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="grid grid-3">
			<?php foreach ( $industries as $ind ) : ?>
				<div class="card reveal">
					<div class="ic" style="width:58px;height:58px;border-radius:16px;background:var(--grad-soft);color:var(--primary);display:grid;place-items:center;font-size:1.6rem;margin-bottom:16px;"><?php echo esc_html( $ind[0] ); ?></div>
					<h3 style="margin-bottom:8px;"><?php echo esc_html( $ind[1] ); ?></h3>
					<p style="color:var(--muted);font-size:.94rem;"><?php echo esc_html( $ind[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Not sure if I work with your industry?', 'I almost certainly do. Book a free SEO audit and let\'s talk about your specific market.' ); ?>
<?php get_footer(); ?>
