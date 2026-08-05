<?php
/**
 * Single blog post.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="pg-page-header">
		<div class="pg-wrap">
			<h1><?php the_title(); ?></h1>
			<?php plantgift_pro_entry_meta(); ?>
			<?php if ( has_excerpt() ) : ?>
				<p class="pg-lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'pg-section' ); ?>>
		<div class="pg-wrap">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="pg-split__media pg-mb-2" style="aspect-ratio:16/7;">
					<?php the_post_thumbnail( 'plantgift-wide', array( 'fetchpriority' => 'high' ) ); ?>
					<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
						<figcaption class="pg-small pg-muted"><?php echo esc_html( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<div class="pg-layout pg-layout--sidebar">
				<div>
					<div class="pg-toc" data-pg-toc data-pg-toc-scope=".pg-entry">
						<h2><?php esc_html_e( 'What this guide covers', 'plantgift-pro' ); ?></h2>
					</div>

					<div class="pg-entry">
						<?php
						the_content();
						wp_link_pages(
							array(
								'before' => '<nav class="pg-pagination">',
								'after'  => '</nav>',
							)
						);
						?>
					</div>

					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="pg-author-box">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?>
							<div>
								<h2 style="font-size:var(--pg-step-1);margin-bottom:0.3rem;"><?php echo esc_html( get_the_author() ); ?></h2>
								<p class="pg-mb-0 pg-small"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
							</div>
						</div>
					<?php endif; ?>

					<nav class="pg-btn-row pg-mt-2" aria-label="<?php esc_attr_e( 'Post navigation', 'plantgift-pro' ); ?>">
						<?php
						$prev = get_previous_post();
						$next = get_next_post();
						if ( $prev ) {
							printf( '<a class="pg-btn pg-btn--ghost" href="%s">%s</a>', esc_url( get_permalink( $prev ) ), esc_html__( 'Previous article', 'plantgift-pro' ) );
						}
						if ( $next ) {
							printf( '<a class="pg-btn pg-btn--ghost" href="%s">%s</a>', esc_url( get_permalink( $next ) ), esc_html__( 'Next article', 'plantgift-pro' ) );
						}
						?>
					</nav>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
