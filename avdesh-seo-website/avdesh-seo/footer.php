<?php
/**
 * Footer template.
 *
 * @package Avdesh_SEO
 */
?>
</main><!-- #main -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div>
				<h4><?php echo esc_html( avseo_info( 'name' ) ); ?><span class="footer-brand-dot">.</span></h4>
				<p style="max-width:340px;color:#b7b2c4;">
					<?php echo esc_html( avseo_info( 'role' ) ); ?> based in <?php echo esc_html( avseo_info( 'location' ) ); ?>.
					Helping brands grow organic traffic, rankings and revenue with white hat SEO and AI search optimization.
				</p>
			</div>

			<div>
				<h4>Services</h4>
				<ul class="footer-links">
					<li><a href="<?php echo esc_url( home_url( '/seo-services/' ) ); ?>">SEO Services</a></li>
					<li><a href="<?php echo esc_url( home_url( '/technical-seo-services/' ) ); ?>">Technical SEO</a></li>
					<li><a href="<?php echo esc_url( home_url( '/on-page-seo-services/' ) ); ?>">On-Page SEO</a></li>
					<li><a href="<?php echo esc_url( home_url( '/off-page-seo-link-building/' ) ); ?>">Link Building</a></li>
					<li><a href="<?php echo esc_url( home_url( '/local-seo-services/' ) ); ?>">Local SEO</a></li>
				</ul>
			</div>

			<div>
				<h4>More</h4>
				<ul class="footer-links">
					<li><a href="<?php echo esc_url( home_url( '/ecommerce-seo-services/' ) ); ?>">eCommerce SEO</a></li>
					<li><a href="<?php echo esc_url( home_url( '/ai-search-optimization/' ) ); ?>">AI Search Optimization</a></li>
					<li><a href="<?php echo esc_url( home_url( '/google-ads-management/' ) ); ?>">Google Ads</a></li>
					<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
				</ul>
			</div>

			<div>
				<h4>Get in touch</h4>
				<ul class="footer-links">
					<li>📞 <a href="tel:<?php echo esc_attr( avseo_info( 'phone_link' ) ); ?>"><?php echo esc_html( avseo_info( 'phone' ) ); ?></a></li>
					<li>✉️ <a href="mailto:<?php echo esc_attr( avseo_info( 'email' ) ); ?>"><?php echo esc_html( avseo_info( 'email' ) ); ?></a></li>
					<li>📍 <?php echo esc_html( avseo_info( 'location' ) ); ?></li>
					<?php if ( avseo_info( 'linkedin' ) && '#' !== avseo_info( 'linkedin' ) ) : ?>
						<li>in <a href="<?php echo esc_url( avseo_info( 'linkedin' ) ); ?>" target="_blank" rel="noopener">LinkedIn</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( avseo_info( 'name' ) ); ?>. All rights reserved.</span>
			<span>White hat SEO &bull; AI Search Optimization &bull; Google Ads</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
