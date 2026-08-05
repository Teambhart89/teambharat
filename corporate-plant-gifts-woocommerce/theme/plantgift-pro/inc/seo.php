<?php
/**
 * Light SEO layer.
 *
 * Everything here stands down automatically when Yoast SEO, Rank Math, SEOPress
 * or All in One SEO is active, so nothing is ever emitted twice.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Detect a dedicated SEO plugin.
 *
 * @return bool
 */
function plantgift_pro_seo_plugin_active() {
	return (
		defined( 'WPSEO_VERSION' )
		|| class_exists( 'RankMath' )
		|| defined( 'SEOPRESS_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
	);
}

/**
 * Output the meta description, canonical URL and social tags.
 */
function plantgift_pro_head_meta() {
	if ( plantgift_pro_seo_plugin_active() ) {
		return;
	}

	$description = '';
	$canonical   = '';
	$image       = '';
	$type        = 'website';

	if ( is_front_page() ) {
		$description = get_bloginfo( 'description' );
		$canonical   = home_url( '/' );
	} elseif ( is_singular() ) {
		$post_id     = get_queried_object_id();
		$description = get_post_meta( $post_id, '_pg_meta_description', true );
		if ( ! $description ) {
			$description = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) ), 32 );
		}
		$canonical = get_permalink( $post_id );
		$image     = get_the_post_thumbnail_url( $post_id, 'plantgift-wide' );
		$type      = is_singular( 'post' ) ? 'article' : ( is_singular( 'product' ) ? 'product' : 'website' );
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$description = get_term_meta( $term->term_id, '_pg_meta_description', true );
			if ( ! $description ) {
				$description = wp_trim_words( wp_strip_all_tags( $term->description ), 32 );
			}
			$canonical = get_term_link( $term );
			$thumb_id  = get_term_meta( $term->term_id, 'thumbnail_id', true );
			if ( $thumb_id ) {
				$image = wp_get_attachment_image_url( $thumb_id, 'plantgift-wide' );
			}
		}
	} elseif ( is_post_type_archive() ) {
		$description = get_the_archive_description();
		$canonical   = get_post_type_archive_link( get_post_type() );
	}

	$description = trim( wp_strip_all_tags( (string) $description ) );
	if ( mb_strlen( $description ) > 158 ) {
		$description = mb_substr( $description, 0, 155 ) . '...';
	}

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}

	if ( $canonical && ! is_wp_error( $canonical ) ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}

	// Open Graph and Twitter.
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $canonical && ! is_wp_error( $canonical ) ) {
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	}
	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	} else {
		echo '<meta name="twitter:card" content="summary">' . "\n";
	}
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	if ( $description ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $description ) );
	}

	// Keep thin pages out of the index.
	if ( is_search() || is_404() || ( is_paged() && is_front_page() ) ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	}
}
add_action( 'wp_head', 'plantgift_pro_head_meta', 2 );

/**
 * Meta description field on posts, pages and products.
 */
function plantgift_pro_meta_box() {
	if ( plantgift_pro_seo_plugin_active() ) {
		return;
	}
	foreach ( array( 'post', 'page', 'product' ) as $screen ) {
		add_meta_box(
			'plantgift_seo',
			__( 'Search snippet', 'plantgift-pro' ),
			'plantgift_pro_meta_box_html',
			$screen,
			'normal',
			'default'
		);
	}
}
add_action( 'add_meta_boxes', 'plantgift_pro_meta_box' );

/**
 * Render the meta box.
 *
 * @param WP_Post $post Current post.
 */
function plantgift_pro_meta_box_html( $post ) {
	wp_nonce_field( 'plantgift_seo_save', 'plantgift_seo_nonce' );
	$value = get_post_meta( $post->ID, '_pg_meta_description', true );
	?>
	<p>
		<label for="pg-meta-description"><strong><?php esc_html_e( 'Meta description', 'plantgift-pro' ); ?></strong></label>
		<textarea id="pg-meta-description" name="pg_meta_description" rows="3" style="width:100%;" maxlength="160"><?php echo esc_textarea( $value ); ?></textarea>
		<span class="description"><?php esc_html_e( 'Aim for 140 to 158 characters. Lead with the benefit, then name the product or service once.', 'plantgift-pro' ); ?></span>
	</p>
	<?php
}

/**
 * Save the meta description.
 *
 * @param int $post_id Post ID.
 */
function plantgift_pro_meta_box_save( $post_id ) {
	if ( ! isset( $_POST['plantgift_seo_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['plantgift_seo_nonce'] ) ), 'plantgift_seo_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['pg_meta_description'] ) ) {
		update_post_meta( $post_id, '_pg_meta_description', sanitize_textarea_field( wp_unslash( $_POST['pg_meta_description'] ) ) );
	}
}
add_action( 'save_post', 'plantgift_pro_meta_box_save' );

/**
 * Organization, WebSite and LocalBusiness graph.
 */
function plantgift_pro_org_schema() {
	if ( plantgift_pro_seo_plugin_active() || ! is_front_page() ) {
		return;
	}

	$home = home_url( '/' );
	$name = get_theme_mod( 'plantgift_biz_legal_name', get_bloginfo( 'name' ) );

	$org = array(
		'@type'       => 'Organization',
		'@id'         => $home . '#organization',
		'name'        => $name,
		'url'         => $home,
		'description' => get_bloginfo( 'description' ),
	);

	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$org['logo'] = wp_get_attachment_image_url( $logo_id, 'full' );
	}

	$phone = get_theme_mod( 'plantgift_phone', '' );
	$email = get_theme_mod( 'plantgift_email', '' );
	if ( $phone || $email ) {
		$org['contactPoint'] = array(
			array_filter(
				array(
					'@type'       => 'ContactPoint',
					'contactType' => 'sales',
					'telephone'   => $phone,
					'email'       => $email,
					'areaServed'  => get_theme_mod( 'plantgift_biz_country', 'IN' ),
				)
			),
		);
	}

	$same_as = array_values(
		array_filter(
			array(
				get_theme_mod( 'plantgift_social_linkedin', '' ),
				get_theme_mod( 'plantgift_social_instagram', '' ),
				get_theme_mod( 'plantgift_social_facebook', '' ),
			)
		)
	);
	if ( $same_as ) {
		$org['sameAs'] = $same_as;
	}

	$locality = get_theme_mod( 'plantgift_biz_locality', '' );
	if ( $locality ) {
		$org['address'] = array_filter(
			array(
				'@type'           => 'PostalAddress',
				'addressLocality' => $locality,
				'addressRegion'   => get_theme_mod( 'plantgift_biz_region', '' ),
				'postalCode'      => get_theme_mod( 'plantgift_biz_postcode', '' ),
				'addressCountry'  => get_theme_mod( 'plantgift_biz_country', '' ),
			)
		);
	}

	$graph = array(
		$org,
		array(
			'@type'           => 'WebSite',
			'@id'             => $home . '#website',
			'url'             => $home,
			'name'            => get_bloginfo( 'name' ),
			'publisher'       => array( '@id' => $home . '#organization' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => $home . '?s={search_term_string}',
				),
				'query-input' => 'required name=search_term_string',
			),
		),
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph'   => $graph,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		)
	);
}
add_action( 'wp_head', 'plantgift_pro_org_schema', 5 );

/**
 * Breadcrumb structured data on inner pages.
 */
function plantgift_pro_breadcrumb_schema() {
	if ( plantgift_pro_seo_plugin_active() || is_front_page() ) {
		return;
	}

	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Home', 'plantgift-pro' ),
			'item'     => home_url( '/' ),
		),
	);

	if ( is_singular() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$link    = get_term_link( $term );
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => $term->name,
				'item'     => is_wp_error( $link ) ? home_url( '/' ) : $link,
			);
		}
	} else {
		return;
	}

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode(
			array(
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $items,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		)
	);
}
add_action( 'wp_head', 'plantgift_pro_breadcrumb_schema', 6 );

/**
 * Prefer the excerpt as the archive description so listings read cleanly.
 *
 * @param string $title Archive title.
 * @return string
 */
function plantgift_pro_archive_title( $title ) {
	if ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'plantgift_pro_archive_title' );
