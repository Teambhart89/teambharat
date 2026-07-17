<?php
/**
 * Template Name: Service Page
 *
 * Renders a service page with H1 hero, SEO content and the booking form.
 *
 * @package epoojabooking
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="epb-page-hero">
		<div class="epb-container">
			<?php epb_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="epb-hero-sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
		<div class="epb-arch-divider" aria-hidden="true"></div>
	</section>

	<section class="epb-section">
		<div class="epb-container epb-service-layout">
			<div class="epb-service-content epb-prose">
				<?php the_content(); ?>
			</div>

			<aside class="epb-service-aside" aria-label="<?php esc_attr_e( 'Booking', 'epoojabooking' ); ?>">
				<div class="epb-booking-card">
					<h2 class="epb-booking-title"><?php esc_html_e( 'Book This Seva', 'epoojabooking' ); ?></h2>
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

	<section class="epb-section epb-cta-band">
		<div class="epb-container epb-cta-inner">
			<h2><?php esc_html_e( 'Have a Question Before Booking?', 'epoojabooking' ); ?></h2>
			<p><?php esc_html_e( 'Our devotee support team is happy to help you choose the right puja and muhurat.', 'epoojabooking' ); ?></p>
			<a class="epb-btn epb-btn-light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Support', 'epoojabooking' ); ?></a>
		</div>
	</section>
	<?php
endwhile;

get_footer();
