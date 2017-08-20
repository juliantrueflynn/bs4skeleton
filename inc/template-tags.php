<?php
/**
 * Custom template tags for this theme.
 *
 * @package BS4_Skeleton
 */

/*
 * Form helpers
 */
require get_parent_theme_file_path( '/inc/template-form-tags.php' );

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param string $template_name Template file path.
 * @param array  $args          Arguments to pass through to template.
 */
function bs4_get_template_part( $template_name, $args = array() ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	$located = locate_template( $template_name . '.php' );

	if ( ! file_exists( $located ) ) {
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$located = apply_filters( 'bs4_get_template', $located, $template_name, $args );

	do_action( 'bs4_before_template_part', $template_name, $located, $args );

	include( $located );

	do_action( 'bs4_after_template_part', $template_name, $located, $args );
}

/**
 * Like bs4_get_template_part, but returns the HTML instead of outputting.
 *
 * @param string $template_name Template file path.
 * @param array  $args          Arguments to pass through to template.
 */
function bs4_get_template_part_html( $template_name, $args = array() ) {
	ob_start();
	bs4_get_template_part( $template_name, $args );
	return ob_get_clean();
}

/**
 * Display the loop layout name.
 */
function bs4_loop_layout() {
	echo sanitize_html_class( bs4_get_loop_layout() );
}

/**
 * Return the loop layout name. Filterable and can also be set from Theme Customizer.
 */
function bs4_get_loop_layout() {
	return apply_filters( 'bs4_loop_layout', get_theme_mod( 'loop_layout', 'full' ) );
}

if ( ! function_exists( 'bs4_entry_time' ) ) {
	/**
	 * Display nicely formatted string for the published date.
	 */
	function bs4_entry_time() {
		echo bs4_get_entry_time(); // WPCS: XSS OK.
	}
}

if ( ! function_exists( 'bs4_get_entry_time' ) ) {
	/**
	 * Return nicely formatted string for the published date.
	 */
	function bs4_get_entry_time() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		return sprintf(
			$time_string,
			get_the_date( DATE_W3C ),
			get_the_date(),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);
	}
}

if ( ! function_exists( 'bs4_navbar_search' ) ) {
	/**
	 * Display conditional template for navbar search.
	 */
	function bs4_navbar_search() {
		$hide_search = apply_filters( 'bs4_hide_top_nav_search', get_theme_mod( 'hide_top_nav_search', false ) );

		// Display navbar search template if not hidden.
		if ( ! $hide_search ) {
			get_template_part( 'template-parts/nav/nav', 'search' );
		}
	}
}

/**
 * Display text and or icon if blog comment is done by blog post author.
 *
 * @param int $comment_user_id Single comment ID.
 *
 * @return bool
 */
function bs4_comment_by_author( $comment_user_id ) {
	global $post;
	$retval = false;

	if ( $comment_user_id > 0 ) {
		if ( $comment_user_id === $post->post_author ) {
			$retval = true;
		}
	}

	return apply_filters( 'bs4_comment_by_author', $retval, $comment_user_id );
}

if ( ! function_exists( 'bs4_the_comments_pagination' ) ) {
	/**
	 * Template/display for comments and pingbacks. A callback for wp_list_comments().
	 *
	 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments
	 *
	 * @param string $args Default arguments.
	 */
	function bs4_the_comments_pagination( $args = array() ) {
		echo bs4_get_the_comments_pagination( (array) $args ); // WPCS: XSS OK.
	}
}

if ( ! function_exists( 'bs4_get_the_comments_pagination' ) ) {
	/**
	 * Return Bootstrap friendly comments pagination.
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_the_comments_pagination/
	 *
	 * @param string $args Default arguments.
	 */
	function bs4_get_the_comments_pagination( $args = array() ) {
		global $wp_rewrite;

		if ( ! is_singular() ) {
			return;
		}

		$output = '';
		$pagination = '';

		$page = ! get_query_var( 'cpage' ) ? 1 : get_query_var( 'cpage' );

		$max_page = get_comment_pages_count();

		$defaults = array(
			'base'               => add_query_arg( 'cpage', '%#%' ),
			'format'             => '',
			'type'               => 'array',
			'total'              => $max_page,
			'current'            => $page,
			'prev_text'          => esc_attr__( 'Previous', 'bs4' ),
			'next_text'          => esc_attr__( 'Next', 'bs4' ),
			'before_page_number' => '<span class="sr-only">' . esc_html__( 'Comment page', 'bs4' ) . '</span> ',
			'screen_reader_text' => esc_attr__( 'Comments pagination' ),
			'add_fragment'       => '#comments',
		);

		if ( $wp_rewrite->using_permalinks() ) {
			$defaults['base'] = user_trailingslashit( trailingslashit( get_permalink() ) . $wp_rewrite->comments_pagination_base . '-%#%', 'commentpaged' );
		}

		$r = wp_parse_args( $args, $defaults );

		$r['type'] = 'array';
		$r['echo'] = false;

		$pages = paginate_links( $r );

		if ( is_array( $pages ) ) {
			$pagination = bs4_pre_navigation_markup( $pages );
		}

		if ( $pagination ) {
			$output = _navigation_markup( $pagination, 'comments-pagination', $r['screen_reader_text'] );
		}

		return $output;
	}
}// End if().

if ( ! function_exists( 'bs4_loop_grid_rows_splitter' ) ) {
	/**
	 * Split Bootstrap 'row' and start a new 'row' wrap in "Grid" loop layout.
	 *
	 * Posts per row are based on 'loop_per_row' in Customizer.
	 *
	 * @param int  $count Number for current post in loop.
	 * @param bool $echo  Optional. True echo, false return. Default true.
	 */
	function bs4_loop_grid_rows_splitter( $count = 0, $echo = true ) {
		// Get theme posts per row count.
		$per_row = (int) apply_filters( 'bs4_loop_per_row', get_theme_mod( 'loop_per_row', 3 ) );

		if ( $echo ) {
			echo bs4_get_loop_rows_splitter( $count, $per_row ); // WPCS: XSS OK.
		} else {
			return bs4_get_loop_rows_splitter( $count, $per_row );
		}
	}
}

if ( ! function_exists( 'bs4_loop_rows_splitter' ) ) {
	/**
	 * Display split Bootstrap 'row' and start a new 'row' based on columns per row and current index entry.
	 *
	 * Makes for easier development with loops that need to be in Bootstrap grid.
	 *
	 * @param int $count   Number for current post in loop.
	 * @param int $per_row Number of posts per row.
	 */
	function bs4_loop_rows_splitter( $count = 0, $per_row ) {
		echo bs4_get_loop_rows_splitter( (int) $count, (int) $per_row ); // WPCS: XSS OK.
	}
}

/**
 * Return split Bootstrap 'row' and start a new 'row' based on columns per row and current index entry.
 *
 * Makes for easier development with loops that need to be in Bootstrap grid.
 *
 * @param int $count   Number for current post in loop.
 * @param int $per_row Number of posts per row.
 */
function bs4_get_loop_rows_splitter( $count = 0, $per_row ) {
	$output = '';

	if ( 0 < $count && is_integer( $count ) ) {
		// If post is not last in row, then open new row.
		if ( $count % $per_row === $per_row - 1 ) {
			$output = '</div><!-- .row -->' . "\n";
			$output .= '<div class="row">';
		}
	}

	return apply_filters( 'bs4_rows_splitter', $output, $count );
}

if ( ! function_exists( 'bs4_the_posts_pagination' ) ) {
	/**
	 * Display Bootstrap 4 compatible WordPress posts pagination.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/paginate_links
	 *
	 * @param array $args Posts pagination arguments.
	 */
	function bs4_the_posts_pagination( $args = array() ) {
		echo bs4_get_the_posts_pagination( (array) $args ); // WPCS: XSS OK.
	}
}

/**
 * Return Bootstrap 4 compatible WordPress posts pagination.
 *
 * @link https://codex.wordpress.org/Function_Reference/paginate_links
 *
 * @param array $args Posts pagination arguments.
 */
function bs4_get_the_posts_pagination( $args = array() ) {
	// Make posts pagination arguments filterable.
	$defaults = apply_filters( 'bs4_the_posts_pagination_args', array(
		'prev_text' => __( 'Previous', 'bs4' ),
		'next_text' => __( 'Next', 'bs4' ),
		'before_page_number' => '<span class="sr-only">' . esc_html__( 'Page', 'bs4' ) . '</span> ',
		'screen_reader_text' => __( 'Posts navigation', 'bs4' ),
	) );

	// Parse pagination default arguments.
	$r = wp_parse_args( $args, $defaults );

	$r['type'] = 'array';
	$r['echo'] = false;

	$output = '';
	$links = '';

	$pages = paginate_links( $r );

	if ( is_array( $pages ) ) {
		$links = bs4_pre_navigation_markup( $pages );
	}

	if ( $links ) {
		$output = _navigation_markup( $links, 'posts-pagination', esc_html( $r['screen_reader_text'] ) );
	}

	return $output;
}

/**
 * Exactly like WordPress get_page_template_slug, but removes '.php'.
 *
 * @link https://developer.wordpress.org/reference/functions/get_page_template_slug/
 *
 * @param int $post_id Post ID.
 *
 * @return string
 */
function bs4_get_page_template_slug( $post_id = null ) {
	// If post/page doesn't exist then return false.
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	// The page template file path.
	$template = get_post_meta( $post_id, '_wp_page_template', true );

	// If there's no template then return empty.
	if ( ! $template || 'default' === $template ) {
		return '';
	}

	// Remove '.php' from string.
	$template = str_replace( '.php', '', $template );

	return $template;
}

if ( ! function_exists( 'bs4_copyright_text' ) ) {
	/**
	 * Display the site copyright text.
	 */
	function bs4_copyright_text() {
		$default = esc_attr__( 'Copyright %title% %year%', 'bs4' );
		$copyright_text = apply_filters( 'bs4_footer_copyright_text', get_theme_mod( 'footer_copyright_text', $default ) );

		$output = '';

		if ( $copyright_text ) {
			$linked_title = sprintf(
				'<a href="%s">%s</a>',
				esc_url( home_url() ),
				esc_attr( get_bloginfo( 'name' ) )
			);

			// Replace %year% with the year.
			$output = str_replace( '%year%', date( 'Y' ), $copyright_text );
			$output = str_replace( '%title%', $linked_title, $output );
		}

		echo $output; // WPCS: XSS OK.
	}
}
