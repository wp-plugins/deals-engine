<?php
/*
Plugin Name: Social Deals Engine
Plugin URI: http://wpsocial.com/social-deals-engine-plugin-for-wordpress/
Description: Social Deals Engine - A powerful plugin to add real deals of any kind of products and services to your website.
Version: 1.0.2
Author: WPSocial.com
Author URI: http://wpsocial.com

Social Deals Engine is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Social Deals Engine is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Social Deals Engine. If not, see <http://www.gnu.org/licenses/>.
*/ 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Basic plugin definitions 
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

global $wpdb;
if( !defined( 'WPS_DEALS_VERSION' ) ) {
	define( 'WPS_DEALS_VERSION', '1.0.2' ); //version of plugin
}
if( !defined( 'WPS_DEALS_DIR' ) ) {
	define( 'WPS_DEALS_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WPS_DEALS_BASENAME') ) {
	define( 'WPS_DEALS_BASENAME', 'deals-engine' );
}
if( !defined( 'WPS_DEALS_TEMPLATES_PATH' ) ) {
	define( 'WPS_DEALS_TEMPLATES_PATH', WPS_DEALS_DIR . '/includes/templates/' ); // plugin dir
}
if( !defined( 'WPS_DEALS_URL' ) ) {
	define( 'WPS_DEALS_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'WPS_DEALS_ADMIN' ) ) {
	define( 'WPS_DEALS_ADMIN', WPS_DEALS_DIR . '/includes/admin' ); // plugin admin dir
}
if( !defined( 'WPS_DEALS_GATEWAYS_DIR' ) ) {
	define( 'WPS_DEALS_GATEWAYS_DIR', WPS_DEALS_DIR . '/includes/gateways' ); // plugin gateways dir
}
if( !defined( 'WPS_DEALS_PAGE_BASENAME' ) )  {
	define( 'WPS_DEALS_PAGE_BASENAME', 'wpsdeals' ); // base name for plugin settings and licensing
}
if( !defined( 'WPS_DEALS_META_DIR' ) ) {
	define( 'WPS_DEALS_META_DIR', WPS_DEALS_DIR . '/includes/meta-boxes' ); // path to meta boxes
}
if( !defined( 'WPS_DEALS_META_URL' ) ) {
	define( 'WPS_DEALS_META_URL', WPS_DEALS_URL . 'includes/meta-boxes' ); // path to meta boxes
}
if( !defined( 'WPS_DEALS_META_PREFIX' ) ) {
	define( 'WPS_DEALS_META_PREFIX', '_wps_deals_' ); // meta box prefix
}
if( !defined( 'WPS_DEALS_POST_TYPE' ) ) {
	define( 'WPS_DEALS_POST_TYPE', 'wpsdeals' ); // custom post type's slug
}
if( !defined( 'WPS_DEALS_POST_TAGS' ) ) {
	define( 'WPS_DEALS_POST_TAGS', 'wpsdealtags' ); // custom post type's tags slug
}
if( !defined( 'WPS_DEALS_POST_TAXONOMY' ) ) {
	define( 'WPS_DEALS_POST_TAXONOMY', 'wpsdealcategories' ); // custom post type's taxonomy slug
}
if( !defined( 'WPS_DEALS_SALES_POST_TYPE' ) ) {
	define( 'WPS_DEALS_SALES_POST_TYPE', 'wpsdealssales' ); // custom post deals sales type's taxonomy slug
}
if( !defined( 'WPS_DEALS_PAYPAL_GATEWAY' )) {
	define( 'WPS_DEALS_PAYPAL_GATEWAY',__( 'PayPal', 'wpsdeals' ) ); // paypal gateway
}
if( !defined( 'WPS_DEALS_POST_TYPE_SLUG' )) {
	define( 'WPS_DEALS_POST_TYPE_SLUG', 'deals');
}
if( !defined( 'WPS_DEALS_PAYMENT_PAGE_TITLE' )) {
	define( 'WPS_DEALS_PAYMENT_PAGE_TITLE', __('Payment Process','wpsdeals'));
}
if( !defined( 'WPS_DEALS_TESTMODE_GATEWAY' )) {
	define( 'WPS_DEALS_TESTMODE_GATEWAY', __('Test Mode','wpsdeals'));
}
if( !defined( 'WPS_DEALS_PLUGIN_NAME' )) {
	define( 'WPS_DEALS_PLUGIN_NAME', __('Social Deals Engine','wpsdeals'));
}
if( !defined( 'WPS_DEALS_LOGS_POST_TYPE' )) {
	define( 'WPS_DEALS_LOGS_POST_TYPE', 'wpsdealslogs');
}
if( !defined( 'WPS_DEALS_LOGS_TAXONOMY' )) { //taxonomy for log
	define( 'WPS_DEALS_LOGS_TAXONOMY', 'wpsdealslogtype');
}
if( !defined( 'WPS_DEALS_SOCIAL_DIR' ) ) { //social liberary dir
	define( 'WPS_DEALS_SOCIAL_DIR', WPS_DEALS_DIR . '/includes/social' );
}
if( !defined( 'WPS_DEALS_SOCIAL_URL' ) ) { //social liberary dir
	define( 'WPS_DEALS_SOCIAL_URL', WPS_DEALS_URL . 'includes/social' );
}
if( !defined( 'WPS_DEALS_SOCIAL_LIB_DIR' ) ) { //social liberary dir
	define( 'WPS_DEALS_SOCIAL_LIB_DIR', WPS_DEALS_DIR . '/includes/social/libraries' );
}
if( !defined( 'WPS_DEALS_SOCIAL_LIB_URL' ) ) { //social liberary dir
	define( 'WPS_DEALS_SOCIAL_LIB_URL', WPS_DEALS_URL . 'includes/social/libraries' );
}
/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_load_textdomain() {

  load_plugin_textdomain( 'wpsdeals', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}

add_action( 'init', 'wps_deals_load_textdomain' ); 

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

register_activation_hook( __FILE__, 'wps_deals_install' );


/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

register_deactivation_hook( __FILE__, 'wps_deals_uninstall');

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup,
 * stest default values for the plugin options.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_install() {
	
	global $wpdb,$user_ID;
	
	//register custom post type
	wps_deals_register_deal_post_type();
	wps_deals_register_sales_post_types();
	
	//IMP Call of Function
	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
	
	//add capabilities to administrator roles
	wps_deals_add_capabilities();
	
	//get option for when plugin is activating first time
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	//get all option for the plugin
	$wps_deals_options = get_option( 'wps_deals_options' );
	
	if( empty( $wps_deals_options ) ) { //check plugin version option
		
		$deals_page = array(
								'post_type' 	=> 'page',
								'post_status' 	=> 'publish',
								'post_title' 	=> __('Social Deals','wpsdeals'),
								'post_content' 	=> '[wps_deals][/wps_deals]',
								'post_author' 	=> $user_ID,
								'menu_order' 	=> 0,
								'comment_status' => 'closed'
							);
							
		//create main page for plugin					
		$deals_parent_page_id = wp_insert_post($deals_page);
		
		// thank you page creation
		$deals_thank_you = array(
									'post_type' => 'page',
									'post_status' => 'publish',
									'post_parent' => $deals_parent_page_id,
									'post_title' => __('Social Deals Thank You Page','wpsdeals'),
									'post_content' => '[wps_deals_order_complete][/wps_deals_order_complete]',
									'post_author' => $user_ID,
									'comment_status' => 'closed'
								);
		//create thank you page						
		$thank_you_page_id = wp_insert_post($deals_thank_you);
		
		// cancel page creation
		$deals_cancel = array(
									'post_type' => 'page',
									'post_status' => 'publish',
									'post_parent' => $deals_parent_page_id,
									'post_title' => __('Social Deals Cancel Page','wpsdeals'),
									'post_content' => '[wps_deals_order_cancel][/wps_deals_order_cancel]',
									'post_author' => $user_ID,
									'comment_status' => 'closed'
								);
		//create cancel page				
		$cancel_page_id = wp_insert_post($deals_cancel);
		
		// checkout page creation 
		$checkout_page = array(
										
									'post_type' => 'page',
									'post_status' => 'publish',
									'post_parent' => $deals_parent_page_id,
									'post_title' => __('Social Deals Checkout','wpsdeals'),
									'post_content' => '[wps_deals_checkout][/wps_deals_checkout]',
									'post_author' => $user_ID,
									'comment_status' => 'closed'
								);
		$checkout_page_id = wp_insert_post($checkout_page);
		
		//create my account page
		$deals_myaccount_page = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_title' 	=> __('My Account','wpsdeals'),
											'post_content' 	=> '[wps_deals_my_account][/wps_deals_my_account]',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
		//create my account page
		$myaccount_page_id = wp_insert_post( $deals_myaccount_page );
		
		//order details page createion
		$order_details_page = array(
										'post_type'		=>	'page',
										'post_status'	=>	'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title'	=>	__('View Orders','wpsdeals'),
										'post_content'	=>	'[wps_deals_orders][/wps_deals_orders]',
										'post_author'	=>	$user_ID,
										'comment_status'=>	'closed'
									);
		$order_details_id  = wp_insert_post( $order_details_page );
		
		//create change password page
		$deals_edit_address_args = array(
										'post_type' 	=> 'page',
										'post_status' 	=> 'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title' 	=> __( 'Edit Address','wpsdeals' ),
										'post_content' 	=> '[wps_deals_edit_address][/wps_deals_edit_address]',
										'post_author' 	=> $user_ID,
										'menu_order' 	=> 0,
										'comment_status' => 'closed'
									);
							
		//create edit addresses
		$edit_address_id = wp_insert_post( $deals_edit_address_args );
		
		//create change password page
		$deals_change_pass_args = array(
										'post_type' 	=> 'page',
										'post_status' 	=> 'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title' 	=> __( 'Change Password','wpsdeals' ),
										'post_content' 	=> '[wps_deals_change_password][/wps_deals_change_password]',
										'post_author' 	=> $user_ID,
										'menu_order' 	=> 0,
										'comment_status' => 'closed'
									);
							
		//create change password page
		$change_password_id = wp_insert_post( $deals_change_pass_args );
		
		//create logout page
		$deals_logout_args = array(
										'post_type' 	=> 'page',
										'post_status' 	=> 'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title' 	=> __( 'Logout','wpsdeals' ),
										'post_content' 	=> '',
										'post_author' 	=> $user_ID,
										'menu_order' 	=> 0,
										'comment_status' => 'closed'
									);
							
		//create logout page
		$logout_id = wp_insert_post( $deals_logout_args );
		
		//create lost password page
		$deals_lost_pass_args = array(
										'post_type' 	=> 'page',
										'post_status' 	=> 'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title' 	=> __( 'Lost Password','wpsdeals' ),
										'post_content' 	=> '[wps_deals_lost_password][/wps_deals_lost_password]',
										'post_author' 	=> $user_ID,
										'menu_order' 	=> 0,
										'comment_status' => 'closed'
									);
		//create lost password page
		$lost_pass_page_id = wp_insert_post( $deals_lost_pass_args );
		
		// this option contains all page ID(s) to just pass it to wps_deals_default_settings function
		update_option( 'wps_deals_set_pages', array(
														'main_page'			=> 	$deals_parent_page_id,
														'thank_you_page'	=>	$thank_you_page_id,
														'cancel_page'		=>	$cancel_page_id,
														'checkout_page'		=>	$checkout_page_id,
														'order_details'		=>	$order_details_id,
														'my_account_page'	=>	$myaccount_page_id,
														'edit_adderess'		=>	$edit_address_id,
														'change_password'	=>	$change_password_id,
														'logout'			=>	$logout_id,
														'lost_password'		=>	$lost_pass_page_id
													));
									
		// set default settings
		wps_deals_default_settings();
		
		//update plugin version to option 
		update_option( 'wps_deals_set_option', '1.0' );
		
		//update countires to database
		wps_deals_update_countries();
		
	} //check deals options empty or not 
	
	if( $wps_deals_set_option == '1.0' ) { //check set option for plugin is set 1.0
		 			
		$udpopt = false;
		if( !isset( $wps_deals_options['default_payment_gateway'] ) ) { //check default gateway is set or not
			$defaultgateway = array( 'default_payment_gateway'=> 'paypal' );
			$wps_deals_options = array_merge( $wps_deals_options, $defaultgateway );
			$udpopt = true;
		}
		if( !isset( $wps_deals_options['caching'] ) ) { //check caching is set or not
			$caching = array( 'caching'=> '' );
			$wps_deals_options = array_merge( $wps_deals_options, $caching );
			$udpopt = true;
		}
		if( !isset( $wps_deals_options['cheque_customer_msg'] ) ) { //check Customer Message is set or not
			$cheque_customer_msg = array( 'cheque_customer_msg'=> __( 'Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.', 'wpsdeals' ) );
			$wps_deals_options = array_merge( $wps_deals_options, $cheque_customer_msg );
			$udpopt = true;
		}
		if( !isset( $wps_deals_options['login_heading'] ) ) { //check Social Login Title is set or not
			$login_heading = array( 'login_heading'=> __( 'Login with Social Media', 'wpsdeals' ) );
			$wps_deals_options = array_merge( $wps_deals_options, $login_heading );
			$udpopt = true;
		}
		if( !isset( $wps_deals_options['login_redirect_url'] ) ) { //check Redirect URL is set or not
			$login_redirect_url = array( 'login_redirect_url'=> '' );
			$wps_deals_options = array_merge( $wps_deals_options, $login_redirect_url );
			$udpopt = true;
		}
		if( !isset( $wps_deals_options['email_template'] ) ) { //check Email Template is set or not
			$email_template = array( 'email_template'=> '' );
			$wps_deals_options = array_merge( $wps_deals_options, $email_template );
			$udpopt = true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated 				
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		//update plugin version to option 
		update_option( 'wps_deals_set_option', '1.0.1' );
		
	} //check plugin set option value is 1.0
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.1' ) {
		
		$udpopt = false;
		//check enable billin is set in options or not
		if( !isset( $wps_deals_options['enable_billing'] ) ) {
			$billing = array( 'enable_billing'=> '' );
			$wps_deals_options = array_merge( $wps_deals_options, $billing );
			$udpopt = true;
		}
		//create my account page & its child pages and move the order details page
		if( !isset( $wps_deals_options['my_account_page'] ) ) {
		
			$deals_myaccount_page = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_title' 	=> __( 'My Account','wpsdeals' ),
											'post_content' 	=> '[wps_deals_my_account][/wps_deals_my_account]',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
								
			//create my account page
			$myaccount_page_id = wp_insert_post( $deals_myaccount_page );
			
			//create edit addresses page
			$deals_edit_address_args = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_parent'	=>	$myaccount_page_id,
											'post_title' 	=> __( 'Edit Address','wpsdeals' ),
											'post_content' 	=> '[wps_deals_edit_address][/wps_deals_edit_address]',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
			//create edit addresses
			$edit_address_id = wp_insert_post( $deals_edit_address_args );
			
			//create change password page
			$deals_change_pass_args = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_parent'	=>	$myaccount_page_id,
											'post_title' 	=> __( 'Change Password','wpsdeals' ),
											'post_content' 	=> '[wps_deals_change_password][/wps_deals_change_password]',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
								
			//create change password page
			$change_password_id = wp_insert_post( $deals_change_pass_args );
			
			//create logout page
			$deals_logout_args = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_parent'	=>	$myaccount_page_id,
											'post_title' 	=> __( 'Logout','wpsdeals' ),
											'post_content' 	=> '',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
								
			//create logout page
			$logout_id = wp_insert_post( $deals_logout_args );
			
			//create lost password page
			$deals_lost_pass_args = array(
											'post_type' 	=> 'page',
											'post_status' 	=> 'publish',
											'post_parent'	=>	$myaccount_page_id,
											'post_title' 	=> __( 'Lost Password','wpsdeals' ),
											'post_content' 	=> '[wps_deals_lost_password][/wps_deals_lost_password]',
											'post_author' 	=> $user_ID,
											'menu_order' 	=> 0,
											'comment_status' => 'closed'
										);
			//create lost password page
			$lost_pass_page_id = wp_insert_post( $deals_lost_pass_args );
			
			//get set pages option data
			$wps_deals_set_pages = get_option( 'wps_deals_set_pages' );
			
			//store my account page to already created page
			$wps_deals_set_pages['my_account_page'] = $myaccount_page_id;
			$wps_deals_set_pages['edit_adderess'] 	= $edit_address_id;
			$wps_deals_set_pages['change_password'] = $change_password_id;
			$wps_deals_set_pages['logout'] 			= $logout_id;
			$wps_deals_set_pages['lost_password'] 	= $lost_pass_page_id;
			
			//update new pages data
			update_option( 'wps_deals_set_pages', $wps_deals_set_pages );
			
			//update order details page to child of my account page
			wp_update_post( array( 
									'ID' => $wps_deals_set_pages['order_details'],
									'post_parent' => $myaccount_page_id,
									'post_name' => 'view-orders',
									'post_title' => __( 'View Orders', 'wpsdeals' )
								) );
			
			$myaccountpage = array( 
									'my_account_page'	=>	$myaccount_page_id,
									'edit_adderess'		=>	$edit_address_id,
									'change_password'	=>	$change_password_id,
									'logout'			=>	$logout_id,
									'lost_password'		=>	$lost_pass_page_id
								);
			$wps_deals_options = array_merge( $wps_deals_options, $myaccountpage );
			$udpopt = true;
			
		} //end if to check my account page
		
		//check reset password email subject is set in options or not
		if( !isset( $wps_deals_options['reset_password_email_subject'] ) ) {
			$email_subject = array( 'reset_password_email_subject'=> __('Reset Password','wpsdeals') );
			$wps_deals_options = array_merge( $wps_deals_options, $email_subject );
			$udpopt = true;
		}
		
		//check reset password email body is set in options or not
		if( !isset( $wps_deals_options['reset_password_email'] ) ) {
			$email_sbody = array( 'reset_password_email'=> __('Someone requested that the password be reset for the following account:'."\n\n".'Username: {user_name}'."\n\n".'If this was a mistake, just ignore this email and nothing will happen.'."\n\n".'To reset your password, visit the following address:'."\n\n".'{reset_link}','wpsdeals') );
			$wps_deals_options = array_merge( $wps_deals_options, $email_sbody );
			$udpopt = true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated 				
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		//update plugin version to option 
		update_option( 'wps_deals_set_option', '1.0.2' );
		
	} //check plugin set option value is 1.0.1
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.2' ) {
		
		// future code will be done here
		
	} //check plugin set option value is 1.0.2
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Delete  plugin options.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_uninstall() {
	
	global $wpdb,$wps_deals_options;
	
	//register custom post type
	wps_deals_register_deal_post_type();
	wps_deals_register_sales_post_types();
	
	//IMP Call of Function
	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
	
	//$wps_deals_options = get_option('wps_deals_options');
	
	if( isset($wps_deals_options['del_all_options'] ) && !empty( $wps_deals_options['del_all_options'] ) 
		&& $wps_deals_options['del_all_options'] == '1' ) {
		
		//remove capabilities to administrator roles
		wps_deals_remove_capabilities();
		
		//delete option
		delete_option('wps_deals_options');
		
		//delete country option
		delete_option('wps_deals_countries');
		
		
		//get all page ID(s) which are created when plugin is activating first time
		$pages = get_option('wps_deals_set_pages');
			wp_delete_post( $pages['thank_you_page'],true );//delete thank you page
			wp_delete_post( $pages['cancel_page'],true );//delete cancel page
			wp_delete_post( $pages['checkout_page'],true );//delete order page
			wp_delete_post( $pages['main_page'],true );//delete main page
			wp_delete_post( $pages['order_details'],true );//delete order details page
			wp_delete_post( $pages['my_account_page'],true );//delete my account page
			wp_delete_post( $pages['edit_adderess'],true );//delete edit address page
			wp_delete_post( $pages['change_password'],true );//delete change password page
			wp_delete_post( $pages['logout'],true );//delete logout page
			wp_delete_post( $pages['lost_password'],true );//delete lost password page
		
		//delete option which is check the plugin is activation first time
		delete_option('wps_deals_set_option');
		
		//delete option for pages
		delete_option('wps_deals_set_pages');
			
		//delete custom main post data
		$mainargs = array( 'post_type' => WPS_DEALS_POST_TYPE, 'numberposts' => '-1', 'post_status' => 'any' );
		$mainpostdata = get_posts( $mainargs );
		
		foreach ( $mainpostdata as $post ) {
			wp_delete_post( $post->ID,true );
		}
		
		//delete sales post data
		$saleargs = array( 'post_type' => WPS_DEALS_SALES_POST_TYPE, 'numberposts' => '-1', 'post_status' => 'any' );
		$salesdata = get_posts( $saleargs );
		
		foreach ( $salesdata as $sale ) {
			wp_delete_post( $sale->ID,true );
		}
		
		//delete all categories which are created
		$catargs = array(	
							'type'		 	=> 'post',
							'child_of'	 	=> '0',
							'parent'     	=> '',
							'orderby'    	=> 'name',
							'order'      	=> 'ASC',
							'hide_empty' 	=> '0',
							'hierarchical'	=> '1',
							'exclude'		=> '',
							'include'       => '',
							'number'        => '',
							'taxonomy'      => WPS_DEALS_POST_TAXONOMY,
							'pad_counts'    => false 
						);
						
		$allcategories = get_categories( $catargs );
		foreach ( $allcategories as $category ) {
			wp_delete_term( $category->term_id, WPS_DEALS_POST_TAXONOMY );
		}
		
		//delete tags data
		$tagsargs = array(	
							'type'		 	=> 'post',
							'child_of'	 	=> '0',
							'parent'     	=> '',
							'orderby'    	=> 'name',
							'order'      	=> 'ASC',
							'hide_empty' 	=> '0',
							'hierarchical'	=> '1',
							'exclude'		=> '',
							'include'       => '',
							'number'        => '',
							'taxonomy'      => WPS_DEALS_POST_TAGS,
							'pad_counts'    => false 
						);
		$alltags = get_categories( $tagsargs );
		foreach ( $alltags as $tag ) {
			wp_delete_term( $tag->term_id, WPS_DEALS_POST_TAGS );
		}
		
		//delete logs data
		$logargs = array( 'post_type' => WPS_DEALS_LOGS_POST_TYPE, 'numberposts' => '-1', 'post_status' => 'any' );
		$logdata = get_posts( $logargs );
		
		foreach ( $logdata as $log ) {
			wp_delete_post( $log->ID,true );
		}
		
		//delete all logs taxonomy data which are created
		$logcatargs = array(	
							'type'		 	=> 'post',
							'child_of'	 	=> '0',
							'parent'     	=> '',
							'orderby'    	=> 'name',
							'order'      	=> 'ASC',
							'hide_empty' 	=> '0',
							'hierarchical'	=> '1',
							'exclude'		=> '',
							'include'       => '',
							'number'        => '',
							'taxonomy'      => WPS_DEALS_LOGS_TAXONOMY,
							'pad_counts'    => false 
						);
		$alllogcats = get_categories( $logcatargs );
		
		foreach ( $alllogcats as $logcat ) {
			wp_delete_term( $logcat->term_id, WPS_DEALS_LOGS_TAXONOMY );
		}
		
	}
}

/**
 * Plugin Setup (On First Time Activation)
 *
 * Does the initial setup when plugin is going to activate first time,
 * stest default values for the plugin options.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_default_settings() {
	
	global $wps_deals_options;
	
	//get values for created pages
	$pages = get_option('wps_deals_set_pages');
	
	//default for all created pages
	$mainpage = $thank_you = $cancel = $checkout = $orderedpage = $myaccountpage = $editaddresspage = $changepasspage = $logoutpage = $lostpasspage = '';
	
	//check pages are created or not
	if( !empty( $pages ) ) {
		
		//check if thank you page is created then set to default
		if ( isset( $pages['thank_you_page'] ) ) { $thank_you = $pages['thank_you_page'];}
		//check if cancel page is created then set to default
		if ( isset( $pages['cancel_page'] ) ) {	$cancel = $pages['cancel_page']; }
		//check if checkout page is created then set to default
		if ( isset( $pages['checkout_page'] ) ) { $checkout = $pages['checkout_page']; }
		//check if checkout page is created then set to default
		if( isset( $pages['main_page'] ) ) { $mainpage = $pages['main_page']; }
		//check order details page is create then set to default
		if( isset( $pages['order_details'] ) ) { $orderedpage = $pages['order_details']; }
		//check my account page is created then set to default
		if( isset( $pages['my_account_page'] ) ) { $myaccountpage = $pages['my_account_page']; }
		//check edit address page is created then set to default
		if( isset( $pages['edit_adderess'] ) ) { $editaddresspage = $pages['edit_adderess']; }
		//check change password page is created then set to default
		if( isset( $pages['change_password'] ) ) { $changepasspage = $pages['change_password'];	}
		//check logout page is created then set to default
		if( isset( $pages['logout'] ) ) { $logoutpage = $pages['logout'];	}
		//check edit address page is created then set to default
		if( isset( $pages['lost_password'] ) ) { $lostpasspage = $pages['lost_password']; }
	}
	
	$wps_deals_options = array(
								'del_all_options'				=>	'',
								'disable_twitter_bootstrap'		=>	'',
								'deals_size'					=>	'large',
								'disable_more_deals'			=>	'',
								'ending_deals_in'				=>	'5',
								'upcoming_deals_in'				=>	'5',
								'deals_per_page'				=>	'10',
								'payment_gateways'				=>	array('paypal'),
								'paypal_merchant_email'			=>	'',
								'enable_testmode'				=>	'',
								'enable_debug'					=>	'',
								'from_email'					=>	get_option( 'blogname' ) . ' <' . get_option( 'admin_email' ) . '>',
								'buyer_email_subject'			=>	__('Purchase Receipt','wpsdeals'),
								'buyer_email_body'				=>	__('Dear {first_name}'."\n\n".'Thank you for your purchase. Please click on the link(s) below to download your files.'."\n\n".'Product Details : {product_details}'."\n\n".'Total: {total}'."\n\n".'Thank you','wpsdeals'),
								'notif_email_address'			=>	get_option('admin_email'),
								'disable_seller_notif'			=>	'',
								'seller_email_subject'			=>	__('New deal purchase','wpsdeals'),
								'seller_email_body'				=>	__('Hello'."\n\n".'A deals purchase has been made.'."\n\n".'Deals sold:{product_details}'."\n\n".'Purchased by: {username}'."\n\n".'Total: {total}'."\n\n".'Payment Method: {payment_method}'."\n\n".'Thank you','wpsdeals'),
								'reset_password_email_subject'	=>	__('Reset Password','wpsdeals'),
								'reset_password_email'			=>	__('Someone requested that the password be reset for the following account:'."\n\n".'Username: {user_name}'."\n\n".'If this was a mistake, just ignore this email and nothing will happen.'."\n\n".'To reset your password, visit the following address:'."\n\n".'{reset_link}','wpsdeals'),
								'currency'						=>	'USD',
								'payment_thankyou_page'			=> $thank_you,
								'payment_cancel_page'			=> $cancel,
								'payment_checkout_page'			=> $checkout,
								'deals_main_page'				=> $mainpage,
								'ordered_page'					=> $orderedpage,
								'my_account_page'				=> $myaccountpage,
								'edit_adderess'					=> $editaddresspage,
								'change_password'				=> $changepasspage,
								'logout'						=> $logoutpage,
								'lost_password'					=> $lostpasspage,
								'show_login_register'			=> '',
								'disable_guest_checkout'		=> '',
								'currency_position'				=> 'before',
								'thounsands_seperator'			=> ',',
								'decimal_seperator'				=> '.',
								'decimal_places'				=> '2',
								'social_buttons'				=> array('facebook'),
								'add_to_cart_text'				=> __( 'Add to Cart','wpsdeals' ),
								'redirect_to_checkout'			=> '',
								'link_expiration'				=> '',
								'per_page'						=> '10',
								'enable_terms'					=> '',
								'terms_label'					=> '',
								'terms_content'					=> '',
								'update_order_email_subject'	=> __( 'Order Update','wpsdeals' ),
								'update_order_email'			=> __( 'Order ID : {order_id}'."\n\n".'Order Date :{order_date}'."\n\n".'Your order has been updated to the following status.'."\n\n".'New status: {status}' ,'wpsdeals' ),
								'tw_user_name'					=> '',
								'custom_css'					=> '',
								'paypal_api_user'				=> '',
								'paypal_api_pass'				=> '',
								'paypal_api_sign'				=> '',
								'file_download_limit'			=> '',
								'enable_facebook'				=> '',
								'fb_app_id'						=> '',
								'fb_app_secret'					=> '',
								'fb_language'					=> 'en_US',
								'fb_redirect_url'				=> '',
								'fb_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/facebook.png',
								'enable_gplus'					=> '',
								'gplus_client_id'				=> '',
								'gplus_client_secret'			=> '',
								'gplus_icon_url'				=> WPS_DEALS_SOCIAL_URL.'/images/google_plus.png',
								'enable_twitter'				=> '',
								'tw_consumer_key'				=> '',
								'tw_consumer_secrets'			=> '',
								'tw_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/twitter.png',
								'enable_linkedin'				=> '',
								'li_app_id'						=> '',
								'li_app_secret'					=> '',
								'li_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/linkedin.png',
								'enable_yahoo'					=> '',
								'yh_consumer_key'				=> '',
								'yh_consumer_secrets'			=> '',
								'yh_app_id'						=> '',
								'yh_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/yahoo.png',
								'enable_foursquare'				=> '',
								'fs_client_id'					=> '',
								'fs_client_secrets'				=> '',
								'fs_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/foursquare.png',
								'enable_windowslive'			=> '',
								'wl_client_id'					=> '',
								'wl_client_secrets'				=> '',
								'wl_icon_url'					=> WPS_DEALS_SOCIAL_URL.'/images/windowslive.png',
								'social_order'					=> array('facebook','twitter','googleplus','linkedin','yahoo','foursquare','windowslive'),
								'default_payment_gateway'		=> 'paypal',
								'caching'						=> '',
								'cheque_customer_msg'			=> __( 'Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.', 'wpsdeals' ),
								'login_heading'					=> __( 'Login with Social Media', 'wpsdeals' ),
								'login_redirect_url'			=> '',
								'email_template'				=> '',
								'enable_billing'				=> ''
							);
	
	$default_options = apply_filters('wps_deals_options_values',$wps_deals_options );
	
	//update default options
	update_option( 'wps_deals_options', $default_options );
	
	//overwrite global variable when option is update
	$wps_deals_options = wps_deals_get_settings();
}

/**
 * Settings Link
 *
 * Adds a settings link to the plugin list.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
 
function wps_deals_add_settings_link( $links, $file ) {

	static $this_plugin;
	if ( !$this_plugin ) $this_plugin = plugin_basename( __FILE__ );
	if ( $file == $this_plugin ) {
		$settings_link = '<a href="admin.php?page=wps-deals-settings">' . __( 'Settings', 'wpsdeals' ) . '</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}
//adding setting link below plugin name in plugins list
add_filter( 'plugin_action_links', 'wps_deals_add_settings_link', 10, 2 );

/**
 * WPSocial Admin Bar
 *
 * Add WPSocial options drop down menu to the admin bar.
 * all other plugins will have a submenu in there.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
if ( !function_exists( 'wps_plugins_adminbar' ) ) {

	function wps_plugins_adminbar() {

		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu( array(
			
			'id' => 'wps_plugins_options',
			'title' => 'WPSocial'
		));
	}
}

/**
 * Start Session
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_start_session() {
	
	if( !session_id() ) { 
		session_start();
	}
}

/**
 * Check if current page is edit page.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_is_edit_page() {

	global $pagenow;
	return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

/**
 * Global Variables
 * 
 * Declaration of some needed global varibals for plugin
 *
 * @package Social Deals Engine
 * @since 1.0.0
 * 
 */

global	$wps_deals_model,$wps_deals_scripts,$wps_deals_render,
		$wps_deals_paypal,$wps_deals_cart,$wps_deals_currency,
		$wps_deals_price,$wps_deals_codes,$wps_deals_message,
		$wps_deals_options,$wps_deals_logs,$wps_deals_shortcode,
		$wps_deals_public,$wps_deals_admin,$wps_deals_metabox,
		$wps_deals_payment_log;

/**
 * Includes Files
 * 
 * Includes some required files for plugin
 *
 * @package Social Deals Engine
 * @since 1.0.0
 * 
 */


// loads the Misc Functions file
require_once ( WPS_DEALS_DIR . '/includes/wps-deals-countries-states.php' );

// loads the Misc Functions file
require_once ( WPS_DEALS_DIR . '/includes/wps-deals-misc-functions.php' );
$wps_deals_options = wps_deals_get_settings();
wps_deals_initialize();

include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-message-stack.php'); // message class, handles the messages after review submission
$wps_deals_message = new Wps_Deals_Message_Stack();

//Logs Class
require_once( WPS_DEALS_DIR .'/includes/class-wps-deals-logging.php' );
$wps_deals_logs = new Wps_Deals_Logging();

//Currencies class handles most of functionalities of plugin
include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-currencies.php' );
$wps_deals_currency = new Wps_Deals_Currencies();

//Price class handles most of plugin related to price
include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-price.php' );
$wps_deals_price = new Wps_Deals_Price();

//Model class handles most of functionalities of plugin
include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-model.php' );
$wps_deals_model = new Wps_Deals_Model();

include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-scripts.php' ); // script class, handles all the scripts and css
$wps_deals_scripts = new Wps_Deals_Scripts();
$wps_deals_scripts->add_hooks();

//Download Functions
require_once( WPS_DEALS_DIR . '/includes/wps-deals-download-functions.php' );

//Logs Functions File
require_once( WPS_DEALS_ADMIN . '/logs/wps-deals-logs-functions.php');

//Shopping Cart class handles most of functionalities of cart
include_once( WPS_DEALS_DIR . '/includes/class-wps-deals-shopping-cart.php' );
$wps_deals_cart = new Wps_Deals_Shopping_Cart();

//includes paypal class file
require_once( WPS_DEALS_GATEWAYS_DIR . '/libraries/class-wps-deals-paypal.php'); 
$wps_deals_paypal = new Wps_Deals_Paypal();

//includes paypal class file
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-logger.php'); 
$wps_deals_payment_log = new Wps_Deals_Payment_Log();

//includes paypal payments class
require_once( WPS_DEALS_GATEWAYS_DIR . '/paypal-standard.php');

//loads the gateways functions
require_once( WPS_DEALS_GATEWAYS_DIR . '/functions.php');

//Render class to handles most of html design for plugin
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-renderer.php' );
$wps_deals_render = new Wps_Deals_Renderer();

//Shortcodes class for handling shortcodes
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-shortcodes.php' );
$wps_deals_shortcode = new Wps_Deals_Shortcodes();
$wps_deals_shortcode->add_hooks();

//Public Pages Class for handling front side functionalities
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-public-pages.php' );
$wps_deals_public = new Wps_Deals_Public_Pages();
$wps_deals_public->add_hooks();

//Admin Pages Class for admin site
require_once( WPS_DEALS_ADMIN . '/class-wps-deals-admin.php' );
$wps_deals_admin = new Wps_Deals_AdminPages();
$wps_deals_admin->add_hooks();

if( wps_deals_is_edit_page() ) {
	
	//include the meta functions file for metabox
	require_once ( WPS_DEALS_META_DIR . '/wps-deals-meta-box-functions.php' );
	
	//include the main class file for metabox
	require_once ( WPS_DEALS_META_DIR . '/class-wps-deals-meta-box.php' );
	$wps_deals_metabox = new Wps_Deals_Meta_Box();
	$wps_deals_metabox->add_hooks();
}

//Post type to handle custom post type
require_once( WPS_DEALS_DIR . '/includes/wps-deals-post-types.php' );

//Pagination Class
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-pagination-public.php' ); // front end pagination class

// loads the Templates Functions file
require_once ( WPS_DEALS_DIR . '/includes/wps-deals-template-functions.php' );

// Loads the download process file
require_once( WPS_DEALS_DIR . '/includes/wps-deals-download-process.php');

//Register Widget
require_once( WPS_DEALS_DIR . '/includes/widgets/class-wps-deals-lists.php');

//Register Cart Deals Widget
require_once( WPS_DEALS_DIR . '/includes/widgets/class-wps-deals-latest-products-cart.php');

//Loads the dashboard widgets file
require_once( WPS_DEALS_DIR . '/includes/widgets/wps-deals-dashboard-widgets.php');

//Export to CSV files
require_once( WPS_DEALS_DIR . '/includes/exports/wps-deals-exports.php');

//Generate to PDF files
require_once( WPS_DEALS_DIR . '/includes/exports/wps-deals-sales-generate-pdf.php');

//include payment process file
require_once( WPS_DEALS_DIR . '/includes/wps-deals-payment-process.php' );

//View reports page
require_once( WPS_DEALS_ADMIN . '/reports/view-reports.php');

//include cheque payment gateway file
require_once( WPS_DEALS_GATEWAYS_DIR . '/cheque.php');

//include payment gateway test mode file
require_once( WPS_DEALS_GATEWAYS_DIR . '/testmode.php');

//Social Login File
require_once( WPS_DEALS_SOCIAL_DIR .'/wps-deals-social.php');

//Load Template Hook File
require_once( WPS_DEALS_DIR . '/includes/wps-deals-template-hooks.php' );

//add action init for starting a session
add_action( 'init', 'wps_deals_start_session');

//add action to delete log
add_action( 'delete_post', array( $wps_deals_model,'wps_deals_remove_logs_on_delete' ) );

?>