<?php
/**
 * Custom walker for blog comments and replies
 *
 * @package BS4_Skeleton
 */

/**
 * Walker class to make wp_list_comments() compatible with Bootstrap 4.
 */
class BS4_Walker_Comments extends Walker_Comment {
	/**
	 * Starts the element output.
	 *
	 * This opens the comment.  Will check if the comment has children or is a stand-alone comment.
	 *
	 * @access public
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 *
	 * @global int        $comment_depth
	 * @global WP_Comment $comment
	 *
	 * @param string     $output  Passed by reference. Used to append additional content.
	 * @param WP_Comment $comment Comment data object.
	 * @param int        $depth   Depth of comment in reference to parents.
	 * @param array      $args    An array of arguments.
	 * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
	 */
	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth; // WPCS: override ok.
		$GLOBALS['comment'] = $comment; // WPCS: override ok.

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			if ( ! empty( $args['has_children'] ) ) {
				$this->start_parent_html5_comment( $comment, $depth, $args );
			} else {
				$this->html5_comment( $comment, $depth, $args, false );
			}
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @access public
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		// Check if 'end-callback' argument exists.
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		// If top level comment, else is a child comment.
		if ( ! empty( $args['has_children'] ) && 'html5' === $args['format'] ) {
			ob_start();
			$this->end_parent_html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			if ( 'div' === $args['style'] ) {
				$output .= '</div><!-- #comment-## -->';
			} else {
				$output .= '</li><!-- #comment-## -->';
			}
		}
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @access public
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; // WPCS: override ok.
	}

	/**
	 * Output the beginning of a parent comment in the HTML5 format.
	 *
	 * Bootstrap media element requires child comments to be nested within the parent media-body.
	 * The original comment walker writes the entire comment at once, this method writes the opening
	 * of a parent comment so children comments can be nested within.
	 *
	 * @access protected
	 *
	 * @see http://getbootstrap.com/components/#media
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function start_parent_html5_comment( $comment, $depth, $args ) {
		$this->html5_comment( $comment, $depth, $args, true );
	}

	/**
	 * Output the end of a parent comment in the HTML5 format.
	 *
	 * Bootstrap media element requires child comments to be nested within the parent media-body.
	 * The original comment walker writes the entire comment at once, this method writes the end
	 * of a parent comment so child comments can be nested within.
	 *
	 * @access protected
	 *
	 * @see wp_list_comments()
	 * @see http://getbootstrap.com/components/#media
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function end_parent_html5_comment( $comment, $depth, $args ) {
		if ( 1 === $depth ) {
			get_template_part( 'template-parts/comments/comment', 'replies-close' );
		} else {
			echo '</div><!-- .children -->';
		}

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		echo '</' . esc_attr( $tag ) . '>';
	}

	/**
	 * Outputs a pingback comment.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		// Pingbacks and trackbacks template.
		bs4_get_template_part( 'template-parts/comments/pingback', array(
			'comment'      => $comment,
			'tag'          => ( 'div' === $args['style'] ) ? 'div' : 'li',
		) );
	}

	/**
	 * Output a comment in the HTML5 format
	 *
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment   Comment to display.
	 * @param int    $depth     Depth of comment.
	 * @param array  $args      An array of arguments.
	 * @param bool   $is_parent Flag indicating whether or not this is a parent comment.
	 */
	protected function html5_comment( $comment, $depth, $args, $is_parent = false ) {
		$comment_data = array(
			'comment'      => $comment,
			'parent_class' => $is_parent ? 'parent' : '',
			'args'         => $args,
			'depth'        => $depth,
			'tag'          => ( 'div' === $args['style'] ) ? 'div' : 'li',
		);

		// If top level comment.
		if ( 1 === $depth ) {
			// Comments template.
			bs4_get_template_part( 'template-parts/comments/comment', $comment_data );

			if ( $is_parent ) {
				get_template_part( 'template-parts/comments/comment', 'replies-open' );
			}
		} else {
			// Replies template.
			bs4_get_template_part( 'template-parts/comments/reply', $comment_data );

			if ( $is_parent ) {
				echo '<div class="children">';
			}
		}
	}
}
