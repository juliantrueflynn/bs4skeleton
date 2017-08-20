<?php
/**
 * Custom walker for child pages list
 *
 * @package BS4_Skeleton
 */

/**
 * Walker class for wp_list_pages to make compatible with Bootstrap 4.
 */
class BS4_Walker_Page extends Walker_Page {
	/**
	 * Outputs the beginning of the current level in the tree before elements are output.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
	 * @param array  $args   Optional. Arguments for outputting the next level.
	 *                       Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class='dropdown-menu' role='menu'>\n";
	}

	/**
	 * Outputs the beginning of the current element in the tree.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string  $output       Used to append additional content. Passed by reference.
	 * @param WP_Post $page         Page data object.
	 * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
	 * @param array   $args         Optional. Array of arguments. Default empty array.
	 * @param int     $current_page Optional. Page ID. Default 0.
	 */
	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth ) {
			$indent = str_repeat( "\t", $depth );
		} else {
			$indent = '';
		}

		$css_class = array( 'page_item', 'page-item-' . $page->ID );

		if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
			$css_class[] = 'page_item_has_children';
		}

		if ( ! empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( in_array( $page->ID, $_current_page->ancestors, true ) ) {
				$css_class[] = 'current_page_ancestor';
			}
			if ( $page->ID === $current_page ) {
				$css_class[] = 'current_page_item';
				$css_class[] = 'active';
			} elseif ( $_current_page && $page->ID === $_current_page->post_parent ) {
				$css_class[] = 'current_page_parent';
			}
		} elseif ( get_option( 'page_for_posts' ) === $page->ID ) {
			$css_class[] = 'current_page_parent';
		}

		$css_class[] = 'list-group-item';
		$css_class[] = 'list-group-item-action';

		$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		if ( '' === $page->post_title ) {
			$page->post_title = sprintf(
				/* translators: %d: page ID. */
				__( '#%d (no title)' ),
				$page->ID
			);
		}

		$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
		$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

		/** This filter is documented in wp-includes/post-template.php */
		if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
			$output .= $indent . sprintf(
				'<a class="%s" href="%s">%s%s%s</a>',
				$css_classes,
				get_permalink( $page->ID ),
				$args['link_before'],
				apply_filters( 'the_title', $page->post_title, $page->ID ),
				$args['link_after']
			);
		} else {
			$output .= $indent . sprintf(
				'<a class="%s" href="%s">%s%s%s</a>',
				$css_classes,
				get_permalink( $page->ID ),
				$args['link_before'],
				apply_filters( 'the_title', $page->post_title, $page->ID ),
				$args['link_after']
			);
		}

		if ( ! empty( $args['show_date'] ) ) {
			if ( 'modified' === $args['show_date'] ) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
			$output .= ' ' . mysql2date( $date_format, $time );
		}
	}
}
