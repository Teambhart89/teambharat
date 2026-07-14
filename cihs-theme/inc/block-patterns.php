<?php
/**
 * Block patterns for the CIHS theme (Gutenberg editor).
 *
 * @package CIHS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cihs_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern_category(
		'cihs',
		array( 'label' => __( 'CIHS', 'cihs' ) )
	);

	register_block_pattern(
		'cihs/cta-band',
		array(
			'title'      => __( 'CIHS Call-to-Action Band', 'cihs' ),
			'categories' => array( 'cihs' ),
			'content'    => '<!-- wp:group {"className":"cihs-cta"} -->
<div class="wp-block-group cihs-cta"><!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'Partner with CIHS', 'cihs' ) . '</h2>
<!-- /wp:heading --><!-- wp:paragraph -->
<p>' . esc_html__( 'Collaborate with our scholars on research, events and policy dialogue.', 'cihs' ) . '</p>
<!-- /wp:paragraph --><!-- wp:paragraph -->
<p><a class="cihs-btn" href="/contact/">' . esc_html__( 'Get in Touch', 'cihs' ) . '</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
		)
	);

	register_block_pattern(
		'cihs/quote-highlight',
		array(
			'title'      => __( 'CIHS Highlight Quote', 'cihs' ),
			'categories' => array( 'cihs' ),
			'content'    => '<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p>' . esc_html__( 'Vasudhaiva Kutumbakam — the world is one family. Our research begins from this conviction and works toward solutions that are holistic, equitable and inclusive.', 'cihs' ) . '</p>
<!-- /wp:paragraph --><cite>' . esc_html__( 'Centre for Integrated and Holistic Studies', 'cihs' ) . '</cite></blockquote>
<!-- /wp:quote -->',
		)
	);
}
add_action( 'init', 'cihs_register_block_patterns' );
