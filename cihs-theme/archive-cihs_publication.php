<?php
/**
 * Publications archive: filterable library of research output.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php esc_html_e( 'Publications', 'cihs' ); ?></h1>
		<p style="color:#c6cede;max-width:640px;"><?php esc_html_e( 'Research papers, reports, issue briefs and press releases from CIHS scholars.', 'cihs' ); ?></p>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container">

		<?php
		$cihs_types = get_terms(
			array(
				'taxonomy'   => 'cihs_publication_type',
				'hide_empty' => true,
			)
		);
		if ( $cihs_types && ! is_wp_error( $cihs_types ) ) :
			?>
			<p style="margin-bottom:2.4em;">
				<strong><?php esc_html_e( 'Browse by type:', 'cihs' ); ?></strong>
				<?php foreach ( $cihs_types as $cihs_type ) : ?>
					<a class="cihs-tags" style="margin-left:8px;" href="<?php echo esc_url( get_term_link( $cihs_type ) ); ?>"><?php echo esc_html( $cihs_type->name ); ?> (<?php echo (int) $cihs_type->count; ?>)</a>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="cihs-archive-grid">
				<?php
				while ( have_posts() ) {
					the_post();
					cihs_render_card();
				}
				?>
			</div>
			<div class="pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'No publications yet — add the first one from Publications in the dashboard.', 'cihs' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
