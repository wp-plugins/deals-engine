<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Gateways Functions
 *
 * Handles to all gateways functions
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

/**
 * Send to payment gateway
 *
 * Handles to call action to send to payment process
 * as per gateway selected
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_send_to_gateway( $gateway, $data, $postdata ) {
	
	// $gateway must match the ID used when registering the gateway
	do_action( 'wps_deals_gateway_' . $gateway, $data, $postdata );
}
/**
 * Check payment gateway is active
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_is_gateway_active($gateway) {
	
	global $wps_deals_options;
	
	$gateways = $wps_deals_options['payment_gateways'];
	if( array_key_exists( $gateway,$gateways ) ) {
		return true;
	}
	return false;
}
/**
 * Insert cart data to database
 * 
 * Handles to add cart data to database
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_insert_payment_data($data=array()) {
	
	global $wps_deals_price,$wps_deals_options,
			$wps_deals_currency,$wps_deals_model,$current_user;
	
	$prefix = WPS_DEALS_META_PREFIX;
	
	//price class
	$price = $wps_deals_price;
	
	//model class
	$model = $wps_deals_model;
	
	//currency class
	$currency = $wps_deals_currency;
	
	//cart data
	$cartdetails = $data['cartdata'];
	
	//get the value for user's first name from posted data
	$first_name = $data['user_info']['first_name'];
		
	//get the value for user's last name from posted data
	$last_name = $data['user_info']['last_name'];
	
	//get the value of user email 
	$user_email = $data['user_info']['user_email'];
	
	$user_name = $data['user_info']['user_name'];
	
	if(is_user_logged_in()) {
		$userid = $current_user->ID;
	} else {
		$userid = '0';
	}
	
	//create array arguments for saving the deal sales data to database
	$deal_sale_args = array(
								  'post_title'		=>	$user_name,
								  'post_content'	=>	'',
								  'post_status'		=>	'publish',
								  'post_type'		=>	WPS_DEALS_SALES_POST_TYPE,
								  'post_author'		=>	$userid
							);
	
	// insert the cart data to database
	$salesid = wp_insert_post( $deal_sale_args );
	
	//if deals sales basic data is successfully stored then update some more data to database
	if(!empty($salesid)) { //check order is inserted in database
	
		//cart products
		$cartproducts = $cartdetails['products'];
		
		$ordered_deal_userdetails = array(
											'user_id'		=>	$userid,
											'user_name'		=>	$user_name,
											'user_email'	=>	$user_email,
											'first_name'	=>	$first_name,
											'last_name'		=>	$last_name
										);
		
		// update the value for the user details to the post meta box
		update_post_meta( $salesid, $prefix.'order_userdetails',$ordered_deal_userdetails);
	
		// coupon details
    	$ordered_deals_args = array (
    									'order_id' 			=>	$salesid,
										'currency' 			=>	$wps_deals_options['currency'],
										'payment_method'	=>	$data['payment_method'], //WPS_DEALS_PAYPAL_GATEWAY
										'checkout_label'	=>	isset( $data['checkout_label'] ) ? $data['checkout_label'] : $data['payment_method']
    								);		
	
		foreach ($cartproducts as $dealid => $dealdata) {

			//get the data by deal id
			$getdeal = get_post( $dealid );
			
			//get the value for available deals from post meta
			$available = get_post_meta($dealid,$prefix.'avail_total',true);
			
			//get quantity
			$quantity = $dealdata['quantity'];
			
			//get deal title
			$dealtitle = get_the_title($getdeal->ID);
			
			//get deal desc 
			$dealdesc = $getdeal->post_content;
			
			//get the value for start date from post meta
			$startdate = get_post_meta($dealid,$prefix.'start_date',true);
			
			//get the value for end date from post meta
			$enddate = get_post_meta($dealid,$prefix.'end_date',true);
			
			//get the value for sale price from post meta
			$saleprice = get_post_meta($dealid,$prefix.'sale_price',true);
			
			//product price
			$productprice = $price->wps_deals_get_price($dealid);
			
			//get the value for normal price from post meta
			$normalprice = get_post_meta($dealid,$prefix.'normal_price',true);
			
			//get the value for deal image featured image
			$deal_image = get_the_post_thumbnail( $dealid, 'wpsdeals-single', array( 'alt' => __('Deal Image','wpsdeals'), 
																				 	 'title'	=> trim( strip_tags( get_the_title( $dealid ) ) ) 
																					) );
		
			$dealimg = !empty( $deal_image ) ? $deal_image : '<img src="'.WPS_DEALS_URL.'includes/images/deals-no-image-big.jpg'.'" alt="'.__('Deal Image','wpsdeals').'" />';
			
			
			//get the value for deal image from post meta
			$address = get_post_meta($dealid,$prefix.'address',true);
			
			//get the value for deal terms & conditions from post meta
			$terms = get_post_meta($dealid,$prefix.'terms_conditions',true);
			
			//get the value for deal image from post meta
			//$related_img = array();
			//$related_img[1] = get_post_meta($dealid,$prefix.'related_image_1',true);
			//$related_img[2] = get_post_meta($dealid,$prefix.'related_image_2',true);
			//$related_img[3] = get_post_meta($dealid,$prefix.'related_image_3',true);
			
			//display price
			$dis_sale_price  = $currency->wps_deals_formatted_value($productprice,$wps_deals_options['currency']);
			
			//get value of deal all data
			$dealalldata = array(
										'title'				=> $dealtitle,
										'desc'				=> $dealdesc,
										'start_date'		=> $startdate,
										'end_date'			=> $enddate,
										'normal_price'		=> $normalprice,
										'sale_price'		=> $saleprice,
										'avail_total'		=> $available,
										'address'			=> $address,
										'terms_conditions'	=> $terms,
										'main_image'		=> $dealimg,
										//'related_images'	=> $related_img,
								);
		
			
			//display total
			$dis_total = $currency->wps_deals_formatted_value(($productprice * $quantity),$wps_deals_options['currency']);	
			
			//get the value for deal download link
			//$product_link = get_post_meta($dealid,$prefix.'upload_files',true);
					
	    	$ordered_deals_args['deals_details'][] = array(
	    														'deal_id' 				=> $dealid,
					    										'deal_title'			=> $dealtitle,
					    										'deal_sale_price'		=> $productprice,
					    										'deal_start_date'		=> $startdate,
					    										'deal_end_date'			=> $enddate,
					    										'deal_quantity'			=> $quantity,
					    										'display_price'			=> $dis_sale_price, //including taxes
					    										'display_sale_price'	=> $dis_sale_price,//simple sale price
					    										'display_total'			=> $dis_total,
					    										//'product_link'			=> $product_link,
					    										'deal_details'			=> serialize($dealalldata)
	    												 );
	    		
		}
		
		//store user IP address to database
		$ordered_deals_args['order_ip'] = wps_deals_getip();
		
		//store subtotal to database
		$ordsubtotal = $cartdetails['subtotal'];
		$ordered_deals_args['subtotal'] = $ordsubtotal;
		
		//store order total amount to database
		$ordtotal = $cartdetails['total'];
		$ordered_deals_args['order_total'] = $ordtotal;
		
		$ordered_deals_args['post_data'] = $data['post_data'];
		
		$dis_order_total = $currency->wps_deals_formatted_value($ordtotal,$wps_deals_options['currency']);
		$ordered_deals_args['display_order_total'] = $dis_order_total;
		
		//apply filter to add some data to order details array for saving to data base
		$ordered_deals_args = apply_filters('wps_deals_update_cart_data',$ordered_deals_args);
		
		//unset post data when its requirement is over
		unset( $ordered_deals_args['post_data'] );
		
		$dis_order_subtotal = $currency->wps_deals_formatted_value($ordsubtotal,$wps_deals_options['currency']);
		$ordered_deals_args['display_order_subtotal'] = $dis_order_subtotal;
		
    	//update order details to post meta
	    update_post_meta($salesid,$prefix.'order_details',$ordered_deals_args);
	    
		// update the value for the user email to post meta
		update_post_meta( $salesid, $prefix.'payment_user_email', $user_email);
		
		// update the value for the payment status to the post meta box
		$payment_status = isset($data['payment_status']) ? $data['payment_status'] : '0';
		
		//update payment status to database
		wps_deals_update_payment_status( $payment_status, $salesid );
	    
		//order tracking data
		$trackargs = array( 'orderid' => $salesid, 'payment_status' => $payment_status, 'notify' => wps_deals_notify_from_status( $payment_status ) );
		wps_deals_update_order_track( $trackargs );
		
	    //do action to do something before payment process
	    do_action( 'wps_deals_cart_payment_process_before', $salesid );
	 }
	 
	return $salesid;
	
}
/**
 * Update Payment Status
 * 
 * Handles to update status of order after payment
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_update_payment_status( $newstatus='0', $orderid ){
	
	global $wps_deals_model;
	
	$prefix = WPS_DEALS_META_PREFIX;
	
	//model class
	$model = $wps_deals_model;
	
	//get old status
	$oldstatus = $model->wps_deals_get_ordered_payment_status( $orderid, true );//get_post_meta( $orderid, $prefix.'payment_status', true );
	
	//check old status and new status are not same
	if( $oldstatus != $newstatus ) {
	
		//do action to call someting before changing payment status
		do_action( 'wps_deals_before_payment_status_change', $orderid, $newstatus, $oldstatus );
		
		//update payment status
		update_post_meta( $orderid, $prefix.'payment_status', $newstatus );
		
		//do action when status is going to update
		do_action( 'wps_deals_update_payment_status', $orderid, $newstatus, $oldstatus );
		
		//status from //default it will pending
		$statusfrom = $model->wps_deals_payment_value_to_slug( $oldstatus );
		//status to
		$statusto = $model->wps_deals_payment_value_to_slug( $newstatus );
		
		//do action when particular status change from particular status
		do_action( 'wps_deals_order_status_'.$statusfrom.'_to_'.$statusto, $orderid, $newstatus, $oldstatus );
		
	} //end if to check old status and new status are not same
}

/**
 * Send Admin Notification
 * 
 * Handles to call when new order 
 * is being created
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 **/
function wps_deals_send_order_notification( $orderid, $newstatus, $oldstatus ) {
	
	global $wps_deals_model;
	
	//model class
	$model = $wps_deals_model;

	//order details
	$orderdetails 	= $model->wps_deals_get_post_meta_ordered( $orderid );

	//user details
	$userdetails 	= $model->wps_deals_get_ordered_user_details( $orderid );
	
	$maildata 					= array();
	$maildata['user_data'] 		= $userdetails; //user details for email data
	$maildata['order_details'] 	= $orderdetails; //order details for email data
	
	//send mail to seller notification
	$model->wps_deals_seller_mail( $maildata );
	
	//send email to user
	$model->wps_deals_buyer_mail( $maildata );

	//order tracking data
	/*$trackargs = array( 'orderid' => $orderid, 'payment_status' => $newstatus, 'notify' => '1' );
	wps_deals_update_order_track( $trackargs );*/
}

/**
 * Make Payment status completed
 * 
 * Handles to make payment status 
 * as a completed
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 **/
function wps_deals_make_payment_status_change( $orderid, $newstatus, $oldstatus ) {
	
	global $wps_deals_model;
	
	//model class
	$model = $wps_deals_model;
	
	//check payment new status is completed 
	if( $newstatus == '1' ) {
	
		//update some product data like baught copy and available copy
		$model->wps_deals_record_sales( $orderid );
		
	} //end if to check payment status completed
	/*elseif ( $newstatus == '4' ) { //check new status should be cancelled
		
		//decrease recorded sales
		$model->wps_deals_decrease_sales( $orderid );
		
		//do action for cancelling the order
		do_action( 'wps_deals_order_cancelled', $orderid );
		
	}*/ //end elseif to check status is cancelled or not

}
//add action to record sales & decrease sale on cancelled payment or order
add_action( 'wps_deals_update_payment_status', 'wps_deals_make_payment_status_change', 10, 3 );

/**
 * Empty Cart
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_empty_cart(){
	
	global $wps_deals_cart;
	
	//cart class
	$cart = $wps_deals_cart;
	
	//make cart empty
	$cart->cartempty();
}
/**
 * Update Order Track
 * 
 * Handles to update order track
 * data to database
 * 
 * @package Social Deals Engine 
 * @since 1.0.0
 **/
function wps_deals_update_order_track( $args = array() ) {
	
	$prefix = WPS_DEALS_META_PREFIX;
	
	//customer is notified or not
	$notifycustomer = isset( $args['notify'] ) ? $args['notify'] : '0';
	//order id
	$orderid 		= $args['orderid'];
	//new payment status
	$paymentstatus  = $args['payment_status'];
	//comments for trackin
	$comments		= isset( $args['comments'] ) ? $args['comments'] : '';
	
	//get saved order tracking data
	$track = get_post_meta( $orderid, $prefix.'order_track', true );
	
	//initialize tracking data with array
	$track = !empty( $track ) ? $track : array();
	$track[] = array(
					'date'		=>	date( 'Y-m-d H:i:s' ),
					'notify'	=>	$notifycustomer,
					'status'	=>	$paymentstatus,
					'comments'	=>	$comments
				);
	
	//update order tracking data
	update_post_meta( $orderid, $prefix.'order_track', $track );
}

/**
 * Call on Order Cancell
 * 
 * Handles to call when order is being cancelled by
 * customer
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_order_cancel_by_customer() {
	
	global $wps_deals_model;
	
	//model class
	$model = $wps_deals_model;
	
	if( isset( $_GET['wps_deals_cancel_order'] ) && !empty( $_GET['wps_deals_cancel_order'] ) 
		&& isset( $_GET['order_id'] ) && !empty( $_GET['order_id'] ) ) {

		//order id
		$orderid = $_GET['order_id'];
		
		//get existing order status	
		$paymentstatus = $model->wps_deals_get_ordered_payment_status( $orderid, true );
		
		//check payment status should be pending or failed
		if( $paymentstatus == '0' || $paymentstatus == '3' ){
			
			//update payment status
			wps_deals_update_payment_status( '4', $orderid );
			
			//make order cancelled
			$cancelqrystrargs = array( 'wps_deals_cancel_order' => false, 'order_id' => $orderid );
			
			//send back user to cancel order page
			wps_deals_send_on_cancel_page( $cancelqrystrargs );
			
		} //end if to check payment status
			
	} //check wps_deals_cancel_order is set and not empty & order_id must set
	
}
//add action to make order cancel by customer
add_action( 'init', 'wps_deals_order_cancel_by_customer' );

/**
 * Return Notify Value By Payment Status
 * 
 * Handles to return value of notify
 * track with payment status
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 **/
function wps_deals_notify_from_status( $status ) {
	
	global $wps_deals_model;
	
	$model = $wps_deals_model;
	
	$statusslug = $model->wps_deals_payment_value_to_slug( $status );
	
	//add more status in below array if you need to
	//do on notified for particular status
	//notify in this payment gateway
	$notifywithstatus = array( 'onhold', 'completed' );
	
	//check passed status is in array or not
	if( in_array( $statusslug, $notifywithstatus ) )  {
		return '1'; //notified
	} else {
		return '0'; //not notified
	}
}
?>