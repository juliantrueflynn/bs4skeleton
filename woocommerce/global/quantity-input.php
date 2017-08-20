<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( $max_value && $min_value === $max_value ) : ?>
	<div class="quantity hidden">
		<?php bs4_form_input_hidden( esc_attr( $input_name ), esc_attr( $min_value ), array(
			'class' => 'qty',
		) ); ?>
	</div><!-- .quantity -->
<?php else : ?>
	<div class="quantity form-group">
		<?php bs4_form_input( esc_attr( $input_name ), esc_attr( $input_value ), array(
			'type' => 'number',
			'class' => 'input-text qty text form-control',
			'title' => esc_attr_x( 'Qty', 'Product quantity input tooltip', 'bs4' ),
			'step' => esc_attr( $step ),
			'max' => 0 < $max_value ? esc_attr( $max_value ) : '',
			'min' => esc_attr( $min_value ),
			'size' => 4,
			'pattern' => esc_attr( $pattern ),
			'inputmode' => esc_attr( $inputmode ),
		) ); ?>
	</div><!-- .quantity -->
<?php
endif;
