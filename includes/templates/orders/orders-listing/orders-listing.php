<?php

/**
 * Orederd Deals Listing Markup
 * 
 * Template for Ordered Deals Listing Markup
 * 
 * Override this template by copying it to 
 * yourtheme/deals-engine/orders/orders-markup.php
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 **/

	global $wps_deals_model, $wps_deals_options;

	//model class
	$model = $wps_deals_model;

?>

<div class="wps-deals-paging">
	<div id="wps-deals-tablenav-pages" class="wps-deals-tablenav-pages">
		<?php echo $paging->getOutput(); ?>
	</div>
</div>
<div class="wps-deals-sales-loader">
	<img src="<?php echo WPS_DEALS_URL;?>includes/images/cart-loader.gif"/>
</div>
<div class="wps-deals-clear"></div>

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
		foreach ( $ordereddeals as $order ) {
			
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
			<th><?php _e('Order Date','wpsdeals');?></th>
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