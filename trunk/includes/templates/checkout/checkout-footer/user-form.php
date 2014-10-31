<?php 

/**
 * Template User Login
 * 
 * Handles to show User login fields
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/user-form.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="wps-deals-user-form">
	<?php	
		//do action to add content inside user form
		do_action( 'wps_deals_cart_user_form_content' );
	?>			
</div><!--wps-deals-user-form-->