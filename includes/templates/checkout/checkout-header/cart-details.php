<?php 

/**
 * Template For Cart Details
 * 
 * Handles to return design of shopping cart table
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-header/cart-details.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $wps_deals_render,$wps_deals_cart,
			$wps_deals_price,$wps_deals_currency;
	
	$prefix = WPS_DEALS_META_PREFIX;
	
	//render class
	$render = $wps_deals_render;
	
	//price class
	$price = $wps_deals_price;
	
	//cart class 
	$cart = $wps_deals_cart;
	
	//currency error
	$currency = $wps_deals_currency;
	
	$cartdetails = $cart->get();
	
?>
<div class="wps-deals-cart-details row-fluid">
	<?php
		
		if(!empty($cartdetails)) { //check cart details should not blank
			
			//current date time
			$today = date('Y-m-d H:i:s');
			
			$totalamount = isset($cartdetails['total']) ? $cartdetails['total'] : '';
			
			$totalqty = 0;
			$discount = 0;
			
			//do action to add something before cart details
			do_action( 'wps_deals_cart_table_before', $cartdetails );
			
		?>
		<table class="table">
			<thead>
				<tr class="alternate">
					<?php 
							//do action to add something before cart details table header
							do_action( 'wps_deals_cart_table_header_before' );
					?>
					<th class="wps-deals-remove">&nbsp;</th>
					<th class="wps-deals-name"><?php _e('Product','wpsdeals');?></th>
					<?php 
							//do action to add something after product head
							do_action( 'wps_deals_cart_table_header_product_after' );
					?>
					<th class="wps-deals-quantity"><?php _e('QTY','wpsdeals');?></th>
					<?php 
							//do action to add something after qunatity
							do_action( 'wps_deals_cart_table_header_qty_after' );
					?>
					<th class="wps-deals-subtotal"><?php _e('Price','wpsdeals');?></th>
					<?php 
							//do action to add something after cart details table header 
							do_action( 'wps_deals_cart_table_header_after' );
					?>
				</tr>
			</thead>
			
			<tbody>
				
			<?php 	
				
				//do action to add before table content
				do_action( 'wps_deals_cart_table_content_before', $cartdetails );
				
					foreach ($cartdetails['products'] as $item)	 {
									
						$error = '';
						$dealname = get_the_title($item['dealid']);
						
						//product price
						$productprice = $price->wps_deals_get_price($item['dealid']);
						
							$quantity = $item['quantity'];
						
						$totalqty =	($totalqty + $quantity);
						
						//get the value of quantity availablity of stock
						$available = get_post_meta($item['dealid'],$prefix.'avail_total',true);
						
						//get the value of end date 
						$enddate = get_post_meta($item['dealid'],$prefix.'end_date',true);
						
						//get the value of end date 
						$startdate = get_post_meta($item['dealid'],$prefix.'start_date',true);
						
						if ($enddate < $today) { //check deal end date is greater then current date
							$error = __('No longer available.','wpsdeals');
						}else if ($startdate > $today) { //check deal start date for deal is started or not
							$error = __('Not started yet.','wpsdeals');
						}else if($available != '' && $available < 1) { //check product availablity
							$error = __('Out of Stock.','wpsdeals');
						} else if ($quantity > $available && $available != '') { //check inserted quantity and available 
							$error = sprintf( __('Only %1$s deal(s) are available.', 'wpsdeals' ), $available );
						}
			?>
						<tr class="wps-deals-product-details">
							<?php 
								// do action to add before deal remove icon
								do_action( 'wps_deals_cart_table_deal_remove_before', $item['dealid'] );
							?>
							<td class="wps-deals-remove">
								<a href="javascript:void(0);" class="wps-deals-cart-item-remove" item-id="<?php echo $item['dealid'];?>" title="<?php _e('Remove Item','wpsdeals');?>"><img src="<?php echo WPS_DEALS_URL;?>includes/images/cross.gif" alt="<?php _e('Remove','wpsdeals');?>"/></a>
							</td>
							<?php 
								// do action to add after deal remove icon
								do_action( 'wps_deals_cart_table_deal_remove_after', $item['dealid'] );
							?>
							<td class="wps-deals-name">
								<a href="<?php echo get_permalink($item['dealid']);?>" title="<?php echo $dealname;?>"><?php echo $dealname;?></a><br />
								<span class="wps-deals-checkout-error"><?php echo $error;?></span>
							</td>
							<?php 
								// do action to add after deal name
								do_action( 'wps_deals_cart_table_deal_name_after', $item['dealid'] );
							?>
							<td class="wps-deals-quantity">
								<input type="text" class="wps-deals-cart-item-qty-value" item-id="<?php echo $item['dealid'];?>" value="<?php echo $quantity;?>" size="1"/>
							</td>
							<?php 
								// do action to add after deal quantity
								do_action( 'wps_deals_cart_table_deal_qty_after', $item['dealid'] );
							?>
							<td class="wps-deals-subtotal">
								<?php echo $price->get_display_price( $productprice, $item['dealid'] );?>
							</td>
							<?php 
								// do action to add after deal price
								do_action( 'wps_deals_cart_table_deal_price_after', $item['dealid'] );
							?>
						</tr>
			<?php
					}
				
				//do action to add someting before subtotal
				do_action( 'wps_deals_cart_table_content_subtotal_before', $cartdetails );
					
				$cartsubtotal = $cart->show_subtotal();
				$carttotal = $cart->show_total();
			
				if( $cartsubtotal != $carttotal )	{ //check if cart subtotal and total are not same then show subtotal row
					?>	
						
						<tr class="wps-deals-cart-subtotal-row alternate">
							<td colspan="3" class="subtotal"><strong><?php _e('Sub Total','wpsdeals');?></strong></td>
							<td class="wps-deals-cart-item-qty wps-deals-subtotal"><?php echo $currency->wps_deals_formatted_value($cartsubtotal);?></td>
						</tr>
					<?php
				
				} //end if
									
				//do action to add before table after
				do_action( 'wps_deals_cart_table_content_after', $cartdetails );
			?>
			</tbody>
			
			<tfoot>
					<?php 
							//do action to show row before cart footer
							do_action( 'wps_deals_cart_table_footer_before', $cartdetails );
					?>
					<tr class="alternate">
						<td class="total" colspan="3"><?php _e('Total ','wpsdeals');?></td>
						<td class="wps-deals-cart-item-qty wps_deals_cart_total"><?php echo $currency->wps_deals_formatted_value($carttotal);?></td>
					</tr>
					<?php 
							//do action to show row after cart footer
							do_action( 'wps_deals_cart_table_footer_after', $cartdetails );
					?>
		 	<tfoot>
		</table>
<?php
	
		//do action to add something after cart details table
		do_action( 'wps_deals_cart_table_after', $cartdetails );
	
	} else {
		
		//do action cart empty
		do_action( 'wps_deals_cart_empty' );
	}
?>
</div><!--wps-deals-cart-details-->