<?php
/**
 * Generic page fallback (used for any page without a dedicated template).
 *
 * @package Avdesh_SEO
 */
get_header(); ?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<div class="prose mx-auto">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
