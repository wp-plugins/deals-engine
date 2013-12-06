<?php 

/**
 * Template For Edit Address
 * 
 * Handles to return for edit address page content
 * 
 * Override this template by copying it to yourtheme/deals-engine/edit-address.php
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
						//do action to show edit address page top
						do_action( 'wps_deals_edit_address_top' );
					?>	
					<div class="row-fluid">
						
					<?php
							//when user is logged in then show edit address content	
							if( is_user_logged_in() ) { //important
								//do action to show edit address page content
								do_action( 'wps_deals_edit_address_content' );
							} else {
								//else show log in form
								//do action to show edit address page content
								do_action( 'wps_deals_edit_address_login_content' );
							}
					?>
						
					</div><!--row-fluid-->
					
					<?php
						//do action to show edit address page bottom
						do_action( 'wps_deals_edit_address_bottom' );
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