<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<div id="wc-product-tabs-product" class="tabs wc-tabs nav nav-tabs" role="tablist">
			<?php
			$i = 0;
			foreach ( $tabs as $key => $tab ) :
				$active = 0 === $i ? ' active' : '';
				?>
				<a class="nav-link<?php echo esc_attr( $active ); ?>" id="tab-title-<?php echo esc_attr( $key ); ?>" data-toggle="tab" href="#tab-<?php echo esc_attr( $key ); ?>" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<?php echo apply_filters( 'woocommerce_product_' . esc_attr( $key ) . '_tab_title', esc_html( $tab['title'] ), esc_attr( $key ) ); // WPCS: XSS OK. ?>
				</a>
				<?php
				$i++;
			endforeach;
			?>
		</div><!-- .nav-tabs -->
		<div id="wc-product-tabs-content" class="tab-content">
			<?php
			$i = 0;
			foreach ( $tabs as $key => $tab ) :
				$active = 0 === $i ? ' show active' : '';
				?>
				<div class="tab-pane<?php echo esc_attr( $active ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel">
					<?php call_user_func( $tab['callback'], $key, $tab ); ?>
				</div><!-- .tab-pane -->
				<?php
				$i++;
			endforeach;
			?>
		</div><!-- .tab-content -->
	</div><!-- .woocommerce-tabs -->

<?php
endif;
