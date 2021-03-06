<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
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
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( 'no' === get_option( 'woocommerce_enable_shipping_calc' ) || ! WC()->cart->needs_shipping() ) {
	return;
}
?>

<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator table" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<p><a href="#" class="shipping-calculator-button"><?php esc_attr_e( 'Calculate shipping', 'bs4' ); ?></a></p>

	<section class="shipping-calculator-form" style="display:none;">

		<div class="form-row form-row-wide form-group" id="calc_shipping_country_field">
			<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state form-control" rel="calc_shipping_state">
				<option value=""><?php esc_attr_e( 'Select a country&hellip;', 'bs4' ); ?></option>
				<?php foreach ( WC()->countries->get_shipping_countries() as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( WC()->customer->get_shipping_country(), esc_attr( $key ) ); ?>>
						<?php echo esc_html( $value ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div><!-- .form-group -->

		<div class="form-row form-row-wide form-group" id="calc_shipping_state_field">
			<?php
			$current_cc = WC()->customer->get_shipping_country();
			$current_r  = WC()->customer->get_shipping_state();
			$states     = WC()->countries->get_states( $current_cc );

			if ( is_array( $states ) && empty( $states ) ) :

				// Hidden Input.
				?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'bs4' ); ?>" /><?php

			elseif ( is_array( $states ) ) :

				// Dropdown Input.
				?><span>
					<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'bs4' ); ?>" class="form-control">
						<option value=""><?php esc_html_e( 'Select a state&hellip;', 'bs4' ); ?></option>
						<?php
						foreach ( $states as $ckey => $cvalue ) :
							echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
						endforeach;
						?>
					</select>
				</span><?php

			else :

				// Standard Input.
				?><input type="text" class="input-text form-control" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'bs4' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

			endif;
			?>
		</div><!-- .form-group -->

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

			<div class="form-row form-row-wide" id="calc_shipping_city_field form-group">
				<input type="text" class="input-text form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'bs4' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</div><!-- .form-group -->

		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<div class="form-row form-row-wide" id="calc_shipping_postcode_field form-group">
				<input type="text" class="input-text form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'bs4' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</div><!-- .form-group -->

		<?php endif; ?>

		<button type="submit" name="calc_shipping" value="1" <?php bs4_btn_class( 'button' ); ?>><?php esc_attr_e( 'Update totals', 'bs4' ); ?></button>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
