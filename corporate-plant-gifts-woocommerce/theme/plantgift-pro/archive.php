<?php
/**
 * Blog archives: category, tag, author, date.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="pg-page-header">
	<div class="pg-wrap">
		<h1><?php the_archive_title(); ?></h1>
		<?php
		$description = get_the_archive_description();
		if ( $description ) :
			?>
			<div class="pg-lede"><?php echo wp_kses_post( $description ); ?></div>
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
