<?php
/**
 * Single service page: H1, structured content, sticky enquiry form with
 * document upload, WhatsApp button, FAQs and related services.
 *
 * @package krishna-taxnova
 */

get_header();

while ( have_posts() ) :
	the_post();
	$timeline  = get_post_meta( get_the_ID(), '_ktn_timeline', true );
	$authority = get_post_meta( get_the_ID(), '_ktn_authority', true );
	?>

	<header class="ktn-service-hero">
		<div class="wrap">
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="ktn-service-hero-sub"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="ktn-service-hero-meta">
				<?php if ( $timeline ) : ?>
					<span>&#9201; <?php echo esc_html( $timeline ); ?></span>
				<?php endif; ?>
				<?php if ( $authority ) : ?>
					<span>&#127963; <?php echo esc_html( $authority ); ?></span>
				<?php endif; ?>
				<span>&#128241; <?php esc_html_e( 'Upload documents online or on WhatsApp', 'krishna-taxnova' ); ?></span>
			</div>
			<div class="ktn-service-hero-cta">
				<a class="ktn-btn ktn-btn-primary" href="#ktn-enquiry-form"><?php esc_html_e( 'Start Now: Fill Details and Upload Documents', 'krishna-taxnova' ); ?></a>
				<?php echo ktn_whatsapp_button( get_the_title() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</div>
		</div>
	</header>

	<div class="wrap ktn-service-layout">
		<article class="ktn-service-content" id="post-<?php the_ID(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="ktn-service-feature">
					<?php the_post_thumbnail( 'ktn-service-feature', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
				</figure>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php ktn_render_faqs( ktn_get_service_faqs( get_the_ID() ), sprintf( __( '%s: Frequently Asked Questions', 'krishna-taxnova' ), get_the_title() ) ); ?>

			<section class="ktn-service-bottom-cta">
				<h2><?php echo esc_html( sprintf( __( 'Get %s Done by Experts', 'krishna-taxnova' ), get_the_title() ) ); ?></h2>
				<p><?php esc_html_e( 'Fill in your details, upload your documents online or send them on WhatsApp. A qualified CA will review your case and call you back with the exact steps and a fixed quote.', 'krishna-taxnova' ); ?></p>
				<div class="ktn-service-hero-cta">
					<a class="ktn-btn ktn-btn-primary" href="#ktn-enquiry-form"><?php esc_html_e( 'Fill Details Online', 'krishna-taxnova' ); ?></a>
					<?php echo ktn_whatsapp_button( get_the_title() ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>
			</section>
		</article>

		<aside class="ktn-service-sidebar">
			<div class="ktn-sticky">
				<?php echo do_shortcode( '[ktn_service_form]' ); ?>
			</div>
		</aside>
	</div>

	<?php
	// Related services from the same category.
	$terms = get_the_terms( get_the_ID(), 'service_category' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$related = get_posts(
			array(
				'post_type'      => 'service',
				'posts_per_page' => 4,
				'post__not_in'   => array( get_the_ID() ),
				'orderby'        => 'rand',
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'service_category',
						'field'    => 'term_id',
						'terms'    => $terms[0]->term_id,
					),
				),
			)
		);
		if ( $related ) :
			?>
			<section class="ktn-section ktn-section-alt">
				<div class="wrap">
					<h2 class="ktn-section-title"><?php esc_html_e( 'Related Services', 'krishna-taxnova' ); ?></h2>
					<div class="ktn-service-grid">
						<?php foreach ( $related as $post ) : setup_postdata( $post ); // phpcs:ignore ?>
							<?php get_template_part( 'template-parts/service-card' ); ?>
						<?php endforeach; wp_reset_postdata(); ?>
					</div>
				</div>
			</section>
			<?php
		endif;
	}
	?>

<?php endwhile; ?>
<?php get_footer(); ?>
