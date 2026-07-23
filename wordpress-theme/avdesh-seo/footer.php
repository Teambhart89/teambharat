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
	'in' => avdesh_opt( 'avdesh_linkedin', '' ),
	'ig' => avdesh_opt( 'avdesh_instagram', '' ),
	'f'  => avdesh_opt( 'avdesh_facebook', '' ),
	'X'  => avdesh_opt( 'avdesh_twitter', '' ),
	'yt' => avdesh_opt( 'avdesh_youtube', '' ),
);
?>
</main><!-- #content -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<div class="brand">
					<span class="brand-mark">AK</span>
					<span style="color:#fff;">Avdesh Kumar</span>
				</div>
				<p>SEO, AI Search (AISO), GEO &amp; Google Ads consultant based in <?php echo esc_html( $location ); ?>. 8+ years helping 500+ businesses grow organic traffic, leads and revenue with ethical, white-hat strategies.</p>
				<div class="socials">
					<?php foreach ( $socials as $label => $url ) : ?>
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $label ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<div>
				<h4>Services</h4>
				<?php foreach ( array( 'seo-services', 'ai-search-optimization', 'technical-seo-services', 'local-seo-services', 'ecommerce-seo-services', 'google-ads-management' ) as $slug ) :
					$s = avdesh_get_service( $slug ); if ( ! $s ) { continue; } ?>
					<a href="<?php echo esc_url( home_url( '/' . $slug . '/' ) ); ?>"><?php echo esc_html( $s['menu'] ); ?></a><br>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">All services →</a>
			</div>

			<div>
				<h4>Explore</h4>
				<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a><br>
				<a href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Case Studies</a><br>
				<a href="<?php echo esc_url( home_url( '/seo-results/' ) ); ?>">SEO Results</a><br>
				<a href="<?php echo esc_url( home_url( '/industries/' ) ); ?>">Industries</a><br>
				<a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a><br>
				<a href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>">FAQs</a>
			</div>

			<div>
				<h4>Get started</h4>
				<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>">✉ <?php echo esc_html( $email ); ?></a><br><?php endif; ?>
				<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">✆ <?php echo esc_html( $phone ); ?></a><br><?php endif; ?>
				<span style="display:inline-block;padding:4px 0;color:#AEB6DA;">📍 <?php echo esc_html( $location ); ?></span><br>
				<div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:14px;">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/book-free-seo-audit/' ) ); ?>">Book a free SEO audit</a>
					<?php $wa = avdesh_whatsapp_url(); if ( $wa ) : ?>
						<a class="wa-btn" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><?php echo avdesh_whatsapp_svg( 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="wa-label">Chat on WhatsApp</span></a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Avdesh Kumar. All rights reserved.</span>
			<span>SEO • AISO • GEO • Google Ads • White-Hat Only</span>
		</div>
	</div>
</footer>

<?php avdesh_float_contact(); ?>

<?php wp_footer(); ?>
</body>
</html>
