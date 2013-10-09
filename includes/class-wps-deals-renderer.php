<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Renderer Class
 *
 * To handles some small HTML content for front end
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
class Wps_Deals_Renderer {

	var $model,$scripts,$currency,$cart,$price,$message;
	
	public function __construct() {
		
		global $wps_deals_model,$wps_deals_scripts,$wps_deals_currency,$wps_deals_cart,$wps_deals_price,$wps_deals_message;
		
		$this->model = $wps_deals_model;
		$this->scripts = $wps_deals_scripts;
		$this->currency = $wps_deals_currency;
		$this->cart = $wps_deals_cart;
		$this->price = $wps_deals_price;
		$this->message = $wps_deals_message;		
	}
	
	/**
	 * Show Deals List
	 * 
	 * Handles to return list of deals for custom post type
	 *
	 * @package Social Deals Engine
     * @since 1.0.0
	 */
		
	/**
	 * Empty Cart Message
	 *
	 * This will return Empty cart message
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_empty_cart_message() {
		return apply_filters('wps_deals_empty_cart_message', '<div class="wps-deals-error">'.__( 'Your cart is empty.', 'wpsdeals' ).'</div>' );
	}
	/**
	 * Get Order detail popup details
	 * 
	 * Handles to get popup view order details
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_get_order_popup_details($data){
		
		ob_start();
		
		$displayusername = isset($data['userdetails']['first_name']) && !empty($data['userdetails']['first_name']) 
							? $data['userdetails']['first_name'].' '.$data['userdetails']['last_name'] : $data['userdetails']['user_name'];
		
		echo '<div id="wps_deal_ordered_'.$data['ID'].'" class="wps-deals-view-details-wrap">
								<div class="wps-deal-bill-title">'.__('Billing Details','wpsdeals').'</div>';
									
		echo  '<div class="wps-deals-view-bill-details">
							<table>
								<tbody>';
									do_action('wps_deals_sales_admin_header_row_before',$data['ID']);
		echo '						<tr>
										<td><strong>'.__('Purchase Date : ','wpsdeals').'</strong></td>
										<td>'.$this->model->wps_deals_get_date_format($data[ 'post_date' ]).'</td>
									</tr>
									<tr>
										<td><strong>'.__('Purchase ID : ','wpsdeals').'</strong></td>
										<td>'.$data['ID'].'</td>
									</tr>
									<tr>
										<td><strong>'.__('Buyer Name : ','wpsdeals').'</strong></td>
										<td>'.$displayusername.'</td>
									</tr>
									<tr>
										<td><strong>'.__('Buyer Email : ','wpsdeals').'</strong></td>
										<td>'.$data['userdetails']['user_email'].'</td>
									</tr>
									<tr>
										<td><strong>'.__('Payment Method : ','wpsdeals').'</strong></td>
										<td>'.$data['payment_method'].'</td>
									</tr>
									<tr>
										<td><strong>'.__('Payment Status : ','wpsdeals').'</strong></td>
										<td>'.$data['payment_status'].'</td>
									</tr>
									<tr>
										<td><strong>'.__('IP Address : ','wpsdeals').'</strong></td>
										<td>'.$data['order_ip'].'</td>
									</tr>';
									do_action('wps_deals_sales_admin_header_row_after',$data['ID']);
		echo '					</tbody>
							</table>
						</div>';
		
		
		do_action('wps_deals_sales_paymentdetails_after_billing',$data['ID']);
		
		if( $data['payment_method'] == __( 'PayPal Standard', 'wpsdeals' ) ) { //check payment method
			
			echo '<div class="wps-deals-view-paypal-details">
					<img src="'.WPS_DEALS_URL.'includes/images/paypal_logo.gif" />
					<table class="wps-deals-view-paypal-txns" cellspacing="1" cellpadding="1" border="0">
						<tbody>
							<tr>
								<td class="wps-deals-txn-activity" colspan="7">'.__('Transaction Activity','wpsdeals').'</td>
							</tr>
							<tr class="wps-deals-txn-title">
								<td nowrap="nowrap">'.__('Date','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Name','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Payer Email','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Payment Status','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Gross','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Fee','wpsdeals').'</td>
								<td nowrap="nowrap">'.__('Net Amount','wpsdeals').'</td>
							</tr>';
							
							// get the value for the order ipn data from the post meta box
							$paypal_data = $data['ipndata'];
							
							if(!empty($paypal_data)) {
								
								$pay_gross = number_format($paypal_data['mc_gross'],2);
								$pay_fees = number_format($paypal_data['mc_fee'],2);
								$net_amount = number_format(($pay_gross - $pay_fees),2);
								$payment_date = $this->model->wps_deals_get_date_format($paypal_data['payment_date']);
								$payment_currency = $paypal_data['mc_currency'];
								
								echo '<tr class="wps-deals-txn-detail">
										<td nowrap="nowrap">'.$payment_date.'</td>
										<td nowrap="nowrap">'.$paypal_data['first_name'].' '.$paypal_data['last_name'].'</td>
										<td nowrap="nowrap">'.$paypal_data['payer_email'].'</td>
										<td nowrap="nowrap">'.$paypal_data['payment_status'].'</td>
										<td nowrap="nowrap">'.$this->currency->wps_deals_currency_symbol($payment_currency).' '.$pay_gross.'</td>
										<td nowrap="nowrap">'.$this->currency->wps_deals_currency_symbol($payment_currency).' '.$pay_fees.'</td>
										<td nowrap="nowrap">'.$this->currency->wps_deals_currency_symbol($payment_currency).' '.$net_amount.'</td> 																						
									</tr>';
							} else {
									
								echo '<tr class="wps-deals-txn-detail">
												<td colspan="7">'.__('No PayPal Transaction Information Available','wpsdeals').'</td>
										  </tr>';
							}
											
			echo '		</tbody>
					</table>
				</div><!--wps-deals-view-paypal-details-->';
		}
		
		do_action('wps_deals_sales_paymentdetails_before_items',$data['ID']);
								
		echo '<div class="wps-deals-view-product-details">
							<div class="wps-deal-bill-title">'.__('Item Ordered','wpsdeals').'</div>
								<table class="widefat fixed">
									<tbody>
										<thead>
											<tr>';
												do_action('wps_deals_sales_order_deatails_header_before',$data['ID']);
									   echo    '<th>'.__('Name','wpsdeals').'</th>
												<th>'.__('Quantity','wpsdeals').'</th>
												<th>'.__('Price','wpsdeals').'</th>
												<th>'.__('Total','wpsdeals').'</th>';
									   			do_action('wps_deals_sales_order_deatail_header_after',$data['ID']);
										echo '</tr>
										</thead>';
							$alternate = '';
							
							foreach ($data['deals_details'] as $deal) {	
																		
								echo '<tr '.$alternate.'>';
									
										do_action('wps_deals_sales_order_details_data_before',$data['ID']);
									
										echo '<td>'.get_the_title($deal['deal_id']).'</td>
											
											<td>'.$deal['deal_quantity'].'</td>
											
											<td>'.$deal['display_price'].'</td>
																											
											<td>'.$deal['display_total'].'</td>';
										
										do_action('wps_deals_sales_order_details_data_after',$data['ID']);	
										
								echo '</tr>';
								$alternate = $alternate ? '' : 'class="alternate"';
												
							}
							
							do_action('wps_deals_sales_popup_order_row_after',$data['ID']);
							
							echo '<tr class="alternate">
													
									<td colspan="2"></td>
									
									<td>'.__('Sub Total','wpsdeals').'</td>
									
									<td>'.$data['display_order_subtotal'].'</td>
									
								</tr>';
							
							do_action('wps_deals_sales_popup_order_row_after_subtotal',$data['ID']);
							
							echo '<tr class="alternate">
													
									<td colspan="2"></td>
									
									<td>'.__('Total','wpsdeals').'</td>
									
									<td>'.$data['display_order_total'].'</td>
									
								</tr>';
										
		echo '			</tbody>
								</table>';
					
		echo '	</div><!--wps-deals-view-product-details-->
						
					</div><!--.wps-deals-view-details-wrap-->';
		return ob_get_clean();
	}
	/**
	 * Cart Widget Content
	 * 
	 * Handles to get cart widget content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 *
	 */
	public function wps_deals_cart_widget_content() {
		
		global $wps_deals_options;
		
		$cartdata = $this->cart->get();
		$cartproducts = $cartdata['products'];
		
		$html = '';
		
		if( !empty( $cartproducts ) ) {
				
				$html .= '<table class="wps-deals-latest-widget-cart-items table">';
				$html .= '	<tbody>
								<tr>';
				$html = 			apply_filters('wps_deals_latest_widget_head_before',$html);
				$html .= '			<th class="dealname">'.__('Deal Name','wpsdeals').'</th>
									<th class="qty">'.__('QTY','wpsdeals').'</th>
									<th class="price">'.__('Price','wpsdeals').'</th>';
				$html = 			apply_filters('wps_deals_latest_widget_head_after',$html);
				$html .= '		</tr>';
				
				foreach ($cartproducts as $id => $deal) {
					
					$dealprice = $this->price->wps_deals_get_price( $deal['dealid'] );
					
					$html .= '<tr>';
					$html = 	apply_filters('wps_deals_latest_widget_data_before',$html);	
					$html .= '	<td class="dealname"><a href="'.get_permalink($deal['dealid']).'" title="'.get_the_title($deal['dealid']).'" >'.get_the_title($deal['dealid']).'</a></td>
								<td class="qty">'.$deal['quantity'].'</td>
								<td class="price">'.$this->price->get_display_price( $dealprice, $deal['dealid'] ).'</td>';
					$html = 	apply_filters('wps_deals_latest_widget_data_before',$html);	
					$html .= '</tr>';
					
				}
				
				$html .= '<tr class="total">';
				$html = 	apply_filters('wps_deals_latest_widget_total_before',$html);	
				$html .= '	<th colspan="2">'.__('Total','wpsdeals').'</th>
							<td class="price">'.$this->currency->wps_deals_formatted_value($cartdata['subtotal']).'</td>';
				$html = 	apply_filters('wps_deals_latest_widget_total_after',$html);
				$html .= '</tr>';
				
				$html .= '	</tbody>
						</table>';
				
			} else {
				
				ob_start();
				do_action( 'wps_deals_cart_empty' );
				$html .= ob_get_clean();
							
			}
						
			//continue shoping link
			$html .= '	<div class="wps-deals-widget-shopping-link">
							<a href="'.get_permalink($wps_deals_options['deals_main_page']).'" class="wps-deals-widget-cont-shop" title="'.__('Continue Shopping','wpsdeals').'">'.__('Continue Shopping &rarr;','wpsdeals').'</a>
							<a href="'.get_permalink($wps_deals_options['payment_checkout_page']).'" class="wps-deals-widget-view-cart" title="'.__('View Cart','wpsdeals').'">'.__('Checkout &rarr;','wpsdeals').'</a>
						</div>';
			return $html;
	}
	
	/**
	 * Add Issue Refund Button
	 * 
	 * Handles to add refund button
	 * for paypal payment
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_paypal_refund_issue_button( $orderid ) {
		
		$orderdata = $this->model->wps_deals_get_post_meta_ordered( $orderid );
		$payment_status = $this->model->wps_deals_get_ordered_payment_status( $orderid, true );
		
		if( current_user_can( 'manage_options' ) && 
			$orderdata['payment_method'] == WPS_DEALS_PAYPAL_GATEWAY && $payment_status == '1' ) { //if status is completed and payment gateway is paypal standard
			
			$refundurl = add_query_arg( array( 'page' => 'wps-deals-sales', 'action' => 'refund', 'orderid' => $orderid ), admin_url( 'edit.php?post_type='.WPS_DEALS_POST_TYPE ) );
		
			echo '<a href="'.$refundurl.'" class="button-primary wps-deals-issue-refund" title="'.__( 'Issue Refund', 'wpsdeals' ).'">'.__( 'Issue Refund', 'wpsdeals' ).'</a>';
				
		} 
	}
}
?>