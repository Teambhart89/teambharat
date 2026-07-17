<?php
/**
 * Banner slider template part.
 *
 * Usage: get_template_part( 'template-parts/banner-slider', null, array( 'compact' => true ) );
 *
 * @package epoojabooking
 */

$epb_part_banners = post_type_exists( 'epb_banner' ) ? get_posts( array(
	'post_type'      => 'epb_banner',
	'posts_per_page' => 5,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) ) : array();

if ( ! $epb_part_banners ) {
	return;
}

$epb_compact = ! empty( $args['compact'] );
?>
<section class="epb-slider<?php echo $epb_compact ? ' epb-slider-compact' : ''; ?>" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Featured services', 'epoojabooking' ); ?>">
	<?php
	$epb_i = 0;
	foreach ( $epb_part_banners as $epb_banner ) :
		$epb_i++;
		$epb_sub  = get_post_meta( $epb_banner->ID, 'epb_subtitle', true );
		$epb_btnt = get_post_meta( $epb_banner->ID, 'epb_btn_text', true );
		$epb_btnu = get_post_meta( $epb_banner->ID, 'epb_btn_url', true );
		$epb_img  = get_the_post_thumbnail_url( $epb_banner, 'full' );
		?>
		<div class="epb-slide<?php echo 1 === $epb_i ? ' is-active' : ''; ?>"<?php echo $epb_img ? ' style="background-image:url(' . esc_url( $epb_img ) . ')"' : ''; ?> role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( $epb_i . ' / ' . count( $epb_part_banners ) ); ?>"<?php echo 1 === $epb_i ? '' : ' aria-hidden="true"'; ?>>
			<div class="epb-slide-overlay" aria-hidden="true"></div>
			<div class="epb-container epb-slide-inner">
				<p class="epb-slide-title"><?php echo esc_html( get_the_title( $epb_banner ) ); ?></p>
				<?php if ( $epb_sub && ! $epb_compact ) : ?>
					<p class="epb-slide-sub"><?php echo esc_html( $epb_sub ); ?></p>
				<?php endif; ?>
				<?php if ( $epb_btnt && $epb_btnu ) : ?>
					<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( $epb_btnu ) ); ?>"><?php echo esc_html( $epb_btnt ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>

	<?php if ( count( $epb_part_banners ) > 1 ) : ?>
		<button class="epb-slider-arrow epb-slider-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'epoojabooking' ); ?>">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M15 5l-7 7 7 7"/></svg>
		</button>
		<button class="epb-slider-arrow epb-slider-next" aria-label="<?php esc_attr_e( 'Next slide', 'epoojabooking' ); ?>">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M9 5l7 7-7 7"/></svg>
		</button>
		<div class="epb-slider-dots" role="tablist" aria-label="<?php esc_attr_e( 'Choose slide', 'epoojabooking' ); ?>">
			<?php for ( $epb_d = 0; $epb_d < count( $epb_part_banners ); $epb_d++ ) : ?>
				<button class="epb-slider-dot<?php echo 0 === $epb_d ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr( $epb_d ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number. */ __( 'Go to slide %d', 'epoojabooking' ), $epb_d + 1 ) ); ?>"></button>
			<?php endfor; ?>
		</div>
	<?php endif; ?>
</section>
