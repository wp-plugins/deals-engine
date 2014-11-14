<?php 

/**
 * Template Cart Update Button
 * 
 * Handles to show cart update button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-header/cart-action-buttons/cart-update-button.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<button name="wps_deals_cart_update" class="wps-deals-cart-item-update btn"><?php echo apply_filters( 'wps_deals_update_cart_button_text',__('Update Cart','wpsdeals') );?></button>