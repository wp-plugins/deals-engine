<?php 

/**
 * Template For Personal details
 * 
 * Handles to return design of personal details in cart
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/personal-details.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $current_user;

	//get the user email address from site
	if(is_user_logged_in()) { //check user is logged in to site
		
		$useremail = $current_user->user_email;
		$firstname = $current_user->user_firstname;
		$lastname = $current_user->user_lastname;
		
	} else { 
		
		$useremail = '';
		$firstname = '';
		$lastname = '';
		
	}

?>

<div class="wps-deals-guest-details-wrap row-fluid clearfix">
	<div class="wps-deals-guest-details">
		<h2><?php echo apply_filters( 'wps_deals_cart_personal_detail_title',__('Personal Details','wpsdeals'));?></h2>
		
		<?php
				//do action to add something checkout personal details before
				do_action( 'wps_deals_checkout_personal_details_before' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_cart_email_label',__('Email Address','wpsdeals'));?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_cart_user_email" id="wps_deals_cart_user_email" value="<?php echo $useremail;?>"  class="wps-deals-cart-text"/>
			</div>
		</div><!--wps-deals-details-->

		<?php
				//do action to add field checkout personal details email after
				do_action( 'wps_deals_checkout_personal_details_email_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_cart_firstname_label', __('First Name','wpsdeals'));?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_cart_user_first_name" id="wps_deals_cart_user_first_name" value="<?php echo $firstname;?>" class="wps-deals-cart-text"/>
			</div>
		</div><!--wps-deals-details-->

		
		<?php
				//do action to add field checkout personal details first name after
				do_action( 'wps_deals_checkout_personal_details_firstname_after' );
		?>
		
		<div class="wps-deals-details row-fluid">
			<div class="span4">
				<p><?php echo apply_filters( 'wps_deals_cart_lastname_label',__('Last Name','wpsdeals'));?></p>
			</div>
			<div class="span8">
				<input type="text" name="wps_deals_cart_user_last_name" id="wps_deals_cart_user_last_name" value="<?php echo $lastname;?>" class="wps-deals-cart-text"/>
			</div>
		</div><!--wps-deals-details-->
		
		<?php
				//do action to add field after checkout personal details
				do_action( 'wps_deals_checkout_personal_details_after' );
		?>
	</div><!--wps-deals-guest-details-->
</div><!--wps-deals-guest-details-wrap-->