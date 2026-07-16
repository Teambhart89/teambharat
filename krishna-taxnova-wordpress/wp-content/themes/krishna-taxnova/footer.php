<?php
/**
 * Site footer with service links, contact details and legal line.
 *
 * @package krishna-taxnova
 */
?>
</main>

<footer class="ktn-footer">
	<div class="wrap ktn-footer-grid">
		<div class="ktn-footer-col ktn-footer-about">
			<p class="ktn-footer-brand">Krishna <em>TaxNova</em></p>
			<p><?php esc_html_e( 'Krishna TaxNova is a Delhi based CA firm offering accounting, income tax, GST, trademark, MCA and business compliance services to startups, businesses and professionals across India. Share your documents online or on WhatsApp and get expert help the same day.', 'krishna-taxnova' ); ?></p>
			<?php $address = ktn_get_option( 'address' ); ?>
			<?php if ( $address ) : ?>
				<p class="ktn-footer-address"><?php echo esc_html( $address ); ?></p>
			<?php endif; ?>
			<?php $hours = ktn_get_option( 'hours' ); ?>
			<?php if ( $hours ) : ?>
				<p><?php echo esc_html( $hours ); ?></p>
			<?php endif; ?>
			<div class="ktn-footer-social">
				<?php
				$socials = array(
					'facebook'  => 'Facebook',
					'instagram' => 'Instagram',
					'linkedin'  => 'LinkedIn',
					'twitter'   => 'X',
					'youtube'   => 'YouTube',
				);
				foreach ( $socials as $key => $label ) {
					$url = ktn_get_option( $key );
					if ( $url ) {
						printf( '<a href="%s" target="_blank" rel="noopener nofollow">%s</a>', esc_url( $url ), esc_html( $label ) );
					}
				}
				?>
			</div>
		</div>

		<?php
		$tree    = ktn_get_service_tree();
		$columns = array_slice( $tree, 0, 3 );
		foreach ( $columns as $branch ) :
			?>
			<div class="ktn-footer-col">
				<h4><?php echo esc_html( $branch['term']->name ); ?></h4>
				<ul>
					<?php foreach ( array_slice( $branch['services'], 0, 6 ) as $service_post ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $service_post ) ); ?>"><?php echo esc_html( $service_post->post_title ); ?></a></li>
					<?php endforeach; ?>
					<li><a class="ktn-footer-more" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>"><?php esc_html_e( 'View all', 'krishna-taxnova' ); ?> &rarr;</a></li>
				</ul>
			</div>
		<?php endforeach; ?>

		<div class="ktn-footer-col">
			<h4><?php esc_html_e( 'Quick Links', 'krishna-taxnova' ); ?></h4>
			<ul>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'All Services', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php esc_html_e( 'Free Online Tools', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog & Insights', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'krishna-taxnova' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'krishna-taxnova' ); ?></a></li>
			</ul>
			<?php $phone = ktn_get_option( 'phone' ); ?>
			<?php if ( $phone ) : ?>
				<p class="ktn-footer-phone"><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">&#9742; <?php echo esc_html( $phone ); ?></a></p>
			<?php endif; ?>
			<?php if ( function_exists( 'ktn_whatsapp_button' ) ) : ?>
				<?php echo ktn_whatsapp_button( '', 'inline' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="ktn-footer-bottom">
		<div class="wrap">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Krishna TaxNova. <?php esc_html_e( 'All rights reserved.', 'krishna-taxnova' ); ?></p>
			<p class="ktn-footer-disclaimer"><?php esc_html_e( 'Krishna TaxNova is a professional services firm. Information on this website is for general guidance only and does not constitute legal or tax advice.', 'krishna-taxnova' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
