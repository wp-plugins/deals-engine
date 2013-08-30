<?php 

/**
 * Template For Order Complete Details
 * 
 * Handles to return order complete details
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/orders/order-complete-details.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

global $wps_deals_model;

$model = $wps_deals_model;

if( isset($_GET['order_id']) && !empty( $_GET['order_id'] ) ) {

	$order_id = $_GET['order_id'];

	$salesdata = get_post( $order_id );

	// get the value for the user details from the post meta box
	$userdetails = $model->wps_deals_get_ordered_user_details($order_id);
	
	// get the value for the order details from the post meta box
	$order_details = $model->wps_deals_get_post_meta_ordered($order_id);
	
	// get the value for the payment status from the post meta box
	$payment_status = $model->wps_deals_get_ordered_payment_status($order_id);
	
	//get order date for payment
	$orderddate = $model->wps_deals_get_date_format($salesdata->post_date);
	
	//get ordered files
	$orderedfiles = $model->wps_deals_get_ordered_file_list( $order_id );
	
	//do action for view order content before
	do_action( 'wps_deals_order_view_content_before',$order_id );
	
?>
		<table id="wps-deals-purchase-receipt">
			<thead>
				<tr>
					<th><strong><?php _e( 'Purchase ID', 'wpsdeals' ); ?>:</strong></th>
					<th><?php echo $order_id; ?></th>
				</tr>
			</thead>
		
			<tbody>
				<?php 
						//do action for view order details row before
						do_action( 'wps_deals_order_view_row_before', $order_id );
				?>
				<tr>
					<td><strong><?php _e( 'Purchase Date', 'wpsdeals' ); ?>:</strong></td>
					<td><?php echo $orderddate; ?></td>
				</tr>
				<?php 
						//do action for view order details row after purchase date
						do_action( 'wps_deals_order_view_purchase_date_after', $order_id );
				?>
				<tr>
					<td><strong><?php _e( 'Email', 'wpsdeals' ); ?>:</strong></td>
					<td><?php echo $userdetails['user_email']; ?></td>
				</tr>
				<?php 
						//do action for view order details row after email
						do_action( 'wps_deals_order_view_email_after', $order_id );
				?>
				<tr>
					<td><strong><?php _e( 'Total Price', 'wpsdeals' ); ?>:</strong></td>
					<td>
						<?php echo $order_details['display_order_total']; ?>
					</td>
				</tr>
				<?php 
						//do action for view order details row after total price
						do_action( 'wps_deals_order_view_total_after', $order_id );
				?>
				<tr>
					<td><strong><?php _e( 'Payment Method', 'wpsdeals' ); ?>:</strong></td>
					<td><?php echo apply_filters( 'wps_deals_order_view_payment_method', $order_details['payment_method'] ); ?></td>
				</tr>
				<?php 
						//do action for view order details row after payment method
						do_action( 'wps_deals_order_view_paymethod_after', $order_id );
				?>
				<tr>
					<td class="wps-deals-payment-status"><strong><?php _e( 'Payment Status', 'wpsdeals' ); ?>:</strong></td>
					<td class="wps-deals-payment-status <?php echo strtolower( $payment_status ); ?>"><?php echo $payment_status; ?></td>
				</tr>
				<?php 
						//do action for view order details row after payment status
						do_action( 'wps_deals_order_view_paystatus_after', $order_id );
				?>
				<tr>
					<td><strong><?php _e( 'IP Address', 'wpsdeals' ); ?>:</strong></td>
					<td><?php echo $order_details['order_ip']; ?></td>
				</tr>
				<?php 
						//do action for view order details row after IP address
						do_action( 'wps_deals_order_view_ipaddress_after', $order_id );
				?>
			</tbody>
		</table>
		
		<h3><?php echo apply_filters( 'wps_deals_payment_receipt_products_title', __( 'Purchased Deals', 'wpsdeals' ) ); ?></h3>
		
		<table id="wps-deals-purchase-receipt-products">
			<thead>
				<?php 
						//do action to add header in order item details before
						do_action( 'wps_deals_order_view_details_before' );
				?>
				<th><?php _e( 'Name', 'wpsdeals' ); ?></th>
				<th><?php _e( 'Quantity', 'wpsdeals' ); ?></th>
				<th><?php _e( 'Price', 'wpsdeals' ); ?></th>
				<th><?php _e( 'Total', 'wpsdeals' ); ?></th>
				<?php 
						//do action to add header in order item details after
						do_action( 'wps_deals_order_view_details_after' );
				?>
			</thead>
		
			<tbody>
			
			<?php 
			
				//do action to add row in view order item details row before loop
				do_action( 'wps_deals_order_view_details_row_before', $order_id );
			
				foreach ( $order_details['deals_details'] as $product ) { ?>
			
					<?php 
						//do action to add row in view order item details table before
						do_action( 'wps_deals_order_view_details_row_loop_before', $product, $order_id );
					?>
				<tr>
					<?php 
						//do action to add row in view order item details after deal name
						do_action( 'wps_deals_order_view_details_name_before', $product, $order_id );
					?>
					<td>
						<div class="wps-deals-purchase-receipt-product-name">
						<?php 
								$deal = get_post( $product['deal_id'] );
								
								if( !empty( $deal ) ) {
						?>
									<a href="<?php echo get_permalink($product['deal_id']);?>" title="<?php echo $product['deal_title'];?>">
										<?php echo $product['deal_title']; ?>
									</a>
						<?php	} else { 
									echo $product['deal_title']; 
								} 
						?>
						</div>
						<?php
						
							//get deal type
							$dealtype = $model->wps_deals_get_deal_type( $product['deal_id'] );
							
							if( $dealtype == 'simple' ) { //check deal type is simple
								
								$downloadfiles = '';
								
								$downloadfiles .= '<ul class="wps-deals-purchase-receipt-files">';
								
								if( !empty( $orderedfiles[$product['deal_id']] ) && is_array( $orderedfiles[$product['deal_id']] ) ) {
									
									foreach ( $orderedfiles[$product['deal_id']] as $key => $file ) {
										
										//get file name from deal id and file key
										$filename = $model->wps_deals_get_download_file_name( $product['deal_id'], $key );
										
										if( !empty( $filename ) ) { // check file name is exist or not
											
											//make file display to user
											$filedisplay = sprintf( __( 'Download File %d : ','wpsdeals' ), ( $key + 1 ) ) . '<a href="'.$file.'" target="_blank">'.$filename.'</a>';
											
											$downloadfiles .= '<li>'.$filedisplay.'</li>';
										}
										
									} //end for loop
									
								} else {
									$downloadfiles .= '<li>' . __( 'No downloadable files found.', 'wpsdeals' ) . '</li>';
								}
								
								$downloadfiles .= '</ul>';
								
								echo apply_filters( 'wps_deals_order_download_files', $downloadfiles, $product['deal_id'], $order_id );
								
							} //end if deal type
						?>
					</td>
					<?php 
						//do action to add row in view order item details after deal name
						do_action( 'wps_deals_order_view_details_name_after', $product, $order_id );
					?>	
					<td>
						<?php echo $product['deal_quantity']; ?>
					</td>
					<?php 
						//do action to add row in view order item details after purchased quantity
						do_action( 'wps_deals_order_view_details_qty_after', $product, $order_id );
					?>	
					<td>
						<?php echo $product['display_price']; ?>
					</td>
					<?php 
						//do action to add row in view order item details after deal price
						do_action( 'wps_deals_order_view_details_price_after', $product, $order_id );
					?>	
					<td>
						<?php echo $product['display_total']; ?>
					</td>
					<?php 
						//do action to add row in view order item details after deal total value
						do_action( 'wps_deals_order_view_details_total_after', $product, $order_id );
					?>	
					
					<?php //do_action('wps_deals_popup_ordered_items_front_data_after',$product); ?>
				</tr>
					<?php 
						//do action to add row in view order item details after inside loop
						do_action( 'wps_deals_order_view_details_row_loop_after', $product, $order_id );
				} 
				
						//do action to add row in view order item details row after loop
						do_action( 'wps_deals_order_view_details_row_after', $order_id );
				?>
				
			</tbody>
		
			<tfoot>
				<?php 
						//do action to add row in footer row before
						do_action( 'wps_deals_order_view_footer_row_before', $order_id );
				?>
				<tr>
					<td colspan="2"></td>
					<td><?php _e('Sub Total','wpsdeals');?></td>
					<td><?php echo $order_details['display_order_subtotal'];?></td>
				</tr>
				<?php 
						//do action to add row after subtotal in order view
						do_action('wps_deals_order_view_details_subtotal_after',$order_id);?>
				<tr>
					<td colspan="2"></td>
					<td><?php _e('Total','wpsdeals');?></td>
					<td><?php echo $order_details['display_order_total'];?></td>
				</tr>
				<?php 
						//do action to add row in footer row after
						do_action('wps_deals_order_view_footer_row_after',$order_id);
				?>
			</tfoot>
		
		</table>
<?php	
		//do action for view order content after
		do_action('wps_deals_order_view_content_after',$order_id);

} else {
	
	echo apply_filters('wps_deals_success_order_message','<p>' . __( 'Thank you for your purchase! Your order has been completed successfully. You will receive an email from us within a few minutes containing the download link(s) from your purchased deal(s) as well as all the payment information for your records.', 'wpsdeals' ) . '</p>');
}
?>