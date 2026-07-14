<?php
/**
 * Site footer: brand blurb, quick links, focus areas, contact, legal bar.
 *
 * @package CIHS
 */
?>
	<footer id="colophon" class="site-footer">
		<div class="cihs-container">
			<div class="cihs-footer-main">
				<div class="cihs-footer-brand">
					<h3><?php bloginfo( 'name' ); ?></h3>
					<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
					<div class="cihs-footer-social">
						<?php cihs_social_links(); ?>
					</div>
				</div>

				<div>
					<h4><?php esc_html_e( 'Quick Links', 'cihs' ); ?></h4>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</div>

				<div>
					<h4><?php esc_html_e( 'Focus Areas', 'cihs' ); ?></h4>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/research/geopolitics-security/' ) ); ?>"><?php esc_html_e( 'Geopolitics & Security', 'cihs' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/research/policy-governance/' ) ); ?>"><?php esc_html_e( 'Policy & Governance', 'cihs' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/research/economy-technology/' ) ); ?>"><?php esc_html_e( 'Economy & Technology', 'cihs' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/research/culture-civilisation/' ) ); ?>"><?php esc_html_e( 'Culture & Civilisation', 'cihs' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/research/diaspora-global/' ) ); ?>"><?php esc_html_e( 'Diaspora & Global Engagement', 'cihs' ); ?></a></li>
					</ul>
				</div>

				<div>
					<h4><?php esc_html_e( 'Contact', 'cihs' ); ?></h4>
					<ul>
						<li><?php echo esc_html( get_theme_mod( 'cihs_address', '903, Ground Floor, Sector 29' ) ); ?>,<br>
							<?php echo esc_html( get_theme_mod( 'cihs_city', 'Noida' ) ); ?> – <?php echo esc_html( get_theme_mod( 'cihs_postcode', '201301' ) ); ?><br>
							<?php echo esc_html( get_theme_mod( 'cihs_region', 'New Delhi NCR, India' ) ); ?></li>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'cihs_phone', '011-46698734' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'cihs_phone', '011-46698734' ) ); ?></a></li>
						<li><a href="mailto:<?php echo esc_attr( get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cihs_email', 'contact@cihs.org.in' ) ); ?></a></li>
						<li><?php echo esc_html( get_theme_mod( 'cihs_hours', 'Mon – Fri, 9:30 AM – 6:00 PM IST' ) ); ?></li>
					</ul>
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="cihs-footer-bottom">
			<div class="cihs-container">
				<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'cihs' ); ?></span>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'legal',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</div>
		</div>
	</footer>

	<button class="cihs-top-btn" aria-label="<?php esc_attr_e( 'Back to top', 'cihs' ); ?>">&uarr;</button>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
