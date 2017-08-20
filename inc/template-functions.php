<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package BS4_Skeleton
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 */
function bs4_body_classes( $classes ) {
	if ( in_array( 'fixed-top', bs4_get_site_navbar_class(), true ) ) {
		// Add class if fixed-top is used for theme top navbar.
		$classes[] = 'has-fixed-top';

		// Adminbar interferes with Bootstrap fixed top.
		// Adding this CSS class helps with styling around that to fix it.
		if ( is_admin_bar_showing() ) {
			$classes[] = 'adminbar-with-fixed-top';
		}
	}

	if ( is_page() ) {
		global $post;

		// Add class for page name.
		$classes[] = $post->post_name;
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'is-static-front-page';
	}

	if ( in_array( 'blog', $classes, true ) || in_array( 'archive', $classes, true ) ) {
		// Add class for every blog pages.
		$classes[] = 'is-loop';

		// Add class for loop layout name.
		if ( '' !== bs4_get_loop_layout() ) {
			$classes[] = 'is-' . sanitize_html_class( bs4_get_loop_layout() ) . '-loop';
		}
	}

	if ( ! is_singular() ) {
		// Add class of hfeed to non-singular pages.
		$classes[] = 'hfeed';
	}

	if ( is_customize_preview() ) {
		// Add class if we're viewing the Customizer for easier styling of options.
		$classes[] = 'bs4-customizer';
	}

	$hide_sidebar = apply_filters( 'bs4_hide_sidebar', get_theme_mod( 'hide_sidebar', false ) );

	if ( 'fluid-no-sidebar-page' !== bs4_get_page_template_slug() || 'no-sidebar-page' !== bs4_get_page_template_slug() || ! is_active_sidebar( 'secondary' ) || ! $hide_sidebar ) {
		// Add class if sidebar is used.
		$classes[] = 'has-sidebar';
	}

	if ( is_tag() ) {
		$default_tag_class = array_search( 'tag', $classes, true );

		// Remove 'tag' CSS class, it was causing conflict with Bootstrap.
		unset( $default_tag_class );

		// Add new class to represent tag page.
		$classes[] = 'is-tag';
	}

	return $classes;
}
add_filter( 'body_class', 'bs4_body_classes' );

/**
 * Add the theme loop_type and placement to post_class.
 *
 * @param array $classes An array of post classes.
 * @param array $class   An array of additional classes added to the post.
 * @param int   $post_id The post ID.
 */
function bs4_post_class_add_loop_type( $classes, $class = '', $post_id = '' ) {
	// Check if current post is in single view or is main loop.
	// Helpful for styling posts only in single view or main loop.
	if ( is_single( $post_id ) || is_page( $post_id ) || is_attachment( $post_id ) ) {
		$classes[] = 'single-entry';
	} else {
		$classes[] = 'loop-entry';

		if ( is_singular() ) {
			$classes[] = 'single-loop-entry';
		}

		$loop_type = (string) bs4_get_loop_layout();

		// Make sure loop layout exists and not WooCommerce product.
		if ( $loop_type && 'product' !== get_post_type( $post_id ) ) {
			// Adding a CSS class for the loop layout makes for easier styling.
			$classes[] = 'loop-' . sanitize_html_class( $loop_type ) . '-entry';

			if ( 'grid' === $loop_type ) {
				$per_row = (int) apply_filters( 'bs4_loop_per_row', get_theme_mod( 'loop_per_row', 3 ) );

				// Column responsive breakpoint.
				$breakpoint = get_theme_mod( 'post_column_breakpoint', 'md' );

				if ( '' !== $breakpoint || 'xs' !== $breakpoint ) {
					$column_breakpoint = '-' . $breakpoint;
				}

				$column_width = '-' . ( 12 / $per_row );

				// Add a Bootstrap column CSS class if grid loop layout.
				$classes[] = sanitize_html_class( 'col' . $column_breakpoint . $column_width );
			}
		}
	}

	return $classes;
}
add_filter( 'post_class', 'bs4_post_class_add_loop_type', 10, 3 );

/**
 * Change container width for 'Fluid' page templates.
 *
 * @param array $classes Container classes.
 */
function bs4_fluid_page_container_width( $classes ) {
	if ( 'fluid-page' === bs4_get_page_template_slug() || 'fluid-no-sidebar-page' === bs4_get_page_template_slug() ) {
		$classes = array( 'container-fluid' );
	}

	return $classes;
}
add_filter( 'bs4_get_site_container_class', 'bs4_fluid_page_container_width' );

/**
 * Filter get_the_archive_title for main loop so it doesn't include default text prefix.
 *
 * Also add to list of conditionals so blog page shows title (not homepage).
 *
 * @param string $title Archive title to be displayed.
 */
function bs4_get_the_archive_title( $title ) {
	if ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'bs4_get_the_archive_title' );

/**
 * Make video embeds in content responsive.
 *
 * @param mixed  $cache   The cached HTML result, stored in post meta.
 * @param string $url     The attempted embed URL.
 */
function bs4_responsive_embed_oembed_html( $cache, $url ) {
	if ( false !== strpos( $url, 'youtube' ) || false !== strpos( $url, 'vimeo' ) || false !== strpos( $url, 'videopress' ) ) {
		$cache = '<div class="embed-responsive embed-responsive-16by9">' . $cache . '</div>';
	}

	return $cache;
}
add_filter( 'embed_oembed_html', 'bs4_responsive_embed_oembed_html', 10, 2 );

/**
 * Make locked post password form Bootstrap friendly.
 *
 * @param string $form Password form HTML.
 */
function bs4_the_password_form( $form ) {
	if ( empty( get_the_ID() ) ) {
		$field_id = 'pwbox-' . rand();
	} else {
		$field_id = 'pwbox-' . get_the_ID();
	}

	$btn_class = join( ' ', bs4_get_btn_class( 'btn-secondary' ) );

	$form = esc_attr__( 'This content is password protected. To view it please enter your password below:', 'bs4' );

	$form .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form form-inline" method="post">'
		. '<div class="input-group">'
		. '<label for="' . $field_id . '" class="sr-only">' . esc_attr__( 'Password:', 'bs4' ) . '</label>'
		. '<input type="password" id="' . $field_id . '" class="form-control" name="post_password" placeholder="' . esc_attr__( 'Password', 'bs4' ) . '" />'
		. '<span class="input-group-btn"><input type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '" class="' . esc_attr( $btn_class ) . '" /></span>'
		. '</div>'
		. '</form>';

	return $form;
}
add_filter( 'the_password_form', 'bs4_the_password_form', 10 );

/**
 * Use Bootstrap component 'dropup' for dropdown menus.
 *
 * Otherwise dropdown will add height to page, causing scrollbar.
 *
 * @param array  $output The CSS classes for current menu item.
 * @param string $name   Key to default menu item argument.
 * @param object $args   An array of {@see wp_nav_menu()} arguments.
 * @param object $item   Menu item data object.
 */
function bs4_footer_nav_dropdown_to_dropup( $output, $name, $args, $item ) {
	// If current menu is footer menu.
	if ( 'footer' === $args->theme_location ) {
		// Check if nav item classes exist.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// If there's children items then add 'dropdown' class.
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$output['dropdown'] = 'dropdown dropup';
		}
	}

	return $output;
}
add_filter( 'bs4_nav_menu_classes', 'bs4_footer_nav_dropdown_to_dropup', 10, 4 );

/**
 * Add Bootstrap close icon class, remove nofollow, and add button role to cancel comment reply link.
 *
 * @param string $formatted_link The HTML-formatted cancel comment reply link.
 */
function bs4_cancel_comment_reply_link( $formatted_link ) {
	return str_replace( 'rel="nofollow"', 'class="close" role="button"', $formatted_link );
}
add_filter( 'cancel_comment_reply_link', 'bs4_cancel_comment_reply_link' );

/**
 * Add classes to comment_reply_link function.
 *
 * @link https://codex.wordpress.org/Function_Reference/comment_reply_link
 *
 * @param string $reply_link Comment reply link HTML output.
 */
function bs4_comment_reply_link_add_classes( $reply_link ) {
	return str_replace( "rel='nofollow' class='comment-reply-link", "class='comment-reply-link nav-link", $reply_link );
}
add_filter( 'comment_reply_link', 'bs4_comment_reply_link_add_classes' );

/**
 * Filter get_next_post_link to add classes to link.
 *
 * @param string $link HTML for next post link.
 */
function bs4_posts_link_next_class( $link ) {
	// Make next post link classes filterable.
	$link_class = apply_filters( 'bs4_posts_link_next_prev_classes', array( 'nav-link', 'nav-link-next' ) );

	return str_replace( 'href=', 'class="' . esc_attr( join( ' ', $link_class ) ) . '" href=', $link );
}
add_filter( 'next_post_link', 'bs4_posts_link_next_class' );

/**
 * Filter get_previous_post_link to add classes to link.
 *
 * @param string $link HTML for previous post link.
 */
function bs4_posts_link_prev_class( $link ) {
	// Make previous post link classes filterable.
	$link_class = apply_filters( 'bs4_posts_link_next_prev_classes', array( 'nav-link', 'nav-link-prev' ) );

	return str_replace( 'href=', 'class="' . esc_attr( join( ' ', $link_class ) ) . '" href=', $link );
}
add_filter( 'previous_post_link', 'bs4_posts_link_prev_class' );

/**
 * Filters the navigation markup template.
 *
 * @param string $template The default navigation template.
 * @param string $class    The class passed by the calling function.
 */
function bs4_navigation_markup_template( $template, $class ) {
	switch ( $class ) {
		case 'posts-pagination':
			$classes = apply_filters( 'bs4_loop_pagination', array( '%1$s', 'pagination' ) );
			$template = '<nav id="%1$s" aria-label="%2$s"><ul class="' . esc_attr( join( ' ', $classes ) ) . '">%3$s</ul></nav>';
			break;
		case 'posts-navigation':
			$classes = apply_filters( 'bs4_loop_nav', array( '%1$s', 'nav', 'justify-content-between' ) );
			$template = '<nav id="%1$s" class="' . esc_attr( join( ' ', $classes ) ) . '">%3$s</nav>';
			break;
		case 'post-navigation':
			$classes = apply_filters( 'bs4_single_nav', array( '%1$s', 'nav', 'justify-content-between' ) );
			$template = '<nav id="%1$s" class="' . esc_attr( join( ' ', $classes ) ) . '">%3$s</nav>';
			break;
		case 'comments-pagination':
			$classes = apply_filters( 'bs4_comment_pagination', array( '%1$s', 'pagination' ) );
			$template = '<nav id="%1$s" aria-label="%2$s"><ul class="' . esc_attr( join( ' ', $classes ) ) . '">%3$s</ul></nav>';
			break;
		case 'comment-navigation':
			$classes = apply_filters( 'bs4_comment_nav', array( '%1$s', 'nav', 'justify-content-between' ) );
			$template = '<nav id="%1$s" class="' . esc_attr( join( ' ', $classes ) ) . '">%3$s</nav>';
			break;
	}

	return $template;
}
add_filter( 'navigation_markup_template', 'bs4_navigation_markup_template', 10, 2 );

/**
 * Markup for paginating array of links.
 *
 * @param array $pages Pagination links.
 *
 * @return string
 */
function bs4_pre_navigation_markup( $pages ) {
	// Wrap each pagination link.
	$pagination_links = '';
	foreach ( $pages as $page ) {
		$pagination_links .= '<li class="page-item">' . $page . '</li>';
	}

	// Create an instance of DOMDocument.
	$dom = new \DOMDocument();
	$dom->loadHTML( mb_convert_encoding( $pagination_links, 'HTML-ENTITIES', 'UTF-8' ) );
	$xpath = new \DOMXpath( $dom );

	// Create an instance of DOMXpath and all elements with the class 'page-numbers'.
	$page_numbers = $xpath->query( "//*[contains(concat(' ', normalize-space(@class), ' '), ' page-numbers ')]" );

	// Iterate over the $page_numbers node.
	foreach ( $page_numbers as $item ) {
		// Convert string of classes to array.
		$classes = explode( ' ', $item->attributes->item( 0 )->value );

		// If current pagination item is for current page then add class.
		if ( in_array( 'current', $classes, true ) ) {
			$add_classes = $dom->createAttribute( 'class' );
			$add_classes->value = 'page-item active';
			$item->parentNode->appendChild( $add_classes );
		}

		// Replace link class for Bootstrap 4 pagination compatibility.
		$item->attributes->item( 0 )->value = str_replace( 'page-numbers', 'page-link', $item->attributes->item( 0 )->value );
	}

	$pagination = $dom->saveHTML();

	// Add accessbility text '(current)' to current page item.
	$output = str_replace( '</span></li>', ' <span class="sr-only">' . esc_html__( '(current)', 'bs4' ) . '</span></span></li>', $pagination );

	return apply_filters( 'bs4_paginate_links', $output, $pages );
}

/**
 * Filter wp_link_pages links to make compatible with Bootstrap 4 pagination.
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_link_pages_link/
 *
 * @param string $link Paginated links for current post.
 */
function bs4_wp_link_pages_link( $link ) {
	$is_active = '';
	$link_html = $link;

	// Make default arguments filterable.
	$args = apply_filters( 'bs4_wp_link_pages_link_args', array(
		'before'         => '',
		'after'          => '',
		'active_class'   => 'disabled',
		'link_class'     => 'page-link',
	) );

	// If link equals current page.
	if ( ctype_digit( $link ) ) {
		// Add space to active class.
		$is_active = ' ' . $args['active_class'];

		// Format link HTML output.
		$link_html = sprintf(
			'<span class="page-link">%s <span class="sr-only">%s</span></span>',
			$link,
			__( '(current page)', 'bs4' )
		);
	} else {
		$link_html = str_replace( '<a href="', '<a class="' . $args['link_class'] . '" href="', $link );
	}

	// Wrap link before returning.
	$output = '<li class="page-item' . $is_active . '">' . $link_html . '</li>';

	return $output;
}
add_filter( 'wp_link_pages_link',  'bs4_wp_link_pages_link' );

/**
 * Add CSS class to sidebar category selects to make Bootstrap-friendly.
 *
 * @param array $args Widget categories dropdown arguments.
 */
function bs4_widget_categories_dropdown_args( $args ) {
	// Make sure widget categories select field has "class" attribute.
	if ( array_key_exists( 'class', $args ) ) {
		$args['class'] .= ' form-control';
	} else {
		$args['class'] = 'form-control';
	}

	return $args;
}
add_filter( 'widget_categories_dropdown_args', 'bs4_widget_categories_dropdown_args' );

/**
 * Makes custom menu widgets compatible with Bootstrap 4.
 *
 * @link https://wordpress.stackexchange.com/a/53952/66224
 *
 * @param array $args An array of {@see wp_nav_menu()} arguments.
 */
function bs4_widget_custom_menu( $args ) {
	// Get WordPress menus that are registered.
	$menu_locations = array();
	foreach ( get_registered_nav_menus() as $menu_id => $menu_name ) {
		$menu_locations[] = $menu_id;
	}

	// Check if current menu is in a widget.
	if ( ! in_array( $args['theme_location'], $menu_locations, true ) ) {
		// Filterable widget custom menu classes.
		$menu_classes = apply_filters( 'bs4_widget_custom_menu_classes', array( 'nav', 'flex-column', 'nav-pills' ) );

		// New menu arguments.
		$new_menu_args = array(
			'menu_class' => esc_attr( join( ' ', $menu_classes ) ),
			'walker' => new BS4_Walker_Nav_Menu(),
		);

		// Overwrite custom menu widget with updated arguments.
		$args = array_merge( $args, $new_menu_args );
	}

	return $args;
}
add_filter( 'wp_nav_menu_args', 'bs4_widget_custom_menu' );

/**
 * Remove link from custom logo display.
 *
 * This makes it easy to work with Bootstrap navbar-brand.
 *
 * @param string $html Custom logo HTML.
 */
function bs4_get_custom_logo( $html ) {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	$custom_logo_attr = array(
		'class'    => 'custom-logo',
		'itemprop' => 'logo',
	);

	/*
	 * If the logo alt attribute is empty, get the site title and explicitly
	 * pass it to the attributes used by wp_get_attachment_image().
	 */
	$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
	if ( empty( $image_alt ) ) {
		$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
	}

	/*
     * If the alt attribute is not empty, there's no need to explicitly pass
     * it because wp_get_attachment_image() already adds the alt attribute.
     */
	$html = wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );

	return $html;
}
add_filter( 'get_custom_logo', 'bs4_get_custom_logo' );

/**
 * Filters the_terms links to make compatible with Bootstrap 4 badges.
 *
 * @param array  $term_list List of terms to display.
 * @param string $taxonomy  The taxonomy name.
 */
function bs4_the_terms_badge( $term_list, $taxonomy ) {
	$term_class = '';

	if ( 'category' === $taxonomy ) {
		$term_class = 'badge-' . get_theme_mod( "badge_color_{$taxonomy}", 'primary' );
	} elseif ( 'post_tag' === $taxonomy ) {
		$term_class = 'badge-' . get_theme_mod( "badge_color_{$taxonomy}", 'secondary' );
	}

	$classes = join( ' ', bs4_get_badge_class( array( $term_class, $taxonomy . '-badge' ) ) );

	$term_list = str_replace( ' rel="tag"', ' class="' . esc_attr( $classes ) . '" rel="tag"', $term_list );

	return $term_list;
}
add_filter( 'the_terms', 'bs4_the_terms_badge', 10, 2 );

/**
 * Filter the_content to make HTML elements compatible with Bootstrap.
 *
 * HTML elements changed: table, blockquote, img.
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content
 *
 * @param string $content Post content.
 */
function bs4_components_for_the_content_filter( $content ) {
	if ( '' === $content ) {
		return $content;
	}

	$content = mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );
	$document = new DOMDocument();
	libxml_use_internal_errors( true );
	$document->loadHTML( utf8_decode( $content ) );

	// Make 'img' elements Bootstrap 4 compatible.
	foreach ( $document->getElementsByTagName( 'img' ) as $img ) {
		if ( '' !== $img->getAttribute( 'class' ) ) {
			$img_classes = explode( ' ', $img->getAttribute( 'class' ) );
		} else {
			// Make sure array is always returned.
			$img_classes = array();
		}

		$img_classes[] = 'img-fluid';

		if ( in_array( 'alignright', $img_classes, true ) ) {
			$img_classes[] = 'float-right';
		} elseif ( in_array( 'alignleft', $img_classes, true ) ) {
			$img_classes[] = 'float-left';
		} elseif ( in_array( 'aligncenter', $img_classes, true ) ) {
			$img_classes[] = 'd-block';
			$img_classes[] = 'mx-auto';
		}

		$img_class = apply_filters( 'bs4_the_content_img_class', array_flip( array_flip( $img_classes ) ) );

		$img->setAttribute( 'class', esc_attr( join( ' ', $img_class ) ) );
	}

	// Make 'blockquote' elements Bootstrap 4 compatible.
	foreach ( $document->getElementsByTagName( 'blockquote' ) as $quote ) {
		if ( '' !== $quote->getAttribute( 'class' ) ) {
			$quote_classes = explode( ' ', $quote->getAttribute( 'class' ) );
		} else {
			// Make sure array is always returned.
			$quote_classes = array();
		}

		// If Twitter embed, skip.
		if ( in_array( 'twitter-tweet', $quote_classes, true ) ) {
			continue;
		}

		$quote_classes[] = 'blockquote';
		$quote_class = apply_filters( 'bs4_the_content_blockquote', array_flip( array_flip( $quote_classes ) ) );

		// Add classes to blockquote.
		$quote->setAttribute( 'class', esc_attr( join( ' ', $quote_class ) ) );
	}

	// Make 'table' elements Bootstrap 4 compatible.
	foreach ( $document->getElementsByTagName( 'table' ) as $table ) {
		if ( '' !== $table->getAttribute( 'class' ) ) {
			$table_classes = explode( ' ', $table->getAttribute( 'class' ) );
		} else {
			// Make sure array is always returned.
			$table_classes = array();
		}

		$table_classes[] = 'table';

		$table_class = apply_filters( 'bs4_the_content_table', array_flip( array_flip( $table_classes ) ) );

		// Add classes to table.
		$table->setAttribute( 'class', esc_attr( join( ' ', $table_class ) ) );
	}

	return $document->saveHTML();
}
add_filter( 'the_content', 'bs4_components_for_the_content_filter' );

/**
 * Filters the default caption shortcode output to make images Bootstrap-friendly.
 *
 * If the filtered output isn't empty, it will be used instead of generating
 * the default caption template.
 *
 * @see img_caption_shortcode()
 *
 * @param string $empty   The caption output. Default empty.
 * @param array  $attr    Attributes of the caption shortcode.
 * @param string $content The image element, possibly wrapped in a hyperlink.
 */
function bs4_img_caption_shortcode_classes( $empty, $attr, $content = null ) {
	$a = shortcode_atts( array(
		'id'	  => '',
		'align'	  => 'alignnone',
		'width'	  => '',
		'caption' => '',
		'class'   => '',
	), $attr, 'caption' );

	if ( (int) $a['width'] < 1 || empty( $a['caption'] ) ) {
		return $content;
	}

	if ( '' !== $a['class'] ) {
		$figure_classes = explode( ' ', $a['class'] );
	} else {
		$figure_classes = array();
	}

	$figure_classes[] = 'wp-caption';
	$figure_classes[] = 'figure';
	$figure_classes[] = 'img-fluid';
	$figure_classes[] = $a['align'];

	if ( '' !== $a['align'] && 'alignnone' !== $a['align'] ) {
		if ( 'aligncenter' === $a['align'] ) {
			$figure_classes[] = 'd-block';
			$figure_classes[] = 'mx-auto';
		} else {
			$align = str_replace( 'align', '', $a['align'] );
			$figure_classes[] = 'float-' . $align;
		}
	}

	// Filterable figure CSS classes. For unique values array_flip() is used.
	$figure_class = apply_filters( 'bs4_the_content_figure_class', array_flip( array_flip( $figure_classes ) ) );

	// Create an instance of DOMDocument.
	$dom = new \DOMDocument();
	$dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
	$xpath = new \DOMXpath( $dom );

	$imgs = $xpath->query( '//img' );

	if ( '' !== $imgs->item( 0 )->getAttribute( 'class' ) ) {
		$img_classes = explode( ' ', $imgs->item( 0 )->getAttribute( 'class' ) );
	} else {
		// Make sure array is always returned.
		$img_classes = array();
	}

	$img_classes[] = 'figure-img';
	$img_classes[] = 'img-fluid';

	// Filterable image CSS classes. For unique values array_flip() is used.
	$img_class = apply_filters( 'bs4_the_content_figure_img_class', array_flip( array_flip( $img_classes ) ) );

	$imgs->item( 0 )->setAttribute( 'class', esc_attr( join( ' ', $img_class ) ) );
	$content = $dom->saveHTML();

	$caption_width = apply_filters( 'img_caption_shortcode_width', intval( $a['width'] ), $a, $content );

	// Filterable figure caption CSS classes.
	$caption_class = apply_filters( 'bs4_the_content_figure_caption_class', array( 'figure-caption' ) );

	return sprintf(
		'<figure id="%1$s" %2$sclass="%3$s">%4$s<figcaption class="%5$s">%6$s</figcaption></figure>',
		sanitize_html_class( $a['id'] ),
		$caption_width ? 'style="width:' . intval( $caption_width ) . 'px" ' : '',
		esc_attr( join( ' ', $figure_class ) ),
		do_shortcode( $content ),
		esc_attr( join( ' ', $caption_class ) ),
		$a['caption']
	);
}
add_filter( 'img_caption_shortcode', 'bs4_img_caption_shortcode_classes', 10, 3 );

/**
 * Make gallery shortcode compatible with Bootstrap grid.
 *
 * @param string $output   The current output - the WordPress core passes an empty string.
 * @param array  $attr     The attributes from the gallery shortcode.
 * @param int    $instance Unique numeric ID of this gallery shortcode instance.
 */
function bs4_post_gallery( $output, $attr, $instance ) {
	global $post;

	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'figure',
		'icontag'    => 'div',
		'captiontag' => 'figcaption',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => '',
		'link'       => '',
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array(
			'include' => $atts['include'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby'],
		) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array(
			'post_parent' => $id,
			'exclude' => $atts['exclude'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby'],
		) );
	} else {
		$attachments = get_children( array(
			'post_parent' => $id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $atts['order'],
			'orderby' => $atts['orderby'],
		) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";

		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}

		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );

	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}

	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}

	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );

	// Column responsive breakpoint.
	$breakpoint = apply_filters( 'bs4_gallery_column_breakpoint', 'md' );

	if ( '' !== $breakpoint ) {
		$column_breakpoint = '-' . $breakpoint;
	}

	$column_width = '-' . ( 12 / $columns );

	// Gallery ID.
	$selector = "gallery-{$instance}";

	$size_class = sanitize_html_class( $atts['size'] );

	$output .= "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output .= '<div class="row">';
	$i = 0;

	foreach ( $attachments as $id => $attachment ) {
		$attr = array(
			'class' => 'gallery-item-img figure-img img-fluid',
		);

		if ( trim( $attachment->post_excerpt ) ) {
			$attr['aria-describedby'] = "$selector-$id";
		}

		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}

		$image_meta  = wp_get_attachment_metadata( $id );

		if ( 5 === $columns || 7 === $columns || 8 === $columns || 9 === $columns ) {
			// Empty if number of columns doesn't work with Bootstrap grid.
			$column_width = '';
		}

		$figure_class = 'gallery-item gallery-item-' . $i . ' col' . $column_breakpoint . $column_width;
		if ( 'figure' === $itemtag ) {
			$figure_class .= ' figure';
		}
		$output .= "<{$itemtag} class='{$figure_class}'>";
		$output .= $image_output;

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption figure-caption' id='$selector-$id'>
				" . wptexturize( $attachment->post_excerpt ) . "
				</{$captiontag}>";
		}

		$output .= "</{$itemtag}>";

		bs4_get_loop_rows_splitter( $i, $columns );

		$i++;
	}// End foreach().

	$output .= "</div><!-- .row -->\n"
		. "</div><!-- #gallery-## -->\n";

	return $output;
}
add_filter( 'post_gallery', 'bs4_post_gallery', 10, 3 );
