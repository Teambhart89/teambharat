<?php
/**
 * Analytics and search engine verification.
 *
 * Adds Customizer fields for a Google Analytics 4 Measurement ID and for
 * Google Search Console and Bing verification codes, then prints the correct
 * tags in the head. This lets the owner connect analytics and verification
 * without editing code or installing a separate plugin.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Analytics and Verification Customizer section.
 */
function avseo_analytics_customize( $wp_customize ) {
	$wp_customize->add_section( 'avseo_analytics', array(
		'title'       => __( 'Analytics & Verification', 'avdesh-seo' ),
		'description' => __( 'Connect Google Analytics and verify your site with search engines. Paste only the codes, not the full tags.', 'avdesh-seo' ),
		'priority'    => 36,
	) );

	$fields = array(
		'ga4_id' => array(
			'label' => __( 'Google Analytics 4 Measurement ID (starts with G-)', 'avdesh-seo' ),
			'desc'  => __( 'Example: G-XXXXXXXXXX', 'avdesh-seo' ),
		),
		'gsc_verification' => array(
			'label' => __( 'Google Search Console verification code', 'avdesh-seo' ),
			'desc'  => __( 'The content value from the HTML tag method.', 'avdesh-seo' ),
		),
		'bing_verification' => array(
			'label' => __( 'Bing Webmaster verification code', 'avdesh-seo' ),
			'desc'  => __( 'The content value from the meta tag method.', 'avdesh-seo' ),
		),
	);

	foreach ( $fields as $key => $data ) {
		$wp_customize->add_setting( $key, array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'       => $data['label'],
			'description' => $data['desc'],
			'section'     => 'avseo_analytics',
			'type'        => 'text',
		) );
	}
}
add_action( 'customize_register', 'avseo_analytics_customize' );

/**
 * Print verification meta tags early in the head.
 */
function avseo_verification_tags() {
	$gsc  = avseo_opt( 'gsc_verification', '' );
	$bing = avseo_opt( 'bing_verification', '' );

	if ( $gsc ) {
		// Accept either the raw token or a pasted full tag.
		if ( preg_match( '/content=["\']([^"\']+)["\']/', $gsc, $m ) ) {
			$gsc = $m[1];
		}
		echo '<meta name="google-site-verification" content="' . esc_attr( $gsc ) . '">' . "\n";
	}
	if ( $bing ) {
		if ( preg_match( '/content=["\']([^"\']+)["\']/', $bing, $m ) ) {
			$bing = $m[1];
		}
		echo '<meta name="msvalidate.01" content="' . esc_attr( $bing ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'avseo_verification_tags', 1 );

/**
 * Print the Google Analytics 4 tag when a Measurement ID is set.
 * Logged in administrators are not tracked, to keep your data clean.
 */
function avseo_ga4_tag() {
	$id = trim( avseo_opt( 'ga4_id', '' ) );
	if ( ! $id || ! preg_match( '/^G-[A-Z0-9]+$/i', $id ) ) {
		return;
	}
	if ( current_user_can( 'manage_options' ) ) {
		return;
	}
	$id = esc_js( $id );
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $id ); ?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '<?php echo $id; ?>');
</script>
	<?php
}
add_action( 'wp_head', 'avseo_ga4_tag', 90 );

/**
 * Make sure the WordPress core XML sitemap stays enabled and is announced in
 * robots.txt. If an SEO plugin such as Rank Math or Yoast is active it will
 * manage its own sitemap, which is also fine.
 */
function avseo_enable_core_sitemap( $enabled ) {
	return true;
}
add_filter( 'wp_sitemaps_enabled', 'avseo_enable_core_sitemap' );
