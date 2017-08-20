<?php
/**
 * BS4 Skeleton: Customizer
 *
 * @package BS4_Skeleton
 */

/**
 * Register WordPress Theme Customizer settings
 *
 * @param WP_Customize_Manager $wp_customize theme Customizer object.
 */
function bs4_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'bs4_customize_partial_blogname',
	) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'bs4_customize_partial_blogdescription',
	) );

	// Section: Layout.
	$wp_customize->add_section( 'bs4_layout', array(
		'title' => __( 'Layout', 'bs4' ),
		'priority' => '5',
	) );

	// Add setting: Site container width.
	$wp_customize->add_setting( 'bs4_container_width', array(
		'default' => 'container',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'bs4_container_width', array(
		'label' => __( 'Site container width', 'bs4' ),
		'section' => 'bs4_layout',
		'type' => 'select',
		'description' => __( 'Setting width of Bootstrap container for the header, content area, and footer.', 'bs4' ),
		'choices' => array(
			'none' => 'No container',
			'container' => 'Container',
			'container-fluid' => 'Fluid container',
		),
	) );

	$col_width_choices = array(
		1 => '1/12',
		2 => '2/12',
		3 => '3/12',
		4 => '4/12',
		6 => '6/12',
		7 => '7/12',
		8 => '8/12',
		9 => '9/12',
		10 => '10/12',
		11 => '11/12',
		12 => '12/12',
	);

	// Add setting: Site main column width.
	$wp_customize->add_setting( 'primary_column_width', array(
		'default' => 8,
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'primary_column_width', array(
		'label' => __( 'Main column width', 'bs4' ),
		'section' => 'bs4_layout',
		'type' => 'select',
		'description' => __( 'Main content area column width.', 'bs4' ),
		'choices' => $col_width_choices,
	) );

	// Add setting: Site sidebar column width.
	$wp_customize->add_setting( 'secondary_column_width', array(
		'default' => 4,
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'secondary_column_width', array(
		'label' => __( 'Sidebar column width', 'bs4' ),
		'section' => 'bs4_layout',
		'type' => 'select',
		'description' => __( 'Sidebar area column width.', 'bs4' ),
		'choices' => $col_width_choices,
	) );

	// Add setting: Site columns responsive breakpoint.
	$wp_customize->add_setting( 'site_columns_breakpoint', array(
		'default' => 'md',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'site_columns_breakpoint', array(
		'label' => __( 'Site column breakpoint', 'bs4' ),
		'section' => 'bs4_layout',
		'type' => 'select',
		'description' => __( 'Responsive device breakpoint for main content and sidebar column.', 'bs4' ),
		'choices' => bs4_customize_control_column_breakpoint_choices(),
	) );

	// Add setting: Hide sidebar.
	$wp_customize->add_setting( 'hide_sidebar', array(
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'hide_sidebar', array(
		'label' => __( 'Hide sidebar', 'bs4' ),
		'section' => 'bs4_layout',
		'type' => 'checkbox',
	) );

	// Section: Colors (default WordPress section).
	// Add setting: Button colors.
	$wp_customize->add_setting( 'btn_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'btn_color', array(
		'label' => __( 'Button color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Default color for buttons on the site unless coded elsewhere in theme.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices( 'btn' ),
	) );

	// Add setting: Badge colors.
	$wp_customize->add_setting( 'badge_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'badge_color', array(
		'label' => __( 'Badge color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Default color for buttons on the site unless coded elsewhere in theme.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices( 'badge' ),
	) );

	// Add setting: Category badge color.
	$wp_customize->add_setting( 'badge_color_post_cat', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'badge_color_post_cat', array(
		'label' => __( 'Category badge color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Default badge color for category lists in single view.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices( 'badge' ),
	) );

	// Add setting: Tag badge color.
	$wp_customize->add_setting( 'badge_color_post_tag', array(
		'default' => 'secondary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'badge_color_post_tag', array(
		'label' => __( 'Tag badge color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Default badge color for tag lists in single view.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices( 'badge' ),
	) );

	// Add setting: Alert background color.
	$wp_customize->add_setting( 'alert_bg_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'alert_bg_color', array(
		'label' => __( 'Alert background color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Background color for Bootstrap alerts.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );

	// Add setting: Top navbar color scheme.
	$wp_customize->add_setting( 'top_navbar_color_scheme', array(
		'default' => 'dark',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'top_navbar_color_scheme', array(
		'label' => __( 'Top navbar color scheme', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Color scheme for the top navbar.', 'bs4' ),
		'choices' => array(
			'none' => 'No color scheme',
			'dark' => 'Dark',
			'light' => 'Light',
		),
	) );

	// Add setting: Top navbar background color.
	$wp_customize->add_setting( 'top_navbar_bg_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'top_navbar_bg_color', array(
		'label' => __( 'Top navbar color', 'bs4' ),
		'section' => 'colors',
		'type' => 'select',
		'description' => __( 'Background color for the top navbar.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );

	// Section: Header.
	$wp_customize->add_section( 'bs4_header', array(
		'title' => __( 'Header', 'bs4' ),
		'priority' => '10',
	) );

	// Add setting: Top navbar position.
	$wp_customize->add_setting( 'top_navbar_position', array(
		'default' => 'none',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'top_navbar_position', array(
		'label' => __( 'Site navbar position', 'bs4' ),
		'section' => 'bs4_header',
		'type' => 'select',
		'description' => __( 'Position the top navbar.', 'bs4' ),
		'choices' => array(
			'none' => 'Default position',
			'fixed-top' => 'Fixed top',
			'fixed-bottom' => 'Fixed Bottom',
			'sticky-top' => 'Sticky top',
		),
	) );

	// Hide parts of layout.
	$header_choices = array(
		'hide_header' => __( 'Header', 'bs4' ),
		'hide_top_nav_search' => __( 'Top nav search', 'bs4' ),
	);

	$header_list = array();

	// Add setting: Hide Parts.
	foreach ( $header_choices as $header_key => $header_value ) {
		$header_list[ $header_key ] = $header_key;
		$wp_customize->add_setting( $header_key, array(
			'sanitize_callback' => 'sanitize_key',
		) );
	}

	$wp_customize->add_control( new BS4_Multi_Checkbox_WP_Customize_Control( $wp_customize, 'hide_header_parts', array(
		'label' => __( 'Hide header parts', 'bs4' ),
		'section' => 'bs4_header',
		'type' => 'multi_checkbox',
		'description' => __( 'Check off any parts of the header to hide.', 'bs4' ),
		'settings' => $header_list,
		'choices' => $header_choices,
	) ) );

	// Section: Loop.
	$wp_customize->add_section( 'bs4_loops', array(
		'title' => __( 'Loop', 'bs4' ),
		'priority' => '10',
	) );

	// Add setting: Loop layout.
	$wp_customize->add_setting( 'loop_layout', array(
		'default' => 'full',
		'sanitize_callback' => 'esc_attr',
	) );

	$wp_customize->add_control( 'loop_layout', array(
		'label' => __( 'Loop type', 'bs4' ),
		'section' => 'bs4_loops',
		'type' => 'radio',
		'description' => __( 'When the two column layout is assigned, the page title is in one column and content is in the other.', 'bs4' ),
		'choices' => array(
			'full' => __( 'Full', 'bs4' ),
			'excerpt' => __( 'Excerpt', 'bs4' ),
			'grid' => __( 'Grid', 'bs4' ),
		),
	) );

	// Add setting: Columns per row in loop.
	$wp_customize->add_setting( 'loop_per_row', array(
		'default' => 3,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'loop_per_row', array(
		'label' => __( 'Posts per row', 'bs4' ),
		'section' => 'bs4_loops',
		'type' => 'text',
		'description' => __( 'Amount of posts in each row.', 'bs4' ),
	) );

	// Add setting: Loop column responsive breakpoint.
	$wp_customize->add_setting( 'post_column_breakpoint', array(
		'default' => 'md',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'post_column_breakpoint', array(
		'label' => __( 'Post column breakpoint', 'bs4' ),
		'section' => 'bs4_loops',
		'type' => 'select',
		'description' => __( 'Responsive device breakpoint for post columns in grid.', 'bs4' ),
		'choices' => bs4_customize_control_column_breakpoint_choices(),
	) );

	// Section: Footer.
	$wp_customize->add_section( 'bs4_footer', array(
		'title' => __( 'Footer', 'bs4' ),
		'priority' => '10',
	) );

	// Add setting: Post column width.
	$wp_customize->add_setting( 'footer_copyright_text', array(
		'default' => __( 'Copyright --title --year', 'bs4' ),
		'sanitize_callback' => 'esc_attr',
	) );

	$wp_customize->add_control( 'footer_copyright_text', array(
		'label' => __( 'Copyright text', 'bs4' ),
		'section' => 'bs4_footer',
		'type' => 'text',
		'description' => __( '%year% = Current year.<br>%title% = Site title with link.', 'bs4' ),
	) );

	// Hide footer parts choices.
	$parts_choices = array(
		'hide_footer' => __( 'Footer', 'bs4' ),
		'hide_footer_copyright' => __( 'Copyright', 'bs4' ),
		'hide_footer_credit_links' => __( 'WordPress credit link', 'bs4' ),
	);

	$parts_list = array();

	// Add setting: Hide footer parts.
	foreach ( $parts_choices as $part_key => $part_value ) {
		$parts_list[ $part_key ] = $part_key;
		$wp_customize->add_setting( $part_key, array(
			'sanitize_callback' => 'sanitize_key',
		) );
	}

	$wp_customize->add_control( new BS4_Multi_Checkbox_WP_Customize_Control( $wp_customize, 'hide_footer_parts', array(
		'label' => __( 'Hide footer parts', 'bs4' ),
		'section' => 'bs4_footer',
		'type' => 'multi_checkbox',
		'description' => __( 'Check off any parts of the theme to hide.', 'bs4' ),
		'settings' => $parts_list,
		'choices' => $parts_choices,
	) ) );
}
add_action( 'customize_register', 'bs4_customize_register' );

/**
 * Return the default choices for any control for column responsive breakpoint sizes.
 * Used as function so it can be easily used across files, like plugin customizers.
 */
function bs4_customize_control_column_breakpoint_choices() {
	return array(
		'xs' => esc_attr__( 'Extra small (xs)', 'bs4' ),
		'sm' => esc_attr__( 'Small (sm)', 'bs4' ),
		'md' => esc_attr__( 'Medium (md)', 'bs4' ),
		'lg' => esc_attr__( 'Large (lg)', 'bs4' ),
		'xl' => esc_attr__( 'Extra large (xl)', 'bs4' ),
	);
}

/**
 * Select or radio field sanitization callback.
 *
 * Sanitizes `$input` as a slug, and then validates `$input` against the choices defined for the control.
 *
 * @param string               $value   Control value sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 */
function bs4_sanitize_select_or_radio( $value, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $value );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	if ( array_key_exists( $input, $choices ) ) {
		$retval = $input;
	} else {
		$retval = $setting->default;
	}

	return $retval;
}

/*
 * Class for multiple checkbox customize control.
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	require get_parent_theme_file_path( '/inc/class-bs4-multi-checkbox-wp-customize-control.php' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @see bs4_customize_register()
 */
function bs4_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see bs4_customize_register()
 */
function bs4_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Return the default choices for Bootstrap component colors.
 *
 * Used as function so it can be easily used across files, like plugin customizers.
 *
 * @param string $type Optional. Used to determine what colors are returned. Default bg.
 */
function bs4_customize_control_colors_choices( $type = 'bg' ) {
	return bs4_component_colors_default( $type );
}
