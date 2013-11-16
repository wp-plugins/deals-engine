<?php 

/**
 * Template For Lost Password
 * 
 * Handles to return for lost password page content
 * 
 * Override this template by copying it to yourtheme/deals-engine/lost-password.php
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
						//do action to show lost password page top
						do_action( 'wps_deals_lost_password_top' );
					?>	
					<div class="row-fluid">
						
					<?php
						//do action to show lost password page content
						do_action( 'wps_deals_lost_password_content' );
					?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show lost password page bottom
						do_action( 'wps_deals_lost_password_bottom' );
					?>	
					
				</div><!--entry-content-->
				
			</article>
						
		</div><!--#content-->
		
	</div><!--site-content-->
<?php

	//get sidebar
	get_sidebar();
	
	//get footer
	get_footer(); 
	
?>