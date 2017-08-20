<?php
/**
 * Helper functions for displaying Bootstrap components in template
 *
 * @package BS4_Skeleton
 */

/**
 * Display site container CSS classes. Similar to post_class.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_site_container_class( $class = '' ) {
	echo 'class="' . esc_attr( join( ' ', bs4_get_site_container_class( $class ) ) ) . '"';
}

/**
 * Return site container filterable CSS classes. Similar to get_post_class.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_get_site_container_class( $class = '' ) {
	$classes = array();

	$container_width = get_theme_mod( 'bs4_site_container_width', 'container' );

	if ( 'none' !== $container_width ) {
		$defaults[] = sanitize_html_class( $container_width );
	}

	$defaults[] = 'site-container';

	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( 'bs4_site_container_class', $classes, $defaults );
}

/**
 * Display navbar CSS classes. Similar to post_class.
 *
 * @param string|array $class Optional. Navbar additional classes.
 */
function bs4_site_navbar_class( $class = '' ) {
	echo 'class="' . esc_attr( join( ' ', bs4_get_site_navbar_class( $class ) ) ) . '"';
}

/**
 * Return navbar filterable CSS classes. Similar to get_post_class.
 *
 * @param string|array $class Optional. Navbar additional classes.
 */
function bs4_get_site_navbar_class( $class = '' ) {
	$defaults = array();

	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	$defaults = array();
	$defaults[] = 'site-navbar';
	$defaults[] = 'navbar';

	$position = get_theme_mod( 'top_navbar_position', 'fixed-top' );
	$color_scheme = get_theme_mod( 'top_navbar_color_scheme', 'dark' );

	if ( 'none' !== $position ) {
		$defaults[] = $position;
	}

	if ( 'none' !== $color_scheme ) {
		$defaults[] = 'navbar-' . $color_scheme;
	}

	if ( ! bs4_component_has_color_class( $class ) ) {
		$defaults[] = 'bg-' . get_theme_mod( 'top_navbar_bg_color', 'primary' );
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( 'bs4_site_navbar_class', $classes );
}

/**
 * Display main filterable CSS classes.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_site_primary_column_class( $class = '' ) {
	// Primary column width.
	$width = get_theme_mod( 'primary_column_width', 8 );

	echo 'class="' . esc_attr( join( ' ', bs4_get_site_column_class( $class, $width, 'primary' ) ) ) . '"';
}

/**
 * Display sidebar filterable CSS classes.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_site_secondary_column_class( $class = '' ) {
	// Secondary column width.
	$width = get_theme_mod( 'secondary_column_width', 4 );

	echo 'class="' . esc_attr( join( ' ', bs4_get_site_column_class( $class, $width, 'secondary' ) ) ) . '"';
}

/**
 * Return site column filterable CSS classes. For main content area and sidebar columns.
 *
 * @param string|array $class   Optional. Column additional classes.
 * @param int          $width   Width of column. Default none.
 * @param string       $context Location of column.
 */
function bs4_get_site_column_class( $class = '', $width = 'none', $context ) {
	// Column responsive breakpoint.
	$breakpoint = get_theme_mod( 'site_columns_breakpoint', 'md' );

	$column_breakpoint = '-' . $breakpoint;

	if ( 'xs' === $breakpoint || '' === $breakpoint ) {
		$column_breakpoint = '';
	}

	$column_width = '-' . (int) $width;

	if ( 'none' === $width ) {
		$column_width = '';
	}

	$defaults = array();
	$defaults[] = 'col' . $column_breakpoint . $column_width;

	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( "bs4_site_{$context}_column_class", $classes );
}

/**
 * Display button filterable CSS classes. Similar to post_class.
 *
 * @param string|array $class Optional. Button additional classes.
 */
function bs4_btn_class( $class = '' ) {
	echo 'class="' . esc_attr( join( ' ', bs4_get_btn_class( $class ) ) ) . '"';
}

/**
 * Return button filterable CSS classes. Similar to get_post_class.
 *
 * @param string|array $class Optional. Button additional classes.
 */
function bs4_get_btn_class( $class = '' ) {
	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	$defaults = array();
	$defaults[] = 'btn';

	if ( ! bs4_component_has_color_class( $class, 'btn' ) ) {
		$defaults[] = 'btn-' . get_theme_mod( 'btn_color', 'primary' );
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( 'bs4_btn_class', $classes );
}

/**
 * Display badge CSS classes. Similar to post_class.
 *
 * @param string|array $class Optional. Badge additional classes.
 */
function bs4_badge_class( $class = '' ) {
	echo 'class="' . esc_attr( join( ' ', bs4_get_badge_class( $class ) ) ) . '"';
}

/**
 * Return badge filterable CSS classes. Similar to get_post_class.
 *
 * @param string|array $class Optional. Badge additional classes.
 */
function bs4_get_badge_class( $class = '' ) {
	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	$defaults = array();
	$defaults[] = 'badge';

	if ( ! bs4_component_has_color_class( $class, 'badge' ) ) {
		$defaults[] = 'badge-' . get_theme_mod( 'badge_color', 'primary' );
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( 'bs4_badge_class', $classes );
}

/**
 * Display alert filterable CSS classes. Similar to post_class.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_alert_class( $class = '' ) {
	echo 'class="' . esc_attr( join( ' ', bs4_get_alert_class( $class ) ) ) . '"';
}

/**
 * Return alert filterable CSS classes. Similar to get_post_class.
 *
 * @param string|array $class Optional. Container additional classes.
 */
function bs4_get_alert_class( $class = '' ) {
	if ( ! is_array( $class ) ) {
		if ( '' !== $class ) {
			$class = explode( ' ', $class );
		} else {
			$class = array();
		}
	}

	$defaults = array();
	$defaults[] = 'alert';

	if ( ! bs4_component_has_color_class( $class, 'alert' ) ) {
		$defaults[] = 'alert-' . get_theme_mod( 'alert_bg_color', 'primary' );
	}

	// Merge added classes and default classes.
	$classes = array_merge( $defaults, $class );

	return apply_filters( 'bs4_alert_class', $classes );
}

/**
 * Return the default Bootstrap component and utility colors.
 *
 * @param string $type Optional. Used to determine what colors are returned. Default bg.
 */
function bs4_component_colors_default( $type = 'bg' ) {
	$colors = array(
		'none' => esc_attr__( 'None', 'bs4' ),
		'primary' => esc_attr__( 'Primary', 'bs4' ),
		'secondary' => esc_attr__( 'Secondary', 'bs4' ),
		'success' => esc_attr__( 'Success', 'bs4' ),
		'danger' => esc_attr__( 'Danger', 'bs4' ),
		'warning' => esc_attr__( 'Warning', 'bs4' ),
		'info' => esc_attr__( 'Info', 'bs4' ),
		'light' => esc_attr__( 'Light', 'bs4' ),
		'dark' => esc_attr__( 'Dark', 'bs4' ),
	);

	if ( 'btn' !== $type || 'alert' !== $type || 'badge' !== $type ) {
		$colors[]['white'] = esc_attr__( 'White', 'bs4' );
	}

	if ( 'btn' === $type ) {
		$colors[]['link'] = esc_attr__( 'Link', 'bs4' );
	}

	return $colors;
}

/**
 * Return the default choices for Bootstrap component colors.
 *
 * Used as function so it can be easily used across files, like plugin customizers.
 *
 * @param array  $classes Component CSS classes.
 * @param string $type    Optional. Used to determine what colors are returned. Default bg.
 *
 * @return bool
 */
function bs4_component_has_color_class( $classes, $type = 'bg' ) {
	$retval = false;

	if ( $classes && is_array( $classes ) ) {
		$twbs_colors = array_keys( bs4_component_colors_default( $type ) );

		foreach ( $twbs_colors as $color ) {
			$color_class = $type . '-' . $color;

			if ( in_array( $color_class, $classes, true ) ) {
				$retval = true;
			}
		}
	}

	return $retval;
}
