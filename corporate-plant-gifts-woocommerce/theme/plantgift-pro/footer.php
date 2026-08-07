<?php
/**
 * Site footer.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;
?>
	</main><!-- #pg-main -->

	<?php if ( ! is_page_template( 'page-templates/template-blank.php' ) ) : ?>
	<section class="pg-prefooter" aria-labelledby="pg-prefooter-title">
		<div class="pg-wrap pg-prefooter__inner">
			<div>
				<h2 id="pg-prefooter-title" style="font-size:var(--pg-step-2);margin-bottom:0.4rem;">
					<?php echo esc_html( get_theme_mod( 'plantgift_prefooter_title', __( 'Planning a gifting round for your team?', 'plantgift-pro' ) ) ); ?>
				</h2>
				<p class="pg-mb-0">
					<?php echo esc_html( get_theme_mod( 'plantgift_prefooter_text', __( 'Share your headcount, budget and delivery dates. Our gifting desk sends a curated shortlist with sample photos within one working day.', 'plantgift-pro' ) ) ); ?>
				</p>
			</div>
			<div>
				<div class="pg-btn-row">
					<a class="pg-btn pg-btn--action pg-btn--lg" href="<?php echo esc_url( plantgift_pro_quote_url() ); ?>"><?php esc_html_e( 'Get a bulk quote', 'plantgift-pro' ); ?></a>
					<a class="pg-btn pg-btn--ghost pg-btn--lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Talk to the gifting desk', 'plantgift-pro' ); ?></a>
				</div>
				<?php if ( is_active_sidebar( 'footer-notice' ) ) : ?>
					<div class="pg-small pg-mt-2"><?php dynamic_sidebar( 'footer-notice' ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<footer id="colophon" class="pg-footer">
		<div class="pg-wrap">
			<div class="pg-footer__grid">

				<div class="pg-footer__brand">
					<p><?php bloginfo( 'name' ); ?></p>
					<p><?php echo esc_html( get_theme_mod( 'plantgift_footer_about', __( 'Live plant gifts for workplaces. We grow, pot, brand and deliver low maintenance greenery for employees, clients and events.', 'plantgift-pro' ) ) ); ?></p>
					<div class="pg-social">
						<?php
						$socials = array(
							'linkedin'  => get_theme_mod( 'plantgift_social_linkedin', '' ),
							'instagram' => get_theme_mod( 'plantgift_social_instagram', '' ),
							'facebook'  => get_theme_mod( 'plantgift_social_facebook', '' ),
						);
						foreach ( $socials as $key => $url ) :
							if ( ! $url ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $url ); ?>" rel="noopener noreferrer nofollow" target="_blank">
								<span class="screen-reader-text"><?php echo esc_html( ucfirst( $key ) ); ?></span>
								<?php plantgift_pro_the_icon( 'leaf', 18 ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<?php if ( has_nav_menu( 'footer_' . $i ) ) : ?>
						<div>
							<h3><?php echo esc_html( get_theme_mod( 'plantgift_footer_title_' . $i, '' ) ? get_theme_mod( 'plantgift_footer_title_' . $i ) : sprintf( /* translators: %d: column number */ __( 'Column %d', 'plantgift-pro' ), $i ) ); ?></h3>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer_' . $i,
									'container'      => false,
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
							?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>

				<div>
					<h3><?php esc_html_e( 'Gifting desk', 'plantgift-pro' ); ?></h3>
					<ul>
						<?php $phone = get_theme_mod( 'plantgift_phone', '' ); ?>
						<?php if ( $phone ) : ?>
							<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
						<?php endif; ?>
						<?php $email = get_theme_mod( 'plantgift_email', '' ); ?>
						<?php if ( $email ) : ?>
							<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
						<?php endif; ?>
						<?php $hours = get_theme_mod( 'plantgift_hours', __( 'Monday to Saturday, 9.30am to 6.30pm', 'plantgift-pro' ) ); ?>
						<?php if ( $hours ) : ?>
							<li><?php echo esc_html( $hours ); ?></li>
						<?php endif; ?>
						<?php $addr = get_theme_mod( 'plantgift_address', '' ); ?>
						<?php if ( $addr ) : ?>
							<li><?php echo nl2br( esc_html( $addr ) ); ?></li>
						<?php endif; ?>
					</ul>
				</div>

			</div>

			<div class="pg-footer__bottom">
				<p style="margin:0;">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'plantgift-pro' ); ?>
				</p>
				<?php
				if ( has_nav_menu( 'legal' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'legal',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				}
				?>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
