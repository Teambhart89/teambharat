<?php
/**
 * Fallback template for posts and pages.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>

<main id="main" class="page" tabindex="-1">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'card content-card' ); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<section class="card content-card">
			<h1><?php esc_html_e( 'Nothing here yet', 'saltstayz' ); ?></h1>
			<p><?php esc_html_e( 'Head back to the home page to book a stay.', 'saltstayz' ); ?></p>
			<p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'saltstayz' ); ?></a></p>
		</section>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
