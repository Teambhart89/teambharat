<?php
/**
 * Shown when a query returns nothing.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="pg-card--flat">
	<h2><?php esc_html_e( 'Nothing found here yet', 'plantgift-pro' ); ?></h2>
	<p><?php esc_html_e( 'Try a different search term, or browse our gifting categories to find the right plant for your team.', 'plantgift-pro' ); ?></p>
	<?php get_search_form(); ?>
	<p class="pg-mt-2">
		<a class="pg-btn" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Browse all plant gifts', 'plantgift-pro' ); ?>
		</a>
	</p>
</section>
