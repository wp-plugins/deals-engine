<?php 

/**
 * Template For Create an Account
 * 
 * Handles to return for create an account page content
 * 
 * Override this template by copying it to yourtheme/deals-engine/create-account.php
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
						//do action to show create account page top
						do_action( 'wps_deals_create_account_top' );
					?>	
					<div class="row-fluid">
						
					<?php
							//when user is not logged in then show create an account page content	
							if( !is_user_logged_in() ) { //important
								//do action to show create an account page content
								do_action( 'wps_deals_create_account_content' );
							} else {
								//else show log in form
								//do action to show create an account page content
								do_action( 'wps_deals_create_account_logout_content' );
							}
					?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show create an acoount page bottom
						do_action( 'wps_deals_create_account_bottom' );
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