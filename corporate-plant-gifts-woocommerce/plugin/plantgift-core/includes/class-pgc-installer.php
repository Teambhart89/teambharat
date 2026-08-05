<?php
/**
 * Builds the store: attributes, categories, products, pages, menus and settings.
 *
 * Every step is idempotent. Running it twice updates existing content rather than
 * creating duplicates, which matters because the setup screen lets you re run
 * individual steps.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Installer.
 */
class PGC_Installer {

	/**
	 * How many products to build per batch.
	 */
	const PRODUCT_BATCH = 4;

	/**
	 * Create the global pot attributes and their terms.
	 *
	 * @return array Result summary.
	 */
	public static function install_attributes() {
		if ( ! function_exists( 'wc_create_attribute' ) ) {
			return array( 'done' => true, 'message' => __( 'WooCommerce is not active.', 'plantgift-core' ) );
		}

		$defs    = plantgift_core_data( 'attributes' );
		$created = 0;
		$terms   = 0;

		foreach ( $defs as $slug => $def ) {
			$attribute_id = self::get_attribute_id( $slug );

			if ( ! $attribute_id ) {
				$attribute_id = wc_create_attribute(
					array(
						'name'         => $def['label'],
						'slug'         => $slug,
						'type'         => isset( $def['type'] ) ? $def['type'] : 'select',
						'order_by'     => isset( $def['orderby'] ) ? $def['orderby'] : 'menu_order',
						'has_archives' => false,
					)
				);

				if ( is_wp_error( $attribute_id ) ) {
					continue;
				}
				$created++;
			}

			$taxonomy = wc_attribute_taxonomy_name( $slug );
			self::register_attribute_taxonomy( $taxonomy );

			$position = 0;
			foreach ( $def['terms'] as $term ) {
				$position++;
				$existing = get_term_by( 'slug', $term['slug'], $taxonomy );

				if ( $existing ) {
					wp_update_term(
						$existing->term_id,
						$taxonomy,
						array(
							'name'        => $term['name'],
							'description' => $term['description'],
						)
					);
					$term_id = $existing->term_id;
				} else {
					$inserted = wp_insert_term(
						$term['name'],
						$taxonomy,
						array(
							'slug'        => $term['slug'],
							'description' => $term['description'],
						)
					);
					if ( is_wp_error( $inserted ) ) {
						continue;
					}
					$term_id = $inserted['term_id'];
					$terms++;
				}

				update_term_meta( $term_id, 'order', $position );
				update_term_meta( $term_id, '_pgc_price_modifier', (float) ( isset( $term['price'] ) ? $term['price'] : 0 ) );
			}
		}

		delete_transient( 'wc_attribute_taxonomies' );
		if ( class_exists( 'WC_Cache_Helper' ) ) {
			WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
		}

		self::mark_step( 'attributes' );

		return array(
			'done'    => true,
			/* translators: 1: attributes created, 2: terms created. */
			'message' => sprintf( __( 'Attributes ready. %1$d created, %2$d new options added.', 'plantgift-core' ), $created, $terms ),
		);
	}

	/**
	 * Find an existing attribute id by slug.
	 *
	 * @param string $slug Attribute slug.
	 * @return int
	 */
	private static function get_attribute_id( $slug ) {
		foreach ( wc_get_attribute_taxonomies() as $tax ) {
			if ( $tax->attribute_name === $slug ) {
				return (int) $tax->attribute_id;
			}
		}
		return 0;
	}

	/**
	 * Register an attribute taxonomy immediately so terms can be inserted in the
	 * same request that created the attribute.
	 *
	 * @param string $taxonomy Taxonomy name.
	 */
	private static function register_attribute_taxonomy( $taxonomy ) {
		if ( taxonomy_exists( $taxonomy ) ) {
			return;
		}
		register_taxonomy(
			$taxonomy,
			array( 'product' ),
			array(
				'hierarchical' => false,
				'show_ui'      => false,
				'query_var'    => true,
				'rewrite'      => false,
				'public'       => false,
			)
		);
	}

	/**
	 * Create the product categories with their SEO copy.
	 *
	 * @return array
	 */
	public static function install_categories() {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return array( 'done' => true, 'message' => __( 'WooCommerce is not active.', 'plantgift-core' ) );
		}

		$cats    = plantgift_core_data( 'categories' );
		$created = 0;
		$order   = 0;

		foreach ( $cats as $cat ) {
			$order++;
			$existing = get_term_by( 'slug', $cat['slug'], 'product_cat' );

			$args = array(
				'slug'        => $cat['slug'],
				'description' => $cat['intro'],
			);

			if ( $existing ) {
				wp_update_term( $existing->term_id, 'product_cat', array_merge( $args, array( 'name' => $cat['name'] ) ) );
				$term_id = (int) $existing->term_id;
			} else {
				$inserted = wp_insert_term( $cat['name'], 'product_cat', $args );
				if ( is_wp_error( $inserted ) ) {
					continue;
				}
				$term_id = (int) $inserted['term_id'];
				$created++;
			}

			update_term_meta( $term_id, 'order', $order );
			update_term_meta( $term_id, '_pg_intro', $cat['intro'] );
			update_term_meta( $term_id, '_pg_seo_body', $cat['body'] );
			update_term_meta( $term_id, '_pg_meta_title', $cat['meta_title'] );
			update_term_meta( $term_id, '_pg_meta_description', $cat['meta_desc'] );
			update_term_meta( $term_id, '_pg_focus_keyword', $cat['focus'] );
			update_term_meta( $term_id, '_pg_faqs', isset( $cat['faqs'] ) ? $cat['faqs'] : array() );
			update_term_meta( $term_id, 'display_type', '' );

			if ( ! get_term_meta( $term_id, 'thumbnail_id', true ) ) {
				$image_id = self::create_placeholder_image( $cat['slug'], $cat['name'] );
				if ( $image_id ) {
					update_term_meta( $term_id, 'thumbnail_id', $image_id );
				}
			}
		}

		self::mark_step( 'categories' );

		return array(
			'done'    => true,
			/* translators: 1: categories created, 2: total categories. */
			'message' => sprintf( __( 'Categories ready. %1$d created, %2$d total.', 'plantgift-core' ), $created, count( $cats ) ),
		);
	}

	/**
	 * Create products in batches.
	 *
	 * @param int $offset Index to start from.
	 * @return array
	 */
	public static function install_products( $offset = 0 ) {
		if ( ! class_exists( 'WC_Product_Variable' ) ) {
			return array( 'done' => true, 'message' => __( 'WooCommerce is not active.', 'plantgift-core' ) );
		}

		$products = plantgift_core_data( 'products' );
		$total    = count( $products );
		$offset   = max( 0, (int) $offset );
		$slice    = array_slice( $products, $offset, self::PRODUCT_BATCH );
		$built    = 0;

		foreach ( $slice as $data ) {
			if ( self::build_product( $data ) ) {
				$built++;
			}
		}

		$next = $offset + count( $slice );
		$done = $next >= $total;

		if ( $done ) {
			self::mark_step( 'products' );
			if ( function_exists( 'wc_delete_product_transients' ) ) {
				wc_delete_product_transients();
			}
		}

		return array(
			'done'     => $done,
			'offset'   => $next,
			'total'    => $total,
			'progress' => $total ? (int) round( ( $next / $total ) * 100 ) : 100,
			/* translators: 1: products done, 2: total products. */
			'message'  => sprintf( __( 'Built %1$d of %2$d products.', 'plantgift-core' ), $next, $total ),
		);
	}

	/**
	 * Create or update one variable product and its variations.
	 *
	 * @param array $data Product blueprint.
	 * @return bool
	 */
	private static function build_product( $data ) {
		$existing_id = self::find_product_by_slug( $data['slug'] );
		$product     = $existing_id ? wc_get_product( $existing_id ) : null;

		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			$product = new WC_Product_Variable();
		}

		$product->set_name( $data['name'] );
		$product->set_slug( $data['slug'] );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_description( $data['desc'] );
		$product->set_short_description( $data['short'] );
		$product->set_sku( $data['sku'] );
		$product->set_manage_stock( false );
		$product->set_stock_status( 'instock' );
		$product->set_reviews_allowed( true );

		// Categories.
		$cat_ids = array();
		foreach ( $data['cats'] as $slug ) {
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			if ( $term ) {
				$cat_ids[] = (int) $term->term_id;
			}
		}
		if ( $cat_ids ) {
			$product->set_category_ids( $cat_ids );
		}

		// Attributes.
		$attributes = array();
		$position   = 0;

		$axes = array(
			'pot-size'     => $data['sizes'],
			'pot-material' => $data['materials'],
			'pot-design'   => $data['designs'],
		);

		foreach ( $axes as $slug => $options ) {
			$attribute = self::make_attribute( $slug, $options, $position, true );
			if ( $attribute ) {
				$attributes[] = $attribute;
				$position++;
			}
		}

		// Informational attributes shown in the details tab but not used for variations.
		foreach ( array( 'plant-type' => array( $data['type'] ), 'light-need' => array( $data['light'] ) ) as $slug => $options ) {
			$attribute = self::make_attribute( $slug, $options, $position, false );
			if ( $attribute ) {
				$attributes[] = $attribute;
				$position++;
			}
		}

		$product->set_attributes( $attributes );

		$product->set_default_attributes(
			array(
				wc_attribute_taxonomy_name( 'pot-size' )     => $data['sizes'][0],
				wc_attribute_taxonomy_name( 'pot-material' ) => $data['materials'][0],
				wc_attribute_taxonomy_name( 'pot-design' )   => $data['designs'][0],
			)
		);

		$product_id = $product->save();
		if ( ! $product_id ) {
			return false;
		}

		update_post_meta( $product_id, '_pg_meta_description', wp_trim_words( $data['short'], 26 ) );
		update_post_meta(
			$product_id,
			'_pg_bulk_slabs',
			array(
				array( '25 to 49', '5%' ),
				array( '50 to 99', '10%' ),
				array( '100 to 249', '15%' ),
				array( '250 to 499', '20%' ),
				array( '500 and above', __( 'Custom quote', 'plantgift-core' ) ),
			)
		);

		if ( ! has_post_thumbnail( $product_id ) ) {
			$image_id = self::create_placeholder_image( $data['slug'], $data['name'] );
			if ( $image_id ) {
				set_post_thumbnail( $product_id, $image_id );
			}
		}

		self::build_variations( $product_id, $data );

		if ( class_exists( 'WC_Product_Variable' ) ) {
			WC_Product_Variable::sync( $product_id );
		}

		return true;
	}

	/**
	 * Build a WC_Product_Attribute for a taxonomy.
	 *
	 * @param string $slug      Attribute slug without the pa_ prefix.
	 * @param array  $options   Term slugs.
	 * @param int    $position  Sort position.
	 * @param bool   $variation Whether the attribute drives variations.
	 * @return WC_Product_Attribute|false
	 */
	private static function make_attribute( $slug, $options, $position, $variation ) {
		$taxonomy = wc_attribute_taxonomy_name( $slug );
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return false;
		}

		$term_ids = array();
		foreach ( (array) $options as $option ) {
			$term = get_term_by( 'slug', $option, $taxonomy );
			if ( $term ) {
				$term_ids[] = (int) $term->term_id;
			}
		}

		if ( ! $term_ids ) {
			return false;
		}

		$attribute = new WC_Product_Attribute();
		$attribute->set_id( self::get_attribute_id( $slug ) );
		$attribute->set_name( $taxonomy );
		$attribute->set_options( $term_ids );
		$attribute->set_position( $position );
		$attribute->set_visible( true );
		$attribute->set_variation( $variation );

		return $attribute;
	}

	/**
	 * Create every size, material and design combination as a variation.
	 *
	 * @param int   $product_id Parent product id.
	 * @param array $data       Blueprint.
	 */
	private static function build_variations( $product_id, $data ) {
		$size_tax     = wc_attribute_taxonomy_name( 'pot-size' );
		$material_tax = wc_attribute_taxonomy_name( 'pot-material' );
		$design_tax   = wc_attribute_taxonomy_name( 'pot-design' );

		$existing = array();
		foreach ( get_posts(
			array(
				'post_type'      => 'product_variation',
				'post_parent'    => $product_id,
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'post_status'    => 'any',
			)
		) as $variation_id ) {
			$key              = implode(
				'|',
				array(
					get_post_meta( $variation_id, 'attribute_' . $size_tax, true ),
					get_post_meta( $variation_id, 'attribute_' . $material_tax, true ),
					get_post_meta( $variation_id, 'attribute_' . $design_tax, true ),
				)
			);
			$existing[ $key ] = $variation_id;
		}

		$base = (float) $data['price'];

		foreach ( $data['sizes'] as $size ) {
			foreach ( $data['materials'] as $material ) {
				foreach ( $data['designs'] as $design ) {

					$key   = $size . '|' . $material . '|' . $design;
					$price = $base
						+ self::term_modifier( $size_tax, $size )
						+ self::term_modifier( $material_tax, $material )
						+ self::term_modifier( $design_tax, $design );
					$price = max( 99, round( $price ) );

					$variation = isset( $existing[ $key ] ) ? new WC_Product_Variation( $existing[ $key ] ) : new WC_Product_Variation();
					$variation->set_parent_id( $product_id );
					$variation->set_status( 'publish' );
					$variation->set_attributes(
						array(
							$size_tax     => $size,
							$material_tax => $material,
							$design_tax   => $design,
						)
					);
					$variation->set_regular_price( (string) $price );
					$variation->set_manage_stock( false );
					$variation->set_stock_status( 'instock' );
					$variation->set_sku( $data['sku'] . '-' . strtoupper( substr( md5( $key ), 0, 6 ) ) );
					$variation->save();

					unset( $existing[ $key ] );
				}
			}
		}

		// Remove combinations that no longer exist in the blueprint.
		foreach ( $existing as $orphan_id ) {
			wp_delete_post( $orphan_id, true );
		}
	}

	/**
	 * Price modifier stored against an attribute term.
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @param string $slug     Term slug.
	 * @return float
	 */
	private static function term_modifier( $taxonomy, $slug ) {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( ! $term ) {
			return 0;
		}
		return (float) get_term_meta( $term->term_id, '_pgc_price_modifier', true );
	}

	/**
	 * Look up a product by slug.
	 *
	 * @param string $slug Product slug.
	 * @return int
	 */
	private static function find_product_by_slug( $slug ) {
		$posts = get_posts(
			array(
				'post_type'      => 'product',
				'name'           => $slug,
				'posts_per_page' => 1,
				'post_status'    => 'any',
				'fields'         => 'ids',
			)
		);
		return $posts ? (int) $posts[0] : 0;
	}

	/**
	 * Create the service pages and core pages.
	 *
	 * @return array
	 */
	public static function install_pages() {
		$services = plantgift_core_data( 'pages-services' );
		$core     = plantgift_core_data( 'pages-core' );
		$created  = 0;
		$order    = 0;

		foreach ( $services as $page ) {
			$page['template'] = 'page-templates/template-service.php';
			if ( self::build_page( $page, ++$order ) ) {
				$created++;
			}
		}

		foreach ( $core as $page ) {
			if ( self::build_page( $page, ++$order ) ) {
				$created++;
			}
		}

		self::assign_special_pages( $core );
		self::mark_step( 'pages' );

		return array(
			'done'    => true,
			/* translators: %d: number of pages. */
			'message' => sprintf( __( '%d pages created or updated.', 'plantgift-core' ), count( $services ) + count( $core ) ),
		);
	}

	/**
	 * Create or update one page.
	 *
	 * @param array $page  Page definition.
	 * @param int   $order Menu order.
	 * @return bool True when newly created.
	 */
	private static function build_page( $page, $order ) {
		$existing = get_page_by_path( $page['slug'], OBJECT, 'page' );
		$is_new   = ! $existing;

		$args = array(
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_content' => isset( $page['content'] ) ? $page['content'] : '',
			'post_excerpt' => isset( $page['excerpt'] ) ? $page['excerpt'] : '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'menu_order'   => $order,
		);

		if ( $existing ) {
			$args['ID'] = $existing->ID;
			$page_id    = wp_update_post( $args );
		} else {
			$page_id = wp_insert_post( $args );
		}

		if ( is_wp_error( $page_id ) || ! $page_id ) {
			return false;
		}

		if ( ! empty( $page['template'] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $page['template'] );
		}
		if ( ! empty( $page['eyebrow'] ) ) {
			update_post_meta( $page_id, '_pg_eyebrow', $page['eyebrow'] );
		}
		if ( ! empty( $page['highlights'] ) ) {
			update_post_meta( $page_id, '_pg_highlights', $page['highlights'] );
		}
		if ( ! empty( $page['cats'] ) ) {
			update_post_meta( $page_id, '_pg_related_cats', $page['cats'] );
		}
		if ( ! empty( $page['faqs'] ) ) {
			update_post_meta( $page_id, '_pg_faqs', $page['faqs'] );
		}
		if ( ! empty( $page['meta_desc'] ) ) {
			update_post_meta( $page_id, '_pg_meta_description', $page['meta_desc'] );
		}
		if ( ! empty( $page['meta_title'] ) ) {
			update_post_meta( $page_id, '_pg_meta_title', $page['meta_title'] );
		}
		if ( ! empty( $page['focus'] ) ) {
			update_post_meta( $page_id, '_pg_focus_keyword', $page['focus'] );
		}
		if ( ! empty( $page['menu_title'] ) ) {
			update_post_meta( $page_id, '_pg_menu_title', $page['menu_title'] );
		}
		if ( ! empty( $page['front'] ) ) {
			update_post_meta( $page_id, '_pg_is_front', 1 );
		}
		if ( ! empty( $page['blog'] ) ) {
			update_post_meta( $page_id, '_pg_is_blog', 1 );
		}

		return $is_new;
	}

	/**
	 * Point the front page and the posts page at the right pages.
	 *
	 * @param array $core Core page definitions.
	 */
	private static function assign_special_pages( $core ) {
		foreach ( $core as $page ) {
			$post = get_page_by_path( $page['slug'], OBJECT, 'page' );
			if ( ! $post ) {
				continue;
			}
			if ( ! empty( $page['front'] ) ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $post->ID );
			}
			if ( ! empty( $page['blog'] ) ) {
				update_option( 'page_for_posts', $post->ID );
			}
		}
	}

	/**
	 * Build the navigation menus and assign them to theme locations.
	 *
	 * @return array
	 */
	public static function install_menus() {
		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations = is_array( $locations ) ? $locations : array();

		// Primary menu.
		$primary = self::get_or_create_menu( __( 'Primary Menu', 'plantgift-core' ) );
		if ( $primary ) {
			self::clear_menu( $primary );

			self::add_menu_page( $primary, 'home', __( 'Home', 'plantgift-core' ) );

			$shop_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
			$shop_item = 0;
			if ( $shop_id > 0 ) {
				$shop_item = wp_update_nav_menu_item(
					$primary,
					0,
					array(
						'menu-item-title'     => __( 'Shop Plant Gifts', 'plantgift-core' ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $shop_id,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}

			$featured = array(
				'succulent-corporate-gifts',
				'air-plant-gifts',
				'desk-plants-for-office',
				'air-purifying-plant-gifts',
				'bonsai-corporate-gifts',
				'plant-gift-hampers',
				'branded-logo-planters',
			);
			foreach ( $featured as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( ! $term ) {
					continue;
				}
				wp_update_nav_menu_item(
					$primary,
					0,
					array(
						'menu-item-title'     => $term->name,
						'menu-item-object'    => 'product_cat',
						'menu-item-object-id' => $term->term_id,
						'menu-item-type'      => 'taxonomy',
						'menu-item-status'    => 'publish',
						'menu-item-parent-id' => $shop_item,
					)
				);
			}

			$services = plantgift_core_data( 'pages-services' );
			$hub      = get_page_by_path( 'corporate-plant-gifting', OBJECT, 'page' );
			$hub_item = 0;
			if ( $hub ) {
				$hub_item = wp_update_nav_menu_item(
					$primary,
					0,
					array(
						'menu-item-title'     => __( 'Gifting Services', 'plantgift-core' ),
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $hub->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
			foreach ( $services as $service ) {
				if ( 'corporate-plant-gifting' === $service['slug'] ) {
					continue;
				}
				self::add_menu_page( $primary, $service['slug'], $service['menu_title'], $hub_item );
			}

			self::add_menu_page( $primary, 'blog', __( 'Journal', 'plantgift-core' ) );
			self::add_menu_page( $primary, 'about-us', __( 'About', 'plantgift-core' ) );
			self::add_menu_page( $primary, 'contact', __( 'Contact', 'plantgift-core' ) );

			$locations['primary'] = $primary;
		}

		// Footer column one: shop.
		$footer_1 = self::get_or_create_menu( __( 'Footer Shop', 'plantgift-core' ) );
		if ( $footer_1 ) {
			self::clear_menu( $footer_1 );
			foreach ( array( 'succulent-corporate-gifts', 'air-plant-gifts', 'desk-plants-for-office', 'money-plant-gifts', 'plant-gift-hampers', 'branded-logo-planters' ) as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( ! $term ) {
					continue;
				}
				wp_update_nav_menu_item(
					$footer_1,
					0,
					array(
						'menu-item-title'     => $term->name,
						'menu-item-object'    => 'product_cat',
						'menu-item-object-id' => $term->term_id,
						'menu-item-type'      => 'taxonomy',
						'menu-item-status'    => 'publish',
					)
				);
			}
			$locations['footer_1'] = $footer_1;
		}

		// Footer column two: services.
		$footer_2 = self::get_or_create_menu( __( 'Footer Services', 'plantgift-core' ) );
		if ( $footer_2 ) {
			self::clear_menu( $footer_2 );
			foreach ( plantgift_core_data( 'pages-services' ) as $service ) {
				self::add_menu_page( $footer_2, $service['slug'], $service['menu_title'] );
			}
			$locations['footer_2'] = $footer_2;
		}

		// Footer column three: company.
		$footer_3 = self::get_or_create_menu( __( 'Footer Company', 'plantgift-core' ) );
		if ( $footer_3 ) {
			self::clear_menu( $footer_3 );
			foreach ( array( 'about-us', 'contact', 'faq', 'blog', 'shipping-and-returns' ) as $slug ) {
				self::add_menu_page( $footer_3, $slug );
			}
			$locations['footer_3'] = $footer_3;
		}

		// Legal menu.
		$legal = self::get_or_create_menu( __( 'Legal Menu', 'plantgift-core' ) );
		if ( $legal ) {
			self::clear_menu( $legal );
			foreach ( array( 'privacy-policy', 'terms-and-conditions', 'shipping-and-returns' ) as $slug ) {
				self::add_menu_page( $legal, $slug );
			}
			$locations['legal'] = $legal;
		}

		set_theme_mod( 'nav_menu_locations', $locations );
		self::mark_step( 'menus' );

		return array( 'done' => true, 'message' => __( 'Navigation menus created and assigned.', 'plantgift-core' ) );
	}

	/**
	 * Get a menu by name, creating it when missing.
	 *
	 * @param string $name Menu name.
	 * @return int
	 */
	private static function get_or_create_menu( $name ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( $menu ) {
			return (int) $menu->term_id;
		}
		$menu_id = wp_create_nav_menu( $name );
		return is_wp_error( $menu_id ) ? 0 : (int) $menu_id;
	}

	/**
	 * Empty a menu so it can be rebuilt cleanly.
	 *
	 * @param int $menu_id Menu id.
	 */
	private static function clear_menu( $menu_id ) {
		$items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );
		if ( ! $items ) {
			return;
		}
		foreach ( $items as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	/**
	 * Add a page to a menu.
	 *
	 * @param int    $menu_id Menu id.
	 * @param string $slug    Page slug.
	 * @param string $title   Optional label.
	 * @param int    $parent  Optional parent item id.
	 * @return int
	 */
	private static function add_menu_page( $menu_id, $slug, $title = '', $parent = 0 ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page ) {
			return 0;
		}
		if ( ! $title ) {
			$title = get_post_meta( $page->ID, '_pg_menu_title', true );
			if ( ! $title ) {
				$title = $page->post_title;
			}
		}
		$item = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $title,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent,
			)
		);
		return is_wp_error( $item ) ? 0 : (int) $item;
	}

	/**
	 * Apply permalink, WooCommerce and reading settings.
	 *
	 * @return array
	 */
	public static function install_settings() {
		// SEO friendly permalinks.
		global $wp_rewrite;
		update_option( 'permalink_structure', '/%postname%/' );
		if ( isset( $wp_rewrite ) ) {
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
		}

		// Short, readable WooCommerce bases.
		update_option(
			'woocommerce_permalinks',
			array(
				'product_base'           => '/plant-gift',
				'category_base'          => 'plant-gifts',
				'tag_base'               => 'plant-tag',
				'attribute_base'         => '',
				'use_verbose_page_rules' => false,
			)
		);

		// Reading and discussion defaults that suit a store.
		update_option( 'posts_per_page', 9 );
		update_option( 'blog_public', 1 );
		update_option( 'default_ping_status', 'closed' );
		update_option( 'default_comment_status', 'closed' );
		update_option( 'thumbnail_crop', 1 );

		if ( class_exists( 'WooCommerce' ) ) {
			update_option( 'woocommerce_enable_reviews', 'yes' );
			update_option( 'woocommerce_review_rating_verification_required', 'no' );
			update_option( 'woocommerce_catalog_columns', 3 );
			update_option( 'woocommerce_catalog_rows', 4 );
			update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );
			update_option( 'woocommerce_cart_redirect_after_add', 'no' );
			update_option( 'woocommerce_shop_page_display', '' );
			update_option( 'woocommerce_category_archive_display', '' );
			update_option( 'woocommerce_default_catalog_orderby', 'menu_order' );
			update_option( 'woocommerce_thumbnail_cropping', '1:1' );
		}

		// Widgets that make the shop sidebar useful out of the box.
		self::seed_shop_widgets();

		flush_rewrite_rules();
		self::mark_step( 'settings' );

		return array( 'done' => true, 'message' => __( 'Permalinks, WooCommerce options and sidebar widgets configured.', 'plantgift-core' ) );
	}

	/**
	 * Place a few filter widgets into the shop sidebar if it is empty.
	 */
	private static function seed_shop_widgets() {
		$sidebars = get_option( 'sidebars_widgets', array() );
		if ( ! empty( $sidebars['sidebar-shop'] ) ) {
			return;
		}

		$assigned = array();

		// Product categories widget.
		$cats                = get_option( 'widget_woocommerce_product_categories', array() );
		$next                = self::next_widget_index( $cats );
		$cats[ $next ]       = array(
			'title'        => __( 'Gift categories', 'plantgift-core' ),
			'orderby'      => 'order',
			'dropdown'     => 0,
			'count'        => 1,
			'hierarchical' => 1,
			'show_children_only' => 0,
			'hide_empty'   => 0,
			'max_depth'    => 2,
		);
		$cats['_multiwidget'] = 1;
		update_option( 'widget_woocommerce_product_categories', $cats );
		$assigned[] = 'woocommerce_product_categories-' . $next;

		// Price filter.
		$price                = get_option( 'widget_woocommerce_price_filter', array() );
		$next                 = self::next_widget_index( $price );
		$price[ $next ]       = array( 'title' => __( 'Filter by price', 'plantgift-core' ) );
		$price['_multiwidget'] = 1;
		update_option( 'widget_woocommerce_price_filter', $price );
		$assigned[] = 'woocommerce_price_filter-' . $next;

		// Layered nav on pot size and material.
		$nav = get_option( 'widget_woocommerce_layered_nav', array() );
		foreach ( array( 'pot-size' => __( 'Pot size', 'plantgift-core' ), 'pot-material' => __( 'Pot material', 'plantgift-core' ) ) as $attr => $title ) {
			$next          = self::next_widget_index( $nav );
			$nav[ $next ]  = array(
				'title'        => $title,
				'attribute'    => $attr,
				'display_type' => 'list',
				'query_type'   => 'and',
			);
			$assigned[]    = 'woocommerce_layered_nav-' . $next;
		}
		$nav['_multiwidget'] = 1;
		update_option( 'widget_woocommerce_layered_nav', $nav );

		$sidebars['sidebar-shop'] = $assigned;
		update_option( 'sidebars_widgets', $sidebars );
	}

	/**
	 * Next free numeric key in a widget option array.
	 *
	 * @param array $option Widget option.
	 * @return int
	 */
	private static function next_widget_index( $option ) {
		$keys = array_filter( array_keys( (array) $option ), 'is_numeric' );
		return $keys ? ( max( $keys ) + 1 ) : 1;
	}

	/**
	 * Generate a simple gradient placeholder image and attach it to the library.
	 *
	 * Keeps the download small while still giving categories and products
	 * something better looking than the default grey placeholder. Replace these
	 * with real photography before launch.
	 *
	 * @param string $seed  Unique string used to pick the colours.
	 * @param string $title Alt text.
	 * @return int Attachment id, or 0 on failure.
	 */
	public static function create_placeholder_image( $seed, $title ) {
		if ( ! function_exists( 'imagecreatetruecolor' ) || ! function_exists( 'imagepng' ) ) {
			return 0;
		}

		$uploads = wp_upload_dir();
		if ( ! empty( $uploads['error'] ) ) {
			return 0;
		}

		$filename = 'plantgift-' . sanitize_file_name( $seed ) . '.png';
		$path     = trailingslashit( $uploads['path'] ) . $filename;

		// Reuse an identical file if the step is re run.
		$existing = get_posts(
			array(
				'post_type'      => 'attachment',
				'name'           => sanitize_title( 'plantgift-' . $seed ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'post_status'    => 'inherit',
			)
		);
		if ( $existing ) {
			return (int) $existing[0];
		}

		$size = 900;
		$img  = imagecreatetruecolor( $size, $size );

		$hash = md5( $seed );
		$hue  = hexdec( substr( $hash, 0, 2 ) ) / 255;

		// A calm green to clay palette so every tile belongs to the same family.
		$palettes = array(
			array( array( 214, 236, 221 ), array( 47, 128, 85 ) ),
			array( array( 236, 228, 214 ), array( 168, 88, 58 ) ),
			array( array( 221, 233, 236 ), array( 39, 102, 67 ) ),
			array( array( 240, 235, 222 ), array( 23, 56, 31 ) ),
			array( array( 226, 240, 229 ), array( 79, 159, 115 ) ),
		);
		$palette  = $palettes[ hexdec( substr( $hash, 2, 2 ) ) % count( $palettes ) ];

		// Vertical gradient.
		for ( $y = 0; $y < $size; $y++ ) {
			$t = $y / $size;
			$r = (int) ( $palette[0][0] + ( $palette[1][0] - $palette[0][0] ) * $t );
			$g = (int) ( $palette[0][1] + ( $palette[1][1] - $palette[0][1] ) * $t );
			$b = (int) ( $palette[0][2] + ( $palette[1][2] - $palette[0][2] ) * $t );
			$c = imagecolorallocate( $img, $r, $g, $b );
			imageline( $img, 0, $y, $size, $y, $c );
		}

		// A few soft leaf shapes so the tile does not read as a plain gradient.
		for ( $i = 0; $i < 5; $i++ ) {
			$seed_i = hexdec( substr( $hash, ( $i * 4 ) % 28, 4 ) );
			$cx     = ( $seed_i % $size );
			$cy     = ( ( $seed_i * 7 ) % $size );
			$rad    = 90 + ( $seed_i % 210 );
			$shade  = imagecolorallocatealpha(
				$img,
				min( 255, $palette[1][0] + 40 ),
				min( 255, $palette[1][1] + 60 ),
				min( 255, $palette[1][2] + 40 ),
				90
			);
			imagefilledellipse( $img, $cx, $cy, $rad, (int) ( $rad * 1.5 ), $shade );
		}

		imagealphablending( $img, true );
		$saved = imagepng( $img, $path, 8 );
		imagedestroy( $img );

		if ( ! $saved ) {
			return 0;
		}

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => 'image/png',
				'post_title'     => $title,
				'post_name'      => sanitize_title( 'plantgift-' . $seed ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			),
			$path
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			return 0;
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $path ) );
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', $title );

		return (int) $attachment_id;
	}

	/**
	 * Record that a step has completed.
	 *
	 * @param string $step Step key.
	 */
	private static function mark_step( $step ) {
		$state          = get_option( 'plantgift_core_setup_state', array() );
		$state[ $step ] = time();
		update_option( 'plantgift_core_setup_state', $state );
	}

	/**
	 * Remove all generated content. Used by the reset button.
	 *
	 * @return array
	 */
	public static function reset_content() {
		// Products and variations.
		foreach ( plantgift_core_data( 'products' ) as $data ) {
			$id = self::find_product_by_slug( $data['slug'] );
			if ( ! $id ) {
				continue;
			}
			foreach ( get_posts(
				array(
					'post_type'      => 'product_variation',
					'post_parent'    => $id,
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'post_status'    => 'any',
				)
			) as $variation_id ) {
				wp_delete_post( $variation_id, true );
			}
			wp_delete_post( $id, true );
		}

		// Categories.
		foreach ( plantgift_core_data( 'categories' ) as $cat ) {
			$term = get_term_by( 'slug', $cat['slug'], 'product_cat' );
			if ( $term ) {
				wp_delete_term( $term->term_id, 'product_cat' );
			}
		}

		// Pages.
		$pages = array_merge( plantgift_core_data( 'pages-services' ), plantgift_core_data( 'pages-core' ) );
		foreach ( $pages as $page ) {
			$post = get_page_by_path( $page['slug'], OBJECT, 'page' );
			if ( $post ) {
				wp_delete_post( $post->ID, true );
			}
		}

		update_option(
			'plantgift_core_setup_state',
			array(
				'attributes' => 0,
				'categories' => 0,
				'products'   => 0,
				'pages'      => 0,
				'menus'      => 0,
				'settings'   => 0,
			)
		);

		return array( 'done' => true, 'message' => __( 'Generated content removed. Attributes and menus were left in place.', 'plantgift-core' ) );
	}
}
