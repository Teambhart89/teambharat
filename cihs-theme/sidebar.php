<?php
/**
 * Blog sidebar with sensible fallbacks when no widgets are set.
 *
 * @package CIHS
 */
?>
<aside class="cihs-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'cihs' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Search', 'cihs' ); ?></h2>
			<?php get_search_form(); ?>
		</section>
		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Recent Publications', 'cihs' ); ?></h2>
			<ul>
				<?php
				$cihs_sidebar_pubs = get_posts(
					array(
						'post_type'      => 'cihs_publication',
						'posts_per_page' => 5,
					)
				);
				foreach ( $cihs_sidebar_pubs as $cihs_sidebar_pub ) {
					echo '<li><a href="' . esc_url( get_permalink( $cihs_sidebar_pub ) ) . '">' . esc_html( get_the_title( $cihs_sidebar_pub ) ) . '</a></li>';
				}
				?>
			</ul>
		</section>
		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Categories', 'cihs' ); ?></h2>
			<ul><?php wp_list_categories( array( 'title_li' => '' ) ); ?></ul>
		</section>
	<?php endif; ?>
</aside>
