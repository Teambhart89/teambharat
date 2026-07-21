<?php
/**
 * Template Name: FAQs
 *
 * The FAQ list here is also used to output FAQPage schema (see inc/seo-schema.php).
 *
 * @package Avdesh_SEO
 */

get_header();

$faqs = avdesh_faq_list();
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>FAQs</span></nav>
		<span class="eyebrow">FAQ</span>
		<h1>Frequently Asked Questions</h1>
		<p>Everything you might want to know about working with me on SEO, AI search, GEO and Google Ads.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php avdesh_faq_grid( $faqs ); ?>
	</div>
</section>

<?php avdesh_cta_band( 'Still have questions?', 'Book a free SEO audit or send me a message and I\'ll answer everything, no obligation.' ); ?>
<?php get_footer(); ?>
