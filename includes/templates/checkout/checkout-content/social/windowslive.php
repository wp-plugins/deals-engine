<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Windows Live Button Template
 *
 * To handles show windows live button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/windowslive.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */	
?>
<a title="<?php _e( 'Connect with Windows Live', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-windowslive">
	<img src="<?php echo $wliconurl;?>" alt="<?php _e( 'Windows Live', 'wpsdeals');?>" />
</a>