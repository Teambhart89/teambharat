<?php
/**
 * Front page: hero, services, plans, booking, FAQs and areas.
 *
 * @package Rajdhani_Nursery
 */

get_header();
$booking_url = home_url( '/book-maali-online/' );
?>

<section class="rn-hero">
	<div class="rn-container">
		<h1><?php esc_html_e( 'Mali On Rent in Delhi. Book Your Maali Online in 2 Minutes', 'rajdhani-nursery' ); ?></h1>
		<p><?php esc_html_e( 'Rajdhani Nursery sends verified, experienced gardeners to your doorstep across Delhi NCR. Book for 1 hour, 2 hours, 4 hours, 6 hours or a full day. Pick your date and time online, and we handle the rest.', 'rajdhani-nursery' ); ?></p>
		<div class="rn-hero-actions">
			<a class="rn-btn rn-btn-amber" href="<?php echo esc_url( $booking_url ); ?>"><?php esc_html_e( 'Book Maali Online', 'rajdhani-nursery' ); ?></a>
			<a class="rn-btn rn-btn-wa" href="<?php echo esc_url( rn_whatsapp_link() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp Us', 'rajdhani-nursery' ); ?></a>
		</div>
		<div class="rn-hero-badges">
			<span>✅ <?php esc_html_e( 'Verified Gardeners', 'rajdhani-nursery' ); ?></span>
			<span>🌿 <?php esc_html_e( 'Own Plant Nursery', 'rajdhani-nursery' ); ?></span>
			<span>📍 <?php esc_html_e( 'All Delhi NCR', 'rajdhani-nursery' ); ?></span>
			<span>💰 <?php esc_html_e( 'From Rs 349 per Visit', 'rajdhani-nursery' ); ?></span>
		</div>
	</div>
</section>

<section class="rn-section">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'Our Services', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'Gardening Services We Provide in Delhi', 'rajdhani-nursery' ); ?></h2>
			<p><?php esc_html_e( 'From a single plant checkup to full time garden management, our maalis cover everything your green space needs.', 'rajdhani-nursery' ); ?></p>
		</div>
		<div class="rn-grid rn-grid-3">
			<?php
			$services = array(
				array( '👨‍🌾', __( 'Mali On Rent', 'rajdhani-nursery' ), __( 'Hire a trained maali by the hour, day, week or month. Verified gardeners for homes, farmhouses, societies and offices.', 'rajdhani-nursery' ), '/mali-on-rent-delhi/' ),
				array( '🧑‍🌾', __( 'Gardener On Rent', 'rajdhani-nursery' ), __( 'Professional gardener services for lawns, flower beds and complete garden upkeep, booked online in minutes.', 'rajdhani-nursery' ), '/gardener-on-rent-delhi/' ),
				array( '🌳', __( 'Garden Maintenance', 'rajdhani-nursery' ), __( 'Weekly and monthly maintenance plans with mowing, pruning, feeding and seasonal care for every kind of garden.', 'rajdhani-nursery' ), '/garden-maintenance-services-delhi/' ),
				array( '🪴', __( 'Plant Care Services', 'rajdhani-nursery' ), __( 'Plant doctor visits, repotting, pest treatment and care routines for indoor and outdoor plants.', 'rajdhani-nursery' ), '/plant-care-services-delhi/' ),
				array( '🏙️', __( 'Terrace Garden Care', 'rajdhani-nursery' ), __( 'Specialist care for terrace and balcony gardens, including kitchen gardens and seepage safe watering.', 'rajdhani-nursery' ), '/terrace-garden-maintenance-delhi/' ),
				array( '🌸', __( 'Plants & Supplies', 'rajdhani-nursery' ), __( 'Healthy plants, pots, soil and fertilizers straight from our own Delhi nursery at genuine prices.', 'rajdhani-nursery' ), '/contact-us/' ),
			);
			foreach ( $services as $service ) :
				?>
				<div class="rn-card">
					<div class="rn-card-icon"><?php echo esc_html( $service[0] ); ?></div>
					<h3><?php echo esc_html( $service[1] ); ?></h3>
					<p><?php echo esc_html( $service[2] ); ?></p>
					<a class="rn-card-link" href="<?php echo esc_url( home_url( $service[3] ) ); ?>"><?php esc_html_e( 'Learn more →', 'rajdhani-nursery' ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="rn-section rn-section-soft">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'Plans & Pricing', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'Maali Service Plans for Every Garden', 'rajdhani-nursery' ); ?></h2>
			<p><?php esc_html_e( 'Choose visits per week that suit your garden. Same trusted maali on every visit, materials only with your approval.', 'rajdhani-nursery' ); ?></p>
		</div>
		<?php rn_render_plans(); ?>
		<p style="text-align:center;margin-top:28px;">
			<a class="rn-btn rn-btn-outline" href="<?php echo esc_url( home_url( '/maali-service-plans/' ) ); ?>"><?php esc_html_e( 'Compare All Plans in Detail', 'rajdhani-nursery' ); ?></a>
		</p>
	</div>
</section>

<section class="rn-section">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'Simple Process', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'How Online Maali Booking Works', 'rajdhani-nursery' ); ?></h2>
		</div>
		<div class="rn-grid rn-grid-4 rn-steps">
			<div class="rn-step">
				<div class="rn-step-num"></div>
				<h3><?php esc_html_e( 'Fill the Form', 'rajdhani-nursery' ); ?></h3>
				<p><?php esc_html_e( 'Share your name, number and address so we send the right maali to you.', 'rajdhani-nursery' ); ?></p>
			</div>
			<div class="rn-step">
				<div class="rn-step-num"></div>
				<h3><?php esc_html_e( 'Choose Duration', 'rajdhani-nursery' ); ?></h3>
				<p><?php esc_html_e( '1 hour, 2 hours, 4 hours, 6 hours or full day. Prices shown upfront.', 'rajdhani-nursery' ); ?></p>
			</div>
			<div class="rn-step">
				<div class="rn-step-num"></div>
				<h3><?php esc_html_e( 'Pick Date & Time', 'rajdhani-nursery' ); ?></h3>
				<p><?php esc_html_e( 'Select any date from the calendar and a slot between 7 AM and 5 PM.', 'rajdhani-nursery' ); ?></p>
			</div>
			<div class="rn-step">
				<div class="rn-step-num"></div>
				<h3><?php esc_html_e( 'Maali Arrives', 'rajdhani-nursery' ); ?></h3>
				<p><?php esc_html_e( 'We confirm on call or WhatsApp and your gardener arrives on time.', 'rajdhani-nursery' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="rn-section rn-section-soft" id="booking">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'Book Now', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'Book Your Maali Online', 'rajdhani-nursery' ); ?></h2>
		</div>
		<?php echo do_shortcode( '[maali_booking_form]' ); ?>
	</div>
</section>

<section class="rn-section">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'FAQs', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'Frequently Asked Questions', 'rajdhani-nursery' ); ?></h2>
		</div>
		<?php echo do_shortcode( '[rn_faqs]' ); ?>
	</div>
</section>

<section class="rn-section rn-section-soft">
	<div class="rn-container">
		<div class="rn-section-head">
			<span class="rn-kicker"><?php esc_html_e( 'Service Areas', 'rajdhani-nursery' ); ?></span>
			<h2><?php esc_html_e( 'Mali On Rent Across Delhi NCR', 'rajdhani-nursery' ); ?></h2>
		</div>
		<ul class="rn-areas">
			<?php foreach ( rn_get_areas() as $area ) : ?>
				<li><?php echo esc_html( $area ); ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="rn-cta-band">
			<h2><?php esc_html_e( 'Your Garden Deserves Expert Hands', 'rajdhani-nursery' ); ?></h2>
			<p><?php esc_html_e( 'Join hundreds of happy homes across Delhi NCR. Book a verified maali today and see the difference on the very first visit.', 'rajdhani-nursery' ); ?></p>
			<a class="rn-btn rn-btn-amber" href="<?php echo esc_url( $booking_url ); ?>"><?php esc_html_e( 'Book Maali Online Now', 'rajdhani-nursery' ); ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
