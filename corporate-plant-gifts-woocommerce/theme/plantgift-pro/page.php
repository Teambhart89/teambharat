<?php
/**
 * Default page template.
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
				</figure>
			<?php endif; ?>

			<div class="pg-layout pg-layout--sidebar">
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
				<aside class="pg-page-aside">
					<div class="pg-toc" data-pg-toc data-pg-toc-scope=".pg-entry">
						<h2><?php esc_html_e( 'On this page', 'plantgift-pro' ); ?></h2>
					</div>
					<div class="widget">
						<h2 class="widget-title"><?php esc_html_e( 'Need help choosing?', 'plantgift-pro' ); ?></h2>
						<p class="pg-small"><?php esc_html_e( 'Tell us the headcount, budget per gift and the delivery city. We will send a shortlist with photos.', 'plantgift-pro' ); ?></p>
						<a class="pg-btn pg-btn--block" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask the gifting desk', 'plantgift-pro' ); ?></a>
					</div>
				</aside>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
