<?php
/**
 * Theme footer with WhatsApp floating button.
 *
 * @package Rajdhani_Nursery
 */
?>
<footer class="rn-footer">
	<div class="rn-container">
		<div class="rn-footer-grid">
			<div>
				<h4>🌱 <?php bloginfo( 'name' ); ?></h4>
				<p><?php esc_html_e( 'Plant nursery in Delhi providing mali on rent, gardener booking online and complete garden care across Delhi NCR. Trusted maalis, honest pricing and healthy plants.', 'rajdhani-nursery' ); ?></p>
				<p>
					📍 <?php echo esc_html( rn_get_option( 'address' ) ); ?><br>
					📞 <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', rn_get_option( 'phone' ) ) ); ?>"><?php echo esc_html( rn_get_option( 'phone' ) ); ?></a><br>
					✉️ <a href="mailto:<?php echo esc_attr( rn_get_option( 'email' ) ); ?>"><?php echo esc_html( rn_get_option( 'email' ) ); ?></a>
				</p>
			</div>
			<div>
				<h4><?php esc_html_e( 'Our Services', 'rajdhani-nursery' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/mali-on-rent-delhi/' ) ); ?>"><?php esc_html_e( 'Mali On Rent Delhi', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/gardener-on-rent-delhi/' ) ); ?>"><?php esc_html_e( 'Gardener On Rent', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/garden-maintenance-services-delhi/' ) ); ?>"><?php esc_html_e( 'Garden Maintenance', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/plant-care-services-delhi/' ) ); ?>"><?php esc_html_e( 'Plant Care Services', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terrace-garden-maintenance-delhi/' ) ); ?>"><?php esc_html_e( 'Terrace Garden Care', 'rajdhani-nursery' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4><?php esc_html_e( 'Quick Links', 'rajdhani-nursery' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/book-maali-online/' ) ); ?>"><?php esc_html_e( 'Book Maali Online', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/maali-service-plans/' ) ); ?>"><?php esc_html_e( 'Plans & Pricing', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>"><?php esc_html_e( 'FAQs', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'rajdhani-nursery' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'rajdhani-nursery' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4><?php esc_html_e( 'Areas We Serve', 'rajdhani-nursery' ); ?></h4>
				<p><?php echo esc_html( implode( ', ', rn_get_areas() ) ); ?></p>
				<a class="rn-btn rn-btn-wa rn-btn-sm" href="<?php echo esc_url( rn_whatsapp_link() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Chat on WhatsApp', 'rajdhani-nursery' ); ?></a>
			</div>
		</div>
	</div>
	<div class="rn-footer-bottom">
		<div class="rn-container">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'rajdhani-nursery' ); ?>
		</div>
	</div>
</footer>

<a class="rn-wa-float" href="<?php echo esc_url( rn_whatsapp_link() ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'rajdhani-nursery' ); ?>">
	<svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 2.9C8.8 2.9 2.9 8.8 2.9 16c0 2.3.6 4.6 1.8 6.6L2.8 29.2l6.8-1.8c1.9 1.1 4.1 1.6 6.4 1.6 7.2 0 13.1-5.9 13.1-13.1S23.2 2.9 16 2.9zm0 23.9c-2 0-3.9-.5-5.6-1.5l-.4-.2-4 1 1.1-3.9-.3-.4c-1.1-1.8-1.7-3.8-1.7-5.9 0-6 4.9-10.9 10.9-10.9S26.9 10 26.9 16 22 26.8 16 26.8zm6-8.1c-.3-.2-1.9-1-2.2-1.1-.3-.1-.5-.2-.8.2-.2.3-.9 1.1-1 1.3-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-1.9-1.8-2.3-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.3.3-.6.1-.2.1-.4 0-.6-.1-.2-.8-1.8-1-2.5-.3-.6-.5-.5-.8-.6h-.7c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.8s1.2 3.2 1.4 3.5c.2.2 2.4 3.7 5.9 5.2.8.4 1.5.6 2 .7.8.3 1.6.2 2.2.1.7-.1 2-.8 2.3-1.6.3-.8.3-1.5.2-1.6-.1-.2-.3-.3-.6-.4z"/></svg>
</a>
<a class="rn-call-float" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', rn_get_option( 'phone' ) ) ); ?>">📞 <?php esc_html_e( 'Call Now', 'rajdhani-nursery' ); ?></a>

<?php wp_footer(); ?>
</body>
</html>
