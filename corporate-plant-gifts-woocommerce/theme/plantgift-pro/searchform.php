<?php
/**
 * Search form.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

$pg_search_id = 'pg-search-' . wp_unique_id();
?>
<form role="search" method="get" class="pg-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $pg_search_id ); ?>">
		<?php esc_html_e( 'Search for plants, pots or gifting guides', 'plantgift-pro' ); ?>
	</label>
	<div style="display:flex;gap:0.5rem;">
		<input type="search" id="<?php echo esc_attr( $pg_search_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Try succulents, air plants, jute pots', 'plantgift-pro' ); ?>">
		<button class="pg-btn" type="submit"><?php esc_html_e( 'Search', 'plantgift-pro' ); ?></button>
	</div>
</form>
