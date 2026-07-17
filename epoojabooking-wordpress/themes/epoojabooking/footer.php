<?php
/**
 * Site footer.
 *
 * @package epoojabooking
 */
?>
</main>

<footer class="epb-footer">
	<div class="epb-footer-arch" aria-hidden="true"></div>
	<div class="epb-container">
		<div class="epb-footer-grid">
			<div class="epb-footer-col epb-footer-about">
				<p class="epb-footer-brand">epooja<span>booking</span></p>
				<p><?php esc_html_e( 'Experience seamless online puja booking for all your spiritual needs. Book online pujas, temple offerings, chadhava, astrology consultations and spiritual products from trusted temples across India.', 'epoojabooking' ); ?></p>
				<ul class="epb-trust-list">
					<li><?php esc_html_e( 'Verified temples and pandits', 'epoojabooking' ); ?></li>
					<li><?php esc_html_e( 'Secure payments, UPI and cards', 'epoojabooking' ); ?></li>
					<li><?php esc_html_e( 'Prasad delivery in India and abroad', 'epoojabooking' ); ?></li>
				</ul>
			</div>

			<nav class="epb-footer-col" aria-label="<?php esc_attr_e( 'Services', 'epoojabooking' ); ?>">
				<h2 class="epb-footer-heading"><?php esc_html_e( 'Our Services', 'epoojabooking' ); ?></h2>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/online-puja-booking/' ) ); ?>"><?php esc_html_e( 'Online Puja Booking', 'epoojabooking' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/online-chadhava-offering/' ) ); ?>"><?php esc_html_e( 'Chadhava and Temple Offerings', 'epoojabooking' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/online-astrology-consultation/' ) ); ?>"><?php esc_html_e( 'Astrology Consultation', 'epoojabooking' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/online-abhishek-booking/' ) ); ?>"><?php esc_html_e( 'Abhishek Booking', 'epoojabooking' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/online-havan-booking/' ) ); ?>"><?php esc_html_e( 'Havan Booking', 'epoojabooking' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/book-pandit-online/' ) ); ?>"><?php esc_html_e( 'Book Pandit Ji Online', 'epoojabooking' ); ?></a></li>
				</ul>
			</nav>

			<nav class="epb-footer-col" aria-label="<?php esc_attr_e( 'Quick links', 'epoojabooking' ); ?>">
				<h2 class="epb-footer-heading"><?php esc_html_e( 'Quick Links', 'epoojabooking' ); ?></h2>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => function () {
						echo '<ul>';
						echo '<li><a href="' . esc_url( home_url( '/about-us/' ) ) . '">' . esc_html__( 'About Us', 'epoojabooking' ) . '</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/faq/' ) ) . '">' . esc_html__( 'FAQ', 'epoojabooking' ) . '</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/contact-us/' ) ) . '">' . esc_html__( 'Contact Us', 'epoojabooking' ) . '</a></li>';
						echo '</ul>';
					},
				) );
				?>
			</nav>

			<div class="epb-footer-col">
				<h2 class="epb-footer-heading"><?php esc_html_e( 'Devotee Support', 'epoojabooking' ); ?></h2>
				<p><?php esc_html_e( 'Serving devotees in India, USA, UK, Canada, Australia, UAE and worldwide.', 'epoojabooking' ); ?></p>
				<p><a href="mailto:support@epoojabooking.com">support@epoojabooking.com</a></p>
				<p><?php esc_html_e( 'WhatsApp support available 7 days a week.', 'epoojabooking' ); ?></p>
			</div>
		</div>

		<div class="epb-footer-bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> epoojabooking.com &middot; <?php esc_html_e( 'All rights reserved.', 'epoojabooking' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
