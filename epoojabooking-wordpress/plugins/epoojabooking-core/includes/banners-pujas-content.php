<?php
/**
 * Seed content: homepage banners and sample special pujas.
 *
 * All text is original. Banner and card photos are not bundled;
 * upload your own images as Featured Images in wp-admin.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Import banners and special pujas. Existing slugs are skipped.
 */
function epb_import_banners_and_pujas() {

	$banners = array(
		array(
			'slug'     => 'banner-book-puja',
			'title'    => 'Book Online Puja at India\'s Sacred Temples',
			'subtitle' => 'Verified pandits perform the puja in your name with full sankalp. Watch it live and receive prasad at your doorstep, anywhere in the world.',
			'btn_text' => 'Book Puja',
			'btn_url'  => '/online-puja-booking/',
			'order'    => 1,
		),
		array(
			'slug'     => 'banner-chadhava',
			'title'    => 'Offer Chadhava at Your Beloved Temple',
			'subtitle' => 'Flowers, vastra, sweets and dakshina offered at renowned temples across India, from your home. Photos shared after every offering.',
			'btn_text' => 'Offer Chadhava',
			'btn_url'  => '/online-chadhava-offering/',
			'order'    => 2,
		),
		array(
			'slug'     => 'banner-astrology',
			'title'    => 'Talk to Experienced Vedic Astrologers',
			'subtitle' => 'Kundli analysis, horoscope reading, numerology and Vastu guidance over call or video, with practical remedies you can act on.',
			'btn_text' => 'Book Consultation',
			'btn_url'  => '/online-astrology-consultation/',
			'order'    => 3,
		),
	);

	foreach ( $banners as $banner ) {
		if ( get_page_by_path( $banner['slug'], OBJECT, 'epb_banner' ) ) {
			continue;
		}
		$banner_id = wp_insert_post( array(
			'post_type'   => 'epb_banner',
			'post_status' => 'publish',
			'post_name'   => $banner['slug'],
			'post_title'  => $banner['title'],
			'menu_order'  => $banner['order'],
		) );
		if ( ! is_wp_error( $banner_id ) && $banner_id ) {
			update_post_meta( $banner_id, 'epb_subtitle', $banner['subtitle'] );
			update_post_meta( $banner_id, 'epb_btn_text', $banner['btn_text'] );
			update_post_meta( $banner_id, 'epb_btn_url', $banner['btn_url'] );
		}
	}

	$pujas = array(
		array(
			'slug'    => 'shravan-somvar-rudrabhishek',
			'title'   => 'Shravan Somvar Rudrabhishek with Mahamrityunjaya Jaap',
			'badge'   => 'Shravan Special',
			'temple'  => 'Shiva Temple, Ujjain',
			'date'    => 'Every Monday of Shravan',
			'price'   => '₹1,100',
			'terms'   => array(
				'epb_deity'    => array( 'Shiva' ),
				'epb_tithi'    => array( 'Shravan Somvar' ),
				'epb_dosha'    => array( 'Kaal Sarp Dosh' ),
				'epb_benefit'  => array( 'Health and Protection' ),
				'epb_location' => array( 'Ujjain' ),
			),
			'excerpt' => 'The most powerful Mondays of the year. Rudrabhishek with Mahamrityunjaya jaap performed in your name for health, protection and removal of long-standing obstacles.',
			'content' => <<<'HTML'
<p>Shravan is the month Lord Shiva holds dearest, and each of its Mondays multiplies the fruit of Shiva worship. In this special seva, our pandits perform Rudrabhishek along with Mahamrityunjaya jaap in your name at a trusted Shiva temple.</p>
<h2>What Is Included</h2>
<ul>
<li>Sankalp with your name, gotra and prayer intention</li>
<li>Rudrabhishek of the shivling with panchamrit and Gangajal</li>
<li>Mahamrityunjaya mantra jaap by temple pandits</li>
<li>Bilva patra, flowers, bhog and complete samagri</li>
<li>Video of your puja and prasad delivery to your home</li>
</ul>
<h2>Who Should Book This Puja</h2>
<p>Devotees seeking recovery from illness, protection of family members, relief from fear and anxiety, and blessings for a long and healthy life. Families often book this seva together for elders.</p>
<h2>How It Works</h2>
<p>Fill the booking form with your details and preferred Monday. We confirm your slot on WhatsApp, perform the puja with full vidhi, and share the video the same day.</p>
HTML
		),
		array(
			'slug'    => 'purnima-satyanarayan-katha',
			'title'   => 'Purnima Satyanarayan Katha with 108 Deepdaan',
			'badge'   => 'Purnima Special',
			'temple'  => 'Vishnu Temple, Varanasi',
			'date'    => 'Next Purnima',
			'price'   => '₹851',
			'terms'   => array(
				'epb_deity'    => array( 'Vishnu' ),
				'epb_tithi'    => array( 'Purnima' ),
				'epb_benefit'  => array( 'Family Harmony', 'New Beginnings' ),
				'epb_location' => array( 'Varanasi' ),
			),
			'excerpt' => 'Satyanarayan katha on the full moon, completed with the offering of 108 lamps on the ghats. For gratitude, family harmony and new beginnings.',
			'content' => <<<'HTML'
<p>The Satyanarayan katha on Purnima is among the most beloved observances in Hindu homes, performed in gratitude and for the wellbeing of the whole family. In this seva, the katha is recited in your name at a Vishnu temple in Kashi, followed by the offering of 108 deepdaan lamps.</p>
<h2>What Is Included</h2>
<ul>
<li>Sankalp with your family names and gotra</li>
<li>Complete Satyanarayan katha with panchamrit and puja</li>
<li>108 lamps offered in your name after the katha</li>
<li>Charnamrit and panjiri prasad delivery</li>
<li>Photos and video of the katha and deepdaan</li>
</ul>
<h2>Who Should Book This Puja</h2>
<p>Families marking a new home, new job, marriage, childbirth or any milestone, and devotees who wish to keep the monthly Purnima tradition alive even when far from home.</p>
<h2>How It Works</h2>
<p>Book your slot before Purnima, share your family names, and receive the video and prasad after the katha is completed.</p>
HTML
		),
		array(
			'slug'    => 'navagraha-shanti-mahapuja',
			'title'   => 'Navagraha Shanti Mahapuja and Havan',
			'badge'   => 'Graha Shanti',
			'temple'  => 'Navagraha Mandir, Ujjain',
			'date'    => 'Shani Amavasya',
			'price'   => '₹2,100',
			'terms'   => array(
				'epb_deity'    => array( 'Navagraha', 'Shani Dev' ),
				'epb_tithi'    => array( 'Amavasya' ),
				'epb_dosha'    => array( 'Shani Sade Sati', 'Mangal Dosh' ),
				'epb_benefit'  => array( 'Career and Wealth', 'Obstacle Removal' ),
				'epb_location' => array( 'Ujjain' ),
			),
			'excerpt' => 'A complete pacification of all nine grahas at Ujjain\'s Navagraha temple, with havan and til-oil offerings to Shani Dev on the powerful Amavasya day.',
			'content' => <<<'HTML'
<p>When the kundli shows difficult periods, shani sade sati, mangal dosh or troubling dashas, the shastras recommend graha shanti. This mahapuja pacifies all nine celestial grahas at the Navagraha temple by the Kshipra in Ujjain, on the most potent day for Shani worship.</p>
<h2>What Is Included</h2>
<ul>
<li>Sankalp with your name, gotra and birth details</li>
<li>Puja of all nine grahas with their mantras</li>
<li>Navagraha havan with the prescribed samidha for each graha</li>
<li>Til and oil offerings to Shani Dev in your name</li>
<li>Video of the complete ritual and prasad delivery</li>
</ul>
<h2>Who Should Book This Puja</h2>
<p>Anyone facing repeated obstacles, delays in career or marriage, or difficult planetary periods identified in an astrology consultation. Pair it with a kundli reading on our astrology page for the fullest guidance.</p>
<h2>How It Works</h2>
<p>Share your birth details with the booking so the pandits can include the correct graha mantras in your sankalp. The video reaches you the same evening.</p>
HTML
		),
	);

	foreach ( $pujas as $puja ) {
		if ( get_page_by_path( $puja['slug'], OBJECT, 'epb_puja' ) ) {
			continue;
		}
		$puja_id = wp_insert_post( array(
			'post_type'    => 'epb_puja',
			'post_status'  => 'publish',
			'post_name'    => $puja['slug'],
			'post_title'   => $puja['title'],
			'post_content' => $puja['content'],
			'post_excerpt' => $puja['excerpt'],
		) );
		if ( ! is_wp_error( $puja_id ) && $puja_id ) {
			update_post_meta( $puja_id, 'epb_badge', $puja['badge'] );
			update_post_meta( $puja_id, 'epb_temple_name', $puja['temple'] );
			update_post_meta( $puja_id, 'epb_event_date', $puja['date'] );
			update_post_meta( $puja_id, 'epb_price', $puja['price'] );
			update_post_meta( $puja_id, 'epb_meta_description', $puja['excerpt'] );
			if ( ! empty( $puja['terms'] ) ) {
				foreach ( $puja['terms'] as $taxonomy => $terms ) {
					if ( taxonomy_exists( $taxonomy ) ) {
						wp_set_object_terms( $puja_id, $terms, $taxonomy );
					}
				}
			}
		}
	}
}
