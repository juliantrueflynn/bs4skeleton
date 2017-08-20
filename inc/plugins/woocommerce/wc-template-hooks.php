<?php
/**
 * Functions using WooCommerce action hooks to adjust template
 *
 * @package BS4_Skeleton
 */

/**
 * Remove WooCommerce hooked sidebar woocommerce_get_sidebar().
 *
 * Default WordPress sidebar is used instead of the WooCommerce sidebar.
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Open Bootstrap .card-body component around product loop entry.
 *
 * @hooked woocommerce_show_product_loop_sale_flash - 10
 * @hooked woocommerce_template_loop_product_thumbnail - 10
 */
function bs4_wc_before_shop_loop_item_title_wrapper_open() {
	?><div class="card-img-top"><?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'bs4_wc_before_shop_loop_item_title_wrapper_open', 5 );

/**
 * Close Bootstrap .card-body component around product loop entry.
 *
 * @hooked woocommerce_show_product_loop_sale_flash - 10
 * @hooked woocommerce_template_loop_product_thumbnail - 10
 */
function bs4_wc_before_shop_loop_item_title_wrapper_close() {
	?></div><!-- .card-img-top --><?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'bs4_wc_before_shop_loop_item_title_wrapper_close', 15 );

/**
 * Open Bootstrap .card component around product loop entry.
 */
function bs4_wc_before_shop_loop_item() {
	?><div class="card"><?php
}
add_action( 'woocommerce_before_shop_loop_item', 'bs4_wc_before_shop_loop_item', 10 );

/**
 * Close Bootstrap .card-body component around product loop entry.
 */
function bs4_wc_after_shop_loop_item() {
	?></div><!-- .card --><?php
}
add_action( 'woocommerce_after_shop_loop_item', 'bs4_wc_after_shop_loop_item', 15 );

/**
 * Remove default product link in loop.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/**
 * Open Bootstrap .card-body component around product loop entry.
 */
function bs4_wc_before_shop_loop_item_title() {
	?><div class="card-body d-flex flex-column"><?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'bs4_wc_before_shop_loop_item_title', 20 );

/**
 * Close Bootstrap .card-body component around product loop entry.
 *
 * @hooked woocommerce_template_loop_add_to_cart - 10
 */
function bs4_wc_after_shop_loop_item_block() {
	?></div><!-- .card-body --><?php
}
add_action( 'woocommerce_after_shop_loop_item', 'bs4_wc_after_shop_loop_item_block', 15 );

/**
 * Open single-product-meta row with woocommerce_before_shop_loop hook.
 *
 * @hooked wc_print_notices - 10
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */
function bs4_wc_before_shop_loop_meta_open() {
	?><div class="single-product-meta d-flex flex-row align-items-center justify-content-between"><?php
}
add_action( 'woocommerce_before_shop_loop', 'bs4_wc_before_shop_loop_meta_open', 15 );

/**
 * Close single-product-meta row with woocommerce_before_shop_loop hook.
 *
 * @hooked wc_print_notices - 10
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */
function bs4_wc_before_shop_loop_meta_close() {
	?></div><!-- .single-product-meta --><?php
}
add_action( 'woocommerce_before_shop_loop', 'bs4_wc_before_shop_loop_meta_close', 35 );

/**
 * Open WooCommerce single product Bootstrap 'row' around image and summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
function bs4_wc_before_single_product_summary__row() {
	?><div class="single-product-row row"><?php
}
add_action( 'woocommerce_before_single_product_summary', 'bs4_wc_before_single_product_summary__row', 4 );

/**
 * Open WooCommerce single product Bootstrap 'row' around image and summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
function bs4_wc_before_single_product_summary__images() {
	?><div class="product-images-col col-md-6"><?php
}
add_action( 'woocommerce_before_single_product_summary', 'bs4_wc_before_single_product_summary__images', 7 );

/**
 * Open WooCommerce single product Bootstrap 'row' around image and summary.
 *
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */
function bs4_wc_before_single_product_summary__images_close() {
	?></div><!-- .product-images-col --><?php
}
add_action( 'woocommerce_before_single_product_summary', 'bs4_wc_before_single_product_summary__images_close', 30 );

/**
 * Open WooCommerce single product Bootstrap 'row' around image and summary.
 *
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */
function bs4_wc_before_single_product_summary__excerpt() {
	?><div class="product-excerpt-col col-md-6"><?php
}
add_action( 'woocommerce_before_single_product_summary', 'bs4_wc_before_single_product_summary__excerpt', 40 );

/**
 * Action hook for woocommerce_single_product_summary().
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 * @hooked WC_Structured_Data::generate_product_data() - 60
 */
function bs4_wc_single_product_summary__excerpt() {
	?></div><!-- .product-excerpt-col --><?php
}
add_action( 'woocommerce_single_product_summary', 'bs4_wc_single_product_summary__excerpt', 70 );

/**
 * Close WooCommerce single product Bootstrap 'row' around image and summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
function bs4_wc_after_single_product_summary__row() {
	?></div><!-- .single-product-row --><?php
}
add_action( 'woocommerce_after_single_product_summary', 'bs4_wc_after_single_product_summary__row', 5 );

/**
 * Open .media with woocommerce_review_before hook.
 *
 * @hooked woocommerce_review_display_gravatar - 10
 */
function bs4_wc_review_before_card_open() {
	?><div class="media"><?php
}
add_action( 'woocommerce_review_before', 'bs4_wc_review_before_card_open', 5 );

/**
 * Close .media with woocommerce_review_after_comment_text hook.
 */
function bs4_wc_review_after_card_close() {
	?></div><!-- .media --><?php
}
add_action( 'woocommerce_review_after_comment_text', 'bs4_wc_review_after_card_close', 15 );

/**
 * Open .media-body with woocommerce_review_after_comment_text hook.
 *
 * @hooked woocommerce_review_display_gravatar - 10
 */
function bs4_wc_review_before_body_open() {
	?><div class="media-body"><?php
}
add_action( 'woocommerce_review_before', 'bs4_wc_review_before_body_open', 15 );

/**
 * Close .media-body with woocommerce_review_after_comment_text hook.
 */
function bs4_wc_review_after_body_close() {
	?></div><!-- .media-body --><?php
}
add_action( 'woocommerce_review_after_comment_text', 'bs4_wc_review_after_body_close', 10 );
