<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Payment Paypal
 * 
 * Handles functionalities about payment
 * all gateways
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

function wps_deals_process_payment_paypal( $cartdetails, $postdata ) {
	
	global $wps_deals_paypal,$wps_deals_price,$wps_deals_options,
			$wps_deals_currency,$wps_deals_model;
	
	//price class
	$price = $wps_deals_price;
	
	//model class
	$model = $wps_deals_model;
	
	//paypal class
	$paypal = $wps_deals_paypal;
	
	//currency class
	$currency = $wps_deals_currency;
	
	//payment method
	$method	= WPS_DEALS_PAYPAL_GATEWAY;
	
	$purchasedata = array();
	$purchasedata['user_info'] = array( 
										'first_name' => $postdata['wps_deals_cart_user_first_name'],
										'last_name' => $postdata['wps_deals_cart_user_last_name'],
										'user_name' => $postdata['user_name'],
										'user_email' => $postdata['wps_deals_cart_user_email'],
									  );
	$purchasedata['payment_method'] = $method;
	$purchasedata['post_data'] = $postdata;
	$purchasedata['cartdata'] = $cartdetails;
	$payment_status['payment_status'] = '0';
	
	$salesid = wps_deals_insert_payment_data($purchasedata);
	
	$cancelurl = isset($wps_deals_options['payment_cancel_page']) ? get_permalink($wps_deals_options['payment_cancel_page']) : '';
	$thankyouurl = isset($wps_deals_options['payment_thankyou_page']) ? get_permalink($wps_deals_options['payment_thankyou_page']) : '';
	
	$cancelurl = add_query_arg( array( 'order_id' => $salesid ), $cancelurl );
	$thankyouurl = add_query_arg( array( 'order_id' => $salesid ), $thankyouurl );
	
	if(!empty($salesid)) {
		
		//get order deals
		$orderdetailsall = $model->wps_deals_get_post_meta_ordered($salesid);
		$orderdetails = $orderdetailsall['deals_details'];
		
		//get the merchant id from settings page
		$merchantid = $wps_deals_options['paypal_merchant_email'];
		
		//make notify url when payapl ipn is going to validate
		//$notifyurl = add_query_arg(array( 'dealslistner' => 'paypalipn','order_id' => $salesid),home_url());
		
		$notifyurl = trailingslashit( home_url() ).'?dealslistner=paypalipn';
		
		$paypal->add_field('business',$merchantid);
		$paypal->add_field('return', $thankyouurl);
		$paypal->add_field('cancel_return',$cancelurl );
		$paypal->add_field('notify_url', $notifyurl);
		$paypal->add_field('first_name', $purchasedata['user_info']['first_name'] );
		$paypal->add_field('last_name', $purchasedata['user_info']['last_name'] );
		$paypal->add_field('currency_code', $wps_deals_options['currency']);
		$paypal->add_field('cmd', '_ext-enter');//
		$paypal->add_field('custom', $salesid);//
		$paypal->add_field('rm', '2');
		$paypal->add_field('redirect_cmd', '_cart');
		$paypal->add_field('upload', count($orderdetails));
		
		//do action to add field to paypal form
		do_action('wps_deals_add_paypal_field',$salesid);
		
		$i = 1;
		
		//made proper data format for sending into paypal
		foreach ($orderdetails as $order) {
		
			$dealid = $order['deal_id'];
			
			//get deal title
			$dealtitle =  get_the_title($order['deal_id']);
			
			//append item name to string which will send into paypal
			//$item_name .= $dealtitle.',';
			$item_name = $dealtitle;
			
			//get deal price
			$dealprice = $order['deal_sale_price'];
			
			//get deal quantity
			//$dealqty .= $order['deal_quantity'].',';
			$dealqty = $order['deal_quantity'];
			
			$paypal->add_field('item_name_'.$i, $item_name);
			$paypal->add_field('amount_'.$i, $dealprice );
			$paypal->add_field('quantity_'.$i, $dealqty);
			$i++;
		}
		//empty cart
	 	wps_deals_empty_cart();
		// submit the fields to paypal
		$paypal->submit_paypal_post(); 
		exit;
		
	} else {
		
		//return to checkout page
		wps_deals_send_on_checkout_page();
	}
}
add_action( 'wps_deals_gateway_paypal', 'wps_deals_process_payment_paypal', 10, 2);

/**
 * Paypal payment validate
 * 
 * Handles to validate paypal payment
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
 
function wps_deals_paypal_verfication() {
	
	global $wps_deals_paypal,$wps_deals_model;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
	//paypal class
	$paypal = $wps_deals_paypal;
	
	//model class
	$model = $wps_deals_model;
		 
	if(isset($_GET['dealslistner']) && $_GET['dealslistner'] == 'paypalipn' ) { //check listner value
		 
		 
		if($paypal->validate_ipn()) { //check validate ipn
			
			//status of paypal transaction
			$status = $paypal->ipn_data['payment_status'];
			
			//get order id
			$orderid = $_POST['custom'];
			
			// update the value for the paypal data to the post meta box
		 	update_post_meta( $orderid, $prefix.'order_ipn_data', $paypal->ipn_data ); // ipn data
			
		 	//update payment status
		 	$payment_status = $model->wps_deals_paypal_status_to_value( $status );
		 	
			//order details
			$orderdata = $model->wps_deals_get_post_meta_ordered( $orderid );
			
			//user details
			$userdetails = $model->wps_deals_get_ordered_user_details( $orderid );
			
			switch ( $status ) {
				
				case 'Completed'	: 
										
										wps_deals_update_payment_status( $payment_status, $orderid );
										break;
				case 'Reversed'		:
	            case 'Chargeback'	:
		            					$args = array();
										$args['order_id'] = $orderid;
										$args['email'] = $userdetails['user_email'];
										$args['status'] = $status;
										
										//send email to buyer		
										$model->wps_deals_send_order_status_email( $args );
										
										$adminargs = array( 
																'subject'	=>	sprintf( __( 'Payment for order %s refunded/reversed', 'wpsdeals' ), $orderid ),
																'message'	=>	sprintf( __( 'Order %s has been marked as refunded - PayPal reason code: %s', 'wpsdeals' ), $orderid, $_POST['reason_code']),
															);
										
										//send email to admin
										$model->wps_deals_send_order_status_email_admin( $adminargs );
						
										wps_deals_update_payment_status( $payment_status, $orderid );
										
										break;
				case 'Refunded'	:
									if( $orderdata['order_total'] == ( $_POST['mc_gross'] * -1 ) ) {
										
										$args = array();
										$args['order_id'] = $orderid;
										$args['email'] = $userdetails['user_email'];
										$args['status'] = $status;
										
										//send email to buyer		
										$model->wps_deals_send_order_status_email( $args );
										
										$adminargs = array( 
																'subject'	=>	sprintf( __( 'Payment for order %s refunded/reversed', 'wpsdeals' ), $orderid ),
																'message'	=>	sprintf( __( 'Order %s has been marked as refunded - PayPal reason code: %s', 'wpsdeals' ), $orderid, $_POST['reason_code']),
															);
										
										//send email to admin
										$model->wps_deals_send_order_status_email_admin( $adminargs );
						
										wps_deals_update_payment_status( $payment_status, $orderid );
									}
									break;
				default 		:
						            wps_deals_update_payment_status( $payment_status, $orderid );
						            break;
			}
			
			do_action( 'wps_deals_verify_paypal_ipn',$orderid );
		}
		
	}
	
}
add_action('init','wps_deals_paypal_verfication',100);

/**
 * Direct Buy with Paypal
 * 
 * Handles to direct buy with paypal
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
 
function wps_deals_paypal_buy_now() {
	
	global $wps_deals_price,$current_user;
	
	// Check payment mode directly Buy Now
	if( is_user_logged_in() &&  isset( $_GET['dealsaction'] ) && $_GET['dealsaction'] == 'buynow' 
		&& isset( $_GET['dealid'] ) && !empty( $_GET['dealid'] ) ) {
			
		// deal id
		$dealid = $_GET['dealid'];
			
		// deal price
		$productprice = $wps_deals_price->wps_deals_get_price( $dealid );
			
		$cartdetails = array(
									'total' 	=> $productprice,
									'subtotal' 	=> $productprice,
									'products' 	=> array(
															$dealid => array(
																				'dealid' => $dealid,
																				'quantity' => '1'
																			)
														)
								);
		$postdata = array(
							'wps_deals_cart_user_first_name'=> $current_user->first_name,
							'wps_deals_cart_user_last_name' => $current_user->last_name,
							'wps_deals_cart_user_email' 	=> $current_user->user_email,
							'user_name' 					=> $current_user->display_name
						);
									
		wps_deals_process_payment_paypal( $cartdetails, $postdata );
			
	}
	
}
add_action('init','wps_deals_paypal_buy_now');
?>