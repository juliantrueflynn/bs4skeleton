<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
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
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}
?>

<form class="woocomerce-form woocommerce-form-login login" method="post" <?php echo $hidden ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php if ( $message ) :
		echo wpautop( wptexturize( $message ) ); // WPCS: XSS OK.
	endif; ?>

	<div class="form-row form-row-first form-group">
		<label for="username"><?php esc_attr_e( 'Username or email', 'bs4' ); ?> <span class="required text-danger">*</span></label>
		<input type="text" class="input-text" name="username" id="username" />
	</div><!-- .form-group -->

	<div class="form-row form-row-last form-group">
		<label for="password"><?php esc_attr_e( 'Password', 'bs4' ); ?> <span class="required text-danger">*</span></label>
		<input class="input-text" type="password" name="password" id="password" />
	</div><!-- .form-group -->

	<?php do_action( 'woocommerce_login_form' ); ?>

	<fieldset class="form-inline">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<input type="submit" <?php bs4_btn_class( 'button' ); ?> name="login" value="<?php esc_attr_e( 'Login', 'bs4' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox form-control" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_attr_e( 'Remember me', 'bs4' ); ?></span>
		</label>
	</fieldset>

	<p class="lost_password form-text">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_attr_e( 'Lost your password?', 'bs4' ); ?></a>
	</p>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
