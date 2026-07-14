<?php
/**
 * 404 template.
 *
 * @package CIHS
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="cihs-container cihs-404">
		<div class="cihs-404__code">404</div>
		<h1><?php esc_html_e( 'This page could not be found', 'cihs' ); ?></h1>
		<p><?php esc_html_e( 'The page you are looking for may have been moved or no longer exists. Try searching, or return to the homepage.', 'cihs' ); ?></p>
		<div style="max-width:420px;margin:2em auto;"><?php get_search_form(); ?></div>
		<a class="cihs-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'cihs' ); ?></a>
	</div>
</main>

<?php
get_footer();
