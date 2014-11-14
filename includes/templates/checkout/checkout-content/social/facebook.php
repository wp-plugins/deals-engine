<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Facebook Button Template
 *
 * To handles show facebook button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/facebook.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */	
?>
<a title="<?php _e( 'Connect with Facebook', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-facebook">
	<img src="<?php echo $fbiconurl;?>" alt="<?php _e( 'Facebook', 'wpsdeals');?>" />
</a>