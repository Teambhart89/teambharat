<?php
/**
 * Conversion components.
 *
 * A sticky action bar on phones, a floating quote button on desktop, and the
 * small signals on product cards that tell a shopper what they are getting
 * before they click. Everything here is optional and can be switched off from
 * the Customizer.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Body class so the sticky bar does not cover the footer.
 *
 * @param array $classes Body classes.
 * @return array
 */
function plantgift_pro_cro_body_class( $classes ) {
	if ( get_theme_mod( 'plantgift_sticky_bar', true ) ) {
		$classes[] = 'pg-has-sticky-bar';
	}
	return $classes;
}
add_filter( 'body_class', 'plantgift_pro_cro_body_class' );

/**
 * Where every primary call to action points.
 *
 * The corporate gifting landing page carries the enquiry form, so that is the
 * destination rather than the contact page. Filterable if you move the form.
 *
 * @return string
 */
function plantgift_pro_quote_url() {
	return apply_filters( 'plantgift_pro_quote_url', home_url( '/corporate-plant-gifting/#quote' ) );
}

/**
 * The contact number in a form a tel: or wa.me link accepts.
 *
 * @return string
 */
function plantgift_pro_clean_phone() {
	return preg_replace( '/[^0-9+]/', '', (string) get_theme_mod( 'plantgift_phone', '' ) );
}

/**
 * WhatsApp link built from the phone number, or an empty string.
 *
 * @return string
 */
function plantgift_pro_whatsapp_url() {
	$number = get_theme_mod( 'plantgift_whatsapp', '' );
	if ( ! $number ) {
		$number = plantgift_pro_clean_phone();
	}
	$number = preg_replace( '/[^0-9]/', '', (string) $number );
	if ( ! $number ) {
		return '';
	}
	$message = get_theme_mod(
		'plantgift_whatsapp_text',
		__( 'Hi, I would like a quote for corporate plant gifts.', 'plantgift-pro' )
	);
	return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}

/**
 * Sticky action bar for phones.
 *
 * On a product page the primary action is add to cart, which scrolls the
 * shopper back to the form. Everywhere else it is the quote request, because
 * that is the action a corporate buyer is actually here to take.
 */
function plantgift_pro_sticky_bar() {
	if ( ! get_theme_mod( 'plantgift_sticky_bar', true ) ) {
		return;
	}
	if ( is_404() ) {
		return;
	}
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() ) ) {
		return;
	}

	$phone    = plantgift_pro_clean_phone();
	$whatsapp = plantgift_pro_whatsapp_url();
	$is_product = function_exists( 'is_product' ) && is_product();
	?>
	<div class="pg-sticky-bar" data-pg-sticky-bar data-show="false">
		<?php if ( $phone ) : ?>
			<a class="pg-icon-btn" href="tel:<?php echo esc_attr( $phone ); ?>" aria-label="<?php esc_attr_e( 'Call the gifting desk', 'plantgift-pro' ); ?>">
				<?php plantgift_pro_the_icon( 'phone', 20 ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $whatsapp ) : ?>
			<a class="pg-icon-btn" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener nofollow" aria-label="<?php esc_attr_e( 'Message us on WhatsApp', 'plantgift-pro' ); ?>">
				<?php plantgift_pro_the_icon( 'chat', 20 ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $is_product ) : ?>
			<a class="pg-btn pg-btn--action" href="#pg-buy" data-pg-scroll-to=".summary form.cart">
				<?php plantgift_pro_the_icon( 'cart', 18 ); ?>
				<?php esc_html_e( 'Choose pot and buy', 'plantgift-pro' ); ?>
			</a>
		<?php else : ?>
			<a class="pg-btn pg-btn--action" href="<?php echo esc_url( plantgift_pro_quote_url() ); ?>">
				<?php plantgift_pro_the_icon( 'gift', 18 ); ?>
				<?php esc_html_e( 'Get a bulk quote', 'plantgift-pro' ); ?>
			</a>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'wp_footer', 'plantgift_pro_sticky_bar', 20 );

/**
 * Floating quote button for desktop, revealed after the visitor scrolls.
 */
function plantgift_pro_float_cta() {
	if ( ! get_theme_mod( 'plantgift_float_cta', true ) ) {
		return;
	}
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() ) ) {
		return;
	}
	if ( is_page( 'contact' ) || is_page( 'corporate-plant-gifting' ) ) {
		return;
	}
	?>
	<a class="pg-float-cta" data-pg-float-cta data-show="false" href="<?php echo esc_url( plantgift_pro_quote_url() ); ?>">
		<?php plantgift_pro_the_icon( 'gift', 19 ); ?>
		<?php echo esc_html( get_theme_mod( 'plantgift_float_cta_text', __( 'Get a bulk quote', 'plantgift-pro' ) ) ); ?>
	</a>
	<?php
}
add_action( 'wp_footer', 'plantgift_pro_float_cta', 21 );

/**
 * Tell shoppers a product has pot choices before they open it.
 */
function plantgift_pro_loop_variant_hint() {
	global $product;
	if ( ! $product || ! $product->is_type( 'variable' ) ) {
		return;
	}

	$count = 0;
	foreach ( $product->get_attributes() as $attribute ) {
		if ( $attribute->get_variation() ) {
			$count += count( $attribute->get_options() );
		}
	}
	if ( $count < 2 ) {
		return;
	}

	printf(
		'<span class="pg-loop-variants">%s</span>',
		esc_html__( 'Pot options', 'plantgift-pro' )
	);
}
add_action( 'woocommerce_before_shop_loop_item_title', 'plantgift_pro_loop_variant_hint', 15 );

/**
 * Anchor target so the sticky bar can jump to the buy form.
 */
function plantgift_pro_buy_anchor() {
	echo '<span id="pg-buy" class="screen-reader-text"></span>';
}
add_action( 'woocommerce_before_add_to_cart_form', 'plantgift_pro_buy_anchor' );

/**
 * A short reassurance line directly under the add to cart button.
 *
 * This sits where hesitation happens, so it answers the two questions a buyer
 * has at that exact moment: will it arrive alive, and can I order more later.
 */
function plantgift_pro_after_add_to_cart() {
	?>
	<p class="pg-btn-note" style="flex:1 1 100%;margin:0.35rem 0 0;">
		<?php plantgift_pro_the_icon( 'shield', 15 ); ?>
		<?php esc_html_e( 'Free replacement if a plant arrives damaged. Bulk pricing applies automatically from 25 units.', 'plantgift-pro' ); ?>
	</p>
	<?php
}
add_action( 'woocommerce_after_add_to_cart_button', 'plantgift_pro_after_add_to_cart', 20 );

/**
 * Value strip printed under the shop and category headers.
 */
function plantgift_pro_value_strip() {
	$items = array(
		array( 'truck', __( 'Pan India delivery', 'plantgift-pro' ), __( 'Tracked, packed to survive transit', 'plantgift-pro' ) ),
		array( 'brush', __( 'Your logo on the pot', 'plantgift-pro' ), __( 'Mockup back within 48 hours', 'plantgift-pro' ) ),
		array( 'shield', __( 'Healthy plant promise', 'plantgift-pro' ), __( 'Damaged on arrival, we replace it', 'plantgift-pro' ) ),
		array( 'gift', __( 'Bulk from 25 units', 'plantgift-pro' ), __( 'Five slabs up to 500 and above', 'plantgift-pro' ) ),
	);
	?>
	<div class="pg-value-strip">
		<?php foreach ( $items as $item ) : ?>
			<div class="pg-value-strip__item">
				<?php plantgift_pro_the_icon( $item[0], 22 ); ?>
				<span>
					<strong><?php echo esc_html( $item[1] ); ?></strong>
					<span><?php echo esc_html( $item[2] ); ?></span>
				</span>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Star rating markup for social proof blocks.
 *
 * @param float $rating Rating out of five.
 */
function plantgift_pro_stars( $rating = 5 ) {
	echo '<span class="pg-stars" role="img" aria-label="' . esc_attr(
		sprintf(
			/* translators: %s: rating out of five. */
			__( 'Rated %s out of 5', 'plantgift-pro' ),
			number_format_i18n( $rating, 1 )
		)
	) . '">';
	for ( $i = 0; $i < 5; $i++ ) {
		plantgift_pro_the_icon( 'star', 16 );
	}
	echo '</span>';
}
