<?php 

/**
 * Template Cart Action Buttons
 * 
 * Handles to show cart action buttons
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-header/cart-action-buttons.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_cart;
	
	//cart class
	$cart = $wps_deals_cart;

	$cartdetails = $cart->get();
	
if ( !empty( $cartdetails ) )  {

	?>
	
	<div class="wps-deals-cart-action-buttons row-fluid clearfix">
		<?php 
				//do action to add action buttons of cart
				do_action( 'wps_deals_cart_action_buttons' );
		?>
	</div><!--wps-deals-cart-action-buttons-->
	
<?php

	}
?>