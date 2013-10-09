<?php 

/**
 * Template For Login Form
 * 
 * Handles to return design of cart login form
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/user-form/login-form.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="wps-deals-login-form-wrap row-fluid clearfix">
	<div class="wps-deals-login-form">
		<h2><?php echo apply_filters( 'wps_deals_cart_login_account_label', __('Login to your account?','wpsdeals'));?></h2>
		<?php
				//do action to add fields before user login form
				do_action( 'wps_deals_checkout_login_form_before' );
		?>
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_cart_username_label',__('User Name','wpsdeals'));?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_cart_login_user_name" id="wps_deals_cart_login_user_name" class="wps-deals-cart-text wps-deals-required"/>
			</div>
		</div>
		<?php
				//do action to add fields after user name field
				do_action( 'wps_deals_checkout_login_form_username_after' );
		?>		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_cart_password_label', __('Password','wpsdeals'));?></p>
			</div>
			<div class="span8">
				<input type="password" name="wps_deals_cart_login_user_pass" id="wps_deals_cart_login_user_pass" class="wps-deals-cart-text wps-deals-required"/>
			</div>
		</div>
		<?php
				//do action to add fields after user login form
				do_action( 'wps_deals_checkout_login_form_after' );
		?>
	</div><!--.wps-deals-login-form-->
		<p><?php _e('Need to create an account? ','wpsdeals' );?>
			<a href="javascript:void(0);" class="wps-deals-class-reg-link"><?php _e('Register or checkout as a guest.','wpsdeals');?></a></p>
</div><!--.wps-deals-login-form-wrap-->