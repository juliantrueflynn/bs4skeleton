<?php
/**
 * Custom walker for WordPress menus
 *
 * @package BS4_Skeleton
 */

/**
 * Walker class to make wp_nav_menu() compatible with Bootstrap 4.
 */
class BS4_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Filterable additional menu items classes for Bootstrap 4 compatiability.
	 *
	 * @param string $name  Key to default menu item argument.
	 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
	 * @param object $item  Menu item data object.
	 */
	public function bs4_nav_class( $name, $args = array(), $item = null ) {
		// Make nav menu classes arguments filterable.
		$r = apply_filters( 'bs4_nav_menu_classes', array(
			'active'          => 'active',
			'nav-item'        => 'nav-item',
			'nav-link'        => 'nav-link',
			'dropdown'        => 'dropdown',
			'dropdown-menu'   => 'dropdown-menu',
			'dropdown-item'   => 'dropdown-item',
			'dropdown-toggle' => 'dropdown-toggle',
		), $name, $args, $item );

		return $r[ $name ];
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$class_name = $this->bs4_nav_class( 'dropdown-menu', $args );
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<div class=\"$class_name\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</div>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// Indent HTML output per item depth.
		$indent = $depth ? str_repeat( "\t", $depth ) : '';

		// Check if nav item classes exist.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Add 'menu-item-##' class.
		$classes[] = 'menu-item-' . $item->ID;

		// Add 'nav-item' class.
		$classes[] = $this->bs4_nav_class( 'nav-item', $args, $item );

		// If there's children items then add 'dropdown' class.
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$classes[] = $this->bs4_nav_class( 'dropdown', $args, $item );
		}

		// If active item (current page) then add 'active' class.
		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$classes[] = $this->bs4_nav_class( 'active', $args, $item );
		}

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		// Check if new classes exist before sanitizing and HTML output.
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		// Nav list item HTML output if parent.
		if ( 0 === $depth ) {
			$output .= $indent . '<li' . $id . $class_names . '>';
		}

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		// Add new class to nav list item links.
		if ( 0 === $depth ) {
			$atts['class'] = $this->bs4_nav_class( 'nav-link', $args, $item );
		}

		if ( 0 === $depth && in_array( 'menu-item-has-children', $classes, true ) ) {
			$atts['class'] .= ' ' . $this->bs4_nav_class( 'dropdown-toggle', $args, $item );
			$atts['data-toggle']  = 'dropdown';
		}

		if ( $depth > 0 ) {
			$atts['class'] = $this->bs4_nav_class( 'dropdown-item', $args, $item );
		}

		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$atts['class'] .= ' ' . $this->bs4_nav_class( 'active', $args, $item );
		}

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->has_children ) && 0 === $depth ) {
			$output .= "</li>\n";
		}
	}
}
