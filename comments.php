<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BS4_Skeleton
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
} ?>

<div id="comments" class="comments-area card">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title card-header">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) :
				printf(
					/* translators: 1: title. */
					esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'bs4' ),
					'<span class="text-muted">' . get_the_title() . '</span>'
				);
			else :
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'bs4' ) ),
					number_format_i18n( $comment_count ),
					'<span class="text-muted">' . get_the_title() . '</span>'
				);
			endif;
			?>
		</h3>

		<div class="card-body">
			<?php the_comments_navigation(); ?>

			<div class="commentlist">
				<?php wp_list_comments( array(
					'style'	     => 'div',
					'walker'	 => new BS4_Walker_Comments(),
					'short_ping' => true,
				) ); ?>
			</div><!-- .commentlist -->

			<?php the_comments_navigation(); ?>
		</div><!-- .card-body -->
	<?php endif; ?>

	<?php if ( ! comments_open() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<div class="card-body">
			<div <?php bs4_alert_class( 'comments-empty' ); ?>>
				<?php esc_attr_e( 'Comments are closed.', 'bs4' ); ?>
			</div><!-- .no-comments -->
		</div><!-- .card-body -->
	<?php endif; ?>

	<?php
	$commenter = wp_get_current_commenter();

	$comment_form = array(
		'class_form' => 'comment-form',
		'title_reply_before' => '<h3 class="comment-reply-title">',
		'title_reply_after' => '</h3>',
		'class_submit' => join( ' ', bs4_get_btn_class() ),
		'submit_field' => '<div class="form-submit comment-submit text-right">%1$s %2$s</div>',
		'cancel_reply_link' => '<span aria-hidden="true">&times;</span>',
		'cancel_reply_before' => '',
		'cancel_reply_after' => '',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => sprintf(
			'<div class="comment-form-comment form-group">%s%s</div>',
			bs4_form_label( esc_attr__( 'Comment', 'bs4' ), 'comment' ),
			bs4_form_textarea( 'comment', '', array(
				'placeholder' => __( 'Your comment', 'bs4' ),
				'required' => true,
			) )
		),
		'fields' => array(
			'author' => sprintf(
				'<div class="comment-form-author form-group row">%s<div class="col-sm-10">%s</div></div>',
				bs4_form_label( esc_attr__( 'Name', 'bs4' ), 'author', array(
					'class' => 'col-sm-2 col-form-label',
				) ),
				bs4_form_input( 'author', $commenter['comment_author'], array(
					'placeholder' => esc_attr__( 'Your name', 'bs4' ),
					'required' => true,
				) )
			),
			'email' => sprintf(
				'<div class="comment-form-email form-group row">%s<div class="col-sm-10">%s</div></div>',
				bs4_form_label( esc_attr__( 'Email', 'bs4' ), 'email', array(
					'class' => 'col-sm-2 col-form-label',
				) ),
				bs4_form_input( 'email', $commenter['comment_author_email'], array(
					'placeholder' => esc_attr__( 'Your email', 'bs4' ),
					'required' => true,
				) )
			),
			'url' => sprintf(
				'<div class="comment-form-url form-group row">%s<div class="col-sm-10">%s</div></div>',
				bs4_form_label( esc_attr__( 'Website', 'bs4' ), 'url', array(
					'class' => 'col-sm-2 col-form-label',
				) ),
				bs4_form_input( 'url', $commenter['comment_author_url'], array(
					'placeholder' => esc_attr__( 'Your website', 'bs4' ),
					'required' => true,
				) )
			),
		),
	);
	?>

	<div class="card-body">
		<?php comment_form( apply_filters( 'bs4_comment_form', $comment_form ) ); ?>
	</div><!-- .card-body -->
</div><!-- #comments -->
