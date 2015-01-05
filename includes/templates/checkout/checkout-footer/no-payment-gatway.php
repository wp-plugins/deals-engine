<?php 

/**
 * Template No Payment Gateways
 * 
 * Handles to show when no payment 
 * gateways selected in settings page
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/no-payment-gatway.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//if there is no payment gateways selected then show error
?>
<div class="wps-deals-error">
	<?php echo apply_filters( 'wps_deals_no_payment_gateway_message',
							__('<strong>ERROR : </strong> You must enable a payment gateway to use '.WPS_DEALS_PLUGIN_NAME.'.', 'wpsdeals' ) );
	?>
</div>