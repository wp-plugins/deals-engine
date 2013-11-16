<?php 

/**
 * Template For My Account Edit Billing Address
 * 
 * Handles to return for my account edit billing address
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/edit-billing-address.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_message;
?>

	<?php
		if ( $wps_deals_message->size( 'cartuser' ) > 0 ) {
			// if we need to display the error message, we will do it here
			echo '<div class="wps-deals-multierror">';
			echo 	$wps_deals_message->output( 'cartuser' );
			echo '</div>';
		}
	?>
	
	<div class="wps-deals-error wps-deals-cart-user-error"></div>
	
	<form method="POST" action="" >
	
		<?php
			do_action( 'wps_deals_manage_billing_address' );
		?>
		
		<div class="wps-deals-save-address-wrapper">
			<input class="wps-deals-save-address-btn" type="submit" name="wps_deals_save_billing_address" value="<?php _e( 'Save Address', 'wpsdeals' ) ?>" />
		</div>
		
	</form>