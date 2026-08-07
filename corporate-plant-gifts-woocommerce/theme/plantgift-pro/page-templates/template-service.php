<?php
/**
 * Template Name: Service Page
 * Template Post Type: page
 *
 * Long form layout for the gifting service pages. It prints a hero, an auto
 * generated table of contents, the page body, a related category strip and the
 * FAQ block stored by the companion plugin.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$pg_id        = get_the_ID();
	$pg_eyebrow   = get_post_meta( $pg_id, '_pg_eyebrow', true );
	$pg_faqs      = get_post_meta( $pg_id, '_pg_faqs', true );
	$pg_highlight = get_post_meta( $pg_id, '_pg_highlights', true );
	$pg_cat_slugs = get_post_meta( $pg_id, '_pg_related_cats', true );
	?>

	<div class="pg-page-header">
		<div class="pg-wrap">
			<?php if ( $pg_eyebrow ) : ?>
				<p class="pg-eyebrow"><?php echo esc_html( $pg_eyebrow ); ?></p>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="pg-lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="pg-btn-row pg-mt-2">
				<a class="pg-btn pg-btn--action" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php plantgift_pro_the_icon( 'gift', 18 ); ?>
					<?php esc_html_e( 'Request a quote', 'plantgift-pro' ); ?>
				</a>
				<a class="pg-btn pg-btn--ghost" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Browse plant gifts', 'plantgift-pro' ); ?></a>
				<span class="pg-btn-note">
					<?php plantgift_pro_the_icon( 'clock', 15 ); ?>
					<?php esc_html_e( 'Reply within one working day', 'plantgift-pro' ); ?>
				</span>
			</div>
		</div>
	</div>

	<?php if ( is_array( $pg_highlight ) && $pg_highlight ) : ?>
		<div class="pg-marquee">
			<div class="pg-wrap pg-marquee__inner">
				<?php foreach ( array_slice( $pg_highlight, 0, 4 ) as $pg_point ) : ?>
					<span><?php plantgift_pro_the_icon( 'check', 16 ); ?><?php echo esc_html( $pg_point ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<article id="post-<?php echo esc_attr( $pg_id ); ?>" <?php post_class( 'pg-section' ); ?>>
		<div class="pg-wrap">
			<div class="pg-layout pg-layout--sidebar">

				<div>
					<div class="pg-toc" data-pg-toc data-pg-toc-scope=".pg-entry">
						<h2><?php esc_html_e( 'On this page', 'plantgift-pro' ); ?></h2>
					</div>

					<div class="pg-entry">
						<?php the_content(); ?>
					</div>

					<?php if ( is_array( $pg_faqs ) && $pg_faqs ) : ?>
						<section class="pg-mt-2" aria-labelledby="faqs" style="margin-top:3rem;">
							<?php
							plantgift_pro_faq_list( $pg_faqs, __( 'Frequently asked questions', 'plantgift-pro' ), 'h2' );
							if ( function_exists( 'plantgift_core_faq_schema' ) ) {
								plantgift_core_faq_schema( $pg_faqs );
							}
							?>
						</section>
					<?php endif; ?>
				</div>

				<aside class="pg-page-aside">
					<div class="widget widget--quote">
						<h2 class="widget-title"><?php esc_html_e( 'Talk to the gifting desk', 'plantgift-pro' ); ?></h2>
						<p class="pg-small"><?php esc_html_e( 'Send your headcount, budget per gift and delivery cities. We reply with a shortlist and a branded mockup within one working day.', 'plantgift-pro' ); ?></p>
						<a class="pg-btn pg-btn--action pg-btn--block" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get a quote', 'plantgift-pro' ); ?></a>
						<?php $pg_phone = get_theme_mod( 'plantgift_phone', '' ); ?>
						<?php if ( $pg_phone ) : ?>
							<p class="pg-small pg-mt-2 pg-mb-0"><?php esc_html_e( 'Or call', 'plantgift-pro' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $pg_phone ) ); ?>"><?php echo esc_html( $pg_phone ); ?></a></p>
						<?php endif; ?>
					</div>

					<?php
					if ( is_array( $pg_cat_slugs ) && $pg_cat_slugs && taxonomy_exists( 'product_cat' ) ) :
						$pg_rel_terms = get_terms(
							array(
								'taxonomy'   => 'product_cat',
								'slug'       => $pg_cat_slugs,
								'hide_empty' => false,
							)
						);
						if ( $pg_rel_terms && ! is_wp_error( $pg_rel_terms ) ) :
							?>
							<div class="widget">
								<h2 class="widget-title"><?php esc_html_e( 'Shop this service', 'plantgift-pro' ); ?></h2>
								<ul>
									<?php foreach ( $pg_rel_terms as $pg_rel_term ) : ?>
										<li><a href="<?php echo esc_url( get_term_link( $pg_rel_term ) ); ?>"><?php echo esc_html( $pg_rel_term->name ); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<?php
						endif;
					endif;
					?>

					<div class="widget">
						<h2 class="widget-title"><?php esc_html_e( 'Other gifting services', 'plantgift-pro' ); ?></h2>
						<ul>
							<?php
							$pg_siblings = get_posts(
								array(
									'post_type'      => 'page',
									'posts_per_page' => 8,
									'post__not_in'   => array( $pg_id ),
									'meta_key'       => '_wp_page_template',
									'meta_value'     => 'page-templates/template-service.php',
									'orderby'        => 'menu_order title',
									'order'          => 'ASC',
								)
							);
							foreach ( $pg_siblings as $pg_sibling ) {
								printf(
									'<li><a href="%s">%s</a></li>',
									esc_url( get_permalink( $pg_sibling ) ),
									esc_html( get_the_title( $pg_sibling ) )
								);
							}
							?>
						</ul>
					</div>
				</aside>

			</div>
		</div>
	</article>

	<section class="pg-section pg-section--tight">
		<div class="pg-wrap">
			<div class="pg-cta">
				<h2><?php esc_html_e( 'Get a plant gifting plan for your next round', 'plantgift-pro' ); ?></h2>
				<p><?php esc_html_e( 'One brief is enough. We handle the sourcing, the branding, the packing and the delivery tracking so your team only signs off on the design.', 'plantgift-pro' ); ?></p>
				<div class="pg-btn-row">
					<a class="pg-btn pg-btn--action pg-btn--lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Start the conversation', 'plantgift-pro' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
