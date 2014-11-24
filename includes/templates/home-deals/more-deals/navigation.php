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

<div class="deals-navdeal <?php if($activetab == "ending-soon") echo "deals-nav1"; else if($activetab == "upcoming-soon") echo "deals-nav2";?>">

	<span class="deals-active <?php if($activetab == "active") echo "active"; ?>">
		<a href="<?php echo add_query_arg("tab", "active", get_permalink()); ?>">
			<?php echo apply_filters( 'wps_deals_home_active_tab_text', __( 'Active Deals', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
	<span class="deals-ending-soon <?php if($activetab == "ending-soon") echo "active"; ?>">
		<a href="<?php echo add_query_arg("tab", "ending-soon", get_permalink()); ?>">
			<?php echo apply_filters( 'wps_deals_home_ending_tab_text', __( 'Ending Soon', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
	<span class="deals-upcoming-soon <?php if($activetab == "upcoming-soon") echo "active"; ?>">
		<a href="<?php echo add_query_arg("tab", "upcoming-soon", get_permalink()); ?>">
			<?php echo apply_filters( 'wps_deals_home_upcoming_tab_text', __( 'Upcoming Deals', 'wpsdeals' ) ); ?>
		</a>
	</span>
	
</div>