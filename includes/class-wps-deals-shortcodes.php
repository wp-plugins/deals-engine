<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes Class
 *
 * Handles shortcodes functionality of plugin
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
class Wps_Deals_Shortcodes {
	
	var $model,$scripts,$render,$cart,$currency,$message;
	
	function __construct(){
		
		global $wps_deals_model,$wps_deals_scripts,$wps_deals_render,$wps_deals_cart,
				$wps_deals_currency,$wps_deals_message;
		
		$this->model = $wps_deals_model;
		$this->scripts = $wps_deals_scripts;
		$this->render = $wps_deals_render;
		$this->cart = $wps_deals_cart;
		$this->currency = $wps_deals_currency;
		$this->message = $wps_deals_message;
		
	}
	
	/**
	 * Get All Deals Data
	 * 
	 * Handles to getting all deals data on the viewing page
	 * whereever user put shortcode
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0 
	 */
	
	public function wps_deals_all($content) {
		
		ob_start();
		//do action to add before home header
		do_action( 'wps_deals_home_content' );
		$content .= ob_get_clean();
		return $content;
	}
	
	/**
	 * Checkout Page
	 * 
	 * Handles to show details of cart to user
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_checkout($content) {
		
		ob_start();
		//do action for add checkout page
		do_action( 'wps_deals_checkout_content' );
		$content .= ob_get_clean();
		return $content;
	}
	
	/**
	 * Order Completed
	 * 
	 * Handles to show messsage order is completed successfully
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_order_complete( $content ) {
		
		ob_start();
		//do action to show orders details which is completed
		do_action( 'wps_deals_orders_complete_content' );
		$content .= ob_get_clean();
		return $content;
	}
	/**
	 * Order Cancelled
	 * 
	 * Handles to show messsage order will cancelled
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_order_cancelled( $content ) {
		
		ob_start();
		//do action to show orders details which is cancel
		do_action( 'wps_deals_orders_cancel_content' );
		$content .= ob_get_clean();
		return $content;
	
	}
	
	/**
	 * Orders Details
	 * 
	 * Handles to show details of orders placed by users
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_orders( $content ) {
		
		ob_start();
		//do action to show order details
		do_action( 'wps_deals_orders_content' );
		return $content .= ob_get_clean();
		
	}
	
	/**
	 * Deals By Category
	 * 
	 * Handles to show deals by category
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_by_category( $atts, $content ) {
		
		extract( shortcode_atts( array(	
	    	'category'	=>	''
		), $atts ) );
		
		ob_start();
		//do action to load home content by category
		do_action( 'wps_deals_home_content_shortcode', $category );
		$content .= ob_get_clean();
		
		return $content;
	}
	
	/**
	 * Show All Social Login Buttons
	 * 
	 * Handles to show all social login buttons on the viewing page
	 * whereever user put shortcode
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.1
	 */
	public function wps_deals_social_login( $atts, $content ) {
		
		global $wps_deals_options;
		
		extract( shortcode_atts( array(	
			'title'			=>	'',
	    	'redirect_url'	=>	''
		), $atts ) );
		
		if( !is_home() && is_singular() ) {
		
			//check user is not logged in and social login is enable or not for any one service
			if( !is_user_logged_in() && wps_deals_enable_social_login() ) {
				
				// get redirect url from settings
				$defaulturl = isset( $wps_deals_options['login_redirect_url'] ) && !empty( $wps_deals_options['login_redirect_url'] ) 
									? $wps_deals_options['login_redirect_url'] : wps_deals_get_current_page_url();
				
				//redirect url for shortcode
				$defaulturl = isset( $redirect_url ) && !empty( $redirect_url ) ? $redirect_url : $defaulturl; 
				
				//session create for redirect url
				$_SESSION['wps_deals_stcd_redirect_url'] = $defaulturl;
				
				ob_start();
				//do action to add social login buttons
				do_action( 'wps_deals_social_login_shortcode', $title, $redirect_url );
				$content .= ob_get_clean();
			}
		}
		return $content;
	}
	
	/**
	 * Get Single Deal Data
	 * 
	 * Handles to getting single deal data on the viewing page
	 * whereever user put shortcode
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0 
	 */
	
	public function wps_deals_single( $atts, $content ) {
		
		global $post, $wps_deals_options;
		
		// get the size for the design from the settings page
		$size = $wps_deals_options['deals_size'];
		
		extract( shortcode_atts( array(	
			'id'	=>	'',
		), $atts ) );
		
		if( !empty( $id ) ) { // Check deal id is not empty from shortcode
			
			ob_start();
			
			// Add query for display single deal wherever user put single deal id in shortcode
			$args = array( 'post_type' => WPS_DEALS_POST_TYPE, 'post__in' => array( $id ), 'posts_per_page' => '1' );
			
			// The Query
			$the_query = new WP_Query( $args );
		
			// The Loop
			if ( $the_query->have_posts() ) {
				
				while ( $the_query->have_posts() ) {
					
					$the_query->the_post();
					
						//do action to add localize script for individual post data
						do_action( 'wps_deals_localize_map_script' );
					
						//do action to add in top of single page
						do_action( 'wps_deals_single_top' );
					?>
							
						<div class="row-fluid <?php echo $size;?>">
						
							<?php
								//do action to add deal single content
								do_action( 'wps_deal_single_content' );
							?>
							
						</div><!--.row-fluid-->
					
						<?php 
							//do action to add in top of single
							do_action( 'wps_deals_single_bottom' );
						?>
						
					<?php
				}
				wp_reset_query();
			}
			
			$content .= ob_get_clean();
			
		}
		return $content;
	}
	
	/**
	 * Get Multiple Deal Data
	 * 
	 * Handles to getting multiple deal data on the viewing page
	 * whereever user put shortcode
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0 
	 */
	public function wps_deals_multiple( $atts, $content ) {
		
		ob_start();
		$this->render->wps_deals_multiple_deals( $atts );
		$content .= ob_get_clean();
		return $content;
		
	}
	/**
	 * My Account Page
	 * 
	 * Handles to show my account page for
	 * deals
	 * 
	 * @package Social Deals engine
	 * @since 1.0.0
	 **/
	public function wps_deals_my_account( $atts, $content ) {

		ob_start();
		//when user is logged in then show my account content	
		if( is_user_logged_in() ) { //important
			//do action to show my account page content
			do_action( 'wps_deals_my_account_content' );
		} else {
			//else show log in form
			//do action to show my account page content
			do_action( 'wps_deals_my_account_login_content' );
		}
		$content .= ob_get_clean();
		
		return $content;
	}
	/**
	 * Edit Address Page
	 * 
	 * Handles to edit my address page for
	 * deals
	 * 
	 * @package Social Deals engine
	 * @since 1.0.0
	 **/
	public function wps_deals_edit_address( $atts, $content ) {

		ob_start();
		//when user is logged in then show edit address content	
		if( is_user_logged_in() ) { //important
			//do action to show edit address page content
			do_action( 'wps_deals_edit_address_content' );
		} else {
			//else show log in form
			//do action to show edit address page content
			do_action( 'wps_deals_edit_address_login_content' );
		}
		$content .= ob_get_clean();
		
		return $content;
	}
	/**
	 * Change Password Page
	 * 
	 * Handles to change password page for
	 * deals
	 * 
	 * @package Social Deals engine
	 * @since 1.0.0
	 **/
	public function wps_deals_change_password( $atts, $content ) {

		ob_start();
		//when user is logged in then show change password content	
		if( is_user_logged_in() ) { //important
			//do action to show change password page content
			do_action( 'wps_deals_change_password_content' );
		} else {
			//else show log in form
			//do action to show change password page content
			do_action( 'wps_deals_change_password_login_content' );
		}
		$content .= ob_get_clean();
		
		return $content;
	}
	/**
	 * Lost Password Page
	 * 
	 * Handles to lost password page for
	 * deals
	 * 
	 * @package Social Deals engine
	 * @since 1.0.0
	 **/
	public function wps_deals_lost_password( $atts, $content ) {

		ob_start();
		
		//do action to show lost password page content
		do_action( 'wps_deals_lost_password_content' );
		
		$content .= ob_get_clean();
		
		return $content;
	}
	/**
	 * Adding Hooks
	 *
	 * Adding proper hoocks for the shortcodes.
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		//add shortcode to show list of deals on the page
		add_shortcode( 'wps_deals', 				array( $this, 'wps_deals_all' ) );
		
		//add shortcode for showing shopping cart details
		add_shortcode( 'wps_deals_checkout', 		array( $this, 'wps_deals_checkout' ) );
		
		//add shortcode for order complete
		add_shortcode( 'wps_deals_order_complete', 	array( $this, 'wps_deals_order_complete' ) );
		
		//add shortcode for order cancelled
		add_shortcode( 'wps_deals_order_cancel', 	array( $this, 'wps_deals_order_cancelled' ) );
		 
		//add shortcode for order details
		add_shortcode( 'wps_deals_orders', 			array( $this, 'wps_deals_orders' ) );
		
		//add shortcode to show list of deals on the page/post by category
		add_shortcode( 'wps_deals_by_category', 	array( $this, 'wps_deals_by_category' ) );
		
		//add shortcode to show all social login buttons
		add_shortcode( 'wps_deals_social_login', 	array( $this, 'wps_deals_social_login' ) );
		
		//add shortcode to show single deal on the shortcode page
		add_shortcode( 'wps_deals_by_id', 			array( $this, 'wps_deals_single' ) );
		
		//add shortcode to show multiple deal on the shortcode page
		add_shortcode( 'wps_deals_by_ids', 			array( $this, 'wps_deals_multiple' ) );
		
		//add shortcode to show my account on the shortcode page
		add_shortcode( 'wps_deals_my_account', 		array( $this, 'wps_deals_my_account' ) );
		
		//add shortcode to edit my address on the shortcode page
		add_shortcode( 'wps_deals_edit_address', 	array( $this, 'wps_deals_edit_address' ) );
		
		//add shortcode to change password on the shortcode page
		add_shortcode( 'wps_deals_change_password', array( $this, 'wps_deals_change_password' ) );
		
		//add shortcode to lost password on the shortcode page
		add_shortcode( 'wps_deals_lost_password', array( $this, 'wps_deals_lost_password' ) );
		
	}
}