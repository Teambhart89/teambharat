<?php
/**
 * Events archive: upcoming and past events split by date.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php esc_html_e( 'Events', 'cihs' ); ?></h1>
		<p style="color:#c6cede;max-width:640px;"><?php esc_html_e( 'Lectures, seminars, round tables and interaction series convened by CIHS.', 'cihs' ); ?></p>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container">
		<?php
		$cihs_today    = gmdate( 'Y-m-d' );
		$cihs_upcoming = array();
		$cihs_past     = array();

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$cihs_date = get_post_meta( get_the_ID(), '_cihs_event_date', true );
				if ( $cihs_date && $cihs_date >= $cihs_today ) {
					$cihs_upcoming[] = get_post();
				} else {
					$cihs_past[] = get_post();
				}
			}
		}

		// Soonest upcoming event first.
		usort(
			$cihs_upcoming,
			function ( $a, $b ) {
				return strcmp(
					get_post_meta( $a->ID, '_cihs_event_date', true ),
					get_post_meta( $b->ID, '_cihs_event_date', true )
				);
			}
		);
		?>

		<h2><?php esc_html_e( 'Upcoming Events', 'cihs' ); ?></h2>
		<?php
		if ( $cihs_upcoming ) {
			echo '<div class="cihs-grid cihs-grid--4" style="margin-bottom:2em;">';
			foreach ( $cihs_upcoming as $cihs_event ) {
				cihs_render_event_card( $cihs_event );
			}
			echo '</div>';
		} else {
			echo '<p>' . esc_html__( 'No upcoming events at the moment — please check back soon or follow us on social media for announcements.', 'cihs' ) . '</p>';
		}
		?>

		<h2 style="margin-top:2em;"><?php esc_html_e( 'Past Events', 'cihs' ); ?></h2>
		<?php
		if ( $cihs_past ) {
			echo '<div class="cihs-grid cihs-grid--4">';
			foreach ( $cihs_past as $cihs_event ) {
				cihs_render_event_card( $cihs_event );
			}
			echo '</div>';
		} else {
			echo '<p>' . esc_html__( 'Past events will be archived here.', 'cihs' ) . '</p>';
		}
		?>

		<div class="pagination"><?php the_posts_pagination(); ?></div>
	</div>
</main>

<?php
get_footer();
