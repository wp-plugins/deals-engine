<?php 

/**
 * Template For Billing details
 * 
 * Handles to return design of billing details in cart
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/billing-details.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//.wps-deals-address-container need to add because country state ajax will work proper
?>
<div class="wps-deals-billing-details-wrap row-fluid clearfix wps-deals-address-container">
	<div class="wps-deals-billing-details checkout-fields-container">
		<h2><?php echo apply_filters( 'wps_deals_cart_billing_detail_title',__('Billing Details','wpsdeals'));?></h2>
		<?php
				//do action to add something checkout billing details before
				do_action( 'wps_deals_checkout_billing_details_before' );
		?>
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_country_label',__( 'Country','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<select name="wps_deals_billing_details[country]" id="wps_deals_billing_details_country" class="wps-deals-cart-select wps-deals-required billing-country wps-deals-country-combo">
					<option value=""><?php _e( 'Select Country&hellip;', 'wpsdeals' );?></option>
					<?php
							foreach ( $countries as $coukey => $country ) {
					?>
								<option value="<?php echo $country['country_code'];?>" <?php selected( $usercountry, $country['country_code'], true);?>><?php echo $country['country_name']; ?></option>
					<?php
							}
					?>
				</select>
			</div><!--.span8-->
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details country after
				do_action( 'wps_deals_checkout_billing_details_country_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_company_label',__( 'Company Name','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_billing_details[company]" id="wps_deals_billing_details_company" value="<?php echo $usercompany;?>" class="wps-deals-cart-text" placeholder="<?php _e( 'Company Name', 'wpsdeals' );?>"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details company after
				do_action( 'wps_deals_checkout_billing_details_company_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_address_label',__( 'Address','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_billing_details[address1]" id="wps_deals_billing_details_address1" value="<?php echo $useraddress1;?>" class="wps-deals-cart-text wps-deals-required" placeholder="<?php _e( 'Address Line 1', 'wpsdeals' );?>"/>
				<input type="text" name="wps_deals_billing_details[address2]" id="wps_deals_billing_details_address2" value="<?php echo $useraddress2;?>" class="wps-deals-cart-text" placeholder="<?php _e( 'Address Line 2 (optional)', 'wpsdeals' );?>"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details address after
				do_action( 'wps_deals_checkout_billing_details_address_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_city_label',__( 'Town / City','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_billing_details[city]" id="wps_deals_billing_details_city" value="<?php echo $usercity;?>" class="wps-deals-cart-text wps-deals-required" placeholder="<?php _e( 'Town / City', 'wpsdeals' );?>"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details city after
				do_action( 'wps_deals_checkout_billing_details_city_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_state_label',__( 'County / State','wpsdeals' ) );?></p>
			</div>
			<?php  //make state combo HTML as below to work country ajax proper from main plugin ?>
			<div class="span8">
				<div class="wps-deals-state-field">
				<?php 	//check states not empty
						if( !empty( $statelist ) &&  is_array( $statelist ) ) {
				?>			
							<select name="wps_deals_billing_details[state]" id="wps_deals_billing_details_state" class="wps-deals-cart-select wps-deals-required billing-country wps-deals-state-combo">
								<option value=""><?php _e( 'Select State / County&hellip;', 'wpsdeals' );?></option>
				<?php			foreach ( $statelist as $statekey => $state ) {
									echo '<option value="'.$statekey.'" '.selected( $userstate, $statekey, false ).'>'.$state.'</option>';
								} //end loop
				?>			</select>
				<?php	} else { ?>
							<input type="text" name="wps_deals_billing_details[state]" id="wps_deals_billing_details_state" value="<?php echo $userstate;?>" class="wps-deals-cart-text wps-deals-required wps-deals-state-combo" placeholder="<?php _e( 'State / County', 'wpsdeals' );?>"/>			
				<?php	}	?>
					
				</div><!--.wps-deals-state-field-->
			</div><!--.span8-->
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details state after
				do_action( 'wps_deals_checkout_billing_details_state_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_postcode_label',__( 'Zip / Postal Code','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_billing_details[postcode]" id="wps_deals_billing_details_postcode" value="<?php echo $userpostcode;?>" class="wps-deals-cart-text wps-deals-required" placeholder="<?php _e( 'Postcode / Zip', 'wpsdeals' );?>"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field checkout billing details postcode after
				do_action( 'wps_deals_checkout_billing_details_postcode_after' );
		?>
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_billing_phone_label',__( 'Phone','wpsdeals' ) );?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_billing_details[phone]" id="wps_deals_billing_details_phone" value="<?php echo $userphone;?>" class="wps-deals-cart-text" placeholder="<?php _e( 'Phone', 'wpsdeals' );?>"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add something checkout billing details before
				do_action( 'wps_deals_checkout_billing_details_before' );
		?>
		
	</div><!--.wps-deals-billing-details-->
</div><!--.wps-deals-billing-details-wrap-->