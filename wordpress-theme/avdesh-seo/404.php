<?php
/**
 * 404 template.
 *
 * @package Avdesh_SEO
 */

get_header();
?>
<section class="section" style="text-align:center;">
	<div class="container narrow">
		<span class="hello" style="font-family:var(--script);font-size:3rem;color:var(--orange);">Oops 👋</span>
		<h1 style="margin:10px 0;">Page not found</h1>
		<p class="lead">The page you're looking for doesn't exist or has moved. Let's get you back on track.</p>
		<div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:24px;">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/seo-services/' ) ); ?>">View services</a>
		</div>
	</div>
</section>
<?php get_footer(); ?>
