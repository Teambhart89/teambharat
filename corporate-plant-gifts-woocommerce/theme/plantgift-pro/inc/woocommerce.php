<?php
/**
 * WooCommerce integration.
 *
 * Layout is handled with hooks rather than template overrides so the theme keeps
 * working when WooCommerce updates its own templates.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Remove the default sidebar and wrappers, then add our own.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Open the shop layout.
 */
function plantgift_pro_woo_wrapper_start() {
	$has_sidebar = is_active_sidebar( 'sidebar-shop' ) && ( is_shop() || is_product_category() || is_product_tag() );
	echo '<div class="pg-wrap pg-shop-wrap">';
	if ( $has_sidebar ) {
		echo '<div class="pg-layout pg-layout--sidebar-left">';
		echo '<aside class="pg-sidebar widget-area" aria-label="' . esc_attr__( 'Shop filters', 'plantgift-pro' ) . '">';
		dynamic_sidebar( 'sidebar-shop' );
		echo '</aside>';
		echo '<div class="pg-shop-main">';
	} else {
		echo '<div class="pg-shop-main pg-shop-main--full">';
	}
}
add_action( 'woocommerce_before_main_content', 'plantgift_pro_woo_wrapper_start', 10 );

/**
 * Close the shop layout.
 */
function plantgift_pro_woo_wrapper_end() {
	$has_sidebar = is_active_sidebar( 'sidebar-shop' ) && ( is_shop() || is_product_category() || is_product_tag() );
	echo '</div>'; // .pg-shop-main
	if ( $has_sidebar ) {
		echo '</div>'; // .pg-layout
	}
	echo '</div>'; // .pg-wrap
}
add_action( 'woocommerce_after_main_content', 'plantgift_pro_woo_wrapper_end', 10 );

/**
 * Archive page header with the H1 and the short intro.
 */
function plantgift_pro_shop_header() {
	if ( ! is_shop() && ! is_product_category() && ! is_product_tag() ) {
		return;
	}

	$intro = '';
	if ( is_product_category() || is_product_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$intro = get_term_meta( $term->term_id, '_pg_intro', true );
			if ( ! $intro ) {
				$intro = wp_trim_words( wp_strip_all_tags( $term->description ), 45 );
			}
		}
	} else {
		$shop_id = wc_get_page_id( 'shop' );
		$intro   = $shop_id > 0 ? get_post_field( 'post_excerpt', $shop_id ) : '';
	}
	?>
	<div class="pg-page-header">
		<div class="pg-wrap">
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php if ( $intro ) : ?>
				<p class="pg-lede"><?php echo esc_html( wp_strip_all_tags( $intro ) ); ?></p>
			<?php endif; ?>
			<?php plantgift_pro_child_category_pills(); ?>
		</div>
	</div>
	<div class="pg-wrap" style="margin-top:-1.25rem;position:relative;z-index:2;">
		<?php plantgift_pro_value_strip(); ?>
	</div>
	<?php
}
add_action( 'woocommerce_before_main_content', 'plantgift_pro_shop_header', 5 );

// The default title and description output is replaced by the header above.
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Show child categories as quick filter pills.
 */
function plantgift_pro_child_category_pills() {
	$parent = 0;
	if ( is_product_category() ) {
		$term   = get_queried_object();
		$parent = $term instanceof WP_Term ? $term->term_id : 0;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => $parent,
			'hide_empty' => true,
			'number'     => 12,
			'exclude'    => array( get_option( 'default_product_cat' ) ),
		)
	);

	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	echo '<ul class="pg-pill-list pg-mt-2">';
	foreach ( $terms as $term ) {
		printf(
			'<li><a class="pg-pill" href="%s">%s</a></li>',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}
	echo '</ul>';
}

/**
 * Wrap the result count and ordering select in a toolbar.
 */
function plantgift_pro_toolbar_open() {
	echo '<div class="pg-shop-toolbar">';
}
add_action( 'woocommerce_before_shop_loop', 'plantgift_pro_toolbar_open', 19 );

/**
 * Close the toolbar.
 */
function plantgift_pro_toolbar_close() {
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'plantgift_pro_toolbar_close', 31 );

/**
 * Short teaser under each product title in the loop.
 */
function plantgift_pro_loop_excerpt() {
	global $product;
	$short = $product ? $product->get_short_description() : '';
	if ( ! $short ) {
		return;
	}
	printf( '<p class="pg-loop-excerpt">%s</p>', esc_html( wp_trim_words( wp_strip_all_tags( $short ), 14 ) ) );
}
add_action( 'woocommerce_after_shop_loop_item_title', 'plantgift_pro_loop_excerpt', 8 );

/**
 * Long form SEO copy printed below the product grid on category pages.
 *
 * Keeping the detailed copy under the products means shoppers reach the
 * catalogue first while search engines still index the full page.
 */
function plantgift_pro_category_body() {
	if ( ! is_product_category() ) {
		return;
	}

	$term = get_queried_object();
	if ( ! $term instanceof WP_Term ) {
		return;
	}

	$body = get_term_meta( $term->term_id, '_pg_seo_body', true );
	if ( ! $body ) {
		$body = $term->description;
	}

	if ( $body ) {
		echo '<div class="pg-term-body">';
		echo wp_kses_post( wpautop( do_shortcode( $body ) ) );
		echo '</div>';
	}

	$faqs = get_term_meta( $term->term_id, '_pg_faqs', true );
	if ( is_array( $faqs ) && $faqs ) {
		echo '<div class="pg-term-body">';
		plantgift_pro_faq_list( $faqs, __( 'Frequently asked questions', 'plantgift-pro' ), 'h2' );
		if ( function_exists( 'plantgift_core_faq_schema' ) ) {
			plantgift_core_faq_schema( $faqs );
		}
		echo '</div>';
	}
}
add_action( 'woocommerce_after_main_content', 'plantgift_pro_category_body', 5 );

/**
 * Trust points on the single product summary.
 */
function plantgift_pro_product_usps() {
	$points = array(
		__( 'Bulk pricing from 25 units, quoted the same day', 'plantgift-pro' ),
		__( 'Logo printing available on the pot and the sleeve', 'plantgift-pro' ),
		__( 'Printed care card packed with every plant', 'plantgift-pro' ),
		__( 'Free replacement if a plant arrives damaged', 'plantgift-pro' ),
	);
	echo '<ul class="pg-usp-list">';
	foreach ( $points as $point ) {
		printf( '<li>%s<span>%s</span></li>', plantgift_pro_icon( 'check', 18 ), esc_html( $point ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</ul>';
}
add_action( 'woocommerce_single_product_summary', 'plantgift_pro_product_usps', 29 );

/**
 * Bulk quantity slab table on the single product page.
 */
function plantgift_pro_bulk_panel() {
	global $product;
	if ( ! $product ) {
		return;
	}

	$slabs = get_post_meta( $product->get_id(), '_pg_bulk_slabs', true );
	if ( ! is_array( $slabs ) || ! $slabs ) {
		$slabs = array(
			array( '25 to 49', '5%' ),
			array( '50 to 99', '10%' ),
			array( '100 to 249', '15%' ),
			array( '250 to 499', '20%' ),
			array( '500 and above', __( 'Custom quote', 'plantgift-pro' ) ),
		);
	}
	?>
	<div class="pg-bulk-panel">
		<h2><?php esc_html_e( 'Bulk order pricing', 'plantgift-pro' ); ?></h2>
		<table>
			<caption class="screen-reader-text"><?php esc_html_e( 'Discount applied by order quantity', 'plantgift-pro' ); ?></caption>
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Quantity', 'plantgift-pro' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Discount', 'plantgift-pro' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $slabs as $slab ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $slab[0] ); ?></th>
						<td><?php echo esc_html( $slab[1] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p class="pg-small pg-muted pg-mb-0" style="margin-top:0.75rem;">
			<?php esc_html_e( 'Slabs apply to the combined quantity in your cart, so mixed plant and pot selections still qualify.', 'plantgift-pro' ); ?>
			<a href="<?php echo esc_url( home_url( '/bulk-plant-gifts-for-companies/' ) ); ?>"><?php esc_html_e( 'See how bulk gifting works', 'plantgift-pro' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'plantgift_pro_bulk_panel', 33 );

/**
 * Products per page on archives.
 *
 * @return int
 */
function plantgift_pro_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'plantgift_pro_loop_columns' );

/**
 * Show 24 products per archive page.
 *
 * @return int
 */
function plantgift_pro_products_per_page() {
	return 24;
}
add_filter( 'loop_shop_per_page', 'plantgift_pro_products_per_page', 20 );

/**
 * Nicer add to cart labels in the loop.
 *
 * @param string     $text    Button text.
 * @param WC_Product $product Product object.
 * @return string
 */
function plantgift_pro_add_to_cart_text( $text, $product ) {
	if ( $product && $product->is_type( 'variable' ) ) {
		return __( 'Choose pot options', 'plantgift-pro' );
	}
	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'plantgift_pro_add_to_cart_text', 10, 2 );

/**
 * Cart count fragment so the header badge updates without a reload.
 *
 * @param array $fragments Fragments.
 * @return array
 */
function plantgift_pro_cart_fragment( $fragments ) {
	ob_start();
	?>
	<span class="pg-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
	<?php
	$fragments['span.pg-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'plantgift_pro_cart_fragment' );

/**
 * Rename the product data tabs so they read like buyer questions.
 *
 * @param array $tabs Tabs.
 * @return array
 */
function plantgift_pro_product_tabs( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = __( 'About this plant gift', 'plantgift-pro' );
	}
	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = __( 'Pot, size and care details', 'plantgift-pro' );
	}
	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = __( 'Buyer reviews', 'plantgift-pro' );
	}
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'plantgift_pro_product_tabs', 20 );

/**
 * Show four related products.
 *
 * @param array $args Args.
 * @return array
 */
function plantgift_pro_related_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'plantgift_pro_related_args', 20 );

/**
 * Placeholder image sizing.
 *
 * @return string
 */
function plantgift_pro_placeholder_size() {
	return 'plantgift-card';
}
add_filter( 'woocommerce_placeholder_img_size', 'plantgift_pro_placeholder_size' );
