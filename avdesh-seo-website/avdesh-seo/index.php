<?php
/**
 * Main index / blog fallback template.
 *
 * @package Avdesh_SEO
 */
get_header(); ?>

<section class="page-hero">
	<div class="container">
		<?php avseo_breadcrumbs(); ?>
		<h1><?php echo is_home() && ! is_front_page() ? esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) : 'Insights'; ?></h1>
		<p class="lead">SEO, AI search and digital marketing insights, tips and practical guides.</p>
	</div>
</section>

<section class="bg-cream">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid-3">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="quote-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" style="display:block;margin:-28px -28px 18px;border-radius:18px 18px 0 0;overflow:hidden;">
								<?php the_post_thumbnail( 'medium_large', array( 'style' => 'width:100%;height:auto;' ) ); ?>
							</a>
						<?php endif; ?>
						<h3 style="text-transform:none;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p style="color:#6b6b76;"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<a class="card-link" href="<?php the_permalink(); ?>">Read more &rarr;</a>
					</article>
				<?php endwhile; ?>
			</div>
			<div style="margin-top:40px;"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p>No posts yet. Once you publish articles they will appear here.</p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
