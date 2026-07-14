<?php
/**
 * One-click site setup.
 *
 * On theme activation this creates every page, both menus, sample
 * publications, events, analysis posts and team members, then wires up
 * the front page, posts page and permalinks. Runs once (guarded by an
 * option) so re-activating never duplicates content.
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cihs_run_site_setup() {
	if ( get_option( 'cihs_setup_done' ) ) {
		return;
	}

	// CPTs must exist before we insert into them.
	cihs_register_post_types();

	$pages = cihs_setup_pages();
	cihs_setup_focus_terms();
	cihs_setup_publications();
	cihs_setup_events();
	cihs_setup_team();
	cihs_setup_posts();
	cihs_setup_menus( $pages );

	// Front page + posts page.
	if ( isset( $pages['home'], $pages['analysis'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
		update_option( 'page_for_posts', $pages['analysis'] );
	}

	// Pretty permalinks so CPT archives resolve.
	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();

	update_option( 'blogdescription', 'A non-partisan, independent research think tank headquartered in New Delhi, India' );
	update_option( 'cihs_setup_done', 1 );
}
add_action( 'after_switch_theme', 'cihs_run_site_setup' );

/* --------------------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------------------ */

/**
 * Insert a page if a page with that slug doesn't already exist.
 *
 * @return int Page ID.
 */
function cihs_make_page( $slug, $title, $content, $parent = 0, $order = 0 ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return $existing->ID;
	}
	return wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
			'post_parent'  => $parent,
			'menu_order'   => $order,
		)
	);
}

/**
 * Wrap heading + paragraphs in block markup.
 */
function cihs_blocks( $html ) {
	return $html;
}

/* --------------------------------------------------------------------------
 * Pages
 * ------------------------------------------------------------------------ */
function cihs_setup_pages() {
	$ids = array();

	$ids['home'] = cihs_make_page( 'home', 'Home', '<!-- wp:paragraph --><p>This page uses the theme\'s dynamic front-page template. Edit hero slides under Appearance → Customize → CIHS: Homepage Hero Slides.</p><!-- /wp:paragraph -->' );

	/* ---------- About ---------- */
	$ids['about'] = cihs_make_page(
		'about-cihs',
		'About CIHS',
		'<!-- wp:heading --><h2 class="wp-block-heading">Who We Are</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>The Centre for Integrated and Holistic Studies (CIHS) is a non-partisan, independent research think tank headquartered in New Delhi, India. Founded in 2021, CIHS is committed to bringing innovative ideas to society, fostering informed public debate, promoting good policy and programme formulation, and enhancing individual decision-making on some of the world\'s most pressing issues.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Our scholars provide thought leadership on the cultural, societal and geopolitical dynamics that define the 21st century. We brief governments, the media and the wider public through clear, in-depth analysis and accessible multimedia content — shaping discourse with research rooted in evidence and in Bharat\'s civilisational wisdom.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Our Approach</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>We facilitate impartial discourse on evolving issues that affect people in India and abroad by creating a culture of informed public engagement. Our work is holistic, equitable and inclusive, drawing on interdisciplinary knowledge frameworks to pre-empt, recognise and provide sustainable solutions to people\'s issues.</p><!-- /wp:paragraph -->
<!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>Vasudhaiva Kutumbakam — the world is one family. Our research begins from this conviction.</p><!-- /wp:paragraph --></blockquote><!-- /wp:quote -->
<!-- wp:heading --><h2 class="wp-block-heading">What We Do</h2><!-- /wp:heading -->
<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>Produce impactful research papers, reports and issue briefs on pressing national and global questions.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Convene lectures, seminars, round tables and interaction series with thought leaders and practitioners.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Build a diverse global network of solution-oriented thought leaders.</li><!-- /wp:list-item --><!-- wp:list-item --><li>Publish accessible commentary and multimedia analysis for the wider public.</li><!-- /wp:list-item --></ul><!-- /wp:list -->'
	);

	$ids['mission'] = cihs_make_page(
		'mission-vision',
		'Mission & Vision',
		'<!-- wp:heading --><h2 class="wp-block-heading">Our Vision</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>To empower individuals and societies to navigate and adapt to the complexities of our evolving world, guided by the philosophy of oneness rooted in Vasudhaiva Kutumbakam and the coexistence of tradition and modernity.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Our Mission</h2><!-- /wp:heading -->
<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li><strong>Informed discourse:</strong> facilitate impartial debate on evolving issues affecting people in India and abroad.</li><!-- /wp:list-item --><!-- wp:list-item --><li><strong>Global network:</strong> build a diverse, solution-oriented community of thought leaders across democracies.</li><!-- /wp:list-item --><!-- wp:list-item --><li><strong>Sustainable solutions:</strong> pre-empt, recognise and address societal challenges through holistic, equitable, inclusive and research-based approaches.</li><!-- /wp:list-item --><!-- wp:list-item --><li><strong>Policy impact:</strong> promote good policy and programme formulation through rigorous, interdisciplinary research.</li><!-- /wp:list-item --></ul><!-- /wp:list -->
<!-- wp:heading --><h2 class="wp-block-heading">Our Values</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Independence, intellectual honesty, civilisational rootedness, openness to dialogue, and a commitment to the common good — these values guide every study we publish and every conversation we convene.</p><!-- /wp:paragraph -->',
		$ids['about']
	);

	$ids['team'] = cihs_make_page(
		'our-team',
		'Our Team',
		'<!-- wp:paragraph --><p>CIHS is powered by a dedicated team of research scholars, thought leaders and professionals committed to advancing the understanding of culture, society and policy. This page automatically lists everyone added under <strong>Team</strong> in the WordPress dashboard.</p><!-- /wp:paragraph -->',
		$ids['about']
	);

	/* ---------- Research ---------- */
	$research_intro = '<!-- wp:paragraph --><p>CIHS research spans the questions that will define India\'s next decades. Each focus area below combines rigorous evidence with an integrated, holistic reading of society. Explore our <a href="/publications/">publications</a> and <a href="/analysis/">analysis</a> for the latest output in every area.</p><!-- /wp:paragraph -->';
	$ids['research'] = cihs_make_page( 'research', 'Research & Focus Areas', $research_intro );

	$areas = array(
		'geopolitics-security'    => array(
			'Geopolitics & National Security',
			'From West Asia tensions and the Indo-Pacific to terrorism and hybrid threats, CIHS analyses the shifting strategic environment and the long-term posture Bharat needs to manage regional and global uncertainty.',
		),
		'policy-governance'       => array(
			'Policy & Governance',
			'We study public policy design and delivery — evaluating programmes, institutions and reforms with an emphasis on outcomes that are equitable, sustainable and rooted in ground realities.',
		),
		'economy-technology'      => array(
			'Economy & Technology',
			'Aatmanirbhar Bharat, frontier technology, artificial intelligence, energy security and indigenous innovation: our work maps how self-reliance and openness can advance together.',
		),
		'culture-civilisation'    => array(
			'Culture & Civilisational Studies',
			'CIHS documents and interprets Bharat\'s living civilisational heritage — from Kashmir\'s temple traditions to contemporary cultural dynamics — and its relevance to modern policy and identity.',
		),
		'diaspora-global'         => array(
			'Diaspora & Global Engagement',
			'The Indian diaspora is a bridge between democracies. We examine its role in diplomacy, technology, culture and the deepening of India\'s partnerships across the world.',
		),
	);
	foreach ( $areas as $slug => $area ) {
		$ids[ $slug ] = cihs_make_page(
			$slug,
			$area[0],
			'<!-- wp:paragraph --><p>' . $area[1] . '</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">What we examine</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Our scholars publish issue briefs, commentary and long-form reports in this area throughout the year. Browse the <a href="/publications/">publications library</a> or <a href="/contact/">write to us</a> to collaborate on research in this field.</p><!-- /wp:paragraph -->',
			$ids['research']
		);
	}

	/* ---------- Analysis (posts page) ---------- */
	$ids['analysis'] = cihs_make_page( 'analysis', 'Analysis & Commentary', '' );

	/* ---------- Media ---------- */
	$ids['media'] = cihs_make_page(
		'media',
		'Media & Press',
		'<!-- wp:heading --><h2 class="wp-block-heading">CIHS in the Media</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Our experts regularly brief journalists and appear across print, television and digital platforms. For interview requests, press accreditation for CIHS events, or media partnerships, please contact our communications desk via the <a href="/contact/">contact page</a>.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Multimedia</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Watch lectures, panel discussions and explainers on our <a href="https://www.youtube.com/@CIHS_India" target="_blank" rel="noopener">YouTube channel</a>, and follow daily commentary on <a href="https://x.com/cihs_india" target="_blank" rel="noopener">X (Twitter)</a> and <a href="https://www.facebook.com/CIHSofficial/" target="_blank" rel="noopener">Facebook</a>.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Press Releases</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Official statements and announcements from CIHS are published in our <a href="/publications/">publications</a> section under the Press Release type.</p><!-- /wp:paragraph -->'
	);

	/* ---------- Get involved ---------- */
	$ids['careers'] = cihs_make_page(
		'careers-internships',
		'Careers & Internships',
		'<!-- wp:paragraph --><p>CIHS welcomes researchers, writers, editors and interns who share our commitment to rigorous, holistic scholarship. We offer research fellowships, internships for students and early-career professionals, and volunteer opportunities around our events.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">How to apply</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Send your CV, a short statement of interest and a writing sample through the <a href="/contact/">contact form</a>, selecting “Internships &amp; Careers” as the subject. Shortlisted candidates will hear from us within three weeks.</p><!-- /wp:paragraph -->'
	);

	/* ---------- Contact ---------- */
	$ids['contact'] = cihs_make_page(
		'contact',
		'Contact Us',
		'<!-- wp:paragraph --><p>We welcome questions, collaboration proposals and media enquiries. Fill in the form below or reach us directly using the details on this page.</p><!-- /wp:paragraph -->
<!-- wp:shortcode -->[cihs_contact_form]<!-- /wp:shortcode -->'
	);

	/* ---------- Legal ---------- */
	$ids['privacy'] = cihs_make_page(
		'privacy-policy-cihs',
		'Privacy Policy',
		'<!-- wp:paragraph --><p>The Centre for Integrated and Holistic Studies (“CIHS”, “we”) respects your privacy. This policy explains what information we collect through this website and how we use it.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Information we collect</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>We collect information you voluntarily provide — such as your name, email address and message when you use our contact form or subscribe to updates — and standard technical data (such as browser type and pages visited) used in aggregate to improve the site.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">How we use it</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Your details are used only to respond to your enquiry, share updates you have requested, and administer our events. We do not sell or rent personal information to third parties.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Contact</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>For any privacy-related request, including correction or deletion of your data, please write to us via the <a href="/contact/">contact page</a>.</p><!-- /wp:paragraph -->'
	);

	$ids['terms'] = cihs_make_page(
		'terms-of-use',
		'Terms of Use',
		'<!-- wp:paragraph --><p>By using this website you agree to these terms. Content published by CIHS — including research papers, commentary and multimedia — is provided for information and public education.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Use of content</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>You may quote or share our work with clear attribution to “Centre for Integrated and Holistic Studies (CIHS)” and a link to the original page. Commercial reproduction requires prior written permission.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Disclaimer</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Views expressed in individual publications are those of their authors. CIHS is a non-partisan institution and does not take institutional positions on policy matters.</p><!-- /wp:paragraph -->'
	);

	return $ids;
}

/* --------------------------------------------------------------------------
 * Focus-area terms
 * ------------------------------------------------------------------------ */
function cihs_setup_focus_terms() {
	$terms = array(
		'Geopolitics & Security',
		'Policy & Governance',
		'Economy & Technology',
		'Culture & Civilisation',
		'Diaspora & Global Engagement',
	);
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'cihs_focus_area' ) ) {
			wp_insert_term( $term, 'cihs_focus_area' );
		}
	}

	$types = array( 'Research Paper', 'Report', 'Issue Brief', 'Press Release' );
	foreach ( $types as $type ) {
		if ( ! term_exists( $type, 'cihs_publication_type' ) ) {
			wp_insert_term( $type, 'cihs_publication_type' );
		}
	}
}

/* --------------------------------------------------------------------------
 * Sample publications
 * ------------------------------------------------------------------------ */
function cihs_setup_publications() {
	$pubs = array(
		array(
			'title'   => 'India\'s Moral Diplomacy: Vasudhaiva Kutumbakam in an Age of Conflict',
			'type'    => 'Issue Brief',
			'area'    => 'Geopolitics & Security',
			'excerpt' => 'How the philosophy of oneness shapes India\'s diplomatic posture amid global conflict, and what a values-anchored foreign policy offers a fragmenting world order.',
		),
		array(
			'title'   => 'Kashmir\'s Temple Heritage: A Testament to Bharat\'s Enduring Civilisation',
			'type'    => 'Report',
			'area'    => 'Culture & Civilisation',
			'excerpt' => 'A survey of the rich history, architecture and spiritual significance of Kashmir\'s Hindu temples, and the case for their documentation and preservation.',
		),
		array(
			'title'   => 'Swadeshi Goes Hi-Tech: Self-Reliance in Frontier Technology',
			'type'    => 'Research Paper',
			'area'    => 'Economy & Technology',
			'excerpt' => 'Mapping Aatmanirbhar Bharat\'s progress in advanced technology — from semiconductors to space — and the policy levers that can accelerate indigenous innovation.',
		),
		array(
			'title'   => 'Managed Unstable Equilibrium? Bharat\'s Long Game in West Asia',
			'type'    => 'Issue Brief',
			'area'    => 'Geopolitics & Security',
			'excerpt' => 'West Asia\'s tensions demand long-term tactics, not episodic responses. This brief outlines a framework for managing regional uncertainty.',
		),
		array(
			'title'   => 'Desi GAGAN to Power Bharat\'s Aviation',
			'type'    => 'Issue Brief',
			'area'    => 'Economy & Technology',
			'excerpt' => 'How India\'s indigenous satellite-based augmentation system strengthens aviation safety, connectivity and strategic autonomy.',
		),
		array(
			'title'   => 'The Indian Diaspora as a Bridge Between Democracies',
			'type'    => 'Research Paper',
			'area'    => 'Diaspora & Global Engagement',
			'excerpt' => 'The diaspora\'s growing role in technology, culture and diplomacy — and how it deepens India\'s partnerships across democratic societies.',
		),
	);

	foreach ( $pubs as $i => $pub ) {
		if ( get_page_by_path( sanitize_title( $pub['title'] ), OBJECT, 'cihs_publication' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'cihs_publication',
				'post_status'  => 'publish',
				'post_title'   => $pub['title'],
				'post_excerpt' => $pub['excerpt'],
				'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( "-{$i} weeks" ) ),
				'post_content' => '<!-- wp:paragraph --><p>' . $pub['excerpt'] . '</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><em>This is sample content created by the CIHS theme. Replace it with the full text or attach the PDF of the actual publication.</em></p><!-- /wp:paragraph -->',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			wp_set_object_terms( $id, $pub['type'], 'cihs_publication_type' );
			wp_set_object_terms( $id, $pub['area'], 'cihs_focus_area' );
		}
	}
}

/* --------------------------------------------------------------------------
 * Sample events
 * ------------------------------------------------------------------------ */
function cihs_setup_events() {
	$events = array(
		array(
			'title'   => '100 Years\' Journey of RSS: New Horizons — Lecture & Interaction Series',
			'date'    => '2025-08-26',
			'time'    => '10:00 AM onwards',
			'venue'   => 'Vigyan Bhawan, New Delhi',
			'excerpt' => 'A special three-day lecture and interaction series (26–28 August 2025) examining a century-long journey and the horizons ahead.',
		),
		array(
			'title'   => 'Round Table: Technology Sovereignty and Aatmanirbhar Bharat',
			'date'    => gmdate( 'Y-m-d', strtotime( '+3 weeks' ) ),
			'time'    => '3:00 PM – 5:30 PM',
			'venue'   => 'CIHS Office, Sector 29, Noida',
			'excerpt' => 'Scholars and industry practitioners discuss the policy architecture India needs for self-reliance in frontier technology.',
		),
		array(
			'title'   => 'Seminar: The Indian Diaspora and the Future of Democratic Partnerships',
			'date'    => gmdate( 'Y-m-d', strtotime( '+6 weeks' ) ),
			'time'    => '11:00 AM – 1:00 PM',
			'venue'   => 'India International Centre, New Delhi',
			'excerpt' => 'A half-day seminar on the diaspora\'s role as a civilisational and strategic bridge between democracies.',
		),
	);

	foreach ( $events as $event ) {
		if ( get_page_by_path( sanitize_title( $event['title'] ), OBJECT, 'cihs_event' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'cihs_event',
				'post_status'  => 'publish',
				'post_title'   => $event['title'],
				'post_excerpt' => $event['excerpt'],
				'post_content' => '<!-- wp:paragraph --><p>' . $event['excerpt'] . '</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><em>Sample event created by the CIHS theme — edit the details, agenda and registration link from the Events menu in the dashboard.</em></p><!-- /wp:paragraph -->',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_cihs_event_date', $event['date'] );
			update_post_meta( $id, '_cihs_event_time', $event['time'] );
			update_post_meta( $id, '_cihs_event_venue', $event['venue'] );
		}
	}
}

/* --------------------------------------------------------------------------
 * Placeholder team members (replace with real people)
 * ------------------------------------------------------------------------ */
function cihs_setup_team() {
	$members = array(
		array( 'Director — Add Name', 'Director', 'Provides strategic direction to CIHS research and partnerships. Replace this placeholder with the director\'s biography.' ),
		array( 'Senior Fellow — Add Name', 'Senior Research Fellow', 'Leads the geopolitics and security programme. Replace this placeholder with the fellow\'s biography.' ),
		array( 'Research Fellow — Add Name', 'Research Fellow', 'Works on economy, technology and self-reliance studies. Replace this placeholder with the fellow\'s biography.' ),
		array( 'Research Associate — Add Name', 'Research Associate', 'Supports the culture and civilisational studies programme. Replace this placeholder with the associate\'s biography.' ),
	);
	foreach ( $members as $order => $member ) {
		if ( get_page_by_path( sanitize_title( $member[0] ), OBJECT, 'cihs_team' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'cihs_team',
				'post_status'  => 'publish',
				'post_title'   => $member[0],
				'post_content' => '<!-- wp:paragraph --><p>' . $member[2] . '</p><!-- /wp:paragraph -->',
				'menu_order'   => $order,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_cihs_team_role', $member[1] );
		}
	}
}

/* --------------------------------------------------------------------------
 * Sample analysis posts
 * ------------------------------------------------------------------------ */
function cihs_setup_posts() {
	$cats = array();
	foreach ( array( 'Bharat', 'International', 'Security', 'Technology', 'Economy', 'Culture' ) as $cat ) {
		$term = term_exists( $cat, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $cat, 'category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$cats[ $cat ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
		}
	}

	$posts = array(
		array(
			'title'   => 'Khalistani Terror Propaganda Puts Bharat and the US on Edge',
			'cat'     => 'Security',
			'excerpt' => 'Extremist propaganda networks are testing the resilience of the India–US partnership. What both democracies must do to counter them together.',
		),
		array(
			'title'   => 'Civilisational Vision and the Future of Technology Leadership',
			'cat'     => 'Technology',
			'excerpt' => 'Innovation is not value-neutral. A civilisational lens offers a humane framework for AI, biotechnology and the technologies reshaping society.',
		),
		array(
			'title'   => 'Tradition and Modernity: A False Binary for a Rising Bharat',
			'cat'     => 'Culture',
			'excerpt' => 'India\'s development story shows tradition and modernity advancing together — a coexistence the world increasingly looks to understand.',
		),
	);

	foreach ( $posts as $i => $post ) {
		if ( get_page_by_path( sanitize_title( $post['title'] ), OBJECT, 'post' ) ) {
			continue;
		}
		wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $post['title'],
				'post_excerpt'  => $post['excerpt'],
				'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( $i + 1 ) . ' days' ) ),
				'post_category' => isset( $cats[ $post['cat'] ] ) ? array( $cats[ $post['cat'] ] ) : array(),
				'post_content'  => '<!-- wp:paragraph --><p>' . $post['excerpt'] . '</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><em>Sample commentary created by the CIHS theme. Replace with the full article text.</em></p><!-- /wp:paragraph -->',
			)
		);
	}
}

/* --------------------------------------------------------------------------
 * Menus
 * ------------------------------------------------------------------------ */
function cihs_setup_menus( $pages ) {

	/* ----- Primary menu ----- */
	$menu_id = cihs_fresh_menu( 'CIHS Primary Menu' );
	if ( $menu_id ) {
		$home = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Home',
			'menu-item-url'    => home_url( '/' ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		) );

		$about = cihs_menu_page_item( $menu_id, $pages['about'], 'About' );
		cihs_menu_page_item( $menu_id, $pages['about'], 'About CIHS', $about );
		cihs_menu_page_item( $menu_id, $pages['mission'], 'Mission & Vision', $about );
		cihs_menu_page_item( $menu_id, $pages['team'], 'Our Team', $about );
		cihs_menu_page_item( $menu_id, $pages['careers'], 'Careers & Internships', $about );

		$research = cihs_menu_page_item( $menu_id, $pages['research'], 'Research' );
		cihs_menu_page_item( $menu_id, $pages['geopolitics-security'], 'Geopolitics & Security', $research );
		cihs_menu_page_item( $menu_id, $pages['policy-governance'], 'Policy & Governance', $research );
		cihs_menu_page_item( $menu_id, $pages['economy-technology'], 'Economy & Technology', $research );
		cihs_menu_page_item( $menu_id, $pages['culture-civilisation'], 'Culture & Civilisation', $research );
		cihs_menu_page_item( $menu_id, $pages['diaspora-global'], 'Diaspora & Global Engagement', $research );

		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Publications',
			'menu-item-url'    => home_url( '/publications/' ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		) );
		cihs_menu_page_item( $menu_id, $pages['analysis'], 'Analysis' );
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Events',
			'menu-item-url'    => home_url( '/events/' ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		) );
		cihs_menu_page_item( $menu_id, $pages['media'], 'Media' );
		cihs_menu_page_item( $menu_id, $pages['contact'], 'Contact' );

		cihs_assign_menu( 'primary', $menu_id );
	}

	/* ----- Footer quick links ----- */
	$footer_id = cihs_fresh_menu( 'CIHS Footer Menu' );
	if ( $footer_id ) {
		cihs_menu_page_item( $footer_id, $pages['about'], 'About CIHS' );
		wp_update_nav_menu_item( $footer_id, 0, array(
			'menu-item-title'  => 'Publications',
			'menu-item-url'    => home_url( '/publications/' ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		) );
		wp_update_nav_menu_item( $footer_id, 0, array(
			'menu-item-title'  => 'Events',
			'menu-item-url'    => home_url( '/events/' ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		) );
		cihs_menu_page_item( $footer_id, $pages['analysis'], 'Analysis' );
		cihs_menu_page_item( $footer_id, $pages['careers'], 'Careers' );
		cihs_menu_page_item( $footer_id, $pages['contact'], 'Contact' );
		cihs_assign_menu( 'footer', $footer_id );
	}

	/* ----- Legal menu ----- */
	$legal_id = cihs_fresh_menu( 'CIHS Legal Menu' );
	if ( $legal_id ) {
		cihs_menu_page_item( $legal_id, $pages['privacy'], 'Privacy Policy' );
		cihs_menu_page_item( $legal_id, $pages['terms'], 'Terms of Use' );
		cihs_assign_menu( 'legal', $legal_id );
	}
}

/**
 * Create a menu by name, or return the existing one (without duplicating items).
 *
 * @return int|false Menu ID, or false if it already exists with items.
 */
function cihs_fresh_menu( $name ) {
	$existing = wp_get_nav_menu_object( $name );
	if ( $existing ) {
		$items = wp_get_nav_menu_items( $existing->term_id );
		return $items ? false : (int) $existing->term_id;
	}
	$id = wp_create_nav_menu( $name );
	return is_wp_error( $id ) ? false : (int) $id;
}

/**
 * Add a page item to a menu.
 *
 * @return int Menu item ID.
 */
function cihs_menu_page_item( $menu_id, $page_id, $title, $parent = 0 ) {
	return wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => $title,
			'menu-item-object'    => 'page',
			'menu-item-object-id' => (int) $page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => (int) $parent,
		)
	);
}

/**
 * Assign a menu to a theme location, preserving other locations.
 */
function cihs_assign_menu( $location, $menu_id ) {
	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = (int) $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
