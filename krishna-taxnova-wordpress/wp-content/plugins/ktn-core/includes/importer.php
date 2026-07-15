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
			}
		}
	}

	flush_rewrite_rules();
	return $counts;
}

/**
 * Create or update a page from data.
 */
function ktn_upsert_page( $page ) {
	$existing = get_page_by_path( $page['slug'], OBJECT, 'page' );
	$args     = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $page['title'],
		'post_name'    => $page['slug'],
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
