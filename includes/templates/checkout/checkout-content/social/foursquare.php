<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Foursquare Button Template
 *
 * To handles show Foursquare button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/foursquare.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<a title="<?php _e( 'Connect with Foursquare', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-foursquare">
	<img src="<?php echo $fsiconurl;?>" alt="<?php _e( 'Foursquare', 'wpsdeals');?>" />
</a>