<?php
/**
 * SEO helpers that sit alongside whichever SEO plugin the store uses.
 *
 * @package PlantGift_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * SEO layer.
 */
class PGC_SEO {

	/**
	 * Hook in.
	 */
	public static function init() {
		add_filter( 'document_title_parts', array( __CLASS__, 'title_parts' ), 20 );
		add_filter( 'wpseo_title', array( __CLASS__, 'yoast_title' ), 10 );
		add_filter( 'wpseo_metadesc', array( __CLASS__, 'yoast_description' ), 10 );
		add_filter( 'rank_math/frontend/title', array( __CLASS__, 'yoast_title' ), 10 );
		add_filter( 'rank_math/frontend/description', array( __CLASS__, 'yoast_description' ), 10 );

		add_filter( 'wp_sitemaps_taxonomies', array( __CLASS__, 'sitemap_taxonomies' ) );
		add_filter( 'wp_sitemaps_post_types', array( __CLASS__, 'sitemap_post_types' ) );

		add_action( 'wp_head', array( __CLASS__, 'preload_hints' ), 1 );
		add_filter( 'robots_txt', array( __CLASS__, 'robots_txt' ), 10, 2 );
	}

	/**
	 * Use the stored meta title when one exists and no SEO plugin is handling it.
	 *
	 * @param array $parts Title parts.
	 * @return array
	 */
	public static function title_parts( $parts ) {
		if ( self::seo_plugin_active() ) {
			return $parts;
		}

		$custom = self::stored_title();
		if ( $custom ) {
			$parts['title'] = $custom;
			unset( $parts['tagline'] );
		}

		return $parts;
	}

	/**
	 * Feed the stored title to Yoast and Rank Math when their own field is empty.
	 *
	 * @param string $title Title from the plugin.
	 * @return string
	 */
	public static function yoast_title( $title ) {
		$custom = self::stored_title();
		if ( ! $custom ) {
			return $title;
		}
		// Only step in when the SEO plugin is falling back to a generated title.
		$generated = wp_strip_all_tags( get_the_title() );
		if ( $title && 0 !== strpos( $title, $generated ) ) {
			return $title;
		}
		return $custom . ' | ' . get_bloginfo( 'name' );
	}

	/**
	 * Feed the stored description to Yoast and Rank Math when theirs is empty.
	 *
	 * @param string $description Description from the plugin.
	 * @return string
	 */
	public static function yoast_description( $description ) {
		if ( $description ) {
			return $description;
		}
		return self::stored_description();
	}

	/**
	 * Look up the stored meta title for the current view.
	 *
	 * @return string
	 */
	private static function stored_title() {
		if ( is_singular() ) {
			return (string) get_post_meta( get_queried_object_id(), '_pg_meta_title', true );
		}
		if ( is_tax() || is_category() || is_tag() ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				return (string) get_term_meta( $term->term_id, '_pg_meta_title', true );
			}
		}
		return '';
	}

	/**
	 * Look up the stored meta description for the current view.
	 *
	 * @return string
	 */
	private static function stored_description() {
		if ( is_singular() ) {
			return (string) get_post_meta( get_queried_object_id(), '_pg_meta_description', true );
		}
		if ( is_tax() || is_category() || is_tag() ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				return (string) get_term_meta( $term->term_id, '_pg_meta_description', true );
			}
		}
		return '';
	}

	/**
	 * Detect a dedicated SEO plugin.
	 *
	 * @return bool
	 */
	private static function seo_plugin_active() {
		return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
	}

	/**
	 * Include product categories in the core sitemap and drop attribute archives.
	 *
	 * @param array $taxonomies Taxonomy objects.
	 * @return array
	 */
	public static function sitemap_taxonomies( $taxonomies ) {
		foreach ( array_keys( $taxonomies ) as $taxonomy ) {
			if ( 0 === strpos( $taxonomy, 'pa_' ) ) {
				unset( $taxonomies[ $taxonomy ] );
			}
		}
		return $taxonomies;
	}

	/**
	 * Keep variations out of the sitemap.
	 *
	 * @param array $post_types Post type objects.
	 * @return array
	 */
	public static function sitemap_post_types( $post_types ) {
		unset( $post_types['product_variation'] );
		return $post_types;
	}

	/**
	 * Preload the theme stylesheet so first paint is not held up.
	 */
	public static function preload_hints() {
		if ( is_admin() ) {
			return;
		}
		$css = get_template_directory() . '/assets/css/main.css';
		if ( ! file_exists( $css ) ) {
			return;
		}
		printf(
			'<link rel="preload" as="style" href="%s">' . "\n",
			esc_url( get_template_directory_uri() . '/assets/css/main.css' )
		);
	}

	/**
	 * Keep crawlers out of cart, checkout and account URLs.
	 *
	 * @param string $output Existing robots.txt body.
	 * @param bool   $public Whether the site is public.
	 * @return string
	 */
	public static function robots_txt( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}

		$rules = array(
			'Disallow: /cart/',
			'Disallow: /checkout/',
			'Disallow: /my-account/',
			'Disallow: /*add-to-cart=*',
			'Disallow: /*?orderby=',
			'Disallow: /*?filter_',
			'Disallow: /?s=',
			'Allow: /wp-content/uploads/',
		);

		$output .= "\n" . implode( "\n", $rules ) . "\n";
		$output .= "\nSitemap: " . esc_url( home_url( '/wp-sitemap.xml' ) ) . "\n";

		return $output;
	}
}
