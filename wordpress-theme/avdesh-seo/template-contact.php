<?php
/**
 * Template Name: Contact
 *
 * @package Avdesh_SEO
 */

get_header();

$email    = avdesh_opt( 'avdesh_email', '' );
$phone    = avdesh_opt( 'avdesh_phone', '' );
$whatsapp = avdesh_opt( 'avdesh_whatsapp', '' );
$location = avdesh_opt( 'avdesh_location', 'Delhi, India' );
$calendly = avdesh_opt( 'avdesh_calendly', '' );
?>

<section class="page-hero">
	<div class="container">
		<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span>Contact</span></nav>
		<span class="eyebrow">Get in touch</span>
		<h1>Let's grow your search visibility</h1>
		<p>Tell me about your business and goals. I'll reply with how SEO, AI search optimization, GEO and Google Ads can drive real results for you.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="contact-grid">
			<div class="reveal">
				<h2>Contact details</h2>
				<ul class="contact-info" style="margin-top:22px;">
					<?php if ( $email ) : ?><li><span class="ci-ic">✉</span><span><b>Email</b><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span></li><?php endif; ?>
					<?php if ( $phone ) : ?><li><span class="ci-ic">✆</span><span><b>Phone</b><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></span></li><?php endif; ?>
					<li><span class="ci-ic">📍</span><span><b>Location</b><?php echo esc_html( $location ); ?></span></li>
					<li><span class="ci-ic">🌍</span><span><b>Serving</b>India, USA, UK, Canada, Australia, UAE &amp; Europe</span></li>
				</ul>
				<div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:16px;">
					<?php if ( $whatsapp ) : ?><a class="btn btn-accent" target="_blank" rel="noopener" href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $whatsapp ) ); ?>">💬 WhatsApp me</a><?php endif; ?>
					<?php if ( $calendly ) : ?><a class="btn btn-outline" target="_blank" rel="noopener" href="<?php echo esc_url( $calendly ); ?>">📅 Book a call</a><?php endif; ?>
				</div>
				<div class="callout" style="margin-top:26px;">Prefer email? Send your website URL and your main goal, and I'll reply with quick, actionable ideas.</div>
			</div>

			<div class="reveal">
				<div class="card">
					<h2 style="font-size:1.5rem;">Send a message</h2>
					<?php
					$shortcode = avdesh_opt( 'avdesh_form_shortcode', '' );
					if ( $shortcode ) {
						echo do_shortcode( $shortcode );
					} else {
						$to = $email ? $email : get_option( 'admin_email' );
						?>
						<form action="mailto:<?php echo esc_attr( $to ); ?>" method="post" enctype="text/plain" style="margin-top:18px;">
							<div class="field"><label for="cf-name">Your name</label><input id="cf-name" type="text" name="Name" required></div>
							<div class="field"><label for="cf-email">Your email</label><input id="cf-email" type="email" name="Email" required></div>
							<div class="field"><label for="cf-site">Website URL</label><input id="cf-site" type="text" name="Website"></div>
							<div class="field"><label for="cf-service">Service needed</label>
								<select id="cf-service" name="Service">
									<?php foreach ( avdesh_services() as $srv ) : ?><option><?php echo esc_html( $srv['menu'] ); ?></option><?php endforeach; ?>
									<option>Not sure yet</option>
								</select>
							</div>
							<div class="field"><label for="cf-msg">Your message</label><textarea id="cf-msg" name="Message" rows="5" required></textarea></div>
							<button class="btn btn-primary btn-block" type="submit">Send message →</button>
						</form>
						<p style="font-size:.82rem;color:var(--muted);margin-top:12px;">Tip: for a database-backed form, install WPForms or Contact Form 7 and paste its shortcode into Customize → Contact &amp; Identity.</p>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
