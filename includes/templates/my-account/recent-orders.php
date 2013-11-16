<?php 

/**
 * Template For My Account Recent Orders
 * 
 * Handles to return for my account page recent orders
 * 
 * Override this template by copying it to yourtheme/deals-engine/my-account/recent-orders.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_options;

?>
<div class="wps-deals-recent-ordered-deals">
	<h3><?php _e( 'Recent Orders', 'wpsdeals' );?></h3>
	
	<table id="wps-deals-my-account-recent-deals" class="wps-deals-ordered-table">
		<thead>
				<tr class="wps-deals-ordered-row-head">
					<?php 
						//do action to add header before in my account page head
						do_action( 'wps_deals_my_account_recent_header_foot_before' );
					?>
					<th><?php _e( 'Order ID', 'wpsdeals' );?></th>
					<th><?php _e( 'Date', 'wpsdeals' );?></th>
					<th><?php _e( 'Status', 'wpsdeals' );?></th>
					<th><?php _e( 'Total', 'wpsdeals' );?></th>
					<th><?php _e( 'Details', 'wpsdeals' );?></th>
					<?php 
						//do action to add header after in my account page head
						do_action( 'wps_deals_my_account_recent_header_foot_after' );
					?>
				</tr>
		</thead>
		<tbody>
		<?php
			foreach ( $orderdata as $key => $order ) {
				
				//order view page url
				$order_query = get_permalink( $wps_deals_options['payment_thankyou_page'] );
				$order_query = add_query_arg( array('order_id' => $order['order_id'] ), $order_query );
				
				//counter label for purchased deals
				$countlabel = $order['deal_count'] > 1 ? 'deals' : 'deal';
			
		?>
				<tr class="wps-deals-ordered-row-body">
					<?php 
						//do action to add details before
						do_action( 'wps_deals_my_account_recent_details_before', $order['order_id'] );
					?>
					<td><?php echo $order['order_id']?></td>
					<td><?php echo $order['order_date'];?></td>
					<td><?php echo $order['payment_status'];?></td>
					<td><?php printf( __( '%s for %s %s', 'wpsdeals' ), $order['order_total'], $order['deal_count'], $countlabel );?></td>
					<?php
						//do action to add details after total column
						do_action( 'wps_deals_my_account_recent_details_total_after', $order['order_id'] );
					?>
					<td><a href="<?php echo $order_query;?>"><?php _e( 'View Details', 'wpsdeals');?></a></td>
					<?php
						//do action to add details after
						do_action( 'wps_deals_my_account_recent_details_after', $order['order_id'] );
					?>
				</tr>
		<?php		
			}
		?>
		</tbody>
		<tfoot>
				<tr class="wps-deals-ordered-row-foot">
					<?php 
						//do action to add header before in my account page head
						do_action( 'wps_deals_my_account_recent_header_foot_before' );
					?>
					<th><?php _e( 'Order ID', 'wpsdeals' );?></th>
					<th><?php _e( 'Date', 'wpsdeals' );?></th>
					<th><?php _e( 'Status', 'wpsdeals' );?></th>
					<th><?php _e( 'Total', 'wpsdeals' );?></th>
					<th><?php _e( 'Details', 'wpsdeals' );?></th>
					<?php 
						//do action to add header after in my account page head
						do_action( 'wps_deals_my_account_recent_header_foot_after' );
					?>
				</tr>
		</tfoot>
	</table>
</div><!--.wps-deals-recent-purchased-deals-->
