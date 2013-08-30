<?php 

/**
 * Template For Registration form
 * 
 * Handles to return design of registration form
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/user-form/registration-form.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_options;

	$optiontext = empty($wps_deals_options['disable_guest_checkout']) ? '(optional)' : '';
?>	
	<div class="wps-deals-reg-wrap row-fluid clearfix">
		<span><?php _e('Already have an account?','wpsdeals');?>
		<?php echo apply_filters( 'wps_deals_cart_login_link','<a href="javascript:void(0);" class="wps-deals-login-link">'.__('Login','wpsdeals').'</a>');?></span>
		<div class="wps-deals-registration-form">
			<h2><?php echo apply_filters( 'wps_deals_cart_create_account_label', __('Create an account '.$optiontext,'wpsdeals'));?></h2>
			
			<?php
				//do action to add fields before reg form in cart
				do_action( 'wps_deals_checkout_reg_form_before' );
			?>
					
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><?php echo apply_filters( 'wps_deals_cart_username_label',__('User Name','wpsdeals'));?></p>
				</div>
				<div class="span8">
					<input type="text" name="wps_deals_cart_reg_user_name" id="wps_deals_cart_reg_user_name" class="wps-deals-cart-text"/>
				</div>
			</div><!--wps-deals-details-->
			<?php
				//do action to add fields after user name
				do_action( 'wps_deals_cart_reg_form_username_after' );
			?>
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><?php  echo apply_filters( 'wps_deals_cart_password_label', __('Password','wpsdeals'));?></p>
				</div>
				<div class="span8">
					<input type="password" name="wps_deals_cart_reg_user_pass" id="wps_deals_cart_reg_user_pass" class="wps-deals-cart-text"/>
				</div>
			</div><!--wps-deals-details-->
			<?php
				//do action to add fields after user password
				do_action( 'wps_deals_checkout_reg_form_pass_after' );
			?>		
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><?php  echo apply_filters( 'wps_deals_cart_confirm_password_label',__('Confirm Password','wpsdeals'));?></p>
				</div>
				<div class="span8">
					<input type="password" name="wps_deals_cart_reg_user_confirm_pass" id="wps_deals_cart_reg_user_confirm_pass" class="wps-deals-cart-text"/>
				</div>
			</div><!--wps-deals-details-->
			<?php
				//do action to add fields after registration form
				do_action( 'wps_deals_checkout_reg_form_after' );
			?>	
		</div><!--.wps-deals-registration-form-->
	</div><!--wps-deals-reg-wrap-->