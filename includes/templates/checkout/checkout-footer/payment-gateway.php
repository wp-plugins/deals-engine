<?php 

/**
 * Template For Payment Gateway
 * 
 * Handles to return design of payment gateway
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/payment-gateway.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	if(count($paymentgatway) > 1) { //when more than one payment gateways selected then show dropdown
	
		?>	
			<div class="wps-deals-payment-wrap row-fluid clearfix">
				<div class="wps-deals-payment-form checkout-fields-container">
					<h2><?php echo apply_filters('wps_deals_cart_payment_method_label', __('Payment Method','wpsdeals'));?></h2>
					
						<?php
								//do action to add payment gateway combo box before
								do_action( 'wps_deals_checkout_payment_combo_before' );
						?>			
					
						<select name="wps_deals_payment_gateways" id="wps_deals_payment_gateways" class="wps-deals-cart-select wps-deals-required">
							<?php 			
									foreach ($paymentgatway as $key => $gateway) {
										if( isset( $gateway['checkout_label'] ) ) {
							?>			
										<option value="<?php echo $key;?>" <?php selected( $defaultgatway, $key, true );?>><?php echo $gateway['checkout_label'];?></option>
							<?php 		
										}
									}
							?>		
						</select>
						<?php
								//do action to add payment gateway combo box after
								do_action( 'wps_deals_checkout_payment_combo_after' );
						?>			
					</div>
				</div>
		<?php
	
	} else {
		//when more than one payment gateways selected then show dropdown
		?>
			<input type="hidden" name="wps_deals_payment_gateways" id="wps_deals_payment_gateways" value="<?php echo key($paymentgatway);?>"/>
		<?php 
	}
?>