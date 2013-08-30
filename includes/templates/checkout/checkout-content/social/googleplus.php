<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Google plus Button Template
 *
 * To handles show Google plus button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/googleplus.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */	
?>
<a title="<?php _e( 'Connect with Google+', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-gplus">
	<img src="<?php echo $gpiconurl;?>" alt="<?php _e( 'Google+', 'wpsdeals');?>" />
</a>