<?php 

/**
 * Template For My Account Change Password
 * 
 * Handles to return for my account change password content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/change-password.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_message;

	if ( $wps_deals_message->size( 'changepassword' ) > 0 ) {
		// if we need to display the error message, we will do it here
		echo '<div class="wps-deals-multierror">';
		echo 	$wps_deals_message->output( 'changepassword' );
		echo '</div>';
	}
	
	$submit_label = __( 'Change Password', 'wpsdeals' );
			
?>
	
	<div class="wps-deals-error wps-deals-change-password-error"></div>
	
	<form action="" method="POST">
	
		<div class="wps-deals-change-password-wrap row-fluid clearfix">
			<div class="wps-deals-change-password-fields-container wps-deals-fields-container">
				
				<?php
				
					if( !empty( $wps_deals_reset_key ) && !empty( $wps_deals_reset_login ) ) {
						
						?>	
						
						<div class="wps-deals-details row-fluid">
							<?php echo __( 'Enter a new password below.', 'wpsdeals' ); ?>
						</div><!--wps-deals-details-->
				
						<?php		
					}
				
				?>
				
				<div class="wps-deals-details row-fluid">
					<div class="span4">
						<p><label for="wps_deals_new_password"><?php _e( 'New password','wpsdeals' ); ?></label></p>
					</div>
					<div class="span8">
						<input type="password" name="wps_deals_new_password" id="wps_deals_new_password" class="wps-deals-cart-text wps-deals-required" />
					</div>
				</div><!--wps-deals-details-->
				
				<div class="wps-deals-details row-fluid">
					<div class="span4">
						<p><label for="wps_deals_re_enter_password"><?php echo _e( 'Re-enter new password','wpsdeals' ); ?></label></p>
					</div>
					<div class="span8">
						<input type="password" name="wps_deals_re_enter_password" id="wps_deals_re_enter_password" class="wps-deals-cart-text wps-deals-required" />
					</div>
				</div><!--wps-deals-details-->
				
				<?php
				
					if( !empty( $wps_deals_reset_key ) && !empty( $wps_deals_reset_login ) ) {
						
						$submit_label = __( 'Reset Password', 'wpsdeals' );
						
						?>
						
					    <input type="hidden" name="wps_deals_reset_key" value="<?php echo $wps_deals_reset_key; ?>" />
					    <input type="hidden" name="wps_deals_reset_login" value="<?php echo $wps_deals_reset_login; ?>" />
					    
						<?php		
					}
				
				?>
				
			</div><!--.wps-deals-change-password-fields-container-->
		</div><!--.wps-deals-change-password-wrap-->
	
		<div class="wps-deals-change-password-submit-wrapper">
			<input type="submit" name="wps_deals_change_password" class="wps-deals-change-password-btn wps-deals-btn" value="<?php echo $submit_label; ?>" />
		</div><!--.wps-deals-change-password-submit-wrapper-->
		
	</form>