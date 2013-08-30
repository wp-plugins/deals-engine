<?php 

/**
 * Template For Order Cancel Details
 * 
 * Handles to return order cancel details
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/orders/order-cancel-details.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<p>
	<?php 
 		echo apply_filters('wps_deals_cancel_order_message',__('Sorry, your order has been cancelled.','wpsdeals'));
 	?>
</p>