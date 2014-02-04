<?php 

/**
 * Template For Create An Account Page
 * 
 * Handles to return for create an account page content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/create-account.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_message;

	if ( $wps_deals_message->size( 'register' ) > 0 ) {
		// if we need to display the error message, we will do it here
		echo '<div class="wps-deals-multierror">';
		echo 	$wps_deals_message->output( 'register' );
		echo '</div>';
	}
	
?>

<div class="wps-deals-error wps-deals-register-error"></div>

<form action="" method="post" enctype="multipart/form-data" >
	
	<div class="wps-deals-register-wrap row-fluid clearfix">
		<div class="wps-deals-register-fields-container wps-deals-fields-container">
				
			<?php
				//do action to add fields before reg form in cart
				do_action( 'wps_deals_reg_form_before' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_user_name"><?php _e( 'User Name', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="text" id="wps_deals_reg_user_name" name="wps_deals_reg_user_name" class="wps-deals-cart-text wps-deals-required" value="<?php echo $wps_deals_reg_user_name; ?>" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after user name
				do_action( 'wps_deals_reg_form_username_after' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_reg_user_firstname"><?php _e( 'First Name', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="text" id="wps_deals_reg_user_firstname" name="wps_deals_reg_user_firstname" class="wps-deals-cart-text wps-deals-required" value="<?php echo $wps_deals_reg_user_firstname; ?>" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after user first name
				do_action( 'wps_deals_reg_form_first_name_after' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_reg_user_lastname"><?php _e( 'Last Name', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="text" id="wps_deals_reg_user_lastname" name="wps_deals_reg_user_lastname" class="wps-deals-cart-text wps-deals-required" value="<?php echo $wps_deals_reg_user_lastname; ?>" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after user last name
				do_action( 'wps_deals_reg_form_last_name_after' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_reg_user_email"><?php _e( 'Email Address', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="text" id="wps_deals_reg_user_email" name="wps_deals_reg_user_email" class="wps-deals-cart-text wps-deals-required" value="<?php echo $wps_deals_reg_user_email; ?>" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after user email
				do_action( 'wps_deals_reg_form_email_after' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_reg_user_pass"><?php _e( 'Password', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="password" id="wps_deals_reg_user_pass" name="wps_deals_reg_user_pass" class="wps-deals-cart-text wps-deals-required" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after user password
				do_action( 'wps_deals_reg_form_pass_after' );
			?>
			
			<div class="wps-deals-details row-fluid">
				<div class="span4">
					<p><label for="wps_deals_reg_user_confirm_pass"><?php _e( 'Confirm Password', 'wpsdeals' ); ?></label></p>
				</div>
				<div class="span8">
					<input type="password" id="wps_deals_reg_user_confirm_pass" name="wps_deals_reg_user_confirm_pass" class="wps-deals-cart-text wps-deals-required" />
				</div>
			</div><!--wps-deals-details-->
			
			<?php
				//do action to add fields after registration form
				do_action( 'wps_deals_reg_form_after' );
			?>
		</div><!--.wps-deals-register-fields-container-->
	</div><!--.wps-deals-register-wrap-->
	
	<div class="wps-deals-register-submit-wrapper">
		<input type="submit" class="wps-deals-register-submit-btn wps-deals-btn" name="wps_deals_register_submit" id="wps_deals_register_submit" value="<?php _e( 'Register', 'wpsdeals' ); ?>">
		<a href="<?php echo $loginlink; ?>" class="wps-deals-login-link"><?php _e( 'Login', 'wpsdeals' ); ?></a>
	</div><!--.wps-deals-register-submit-wrapper-->
		
</form>