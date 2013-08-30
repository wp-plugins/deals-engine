<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes Class
 *
 * Handles shortcodes functionality of plugin
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
class Wps_Deals_Shortcodes {
	
	var $model,$scripts,$render,$cart,$currency,$message;
	
	function __construct(){
		
		global $wps_deals_model,$wps_deals_scripts,$wps_deals_render,$wps_deals_cart,
				$wps_deals_currency,$wps_deals_message;
		
		$this->model = $wps_deals_model;
		$this->scripts = $wps_deals_scripts;
		$this->render = $wps_deals_render;
		$this->cart = $wps_deals_cart;
		$this->currency = $wps_deals_currency;
		$this->message = $wps_deals_message;
		
	}
	
	/**
	 * Get All Deals Data
	 * 
	 * Handles to getting all deals data on the viewing page
	 * whereever user put shortcode
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0 
	 */
	
	public function wps_deals_all($content) {
		
		ob_start();
		//do action to add before home header
		do_action( 'wps_deals_home_content' );
		$content .= ob_get_clean();
		return $content;
	}
	
	/**
	 * Checkout Page
	 * 
	 * Handles to show details of cart to user
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_checkout($content) {
		
		ob_start();
		//do action for add checkout page
		do_action( 'wps_deals_checkout_content' );
		$content .= ob_get_clean();
		return $content;
	}
	
	/**
	 * Order Completed
	 * 
	 * Handles to show messsage order is completed successfully
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_order_complete( $content ) {
		
		ob_start();
		//do action to show orders details which is completed
		do_action( 'wps_deals_orders_complete_content' );
		$content .= ob_get_clean();
		return $content;
	}
	/**
	 * Order Cancelled
	 * 
	 * Handles to show messsage order will cancelled
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_order_cancelled( $content ) {
		
		ob_start();
		//do action to show orders details which is cancel
		do_action( 'wps_deals_orders_cancel_content' );
		$content .= ob_get_clean();
		return $content;
	
	}
	
	/**
	 * Orders Details
	 * 
	 * Handles to show details of orders placed by users
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_orders( $content ) {
		
		ob_start();
		//do action to show order details
		do_action( 'wps_deals_orders_content' );
		return $content .= ob_get_clean();
		
	}
	
	/**
	 * Deals By Category
	 * 
	 * Handles to show deals by category
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_by_category( $atts, $content ) {
		
		extract( shortcode_atts( array(	
	    	'category'	=>	''
		), $atts ) );
		
		ob_start();
		//do action to load home content by category
		do_action( 'wps_deals_home_content_shortcode', $category );
		$content .= ob_get_clean();
		
		return $content;
	}
	
	/**
	 * Adding Hooks
	 *
	 * Adding proper hoocks for the shortcodes.
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		//add shortcode to show list of deals on the page
		add_shortcode( 'wps_deals', array( $this, 'wps_deals_all' ) );
		
		//add shortcode for showing shopping cart details
		add_shortcode( 'wps_deals_checkout', array($this, 'wps_deals_checkout'));
		
		//add shortcode for order complete
		add_shortcode( 'wps_deals_order_complete', array($this, 'wps_deals_order_complete'));
		
		//add shortcode for order cancelled
		add_shortcode( 'wps_deals_order_cancel', array($this, 'wps_deals_order_cancelled'));
		
		//add shortcode for order details
		add_shortcode( 'wps_deals_orders', array($this, 'wps_deals_orders'));
		
		//add shortcode to show list of deals on the page/post by category
		add_shortcode( 'wps_deals_by_category', array( $this, 'wps_deals_by_category'));
	}
}