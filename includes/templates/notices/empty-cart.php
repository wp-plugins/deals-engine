<?php 

/**
 * Empty Cart Message Template
 * 
 * Override this template by copying it to yourtheme/deals-engine/notices/empty-cart.php
 *
 * @author 		Social Deals Engine
 * @package 	Deals-Engine/Includes/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="deals-empty-cart">
	
	<div class="deals-message deals-error empty-cart-msg">
		<span><?php echo apply_filters( 'wps_deals_empty_cart_message', __( 'Your cart is empty.', 'wpsdeals' ) ); ?></span>
	</div>
	
</div>