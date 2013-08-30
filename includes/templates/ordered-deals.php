<?php

/**
 * Ordered Deals Data
 * 
 * Handles to show ordered deals data
 * 
 * Override this template by copying it to yourtheme/deals-engine/ordered-deals.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();

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
						//do action to show order details
						do_action( 'wps_deals_orders_top' );
					?>
				
					<div class="row-fluid">	
				
						<?php
							//do action to show order details
							do_action( 'wps_deals_orders_content' );
						?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show order details
						do_action( 'wps_deals_orders_bottom' );
					?>
					
				</div><!--.entry-content-->
				
			</article>
			
		</div><!--#content-->
		
	</div><!--site-content-->
	
<?php

	//get sidebar
	get_sidebar();
	
	//get footer
	get_footer(); 
	
?>	