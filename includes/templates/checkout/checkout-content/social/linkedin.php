<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Linkedin Button Template
 *
 * To handles show Linkedin button for 
 * social login button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-content/social/linkedin.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<a title="<?php _e( 'Connect with LinkedIn', 'wpsdeals');?>" href="javascript:void(0);" class="wps-deals-social-login-linkedin">
	<img src="<?php echo $liiconurl;?>" alt="<?php _e( 'LinkedIn', 'wpsdeals');?>" />
</a>