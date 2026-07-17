<?php
/**
 * Single temple page: photo gallery, overview sections, timings, booking CTA.
 *
 * Images: set a Featured Image for the main photo; any other images
 * uploaded (attached) to this temple appear automatically in the gallery.
 *
 * @package epoojabooking
 */

get_header();

while ( have_posts() ) :
	the_post();

	$epb_city    = get_post_meta( get_the_ID(), 'epb_city', true );
	$epb_state   = get_post_meta( get_the_ID(), 'epb_state', true );
	$epb_deity   = get_post_meta( get_the_ID(), 'epb_deity', true );
	$epb_darshan = get_post_meta( get_the_ID(), 'epb_darshan_timings', true );
	$epb_aarti   = get_post_meta( get_the_ID(), 'epb_aarti_timings', true );

	$epb_gallery = get_attached_media( 'image', get_the_ID() );
	$epb_thumb   = get_post_thumbnail_id();
	?>

	<section class="epb-temple-media">
		<div class="epb-container">
			<div class="epb-temple-gallery">
				<div class="epb-gallery-main">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
					<?php else : ?>
						<span class="epb-thumb-placeholder epb-thumb-placeholder-lg" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="72" height="72" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" aria-hidden="true" focusable="false"><path d="M12 2l1 3h-2l1-3Z"/><path d="M12 5v3"/><path d="M6 11c0-2 2.5-3.5 6-3.5s6 1.5 6 3.5"/><path d="M5 11h14"/><path d="M6 11v9"/><path d="M18 11v9"/><path d="M10 20v-5a2 2 0 0 1 4 0v5"/><path d="M4 20h16"/></svg>
							<span class="epb-placeholder-note"><?php esc_html_e( 'Add a featured image for this temple', 'epoojabooking' ); ?></span>
						</span>
					<?php endif; ?>
				</div>
				<?php
				$epb_side = 0;
				foreach ( $epb_gallery as $epb_img ) {
					if ( (int) $epb_img->ID === (int) $epb_thumb || $epb_side >= 4 ) {
						continue;
					}
					$epb_side++;
					echo '<div class="epb-gallery-item">' . wp_get_attachment_image( $epb_img->ID, 'medium_large', false, array( 'loading' => 'lazy' ) ) . '</div>';
				}
				?>
			</div>
		</div>
	</section>

	<section class="epb-temple-intro">
		<div class="epb-container epb-temple-intro-inner">
			<?php epb_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<p class="epb-temple-location">
				<?php echo esc_html( trim( $epb_city . ', ' . $epb_state, ', ' ) ); ?>
				<?php if ( $epb_deity ) : ?>
					&middot; <?php echo esc_html( $epb_deity ); ?>
				<?php endif; ?>
			</p>
			<div class="epb-temple-actions">
				<a class="epb-btn epb-btn-primary" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Book Puja at This Temple', 'epoojabooking' ); ?></a>
				<a class="epb-btn epb-btn-ghost" href="<?php echo esc_url( home_url( '/online-chadhava-offering/' ) ); ?>"><?php esc_html_e( 'Offer Chadhava', 'epoojabooking' ); ?></a>
			</div>
		</div>
	</section>

	<section class="epb-section">
		<div class="epb-container epb-narrow">
			<div class="epb-prose">
				<?php the_content(); ?>
			</div>

			<?php if ( $epb_darshan || $epb_aarti ) : ?>
				<h2 class="epb-timings-heading"><?php esc_html_e( 'Temple Timings', 'epoojabooking' ); ?></h2>
				<div class="epb-timings-grid">
					<?php if ( $epb_darshan ) : ?>
						<div class="epb-timing-card">
							<span class="epb-card-icon" aria-hidden="true"><?php epb_the_icon( 'bell' ); ?></span>
							<h3><?php esc_html_e( 'Darshan Timings', 'epoojabooking' ); ?></h3>
							<p><?php echo esc_html( $epb_darshan ); ?></p>
						</div>
					<?php endif; ?>
					<?php if ( $epb_aarti ) : ?>
						<div class="epb-timing-card">
							<span class="epb-card-icon" aria-hidden="true"><?php epb_the_icon( 'flame' ); ?></span>
							<h3><?php esc_html_e( 'Aarti Timings', 'epoojabooking' ); ?></h3>
							<p><?php echo esc_html( $epb_aarti ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				<p class="epb-timings-note"><?php esc_html_e( 'Timings can change on festival days and special occasions. Please verify with the temple before planning your visit.', 'epoojabooking' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="epb-section epb-cta-band">
		<div class="epb-container epb-cta-inner">
			<h2><?php esc_html_e( 'Wish to Offer a Puja Here?', 'epoojabooking' ); ?></h2>
			<p><?php esc_html_e( 'Our verified pandits perform pujas and offerings in your name, with sankalp, video proof and prasad delivery to your home.', 'epoojabooking' ); ?></p>
			<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Book Your Puja', 'epoojabooking' ); ?></a>
		</div>
	</section>

	<?php
endwhile;

get_footer();
