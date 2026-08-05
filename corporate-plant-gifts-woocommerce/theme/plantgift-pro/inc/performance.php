<?php
/**
 * Front end trimming. Faster pages help both shoppers and Core Web Vitals.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove head clutter that most stores do not use.
 */
function plantgift_pro_clean_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
}
add_action( 'init', 'plantgift_pro_clean_head' );

/**
 * Drop the emoji script and stylesheet.
 */
function plantgift_pro_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter(
		'tiny_mce_plugins',
		function ( $plugins ) {
			return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
		}
	);
}
add_action( 'init', 'plantgift_pro_disable_emojis' );

/**
 * Load the block library stylesheet only where blocks are actually rendered.
 */
function plantgift_pro_conditional_block_css() {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_singular() ) {
		return;
	}
	$post = get_post();
	if ( $post && ! has_blocks( $post ) ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'plantgift_pro_conditional_block_css', 100 );

/**
 * Keep the first hero image eager so the largest paint element loads early.
 *
 * @param string $content Post content.
 * @return string
 */
function plantgift_pro_priority_hero_image( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	return preg_replace( '/loading=["\']lazy["\']/', 'loading="eager" fetchpriority="high"', $content, 1 );
}
add_filter( 'the_content', 'plantgift_pro_priority_hero_image', 20 );

/**
 * Skip lazy loading on the very first image of a page.
 *
 * @param string|bool $value   Loading attribute value.
 * @param string      $image   Image markup.
 * @param string      $context Context.
 * @return string|bool
 */
function plantgift_pro_skip_first_lazy( $value, $image, $context ) {
	static $counter = 0;
	if ( 'the_content' === $context ) {
		$counter++;
		if ( 1 === $counter ) {
			return false;
		}
	}
	return $value;
}
add_filter( 'wp_img_tag_add_loading_attr', 'plantgift_pro_skip_first_lazy', 10, 3 );

/**
 * Give small card images a realistic sizes attribute so browsers stop
 * downloading a 1200px file for a 320px slot. Larger images are left alone.
 *
 * @param string       $sizes Generated sizes attribute.
 * @param array|string $size  Requested image size.
 * @return string
 */
function plantgift_pro_image_sizes_attr( $sizes, $size ) {
	$width = is_array( $size ) ? (int) $size[0] : 0;

	if ( is_string( $size ) && in_array( $size, array( 'plantgift-card', 'woocommerce_thumbnail', 'thumbnail', 'medium' ), true ) ) {
		return '(max-width: 640px) 50vw, (max-width: 1024px) 33vw, 320px';
	}

	if ( $width > 0 && $width <= 640 ) {
		return '(max-width: 640px) 50vw, 320px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'plantgift_pro_image_sizes_attr', 10, 2 );

/**
 * Defer the theme script so it never blocks first paint.
 *
 * @param string $tag    Script tag.
 * @param string $handle Script handle.
 * @return string
 */
function plantgift_pro_defer_scripts( $tag, $handle ) {
	if ( 'plantgift-pro' === $handle && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'plantgift_pro_defer_scripts', 10, 2 );

/**
 * Trim the WooCommerce cart fragments script off pages with no cart interaction.
 */
function plantgift_pro_trim_cart_fragments() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
		return;
	}
	wp_dequeue_script( 'wc-cart-fragments' );
}
add_action( 'wp_enqueue_scripts', 'plantgift_pro_trim_cart_fragments', 99 );
