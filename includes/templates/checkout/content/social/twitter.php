<?php 

/**
 * Twitter Button Template
 * 
 * Override this template by copying it to yourtheme/deals-engine/checkout/content/social/twitter.php
 *
 * @author 		Social Deals Engine
 * @package 	Deals-Engine/Includes/Templates
 * @version     1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<a title="<?php _e( 'Connect with Twitter', 'wpsdeals');?>" href="javascript:void(0);" class="deals-social-login-twitter">
	<img src="<?php echo $twiconurl;?>" alt="<?php _e( 'Twitter', 'wpsdeals');?>" />
</a>
		
	