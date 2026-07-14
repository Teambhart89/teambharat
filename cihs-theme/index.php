<?php
/**
 * Main fallback template: blog index and generic listings.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php echo esc_html( is_home() ? cihs_page_title() : cihs_page_title() ); ?></h1>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container cihs-with-sidebar">
		<div>
			<?php if ( have_posts() ) : ?>
				<div class="cihs-archive-grid" style="grid-template-columns: repeat(2, 1fr);">
					<?php
					while ( have_posts() ) {
						the_post();
						cihs_render_card();
					}
					?>
				</div>
				<div class="pagination"><?php the_posts_pagination(); ?></div>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing found here yet.', 'cihs' ); ?></p>
				<?php get_search_form(); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>

<?php
get_footer();
