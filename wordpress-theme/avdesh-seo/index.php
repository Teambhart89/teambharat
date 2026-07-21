<?php
/**
 * Blog index / fallback template.
 *
 * @package Avdesh_SEO
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<span class="eyebrow">Insights</span>
		<h1><?php echo is_home() && ! is_front_page() ? esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) : esc_html__( 'SEO & AI Search Blog', 'avdesh-seo' ); ?></h1>
		<p class="lead">Practical SEO, GEO and Google Ads insights to help you grow organic traffic and stay visible in AI search.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-3">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'card reveal' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" style="display:block;border-radius:12px;overflow:hidden;margin-bottom:16px;"><?php the_post_thumbnail( 'medium_large' ); ?></a>
						<?php else : ?>
							<div class="img-ph" style="min-height:150px;margin-bottom:16px;"><span class="badge">📷 Featured image</span></div>
						<?php endif; ?>
						<span class="eyebrow" style="margin:0;"><?php echo esc_html( get_the_date() ); ?></span>
						<h3 style="margin:6px 0 8px;font-size:1.2rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p style="color:var(--muted);font-size:.93rem;"><?php echo esc_html( avdesh_trim( get_the_excerpt(), 22 ) ); ?></p>
						<a class="more" style="color:var(--orange-dark);font-weight:600;" href="<?php the_permalink(); ?>">Read more →</a>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<div style="margin-top:40px;text-align:center;"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php else : ?>
			<div class="narrow prose">
				<h2>No posts yet<span class="dot">.</span></h2>
				<p>Blog posts will appear here. This folder is ready for your SEO and AI search content, already optimized for long-tail keywords and internal linking to your service pages.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
