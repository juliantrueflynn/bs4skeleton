<?php
/**
 * Extra functions to make WooCommerce compatible with Bootstrap 4
 *
 * @package BS4_Skeleton
 */

/*
 * Template action hooks for WooCommerce
 */
require get_parent_theme_file_path( '/inc/plugins/woocommerce/wc-template-hooks.php' );

/*
 * Template functions for WooCommerce
 */
require get_parent_theme_file_path( '/inc/plugins/woocommerce/wc-template-helpers.php' );

/*
 * Conditional styles for WooCommerce
 */
require_once( get_parent_theme_file_path( '/inc/plugins/woocommerce/wc-styles.php' ) );

/*
 * Theme Customizer functions for WooCommerce
 */
require get_parent_theme_file_path( '/inc/plugins/woocommerce/wc-customizer.php' );

/**
 * Theme supports for WooCommerce.
 */
function bs4_wc_setup() {
	// Add theme support for WooCommerce.
	add_theme_support( 'woocommerce' );

	/**
	 * WooCommerce single product galleries can use jQuery zoom, lightbox, and slider. These are optional libraries to register.
	 *
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
	 */
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'bs4_wc_setup' );

/**
 * Remove default Woocommerce Stylesheet
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Filter default HTML output for add to cart notices so the links are Bootstrap friendly.
 *
 * @param string $message Add to cart notice HTML output.
 */
function bs4_wc_add_to_cart_message_html( $message ) {
	$message = str_replace( 'class="button wc-forward"', 'class="button wc-forward alert-link"', $message );

	return $message;
}
add_filter( 'wc_add_to_cart_message_html', 'bs4_wc_add_to_cart_message_html' );

/**
 * Add column width and whatever other additional CSS classes to products in loop.
 *
 * @param array $classes An array of post classes.
 * @param array $class   An array of additional classes added to the post.
 * @param int   $post_id The post ID.
 */
function bs4_wc_post_class_archive_product( $classes, $class = '', $post_id = '' ) {
	// Check if current product is in single view.
	// Important to prevent conflict if other loops are on single product (ex. related products).
	if ( ! is_single( $post_id ) && in_array( 'product', $classes, true ) ) {
		$per_row = (int) apply_filters( 'bs4_wc_loop_per_row', get_theme_mod( 'wc_loop_per_row', 3 ) );

		$column_width = '-' . ( 12 / $per_row );

		// Column responsive breakpoint.
		$breakpoint = get_theme_mod( 'wc_product_column_breakpoint', 'md' );

		if ( '' !== $breakpoint ) {
			$column_breakpoint = '-' . $breakpoint;
		}

		$classes[] = sanitize_html_class( 'col' . $column_breakpoint . $column_width );
	}

	return $classes;
}
add_filter( 'post_class', 'bs4_wc_post_class_archive_product', 20, 3 );

/**
 * Display conditional template for mini cart in navbar.
 *
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 */
function bs4_wc_display_top_nav_cart_menu_item( $items, $args ) {
	$show_cart = apply_filters( 'bs4_hide_top_nav_cart', get_theme_mod( 'wc_hide_top_nav_cart', false ) );

	$nav_cart = '';

	if ( ! $show_cart ) {
		if ( 'top_secondary' === $args->theme_location ) {
			$nav_cart = wc_get_template_html( 'bs4-mini-cart.php' );
		}

		if ( 'top' === $args->theme_location && ! has_nav_menu( 'top_secondary' ) ) {
			$nav_cart = wc_get_template_html( 'bs4-mini-cart.php' );
		}
	}

	return $items . $nav_cart;
}
add_filter( 'wp_nav_menu_items', 'bs4_wc_display_top_nav_cart_menu_item', 10, 2 );

/**
 * Add image size to WordPress. Used for WooCommerce shopping cart product images.
 */
add_image_size( '50x50', 50, 50, true );

/**
 * Filters product categories list to make compatible with Bootstrap 4 badges.
 *
 * @param array $links List of terms to display.
 */
function bs4_wc_product_term_product_cat( $links ) {
	return bs4_wc_term_link_badge_html( $links, 'product_cat' );
}
add_filter( 'term_links-product_cat', 'bs4_wc_product_term_product_cat' );

/**
 * Filters product tags list to make compatible with Bootstrap 4 badges.
 *
 * @param array $links List of terms to display.
 */
function bs4_wc_product_term_product_tag( $links ) {
	return bs4_wc_term_link_badge_html( $links, 'product_tag' );
}
add_filter( 'term_links-product_tag', 'bs4_wc_product_term_product_tag' );

/**
 * Output HTML for WooCommerce taxonomy term link.
 *
 * @param array  $html     List of terms to display.
 * @param string $taxonomy Taxonomy name.
 */
function bs4_wc_term_link_badge_html( $html, $taxonomy ) {
	$badge_class = get_theme_mod( "wc_{$taxonomy}_badge_color", 'primary' );
	$classes = '';
	if ( $badge_class ) {
		$badge_class = 'bg-' . sanitize_html_class( $badge_class );
		$classes = join( ' ', bs4_get_badge_class( $badge_class ) );
	}

	$html = str_replace( ' rel="tag"', ' class="' . esc_attr( $classes ) . '" rel="tag"', $html );

	return $html;
}

/**
 * Open wrapper for WooCommerce product list widget.
 */
function bs4_wc_before_widget_product_list() {
	return '<div class="product_list_widget list-group">';
}
add_filter( 'woocommerce_before_widget_product_list', 'bs4_wc_before_widget_product_list' );

/**
 * Close wrapper for WooCommerce product list widget.
 */
function bs4_wc_after_widget_product_list() {
	return '</div>';
}
add_filter( 'woocommerce_after_widget_product_list', 'bs4_wc_after_widget_product_list' );

/**
 * When product is on sale then show Bootstrap badge component.
 *
 * @param string $sales_flash Sales flash HTML for products.
 */
function bs4_wc_sale_flash( $sales_flash ) {
	$badge_class = get_theme_mod( 'wc_sales_badge_color', 'primary' );
	$classes = '';
	if ( $badge_class && 'none' !== $badge_class ) {
		$badge_class = 'bg-' . sanitize_html_class( $badge_class );
		$classes = join( ' ', bs4_get_badge_class( $badge_class ) );
	}

	// Replace current sales badge class with added classes.
	$sales_flash = str_replace( 'class="onsale"', 'class="onsale ' . esc_attr( $classes ) . '"', $sales_flash );

	return $sales_flash;
}
add_filter( 'woocommerce_sale_flash', 'bs4_wc_sale_flash' );

/**
 * Make single product variation select fields Bootstrap friendly.
 *
 * @param array $args Select field arguments.
 */
function bs4_wc_dropdown_variation_attribute_options_args( $args ) {
	$args['class'] = 'form-control form-control-sm';

	return $args;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'bs4_wc_dropdown_variation_attribute_options_args' );

/**
 * Make single product variation select field reset link Bootstrap friendly.
 *
 * @param array $html Reset variations link HTML.
 */
function bs4_wc_reset_variations_link( $html ) {
	$html = str_replace( 'class="reset_variations"', 'class="reset_variations form-text small"', $html );

	return $html;
}
add_filter( 'woocommerce_reset_variations_link', 'bs4_wc_reset_variations_link' );

/**
 * Make WooCommerce breadcrumbs Bootstrap 4 friendly.
 *
 * @link https://docs.woocommerce.com/document/customise-the-woocommerce-breadcrumb/
 *
 * @param array $args Breadcrumb with new args.
 */
function bs4_filter_default_wc_breadcrumbs( $args ) {
	// Set new breadcrumb settings.
	$args = array(
		'delimiter' => ' ',
		'wrap_before' => '<ol class="breadcrumb">',
		'wrap_after' => '</ol>',
		'before' => '<li class="breadcrumb-item">',
		'after' => '</li>',
		'home' => _x( 'Home', 'breadcrumb', 'bs4' ),
	);

	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'bs4_filter_default_wc_breadcrumbs' );

/**
 * Make WooCommerce sales badge a Bootstrap 4 badge.
 *
 * @link https://docs.woocommerce.com/document/editing-product-data-tabs/
 *
 * @param string $tab_title Title for Reviews tab.
 */
function bs4_wc_reviews_tab_badge( $tab_title ) {
	global $product;

	// Get review count to use in badge.
	$reviews_count = $product->get_review_count();

	$badge_class = get_theme_mod( 'wc_sales_badge_color', 'primary' );
	$classes = '';
	if ( $badge_class && 'none' !== $badge_class ) {
		$badge_class = 'bg-' . sanitize_html_class( $badge_class );
		$classes = join( ' ', bs4_get_badge_class( $badge_class ) );
	}

	return sprintf(
		'%s <span class="%s">%s</span>',
		__( 'Reviews', 'bs4' ),
		esc_attr( $classes ),
		$reviews_count
	);
}
add_filter( 'woocommerce_product_reviews_tab_title', 'bs4_wc_reviews_tab_badge' );

/**
 * Make links in WooCommerce notices Bootstrap alert links.
 *
 * @param string $message Notice message.
 */
function bs4_wc_filter_notice_link( $message ) {
	$message = str_replace( 'class="showlogin"', 'class="showlogin alert-link"', $message );
	$message = str_replace( 'class="showcoupon"', 'class="showcoupon alert-link"', $message );

	return $message;
}
add_filter( 'woocommerce_add_notice', 'bs4_wc_filter_notice_link' );
add_filter( 'woocommerce_add_success', 'bs4_wc_filter_notice_link' );
add_filter( 'woocommerce_add_error', 'bs4_wc_filter_notice_link' );

/**
 * Make loop product add to cart link Bootstrap friendly.
 */
function bs4_wc_loop_add_to_cart_link() {
	global $product;

	return sprintf( '<a href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( 'button card-link' ),
		esc_html( $product->add_to_cart_text() )
	);
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'bs4_wc_loop_add_to_cart_link' );

/**
 * Make cart remove link Bootstrap and HTML5 friendly.
 *
 * @param string $html Cart remove product link.
 */
function bs4_wc_cart_item_remove_link( $html ) {
	$html = str_replace( 'class="remove"', 'class="remove close"', $html );
	$html = str_replace( '>&times;</a>', '><span aria-hidden="true">&times;</span></a>', $html );

	return $html;
}
add_filter( 'woocommerce_cart_item_remove_link', 'bs4_wc_cart_item_remove_link' );
