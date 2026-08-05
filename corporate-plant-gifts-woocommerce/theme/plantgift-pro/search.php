<?php
/**
 * Search results.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="pg-page-header">
	<div class="pg-wrap">
		<h1>
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Results for %s', 'plantgift-pro' ), '&ldquo;' . esc_html( get_search_query() ) . '&rdquo;' );
			?>
		</h1>
		<div style="max-width:32rem;"><?php get_search_form(); ?></div>
	</div>
</div>

<div class="pg-wrap pg-section">
	<div class="pg-layout pg-layout--sidebar">
		<div>
			<?php if ( have_posts() ) : ?>
				<div class="pg-post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					?>
				</div>
				<?php plantgift_pro_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
