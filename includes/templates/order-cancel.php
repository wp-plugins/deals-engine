<?php 

/**
 * Template For Deals Lists Header
 * 
 * Handles to return design of deals listing
 * page header
 * 
 * Override this template by copying it to yourtheme/deals-engine/order-cancel.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//get header
	get_header( 'deals' );

	global $post;
	
?>

	<div class="site-content" id="primary">
	
		<div id="content" role="main">
		
			<article class="post-<?php echo $post->ID;?> page type-page status-publish hentry" id="post-<?php echo $post->ID;?>">
			
				<header class="entry-header">
					<h1 class="entry-title"><?php echo get_the_title( $post->ID );?></h1>
				</header> 
				
				<div class="entry-content">
				
					<?php
						//do action to show order cancel top
						do_action( 'wps_deals_orders_cancel_top' );
					?>	
					<div class="row-fluid">
						
					<?php
							//do action to show orders details which is cancel
							do_action( 'wps_deals_orders_cancel_content' );
						?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show order cancel bottom
						do_action( 'wps_deals_orders_cancel_bottom' );
					?>	
					
				</div><!--entry-content-->
				
			</article>
						
		</div><!--#content-->
		
	</div><!--site-content-->
<?php

	//register sidebar with following action
	do_action( 'wps_deals_sidebar' );
	
	//get footer
	get_footer( 'deals' );
	
?>