<?php

/**
 * Orederd Deals
 * 
 * Template for Ordered Deals
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/orders/orders.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<div class="wps-deals-sales">
	
	<?php 
	
		global $current_user,$wps_deals_model,
				$wps_deals_currency,$wps_deals_options,
				$wps_deals_render,$wps_deals_scripts;
		
				
		if ( is_user_logged_in() ) {
		
			$perpage = isset($wps_deals_options['per_page']) ? $wps_deals_options['per_page'] : '10';
			
			//model class
			$model = $wps_deals_model;
			
			//currency class
			$currency = $wps_deals_currency;
			
			//render class
			$render = $wps_deals_render;
			
			// creating new array for all sold deals count
			$argscount = array(
									'author' 	=>	$current_user->ID,
									'getcount'	=>	'1'
								);
			
			//getting all sold deals count
			$datacount = $model->wps_deals_get_sales($argscount);
			
			// start paging
			$paging = new Wps_Deals_Pagination_Public();
				
			$paging->items( $datacount ); 
			$paging->limit( $perpage ); // limit entries per page
			
			if( isset( $_POST['paging'] ) ) {
				$paging->currentPage( $_POST['paging'] ); // gets and validates the current page
			}
			
			$paging->calculate(); // calculates what to show
			$paging->parameterName( 'paging' );
			$paging->adjacents(1); // no. of pages away from the current page
			
			// setting the limit to start
			$limit_start = ( $paging->page - 1 ) * $paging->limit;
			
			// creating a new array for all approved revies
			
			
			if(isset($_POST['paging'])) { 
				
				//ajax call pagination
				$argsdata = array(
									'author' 			=>	$current_user->ID,
									'posts_per_page' 	=>	$perpage,
									'paged'				=>	$_POST['paging']
								);
				
			} else {
				//on page load 
				$argsdata = array(
									'author' 			=>	$current_user->ID,
									'posts_per_page' 	=>	$perpage,
									'paged'				=>	'1'
								);
			}
			$ordereddeals = $model->wps_deals_get_sales($argsdata);
			
			if( !empty( $ordereddeals ) ) {
				
				//do action add something before orders pagination befoer
				do_action( 'wps_deals_orders_pagination_before' );
				
				// start displaying the paging if needed
			?>
			
				<div class="wps-deals-paging">
					<div id="wps-deals-tablenav-pages" class="wps-deals-tablenav-pages">
						<?php echo $paging->getOutput(); ?>
					</div>
				</div>
				<div class="wps-deals-sales-loader">
					<img src="<?php echo WPS_DEALS_URL;?>includes/images/cart-loader.gif"/>
				</div>
				
				<?php 
						//do action add something before orders table
						do_action( 'wps_deals_orders_table_before' );
				?>
				
				<table class="wps-deals-ordered-table">
					
					<thead>
						<tr class="wps-deals-ordered-row-head">
								<?php 
										//do action to add header title of orders list before
										do_action('wps_deals_orders_header_before');
								?>
								<th><?php _e('Order ID','wpsdeals');?></th>
								<th><?php _e('Order Date','wpsdeals');?></th>
								<th><?php _e('Status','wpsdeals');?></th>
								<th><?php _e('Order Amount','wpsdeals');?></th>
								<th><?php _e('Details','wpsdeals');?></th>
								<?php 
										//do action to add header title of orders list after
										do_action('wps_deals_orders_header_after');
								?>
						</tr>
					</thead>
					
					<tbody>
					<?php
						foreach ($ordereddeals as $order) {
							
							$details = $model->wps_deals_get_post_meta_ordered( $order['ID'] );
							$payment_status = $model->wps_deals_get_ordered_payment_status($order['ID']);
							$userdetails = $model->wps_deals_get_ordered_user_details($order['ID']);
							$orderddate = $model->wps_deals_get_date_format($order['post_date']);
							$ipndata = $model->wps_deals_get_ipn_data($order['ID']);
							$ordertotal = $details['display_order_total'];
					?>			
						<tr class="wps-deals-ordered-row-body">
							<?php 
									//do action to add row for orders list before
									do_action( 'wps_deals_orders_row_before', $order['ID'] ); 
							?>
							<td><?php echo $order['ID'];?></td>
							<td><?php echo $orderddate;?></td>
							<td><?php echo $payment_status;?></td>
							<td><?php echo $ordertotal;?></td>
							<?php
									//order view page url
									$order_query = get_permalink( $wps_deals_options['payment_thankyou_page'] );
									$order_query = add_query_arg( array('order_id' => $order['ID']), $order_query );
							?>
							<td><a href="<?php echo $order_query; ?>" title="<?php _e('View Details','wpsdeals');?>"><?php _e('View Details','wpsdeals');?></a></td>
							<?php 
									//do action to add row for orders list after
									do_action( 'wps_deals_orders_row_after', $order['ID'] ); 
							?>
						</tr>
				<?php	} ?>
					</tbody>
					<tfoot>
						<tr class="wps-deals-ordered-row-foot">
							<?php 
									//do action to add row in footer before
									do_action('wps_deals_orders_footer_before');
							?>
							<th><?php _e('Order ID','wpsdeals');?></th>
							<th><?php _e('Deal Name','wpsdeals');?></th>
							<th><?php _e('Status','wpsdeals');?></th>
							<th><?php _e('Order Amount','wpsdeals');?></th>
							<th><?php _e('Details','wpsdeals');?></th>
							<?php 
									//do action to add row in footer after
									do_action('wps_deals_orders_footer_after');
							?>
						</tr>
					</tfoot>
				</table>
		<?php 
				//do action add something after orders table after	
				do_action( 'wps_deals_orders_table_after' );
			
			} else {
		?>		
			<p><?php _e('You have not purchased any deals yet.','wpsdeals');?></p>
	
		<?php	
			}
			
		} else {
			
		?>	
			<p><?php _e('You need to be logged in to your account to see your purchase history.','wpsdeals');?></p>
			
		<?php 
		
		}
	?>
</div><!--.wps-deals-sales-->