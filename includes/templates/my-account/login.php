<?php 

/**
 * Template For My Account Login
 * 
 * Handles to return for my account login content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/login.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_message;

?>

<div id="wps_deals_login" class="wps-deals-login-wrap" >

	<?php
		if ( $wps_deals_message->size( 'login' ) > 0 ) {
			// if we need to display the error message, we will do it here
			echo '<div class="wps-deals-multierror">';
			echo 	$wps_deals_message->output( 'login' );
			echo '</div>';
		}
	?>
	
	<div class="wps-deals-error wps-deals-login-error"></div>
	
	<form action="" method="post" enctype="multipart/form-data" >
				
		<label for="wps_deals_user_name"><?php _e( 'User Name', 'wpsdeals' ); ?></label><br />
		<input type="text" id="wps_deals_user_name" name="wps_deals_user_name" class="wps-deals-cart-text wps-deals-required" /><br />
					
		<label for="wps_deals_user_pass"><?php _e( 'Password', 'wpsdeals' ); ?></label><br />
		<input type="password" id="wps_deals_user_pass" name="wps_deals_user_pass" class="wps-deals-cart-text wps-deals-required" /><br />
						
		<label for="wps_deals_remember">
			<input type="checkbox" name="wps_deals_remember" id="wps_deals_remember" value="1" /><?php _e( 'Remember me', 'wpsdeals' ); ?>
		</label><br />
	
		<div class="wps-deals-login-submit-wrap">
		<?php if( !empty( $registerlink ) ) { ?>
			<a href="<?php echo $registerlink; ?>" class="wps-deals-register-link"><?php _e( 'Register', 'wpsdeals' ); ?></a>
		<?php } ?>
			<a href="<?php echo $lostpasswordlink; ?>" class="wps-deals-lost-password"><?php _e( 'Lost Password?', 'wpsdeals' ); ?></a>
			<input type="submit" class="wps-deals-login-submit-btn wps-deals-btn" name="wps_deals_login_submit" id="wps_deals_login_submit" value="<?php _e( 'Login', 'wpsdeals' ); ?>"><br />
		</div>
	</form>
					
</div>