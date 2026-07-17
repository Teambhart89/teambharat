<?php
/**
 * JSON-LD structured data for epoojabooking.com.
 *
 * Outputs Organization, WebSite, Service, BreadcrumbList and FAQPage schema
 * so search engines and AI answer engines can understand every page.
 *
 * @package epoojabooking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'epb_site_faqs' ) ) :
/**
 * The 10 site FAQs. Shared by the FAQ page schema and reusable in templates.
 * The ePoojaBooking Core plugin ships the canonical copy; this is a fallback
 * so schema still works if the plugin is disabled.
 *
 * @return array[]
 */
function epb_site_faqs() {
	return array(
		array(
			'q' => 'What is online puja booking and how does it work on epoojabooking?',
			'a' => 'Online puja booking lets you book a puja at a trusted temple from anywhere in the world. Choose your puja, share your name, gotra and sankalp, pick a date, and our verified pandits perform the puja on your behalf. You receive photos or a video of the ritual and prasad is delivered to your address.',
		),
		array(
			'q' => 'Will the puja be performed in my name even if I am not present?',
			'a' => 'Yes. During the sankalp, the pandit takes your name, gotra and your prayer intention, which dedicates the entire puja to you and your family. This is a long accepted practice in Hindu tradition when a devotee cannot travel to the temple in person.',
		),
		array(
			'q' => 'How do I know the puja was actually performed?',
			'a' => 'Every booking includes proof of the ritual. Depending on the service you choose, we share recorded video, photographs, or a live streaming link so you can watch your puja as it happens at the temple.',
		),
		array(
			'q' => 'What is chadhava and can I offer it online?',
			'a' => 'Chadhava is a devotional offering made to the deity, such as flowers, vastra, sweets, coconut or dakshina. Through epoojabooking you can select the chadhava items, and our team offers them at the temple in your name on your chosen day.',
		),
		array(
			'q' => 'Do you deliver prasad outside India?',
			'a' => 'Yes. We deliver prasad across India and to NRI devotees in the USA, UK, Canada, Australia, UAE, Singapore and many other countries. Delivery time depends on your location, and tracking details are shared once your prasad is shipped.',
		),
		array(
			'q' => 'Which payment methods do you accept?',
			'a' => 'We accept UPI, all major credit and debit cards, net banking and popular wallets through secure payment gateways. International devotees can pay with international cards, and multi currency support makes checkout simple from any country.',
		),
		array(
			'q' => 'What details do I need to provide for a puja booking?',
			'a' => 'You share the devotee name, gotra if known, nakshatra if known, your sankalp or prayer intention, a preferred date, and the address for prasad delivery. If you do not know your gotra, the pandit uses Kashyap gotra as per tradition.',
		),
		array(
			'q' => 'Can I consult an astrologer online through epoojabooking?',
			'a' => 'Yes. You can book an online astrology consultation with experienced Vedic astrologers for kundli analysis, horoscope reading, numerology, Vastu guidance and remedies. Consultations happen over call or video at a time that suits you.',
		),
		array(
			'q' => 'Is my payment and personal information safe?',
			'a' => 'Absolutely. Payments are processed by PCI DSS compliant gateways over encrypted connections, and we never store your card details. Your personal details are used only to perform your puja and deliver your prasad.',
		),
		array(
			'q' => 'What if I need to change the date or cancel my booking?',
			'a' => 'You can request a date change or cancellation before the puja is performed by contacting our support team on WhatsApp or email. Refunds for eligible cancellations are processed back to your original payment method.',
		),
	);
}
endif;

/**
 * Print all applicable JSON-LD blocks.
 */
function epb_print_schema() {
	$graphs = array();

	$graphs[] = array(
		'@type'  => 'Organization',
		'@id'    => home_url( '/#organization' ),
		'name'   => 'epoojabooking',
		'url'    => home_url( '/' ),
		'logo'   => get_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : home_url( '/wp-content/uploads/logo.png' ),
		'sameAs' => array(),
		'contactPoint' => array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'customer support',
			'availableLanguage' => array( 'en', 'hi' ),
		),
	);

	$graphs[] = array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'url'             => home_url( '/' ),
		'name'            => 'epoojabooking',
		'description'     => 'Book online pujas, temple chadhava offerings, astrology consultations and spiritual services from trusted temples across India.',
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	if ( is_page() && ! is_front_page() ) {
		$graphs[] = array(
			'@type'    => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Home',
					'item'     => home_url( '/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => get_the_title(),
					'item'     => get_permalink(),
				),
			),
		);
	}

	// Service schema on service template pages.
	if ( is_page_template( 'template-service.php' ) ) {
		$graphs[] = array(
			'@type'       => 'Service',
			'name'        => get_the_title(),
			'url'         => get_permalink(),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'provider'    => array( '@id' => home_url( '/#organization' ) ),
			'areaServed'  => array( 'India', 'United States', 'United Kingdom', 'Canada', 'Australia', 'United Arab Emirates' ),
			'serviceType' => 'Hindu religious service',
		);
	}

	// Temple pages: PlaceOfWorship schema.
	if ( is_singular( 'epb_temple' ) ) {
		$city  = get_post_meta( get_the_ID(), 'epb_city', true );
		$state = get_post_meta( get_the_ID(), 'epb_state', true );

		$graphs[] = array(
			'@type'       => 'HinduTemple',
			'name'        => get_the_title(),
			'url'         => get_permalink(),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'address'     => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => $city,
				'addressRegion'   => $state,
				'addressCountry'  => 'IN',
			),
		);
	}

	// FAQ schema on the FAQ page.
	if ( is_page( 'faq' ) ) {
		$faq_entities = array();
		foreach ( epb_site_faqs() as $faq ) {
			$faq_entities[] = array(
				'@type'          => 'Question',
				'name'           => $faq['q'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $faq['a'],
				),
			);
		}
		$graphs[] = array(
			'@type'      => 'FAQPage',
			'mainEntity' => $faq_entities,
		);
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graphs,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'epb_print_schema', 20 );
