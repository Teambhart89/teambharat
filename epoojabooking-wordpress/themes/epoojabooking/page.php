<?php
/**
 * Default page template.
 *
 * @package epoojabooking
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="epb-page-hero">
		<div class="epb-container">
			<?php epb_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="epb-hero-sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
		<div class="epb-arch-divider" aria-hidden="true"></div>
	</section>

	<section class="epb-section">
		<div class="epb-container epb-narrow">
			<div class="epb-prose">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
