<?php
/**
 * WordPress Customizer settings/options for WooCommerce
 *
 * @package BS4_Skeleton
 */

/**
 * Add to WordPress Customizer for WooCommerce.
 *
 * @param WP_Customize_Manager $wp_customize theme Customizer object.
 */
function bs4_wc_customize_register( $wp_customize ) {
	/**
	 * Add section: WooCommerce.
	 */
	$wp_customize->add_section( 'bs4_woocommerce', array(
		'title' => __( 'WooCommerce', 'bs4' ),
		'priority' => '30',
	) );

	// Add setting: Posts per row.
	$wp_customize->add_setting( 'wc_loop_per_row', array(
		'default' => 3,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'wc_loop_per_row', array(
		'label' => __( 'Products per row', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'text',
		'description' => __( 'Amount of products in each row.', 'bs4' ),
	) );

	// Add setting: Post column width.
	$wp_customize->add_setting( 'wc_product_column_breakpoint', array(
		'default' => 'md',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'wc_product_column_breakpoint', array(
		'label' => __( 'Product column breakpoint', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'select',
		'description' => __( 'Responsive device breakpoint for post columns in grid.', 'bs4' ),
		'choices' => bs4_customize_control_column_breakpoint_choices(),
	) );

	// Add setting: Hide nav cart.
	$wp_customize->add_setting( 'wc_hide_top_nav_cart', array(
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'wc_hide_top_nav_cart', array(
		'label' => __( 'Hide top nav cart', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'checkbox',
	) );

	// Add setting: Format top nav cart text.
	$wp_customize->add_setting( 'wc_nav_cart_icon', array(
		'default' => 'fa fa-shopping-cart',
		'sanitize_callback' => 'esc_attr',
	) );

	$wp_customize->add_control( 'wc_nav_cart_icon', array(
		'label' => __( 'Nav cart icon', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'text',
		'description' => __( 'Icon to display with nav cart text. Only put the icon class (ex. "fa fa-shopping-cart").', 'bs4' ),
	) );

	// Add setting: Sales badge color.
	$wp_customize->add_setting( 'wc_sales_badge_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'wc_sales_badge_color', array(
		'label' => __( 'Sales badge color', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'select',
		'description' => __( 'Color for the product sales badge.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );

	// Add setting: Product tab badge color.
	$wp_customize->add_setting( 'wc_nav_tab_badge_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'wc_nav_tab_badge_color', array(
		'label' => __( 'Nav tab badge color', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'select',
		'description' => __( 'Color for the product nav tab badge.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );

	// Add setting: Product category badge color.
	$wp_customize->add_setting( 'wc_product_cat_badge_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'wc_product_cat_badge_color', array(
		'label' => __( 'Product category badge color', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'select',
		'description' => __( 'Color for the product category badge.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );

	// Add setting: Product tag badge color.
	$wp_customize->add_setting( 'wc_product_tag_badge_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'bs4_sanitize_select_or_radio',
	) );

	$wp_customize->add_control( 'wc_product_tag_badge_color', array(
		'label' => __( 'Product tag badge color', 'bs4' ),
		'section' => 'bs4_woocommerce',
		'type' => 'select',
		'description' => __( 'Color for the product tag badge.', 'bs4' ),
		'choices' => bs4_customize_control_colors_choices(),
	) );
}
add_action( 'customize_register', 'bs4_wc_customize_register' );
