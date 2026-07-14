<?php
/**
 * Search results template.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php echo esc_html( cihs_page_title() ); ?></h1>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container">
		<?php if ( have_posts() ) : ?>
			<div class="cihs-archive-grid">
				<?php
				while ( have_posts() ) {
					the_post();
					cihs_render_card();
				}
				?>
			</div>
			<div class="pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing matched your search. Try different keywords.', 'cihs' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
