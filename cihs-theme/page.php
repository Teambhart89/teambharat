<?php
/**
 * Default page template with hero band and breadcrumbs.
 *
 * @package CIHS
 */

get_header();
?>

<section class="cihs-page-hero">
	<div class="cihs-container">
		<?php cihs_breadcrumbs(); ?>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<main id="primary" class="site-main cihs-content-area">
	<div class="cihs-container">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="entry-content">
					<?php
					the_content();

					// "Our Team" page: append the team grid automatically.
					if ( is_page( 'our-team' ) ) {
						cihs_team_grid();
					}

					// "Research" overview page: list focus-area child pages.
					if ( is_page( 'research' ) ) {
						cihs_child_page_grid();
					}

					wp_link_pages();
					?>
				</div>
			</article>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>
	</div>
</main>

<?php
get_footer();

/**
 * Grid of team members (cihs_team CPT), ordered by menu_order.
 */
function cihs_team_grid() {
	$team = new WP_Query(
		array(
			'post_type'      => 'cihs_team',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
	if ( ! $team->have_posts() ) {
		return;
	}
	echo '<div class="cihs-grid cihs-grid--4" style="margin-top:40px;">';
	while ( $team->have_posts() ) {
		$team->the_post();
		$role = get_post_meta( get_the_ID(), '_cihs_team_role', true );
		?>
		<div class="cihs-card cihs-team-card cihs-reveal">
			<div class="cihs-card__media <?php echo has_post_thumbnail() ? '' : 'cihs-card__media--initial'; ?>">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'medium' );
				} else {
					echo esc_html( mb_substr( get_the_title(), 0, 1 ) );
				}
				?>
			</div>
			<div class="cihs-card__body">
				<h3><?php the_title(); ?></h3>
				<?php if ( $role ) : ?>
					<div class="cihs-team-role"><?php echo esc_html( $role ); ?></div>
				<?php endif; ?>
				<p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) ); ?></p>
			</div>
		</div>
		<?php
	}
	echo '</div>';
	wp_reset_postdata();
}

/**
 * Grid of child pages (used on the Research overview page).
 */
function cihs_child_page_grid() {
	$children = get_pages(
		array(
			'parent'      => get_the_ID(),
			'sort_column' => 'menu_order,post_title',
		)
	);
	if ( ! $children ) {
		return;
	}
	echo '<div class="cihs-grid cihs-grid--3" style="margin-top:40px;">';
	foreach ( $children as $child ) {
		?>
		<div class="cihs-focus-tile cihs-reveal">
			<h3><a href="<?php echo esc_url( get_permalink( $child ) ); ?>"><?php echo esc_html( $child->post_title ); ?></a></h3>
			<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $child->post_content ), 24 ) ); ?></p>
			<a class="cihs-card__more" href="<?php echo esc_url( get_permalink( $child ) ); ?>"><?php esc_html_e( 'Explore →', 'cihs' ); ?></a>
		</div>
		<?php
	}
	echo '</div>';
}
