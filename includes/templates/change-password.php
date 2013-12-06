<?php 

/**
 * Template For Change Password
 * 
 * Handles to return for change password page content
 * 
 * Override this template by copying it to yourtheme/deals-engine/change-password.php
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
						//do action to show change password page top
						do_action( 'wps_deals_change_password_top' );
					?>	
					<div class="row-fluid">
						
					<?php
							//when user is logged in then show change password content	
							if( is_user_logged_in() ) { //important
								//do action to show change password page content
								do_action( 'wps_deals_change_password_content' );
							} else {
								//else show log in form
								//do action to show change password page content
								do_action( 'wps_deals_change_password_login_content' );
							}
					?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show change password page bottom
						do_action( 'wps_deals_change_password_bottom' );
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