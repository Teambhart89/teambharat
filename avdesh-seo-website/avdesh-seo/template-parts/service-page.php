<?php
/**
 * Shared service page layout.
 *
 * The design chrome (hero, sidebar, CTA) lives here, while the H1 comes from
 * the page title and the body comes from the page content, so everything is
 * editable from Pages in the WordPress dashboard without touching code.
 *
 * @package Avdesh_SEO
 */
while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero">
		<div class="container">
			<?php avseo_breadcrumbs(); ?>
			<span class="eyebrow">Services</span>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="bg-cream">
		<div class="container">
			<div class="content-cols">
				<div class="prose entry-content">
					<?php the_content(); ?>
				</div>
				<?php get_template_part( 'template-parts/service-sidebar' ); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;

avseo_cta_band();
