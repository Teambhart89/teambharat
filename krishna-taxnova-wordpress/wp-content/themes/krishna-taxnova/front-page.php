<?php
/**
 * Homepage: hero, trust strip, category grid, how it works, why us,
 * testimonials, FAQs (with schema from core plugin) and final CTA.
 *
 * @package krishna-taxnova
 */

get_header();

$home = get_option( 'ktn_home_data', array() );
$get  = function ( $key, $default = '' ) use ( $home ) {
	return isset( $home[ $key ] ) && '' !== $home[ $key ] ? $home[ $key ] : $default;
};
?>

<section class="ktn-hero">
	<div class="wrap ktn-hero-inner">
		<div class="ktn-hero-copy">
			<p class="ktn-hero-eyebrow"><?php echo esc_html( $get( 'eyebrow', 'CA firm in Delhi, serving all India' ) ); ?></p>
			<h1><?php echo esc_html( $get( 'h1', 'Online CA Services for Tax, GST, Trademark, MCA and Business Compliance' ) ); ?></h1>
			<p class="ktn-hero-sub"><?php echo esc_html( $get( 'sub', 'Krishna TaxNova helps startups, businesses and professionals register, stay compliant and save tax. Fill your details online, upload your documents or WhatsApp them to us, and a qualified expert takes it from there.' ) ); ?></p>
			<ul class="ktn-hero-points">
				<li><?php esc_html_e( 'Upload documents online in minutes', 'krishna-taxnova' ); ?></li>
				<li><?php esc_html_e( 'WhatsApp support for every service', 'krishna-taxnova' ); ?></li>
				<li><?php esc_html_e( 'Transparent fixed pricing, no surprises', 'krishna-taxnova' ); ?></li>
			</ul>
			<div class="ktn-hero-cta">
				<a class="ktn-btn ktn-btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Explore All Services', 'krishna-taxnova' ); ?></a>
				<?php echo ktn_whatsapp_button(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
		<div class="ktn-hero-form">
			<?php echo do_shortcode( '[ktn_service_form title="Talk to a CA Today"]' ); ?>
		</div>
	</div>
</section>

<section class="ktn-trust">
	<div class="wrap ktn-trust-grid">
		<div><strong><?php echo esc_html( $get( 'stat1_num', '1500+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat1_label', 'Clients Served' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat2_num', '90+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat2_label', 'Services Offered' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat3_num', '10+' ) ); ?></strong><span><?php echo esc_html( $get( 'stat3_label', 'Years of Experience' ) ); ?></span></div>
		<div><strong><?php echo esc_html( $get( 'stat4_num', '4.8/5' ) ); ?></strong><span><?php echo esc_html( $get( 'stat4_label', 'Client Rating' ) ); ?></span></div>
	</div>
</section>

<section class="ktn-section">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'Our Services', 'krishna-taxnova' ); ?></h2>
		<p class="ktn-section-sub"><?php esc_html_e( 'Everything your business needs under one roof: registrations, tax filings, intellectual property and ongoing compliance.', 'krishna-taxnova' ); ?></p>
		<div class="ktn-cat-grid">
			<?php foreach ( ktn_get_service_tree() as $branch ) : ?>
				<a class="ktn-cat-card" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>">
					<span class="ktn-cat-icon"><?php echo ktn_icon( get_term_meta( $branch['term']->term_id, '_ktn_icon', true ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3><?php echo esc_html( $branch['term']->name ); ?></h3>
					<p><?php echo esc_html( get_term_meta( $branch['term']->term_id, '_ktn_tagline', true ) ); ?></p>
					<span class="ktn-cat-count"><?php echo esc_html( sprintf( _n( '%d service', '%d services', count( $branch['services'] ), 'krishna-taxnova' ), count( $branch['services'] ) ) ); ?> &rarr;</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ktn-section ktn-section-alt">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'How It Works', 'krishna-taxnova' ); ?></h2>
		<p class="ktn-section-sub"><?php esc_html_e( 'Three simple steps. Everything happens online, from any city in India.', 'krishna-taxnova' ); ?></p>
		<div class="ktn-how-grid">
			<div class="ktn-how-card"><span class="ktn-how-num">1</span><h3><?php esc_html_e( 'Share Your Requirement', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Fill the short form on any service page or message us on WhatsApp. A CA calls you back to understand your need and confirm the exact scope and fee.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-how-card"><span class="ktn-how-num">2</span><h3><?php esc_html_e( 'Upload Your Documents', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Send documents through the secure upload form on the service page or on WhatsApp. We verify everything and tell you if anything is missing.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-how-card"><span class="ktn-how-num">3</span><h3><?php esc_html_e( 'We File, You Relax', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Our team prepares and files your application or return, tracks it with the department and shares the final certificate or acknowledgment with you.', 'krishna-taxnova' ); ?></p></div>
		</div>
	</div>
</section>

<section class="ktn-section">
	<div class="wrap">
		<h2 class="ktn-section-title"><?php esc_html_e( 'Why Businesses Choose Krishna TaxNova', 'krishna-taxnova' ); ?></h2>
		<div class="ktn-why-grid">
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Qualified CA Team', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Your work is reviewed and signed off by experienced Chartered Accountants, so filings are right the first time.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Document Upload and WhatsApp', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'No courier, no office visits. Upload documents on the website or WhatsApp them from your phone.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Fixed, Honest Pricing', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'You get a written quote before work starts. Government fees are always shown separately.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'Deadline Reminders', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'We track your GST, TDS, ROC and income tax due dates and remind you before every deadline.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'One Point of Contact', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'A dedicated expert handles your account end to end, so you never repeat your story.', 'krishna-taxnova' ); ?></p></div>
			<div class="ktn-why-card"><h3><?php esc_html_e( 'All India Coverage', 'krishna-taxnova' ); ?></h3><p><?php esc_html_e( 'Based in Delhi, we serve clients in every state through a fully online process.', 'krishna-taxnova' ); ?></p></div>
		</div>
	</div>
</section>

<?php $tools_page = get_page_by_path( 'tools' ); ?>
<?php if ( $tools_page ) : ?>
	<section class="ktn-section ktn-section-alt">
		<div class="wrap">
			<h2 class="ktn-section-title"><?php esc_html_e( 'Free Online Tools', 'krishna-taxnova' ); ?></h2>
			<p class="ktn-section-sub"><?php esc_html_e( 'Quick calculators built by our CA team. Instant answers, no signup, works on any device.', 'krishna-taxnova' ); ?></p>
			<?php echo do_shortcode( '[ktn_tools_grid]' ); ?>
			<p style="text-align:center;margin-top:1.5rem;">
				<a class="ktn-btn ktn-btn-outline" href="<?php echo esc_url( get_permalink( $tools_page ) ); ?>"><?php esc_html_e( 'View All Tools', 'krishna-taxnova' ); ?></a>
			</p>
		</div>
	</section>
<?php endif; ?>

<?php
$home_faqs = get_option( 'ktn_home_faqs', array() );
if ( $home_faqs ) :
	?>
	<section class="ktn-section ktn-section-alt">
		<div class="wrap ktn-narrow">
			<?php ktn_render_faqs( $home_faqs, __( 'Frequently Asked Questions', 'krishna-taxnova' ) ); ?>
		</div>
	</section>
<?php endif; ?>

<section class="ktn-cta-band">
	<div class="wrap ktn-cta-band-inner">
		<div>
			<h2><?php esc_html_e( 'Ready to get started?', 'krishna-taxnova' ); ?></h2>
			<p><?php esc_html_e( 'Tell us what you need. Get a free consultation and a fixed quote today.', 'krishna-taxnova' ); ?></p>
		</div>
		<div class="ktn-cta-band-actions">
			<a class="ktn-btn ktn-btn-light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Free Consultation', 'krishna-taxnova' ); ?></a>
			<?php echo ktn_whatsapp_button(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
