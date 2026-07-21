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
		<div class="faq reveal">
			<?php foreach ( $faqs as $i => $f ) : ?>
				<details <?php echo 0 === $i ? 'open' : ''; ?>>
					<summary><h2 style="display:inline;font-size:1.05rem;margin:0;font-family:var(--display);"><?php echo esc_html( $f['q'] ); ?></h2></summary>
					<p><?php echo esc_html( $f['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Still have questions?', 'Book a free SEO audit or send me a message and I\'ll answer everything, no obligation.' ); ?>
<?php get_footer(); ?>
