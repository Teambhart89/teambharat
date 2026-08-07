<?php
/**
 * Reusable output helpers.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return an inline SVG icon from a small local set.
 *
 * @param string $name Icon key.
 * @param int    $size Pixel size.
 * @return string
 */
function plantgift_pro_icon( $name, $size = 24 ) {
	$paths = array(
		'leaf'     => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
		'gift'     => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8s1-5 4.5-5a2.5 2.5 0 0 1 0 5"/>',
		'truck'    => '<path d="M14 18V6a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h2"/><path d="M14 9h4l3 3v5a1 1 0 0 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
		'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
		'brush'    => '<path d="m2 22 5-5"/><path d="M14.5 3.5 20.5 9.5 12 18H6v-6Z"/><path d="m17 6 1.5-1.5a2.12 2.12 0 0 1 3 3L20 9"/>',
		'users'    => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'cart'     => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.4 12.2a1.5 1.5 0 0 0 1.5 1.3h8.7a1.5 1.5 0 0 0 1.5-1.2L21 7H6"/>',
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
		'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
		'menu'     => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'close'    => '<path d="M18 6 6 18M6 6l12 12"/>',
		'check'    => '<path d="m4 12 5 5L20 6"/>',
		'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/>',
		'sprout'   => '<path d="M7 20h10"/><path d="M12 20V9"/><path d="M12 9C12 6 9.5 4 6 4c0 3.5 2.5 5 6 5Z"/><path d="M12 12c0-2.5 2-4.5 5-4.5 0 3-2 4.5-5 4.5Z"/>',
		'sun'      => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
		'droplet'  => '<path d="M12 22a7 7 0 0 0 7-7c0-5-7-13-7-13S5 10 5 15a7 7 0 0 0 7 7Z"/>',
		'building' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1M10 22v-3h4v3"/>',
		'star'     => '<path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1 6.2L12 17.3 6.5 20.2l1-6.2L3 9.6l6.2-.9Z"/>',
		'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 11h18"/>',
		'recycle'  => '<path d="M7 19H5a2 2 0 0 1-1.7-3l1.6-2.7"/><path d="m9 22 3-3-3-3"/><path d="M17 5h2a2 2 0 0 1 1.7 3l-1 1.7"/><path d="m15 2-3 3 3 3"/><path d="M12 12.5 9.5 8.2a2 2 0 0 0-3.4 0L5 10"/><path d="M19 14.5 17.4 17a2 2 0 0 1-1.7 1H12"/>',
		'chat'     => '<path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.8-.9L3 20.5l1.6-4.9A8.4 8.4 0 0 1 3.6 11.5a8.4 8.4 0 0 1 8.9-8.4 8.4 8.4 0 0 1 8.5 8.4Z"/>',
		'sparkle'  => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4"/><path d="m6.3 6.3 2.8 2.8M14.9 14.9l2.8 2.8M17.7 6.3l-2.8 2.8M9.1 14.9l-2.8 2.8"/>',
		'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
		'tag'      => '<path d="M20.6 13.3 12.7 21a1.7 1.7 0 0 1-2.4 0l-7.6-7.6a1.7 1.7 0 0 1-.5-1.2V4.4c0-1 .8-1.7 1.7-1.7h7.8c.5 0 .9.2 1.2.5l7.7 7.7a1.7 1.7 0 0 1 0 2.4Z"/><circle cx="7.5" cy="7.5" r="1.3"/>',
	);

	// Solid icons that fill rather than stroke.
	$solid = array(
		'star' => '<path d="m12 2.6 2.9 5.9 6.5 1-4.7 4.6 1.1 6.5L12 17.5l-5.8 3.1 1.1-6.5-4.7-4.6 6.5-1Z"/>',
	);

	if ( isset( $solid[ $name ] ) ) {
		return sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">%2$s</svg>',
			absint( $size ),
			$solid[ $name ]
		);
	}

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%2$s</svg>',
		absint( $size ),
		$paths[ $name ]
	);
}

/**
 * Echo an icon.
 *
 * @param string $name Icon key.
 * @param int    $size Pixel size.
 */
function plantgift_pro_the_icon( $name, $size = 24 ) {
	echo plantgift_pro_icon( $name, $size ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Site logo or text brand.
 */
function plantgift_pro_brand() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<a class="pg-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<span class="pg-brand__mark"><?php plantgift_pro_the_icon( 'leaf', 22 ); ?></span>
		<span class="pg-brand__text">
			<span class="pg-brand__name"><?php bloginfo( 'name' ); ?></span>
			<?php
			$tagline = get_bloginfo( 'description', 'display' );
			if ( $tagline ) :
				?>
				<span class="pg-brand__tag"><?php echo esc_html( $tagline ); ?></span>
			<?php endif; ?>
		</span>
	</a>
	<?php
}

/**
 * Accessible breadcrumb trail. Yields to Yoast or Rank Math when present.
 */
function plantgift_pro_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="pg-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'plantgift-pro' ) . '"><div class="pg-wrap">', '</div></nav>' );
		return;
	}

	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		echo '<nav class="pg-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'plantgift-pro' ) . '"><div class="pg-wrap">';
		rank_math_the_breadcrumbs();
		echo '</div></nav>';
		return;
	}

	$sep   = '<span class="sep" aria-hidden="true">/</span>';
	$items = array( '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'plantgift-pro' ) . '</a>' );

	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( $shop_id > 0 && ! is_shop() ) {
			$items[] = '<a href="' . esc_url( get_permalink( $shop_id ) ) . '">' . esc_html( get_the_title( $shop_id ) ) . '</a>';
		}
		if ( is_product_category() || is_product_tag() ) {
			$term = get_queried_object();
			if ( $term && ! empty( $term->parent ) ) {
				$ancestors = array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) );
				foreach ( $ancestors as $ancestor_id ) {
					$ancestor = get_term( $ancestor_id, $term->taxonomy );
					if ( $ancestor && ! is_wp_error( $ancestor ) ) {
						$items[] = '<a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a>';
					}
				}
			}
			if ( $term ) {
				$items[] = '<span aria-current="page">' . esc_html( $term->name ) . '</span>';
			}
		} elseif ( is_product() ) {
			$terms = get_the_terms( get_the_ID(), 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$primary = array_shift( $terms );
				$items[] = '<a href="' . esc_url( get_term_link( $primary ) ) . '">' . esc_html( $primary->name ) . '</a>';
			}
			$items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
		}
	} elseif ( is_singular() ) {
		$post_id   = get_the_ID();
		$ancestors = array_reverse( get_post_ancestors( $post_id ) );
		foreach ( $ancestors as $ancestor_id ) {
			$items[] = '<a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a>';
		}
		if ( 'post' === get_post_type( $post_id ) ) {
			$blog_id = (int) get_option( 'page_for_posts' );
			if ( $blog_id ) {
				$items[] = '<a href="' . esc_url( get_permalink( $blog_id ) ) . '">' . esc_html( get_the_title( $blog_id ) ) . '</a>';
			}
		}
		$items[] = '<span aria-current="page">' . esc_html( get_the_title( $post_id ) ) . '</span>';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$items[] = '<span aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</span>';
	} elseif ( is_search() ) {
		$items[] = '<span aria-current="page">' . esc_html__( 'Search results', 'plantgift-pro' ) . '</span>';
	} elseif ( is_404() ) {
		$items[] = '<span aria-current="page">' . esc_html__( 'Page not found', 'plantgift-pro' ) . '</span>';
	}

	if ( count( $items ) < 2 ) {
		return;
	}

	echo '<nav class="pg-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'plantgift-pro' ) . '"><div class="pg-wrap">';
	echo wp_kses_post( implode( ' ' . $sep . ' ', $items ) );
	echo '</div></nav>';
}

/**
 * Post meta line.
 */
function plantgift_pro_entry_meta() {
	if ( 'post' !== get_post_type() ) {
		return;
	}
	?>
	<div class="pg-entry-meta">
		<span><?php echo esc_html( get_the_date() ); ?></span>
		<span><?php echo esc_html( get_the_author() ); ?></span>
		<?php
		$cats = get_the_category_list( ', ' );
		if ( $cats ) :
			?>
			<span><?php echo wp_kses_post( $cats ); ?></span>
		<?php endif; ?>
		<span><?php echo esc_html( plantgift_pro_reading_time() ); ?></span>
	</div>
	<?php
}

/**
 * Rough reading time for the current post.
 *
 * @return string
 */
function plantgift_pro_reading_time() {
	$words   = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$minutes = max( 1, (int) ceil( $words / 220 ) );
	/* translators: %d: number of minutes. */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'plantgift-pro' ), $minutes );
}

/**
 * Numeric pagination wrapper.
 */
function plantgift_pro_pagination() {
	$links = paginate_links(
		array(
			'type'      => 'list',
			'mid_size'  => 1,
			'prev_text' => esc_html__( 'Previous', 'plantgift-pro' ),
			'next_text' => esc_html__( 'Next', 'plantgift-pro' ),
		)
	);

	if ( ! $links ) {
		return;
	}

	echo '<nav class="pg-pagination" aria-label="' . esc_attr__( 'Pagination', 'plantgift-pro' ) . '">';
	echo wp_kses_post( str_replace( array( '<ul class=\'page-numbers\'>', '</ul>', '<li>', '</li>' ), '', $links ) );
	echo '</nav>';
}

/**
 * Render an FAQ list. The companion plugin outputs the matching FAQPage schema.
 *
 * @param array  $faqs  Array of arrays with q and a keys.
 * @param string $title Optional heading.
 * @param string $level Heading level for the section title.
 */
function plantgift_pro_faq_list( $faqs, $title = '', $level = 'h2' ) {
	if ( empty( $faqs ) || ! is_array( $faqs ) ) {
		return;
	}

	if ( $title ) {
		printf( '<%1$s id="faqs">%2$s</%1$s>', esc_html( $level ), esc_html( $title ) );
	}

	echo '<div class="pg-faq" data-pg-faq="multi">';
	$i = 0;
	foreach ( $faqs as $faq ) {
		if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
			continue;
		}
		$i++;
		printf(
			'<details class="pg-faq__item" id="faq-%1$d"><summary class="pg-faq__q"><span>%2$s</span></summary><div class="pg-faq__a">%3$s</div></details>',
			absint( $i ),
			esc_html( $faq['q'] ),
			wpautop( wp_kses_post( $faq['a'] ) )
		);
	}
	echo '</div>';
}

/**
 * Small trust strip used across templates.
 */
function plantgift_pro_trust_strip() {
	$items = array(
		array( 'truck', __( 'Pan India delivery on bulk orders', 'plantgift-pro' ) ),
		array( 'brush', __( 'Logo printing on pots and packaging', 'plantgift-pro' ) ),
		array( 'shield', __( 'Healthy plant replacement promise', 'plantgift-pro' ) ),
		array( 'recycle', __( 'Plastic free gift packaging', 'plantgift-pro' ) ),
	);
	?>
	<div class="pg-marquee">
		<div class="pg-wrap pg-marquee__inner">
			<?php foreach ( $items as $item ) : ?>
				<span><?php plantgift_pro_the_icon( $item[0], 16 ); ?><?php echo esc_html( $item[1] ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
