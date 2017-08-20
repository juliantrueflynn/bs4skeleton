<?php
/**
 * Make theme compatible with 3rd party plugins.
 *
 * @package BS4_Skeleton
 */

// If WooCommerce plugin is activated then proceed.
if ( class_exists( 'WooCommerce' ) ) {
	require get_parent_theme_file_path( '/inc/plugins/woocommerce/woocommerce.php' );
}
