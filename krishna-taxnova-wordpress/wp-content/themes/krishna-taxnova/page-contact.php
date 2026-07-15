<?php
/**
 * Template Name: Contact Page
 *
 * @package krishna-taxnova
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<header class="ktn-service-hero">
		<div class="wrap">
			<h1><?php the_title(); ?></h1>
			<p class="ktn-service-hero-sub"><?php esc_html_e( 'Call, WhatsApp or send your details and documents online. A CA will get back to you the same working day.', 'krishna-taxnova' ); ?></p>
		</div>
	</header>

	<div class="wrap ktn-service-layout ktn-contact-layout">
		<div class="ktn-service-content">
			<?php the_content(); ?>

			<div class="ktn-contact-cards">
				<?php $phone = ktn_get_option( 'phone' ); ?>
				<?php if ( $phone ) : ?>
					<div class="ktn-contact-card">
						<h3><?php esc_html_e( 'Call Us', 'krishna-taxnova' ); ?></h3>
						<p><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
					</div>
				<?php endif; ?>
				<?php $email = ktn_get_option( 'email' ); ?>
				<?php if ( $email ) : ?>
					<div class="ktn-contact-card">
						<h3><?php esc_html_e( 'Email Us', 'krishna-taxnova' ); ?></h3>
						<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
					</div>
				<?php endif; ?>
				<div class="ktn-contact-card">
					<h3><?php esc_html_e( 'WhatsApp', 'krishna-taxnova' ); ?></h3>
					<p><?php echo ktn_whatsapp_button(); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
				</div>
				<?php $address = ktn_get_option( 'address' ); ?>
				<?php if ( $address ) : ?>
					<div class="ktn-contact-card">
						<h3><?php esc_html_e( 'Visit Us', 'krishna-taxnova' ); ?></h3>
						<p><?php echo esc_html( $address ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php $map = ktn_get_option( 'map_embed' ); ?>
			<?php if ( $map ) : ?>
				<div class="ktn-map"><?php echo $map; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<?php endif; ?>
		</div>

		<aside class="ktn-service-sidebar">
			<?php echo do_shortcode( '[ktn_service_form title="Send Us Your Details"]' ); ?>
		</aside>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
