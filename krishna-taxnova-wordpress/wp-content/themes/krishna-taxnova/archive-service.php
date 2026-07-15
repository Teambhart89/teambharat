<?php
/**
 * All services overview grouped by category. URL: /services/
 *
 * @package krishna-taxnova
 */

get_header();
?>

<header class="ktn-service-hero">
	<div class="wrap">
		<h1><?php esc_html_e( 'All CA Services in One Place', 'krishna-taxnova' ); ?></h1>
		<p class="ktn-service-hero-sub"><?php esc_html_e( 'Browse every service we offer: business registration, GST, income tax, trademark and IPR, MCA compliance, licenses, NGO, NBFC, environmental approvals and accounting. Each service page lets you fill your details online and upload your documents, or you can simply WhatsApp them to us.', 'krishna-taxnova' ); ?></p>
	</div>
</header>

<?php foreach ( ktn_get_service_tree() as $branch ) : ?>
	<section class="ktn-section ktn-archive-block">
		<div class="wrap">
			<div class="ktn-archive-head">
				<h2><?php echo esc_html( $branch['term']->name ); ?></h2>
				<a class="ktn-archive-all" href="<?php echo esc_url( get_term_link( $branch['term'] ) ); ?>"><?php esc_html_e( 'Category page', 'krishna-taxnova' ); ?> &rarr;</a>
			</div>
			<?php $tagline = get_term_meta( $branch['term']->term_id, '_ktn_tagline', true ); ?>
			<?php if ( $tagline ) : ?>
				<p class="ktn-section-sub ktn-left"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>
			<div class="ktn-service-grid">
				<?php
				global $post;
				foreach ( $branch['services'] as $post ) : // phpcs:ignore
					setup_postdata( $post );
					get_template_part( 'template-parts/service-card' );
				endforeach;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endforeach; ?>

<?php get_footer(); ?>
