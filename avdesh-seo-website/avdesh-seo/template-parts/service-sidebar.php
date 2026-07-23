<?php
/**
 * Shared sidebar shown on every service page: service navigation + CTA.
 *
 * @package Avdesh_SEO
 */
$current = get_post_field( 'post_name', get_post() );
$links   = array(
	'seo-services'                => 'SEO Services',
	'technical-seo-services'      => 'Technical SEO',
	'on-page-seo-services'        => 'On-Page SEO',
	'off-page-seo-link-building'  => 'Off-Page SEO & Link Building',
	'local-seo-services'          => 'Local SEO',
	'ecommerce-seo-services'      => 'eCommerce SEO',
	'ai-search-optimization'      => 'AI Search Optimization',
	'google-ads-management'       => 'Google Ads',
);
?>
<aside>
	<div class="sidebar-card">
		<h3>All Services</h3>
		<ul>
			<?php foreach ( $links as $slug => $label ) : ?>
				<li>
					<a href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>"<?php echo ( $slug === $current ) ? ' style="color:var(--orange);font-weight:700;"' : ''; ?>>
						<?php echo esc_html( $label ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<p style="color:#cfc9d9;font-size:.92rem;">Ready to grow your organic traffic and revenue?</p>
		<a class="btn btn-orange" style="width:100%;justify-content:center;" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Free SEO Audit</a>
	</div>
</aside>
