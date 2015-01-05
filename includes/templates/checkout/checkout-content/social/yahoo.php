<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Yahoo Button Template
 *
 * To handles show Yahoo button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/yahoo.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<a title="<?php _e( 'Connect with Yahoo', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-yahoo">
	<img src="<?php echo $yhiconurl;?>" alt="<?php _e( 'Yahoo', 'wpsdeals');?>" />
</a>