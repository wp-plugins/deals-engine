<?php 

/**
 * Template Checkout Content Part
 * 
 * Handles to show checkout page content part
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/cc-form.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
?>
	
		<div class="wps-deals-credit-card-details">
			
			<h2><?php echo apply_filters( 'wps_deals_cc_info_title',__('Credit Card Info','wpsdeals'));?></h2>
			
			<?php if( is_ssl() ) : ?>
				
				<div id="wps_deals_secure_site_wrapper">
					<span class="padlock"></span>
					<span><?php _e( 'This is a secure SSL encrypted payment.', 'wpsdeals' ); ?></span>
				</div>
				
			<?php endif; ?>
			
			<div id="wps_deals_cc_number_wrap" class="wps-deals-details row-fluid">
				<div class="span4">
					<p>
						<?php echo apply_filters( 'wps_deals_cc_number_label',__('Card Number','wpsdeals'));?>
						<span class="wps-deals-cc-required">*</span>
						<span class="card-type"></span>
					</p>
				</div>
				<div class="span8">
					<input type="text" autocomplete="off" name="wps_deals_card_number" id="wps_deals_card_number" class="wps-deals-card-number wps-deals-cart-text" placeholder="<?php _e( 'Card number', 'wpsdeals' ); ?>" /><br />
					<span class="wps-deals-cc-description"><?php _e( 'The (typically) 16 digits on the front of your credit card.', 'wpsdeals' ); ?></span>
				</div>
			</div>
			<div id="wps_deals_cc_cvc_wrap" class="wps-deals-details row-fluid">
				<div class="span4">
					<p>
						<?php echo apply_filters( 'wps_deals_csv_number_label',__('CVC','wpsdeals'));?>
						<span class="wps-deals-cc-required">*</span>
					</p>
				</div>
				<div class="span8">
					<input type="text" size="4" autocomplete="off" name="wps_deals_card_cvc" id="wps_deals_card_cvc" class="wps-deals-card-cvc wps-deals-cart-text" placeholder="<?php _e( 'Security code', 'wpsdeals' ); ?>" /><br />
					<span class="wps-deals-cc-description"><?php _e( 'The 3 digit (back) or 4 digit (front) value on your card.', 'wpsdeals' ); ?></span>
				</div>
			</div>
			<div id="wps_deals_cc_name_wrap" class="wps-deals-details row-fluid">
				<div class="span4">
					<p>
						<?php echo apply_filters( 'wps_deals_cc_name_label',__('Name on the Card','wpsdeals'));?>
						<span class="wps-deals-cc-required">*</span>
					</p>
				</div>
				<div class="span8">
					<input type="text" autocomplete="off" name="wps_deals_card_name" id="wps_deals_card_name" class="wps-deals-card-name wps-deals-cart-text" placeholder="<?php _e( 'Card name', 'wpsdeals' ); ?>" /><br />
					<span class="wps-deals-cc-description"><?php _e( 'The name printed on the front of your credit card.', 'wpsdeals' ); ?></span>
				</div>
			</div>
			<?php do_action( 'wps_deals_before_cc_expiration' ); ?>
			<div id="wps_deals_cc_expiration_wrap" class="wps-deals-details card-expiration row-fluid">
				<div class="span4">
					<p>
						<?php echo apply_filters( 'wps_deals_cc_expire_label',__('Expiration (MM/YY)','wpsdeals'));?>
						<span class="wps-deals-cc-required">*</span>
					</p>
				</div>
				<div class="span8">
					<select name="wps_deals_card_exp_month" id="wps_deals_card_exp_month" class="wps-deals-card-expiry-month wps-deals-cc-select wps-deals-cart-select">
						<?php for( $i = 1; $i <= 12; $i++ ) { echo '<option value="' . $i . '" '.selected( date('m'), sprintf ('%02d', $i ), false ).'>' . sprintf ('%02d', $i ) . '</option>'; } ?>
					</select>
					<span class="exp-divider"> / </span>
					<select name="wps_deals_card_exp_year" id="wps_deals_card_exp_year" class="wps-deals-card-expiry-year wps-deals-cc-select wps-deals-cart-select">
						<?php for( $i = date('Y'); $i <= date('Y') + 10; $i++ ) { echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; } ?>
					</select><br />
					<span class="wps-deals-cc-description"><?php _e( 'The date your credit card expires, typically on the front of the card.', 'wpsdeals' ); ?></span>
				</div>
			</div>
			<?php do_action( 'wps_deals_cc_expiration_after' ); ?>
			
		</div><!--wps-deals-credit-card-details-->