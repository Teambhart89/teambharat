<?php
/**
 * One click content importer.
 *
 * Reads bundled JSON files (data/*.json), then creates:
 *  - service categories with SEO descriptions
 *  - every service page with structured, heading rich content and 10 FAQs
 *  - core pages (Home, About, Contact, Services overview)
 *  - homepage sections and the 10 site FAQs (stored as options)
 * Also sets pretty permalinks and the static front page.
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ktn_importer_menu() {
	add_submenu_page(
		'ktn-settings',
		__( 'Import Site Content', 'ktn-core' ),
		__( 'Import Content', 'ktn-core' ),
		'manage_options',
		'ktn-import',
		'ktn_render_importer_page'
	);
}
add_action( 'admin_menu', 'ktn_importer_menu' );

function ktn_render_importer_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$done = false;
	if ( isset( $_POST['ktn_import_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['ktn_import_nonce'] ), 'ktn_import' ) ) {
		set_time_limit( 300 );
		$result = ktn_import_content();
		$done   = true;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import Krishna TaxNova Site Content', 'ktn-core' ); ?></h1>
		<?php if ( $done && ! empty( $result ) ) : ?>
			<div class="notice notice-success"><p>
				<?php
				printf(
					/* translators: counts */
					esc_html__( 'Import complete. %1$d categories, %2$d services and %3$d pages are ready. Existing items with the same slug were updated, not duplicated.', 'ktn-core' ),
					(int) $result['categories'],
					(int) $result['services'],
					(int) $result['pages']
				);
				?>
			</p></div>
			<p><a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><?php esc_html_e( 'View Website', 'ktn-core' ); ?></a></p>
		<?php else : ?>
			<p><?php esc_html_e( 'This will create all service categories, every service page with SEO content and FAQs, and the Home, About and Contact pages. Safe to run more than once.', 'ktn-core' ); ?></p>
			<form method="post">
				<?php wp_nonce_field( 'ktn_import', 'ktn_import_nonce' ); ?>
				<p><button type="submit" class="button button-primary button-hero"><?php esc_html_e( 'Import All Content Now', 'ktn-core' ); ?></button></p>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Read one JSON data file.
 */
function ktn_read_data_file( $filename ) {
	$path = KTN_CORE_DIR . 'data/' . $filename;
	if ( ! file_exists( $path ) ) {
		return null;
	}
	$json = file_get_contents( $path ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData
	return json_decode( $json, true );
}

/**
 * Run the full import.
 */
function ktn_import_content() {
	$counts = array( 'categories' => 0, 'services' => 0, 'pages' => 0 );

	// Pretty permalinks for SEO friendly URLs.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );

	$catalog = ktn_read_data_file( 'catalog.json' );
	if ( ! $catalog || empty( $catalog['categories'] ) ) {
		return $counts;
	}

	foreach ( $catalog['categories'] as $category ) {
		$term = term_exists( $category['slug'], 'service_category' );
		if ( ! $term ) {
			$term = wp_insert_term(
				$category['name'],
				'service_category',
				array(
					'slug'        => $category['slug'],
					'description' => $category['description'],
				)
			);
		} else {
			wp_update_term( (int) $term['term_id'], 'service_category', array(
				'name'        => $category['name'],
				'description' => $category['description'],
			) );
		}
		if ( is_wp_error( $term ) ) {
			continue;
		}
		$term_id = (int) $term['term_id'];
		update_term_meta( $term_id, '_ktn_icon', isset( $category['icon'] ) ? $category['icon'] : 'briefcase' );
		update_term_meta( $term_id, '_ktn_tagline', isset( $category['tagline'] ) ? $category['tagline'] : '' );
		$counts['categories']++;

		$services = ktn_read_data_file( $category['file'] );
		if ( ! is_array( $services ) ) {
			continue;
		}
		foreach ( $services as $service ) {
			ktn_import_service( $service, $term_id );
			$counts['services']++;
		}
	}

	// Site level data: homepage sections, global FAQs, About and Contact pages.
	$site = ktn_read_data_file( 'site.json' );
	if ( $site ) {
		if ( ! empty( $site['home_faqs'] ) ) {
			update_option( 'ktn_home_faqs', $site['home_faqs'] );
		}
		if ( ! empty( $site['home'] ) ) {
			update_option( 'ktn_home_data', $site['home'] );
		}
		if ( ! empty( $site['pages'] ) ) {
			foreach ( $site['pages'] as $page ) {
				$page_id = ktn_upsert_page( $page );
				if ( $page_id ) {
					$counts['pages']++;
					if ( 'home' === $page['slug'] ) {
						update_option( 'show_on_front', 'page' );
						update_option( 'page_on_front', $page_id );
					}
				}
				if ( ! empty( $page['children'] ) && is_array( $page['children'] ) ) {
					foreach ( $page['children'] as $child ) {
						if ( ktn_upsert_page( $child ) ) {
							$counts['pages']++;
						}
					}
				}
			}
		}
	}

	ktn_import_team();
	ktn_import_blog();
	ktn_import_testimonials();

	flush_rewrite_rules();
	return $counts;
}

/**
 * Seed placeholder team members (edit or replace under Team Members in admin).
 * Photos are set via Featured Image; without one an initials avatar shows.
 */
function ktn_import_team() {
	$members = array(
		array( 'CA Ankit Verma', 'Founder and Managing Partner' ),
		array( 'CA Priya Malhotra', 'Head, Direct Tax' ),
		array( 'CS Neha Aggarwal', 'Company Law and Compliance' ),
		array( 'Vikram Singh', 'GST and Indirect Tax Lead' ),
	);
	$order = 0;
	foreach ( $members as $member ) {
		$existing = get_page_by_path( sanitize_title( $member[0] ), OBJECT, 'ktn_team' );
		if ( $existing ) {
			$order++;
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'   => 'ktn_team',
				'post_status' => 'publish',
				'post_title'  => $member[0],
				'menu_order'  => $order,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_ktn_role', $member[1] );
		}
		$order++;
	}
}

/**
 * Seed placeholder testimonials (replace with real client feedback under
 * Testimonials in admin). Quote goes in the editor, details in the metabox.
 */
function ktn_import_testimonials() {
	$items = array(
		array(
			'name'   => 'Rohit Malhotra',
			'role'   => 'Founder, D2C food brand, Delhi',
			'rating' => 5,
			'quote'  => 'From company registration to monthly GST returns, one team handles everything. I send documents on WhatsApp and get confirmations the same day. In two years we have never missed a single deadline.',
		),
		array(
			'name'   => 'Sneha Kulkarni',
			'role'   => 'Freelance designer, Pune',
			'rating' => 5,
			'quote'  => 'They compared both tax regimes on my actual numbers before filing and the refund came faster than any year I filed myself. Clear answers, fixed fee, no jargon.',
		),
		array(
			'name'   => 'Amit Jain',
			'role'   => 'Director, manufacturing unit, Faridabad',
			'rating' => 5,
			'quote'  => 'Our pollution NOC and factory licenses were stuck for months with a local agent. This team mapped the requirements, fixed the application and got the consent issued. Very professional follow up.',
		),
		array(
			'name'   => 'Farha Ansari',
			'role'   => 'Trustee, education NGO, Lucknow',
			'rating' => 5,
			'quote'  => 'They registered our trust, then got 12A, 80G and Darpan done in one flow. Donors now get their receipts and certificates on time, and the annual filings run without us chasing anyone.',
		),
		array(
			'name'   => 'Karthik Iyer',
			'role'   => 'CFO, fintech startup, Bengaluru',
			'rating' => 4,
			'quote'  => 'Solid support on RBI compliance and our returns calendar. What I value most is that advice comes in writing with the rule behind it, so my board and auditors are always comfortable.',
		),
	);

	$order = 0;
	foreach ( $items as $item ) {
		if ( ! get_page_by_path( sanitize_title( $item['name'] ), OBJECT, 'ktn_testimonial' ) ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'ktn_testimonial',
					'post_status'  => 'publish',
					'post_title'   => $item['name'],
					'post_content' => $item['quote'],
					'menu_order'   => $order,
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				update_post_meta( $id, '_ktn_role', $item['role'] );
				update_post_meta( $id, '_ktn_rating', $item['rating'] );
			}
		}
		$order++;
	}
}

/**
 * Seed the blog: a Blog page (set as the posts page), starter categories and
 * three original articles so the homepage insights section is never empty.
 */
function ktn_import_blog() {
	// Blog page as the posts page.
	$blog_page = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( ! $blog_page ) {
		$blog_page_id = wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => 'Blog',
				'post_name'   => 'blog',
			)
		);
	} else {
		$blog_page_id = $blog_page->ID;
	}
	if ( $blog_page_id && ! is_wp_error( $blog_page_id ) ) {
		update_option( 'page_for_posts', $blog_page_id );
	}

	$posts = array(
		array(
			'title'    => 'Old vs New Tax Regime: How to Actually Choose This Year',
			'slug'     => 'old-vs-new-tax-regime-how-to-choose',
			'category' => 'Income Tax',
			'excerpt'  => 'The right regime depends on your deductions, not on headlines. Here is the simple three step check our CAs run for every return.',
			'content'  => '<p>Every filing season, the same question tops our inbox: old regime or new regime? The honest answer is that neither is universally better. The right choice depends on how much you genuinely claim in deductions, and it can change from year to year.</p><h2>The Three Step Check</h2><h3>Step 1: Add up your real deductions</h3><p>List what you actually use: section 80C investments, health insurance under 80D, HRA if you pay rent, home loan interest and NPS contributions. Be honest, count only what you will really claim with proof.</p><h3>Step 2: Compare tax under both regimes</h3><p>Compute tax on your income with those deductions under the old regime, and without most of them under the new regime\'s lower slabs. Our free income tax calculator on this website does this side by side in seconds.</p><h3>Step 3: Check the switching rules</h3><p>Salaried taxpayers can switch between regimes every year while filing. Business income earners face restrictions on switching back, so the decision deserves extra care before you opt.</p><h2>A Practical Rule of Thumb</h2><p>If your total deductions are substantial, commonly driven by HRA and home loan interest together, the old regime often wins. With few deductions, the new regime usually takes it. The gap can be tens of thousands of rupees, which is why we compare both regimes on every single return we file.</p><p>Want the comparison done on your actual numbers? Send your Form 16 to us on WhatsApp and we will show you both computations before filing.</p>',
		),
		array(
			'title'    => 'GST Return Filing: 7 Mistakes That Quietly Trigger Notices',
			'slug'     => 'gst-return-filing-mistakes-that-trigger-notices',
			'category' => 'GST',
			'excerpt'  => 'Most GST notices are not about evasion. They come from small, avoidable filing mistakes. Here are the seven we fix most often.',
			'content'  => '<p>The GST system compares your returns against your suppliers\' filings, your e-way bills and your bank inflows automatically. Most notices are born from small mismatches, not wrongdoing. These are the seven mistakes we see most often.</p><h2>The Seven Mistakes</h2><h3>1. Claiming credit that is not in GSTR-2B</h3><p>If your supplier has not filed, your credit is not eligible yet. Claiming it anyway creates a mismatch the system flags immediately.</p><h3>2. Differences between GSTR-1 and GSTR-3B</h3><p>Sales declared in GSTR-1 must match the tax paid in GSTR-3B. Even timing gaps need reconciliation notes, or they surface as scrutiny questions later.</p><h3>3. Skipping nil returns</h3><p>No sales does not mean no return. Missed nil returns pile up late fees daily and can suspend your registration.</p><h3>4. Wrong place of supply on interstate sales</h3><p>Charging CGST and SGST where IGST applied, or the reverse, creates tax paid under the wrong head that takes months to fix.</p><h3>5. Forgetting reverse charge entries</h3><p>Freight, legal services and imports commonly attract reverse charge. Missing them understates your liability.</p><h3>6. Ignoring credit notes and amendments</h3><p>Returns and discounts must flow through credit notes in the returns, not just in your books.</p><h3>7. No monthly reconciliation</h3><p>Books, returns and 2B should be tied out every month. Annual cleanups find problems after the cheapest window to fix them has closed.</p><h2>The Fix Is Routine, Not Heroics</h2><p>A disciplined monthly cycle with 2B reconciliation prevents virtually all of these. That is exactly what our GST return filing service runs for clients. If you have already received a notice, send it to us on WhatsApp for a free first read.</p>',
		),
		array(
			'title'    => 'Why Clean Bookkeeping Is the Cheapest Insurance Your Business Can Buy',
			'slug'     => 'clean-bookkeeping-cheapest-business-insurance',
			'category' => 'Business',
			'excerpt'  => 'Messy books do not just slow your accountant down. They cost you loans, tax savings and negotiating power exactly when you need them.',
			'content'  => '<p>Bookkeeping feels like paperwork until the moment it becomes money. A loan application, a tax deadline, an investor conversation or a notice from the department, each of these prices your books in real rupees.</p><h2>Where Messy Books Cost You</h2><h3>Bank loans get smaller and slower</h3><p>Lenders read your financial statements before they read your pitch. Unreconciled accounts and inconsistent figures shrink sanctioned amounts and stretch timelines.</p><h3>Tax savings expire silently</h3><p>Most tax planning opportunities live during the year: timing purchases, structuring salaries, choosing schemes. If your books are compiled once a year in July, every one of those windows has already closed.</p><h3>Notices become expensive</h3><p>When a GST or income tax query arrives, the answer is a reconciliation. With clean monthly books it takes a day. With a year of backlog it takes weeks, and weeks of professional time cost more than a year of bookkeeping.</p><h3>You fly blind in between</h3><p>Receivables ageing, real margins and cash runway are decisions, not reports. Businesses that see them monthly act months earlier than businesses that do not.</p><h2>What Clean Actually Means</h2><p>Clean books are reconciled with the bank every month, tie out to your GST returns, track who owes you and whom you owe, and close within days of month end. That is a process, not a talent, and it costs far less than most owners assume when it runs monthly instead of as an annual rescue.</p><p>If your books are behind, start with a cleanup and a fixed monthly rhythm. Our accounting and bookkeeping team does exactly this for businesses across India, with documents moving over WhatsApp.</p>',
		),
	);

	foreach ( $posts as $post_data ) {
		if ( get_page_by_path( $post_data['slug'], OBJECT, 'post' ) ) {
			continue;
		}
		$cat_id = 0;
		$term   = term_exists( $post_data['category'], 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $post_data['category'], 'category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$cat_id = (int) $term['term_id'];
		}
		wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $post_data['title'],
				'post_name'     => $post_data['slug'],
				'post_excerpt'  => $post_data['excerpt'],
				'post_content'  => $post_data['content'],
				'post_category' => $cat_id ? array( $cat_id ) : array(),
			)
		);
	}
}

/**
 * Create or update a page from data.
 */
function ktn_upsert_page( $page ) {
	$parent_id = 0;
	$path      = $page['slug'];
	if ( ! empty( $page['parent'] ) ) {
		$parent = get_page_by_path( $page['parent'], OBJECT, 'page' );
		if ( $parent ) {
			$parent_id = $parent->ID;
			$path      = $page['parent'] . '/' . $page['slug'];
		}
	}
	$existing = get_page_by_path( $path, OBJECT, 'page' );
	$args     = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $page['title'],
		'post_name'    => $page['slug'],
		'post_parent'  => $parent_id,
		'post_content' => isset( $page['content'] ) ? $page['content'] : '',
	);
	if ( ! empty( $page['template'] ) ) {
		$args['page_template'] = $page['template'];
	}
	if ( $existing ) {
		$args['ID'] = $existing->ID;
		$page_id    = wp_update_post( $args );
	} else {
		$page_id = wp_insert_post( $args );
	}
	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}
	if ( ! empty( $page['meta_title'] ) ) {
		update_post_meta( $page_id, '_ktn_meta_title', $page['meta_title'] );
	}
	if ( ! empty( $page['meta_description'] ) ) {
		update_post_meta( $page_id, '_ktn_meta_description', $page['meta_description'] );
	}
	return $page_id;
}

/**
 * Create or update one service post with fully composed content.
 */
function ktn_import_service( $service, $term_id ) {
	$existing = get_page_by_path( $service['slug'], OBJECT, 'service' );

	$args = array(
		'post_type'    => 'service',
		'post_status'  => 'publish',
		'post_title'   => $service['name'],
		'post_name'    => $service['slug'],
		'post_excerpt' => isset( $service['excerpt'] ) ? $service['excerpt'] : '',
		'post_content' => ktn_compose_service_content( $service ),
	);
	if ( $existing ) {
		$args['ID'] = $existing->ID;
		$post_id    = wp_update_post( $args );
	} else {
		$post_id = wp_insert_post( $args );
	}
	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return;
	}

	wp_set_object_terms( $post_id, array( $term_id ), 'service_category' );

	update_post_meta( $post_id, '_ktn_meta_title', $service['meta_title'] );
	update_post_meta( $post_id, '_ktn_meta_description', $service['meta_description'] );
	update_post_meta( $post_id, '_ktn_focus_keywords', implode( ', ', $service['keywords'] ) );
	update_post_meta( $post_id, '_ktn_timeline', isset( $service['timeline'] ) ? $service['timeline'] : '' );
	update_post_meta( $post_id, '_ktn_authority', isset( $service['authority'] ) ? $service['authority'] : '' );
	update_post_meta( $post_id, '_ktn_faqs', ktn_build_service_faqs( $service ) );
}

/**
 * Compose the on page HTML for a service with H2, H3 and H4 headings.
 */
function ktn_compose_service_content( $s ) {
	$name = $s['name'];
	$html = '';

	// Lead paragraphs.
	foreach ( (array) $s['intro'] as $para ) {
		$html .= '<p class="ktn-lead">' . $para . "</p>\n";
	}

	// Overview.
	if ( ! empty( $s['what'] ) ) {
		$html .= '<h2>' . esc_html( $s['what_heading'] ?? 'What is ' . $name . '?' ) . "</h2>\n";
		foreach ( (array) $s['what'] as $para ) {
			$html .= '<p>' . $para . "</p>\n";
		}
	}

	// Who needs it.
	if ( ! empty( $s['who'] ) ) {
		$html .= '<h2>' . esc_html( $s['who_heading'] ?? 'Who Should Apply for ' . $name . '?' ) . "</h2>\n<ul>\n";
		foreach ( (array) $s['who'] as $item ) {
			$html .= '<li>' . $item . "</li>\n";
		}
		$html .= "</ul>\n";
	}

	// Benefits with H3 per benefit.
	if ( ! empty( $s['benefits'] ) ) {
		$html .= '<h2>' . esc_html( $s['benefits_heading'] ?? 'Benefits of ' . $name ) . "</h2>\n";
		$html .= '<div class="ktn-benefits">' . "\n";
		foreach ( (array) $s['benefits'] as $benefit ) {
			$html .= '<div class="ktn-benefit"><h3>' . esc_html( $benefit[0] ) . '</h3><p>' . $benefit[1] . "</p></div>\n";
		}
		$html .= "</div>\n";
	}

	// Documents.
	if ( ! empty( $s['documents'] ) ) {
		$html .= '<h2>Documents Required for ' . esc_html( $name ) . "</h2>\n";
		$html .= '<p>Keep these documents ready. You can upload them using the form on this page or send them to us on WhatsApp.</p>' . "\n<ul class=\"ktn-doc-list\">\n";
		foreach ( (array) $s['documents'] as $doc ) {
			$html .= '<li>' . $doc . "</li>\n";
		}
		$html .= "</ul>\n";
	}

	// Process with H3 steps.
	if ( ! empty( $s['process'] ) ) {
		$html .= '<h2>' . esc_html( $s['process_heading'] ?? 'Step by Step Process for ' . $name ) . "</h2>\n";
		$html .= '<ol class="ktn-steps">' . "\n";
		$step_no = 1;
		foreach ( (array) $s['process'] as $step ) {
			$html .= '<li><h3>Step ' . $step_no . ': ' . esc_html( $step[0] ) . '</h3><p>' . $step[1] . "</p></li>\n";
			$step_no++;
		}
		$html .= "</ol>\n";
	}

	// Quick facts with H4 headings.
	$facts = array();
	if ( ! empty( $s['timeline'] ) ) {
		$facts['Estimated Timeline'] = $s['timeline'];
	}
	if ( ! empty( $s['authority'] ) ) {
		$facts['Governing Authority'] = $s['authority'];
	}
	if ( ! empty( $s['validity'] ) ) {
		$facts['Validity'] = $s['validity'];
	}
	if ( ! empty( $s['fees_note'] ) ) {
		$facts['Government Fees'] = $s['fees_note'];
	}
	if ( $facts ) {
		$html .= '<h2>' . esc_html( $name ) . " at a Glance</h2>\n<div class=\"ktn-facts\">\n";
		foreach ( $facts as $label => $value ) {
			$html .= '<div class="ktn-fact"><h4>' . esc_html( $label ) . '</h4><p>' . esc_html( $value ) . "</p></div>\n";
		}
		$html .= "</div>\n";
	}

	// Why choose us, tailored line plus standing points.
	$html .= "<h2>Why Choose Krishna TaxNova for " . esc_html( $name ) . "?</h2>\n";
	if ( ! empty( $s['why_us'] ) ) {
		$html .= '<p>' . $s['why_us'] . "</p>\n";
	}
	$html .= '<div class="ktn-benefits">' . "\n";
	$why_points = array(
		array( 'CA Led Team in Delhi', 'Your work is handled by a qualified Chartered Accountant team, not a call center. You get correct advice the first time.' ),
		array( 'Upload Documents Online', 'Share everything from your phone or laptop. Use the secure upload form on this page or simply WhatsApp us your documents.' ),
		array( 'Transparent Pricing', 'You approve a clear quote before we start. No hidden charges at any stage.' ),
		array( 'End to End Support', 'From document collection to final approval and post registration compliance, one team stays with you throughout.' ),
	);
	foreach ( $why_points as $point ) {
		$html .= '<div class="ktn-benefit"><h3>' . esc_html( $point[0] ) . '</h3><p>' . esc_html( $point[1] ) . "</p></div>\n";
	}
	$html .= "</div>\n";

	return $html;
}

/**
 * Build 10 FAQs per service: unique FAQs from data plus fact based FAQs
 * composed from the service fields so every answer stays specific.
 */
function ktn_build_service_faqs( $s ) {
	$name = $s['name'];
	$faqs = array();

	foreach ( (array) ( $s['faqs'] ?? array() ) as $faq ) {
		$faqs[] = array( 'q' => $faq[0], 'a' => $faq[1] );
	}

	$generated = array();

	if ( ! empty( $s['timeline'] ) ) {
		$generated[] = array(
			'q' => 'How long does ' . $name . ' take?',
			'a' => 'In most cases the work is completed in ' . $s['timeline'] . '. The exact time depends on how quickly documents are shared and on processing time at the department. We keep you updated at every stage.',
		);
	}
	if ( ! empty( $s['documents'] ) ) {
		$generated[] = array(
			'q' => 'What documents are needed for ' . $name . '?',
			'a' => 'The key documents include ' . strtolower( implode( ', ', array_slice( array_map( 'wp_strip_all_tags', (array) $s['documents'] ), 0, 4 ) ) ) . '. Our team shares a simple checklist after the first call so nothing is missed.',
		);
	}
	$generated[] = array(
		'q' => 'Can I complete ' . $name . ' fully online?',
		'a' => 'Yes. The entire process is online. Fill the form on this page, upload your documents or WhatsApp them to us, and our experts handle the filings. You do not need to visit any office.',
	);
	if ( ! empty( $s['authority'] ) ) {
		$generated[] = array(
			'q' => 'Which authority handles ' . $name . '?',
			'a' => $name . ' falls under ' . $s['authority'] . '. Krishna TaxNova prepares and files your application in the required format and responds to any queries raised by the department.',
		);
	}
	if ( ! empty( $s['validity'] ) ) {
		$generated[] = array(
			'q' => 'What is the validity of ' . $name . '?',
			'a' => 'The validity is ' . lcfirst( $s['validity'] ) . '. We send renewal and compliance reminders in advance so you never miss a due date.',
		);
	}
	$generated[] = array(
		'q' => 'Do you provide ' . $name . ' outside Delhi?',
		'a' => 'Yes. We are based in Delhi and serve clients across India. Since the process is fully online, your location does not matter. Documents can be shared through the website or WhatsApp.',
	);
	$generated[] = array(
		'q' => 'How much does ' . $name . ' cost?',
		'a' => 'Fees depend on your exact requirement' . ( ! empty( $s['fees_note'] ) ? ' and applicable government charges (' . lcfirst( $s['fees_note'] ) . ')' : '' ) . '. Share your details through the form or WhatsApp and you will receive a clear, fixed quote before any work begins.',
	);
	$generated[] = array(
		'q' => 'Why should a CA firm handle my ' . $name . '?',
		'a' => 'Small errors in applications and filings lead to rejections, notices and penalties. A qualified CA team reviews your documents, chooses the correct options and stays responsible for the filing, which saves time and risk.',
	);

	foreach ( $generated as $faq ) {
		if ( count( $faqs ) >= 10 ) {
			break;
		}
		$faqs[] = $faq;
	}

	return array_slice( $faqs, 0, 10 );
}
