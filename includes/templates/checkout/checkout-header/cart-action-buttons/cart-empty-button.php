<?php 

/**
 * Template Cart Empty Button
 * 
 * Handles to show cart empty button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-header/cart-action-buttons/cart-empty-button.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<button name="wps_deals_cart_empty" class="wps-deals-cart-empty btn"><?php echo apply_filters( 'wps_deals_empty_cart_button_text',__('Empty Cart','wpsdeals') );?></button>