<?php 

/**
 * Template For My Account My Addresses
 * 
 * Handles to return for my account my addresses content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/my-addresses.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php 	if( !empty( $address_title ) ) { ?>

	<h3><?php echo $address_title; ?></h3>
	
	<p class="wps_deals_my_account_address">
		<?php echo apply_filters( 'wps_deals_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'wpsdeals' ) ); ?>
	</p>
	
	<?php
	
		foreach ( $my_account_addresses as $key => $title ) {
			do_action( 'wps_deals_my_account_' . $key . '_address', $key, $title );
		}
	
	?>
	
<?php 	} else if( !empty( $emptymessage ) ) { // Check addresses are not available
	
			echo $emptymessage;
		}
?>