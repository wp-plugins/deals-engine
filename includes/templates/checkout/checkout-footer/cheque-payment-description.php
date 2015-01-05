<?php 

/**
 * Template Cheque Description
 * 
 * Handles to show cheque description when
 * select cheque payment gateway
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/cheque-payment-description.php
 *
 * @package Social Deals Engine
 * @since 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div id="wps_deals_cheque_payment_description" class="wps-deals-payment-description <?php echo $enablebankdesc;?>">
	<p>
		<?php echo $description;?>
	</p>
</div>