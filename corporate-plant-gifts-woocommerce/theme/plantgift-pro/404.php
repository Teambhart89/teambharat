<?php
/**
 * 404 template.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="pg-wrap pg-404">
	<p class="pg-eyebrow"><?php esc_html_e( 'Error 404', 'plantgift-pro' ); ?></p>
	<h1><?php esc_html_e( 'This page has been repotted somewhere else', 'plantgift-pro' ); ?></h1>
	<p class="pg-lede" style="max-width:52ch;margin-inline:auto;">
		<?php esc_html_e( 'The link you followed no longer points anywhere. Search below, or start from one of the popular gifting collections.', 'plantgift-pro' ); ?>
	</p>

	<div style="max-width:34rem;margin:2rem auto;"><?php get_search_form(); ?></div>

	<?php
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$pg_terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'number'     => 8,
				'orderby'    => 'count',
				'order'      => 'DESC',
				'hide_empty' => true,
			)
		);
		if ( $pg_terms && ! is_wp_error( $pg_terms ) ) {
			echo '<ul class="pg-pill-list" style="justify-content:center;">';
			foreach ( $pg_terms as $pg_term ) {
				printf(
					'<li><a class="pg-pill" href="%s">%s</a></li>',
					esc_url( get_term_link( $pg_term ) ),
					esc_html( $pg_term->name )
				);
			}
			echo '</ul>';
		}
	}
	?>

	<p class="pg-mt-2">
		<a class="pg-btn pg-btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'plantgift-pro' ); ?></a>
	</p>
</div>

<?php
get_footer();
