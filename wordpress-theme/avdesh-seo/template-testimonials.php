<?php
/**
 * Template Name: Testimonials
 *
 * @package Avdesh_SEO
 */

get_header();

$tst = array(
	array( 'Avdesh transformed our organic traffic. We went from page three to the top three for our main keywords in under six months, and qualified leads followed.', 'S. Mehta', 'Founder, SaaS Startup', 'S' ),
	array( 'Professional, transparent and genuinely results-focused. Our eCommerce revenue from organic search more than doubled in a year.', 'A. Khan', 'Director, eCommerce Brand', 'A' ),
	array( 'The AI search work put us ahead of competitors. We now appear in AI answers where our rivals don\'t. Highly recommended.', 'M. Sharma', 'Marketing Lead, Agency', 'M' ),
	array( 'Our local visibility exploded. We rank #1 in the map pack and the phone hasn\'t stopped ringing since.', 'R. Verma', 'Owner, Local Service Business', 'R' ),
	array( 'Avdesh handled our site migration without losing a single ranking. Seamless, careful and clearly an expert.', 'J. Thomas', 'CTO, Tech Company', 'J' ),
	array( 'Clear reporting, honest advice and real ROI. The best SEO partner we have worked with, and we have tried a few.', 'P. Nair', 'CEO, B2B Services', 'P' ),
);
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Testimonials</span></nav>
		<span class="eyebrow">★★★★★ Client love</span>
		<h1>What Clients Say</h1>
		<p>Trusted by 500+ businesses worldwide. Replace these with your own client testimonials, names and results for maximum credibility.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php avdesh_testimonials_section( 'See what clients have to say' ); ?>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">More reviews</span>
			<h2 class="sec-title">Trusted by 500+ businesses</h2>
		</div>
		<div class="grid grid-3" style="margin-top:40px;">
			<?php foreach ( $tst as $t ) : ?>
				<div class="tcard reveal">
					<div class="stars">★★★★★</div>
					<blockquote>"<?php echo esc_html( $t[0] ); ?>"</blockquote>
					<div class="who"><span class="av"><?php echo esc_html( $t[3] ); ?></span><div><b><?php echo esc_html( $t[1] ); ?></b><span><?php echo esc_html( $t[2] ); ?></span></div></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="sec-head center reveal">
			<span class="eyebrow">Video reviews</span>
			<h2 class="sec-title">Hear it from clients</h2>
			<p class="sec-sub">Add video testimonials to build even stronger trust.</p>
		</div>
		<div class="grid grid-3 reveal" style="margin-top:36px;">
			<?php for ( $v = 1; $v <= 3; $v++ ) : ?>
				<div class="img-ph" style="min-height:200px;"><span class="badge">▶ Video testimonial <?php echo esc_html( $v ); ?></span></div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<?php avdesh_cta_band( 'Join 500+ happy clients', 'Book a free SEO audit and see why businesses worldwide trust Avdesh with their growth.' ); ?>
<?php get_footer(); ?>
