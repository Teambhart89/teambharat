<?php
/**
 * Single blog post.
 *
 * @package Avdesh_SEO
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero">
		<div class="container">
			<nav class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a><span class="sep">/</span><span><?php the_title(); ?></span></nav>
			<span class="eyebrow"><?php echo esc_html( get_the_date() ); ?></span>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<section class="section">
		<div class="container narrow prose">
			<?php
			if ( has_post_thumbnail() ) {
				echo '<div style="border-radius:var(--radius);overflow:hidden;margin-bottom:26px;">';
				the_post_thumbnail( 'large' );
				echo '</div>';
			}
			the_content();
			wp_link_pages();
			?>
			<div class="callout" style="margin-top:34px;">Need help applying this to your own site? <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color:var(--orange-dark);font-weight:600;">Get a free consultation →</a></div>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
