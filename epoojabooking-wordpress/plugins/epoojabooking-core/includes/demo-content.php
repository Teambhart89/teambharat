<?php
/**
 * One-click import of the epoojabooking.com site structure:
 * SEO-friendly service pages with ready content, FAQ, About and Contact.
 *
 * Runs on plugin activation. Existing pages with the same slug are never
 * overwritten, so it is safe to re-activate the plugin.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'epb_site_faqs' ) ) {
	/**
	 * The 10 site FAQs. Canonical copy; the theme reuses this for FAQ schema.
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
}

/**
 * Create a page if the slug does not exist yet.
 *
 * @param array $args Page arguments: slug, title, content, excerpt, meta_description, template.
 * @return int Page ID.
 */
function epb_maybe_create_page( $args ) {
	$existing = get_page_by_path( $args['slug'] );
	if ( $existing ) {
		return $existing->ID;
	}

	$page_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_name'    => $args['slug'],
		'post_title'   => $args['title'],
		'post_content' => $args['content'],
		'post_excerpt' => isset( $args['excerpt'] ) ? $args['excerpt'] : '',
	) );

	if ( ! is_wp_error( $page_id ) && $page_id ) {
		if ( ! empty( $args['template'] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $args['template'] );
		}
		if ( ! empty( $args['meta_description'] ) ) {
			update_post_meta( $page_id, 'epb_meta_description', $args['meta_description'] );
		}
	}

	return is_wp_error( $page_id ) ? 0 : $page_id;
}

/**
 * Import all pages, set the front page, build the menu.
 */
function epb_import_site_content() {
	// Pretty permalinks for SEO friendly URLs.
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	$pages = epb_site_pages();

	$created = array();
	foreach ( $pages as $page ) {
		$created[ $page['slug'] ] = epb_maybe_create_page( $page );
	}

	// Front page.
	if ( ! empty( $created['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $created['home'] );
	}

	// Primary menu.
	$menu_name = 'Primary Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( ! is_wp_error( $menu_id ) ) {
			$menu_items = array(
				'online-puja-booking'           => 'Book Puja',
				'online-chadhava-offering'      => 'Chadhava',
				'online-astrology-consultation' => 'Astrology',
				'online-havan-booking'          => 'Havan',
				'book-pandit-online'            => 'Pandit Ji',
				'faq'                           => 'FAQ',
			);
			foreach ( $menu_items as $slug => $label ) {
				if ( ! empty( $created[ $slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => $label,
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $created[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
			// Temple directory link.
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => __( 'Temples', 'epoojabooking-core' ),
				'menu-item-url'    => home_url( '/temples/' ),
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
			) );
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
}

/**
 * All site pages with SEO content.
 *
 * H1 is rendered by the template from the page title.
 * Content uses H2, H3 and H4 tags with reader-friendly copy.
 *
 * @return array[]
 */
function epb_site_pages() {
	$pages = array();

	$pages[] = array(
		'slug'             => 'home',
		'title'            => 'Online Puja Booking, Chadhava and Astrology Services | epoojabooking',
		'template'         => '',
		'excerpt'          => 'Experience seamless online puja booking for all your spiritual needs. Book online pujas, temple offerings, chadhava, astrology consultations and spiritual products from trusted temples across India.',
		'meta_description' => 'Book online pujas, temple chadhava, abhishek, havan and astrology consultations at trusted temples across India. Video proof, prasad delivery worldwide and secure payments on epoojabooking.com.',
		'content'          => '<p>Welcome to epoojabooking, your trusted platform for online puja booking, chadhava offerings and astrology consultations from famous temples across India.</p>',
	);

	$pages[] = array(
		'slug'             => 'online-puja-booking',
		'title'            => 'Online Puja Booking at Famous Temples in India',
		'template'         => 'template-service.php',
		'excerpt'          => 'Book puja online at trusted temples across India. Performed in your name with full sankalp, video proof and prasad delivery to your home, in India or abroad.',
		'meta_description' => 'Book puja online at famous temples in India. Verified pandits perform your puja with full sankalp, you receive video proof and prasad is delivered to your doorstep worldwide.',
		'content'          => epb_content_puja_booking(),
	);

	$pages[] = array(
		'slug'             => 'online-chadhava-offering',
		'title'            => 'Online Chadhava and Temple Offerings',
		'template'         => 'template-service.php',
		'excerpt'          => 'Offer chadhava online at famous temples. Flowers, vastra, sweets, coconut and dakshina offered in your name with photos shared after the offering.',
		'meta_description' => 'Offer chadhava online at famous temples in India. Choose flowers, vastra, sweets and dakshina, and we make the temple offering in your name with photo confirmation.',
		'content'          => epb_content_chadhava(),
	);

	$pages[] = array(
		'slug'             => 'online-astrology-consultation',
		'title'            => 'Online Astrology Consultation with Vedic Astrologers',
		'template'         => 'template-service.php',
		'excerpt'          => 'Talk to experienced Vedic astrologers online. Kundli analysis, horoscope reading, numerology, Vastu guidance and practical remedies over call or video.',
		'meta_description' => 'Book an online astrology consultation with experienced Vedic astrologers. Kundli analysis, horoscope reading, numerology and Vastu guidance with practical remedies.',
		'content'          => epb_content_astrology(),
	);

	$pages[] = array(
		'slug'             => 'online-abhishek-booking',
		'title'            => 'Online Abhishek Booking: Rudrabhishek and More',
		'template'         => 'template-service.php',
		'excerpt'          => 'Book Rudrabhishek, dudh abhishek and other abhishek rituals at Shiva temples and Jyotirlingas. Performed in your name with video and prasad delivery.',
		'meta_description' => 'Book Rudrabhishek and abhishek online at Shiva temples and Jyotirlingas in India. Performed in your name by learned pandits with video proof and prasad delivery.',
		'content'          => epb_content_abhishek(),
	);

	$pages[] = array(
		'slug'             => 'online-havan-booking',
		'title'            => 'Online Havan Booking for Peace and Prosperity',
		'template'         => 'template-service.php',
		'excerpt'          => 'Book havan online: Ganesh havan, Navagraha havan, Mahamrityunjaya havan and more, performed by experienced pandits with full Vedic vidhi.',
		'meta_description' => 'Book havan online with experienced pandits. Ganesh havan, Navagraha havan and Mahamrityunjaya havan performed with full Vedic vidhi, video proof and prasad delivery.',
		'content'          => epb_content_havan(),
	);

	$pages[] = array(
		'slug'             => 'book-pandit-online',
		'title'            => 'Book Pandit Ji Online for Puja at Home',
		'template'         => 'template-service.php',
		'excerpt'          => 'Book verified pandits for griha pravesh, satyanarayan katha, weddings and all sanskars. At your home in India or online for NRI families.',
		'meta_description' => 'Book pandit ji online for puja at home. Verified pandits for griha pravesh, satyanarayan katha, weddings and sanskars, in person across India or online worldwide.',
		'content'          => epb_content_pandit(),
	);

	$pages[] = array(
		'slug'             => 'faq',
		'title'            => 'Frequently Asked Questions',
		'template'         => '',
		'excerpt'          => 'Answers to common questions about online puja booking, chadhava offerings, prasad delivery, payments and astrology consultations on epoojabooking.',
		'meta_description' => 'Frequently asked questions about online puja booking, chadhava, prasad delivery, payments, refunds and astrology consultations on epoojabooking.com.',
		'content'          => epb_content_faq(),
	);

	$pages[] = array(
		'slug'             => 'about-us',
		'title'            => 'About epoojabooking',
		'template'         => '',
		'excerpt'          => 'epoojabooking connects devotees worldwide with trusted temples and verified pandits across India for pujas, chadhava and astrology services.',
		'meta_description' => 'Learn about epoojabooking, the trusted platform connecting devotees in India and abroad with verified temples and pandits for online pujas and chadhava.',
		'content'          => epb_content_about(),
	);

	$pages[] = array(
		'slug'             => 'contact-us',
		'title'            => 'Contact Us',
		'template'         => '',
		'excerpt'          => 'Reach the epoojabooking devotee support team on WhatsApp or email for help with bookings, prasad delivery and consultations.',
		'meta_description' => 'Contact epoojabooking devotee support on WhatsApp or email for help with puja bookings, chadhava offerings, prasad delivery and astrology consultations.',
		'content'          => epb_content_contact(),
	);

	return $pages;
}

/** Online Puja Booking page content. */
function epb_content_puja_booking() {
	return <<<'HTML'
<p>Distance should never come between you and your devotion. With epoojabooking you can book puja online at famous temples across India, and our verified pandits perform the ritual in your name with complete Vedic vidhi. Whether you live in Mumbai or Melbourne, your prayer reaches the deity with full sankalp, and the blessings reach you.</p>

<h2>Why Devotees Choose Online Puja Booking</h2>
<p>Many devotees wish to offer puja at powerful temples like Kashi Vishwanath, Ujjain Mahakaleshwar, Tirupati or Kamakhya Devi, but travel is not always possible. Online puja booking solves this beautifully. You choose the puja, share your details, and an experienced temple pandit performs it on your behalf. The tradition of yajman sankalp allows a puja to be dedicated to a devotee who is not physically present, a practice followed in temples for centuries.</p>

<h3>Performed in Your Name with Full Sankalp</h3>
<p>During the sankalp, the pandit recites your name, gotra and prayer intention before the deity. This dedicates every mantra and every offering of the puja to you and your family. If you do not know your gotra, the pandit uses Kashyap gotra as per tradition, so no devotee is ever left out.</p>

<h3>Video Proof and Live Streaming</h3>
<p>You never have to wonder whether your puja was performed. Depending on the temple, we share a recorded video, photographs, or a live streaming link so you can watch your puja as it happens and join the ritual with folded hands from wherever you are.</p>

<h3>Prasad Delivered to Your Doorstep</h3>
<p>After the puja, the blessed prasad is carefully packed and shipped to your address. We deliver across India and to devotees in the USA, UK, Canada, Australia, UAE, Singapore and many other countries.</p>

<h2>Popular Pujas You Can Book Online</h2>
<ul>
<li>Rudrabhishek at Shiva temples and Jyotirlingas</li>
<li>Satyanarayan puja for family harmony and gratitude</li>
<li>Navagraha shanti puja to pacify planetary doshas</li>
<li>Mahamrityunjaya jaap for health and protection</li>
<li>Ganesh puja before new beginnings and ventures</li>
<li>Lakshmi puja for wealth and abundance</li>
<li>Kaal sarp dosh and pitra dosh nivaran pujas</li>
<li>Festival special pujas on Shivratri, Navratri, Diwali and Purnima</li>
</ul>

<h2>How to Book a Puja Online</h2>
<h3>Step 1: Choose your puja and temple</h3>
<p>Select the puja that matches your intention, whether it is health, career, marriage, children or spiritual growth.</p>
<h3>Step 2: Share your sankalp details</h3>
<p>Fill in the devotee name, gotra, nakshatra if known, your prayer intention and a preferred date. Our team confirms the muhurat with the temple.</p>
<h3>Step 3: Receive blessings and prasad</h3>
<p>Watch your puja live or receive the video, and your prasad arrives at your home within days.</p>

<h2>Trusted by Devotees in India and Abroad</h2>
<p>Every temple and pandit on epoojabooking is verified. Payments are secure with UPI, cards and net banking, and international devotees can pay in their own currency. Our support team is available on WhatsApp to guide you before and after your booking.</p>

<h4>A Note for NRI Devotees</h4>
<p>Time zones are never a problem. We schedule pujas so you can join the live stream at a convenient hour, and prasad shipping includes tracking right to your door.</p>
HTML;
}

/** Chadhava page content. */
function epb_content_chadhava() {
	return <<<'HTML'
<p>Offering chadhava at a temple is one of the purest expressions of devotion. Through epoojabooking you can offer chadhava online at famous temples across India. Choose your offering, and our team presents it at the deity's feet in your name, on the day you choose, with photos shared as confirmation.</p>

<h2>What is Chadhava?</h2>
<p>Chadhava is the devotional offering a devotee presents to the deity. It may be flowers, a coconut, vastra for the deity, sweets like laddoo or peda, sindoor, itra, or dakshina for the temple. Scriptures say that what matters is not the size of the offering but the bhav, the feeling behind it. When you offer chadhava online, that feeling travels with your name to the temple.</p>

<h3>Offerings You Can Choose</h3>
<ul>
<li>Fresh flowers and mala for shringar</li>
<li>Vastra and chunri offerings</li>
<li>Coconut, sweets and dry fruit bhog</li>
<li>Sindoor, itra and shringar items</li>
<li>Deepdaan, oil and ghee lamps</li>
<li>Annadaan and dakshina in your name</li>
</ul>

<h3>Temples Where We Offer Chadhava</h3>
<p>We work with trusted and famous temples across India, including Shiva temples, Hanuman temples, Devi shaktipeeths and Vishnu temples. Popular choices include chadhava at Kashi Vishwanath, Mehandipur Balaji, Khatu Shyam Ji, Salasar Balaji and Vaishno Devi. If you have a specific temple in mind, our team will do the best to arrange your offering there.</p>

<h2>How Online Chadhava Works</h2>
<h3>Step 1: Select your temple and offering</h3>
<p>Pick the temple, choose the chadhava items and tell us the day you would like the offering made. Many devotees choose Tuesdays for Hanuman ji, Mondays for Shiva and Fridays for Devi.</p>
<h3>Step 2: Share your name and gotra</h3>
<p>The offering is made in your name with a short sankalp, so the punya of the chadhava is dedicated to you and your family.</p>
<h3>Step 3: Receive confirmation</h3>
<p>After the offering, we share photos from the temple. For select temples, prasad can also be delivered to your home.</p>

<h2>Why Offer Chadhava Online with epoojabooking</h2>
<p>Devotees trust us because every offering is genuine, every temple is verified, and every booking is confirmed with photos. Payment is quick and secure with UPI, cards or international options for NRI devotees. There are no hidden charges, and our WhatsApp support answers every question, from choosing the right offering to picking an auspicious day.</p>

<h4>Chadhava on Special Days</h4>
<p>Festival days multiply the joy of giving. Book your chadhava in advance for Shivratri, Hanuman Jayanti, Navratri, Janmashtami and Purnima so your offering reaches the deity on the most auspicious tithi.</p>
HTML;
}

/** Astrology page content. */
function epb_content_astrology() {
	return <<<'HTML'
<p>Sometimes the heart needs answers as much as blessings. With epoojabooking you can book an online astrology consultation with experienced Vedic astrologers and understand what your kundli says about career, marriage, health and the road ahead. Consultations happen over call or video, in the language you are comfortable with.</p>

<h2>Astrology Services You Can Book</h2>
<h3>Kundli Analysis and Horoscope Reading</h3>
<p>Your janm kundli is a map of the sky at the moment you were born. Our astrologers read the placement of grahas, the dashas you are passing through, and the yogas in your chart to explain your strengths, challenges and upcoming opportunities in simple language.</p>
<h3>Kundli Milan for Marriage</h3>
<p>Planning a marriage? Get a detailed gun milan and compatibility analysis for the couple, along with honest guidance about mangal dosh and its practical remedies.</p>
<h3>Numerology Consultation</h3>
<p>Numbers carry their own vibration. A numerology session helps you understand your life path number, name number and lucky dates for important decisions.</p>
<h3>Vastu Consultation</h3>
<p>Your home shapes your energy. Our Vastu experts guide you on room placement, entrances, colors and simple corrections that do not require breaking any walls.</p>

<h2>How the Consultation Works</h2>
<h3>Step 1: Book your slot</h3>
<p>Choose your service and preferred time. Share your birth date, birth time and birth place so the astrologer can prepare your charts in advance.</p>
<h3>Step 2: Talk to the astrologer</h3>
<p>Connect over phone or video call. Ask questions freely; a good consultation is a conversation, not a lecture.</p>
<h3>Step 3: Receive your guidance</h3>
<p>After the session you receive a summary of the discussion and any suggested remedies, such as specific pujas, daan or mantra jaap.</p>

<h2>Why Consult Astrologers on epoojabooking</h2>
<p>Every astrologer on our platform is experienced, verified and reviewed. We respect your privacy completely, and your birth details are never shared. If a remedy involves a puja, you can book it on the same platform and we arrange everything at a trusted temple, which keeps your entire spiritual journey in one place.</p>

<h4>Who Should Book a Consultation?</h4>
<p>Anyone standing at a crossroads: a career change, a marriage decision, repeated obstacles, health worries, or simply the wish to understand oneself better. Astrology does not replace effort; it helps you direct your effort wisely.</p>
HTML;
}

/** Abhishek page content. */
function epb_content_abhishek() {
	return <<<'HTML'
<p>Abhishek is the sacred bathing of the deity, an act of love described in the Vedas and Puranas as deeply pleasing to the gods. With epoojabooking you can book abhishek online at Shiva temples, Jyotirlingas and other famous mandirs, performed in your name by learned pandits while you watch from anywhere in the world.</p>

<h2>Types of Abhishek You Can Book</h2>
<h3>Rudrabhishek</h3>
<p>The most revered abhishek of Lord Shiva, performed with the chanting of Rudri path. Devotees book Rudrabhishek for peace, protection, health and the removal of persistent obstacles. Mondays, Pradosh and Shivratri are especially auspicious.</p>
<h3>Dudh Abhishek and Panchamrit Abhishek</h3>
<p>The shivling is bathed with milk, or with panchamrit made of milk, curd, ghee, honey and sugar, while mantras are recited. This gentle offering is loved by devotees seeking harmony at home and calm in the mind.</p>
<h3>Jalabhishek and Gangajal Abhishek</h3>
<p>A continuous stream of pure water or Gangajal is offered to Lord Shiva. Simple, powerful and dear to Bholenath, who is pleased by the simplest sincere offering.</p>

<h2>Where We Perform Abhishek</h2>
<p>Our network includes pandits at revered Shiva temples across India, including Jyotirlinga temples such as Kashi Vishwanath, Mahakaleshwar Ujjain, Somnath and Trimbakeshwar, subject to each temple's rules and calendar. Tell us your preferred temple and date, and we confirm the muhurat with you before payment.</p>

<h2>What Your Booking Includes</h2>
<ul>
<li>Sankalp in your name, with your gotra and prayer intention</li>
<li>All samagri: milk, panchamrit, bilva patra, flowers and bhog</li>
<li>Learned pandits chanting the correct mantras and paths</li>
<li>Video recording or live streaming of the ritual</li>
<li>Prasad delivery to your home in India or overseas</li>
</ul>

<h2>Booking Your Abhishek in Three Steps</h2>
<h3>Step 1: Choose the abhishek and temple</h3>
<p>Select the type of abhishek and your preferred temple or Jyotirlinga.</p>
<h3>Step 2: Set the date and sankalp</h3>
<p>Pick a date; our team suggests auspicious tithis like Mondays, Pradosh, Shivratri and Shravan dates.</p>
<h3>Step 3: Join and receive blessings</h3>
<p>Watch the abhishek live or receive the full video, followed by prasad at your doorstep.</p>

<h4>The Meaning Behind the Ritual</h4>
<p>Each dravya offered in abhishek carries a prayer: milk for purity of mind, honey for sweetness in speech, ghee for strength, curd for prosperity and water for the cleansing of karma. When performed with shraddha, the abhishek becomes a conversation between the devotee and the divine.</p>
HTML;
}

/** Havan page content. */
function epb_content_havan() {
	return <<<'HTML'
<p>The sacred fire has carried human prayers to the heavens since Vedic times. With epoojabooking you can book havan online, performed by experienced pandits with complete vidhi, whether you want a Ganesh havan before a new beginning or a Mahamrityunjaya havan for health and protection.</p>

<h2>Havans You Can Book Online</h2>
<h3>Ganesh Havan</h3>
<p>Performed before new ventures, griha pravesh, weddings and exams. Lord Ganesha removes obstacles and blesses every new beginning with success.</p>
<h3>Navagraha Havan</h3>
<p>When planetary periods bring struggle, the Navagraha havan pacifies all nine grahas. Recommended for those facing shani sade sati, mangal dosh or difficult dashas revealed in the kundli.</p>
<h3>Mahamrityunjaya Havan</h3>
<p>The great healing mantra of Lord Shiva is offered into the fire for recovery from illness, protection from dangers and long life. Families often book this havan for elders and loved ones facing health challenges.</p>
<h3>Lakshmi and Sukh Samriddhi Havan</h3>
<p>For prosperity, abundance and peace at home, especially auspicious on Fridays, Purnima and during Diwali days.</p>
<h3>Durga and Chandi Havan</h3>
<p>Performed for strength, victory over enemies and protection from negativity, especially during Navratri.</p>

<h2>What Is Included in Your Havan Booking</h2>
<ul>
<li>Sankalp with your name, gotra and prayer intention</li>
<li>All havan samagri, ghee, herbs and offerings</li>
<li>Chanting of the specific mantras and ahutis for your chosen havan</li>
<li>Purnahuti performed in your name</li>
<li>Video of the ritual or a live streaming link</li>
<li>Prasad and vibhuti delivered to your address</li>
</ul>

<h2>How Online Havan Booking Works</h2>
<h3>Step 1: Choose your havan</h3>
<p>Select the havan that matches your intention. Not sure which one? Message us on WhatsApp and our team will guide you, or book a short astrology consultation.</p>
<h3>Step 2: Confirm date and sankalp details</h3>
<p>Share the devotee names, gotra and your wish. We confirm an auspicious muhurat.</p>
<h3>Step 3: Witness the sacred fire</h3>
<p>Join the live stream and take the sankalp with folded hands, or watch the recording later. The blessings and prasad follow you home.</p>

<h4>A Tradition That Travels With You</h4>
<p>For NRI families, a havan booked online is a way to keep the sacred fire burning in the family's life, even oceans away from home. Many devotees book havans for parents in India while joining the live stream from abroad, a beautiful bridge between generations.</p>
HTML;
}

/** Pandit booking page content. */
function epb_content_pandit() {
	return <<<'HTML'
<p>Some ceremonies need a pandit by your side. epoojabooking helps you book verified, experienced pandits for pujas at your home in India, or online ceremonies for families abroad. From griha pravesh to satyanarayan katha, every ritual is performed with correct vidhi, clear explanations and genuine care.</p>

<h2>Ceremonies Our Pandits Perform</h2>
<h3>Home and Family Pujas</h3>
<ul>
<li>Griha pravesh puja for your new home</li>
<li>Satyanarayan katha for gratitude and family harmony</li>
<li>Vastu shanti puja</li>
<li>Navagraha shanti and graha dosh nivaran</li>
<li>Birthday and anniversary pujas</li>
</ul>
<h3>Sanskars and Life Events</h3>
<ul>
<li>Naamkaran, the naming ceremony</li>
<li>Annaprashan, the first feeding</li>
<li>Mundan sanskar</li>
<li>Janeu and upanayan sanskar</li>
<li>Vivah, the complete wedding ceremony</li>
</ul>
<h3>Shanti and Shraddh Rituals</h3>
<ul>
<li>Pitra paksha shraddh and tarpan</li>
<li>Asthi visarjan guidance</li>
<li>Barsi and punyatithi pujas</li>
</ul>

<h2>Why Book Pandit Ji Through epoojabooking</h2>
<h3>Verified and Experienced</h3>
<p>Every pandit is verified for shastra knowledge and experience. You get a punctual, well prepared pandit who explains each step of the ritual so the whole family can participate with understanding.</p>
<h3>Transparent Pricing</h3>
<p>Dakshina and samagri costs are shared clearly before you book. No surprises on the day of the puja.</p>
<h3>Your Language, Your Tradition</h3>
<p>Tell us your community and language preference. We match you with pandits familiar with your parampara, whether North Indian, South Indian, Bengali, Maharashtrian, Gujarati or any other tradition.</p>

<h2>Online Pandit Services for NRI Families</h2>
<p>Living abroad? Our pandits conduct complete ceremonies over video call, guiding your family step by step through the ritual at your home in the USA, UK, Canada, Australia, UAE or anywhere in the world. Samagri lists are shared in advance so everything is ready before the ceremony begins.</p>

<h2>How Booking Works</h2>
<h3>Step 1: Tell us your ceremony and date</h3>
<p>Share the type of puja, your city or time zone, and your preferred date.</p>
<h3>Step 2: Get matched with the right pandit</h3>
<p>We confirm the pandit, the muhurat, the samagri list and the complete cost.</p>
<h3>Step 3: Celebrate with devotion</h3>
<p>Your pandit arrives prepared, on time, and performs the ceremony with full vidhi and warmth.</p>

<h4>A Small Tip for Your Puja Day</h4>
<p>Keep the puja space clean and ready an hour early, keep a small lamp lit, and let the children sit in front. Ceremonies stay in a family's memory for decades; we help make them beautiful.</p>
HTML;
}

/** FAQ page content: accordion markup, schema comes from the theme. */
function epb_content_faq() {
	$content  = '<p>Everything you need to know about booking pujas, chadhava, havan and astrology consultations on epoojabooking. If your question is not answered here, our support team is one WhatsApp message away.</p>';
	$content .= "\n<h2>Booking and Rituals</h2>\n";

	if ( function_exists( 'epb_site_faqs' ) ) {
		$faqs = epb_site_faqs();
	} else {
		$faqs = array();
	}

	$count = 0;
	foreach ( $faqs as $faq ) {
		$count++;
		if ( 5 === $count ) {
			$content .= "\n<h2>Delivery, Payments and Support</h2>\n";
		}
		$content .= '<details><summary>' . esc_html( $faq['q'] ) . '</summary><p>' . esc_html( $faq['a'] ) . "</p></details>\n";
	}

	if ( ! $faqs ) {
		$content .= '<p>Activate the epoojabooking theme to load the complete FAQ list.</p>';
	}

	return $content;
}

/** About page content. */
function epb_content_about() {
	return <<<'HTML'
<p>epoojabooking was born from a simple belief: devotion should never be limited by distance. Millions of devotees live far from the temples their hearts belong to, across India and around the world. We bridge that distance with technology, care and complete shraddha.</p>

<h2>What We Do</h2>
<p>We connect devotees with trusted temples and verified pandits across India for online puja booking, chadhava offerings, abhishek, havan, pandit services and astrology consultations. Every ritual is performed with correct vidhi, recorded or streamed live, and followed by prasad delivery to your doorstep, whether you live in Delhi, Dubai, London or New Jersey.</p>

<h2>Our Values</h2>
<h3>Authenticity</h3>
<p>Every temple and pandit on our platform is verified. Every ritual is genuine, performed with full sankalp in your name.</p>
<h3>Transparency</h3>
<p>Clear pricing, photo and video proof, and honest communication at every step.</p>
<h3>Seva Bhav</h3>
<p>We treat every booking as seva, not a transaction. Our support team guides devotees with patience, from choosing a puja to understanding the ritual.</p>

<h2>Serving Devotees Worldwide</h2>
<p>From India to the USA, UK, Canada, Australia, UAE and beyond, epoojabooking serves the global Hindu family. Multi currency payments, international prasad delivery and time zone friendly live streams make devotion borderless.</p>
HTML;
}

/** Contact page content. */
function epb_content_contact() {
	return <<<'HTML'
<p>Namaste! Our devotee support team is happy to help you with bookings, prasad delivery, muhurat guidance and anything else on your mind.</p>

<h2>Reach Us</h2>
<h3>WhatsApp</h3>
<p>The fastest way to reach us. Use the WhatsApp button at the corner of this page and we typically reply within minutes during the day.</p>
<h3>Email</h3>
<p>Write to us at <a href="mailto:support@epoojabooking.com">support@epoojabooking.com</a> and we respond within 24 hours.</p>

<h2>Booking Help</h2>
<p>Not sure which puja or chadhava suits your intention? Message us with your wish, for example health, career, marriage or peace at home, and our team will suggest the right seva and an auspicious date.</p>

<h2>Grievances and Refunds</h2>
<p>If anything about your booking falls short, tell us first. We resolve genuine issues quickly, including date changes and refunds for eligible cancellations made before the ritual is performed.</p>
HTML;
}
