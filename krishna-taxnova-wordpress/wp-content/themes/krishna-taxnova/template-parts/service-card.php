<?php
/**
 * Service card used in grids.
 *
 * @package krishna-taxnova
 */

$card_timeline = get_post_meta( get_the_ID(), '_ktn_timeline', true );
?>
<a class="ktn-service-card" href="<?php the_permalink(); ?>">
	<h3><?php the_title(); ?></h3>
	<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
	<span class="ktn-service-card-meta">
		<?php if ( $card_timeline ) : ?>
			<span class="ktn-chip">&#9201; <?php echo esc_html( $card_timeline ); ?></span>
		<?php endif; ?>
		<span class="ktn-service-card-link"><?php esc_html_e( 'Know more', 'krishna-taxnova' ); ?> &rarr;</span>
	</span>
</a>
