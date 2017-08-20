<?php
/**
 * The template for displaying pingbacks
 *
 * @package BS4_Skeleton
 */

?>

<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( array( 'pingback', 'card' ), $comment ); ?>>
	<div class="card-body">
		<span class="pingback-title"><?php esc_attr_e( 'Pingback:' ); ?></span>
		<span class="pingback-content"><?php comment_author_link( $comment ); ?></span>

		<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
			<a href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>" class="comment-edit-link nav-link small">
				<i class="fa fa-pencil-square-o"></i>
				<?php esc_attr_e( 'Edit', 'bs4' ); ?>
			</a>
		<?php endif; ?>
	</div><!-- .card-body -->
