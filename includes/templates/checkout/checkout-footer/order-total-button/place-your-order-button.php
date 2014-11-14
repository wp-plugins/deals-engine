<?php 

/**
 * Template For Cart Total Footer
 * 
 * Handles to return design of cart total
 * and order button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/order-total-button/place-your-order-button.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$regclass = is_user_logged_in() ? '' : ' wps-deals-reg-button-submit';

?>
<input type="hidden" name="wps_deals_submit_payment" value="<?php _e('Deals Purchase','wpsdeals');?>" />
<?php echo apply_filters('wps_deals_place_your_order_button','<button type="submit" class="wps-deals-checkout-btn btn '.$regclass.'">'.__( 'Place your order','wpsdeals').'</button>');?>