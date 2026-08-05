<?php
/**
 * Post card used in listings.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'pg-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="pg-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'plantgift-card', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="pg-card__body">
		<h2 class="pg-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p class="pg-card__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<p class="pg-card__meta"><?php echo esc_html( get_the_date() ); ?> &middot; <?php echo esc_html( plantgift_pro_reading_time() ); ?></p>
	</div>
</article>
