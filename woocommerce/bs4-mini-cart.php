<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nav_cart_icon = apply_filters( 'bs4_nav_cart_icon', get_theme_mod( 'wc_nav_cart_icon', 'fa fa-shopping-cart' ) );

do_action( 'bs4_wc_before_nav_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<li class="nav-cart-dropdown nav-item dropdown">
		<a class="nav-cart-dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			<?php if ( '' !== $nav_cart_icon ) : ?>
				<i class="<?php echo esc_attr( $nav_cart_icon ); ?>"></i>
			<?php endif; ?>
			<?php echo WC()->cart->get_cart_subtotal(); // WPCS: XSS OK. ?>
		</a>
		<div class="nav-cart-dropdown-menu dropdown-menu dropdown-menu-right">
			<h6 class="dropdown-header"><?php esc_attr_e( 'Your cart', 'bs4' ); ?></h6>
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
					$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>

					<div class="dropdown-item">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( // WPCS: XSS OK.
							'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'bs4' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>

						<div class="nav-cart-item-content d-flex flex-row align-items-center">
							<div class="nav-cart-item-img">
								<a href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( '50x50' ), $cart_item, $cart_item_key ); // WPCS: XSS OK. ?>
								</a>
							</div><!-- .nav-cart-item-img -->

							<div class="nav-cart-item-content-body small">
								<span class="nav-cart-title nav-cart-item-text">
									<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo $product_name; // WPCS: XSS OK. ?></a>
								</span>

								<span class="nav-cart-title nav-cart-item-text d-block">
									<?php echo WC()->cart->get_item_data( $cart_item ); // WPCS: XSS OK. ?>
								</span>

								<?php echo apply_filters( 'bs4_wc_nav_cart_item_quantity', '<span class="quantity nav-cart-item-text">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // WPCS: XSS OK. ?>
							</div><!-- .nav-cart-item-content-body -->
						</div><!-- .nav-cart-item-content -->
					</div><!-- .dropdown-item -->
					<?php
				}// End if().
			}// End foreach().
			?>

			<div class="dropdown-divider"></div>

			<?php do_action( 'bs4_wc_nav_shopping_cart_before_buttons' ); ?>

			<div class="nav-cart__buttons buttons dropdown-item btn-group btn-group-sm" role="group">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" <?php bs4_btn_class( 'button wc-forward w-50 btn-secondary' ); ?>>
					<?php echo esc_html__( 'View cart', 'bs4' ); ?>
				</a>

				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" <?php bs4_btn_class( 'button checkout wc-forward w-50' ); ?>>
					<?php echo esc_html__( 'Checkout', 'bs4' ); ?>
				</a>
			</div><!-- .nav-cart__buttons -->
		</div><!-- .nav-cart-dropdown-menu -->
	</li>
<?php endif; ?>

<?php do_action( 'bs4_wc_after_nav_cart' ); ?>
