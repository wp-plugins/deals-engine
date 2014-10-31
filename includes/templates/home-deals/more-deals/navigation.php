<?php

/**
 * Navigation template for the more Deals (Active, Upcoming, Ending Soon).
 * 
 * Override this template by copying it to yourtheme/deals-engine/home-deals/more-deals/navigation.php
 * 
 * @author 		Social Deals Engine
 * @package 	Deals-Engine/Includes/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="deals-navdeal">

	<span class="active deals-active">
		<a href="javascript:void(0);">
			<?php echo apply_filters( 'wps_deals_home_active_tab_text', __( 'Active Deals', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
	<span class="deals-ending-soon">
		<a href="javascript:void(0);">
			<?php echo apply_filters( 'wps_deals_home_ending_tab_text', __( 'Ending Soon', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
	<span class="deals-upcoming-soon">
		<a href="javascript:void(0);">
			<?php echo apply_filters( 'wps_deals_home_upcoming_tab_text', __( 'Upcoming Deals', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
</div>