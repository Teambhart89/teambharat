<?php
/**
 * Comments template.
 *
 * @package Avdesh_SEO
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area" style="margin-top:40px;">
	<?php if ( have_comments() ) : ?>
		<h3><?php echo esc_html( get_comments_number() ); ?> <?php esc_html_e( 'Comments', 'avdesh-seo' ); ?></h3>
		<ol class="comment-list" style="list-style:none;padding:0;">
			<?php
			wp_list_comments( array( 'style' => 'ol', 'avatar_size' => 44 ) );
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'btn btn-primary',
			'title_reply'  => __( 'Leave a comment', 'avdesh-seo' ),
		)
	);
	?>
</div>
