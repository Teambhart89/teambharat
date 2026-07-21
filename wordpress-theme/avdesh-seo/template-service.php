<?php
/**
 * Template Name: Service Page
 *
 * Renders a full service page (H1 to H4 + FAQ) from the services data library,
 * matched to the current page slug. Assign this template to any of the service
 * pages (they are created automatically on theme activation).
 *
 * @package Avdesh_SEO
 */

get_header();

$slug = get_queried_object()->post_name;

if ( avdesh_get_service( $slug ) ) {
	avdesh_render_service( $slug );
} else {
	// Fallback to normal page content if slug has no service data.
	while ( have_posts() ) :
		the_post();
		?>
		<section class="page-hero"><div class="container"><h1><?php the_title(); ?></h1></div></section>
		<section class="section"><div class="container narrow prose"><?php the_content(); ?></div></section>
		<?php
	endwhile;
}

get_footer();
