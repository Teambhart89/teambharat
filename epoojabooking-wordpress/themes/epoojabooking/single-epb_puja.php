<?php
/**
 * Single special puja: details, thumbnail, meta and booking form.
 *
 * @package epoojabooking
 */

get_header();

while ( have_posts() ) :
	the_post();

	$epb_badge  = get_post_meta( get_the_ID(), 'epb_badge', true );
	$epb_temple = get_post_meta( get_the_ID(), 'epb_temple_name', true );
	$epb_date   = get_post_meta( get_the_ID(), 'epb_event_date', true );
	$epb_price  = get_post_meta( get_the_ID(), 'epb_price', true );
	?>

	<section class="epb-page-hero">
		<div class="epb-container">
			<?php epb_breadcrumbs(); ?>
			<?php if ( $epb_badge ) : ?>
				<span class="epb-badge"><?php echo esc_html( $epb_badge ); ?></span>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="epb-hero-sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<ul class="epb-puja-meta epb-puja-meta-hero">
				<?php if ( $epb_temple ) : ?>
					<li><?php epb_the_icon( 'bell' ); ?> <span><?php echo esc_html( $epb_temple ); ?></span></li>
				<?php endif; ?>
				<?php if ( $epb_date ) : ?>
					<li><?php epb_the_icon( 'calendar' ); ?> <span><?php echo esc_html( $epb_date ); ?></span></li>
				<?php endif; ?>
				<?php if ( $epb_price ) : ?>
					<li><?php epb_the_icon( 'lotus' ); ?> <span><?php echo esc_html( sprintf( /* translators: %s: price. */ __( 'Seva from %s', 'epoojabooking' ), $epb_price ) ); ?></span></li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="epb-arch-divider" aria-hidden="true"></div>
	</section>

	<section class="epb-section">
		<div class="epb-container epb-service-layout">
			<div class="epb-service-content">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="epb-post-thumb">
						<?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
					</figure>
				<?php endif; ?>
				<div class="epb-prose">
					<?php the_content(); ?>
				</div>
			</div>

			<aside class="epb-service-aside" aria-label="<?php esc_attr_e( 'Booking', 'epoojabooking' ); ?>">
				<div class="epb-booking-card">
					<h2 class="epb-booking-title"><?php esc_html_e( 'Participate in This Puja', 'epoojabooking' ); ?></h2>
					<?php
					if ( shortcode_exists( 'epb_booking_form' ) ) {
						echo do_shortcode( '[epb_booking_form]' );
					} else {
						echo '<p>' . esc_html__( 'Activate the ePoojaBooking Core plugin to enable the booking form.', 'epoojabooking' ) . '</p>';
					}
					?>
				</div>
			</aside>
		</div>
	</section>

	<?php
endwhile;

get_footer();
