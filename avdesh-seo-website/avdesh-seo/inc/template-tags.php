<?php
/**
 * Reusable template helper functions.
 *
 * @package Avdesh_SEO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a theme option (Customizer) with a sensible default.
 */
function avseo_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Business / contact details, centralised so they stay consistent
 * and are easy to change from the Customizer.
 */
function avseo_info( $key ) {
	$defaults = array(
		'name'       => 'Avdesh Kumar',
		'role'       => 'SEO & AI Search Optimization Specialist',
		'phone'      => '+91 00000 00000',
		'phone_link' => '+910000000000',
		'email'      => 'hello@avdeshseo.com',
		'location'   => 'Delhi, India',
		'linkedin'   => '#',
		'whatsapp'   => '#',
	);
	$map = array(
		'name'       => 'contact_name',
		'role'       => 'contact_role',
		'phone'      => 'contact_phone',
		'phone_link' => 'contact_phone_link',
		'email'      => 'contact_email',
		'location'   => 'contact_location',
		'linkedin'   => 'social_linkedin',
		'whatsapp'   => 'social_whatsapp',
	);
	$mod = isset( $map[ $key ] ) ? $map[ $key ] : '';
	$def = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return $mod ? avseo_opt( $mod, $def ) : $def;
}

/**
 * Signature lowercase section title with an orange dot.
 *
 * @param string $text  Title text (will be lowercased visually via CSS).
 * @param string $intro Optional intro paragraph shown alongside.
 */
function avseo_section_title( $text, $intro = '' ) {
	echo '<div class="section-head">';
	echo '<h2 class="section-title">' . esc_html( $text ) . '<span class="dot">.</span></h2>';
	if ( $intro ) {
		echo '<div class="section-intro">' . esc_html( $intro ) . '<span class="rule"></span></div>';
	}
	echo '</div>';
}

/**
 * Render an image slot. If the given Customizer image is set it shows the image,
 * otherwise it renders a clearly labelled upload placeholder so the site owner
 * knows exactly where to add or replace a picture.
 *
 * @param string $mod_key   Customizer setting key holding an image URL.
 * @param string $label     Placeholder label shown when empty.
 * @param string $alt       Image alt text (good for SEO).
 * @param string $extra_cls Extra CSS classes.
 * @param string $size      Recommended image size, shown to the site owner.
 */
function avseo_image_slot( $mod_key, $label, $alt = '', $extra_cls = '', $size = '' ) {
	$url = avseo_opt( $mod_key, '' );
	$alt = $alt ? $alt : $label;
	if ( $url ) {
		echo '<div class="img-slot filled ' . esc_attr( $extra_cls ) . '">';
		echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy" />';
		echo '</div>';
	} else {
		echo '<div class="img-slot ' . esc_attr( $extra_cls ) . '">';
		echo '<span class="ph-ico">🖼️</span>';
		echo '<strong>' . esc_html( $label ) . '</strong>';
		if ( $size ) {
			echo '<small>Recommended size: <strong>' . esc_html( $size ) . '</strong></small>';
		}
		echo '<small>Upload in Appearance &rarr; Customize &rarr; Images.</small>';
		echo '</div>';
	}
}

/**
 * Simple breadcrumbs for inner pages (good for users and for SEO).
 */
function avseo_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a> &rsaquo; ';
	if ( is_page() ) {
		$post = get_post();
		if ( $post && $post->post_parent ) {
			$parent = get_post( $post->post_parent );
			echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( get_the_title( $parent ) ) . '</a> &rsaquo; ';
		}
		echo '<span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_singular() ) {
		echo '<span>' . esc_html( get_the_title() ) . '</span>';
	} else {
		echo '<span>' . esc_html( wp_get_document_title() ) . '</span>';
	}
	echo '</nav>';
}

/**
 * Output a CTA band used across pages.
 */
function avseo_cta_band( $heading = '', $text = '' ) {
	$heading = $heading ? $heading : 'Ready to grow your organic traffic and revenue?';
	$text    = $text ? $text : 'Let us build an SEO and AI search strategy that brings qualified traffic, leads and sales to your business. Book a free discovery call today.';
	?>
	<section class="bg-cream">
		<div class="container">
			<div class="cta-band">
				<h2><?php echo esc_html( $heading ); ?></h2>
				<p><?php echo esc_html( $text ); ?></p>
				<a class="btn btn-orange" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Book a Free SEO Consultation</a>
			</div>
		</div>
	</section>
	<?php
}
