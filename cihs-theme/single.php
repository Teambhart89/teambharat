<?php
/**
 * Single template for posts, publications and events.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container cihs-with-sidebar">
		<div>
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php cihs_entry_meta(); ?>

					<?php if ( 'cihs_publication' === get_post_type() ) : ?>
						<div class="cihs-card__meta">
							<?php
							$cihs_terms = get_the_terms( get_the_ID(), 'cihs_publication_type' );
							if ( $cihs_terms && ! is_wp_error( $cihs_terms ) ) {
								echo esc_html( $cihs_terms[0]->name );
							}
							$cihs_focus = get_the_terms( get_the_ID(), 'cihs_focus_area' );
							if ( $cihs_focus && ! is_wp_error( $cihs_focus ) ) {
								echo ' &middot; ' . esc_html( $cihs_focus[0]->name );
							}
							?>
						</div>
					<?php endif; ?>

					<?php if ( 'cihs_event' === get_post_type() ) : ?>
						<div class="cihs-contact-card" style="margin-bottom:2em;">
							<h3><?php esc_html_e( 'Event Details', 'cihs' ); ?></h3>
							<?php
							$cihs_date  = get_post_meta( get_the_ID(), '_cihs_event_date', true );
							$cihs_time  = get_post_meta( get_the_ID(), '_cihs_event_time', true );
							$cihs_venue = get_post_meta( get_the_ID(), '_cihs_event_venue', true );
							$cihs_link  = get_post_meta( get_the_ID(), '_cihs_event_link', true );
							if ( $cihs_date ) {
								echo '<p><strong>' . esc_html__( 'Date:', 'cihs' ) . '</strong> ' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $cihs_date ) ) ) . '</p>';
							}
							if ( $cihs_time ) {
								echo '<p><strong>' . esc_html__( 'Time:', 'cihs' ) . '</strong> ' . esc_html( $cihs_time ) . '</p>';
							}
							if ( $cihs_venue ) {
								echo '<p><strong>' . esc_html__( 'Venue:', 'cihs' ) . '</strong> ' . esc_html( $cihs_venue ) . '</p>';
							}
							if ( $cihs_link ) {
								echo '<p><a class="cihs-btn" href="' . esc_url( $cihs_link ) . '" target="_blank" rel="noopener">' . esc_html__( 'Register', 'cihs' ) . '</a></p>';
							}
							?>
						</div>
					<?php endif; ?>

					<?php if ( 'cihs_career' === get_post_type() ) : ?>
						<div class="cihs-contact-card" style="margin-bottom:2em;">
							<h3><?php esc_html_e( 'Opening Details', 'cihs' ); ?></h3>
							<?php
							$cihs_job_type     = get_post_meta( get_the_ID(), '_cihs_career_type', true );
							$cihs_job_location = get_post_meta( get_the_ID(), '_cihs_career_location', true );
							$cihs_job_deadline = get_post_meta( get_the_ID(), '_cihs_career_deadline', true );
							if ( $cihs_job_type ) {
								echo '<p><strong>' . esc_html__( 'Type:', 'cihs' ) . '</strong> ' . esc_html( $cihs_job_type ) . '</p>';
							}
							if ( $cihs_job_location ) {
								echo '<p><strong>' . esc_html__( 'Location:', 'cihs' ) . '</strong> ' . esc_html( $cihs_job_location ) . '</p>';
							}
							if ( $cihs_job_deadline ) {
								echo '<p><strong>' . esc_html__( 'Apply by:', 'cihs' ) . '</strong> ' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $cihs_job_deadline ) ) ) . '</p>';
							}
							?>
							<p><a class="cihs-btn" href="<?php echo esc_url( home_url( '/careers-internships/#apply' ) ); ?>"><?php esc_html_e( 'Apply for this Position', 'cihs' ); ?></a></p>
						</div>
					<?php endif; ?>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
					<?php endif; ?>

					<div class="entry-content">
						<?php
						the_content();
						wp_link_pages();
						?>
					</div>

					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="cihs-tags">
							<?php
							the_category( ' ' );
							the_tags( '', ' ' );
							?>
						</div>
					<?php endif; ?>
				</article>
				<?php
				the_post_navigation(
					array(
						'prev_text' => '&larr; %title',
						'next_text' => '%title &rarr;',
					)
				);

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
			?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>

<?php
get_footer();
