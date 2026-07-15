<?php
/**
 * Standard page template.
 *
 * @package krishna-taxnova
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<header class="ktn-service-hero">
		<div class="wrap">
			<h1><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="wrap ktn-page ktn-narrow">
		<article <?php post_class( 'ktn-entry' ); ?>>
			<?php the_content(); ?>
		</article>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
