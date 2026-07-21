<?php
/**
 * Single post template.
 *
 * @package Avdesh_SEO
 */
get_header(); ?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<h1><?php the_title(); ?></h1>
		<p class="lead"><?php echo esc_html( get_the_date() ); ?></p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<article class="prose mx-auto">
			<?php
			while ( have_posts() ) :
				the_post();
				if ( has_post_thumbnail() ) {
					echo '<div style="border-radius:18px;overflow:hidden;margin-bottom:28px;">';
					the_post_thumbnail( 'large' );
					echo '</div>';
				}
				the_content();
			endwhile;
			?>
		</article>
	</div>
</section>

<?php avseo_cta_band(); ?>
<?php get_footer(); ?>
