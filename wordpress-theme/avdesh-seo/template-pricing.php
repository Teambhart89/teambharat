<?php
/**
 * Template Name: Pricing
 *
 * @package Avdesh_SEO
 */

get_header();

$currency = avdesh_opt( 'avdesh_price_currency', '$' );
$plans = array(
	array(
		'name'  => 'Starter',
		'desc'  => 'For small businesses and local brands starting their SEO journey.',
		'price' => avdesh_opt( 'avdesh_price_1', '499' ),
		'unit'  => '/month',
		'feat'  => array( 'SEO audit & strategy', 'Keyword research', 'On-page optimization (up to 10 pages)', 'Google Business Profile setup', 'Monthly reporting', 'Email support' ),
		'featured' => false,
	),
	array(
		'name'  => 'Growth',
		'desc'  => 'For businesses ready to scale organic traffic and leads fast.',
		'price' => avdesh_opt( 'avdesh_price_2', '999' ),
		'unit'  => '/month',
		'feat'  => array( 'Everything in Starter', 'Technical SEO & Core Web Vitals', 'Content strategy & 4 articles/mo', 'White-hat link building', 'AI search optimization (GEO)', 'Priority support & monthly call' ),
		'featured' => true,
	),
	array(
		'name'  => 'Custom / Enterprise',
		'desc'  => 'For eCommerce, SaaS, international and high-competition projects.',
		'price' => 'Custom',
		'unit'  => 'quote',
		'feat'  => array( 'Fully tailored strategy', 'eCommerce / International SEO', 'Website migration support', 'Google Ads management', 'Dedicated consulting', 'Custom reporting dashboard' ),
		'featured' => false,
	),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Pricing</span></nav>
		<span class="eyebrow">Pricing &amp; packages</span>
		<h1>Simple, Transparent SEO Pricing</h1>
		<p>Flexible packages built around your goals. Prices are indicative starting points, every project is scoped to your needs. Edit these in the theme Customizer.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="price-grid">
			<?php foreach ( $plans as $p ) : ?>
				<div class="price-card reveal <?php echo $p['featured'] ? 'featured' : ''; ?>">
					<?php if ( $p['featured'] ) : ?><span class="ptag">Most popular</span><?php endif; ?>
					<h3><?php echo esc_html( $p['name'] ); ?></h3>
					<p class="pdesc"><?php echo esc_html( $p['desc'] ); ?></p>
					<div class="price">
						<?php if ( 'Custom' === $p['price'] ) : ?>
							Custom<small> quote</small>
						<?php else : ?>
							<?php echo esc_html( $currency . $p['price'] ); ?><small><?php echo esc_html( $p['unit'] ); ?></small>
						<?php endif; ?>
					</div>
					<ul>
						<?php foreach ( $p['feat'] as $f ) : ?><li><?php echo esc_html( $f ); ?></li><?php endforeach; ?>
					</ul>
					<a class="btn <?php echo $p['featured'] ? 'btn-primary' : 'btn-outline'; ?> btn-block" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>">Get started</a>
				</div>
			<?php endforeach; ?>
		</div>

		<p style="text-align:center;color:var(--muted);margin-top:30px;font-size:.9rem;">All plans are white-hat, transparent and cancellable. Need something different? <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color:var(--primary);font-weight:600;">Request a custom quote →</a></p>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Pricing FAQ</span>
			<h2 class="sec-title">Questions about pricing</h2>
		</div>
		<div class="faq reveal" style="margin-top:32px;">
			<details open><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">Do you offer one-time projects?</h3></summary><p>Yes. Alongside monthly retainers I offer one-time SEO audits, migrations and consulting. Book a free audit and I'll recommend the best fit.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">Are there any long-term contracts?</h3></summary><p>No lock-in. SEO works best with consistency, but you're free to adjust or pause with notice. I earn your business through results.</p></details>
			<details><summary><h3 style="display:inline;font-size:1.02rem;margin:0;font-family:var(--display);">Which currencies do you accept?</h3></summary><p>I work with international clients and can invoice in your preferred currency. Prices shown are indicative starting points.</p></details>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Not sure which plan fits?', 'Book a free SEO audit and I\'ll recommend the right package for your goals and budget.' ); ?>
<?php get_footer(); ?>
