<?php
/**
 * Generic fallback template.
 *
 * @package krishna-taxnova
 */

get_header();
?>

<div class="wrap ktn-page">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'ktn-entry' ); ?>>
				<h2 class="ktn-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="ktn-entry-summary"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		<div class="ktn-pagination"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<h1><?php esc_html_e( 'Nothing found', 'krishna-taxnova' ); ?></h1>
		<p><?php esc_html_e( 'Try searching for a service, or browse all services from the menu.', 'krishna-taxnova' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
