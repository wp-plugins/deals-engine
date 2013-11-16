<?php 

/**
 * Template For My Account Lost Password
 * 
 * Handles to return for my account lost password content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/lost-password.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_message;

	if ( $wps_deals_message->size( 'lostpassword' ) > 0 ) {
		// if we need to display the error message, we will do it here
		echo $wps_deals_message->output( 'lostpassword' );
	}
	if ( $wps_deals_message->size( 'lostpasswordsuccess' ) > 0 ) {
		// if we need to display the error message, we will do it here
		echo $wps_deals_message->output( 'lostpasswordsuccess' );
	}
?>
	
	<div class="wps-deals-error wps-deals-lost-password-error"></div>
	
	<form action="" method="POST">
	
		<div class="wps-deals-reset-password-wrap row-fluid clearfix">
			<div class="wps-deals-reset-password-fields-container wps-deals-fields-container">
				
				<div class="wps-deals-details row-fluid">
					<?php echo apply_filters( 'wps_deals_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'wpsdeals' ) ); ?>
				</div><!--wps-deals-details-->
				
				<div class="wps-deals-details row-fluid">
					<div class="span4">
						<p><label for="wps_deals_user_email"><?php echo _e( 'Username or email','wpsdeals' ); ?></label></p>
					</div>
					<div class="span8">
						<input type="text" name="wps_deals_user_email" id="wps_deals_user_email" class="wps-deals-cart-text wps-deals-required" />
					</div>
				</div><!--wps-deals-details-->
				
			</div><!--.wps-deals-reset-password-fields-container-->
		</div><!--.wps-deals-reset-password-wrap-->
	
		<div class="wps-deals-reset-password-submit-wrapper">
			<input type="submit" name="wps_deals_reset_password" class="wps-deals-reset-password-btn wps-deals-btn" value="<?php _e( 'Reset Password', 'wpsdeals' ) ?>" />
		</div><!--.wps-deals-reset-password-submit-wrapper-->
		
	</form>