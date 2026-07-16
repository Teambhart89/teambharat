<?php
/**
 * Fallback template for archives, search and blog posts.
 *
 * @package Rajdhani_Nursery
 */

get_header();
?>

<section class="rn-page-hero">
	<div class="rn-container">
		<h1>
			<?php
			if ( is_search() ) {
				printf( esc_html__( 'Search results for: %s', 'rajdhani-nursery' ), esc_html( get_search_query() ) );
			} elseif ( is_archive() ) {
				the_archive_title();
			} elseif ( is_singular() ) {
				echo esc_html( get_the_title() );
			} else {
				esc_html_e( 'Gardening Tips & Updates', 'rajdhani-nursery' );
			}
			?>
		</h1>
	</div>
</section>

<div class="rn-content">
	<div class="rn-container">
		<div class="rn-content-inner">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( is_singular() ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<article style="border-bottom:1px solid var(--rn-line);padding-bottom:24px;margin-bottom:24px;">
							<h2 style="margin-top:0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p style="color:var(--rn-gray);font-size:.85rem;"><?php echo esc_html( get_the_date() ); ?></p>
							<?php the_excerpt(); ?>
							<a class="rn-card-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more →', 'rajdhani-nursery' ); ?></a>
						</article>
					<?php endif; ?>
				<?php endwhile; ?>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing found here. Try searching, or head back to the home page.', 'rajdhani-nursery' ); ?></p>
				<a class="rn-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to Home', 'rajdhani-nursery' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
