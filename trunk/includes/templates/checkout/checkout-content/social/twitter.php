<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Twitter Template
 *
 * To handles show Twitter for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/twitter.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */	
?>
<a title="<?php _e( 'Connect with Twitter', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-twitter">
	<img src="<?php echo $twiconurl;?>" alt="<?php _e( 'Twitter', 'wpsdeals');?>" />
</a>
		
	