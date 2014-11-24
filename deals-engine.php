<?php
/**
 * Plugin Name: Social Deals Engine
 * Plugin URI: http://wpsocial.com/social-deals-engine-plugin-for-wordpress/
 * Description: Social Deals Engine - A powerful plugin to add real deals of any kind of products and services to your website.
 * Version: 2.0.4
 * Author: WPSocial.com
 * Author URI: http://wpsocial.com
 * 
 * Social Deals Engine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * 
 * Social Deals Engine is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Social Deals Engine. If not, see <http://www.gnu.org/licenses/>.
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
	define( 'WPS_DEALS_VERSION', '2.0.4' ); //version of plugin
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

if ( ! defined( 'WPS_DEALS_LOG_DIR' ) ) {
	define( 'WPS_DEALS_LOG_DIR', ABSPATH . 'sde-logs/' );
}

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
load_plugin_textdomain( 'wpsdeals', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Admin Warning
 * 
 * This will output a warning message, if the main plugin isn't activated.
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_admin_notice() {
	
	//check Woocommerce is activated
	if( class_exists( 'Woocommerce' ) ) {
		
		$woo_link = '<a target="_BLANK" href="http://wpsocial.com/product/woocommerce-deals-extension/">WPSocial.com</a>';
		
		echo '<div class="error">';
		echo "<p><strong>" . sprintf( __( 'We noticed, that you have WooCommerce installed. For that we recommend, that you\'re using the Deals Extension for WooCommerce available here: %s .', 'wpsdeals' ), $woo_link ) . "</strong></p>";
		echo '</div>';
	}
}
add_action( 'admin_notices', 'wps_deals_admin_notice' );

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
		
		//create an account page creation
		$create_account_page = array(
										'post_type'		=>	'page',
										'post_status'	=>	'publish',
										'post_parent'	=>	$myaccount_page_id,
										'post_title'	=>	__('Create an Account','wpsdeals'),
										'post_content'	=>	'[wps_deals_create_account][/wps_deals_create_account]',
										'post_author'	=>	$user_ID,
										'comment_status'=>	'closed'
									);
		$create_account_id  = wp_insert_post( $create_account_page );
		
		//order details page creation
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
														'main_page'				=> 	$deals_parent_page_id,
														'thank_you_page'		=>	$thank_you_page_id,
														'cancel_page'			=>	$cancel_page_id,
														'checkout_page'			=>	$checkout_page_id,
														'order_details'			=>	$order_details_id,
														'my_account_page'		=>	$myaccount_page_id,
														'create_account_page'	=>	$create_account_id,
														'edit_adderess'			=>	$edit_address_id,
														'change_password'		=>	$change_password_id,
														'logout'				=>	$logout_id,
														'lost_password'			=>	$lost_pass_page_id
													));
									
		// set default settings
		wps_deals_default_settings();
		
		//update plugin version to option
		update_option( 'wps_deals_set_option', '1.0' );
		
		//update countires to database
		wps_deals_update_countries();
		
	} //check deals options empty or not
	
	// Cron jobs
	wp_clear_scheduled_hook( 'wps_deals_scheduled_set_price_meta' );
	wp_schedule_event( time(), 'daily', 'wps_deals_scheduled_set_price_meta' );
	
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
			$email_sbody = array( 'reset_password_email'=> sprintf( __('Someone requested that the password be reset for the following account:'."\n\n".'Username: {%s}'."\n\n".'If this was a mistake, just ignore this email and nothing will happen.'."\n\n".'To reset your password, visit the following address:'."\n\n".'{%s}','wpsdeals'), 'user_name', 'reset_link' ));
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
		
		$udpopt = false;
		
		//check reset password email body is set in options or not
		if( !isset( $wps_deals_options['cheque_title'] ) ) {
			$cheque_title = array( 'cheque_title'=> __( 'Cheque Payment','wpsdeals') );
			$wps_deals_options = array_merge( $wps_deals_options, $cheque_title );
			$udpopt = true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		//update plugin version to option
		update_option( 'wps_deals_set_option', '1.0.3' );
		
	} //check plugin set option value is 1.0.2
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.3' ) {
		
		$udpopt = false;
		
		//check force ssl checkout settings is set or not
		if( !isset( $wps_deals_options['force_ssl_checkout'] ) ) {
			$force_ssl = array( 'force_ssl_checkout' => '' );
			$wps_deals_options = array_merge( $wps_deals_options, $force_ssl );
			$udpopt = true;
		}
		
		//check unforce ssl checkout settings is set or not
		if( !isset( $wps_deals_options['unforce_ssl_checkout'] ) ) {
			$unforce_ssl = array( 'unforce_ssl_checkout' => '' );
			$wps_deals_options = array_merge( $wps_deals_options, $unforce_ssl );
			$udpopt = true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		//update plugin version to option
		update_option( 'wps_deals_set_option', '1.0.4' );
		
	} //check plugin set option value is 1.0.3
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.4' ) {
		
		$udpopt = false;
		
		//check default deals orderby settings is set or not
		if( !isset( $wps_deals_options['default_deals_orderby'] ) ) {
			$default_deals_orderby	= array( 'default_deals_orderby' => 'date-desc' );
			$wps_deals_options		= array_merge( $wps_deals_options, $default_deals_orderby );
			$udpopt					= true;
		}
		
		//check enable deals orderby settings
		if( !isset( $wps_deals_options['enable_deals_orderby'] ) ) {
			$enable_deals_orderby	= array( 'enable_deals_orderby' => '' );
			$wps_deals_options		= array_merge( $wps_deals_options, $enable_deals_orderby );
			$udpopt					= true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		//update plugin version to option
		update_option( 'wps_deals_set_option', '1.0.5' );
	} //check plugin set option value is 1.0.4
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.5' ) {
		
		//get set pages option data
		$wps_deals_set_pages = get_option( 'wps_deals_set_pages' );
		
		//Create an Account page under my account page
		if( isset( $wps_deals_set_pages['my_account_page'] ) ) {
			
			//create an account page creation
			$create_account_page = array(
											'post_type'		=>	'page',
											'post_status'	=>	'publish',
											'post_parent'	=>	$wps_deals_set_pages['my_account_page'],
											'post_title'	=>	__('Create an Account','wpsdeals'),
											'post_content'	=>	'[wps_deals_create_account][/wps_deals_create_account]',
											'post_author'	=>	$user_ID,
											'comment_status'=>	'closed'
										);
			$create_account_id  = wp_insert_post( $create_account_page );
			
			//store create an account page to already created page
			$wps_deals_set_pages['create_account_page'] = $create_account_id;
			
			//update new pages data
			update_option( 'wps_deals_set_pages', $wps_deals_set_pages );
			
			$createaccountpage = array( 
										'create_account_page'	=>	$create_account_id
									);
			$wps_deals_options = array_merge( $wps_deals_options, $createaccountpage );
			$udpopt = true;
			
			if( $udpopt == true ) { // if any of the settings need to be updated
				update_option( 'wps_deals_options', $wps_deals_options );
			}
			
			//update plugin version to option
			update_option( 'wps_deals_set_option', '1.0.6' );
			
		} //end if to check my account page
		
	} //check plugin set option value is 1.0.5
	
	$wps_deals_set_option = get_option( 'wps_deals_set_option' );
	
	if( $wps_deals_set_option == '1.0.6' ) {
		
		$udpopt = false;
		
		// check chome deals
		if( !isset( $wps_deals_options['deals_home'] ) ) {
			$deals_home = array( 'deals_home' => 'deals-col-6' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_home );
			$udpopt = true;
		}
		
		// check single deal size
		if( !isset( $wps_deals_options['deals_size_single'] ) ) {
			$deals_size_single = array( 'deals_size_single' => 'medium' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_size_single );
			$udpopt = true;
		}
		
		// check archive deals size
		if( !isset( $wps_deals_options['deals_size_archive'] ) ) {
			$deals_size_archive = array( 'deals_size_archive' => 'medium' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_size_archive );
			$udpopt = true;
		}
		
		// check button color
		if( !isset( $wps_deals_options['deals_btn_color'] ) ) {
			$deals_btn_color = array( 'deals_btn_color' => 'blue' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_btn_color );
			$udpopt = true;
		}
		
		// check home columns
		if( !isset( $wps_deals_options['deals_columns'] ) ) {
			$deals_columns = array( 'deals_columns' => 'deals-col-6' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_columns );
			$udpopt = true;
		}
		
		// check archive columns
		if( !isset( $wps_deals_options['deals_columns_archive'] ) ) {
			$deals_columns_archive = array( 'deals_columns_archive' => 'deals-col-6' );
			$wps_deals_options = array_merge( $wps_deals_options, $deals_columns_archive );
			$udpopt = true;
		}
		
		if( $udpopt == true ) { // if any of the settings need to be updated
			update_option( 'wps_deals_options', $wps_deals_options );
		}
		
		// update plugin version to option
		update_option( 'wps_deals_set_option', '1.2.0' );
		
	} //check plugin set option value is 1.0.6
	
	//Change Log file Dir and create directory on activation
	wps_deals_create_files();
	
	if( $wps_deals_set_option == '1.2.0' ) {
		
		// future code here
		
	} //check plugin set option value is 1.2.0
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
			wp_delete_post( $pages['create_account_page'],true );//delete create an account page
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
		
		do_action('wps_deals_delete_options');
		
	}
}

/**
 * Create Files/Directories
 * 
 * Handle to create files/directories on activation
 * 
 * @package  @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_create_files() {
	
	$files = array(
		array(
			'base' 		=> WPS_DEALS_LOG_DIR,
			'file' 		=> '.htaccess',
			'content' 	=> 'deny from all'
		),
		array(
			'base' 		=> WPS_DEALS_LOG_DIR,
			'file' 		=> 'index.html',
			'content' 	=> ''
		)
	);
	
	foreach ( $files as $file ) {
		if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
			if ( $file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ) ) {
				fwrite( $file_handle, $file['content'] );
				fclose( $file_handle );
			}
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
	$mainpage = $thank_you = $cancel = $checkout = $orderedpage = $myaccountpage = $createaccountpage = $editaddresspage = $changepasspage = $logoutpage = $lostpasspage = '';
	
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
		//check create an account page is created then set to default
		if( isset( $pages['create_account_page'] ) ) { $createaccountpage = $pages['create_account_page']; }
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
								'deals_home'					=>	'rand',
								'deals_size_archive'			=> 	'medium',
								'deals_size_single'				=> 	'medium',
								'deals_btn_color'				=> 	'blue',
								'deals_columns'					=>	'deals-col-6',
								'deals_columns_archive'			=>	'deals-col-6',
								'disable_more_deals'			=>	'',
								'ending_deals_in'				=>	'5',
								'upcoming_deals_in'				=>	'5',
								'deals_per_page'				=>	'10',
								'default_deals_orderby'			=>	'date-asc',
								'payment_gateways'				=>	array('paypal'),
								'paypal_merchant_email'			=>	'',
								'enable_testmode'				=>	'',
								'enable_debug'					=>	'',
								'from_email'					=>	get_option( 'blogname' ) . ' <' . get_option( 'admin_email' ) . '>',
								'buyer_email_subject'			=>	__('Purchase Receipt','wpsdeals'),
								'buyer_email_body'				=>	sprintf( __('Dear {%s}'."\n\n".'Thank you for your purchase. Please click on the link(s) below to download your files.'."\n\n".'Product Details : {%s}'."\n\n".'Total: {%s}'."\n\n".'Thank you','wpsdeals'), 'first_name', 'product_details', 'total' ),
								'notif_email_address'			=>	get_option('admin_email'),
								'disable_seller_notif'			=>	'',
								'seller_email_subject'			=>	__('New deal purchase','wpsdeals'),
								'seller_email_body'				=>	sprintf( __('Hello'."\n\n".'A deals purchase has been made.'."\n\n".'Deals sold: {%s}'."\n\n".'Purchased by: {%s}'."\n\n".'Total: {%s}'."\n\n".'Payment Method: {%s}'."\n\n".'Thank you','wpsdeals'), 'product_details', 'username', 'total', 'payment_method' ),
								'reset_password_email_subject'	=>	__('Reset Password','wpsdeals'),
								'reset_password_email'			=>	sprintf( __('Someone requested that the password be reset for the following account:'."\n\n".'Username: {%s}'."\n\n".'If this was a mistake, just ignore this email and nothing will happen.'."\n\n".'To reset your password, visit the following address:'."\n\n".'{%s}','wpsdeals'), 'user_name', 'reset_link' ),
								'currency'						=>	'USD',
								'payment_thankyou_page'			=> $thank_you,
								'payment_cancel_page'			=> $cancel,
								'payment_checkout_page'			=> $checkout,
								'deals_main_page'				=> $mainpage,
								'ordered_page'					=> $orderedpage,
								'my_account_page'				=> $myaccountpage,
								'create_account_page'			=> $createaccountpage,
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
								'update_order_email'			=> sprintf( __( 'Order ID : {%s}'."\n\n".'Order Date : {%s}'."\n\n".'Your order has been updated to the following status.'."\n\n".'New status: {%s}' ,'wpsdeals' ), 'order_id', 'order_date', 'status' ),
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
								'cheque_title'					=> __( 'Cheque Payment', 'wpsdeals' ),
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

global	$wps_deals_session,$wps_deals_fees,
		$wps_deals_model,$wps_deals_scripts,$wps_deals_render,
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
 **/
// loads the Misc Functions file
require_once ( WPS_DEALS_DIR . '/includes/wps-deals-countries-states.php' );

// loads the Misc Functions file
require_once ( WPS_DEALS_DIR . '/includes/class-wps-deals-session.php' );
$wps_deals_session = new Wps_Deals_Session();

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

//Fees Class to handles most of fees related functionalities
require_once ( WPS_DEALS_DIR . '/includes/class-wps-deals-fees.php' );
$wps_deals_fees = new Wps_Deals_Fees();

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
	
//include the meta functions file for metabox
require_once ( WPS_DEALS_META_DIR . '/wps-deals-meta-box-functions.php' );

//include the main class file for metabox
require_once ( WPS_DEALS_META_DIR . '/class-wps-deals-meta-box.php' );
$wps_deals_metabox = new Wps_Deals_Meta_Box();
$wps_deals_metabox->add_hooks();

//Post type to handle custom post type
require_once( WPS_DEALS_DIR . '/includes/wps-deals-post-types.php' );

//Pagination Class
require_once( WPS_DEALS_DIR . '/includes/class-wps-deals-pagination-public.php' ); // front end pagination class

// Loads the download process file
require_once( WPS_DEALS_DIR . '/includes/wps-deals-download-process.php');

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

//if( !is_admin() ) {

	global $detect_mobile;
	if( !class_exists( 'Mobile_Detect' ) ) {
		require_once( WPS_DEALS_DIR . '/includes/class-mobile-detect.php' ); // including the mobile class
	}
	$detect_mobile = new Mobile_Detect();

	// deals plugin front end template functions
	require_once ( WPS_DEALS_DIR . '/includes/wps-deals-template-functions.php' );

	// deals plugin front end template hooks
	require_once( WPS_DEALS_DIR . '/includes/wps-deals-template-hooks.php' );
	
//}

//Register Widget
require_once( WPS_DEALS_DIR . '/includes/widgets/class-wps-deals-lists.php');

//Register Cart Deals Widget
require_once( WPS_DEALS_DIR . '/includes/widgets/class-wps-deals-latest-products-cart.php');

//add action to delete log
add_action( 'delete_post', array( $wps_deals_model,'wps_deals_remove_logs_on_delete' ) );

?>