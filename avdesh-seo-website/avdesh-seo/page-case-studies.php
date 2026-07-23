<?php
/**
 * Case Studies page template (slug: case-studies).
 * Metrics come from the Customizer; images from the Images section; the intro
 * and closing copy are editable in Pages.
 *
 * @package Avdesh_SEO
 */
get_header();
while ( have_posts() ) :
	the_post();
	?>

	<section class="page-hero">
		<div class="container">
			<?php avseo_breadcrumbs(); ?>
			<span class="eyebrow">Case Studies</span>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Headline metrics -->
	<section class="stats-bar" style="padding:0;">
		<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<div class="stat">
					<span class="snum"><?php echo esc_html( avseo_opt( "case_metric_{$i}_num", '' ) ); ?></span>
					<span class="slabel"><?php echo esc_html( avseo_opt( "case_metric_{$i}_label", '' ) ); ?></span>
				</div>
			<?php endfor; ?>
		</div>
	</section>

	<!-- Case study cards -->
	<section class="bg-cream">
		<div class="container">
			<?php avseo_section_title( 'featured work', 'A snapshot of projects across different industries and SEO goals.' ); ?>
			<div class="grid-4">
				<?php
				$cases = array(
					array( 'img_case_1', 'Project One', 'Organic Growth', 'SEO Strategy &amp; Content' ),
					array( 'img_case_2', 'Project Two', 'Local SEO', 'Google Business Profile' ),
					array( 'img_case_3', 'Project Three', 'eCommerce SEO', 'Shopify &amp; WooCommerce' ),
					array( 'img_case_4', 'Project Four', 'AI Search', 'GEO &amp; Content' ),
				);
				foreach ( $cases as $c ) : ?>
					<div class="case-card">
						<?php avseo_image_slot( $c[0], $c[1], $c[2], '', '600 x 400 px' ); ?>
						<div class="case-card-body">
							<span class="case-tag"><?php echo wp_kses_post( $c[2] ); ?></span>
							<h3><?php echo esc_html( $c[1] ); ?></h3>
							<p><?php echo wp_kses_post( $c[3] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="center" style="color:var(--muted);margin-top:22px;font-size:.9rem;">
				Replace these images and labels: pictures in Appearance &rarr; Customize &rarr; Images, metrics in Case Study Metrics.
			</p>
		</div>
	</section>

	<?php if ( trim( get_the_content() ) ) : ?>
	<section class="bg-white">
		<div class="container">
			<div class="prose entry-content mx-auto">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php
endwhile;
avseo_cta_band();
get_footer();
