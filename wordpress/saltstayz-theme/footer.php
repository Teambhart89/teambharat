<?php
/**
 * Site footer.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="footer-inner">
		<div>
			<p><strong><?php echo esc_html( get_bloginfo( 'name' ) ?: 'SaltStayz' ); ?></strong> — Serviced apartments &amp; studios</p>
			<p><?php echo esc_html( get_bloginfo( 'admin_email' ) ); ?></p>
		</div>
		<div>
			<p><a href="<?php echo esc_url( home_url( '/#book' ) ); ?>">Book a stay</a> · <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ssz_booking' ) ); ?>">Operator login</a></p>
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ?: 'SaltStayz' ); ?>. All rights reserved.</p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
