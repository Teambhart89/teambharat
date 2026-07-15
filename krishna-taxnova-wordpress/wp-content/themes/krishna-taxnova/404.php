<?php
/**
 * 404 template.
 *
 * @package krishna-taxnova
 */

get_header();
?>

<div class="wrap ktn-page ktn-narrow ktn-404">
	<h1><?php esc_html_e( 'Page not found', 'krishna-taxnova' ); ?></h1>
	<p><?php esc_html_e( 'The page you are looking for may have moved. Search below or browse all services.', 'krishna-taxnova' ); ?></p>
	<?php get_search_form(); ?>
	<p><a class="ktn-btn ktn-btn-primary" href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'View All Services', 'krishna-taxnova' ); ?></a></p>
</div>

<?php get_footer(); ?>
