<?php
/**
 * Service category landing page: intro, service grid and CTA.
 *
 * @package krishna-taxnova
 */

get_header();

$term = get_queried_object();
?>

<header class="ktn-service-hero">
	<div class="wrap">
		<h1><?php echo esc_html( $term->name ); ?></h1>
		<?php if ( $term->description ) : ?>
			<p class="ktn-service-hero-sub"><?php echo esc_html( $term->description ); ?></p>
		<?php endif; ?>
		<div class="ktn-service-hero-cta">
			<?php echo ktn_whatsapp_button( $term->name ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</header>

<section class="ktn-section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="ktn-service-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/service-card' );
				endwhile;
				?>
			</div>
			<div class="ktn-pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'Services will be published here shortly. Please contact us for immediate help.', 'krishna-taxnova' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="ktn-cta-band">
	<div class="wrap ktn-cta-band-inner">
		<div>
			<h2><?php echo esc_html( sprintf( __( 'Need help choosing the right service in %s?', 'krishna-taxnova' ), $term->name ) ); ?></h2>
			<p><?php esc_html_e( 'Talk to a CA for free. We will point you to exactly what your business needs, nothing more.', 'krishna-taxnova' ); ?></p>
		</div>
		<div class="ktn-cta-band-actions">
			<a class="ktn-btn ktn-btn-light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Free Consultation', 'krishna-taxnova' ); ?></a>
			<?php echo ktn_whatsapp_button( $term->name ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
