<?php
/**
 * Single post template.
 *
 * @package epoojabooking
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="epb-page-hero">
		<div class="epb-container">
			<?php epb_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<p class="epb-post-meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</p>
		</div>
		<div class="epb-arch-divider" aria-hidden="true"></div>
	</section>

	<section class="epb-section">
		<div class="epb-container epb-narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="epb-post-thumb">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php endif; ?>
			<div class="epb-prose">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
