<?php
/**
 * Comments.
 *
 * @package PlantGift_Pro
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="pg-comments pg-mt-2" style="margin-top:3rem;">
	<?php if ( have_comments() ) : ?>
		<h2 style="font-size:var(--pg-step-2);">
			<?php
			$pg_count = get_comments_number();
			/* translators: %s: comment count. */
			printf( esc_html( _n( '%s comment', '%s comments', $pg_count, 'plantgift-pro' ) ), esc_html( number_format_i18n( $pg_count ) ) );
			?>
		</h2>

		<ol class="comment-list" style="list-style:none;padding:0;">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'avatar_size' => 56,
					'short_ping'  => true,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination( array( 'class' => 'pg-pagination' ) ); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit'       => 'pg-btn',
			'title_reply_before' => '<h2 style="font-size:var(--pg-step-2);">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>
</section>
