<?php
/**
 * Default page template with hero title and centered content column.
 *
 * @package Rajdhani_Nursery
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<section class="rn-page-hero">
		<div class="rn-container">
			<nav class="rn-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rajdhani-nursery' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rajdhani-nursery' ); ?></a> &rsaquo; <?php the_title(); ?>
			</nav>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>

	<div class="rn-content">
		<div class="rn-container">
			<div class="rn-content-inner">
				<?php the_content(); ?>

				<?php if ( ! is_page( array( 'book-maali-online', 'contact-us' ) ) ) : ?>
					<div class="rn-cta-band">
						<h2><?php esc_html_e( 'Ready for a Greener Garden?', 'rajdhani-nursery' ); ?></h2>
						<p><?php esc_html_e( 'Book a verified maali online in two minutes, or message us on WhatsApp for a free consultation.', 'rajdhani-nursery' ); ?></p>
						<a class="rn-btn rn-btn-amber" href="<?php echo esc_url( home_url( '/book-maali-online/' ) ); ?>"><?php esc_html_e( 'Book Maali Online', 'rajdhani-nursery' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endwhile; ?>

<?php get_footer(); ?>
