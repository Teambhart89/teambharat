<?php
/**
 * Structured data.
 *
 * WooCommerce already emits Product and Offer markup, so this class adds only
 * what is missing: FAQPage for the question blocks, Service for the gifting
 * service pages, ItemList for category archives and CollectionPage details.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Schema output.
 */
class PGC_Schema {

	/**
	 * Tracks whether FAQ markup has already been printed on this request.
	 *
	 * @var bool
	 */
	private static $faq_printed = false;

	/**
	 * Hook into wp_head.
	 */
	public static function init() {
		add_action( 'wp_head', array( __CLASS__, 'service_schema' ), 8 );
		add_action( 'wp_head', array( __CLASS__, 'category_schema' ), 8 );
		add_filter( 'woocommerce_structured_data_product', array( __CLASS__, 'extend_product_schema' ), 10, 2 );
	}

	/**
	 * Print FAQPage markup once per request.
	 *
	 * Google only reads one FAQPage block per page, so repeated calls are ignored
	 * rather than stacked.
	 *
	 * @param array $faqs Array of arrays with q and a keys.
	 */
	public static function print_faq_schema( $faqs ) {
		if ( self::$faq_printed || empty( $faqs ) || ! is_array( $faqs ) ) {
			return;
		}

		$entities = array();
		foreach ( $faqs as $faq ) {
			if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
				continue;
			}
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $faq['q'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $faq['a'] ),
				),
			);
		}

		if ( ! $entities ) {
			return;
		}

		self::$faq_printed = true;

		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode(
				array(
					'@context'   => 'https://schema.org',
					'@type'      => 'FAQPage',
					'mainEntity' => $entities,
				),
				JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
			)
		);
	}

	/**
	 * Service markup on the gifting service pages.
	 */
	public static function service_schema() {
		if ( ! is_page() ) {
			return;
		}

		$post_id = get_queried_object_id();
		if ( 'page-templates/template-service.php' !== get_page_template_slug( $post_id ) ) {
			return;
		}

		$home = home_url( '/' );

		$service = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Service',
			'@id'         => get_permalink( $post_id ) . '#service',
			'name'        => get_the_title( $post_id ),
			'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
			'url'         => get_permalink( $post_id ),
			'serviceType' => 'Corporate plant gifting',
			'provider'    => array(
				'@type' => 'Organization',
				'@id'   => $home . '#organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => $home,
			),
			'areaServed'  => array(
				'@type' => 'Country',
				'name'  => get_theme_mod( 'plantgift_biz_country', 'India' ),
			),
			'audience'    => array(
				'@type' => 'BusinessAudience',
				'name'  => 'Companies and corporate buyers',
			),
		);

		$cats = get_post_meta( $post_id, '_pg_related_cats', true );
		if ( is_array( $cats ) && $cats && taxonomy_exists( 'product_cat' ) ) {
			$items = array();
			$i     = 0;
			foreach ( $cats as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( ! $term ) {
					continue;
				}
				$link = get_term_link( $term );
				if ( is_wp_error( $link ) ) {
					continue;
				}
				$i++;
				$items[] = array(
					'@type'    => 'Offer',
					'position' => $i,
					'name'     => $term->name,
					'url'      => $link,
				);
			}
			if ( $items ) {
				$service['hasOfferCatalog'] = array(
					'@type'           => 'OfferCatalog',
					'name'            => get_the_title( $post_id ),
					'itemListElement' => $items,
				);
			}
		}

		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode( $service, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		);
	}

	/**
	 * ItemList markup on product category archives.
	 */
	public static function category_schema() {
		if ( ! function_exists( 'is_product_category' ) || ! is_product_category() ) {
			return;
		}

		global $wp_query;
		if ( empty( $wp_query->posts ) ) {
			return;
		}

		$term  = get_queried_object();
		$items = array();
		$i     = 0;

		foreach ( array_slice( $wp_query->posts, 0, 24 ) as $post ) {
			$i++;
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $i,
				'url'      => get_permalink( $post ),
				'name'     => get_the_title( $post ),
			);
		}

		$link = $term instanceof WP_Term ? get_term_link( $term ) : home_url( '/' );

		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode(
				array(
					'@context'        => 'https://schema.org',
					'@type'           => 'ItemList',
					'@id'             => ( is_wp_error( $link ) ? home_url( '/' ) : $link ) . '#products',
					'name'            => $term instanceof WP_Term ? $term->name : '',
					'numberOfItems'   => count( $items ),
					'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
					'itemListElement' => $items,
				),
				JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
			)
		);
	}

	/**
	 * Add pot details to the WooCommerce product schema.
	 *
	 * @param array      $markup  Existing markup.
	 * @param WC_Product $product Product object.
	 * @return array
	 */
	public static function extend_product_schema( $markup, $product ) {
		if ( ! $product instanceof WC_Product ) {
			return $markup;
		}

		$properties = array();

		foreach ( array( 'pot-size', 'pot-material', 'pot-design', 'plant-type', 'light-need' ) as $slug ) {
			$taxonomy = wc_attribute_taxonomy_name( $slug );
			$terms    = wp_get_post_terms( $product->get_id(), $taxonomy, array( 'fields' => 'names' ) );
			if ( is_wp_error( $terms ) || ! $terms ) {
				continue;
			}
			$properties[] = array(
				'@type' => 'PropertyValue',
				'name'  => wc_attribute_label( $taxonomy ),
				'value' => implode( ', ', $terms ),
			);
		}

		if ( $properties ) {
			$markup['additionalProperty'] = $properties;
		}

		$markup['category'] = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ', '', '' ) );

		if ( empty( $markup['brand'] ) ) {
			$markup['brand'] = array(
				'@type' => 'Brand',
				'name'  => get_bloginfo( 'name' ),
			);
		}

		return $markup;
	}
}
