<?php 

/**
 * Template For Order Total and Order Button
 * 
 * Handles to return design of Order total
 * and order button
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/order-total-button.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>									

<div class="wps-deals-details row-fluid">
	<div class="span4 hidden-phone">&nbsp;</div>
	<div class="span8">	
		<?php 
				//do action to show order total and button
				do_action( 'wps_deals_cart_footer_total_button' );
		?>
	</div>
</div><!--wps-deals-details-->