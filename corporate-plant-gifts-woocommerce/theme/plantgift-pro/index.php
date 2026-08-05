<?php
/**
 * Fallback template used for the blog index and any query without a closer match.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="pg-page-header">
	<div class="pg-wrap">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<h1><?php echo esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) ); ?></h1>
			<?php
			$blog_id   = (int) get_option( 'page_for_posts' );
			$blog_page = $blog_id ? get_post( $blog_id ) : null;
			if ( $blog_page && $blog_page->post_excerpt ) :
				?>
				<p class="pg-lede"><?php echo esc_html( $blog_page->post_excerpt ); ?></p>
			<?php endif; ?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Plant gifting journal', 'plantgift-pro' ); ?></h1>
		<?php endif; ?>
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
