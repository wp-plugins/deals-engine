<?php 

/**
 * Template For Cart Empty Message
 * 
 * Handles to return cart empty message
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-header/cart-empty.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="wps-deals-error">
	<?php echo apply_filters('wps_deals_empty_cart_message', __( 'Your cart is empty.', 'wpsdeals' ));?>
</div>