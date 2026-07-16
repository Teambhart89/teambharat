<?php
/**
 * Rajdhani Nursery theme functions.
 *
 * @package Rajdhani_Nursery
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RN_THEME_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/booking.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/setup-content.php';

/**
 * Theme setup.
 */
function rn_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'rajdhani-nursery' ),
			'footer'  => __( 'Footer Menu', 'rajdhani-nursery' ),
		)
	);
}
add_action( 'after_setup_theme', 'rn_theme_setup' );

/**
 * Enqueue styles and scripts.
 */
function rn_enqueue_assets() {
	wp_enqueue_style( 'rajdhani-nursery-style', get_stylesheet_uri(), array(), RN_THEME_VERSION );
	wp_enqueue_script( 'rajdhani-nursery-main', get_template_directory_uri() . '/js/main.js', array(), RN_THEME_VERSION, true );

	wp_localize_script(
		'rajdhani-nursery-main',
		'rnBooking',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'rn_booking_nonce' ),
			'durations' => rn_get_durations(),
			'waNumber'  => rn_get_option( 'whatsapp' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'rn_enqueue_assets' );

/**
 * Business details, editable under Appearance > Customize > Business Details.
 */
function rn_get_option( $key ) {
	$defaults = array(
		'phone'    => '+91 99999 99999',
		'whatsapp' => '919999999999',
		'email'    => 'info@rajdhaninursery.com',
		'address'  => 'Rajdhani Nursery, New Delhi, Delhi 110001',
		'hours'    => 'Mon to Sun: 7:00 AM to 7:00 PM',
	);
	$value = get_theme_mod( 'rn_' . $key, $defaults[ $key ] ?? '' );
	return $value ? $value : ( $defaults[ $key ] ?? '' );
}

/**
 * Customizer settings.
 */
function rn_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'rn_business',
		array(
			'title'    => __( 'Business Details', 'rajdhani-nursery' ),
			'priority' => 20,
		)
	);

	$fields = array(
		'phone'    => __( 'Phone Number (shown on site)', 'rajdhani-nursery' ),
		'whatsapp' => __( 'WhatsApp Number (digits only, with country code, e.g. 919999999999)', 'rajdhani-nursery' ),
		'email'    => __( 'Email Address', 'rajdhani-nursery' ),
		'address'  => __( 'Business Address', 'rajdhani-nursery' ),
		'hours'    => __( 'Working Hours', 'rajdhani-nursery' ),
	);

	foreach ( $fields as $key => $label ) {
		$wp_customize->add_setting( 'rn_' . $key, array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			'rn_' . $key,
			array(
				'label'   => $label,
				'section' => 'rn_business',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'rn_customize_register' );

/**
 * WhatsApp click to chat link.
 */
function rn_whatsapp_link( $message = '' ) {
	$number = preg_replace( '/\D/', '', rn_get_option( 'whatsapp' ) );
	if ( ! $message ) {
		$message = 'Hello Rajdhani Nursery, I want to book a maali for my garden. Please share details.';
	}
	return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}

/**
 * Booking durations with one time visit pricing.
 */
function rn_get_durations() {
	return array(
		'1hr'     => array( 'label' => '1 Hour', 'price' => 349 ),
		'2hr'     => array( 'label' => '2 Hours', 'price' => 549 ),
		'4hr'     => array( 'label' => '4 Hours', 'price' => 999 ),
		'6hr'     => array( 'label' => '6 Hours', 'price' => 1299 ),
		'fullday' => array( 'label' => 'Full Day (8 Hrs)', 'price' => 1599 ),
	);
}

/**
 * Time slots for booking.
 */
function rn_get_time_slots() {
	return array(
		'07:00 AM', '08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM',
		'12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM',
	);
}

/**
 * The five maali service plans.
 */
function rn_get_plans() {
	return array(
		array(
			'name'     => 'Basic Green Plan',
			'price'    => '1,499',
			'period'   => 'per month',
			'visits'   => '1 visit every week, 4 visits a month',
			'duration' => '1 hour per visit',
			'popular'  => false,
			'features' => array(
				'Watering of all plants and lawn',
				'Removal of dry leaves and weeds',
				'Basic pruning and trimming',
				'Soil loosening (gudai) for pots',
				'Garden cleaning after every visit',
			),
			'ideal'    => 'Small balcony gardens and homes with up to 25 pots',
		),
		array(
			'name'     => 'Standard Care Plan',
			'price'    => '2,799',
			'period'   => 'per month',
			'visits'   => '2 visits every week, 8 visits a month',
			'duration' => '1.5 hours per visit',
			'popular'  => true,
			'features' => array(
				'Everything in Basic Green Plan',
				'Seasonal repotting support',
				'Pest and disease check on every visit',
				'Fertilizer application (material chargeable)',
				'Free gardening advice on WhatsApp',
			),
			'ideal'    => 'Independent homes and terrace gardens with 25 to 60 pots',
		),
		array(
			'name'     => 'Premium Garden Plan',
			'price'    => '3,999',
			'period'   => 'per month',
			'visits'   => '3 visits every week, 12 visits a month',
			'duration' => '2 hours per visit',
			'popular'  => false,
			'features' => array(
				'Everything in Standard Care Plan',
				'Lawn mowing and edge trimming',
				'Hedge shaping and creeper training',
				'Seasonal flower bed preparation',
				'Monthly garden health report',
			),
			'ideal'    => 'Villas, farmhouses and gardens with lawns',
		),
		array(
			'name'     => 'Daily Maali Plan',
			'price'    => '6,999',
			'period'   => 'per month',
			'visits'   => '6 visits every week, Monday to Saturday',
			'duration' => '2 hours per visit',
			'popular'  => false,
			'features' => array(
				'Everything in Premium Garden Plan',
				'Daily watering and plant care',
				'Priority same day support',
				'Dedicated maali assigned to you',
				'Free replacement visit if maali is absent',
			),
			'ideal'    => 'Large homes, societies and offices needing daily care',
		),
		array(
			'name'     => 'Full Day Dedicated Maali',
			'price'    => '13,999',
			'period'   => 'per month',
			'visits'   => 'Daily, Monday to Saturday',
			'duration' => 'Full day, 8 hours',
			'popular'  => false,
			'features' => array(
				'Trained full time maali for your property',
				'Complete garden and lawn management',
				'Nursery support and plant sourcing help',
				'Supervisor visit twice a month',
				'Backup maali on leave days',
			),
			'ideal'    => 'Farmhouses, corporate campuses, hotels and schools',
		),
	);
}

/**
 * Ten frequently asked questions. Used by the FAQ shortcode and FAQ schema.
 */
function rn_get_faqs() {
	return array(
		array(
			'q' => 'How can I book a maali online in Delhi?',
			'a' => 'You can book a maali directly on our website in under two minutes. Open the Book Maali Online page, fill in your name, phone number and address, choose your duration such as 1 hour, 2 hours, 4 hours, 6 hours or a full day, then pick a date and time slot from the calendar. Our team confirms every booking on call or WhatsApp within a few hours.',
		),
		array(
			'q' => 'What are the charges for mali on rent in Delhi?',
			'a' => 'Our one time visit charges start at Rs 349 for 1 hour, Rs 549 for 2 hours, Rs 999 for 4 hours, Rs 1,299 for 6 hours and Rs 1,599 for a full day of 8 hours. Monthly plans start at Rs 1,499 with one visit per week. Final charges depend on your garden size and the work required, and we always confirm the price before the visit.',
		),
		array(
			'q' => 'Which areas of Delhi do you cover?',
			'a' => 'We provide mali on rent and gardening services across all of Delhi, including South Delhi, North Delhi, East Delhi, West Delhi and Central Delhi. We also serve Noida, Gurugram, Ghaziabad, Faridabad and Greater Noida in Delhi NCR. If you are unsure about your locality, message us on WhatsApp and we will confirm availability.',
		),
		array(
			'q' => 'What work does the maali do during a visit?',
			'a' => 'Our maali handles watering, pruning, trimming, weeding, soil loosening (gudai), repotting, lawn mowing, hedge shaping, pest checks and general garden cleaning. Tell us your requirements while booking and we will send a gardener with the right tools and experience for the job.',
		),
		array(
			'q' => 'How many visits do I get in the weekly and monthly plans?',
			'a' => 'The Basic Green Plan gives 4 visits a month with one visit each week. The Standard Care Plan gives 8 visits a month. The Premium Garden Plan gives 12 visits a month. The Daily Maali Plan covers 6 days a week, and the Full Day Dedicated Maali works at your property every working day for the full day.',
		),
		array(
			'q' => 'What is included in the service and what is chargeable extra?',
			'a' => 'The maali\'s labour, basic hand tools and travel within our service area are included in every plan. Materials such as fertilizers, manure, khaad, pesticides, new pots, fresh soil, grass and plants are chargeable at actual cost. We always inform you and take your approval before buying any material.',
		),
		array(
			'q' => 'Are your gardeners verified and experienced?',
			'a' => 'Yes. Every maali at Rajdhani Nursery is background verified and has hands on experience with Delhi\'s climate, soil and seasonal plants. Most of our gardeners have five or more years of experience with homes, farmhouses, societies and office gardens.',
		),
		array(
			'q' => 'Can I book the same maali for regular visits?',
			'a' => 'Yes. In all our monthly plans we assign a dedicated maali to your home so the same person cares for your garden on every visit. This helps the gardener understand your plants better and give consistent care. If your maali is on leave, we send a trained replacement.',
		),
		array(
			'q' => 'Do you provide plants, pots and gardening material also?',
			'a' => 'Yes. Rajdhani Nursery is a full plant nursery in Delhi. Along with maali services we supply indoor and outdoor plants, flowering plants, pots, planters, soil, manure, fertilizers and garden accessories. Your maali can bring whatever your garden needs on the next visit at nursery prices.',
		),
		array(
			'q' => 'What if I am not satisfied with the maali service?',
			'a' => 'Your satisfaction matters to us. If you are not happy with any visit, tell us within 24 hours and we will send a supervisor or arrange a free corrective visit. You can also request a different gardener at any time in the monthly plans, with no extra cost.',
		),
	);
}

/**
 * Areas served, used on the home page and footer.
 */
function rn_get_areas() {
	return array(
		'South Delhi', 'North Delhi', 'East Delhi', 'West Delhi', 'Central Delhi',
		'Dwarka', 'Rohini', 'Saket', 'Vasant Kunj', 'Greater Kailash',
		'Noida', 'Gurugram', 'Ghaziabad', 'Faridabad', 'Greater Noida',
	);
}

/**
 * FAQ shortcode: [rn_faqs]
 */
function rn_faqs_shortcode() {
	ob_start();
	?>
	<div class="rn-faq">
		<?php foreach ( rn_get_faqs() as $i => $faq ) : ?>
			<div class="rn-faq-item<?php echo 0 === $i ? ' open' : ''; ?>">
				<button class="rn-faq-q" type="button" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
					<?php echo esc_html( $faq['q'] ); ?>
				</button>
				<div class="rn-faq-a"><p><?php echo esc_html( $faq['a'] ); ?></p></div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rn_faqs', 'rn_faqs_shortcode' );

/**
 * Plans shortcode: [rn_plans]
 */
function rn_plans_shortcode() {
	ob_start();
	rn_render_plans();
	return ob_get_clean();
}
add_shortcode( 'rn_plans', 'rn_plans_shortcode' );

/**
 * Render the pricing plan cards.
 */
function rn_render_plans() {
	$booking_url = home_url( '/book-maali-online/' );
	?>
	<div class="rn-plans">
		<?php foreach ( rn_get_plans() as $plan ) : ?>
			<div class="rn-plan<?php echo $plan['popular'] ? ' rn-plan-popular' : ''; ?>">
				<?php if ( $plan['popular'] ) : ?>
					<span class="rn-plan-badge"><?php esc_html_e( 'Most Popular', 'rajdhani-nursery' ); ?></span>
				<?php endif; ?>
				<h3><?php echo esc_html( $plan['name'] ); ?></h3>
				<div class="rn-plan-price">&#8377;<?php echo esc_html( $plan['price'] ); ?> <small><?php echo esc_html( $plan['period'] ); ?></small></div>
				<span class="rn-plan-visits"><?php echo esc_html( $plan['visits'] ); ?></span>
				<p style="font-size:.85rem;color:var(--rn-gray);margin-bottom:10px;"><strong><?php esc_html_e( 'Duration:', 'rajdhani-nursery' ); ?></strong> <?php echo esc_html( $plan['duration'] ); ?></p>
				<ul>
					<?php foreach ( $plan['features'] as $feature ) : ?>
						<li><?php echo esc_html( $feature ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p style="font-size:.82rem;color:var(--rn-gray);"><strong><?php esc_html_e( 'Best for:', 'rajdhani-nursery' ); ?></strong> <?php echo esc_html( $plan['ideal'] ); ?></p>
				<a class="rn-btn" href="<?php echo esc_url( $booking_url ); ?>"><?php esc_html_e( 'Book This Plan', 'rajdhani-nursery' ); ?></a>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Fallback menu when no menu is assigned.
 */
function rn_fallback_menu() {
	$links = array(
		'/'                                    => __( 'Home', 'rajdhani-nursery' ),
		'/mali-on-rent-delhi/'                 => __( 'Mali On Rent', 'rajdhani-nursery' ),
		'/gardener-on-rent-delhi/'             => __( 'Gardener On Rent', 'rajdhani-nursery' ),
		'/garden-maintenance-services-delhi/'  => __( 'Garden Maintenance', 'rajdhani-nursery' ),
		'/plant-care-services-delhi/'          => __( 'Plant Care', 'rajdhani-nursery' ),
		'/maali-service-plans/'                => __( 'Plans & Pricing', 'rajdhani-nursery' ),
		'/faqs/'                               => __( 'FAQs', 'rajdhani-nursery' ),
		'/contact-us/'                         => __( 'Contact', 'rajdhani-nursery' ),
	);
	echo '<ul>';
	foreach ( $links as $path => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( $path ) ), esc_html( $label ) );
	}
	echo '</ul>';
}
