<?php
/**
 * Home Content Footer Timer
 * 
 * Handles to Show Active Deals
 * Template on home page
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/home/home-content/timer.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="wps-deals-timing">
	<span class="timer-icon-small"></span><span><?php echo $timeremain;?></span>
</div>