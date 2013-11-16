<?php 

/**
 * Template For My Account Top Content
 * 
 * Handles to return for my account top content content
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/top-content.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$changepasswordlinkhtml = '<a href="' . $changepasswordlink . '">' . __( 'change your password', 'wpsdeals' ) . '</a>';
?>	
<p class="wps_deals_my_account_top">
	<?php
		printf(	__( 'Hello <strong>%s</strong>, from your account dashboard you can view your recent orders, manage your billing address and %s.', 'wpsdeals' ), $username, $changepasswordlinkhtml );
	?>
</p>