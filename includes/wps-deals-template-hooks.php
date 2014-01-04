<?php
/**
 * Template Hooks
 * 
 * Handles to add all hooks of template
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_options;

	/********************** Home Page Hooks **************************/

	//add_action to load home header - 5
	//add_action to load home content - 10
	//add_action to load home content via shortcode category based deals - 10
	add_action( 'wps_deals_home_content'			, 'wps_deals_home_header'	, 5 );
	add_action( 'wps_deals_home_content'			, 'wps_deals_home_content'	, 10 );
	add_action( 'wps_deals_home_content_shortcode'	, 'wps_deals_home_content'	, 10 );
	
	//add_action to show home header content - 5
	add_action( 'wps_deals_home_header_content', 'wps_deals_home_header_content' , 5 );
	
	//add_action to show home page header timer - 5
	//add_action to show home page header discount box - 10
	add_action( 'wps_deals_home_header_right_top', 'wps_deals_home_header_timer'	, 5 );
	add_action( 'wps_deals_home_header_right_top', 'wps_deals_home_header_discount'	, 10 );
	
	//add_action to show home page header right panel deal value box - 5
	//add_action to show home page header right panel deal saving value - 10
	add_action( 'wps_deals_home_header_right_center', 'wps_deals_home_header_dealvalue'	, 5);
	add_action( 'wps_deals_home_header_right_center', 'wps_deals_home_header_dealsave'	, 10);
	
	//add_action to show home page social facebook button -5 
	//add_action to show home page social twitter button - 10
	//add_action to show home page social google button - 15
	add_action( 'wps_deals_social_buttons', 'wps_deals_social_facebook'	, 5 );
	add_action( 'wps_deals_social_buttons', 'wps_deals_social_twitter'	, 10 );
	add_action( 'wps_deals_social_buttons', 'wps_deals_social_google'	, 15 );
	
	//add_action to show home page header star rating - 5
	//add_action to show home page header social buttons - 10 
	//add_action to show home page header see deal button - 15
	add_action( 'wps_deals_home_header_right_bottom', 'wps_deals_home_header_ratings'	, 5 );
	add_action( 'wps_deals_home_header_right_bottom', 'wps_deals_social_buttons'		, 10 );
	add_action( 'wps_deals_home_header_right_bottom', 'wps_deals_home_header_see_deal'	, 15 );
	
	//add_action to load home more deal navigation - 5
	//add_action to load home more deal orderby - 10
	//add_action to load home content active deals - 15
	//add_action to load home content ending deals - 20
	//add_action to load home content upcoming deals - 25
	add_action( 'wps_deals_home_more_deals', 'wps_deals_home_navigations', 5 );
	add_action( 'wps_deals_home_more_deals', 'wps_deals_home_orderby', 10 );
	add_action( 'wps_deals_home_more_deals', 'wps_deals_home_more_deal_active', 15 );
	add_action( 'wps_deals_home_more_deals', 'wps_deals_home_more_deal_ending', 20 );
	add_action( 'wps_deals_home_more_deals', 'wps_deals_home_more_deal_upcoming', 25 );
	
	//add_action to show home price flag with image - 5 
	//add action to show deal image for home page loop - 10
	//add action to show deal normal price on home page more deal - 15
	//add action to show deal price on home page more deal - 20
	//add action to show deal saving price on home page more deal - 25
	add_action( 'wps_deals_home_more_deal_content', 'wps_deals_home_more_deal_price_flag' 	, 5 );
	add_action( 'wps_deals_home_more_deal_content', 'wps_deals_home_more_deal_image' 		, 10 );
	add_action( 'wps_deals_home_more_deal_content', 'wps_deals_home_more_deal_normal_price' , 15 );
	add_action( 'wps_deals_home_more_deal_content', 'wps_deals_home_more_deal_discount' 	, 20 );
	add_action( 'wps_deals_home_more_deal_content', 'wps_deals_home_more_deal_saving' 		, 25 );
	
	//add action for home more deal footer content ( timer ) - 5
	//add action for home more deal footer content ( see deal ) - 10
	add_action( 'wps_deals_home_more_deal_footer', 'wps_deals_home_more_deal_footer_time' 		, 5 );
	add_action( 'wps_deals_home_more_deal_footer', 'wps_deals_home_more_deal_footer_see_deal' 	, 10 );
	
	/********************** Deal View Page Hooks **************************/
	
	//add_action to load single deal template
	//add_action to load single deal header content -5 
	//add_action to load single deal middle - 10
	//add action to load single deal footer	- 20
	add_action( 'wps_deal_single_content', 'wps_deals_single_header'			, 5 );
	add_action( 'wps_deal_single_content', 'wps_deals_single_content'			, 10 );
	add_action( 'wps_deal_single_content', 'wps_deals_single_footer'			, 15 );
	
	//add action to load header left content - 5
	//add action to load header deal image - 10
	add_action( 'wps_deals_single_header_content', 'wps_deals_single_header_left'		, 5 );
	add_action( 'wps_deals_single_header_content', 'wps_deals_single_deal_img'			, 10 );
	
	//add_action to show add to cart button on top - 5
	//add_action to show deal expired on top - 5
	//add_action to show left deal text on top - 10
	//add_action to show deal details - 15
	//add_action to show deal timer - 20
	//add_action to show deal available & bought box - 25
	//add_action to show social buttons - 30
	//add_action to show deal rating - 35
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_add_to_cart'			, 5 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_deal_expired'			, 5 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_dimsale_box'			, 10 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_deal_details'			, 15 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_deal_timer'			, 20 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_deal_avail_bought'	, 25 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_social_buttons'				, 30 );
	add_action( 'wps_deals_single_header_left', 'wps_deals_single_deal_ratings'			, 35 );
	
	//add action to show deals description - 5
	add_action( 'wps_deals_single_middle_content_top', 'wps_deals_single_description'	, 5 );
	
	//add action to show add to cart button in bottom of page - 5
	//add action to show deal expired in bottom of page - 5
	//add action to show left text in bottom of page - 10
	add_action( 'wps_deals_single_middle_content_center', 'wps_deals_single_add_to_cart'	, 5 );
	add_action( 'wps_deals_single_middle_content_center', 'wps_deals_single_deal_expired'	, 5 );
	add_action( 'wps_deals_single_middle_content_center', 'wps_deals_single_dimsale_box'	, 10 );
	
		
	//add action to load purchase link button - 5 
	//add action to load add to cart button - 5
	//add action to load buy now button - 5
	add_action( 'wps_deals_single_purchase_link', 'wps_deals_purchase_link_button'	, 5 );
	add_action( 'wps_deals_single_add_to_cart', 'wps_deals_add_to_cart_button'		, 5 );
	add_action( 'wps_deals_single_buy_now', 'wps_deals_buy_now_button'				, 5 );
	
	//add action to show  single deal normal price - 5
	//add action to show  single deal discount - 10
	//add action to show  single deal saving price - 15
	add_action( 'wps_deals_single_details', 'wps_deals_single_normalprice'	, 5 );
	add_action( 'wps_deals_single_details', 'wps_deals_single_discount'		, 10 );
	add_action( 'wps_deals_single_details', 'wps_deals_single_save'			, 15 );
	
	//add_action to show available box - 5
	//add_action to show bought box - 10
	add_action( 'wps_deals_available_bought', 'wps_deals_single_available' 	, 5 );
	add_action( 'wps_deals_available_bought', 'wps_deals_single_bought' 	, 10 );
	
	//add_action to show single footer content top
	//add_action to show business title - 5
	//add_action to show business location map - 10
	add_action( 'wps_deals_single_footer_top', 'wps_deals_single_business_title'	, 5 );
	add_action( 'wps_deals_single_footer_top', 'wps_deals_single_business_location'	, 10 );
	
	//add_action to show single footer content before container
	//add_action to show business logo - 5
	add_action( 'wps_deals_single_footer_middle_content_before',	'wps_deals_single_business_logo'	, 5 );
	
	//add_action to show single footer inside container
	//add_action to show business address - 5
	//add_action to show business link - 10
	//add_action to show terms and coditions - 15
	add_action( 'wps_deals_single_footer_middle_content_center', 'wps_deals_single_business_address', 5 );
	add_action( 'wps_deals_single_footer_middle_content_center', 'wps_deals_single_business_link'	, 10 );
	add_action( 'wps_deals_single_footer_middle_content_center', 'wps_deals_single_terms_conditions', 15 );
	
	
	/********************** Deal Ordered Page Hooks **************************/
	
	//add_action to show cheque payment message content - 5
	add_action( 'wps_deals_order_view_content_before'	, 'wps_deals_order_view_content_before'	, 5 );
	
	//add_action to show ordered deal page content - 5
	add_action( 'wps_deals_orders_content'		, 'wps_deals_orders_content'	, 5 );
	
	//add_action to show ordered deals listing table
	add_action( 'wps_deals_orders_table'	, 'wps_deals_orders_listing_content', 5, 2 );
	
	//add_action to show orderes completed page content - 5
	add_action( 'wps_deals_orders_complete_content', 'wps_deals_orders_complete_content', 5 );
	
	//add_action to show orderes cancel page content - 5
	add_action( 'wps_deals_orders_cancel_content', 'wps_deals_orders_cancel_content'	, 5 );
	
	
	/********************** Deal Checkout Page Hooks **************************/
	
	//add_action to show checkout header part - 5
	//add_action to show checkout middle part - 10
	//add_action to show checkout footer part - 15
	add_action( 'wps_deals_checkout_content', 'wps_deals_checkout_header'	, 5 );
	add_action( 'wps_deals_checkout_content', 'wps_deals_checkout_content'	, 10 );
	add_action( 'wps_deals_checkout_content', 'wps_deals_checkout_footer'	, 15 );
	
	//add_action to add content to cart details - 5
	//add_action to add content to cart details via ajax - 5
	//add action to add cart actions buttons - 10
	add_action( 'wps_deals_checkout_header_content', 'wps_deals_cart_details'			, 5 );
	add_action( 'wps_deals_checkout_header_content_ajax', 'wps_deals_cart_details'		, 5 );
	add_action( 'wps_deals_checkout_header_content', 'wps_deals_cart_action_buttons'	, 10 );
	
	//add action to add cart empty button - 5
	//add action to add cart update button - 10
	add_action( 'wps_deals_cart_action_buttons', 'wps_deals_cart_empty_button'	, 5 );
	add_action( 'wps_deals_cart_action_buttons', 'wps_deals_cart_update_button'	, 10 );
	
	//add action to show description in chekout page
	add_action( 'wps_deals_checkout_payment_combo_after', 'wps_deals_display_description', 5 );
		
	//add_action to add social login buttons - 5
	add_action( 'wps_deals_checkout_middle_content', 'wps_deals_cart_social_login' , 5 );
	
	//add_action to add payment gateway combo in checkout form - 5
	//add_action to add content in cart user form - 10
	//add_action to add content in cart user personal details - 15
	//add_action to add content in cart user billing details - 20
	add_action( 'wps_deals_checkout_footer_content', 'wps_deals_checkout_payment_gateways'	, 5 );
	add_action( 'wps_deals_checkout_footer_content', 'wps_deals_checkout_user_form'			, 10 );
	add_action( 'wps_deals_checkout_footer_content', 'wps_deals_cart_user_personal_details'	, 15 );
	add_action( 'wps_deals_checkout_footer_content', 'wps_deals_cart_user_billing_details'	, 20 );
	
	//add_action to add content in cart agree terms and condition - 5 
	//add_action to add order total price & place order button - 10
	add_action( 'wps_deals_checkout_footer_content_after', 'wps_deals_cart_agree_terms'			, 5 );
	add_action( 'wps_deals_checkout_footer_content_after', 'wps_deals_checkout_order_total_button', 10 );
	
	//add_action to load user registration form - 5
	//add_action to load user login form - 10
	add_action( 'wps_deals_cart_user_form_content', 'wps_deals_cart_user_reg_form'	, 5 );
	add_action( 'wps_deals_cart_user_form_content', 'wps_deals_cart_user_login_form', 10 );
	
	//empty cart message
	add_action( 'wps_deals_cart_empty', 'wps_deals_empty_cart_message', 5 );
	
	//add action to show order total in footer - 5
	//add action to show order total in footer - 10
	add_action( 'wps_deals_cart_footer_total_button', 'wps_deals_cart_order_total_footer'		, 5 );
	add_action( 'wps_deals_cart_footer_total_button', 'wps_deals_cart_place_order_button_footer', 10 );
	
	//add action to show social login facebook button - 5
	//add action to show social login twitter button - 10
	//add action to show social login google button - 15
	//add action to show social login linkedin button - 20
	//add action to show social login yahoo button - 25
	$priority = 5;
	if( isset( $wps_deals_options['social_order'] ) && !empty( $wps_deals_options['social_order'] ) ) {
		$socialmedias = $wps_deals_options['social_order'];
	} else {
		$socialorders = wps_deals_social_networks();
		$socialmedias = array_keys ( $socialorders );
	}
	
	foreach (  $socialmedias as $social ) {
		add_action( 'wps_deals_checkout_social_login', 'wps_deals_social_login_'.$social , $priority );
		$priority += 5;
	}
	
	//add action to load social login buttons via shortcode - 10
	add_action( 'wps_deals_social_login_shortcode', 'wps_deals_social_login_shortcode', 10, 2 );
	
	//add action to add localize script for individual post data
	add_action( 'wps_deals_localize_map_script', 'wps_deals_localize_map_script' );
	
	/********************** My Account Page Hooks **************************/
	
	//add action to show my account page address success message - 5
	//add action to show my account page top content - 10
	//add action to show my account page available downloads - 15
	//add action to show my account page recent orders - 20
	//add action to show my account page addresses - 25
	add_action( 'wps_deals_my_account_content', 'wps_deals_my_account_address_success_msg'	, 5  );
	add_action( 'wps_deals_my_account_content', 'wps_deals_my_account_top_content'			, 10 );
	add_action( 'wps_deals_my_account_content', 'wps_deals_my_account_available_downloads'	, 15 );
	add_action( 'wps_deals_my_account_content', 'wps_deals_my_account_recent_orders'		, 20 );
	add_action( 'wps_deals_my_account_content', 'wps_deals_my_account_addresses'			, 25 );
	
	//add action to display my account page billing address
	add_action( 'wps_deals_my_account_billing_address', 'wps_deals_my_account_billing_address', 10, 2 );
	
	//add action to display my account page address success message - 5
	//add action to display my account page login content - 10
	add_action( 'wps_deals_my_account_login_content', 'wps_deals_my_account_address_success_msg', 5  );
	add_action( 'wps_deals_my_account_login_content', 'wps_deals_my_account_login_content'		, 10 );
	
	//add action to display billing address
	add_action( 'wps_deals_display_address', 'wps_deals_display_address'				, 10 );
	
	//add action to edit address page - 5
	add_action( 'wps_deals_edit_address_content', 'wps_deals_edit_address_content'		, 5 );
	
	//add action to edit address page with display address - 5
	add_action( 'wps_deals_edit_address_page', 'wps_deals_my_account_addresses'			, 5 );
	
	//add action to edit billing address
	add_action( 'wps_deals_edit_billing_address', 'wps_deals_edit_billing_address'		, 10 );
	
	//add action to manage billing address
	add_action( 'wps_deals_manage_billing_address', 'wps_deals_cart_user_billing_details', 10 );
	
	//add action to change password page - 5
	add_action( 'wps_deals_change_password_content', 'wps_deals_change_password_content', 5 );
	
	//add action to lost password page - 5
	add_action( 'wps_deals_lost_password_content', 'wps_deals_lost_password_content'	, 5 );
	
	//add action to display sidebar template - 10
	add_action( 'wps_deals_sidebar', 'wps_deals_get_sidebar', 10 );

?>