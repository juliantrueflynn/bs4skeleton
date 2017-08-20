<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="row">
		<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first col-sm">
			<label for="account_first_name"><?php esc_attr_e( 'First name', 'woocommerce' ); ?> <span class="required text-danger">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</div><!-- .col-sm -->
		<div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last col-sm">
			<label for="account_last_name"><?php esc_attr_e( 'Last name', 'woocommerce' ); ?> <span class="required text-danger">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</div><!-- .col-sm -->
	</div><!-- .row -->

	<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
		<label for="account_email"><?php esc_attr_e( 'Email address', 'woocommerce' ); ?> <span class="required text-danger">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</div><!-- .form-group -->

	<fieldset>
		<legend><?php esc_attr_e( 'Password change', 'woocommerce' ); ?></legend>

		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
			<label for="password_current"><?php esc_attr_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_current" id="password_current" />
		</div><!-- .form-group -->
		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
			<label for="password_1"><?php esc_attr_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_1" id="password_1" />
		</div><!-- .form-group -->
		<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
			<label for="password_2"><?php esc_attr_e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_2" id="password_2" />
		</div><!-- .form-group -->
	</fieldset>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<?php wp_nonce_field( 'save_account_details' ); ?>
	<input type="submit" <?php bs4_btn_class( 'woocommerce-Button button' ); ?> value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
	<input type="hidden" name="action" value="save_account_details" />

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
