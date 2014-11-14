<?php

/**
 * Title Template
 * 
 * Override this template by copying it to yourtheme/deals-engine/single-deal/title.php
 *
 * @author 		Social Deals Engine
 * @package 	Deals-Engine/Includes/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<header class="deals-col-12 entry-header">
				
	<h1 itemprop="name" class="entry-title">
		<?php echo the_title();?>
	</h1>
	
</header> 