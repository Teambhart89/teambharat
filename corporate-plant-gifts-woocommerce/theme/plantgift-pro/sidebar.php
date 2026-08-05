<?php
/**
 * Sidebar.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

$pg_sidebar = ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() ) ) ? 'sidebar-shop' : 'sidebar-blog';

if ( ! is_active_sidebar( $pg_sidebar ) ) {
	return;
}
?>
<aside id="secondary" class="pg-sidebar widget-area">
	<?php dynamic_sidebar( $pg_sidebar ); ?>
</aside>
