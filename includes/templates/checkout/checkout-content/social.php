<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Social Template
 *
 * To handles some small HTML content for social login
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/checkout/checkout-content/social.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<div class="wps-deals-social-container">
	
	<?php if( !empty( $title ) ) { ?>
		<h2><?php echo apply_filters( 'wps_deals_social_login_title_lable', $title );?></h2>
	<?php } ?>
	
	<div class="wps-deals-social-wrap">
		<?php 	
				//do action to add social login buttons
				do_action( 'wps_deals_checkout_social_login' );
		?>
	</div><!--.wps-deals-social-wrap-->

	<div class="wps-deals-social-error"></div><!--wps-deals-social-error-->
	
	<div class="wps-deals-social-loader">
		<img src="<?php echo WPS_DEALS_SOCIAL_URL;?>/images/social-loader.gif" alt="<?php _e( 'Social Loader', 'wpsdeals');?>"/>
	</div><!--.wps-deals-social-loader-->
		
	<input type="hidden" class="wps-deals-login-redirect-url" id="wps_deals_login_redirect_url" value="<?php echo $login_redirect_url;?>" />
		
</div><!--.wps-deals-social-container-->