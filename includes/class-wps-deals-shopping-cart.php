<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shopping Cart Class
 * 
 * Handles all functionalities of shopping cart
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */

class Wps_Deals_Shopping_Cart {
	
	var $price;
	
	public function __construct() {
		
		global $wps_deals_price;
		$this->price = $wps_deals_price;
		//$this->calculate();
		
	}
	
	/**
	 * Get Cart Products Details
	 * 
	 * Handles to get details of currently added product into the cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function getproduct() {
		
		$this->calculate();
		//get cart data from session
		$cartdata = isset($_SESSION['deals-cart']['products']) ? $_SESSION['deals-cart']['products'] : false;
		return $cartdata;
	}
	
	/**
	 * Get Cart Details
	 * 
	 * Handles to get details of currently added product into the cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function get() {
		
		$this->calculate();
		//get cart data from session
		$cartdata = isset($_SESSION['deals-cart']) ? $_SESSION['deals-cart'] : false;
		return $cartdata;
	}
	
	/**
	 * Add Product to Cart Details
	 * 
	 * Handles to add products to cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function add($args=array()) {
		
		$dealid = $args['dealid'];
		$qty = $args['quantity'];
		
		//get cart data
		$getcart = $this->getproduct();
		
		$alldatacart = $this->get();
		
		//check cart is not empty then append cart data
		$add = !empty($getcart) && $getcart != false ? $getcart : array();
		
		//total price
		$totalprice = isset($alldatacart['total']) ? $alldatacart['total'] : 0;
		
		//subtotal price
		$subtotal = isset($alldatacart['subtotal']) ? $alldatacart['subtotal'] : 0;
		//sale price
		$sale_price = $this->price->wps_deals_get_price($dealid);
		
		if($this->item_in_cart($dealid) != true) { //check deal id is exist or not
		
			$add[$dealid]	=	array(
												'dealid'	=>	$dealid,
												'quantity'	=>	$qty
											);
			
			$totalprice = $totalprice + ($sale_price * $qty);
			$subtotal = $subtotal + ($sale_price * $qty);
			
		} else {
			//if item is exist in cart then update quantity in cart
			$existdata = array();
			$existdata['dealid'] =	$getcart[$dealid]['dealid'];
			$existdata['quantity']	=	($getcart[$dealid]['quantity'] + $qty);
			
			$totalprice = $totalprice + ($sale_price * $existdata['quantity']);
			$subtotal = $subtotal + ($sale_price * $existdata['quantity']);
			
			$add[$dealid]	=	$existdata;
		}
		$alldatacart['total'] = $totalprice;
		$alldatacart['subtotal'] = $subtotal;
		$alldatacart['products'] = $add;
		
		$this->modifysession($alldatacart); 
		return true;
		
	}
	
	/**
	 * Update Cart Quantity
	 * 
	 * Handles to update product quantity to cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function update($args=array()) {
		
		//get cart data
		$cartdata = $this->get();
			
		$products = $cartdata['products'];
		
		$updated = array();
		
		$i = 0;
		$totalprice = 0;
		$subtotal = 0;
		
		foreach ($products as $key => $value) {

			$sale_price = $this->price->wps_deals_get_price($value['dealid']);
		
			$quantity = isset($args['quantity']) ? $args['quantity'] : array();
			$qty = isset($quantity[$i]) ? $quantity[$i] : $products[$key]['quantity'];//
			
		
			$updated[$key] = array( 
										'dealid' => $value['dealid'],
										'quantity' => $qty
									);
			if(empty($updated[$key]['quantity'])) {
				unset($updated[$key]);
			}
			$subtotal = $subtotal + ($sale_price * $qty);
			$i++;
		}
		
		$totalprice = $subtotal;
		$cartdata['products'] = $updated;
		$cartdata['subtotal'] = $subtotal;
		$cartdata['total'] = $totalprice;
		
		$this->modifysession($cartdata); 
		
		return true;
		
	}
	
	/**
	 * Remove Product From Cart
	 * 
	 * Handles to remove product quantity to cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function remove($id) {
		
		if(!empty($id)) {
			unset($_SESSION['deals-cart']['products'][$id]);
		}
		
		//get cart data
		$getcart = $this->get();
		
		if(empty($getcart['products'])) {
			//$_SESSION['deals-cart']['products'] = $getcart['products'];	
			unset($_SESSION['deals-cart']);
		} else {
			$_SESSION['deals-cart']['products'] = $getcart['products'];	
			
			//update cart
			$this->update();
		}
		
		
		return true;
		
	}
	/**
	 * Empty Cart
	 * 
	 * Handles to remove product quantity to cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function cartempty() {
		
		//remove all item from cart
		unset($_SESSION['deals-cart']);
		return true;
		
	}
	
	/**
	 * Check product in Cart
	 * 
	 * Handles to check product is in cart or not
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function item_in_cart($id) {
		
		//get cart data
		$indata = $this->getproduct();
		$result = false;
		
		if(!empty($indata) && array_key_exists($id,$indata)) { //check item is already in cart or not
			$result = true;
		} else {
			$result = false;
		}
		return $result;
	}
	
	/**
	 * Calculate Sub Total of Cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 * 
	 */
	public function calculate() {
		
		//$cartdata = $this->get();
		$cartdata = isset($_SESSION['deals-cart']) ? $_SESSION['deals-cart'] : false;
		
		if(!empty($cartdata)) {
			
			$products = isset($cartdata['products']) && !empty($cartdata['products']) ? $cartdata['products'] : array();
			$subtotal = 0;
			$total = 0;
			
			foreach ($products as $key => $value) {
			
				$sale_price = $this->price->wps_deals_get_price($value['dealid']);
				$subtotal = $subtotal + ($sale_price * $value['quantity']);
			}
			$cartdata['subtotal'] = $subtotal;
			$cartdata['total']	= $subtotal;
			$this->modifysession($cartdata);
		}
		return $cartdata;
	}
	
	/**
	 * Calculate Sub Total Of Cart
	 * 
	 * Handles to show Sub Total of Product in Cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function show_subtotal() {
		
		$cartdata = $this->get();
		$subtotal = $cartdata['subtotal'];
		return $subtotal;
	}
	
	/**
	 * Calculate Sub Total Of Cart
	 * 
	 * Handles to show Sub Total of Product in Cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function show_total() {
		
		$cartdata = $this->get();
		$total = $cartdata['total'];
		return $total;
	}
	/**
	 * Modify Session
	 * 
	 * Handles to overwrite session
	 * This is called from add(),update(),calculate() and from discount and tax addons
	 */
	public function modifysession($cartdata) {
		
		$_SESSION['deals-cart'] = apply_filters('wps_deals_cart_session_update',$cartdata);
	}
	
}