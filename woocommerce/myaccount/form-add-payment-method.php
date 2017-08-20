<?php
/**
 * Add payment method form form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-add-payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

if ( $available_gateways ) : ?>
	<form id="add_payment_method" method="post">
		<div id="payment" class="woocommerce-Payment">
			<ul class="woocommerce-PaymentMethods payment_methods methods">
				<?php
				// Chosen Method.
				if ( count( $available_gateways ) ) :
					current( $available_gateways )->set_current();
				endif;

				foreach ( $available_gateways as $gateway ) :
					?>
					<li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo $gateway->id; // WPCS: XSS OK. ?> payment_method_<?php echo $gateway->id; // WPCS: XSS OK. ?>">
						<input id="payment_method_<?php echo $gateway->id; // WPCS: XSS OK. ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
						<label for="payment_method_<?php echo $gateway->id; // WPCS: XSS OK. ?>"><?php echo $gateway->get_title(); // WPCS: XSS OK. ?> <?php echo $gateway->get_icon(); // WPCS: XSS OK. ?></label>
						<?php
						if ( $gateway->has_fields() || $gateway->get_description() ) :
							?>
							<div class="woocommerce-PaymentBox woocommerce-PaymentBox--<?php echo $gateway->id; // WPCS: XSS OK. ?> payment_box payment_method_<?php echo $gateway->id; // WPCS: XSS OK. ?>" style="display: none;">
								<?php $gateway->payment_fields(); ?>
							</div>
							<?php
						endif;
						?>
					</li>
					<?php
				endforeach;
				?>
			</ul>

			<?php wp_nonce_field( 'woocommerce-add-payment-method' ); ?>
			<input type="submit" <?php bs4_btn_class( 'woocommerce-Button woocommerce-Button--alt button alt' ); ?> id="place_order" value="<?php esc_attr_e( 'Add payment method', 'bs4' ); ?>" />
			<input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
		</div>
	</form>
<?php else : ?>
	<p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'Sorry, it seems that there are no payment methods which support adding a new payment method. Please contact us if you require assistance or wish to make alternate arrangements.', 'bs4' ); ?></p>
<?php endif; ?>
