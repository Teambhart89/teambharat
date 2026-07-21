<?php
/**
 * Footer
 *
 * @package Avdesh_SEO
 */

$email    = avdesh_opt( 'avdesh_email', '' );
$phone    = avdesh_opt( 'avdesh_phone', '' );
$location = avdesh_opt( 'avdesh_location', 'Delhi, India' );
$socials  = array(
	'LinkedIn'  => avdesh_opt( 'avdesh_linkedin', '' ),
	'Instagram' => avdesh_opt( 'avdesh_instagram', '' ),
	'Facebook'  => avdesh_opt( 'avdesh_facebook', '' ),
	'X'         => avdesh_opt( 'avdesh_twitter', '' ),
	'YouTube'   => avdesh_opt( 'avdesh_youtube', '' ),
);
$icons = array( 'LinkedIn' => 'in', 'Instagram' => 'ig', 'Facebook' => 'f', 'X' => 'x', 'YouTube' => 'yt' );
?>
</main><!-- #content -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<div class="brand">
					<span class="brand-mark">AK</span>
					<span>Avdesh Kumar</span>
				</div>
				<p>SEO &amp; AI Search Optimization Specialist based in <?php echo esc_html( $location ); ?>. Helping businesses grow organic traffic, rankings and real ROI with white-hat SEO, GEO and Google Ads.</p>
				<div class="socials">
					<?php foreach ( $socials as $name => $url ) : ?>
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $icons[ $name ] ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<div>
				<h4>Services</h4>
				<?php foreach ( array( 'seo-services', 'ai-search-optimization', 'technical-seo-services', 'on-page-seo-services', 'off-page-seo-link-building' ) as $slug ) :
					$s = avdesh_get_service( $slug ); if ( ! $s ) { continue; } ?>
					<a href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>"><?php echo esc_html( $s['menu'] ); ?></a><br>
				<?php endforeach; ?>
			</div>

			<div>
				<h4>More</h4>
				<?php foreach ( array( 'local-seo-services', 'ecommerce-seo-services', 'google-ads-management', 'seo-content-writing', 'seo-audit-services' ) as $slug ) :
					$s = avdesh_get_service( $slug ); if ( ! $s ) { continue; } ?>
					<a href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>"><?php echo esc_html( $s['menu'] ); ?></a><br>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a><br>
				<a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>">Portfolio</a>
			</div>

			<div>
				<h4>Get in touch</h4>
				<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>">✉ <?php echo esc_html( $email ); ?></a><br><?php endif; ?>
				<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">✆ <?php echo esc_html( $phone ); ?></a><br><?php endif; ?>
				<span style="display:inline-block;padding:4px 0;">📍 <?php echo esc_html( $location ); ?></span><br>
				<a class="btn btn-primary" style="margin-top:12px;" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a project</a>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Avdesh Kumar. All rights reserved.</span>
			<span>SEO • GEO • AI Search • Google Ads</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
