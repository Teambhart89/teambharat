<?php
/**
 * Contact page template (slug: contact).
 *
 * @package Avdesh_SEO
 */
get_header();
$name = avseo_info( 'name' );
?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<span class="eyebrow">Contact</span>
		<h1><?php echo esc_html( get_the_title() ? get_the_title() : "Let's Grow Your Organic Traffic and Revenue" ); ?></h1>
		<p class="lead">
			<?php
			echo esc_html( has_excerpt() ? get_the_excerpt() : 'Tell me about your business and your goals. I will reply with clear, honest next steps and a plan to bring you qualified traffic, leads and sales.' );
			?>
		</p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<div class="contact-grid">
			<div>
				<h2 class="section-title">get in touch<span class="dot">.</span></h2>
				<p style="max-width:440px;color:var(--muted);margin-bottom:26px;">
					Based in <?php echo esc_html( avseo_info( 'location' ) ); ?> and working with clients worldwide. Reach out
					through any channel below.
				</p>

				<div class="contact-item">
					<span class="ci-ico">📞</span>
					<div>
						<h4>Phone</h4>
						<a href="tel:<?php echo esc_attr( avseo_info( 'phone_link' ) ); ?>"><?php echo esc_html( avseo_info( 'phone' ) ); ?></a>
					</div>
				</div>
				<div class="contact-item">
					<span class="ci-ico">✉️</span>
					<div>
						<h4>Email</h4>
						<a href="mailto:<?php echo esc_attr( avseo_info( 'email' ) ); ?>"><?php echo esc_html( avseo_info( 'email' ) ); ?></a>
					</div>
				</div>
				<div class="contact-item">
					<span class="ci-ico">📍</span>
					<div>
						<h4>Location</h4>
						<span><?php echo esc_html( avseo_info( 'location' ) ); ?></span>
					</div>
				</div>
				<?php if ( avseo_info( 'linkedin' ) && '#' !== avseo_info( 'linkedin' ) ) : ?>
				<div class="contact-item">
					<span class="ci-ico">in</span>
					<div>
						<h4>LinkedIn</h4>
						<a href="<?php echo esc_url( avseo_info( 'linkedin' ) ); ?>" target="_blank" rel="noopener">Connect with me</a>
					</div>
				</div>
				<?php endif; ?>

				<div style="margin-top:26px;">
					<?php avseo_image_slot( 'img_profile', 'Add your profile photo', $name, '', '600 x 600 px' ); ?>
				</div>
			</div>

			<div>
				<div class="contact-form">
					<h3 style="text-transform:none;">Request a free SEO consultation</h3>
					<?php
					// If Contact Form 7 or another form shortcode is added to the page content, show it.
					$content = get_the_content();
					if ( has_shortcode( $content, 'contact-form-7' ) || trim( wp_strip_all_tags( $content ) ) ) {
						echo apply_filters( 'the_content', $content );
					} else {
						// Simple mailto form as a ready to use default.
						?>
						<form action="mailto:<?php echo esc_attr( avseo_info( 'email' ) ); ?>" method="post" enctype="text/plain">
							<label for="cf-name">Your name</label>
							<input type="text" id="cf-name" name="name" placeholder="John Doe" required>

							<label for="cf-email">Email address</label>
							<input type="email" id="cf-email" name="email" placeholder="you@company.com" required>

							<label for="cf-website">Website URL</label>
							<input type="text" id="cf-website" name="website" placeholder="https://yourwebsite.com">

							<label for="cf-service">Service you need</label>
							<select id="cf-service" name="service">
								<option>SEO Services</option>
								<option>Technical SEO</option>
								<option>On-Page SEO</option>
								<option>Off-Page SEO &amp; Link Building</option>
								<option>Local SEO</option>
								<option>eCommerce SEO</option>
								<option>AI Search Optimization</option>
								<option>Google Ads</option>
							</select>

							<label for="cf-message">How can I help?</label>
							<textarea id="cf-message" name="message" rows="5" placeholder="Tell me about your goals..."></textarea>

							<button type="submit" class="btn btn-orange" style="width:100%;justify-content:center;">Send message</button>
						</form>
						<p style="font-size:.8rem;color:var(--muted);margin-top:14px;margin-bottom:0;">
							Tip: for a professional inbox integration, install a plugin such as Contact Form 7 or WPForms and paste
							its shortcode into this page. It will automatically replace this form.
						</p>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
