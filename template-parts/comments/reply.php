<?php
/**
 * The template for displaying replies list (underneath blog comments)
 *
 * @package BS4_Skeleton
 */

?>

<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( array( $parent_class, 'reply-entry' ) ); ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<div class="media">
			<?php echo get_avatar( $comment, $args['avatar_size'], '', esc_attr( get_comment_author( $comment->comment_parent ) . ' avatar' ), array(
				'class' => 'comment-avatar d-flex avatar photo',
			) ); ?>

			<div class="media-body">
				<header class="comment-header">
					<h6 class="comment-title">
						<?php comment_author_link(); ?>

						<?php if ( bs4_comment_by_author( $comment->user_id ) ) : ?>
							<small class="comment-by-author-text text-primary font-italic"><?php echo esc_attr_e( '(Author)', 'bs4' ); ?></small>
						<?php endif; ?>

						<?php if ( $comment->comment_parent ) : ?>
							<small class="reply-to-text"><i class="fa fa-angle-right"></i> <span><?php echo esc_attr( get_comment_author( $comment->comment_parent ) ); ?></span></small>
						<?php endif; ?>
					</h6>
				</header><!-- .comment-header -->

				<?php if ( 0 === $comment->comment_approved ) : ?>
					<div <?php bs4_get_alert_class( 'comment-awaiting-moderation alert-success' ); ?>>
						<?php esc_attr_e( 'Your comment is awaiting moderation', 'bs4' ); ?>
					</div>
				<?php endif; ?>

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
			</div><!-- .media-body -->
		</div><!-- .media -->

		<footer class="comment-meta">
			<div class="nav flex-column flex-sm-row">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>" class="comment-time-link nav-link">
					<i class="fa fa-clock-o"></i>
					<?php printf( // WPCS: XSS OK.
						/* translators: 1: Comment unix time, 2: Comment date, 3: Comment time */
						__( '<time class="comment-date" datetime="%1$s">%2$s at %3$s</time>', 'bs4' ),
						get_comment_time( 'c' ),
						get_comment_date(),
						get_comment_time()
					); ?>
				</a>

				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__( 'Reply', 'bs4' ),
					'depth' => $depth,
					'max_depth' => intval( $args['max_depth'] ),
				) ) ); ?>

				<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
					<a href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>" class="comment-edit-link nav-link">
						<i class="fa fa-pencil-square-o"></i>
						<?php esc_attr_e( 'Edit', 'bs4' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</footer><!-- .comment-meta -->
	</article><!-- .comment-body -->
