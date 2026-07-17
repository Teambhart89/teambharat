<?php
/**
 * Main fallback template (blog index and archives).
 *
 * @package epoojabooking
 */

get_header();
?>

<section class="epb-page-hero">
	<div class="epb-container">
		<h1>
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} elseif ( is_archive() ) {
				the_archive_title();
			} elseif ( is_search() ) {
				/* translators: %s: search query. */
				printf( esc_html__( 'Search results for "%s"', 'epoojabooking' ), esc_html( get_search_query() ) );
			} else {
				esc_html_e( 'Spiritual Blog', 'epoojabooking' );
			}
			?>
		</h1>
	</div>
	<div class="epb-arch-divider" aria-hidden="true"></div>
</section>

<section class="epb-section">
	<div class="epb-container">
		<?php if ( have_posts() ) : ?>
			<div class="epb-card-grid epb-grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'epb-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="epb-card-thumb" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
							</a>
						<?php endif; ?>
						<h2 class="epb-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						<span class="epb-card-link" aria-hidden="true"><?php esc_html_e( 'Read more', 'epoojabooking' ); ?> →</span>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="epb-pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found here yet. Please explore our puja and chadhava services from the menu.', 'epoojabooking' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
