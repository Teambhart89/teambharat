<?php
/**
 * Default page template.
 *
 * @package Avdesh_SEO
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero">
		<div class="container">
			<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span><?php the_title(); ?></span></nav>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<section class="section">
		<div class="container narrow prose">
			<?php
			if ( has_post_thumbnail() ) {
				echo '<div style="border-radius:var(--radius);overflow:hidden;margin-bottom:24px;">';
				the_post_thumbnail( 'large' );
				echo '</div>';
			}
			the_content();
			wp_link_pages();
			?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
