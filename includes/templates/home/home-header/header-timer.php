<?php

/**
 * Home page header deal ending timer
 * 
 * Handles to make home page header timer
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/home/home-header/header-timer.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>	
<div class="wps-deals-right-header">
	<h2><?php echo apply_filters( 'wps_deals_timer_text', __('This deal will end in','wpsdeals') );?></h2>
</div><!--wps-deals-right-header-->
<div class="wps-deals-timing-front">
	<div align="center" class="wps-deals-time">
		<span class="timer-icon-big"></span>
		<span class="wps-deals-days"></span>&nbsp;
		<span><?php _e('days','wpsdeals');?></span>&nbsp;
		<span class="wps-deals-hrs"></span>&nbsp;
		<span><?php _e('hrs','wpsdeals');?></span>&nbsp;
		<span class="wps-deals-mins"></span>&nbsp;
		<span><?php _e('mins','wpsdeals');?></span>&nbsp;
		<span class="wps-deals-secs"></span>&nbsp;
		<span><?php _e('secs','wpsdeals');?></span>
	</div><!--wps-deals-time-->
</div><!--.wps-deals-timing-front-->