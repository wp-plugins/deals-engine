<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Contains the query functions for Deals Engine which alter the front-end post queries and loops.
 * 
 * @package Social Deals Engine
 * @since 2.0.7
 */

if ( ! class_exists( 'Wps_Deals_Query' ) ) {
	
	/**
	 * Wps_Deals_Query Class
	 * 
	 * @package Social Deals Engine
	 * @since 2.0.7
	 */
	class Wps_Deals_Query {
	
		/** @public array Query vars to add to wp */
		public $query_vars = array();	
	
		/**
		 * Constructor for the query class.
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function __construct() {
			
			//initialize query variable
			$this->init_query_vars();				
		}
	
		/**
		 * Init query vars by loading options.
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function init_query_vars() {
			
			// Query vars to add to WP
			$this->query_vars = apply_filters( 'wps_deals_query_args', array(
															// Checkout actions
															'social-deals-thank-you-page' 	=> 'social-deals-thank-you-page',
															'social-deals-cancel-page'		=> 'social-deals-cancel-page',	
															
															// My account actions	
															'change-password'    => 'change-password',			
															'edit-address'       => 'edit-address',
															'lost-password'      => 'lost-password',
															'view-orders'    	 => 'view-orders',
															'create-an-account'  => 'create-an-account'
														)
											);
		}
		
		/**
		 * Add endpoints for query vars
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function add_endpoints() {
			foreach ( $this->query_vars as $key => $var )
				add_rewrite_endpoint( $var, EP_ROOT | EP_PAGES );			
		}
	
		/**
		 * add_query_vars function.
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function add_query_vars( $vars ) {
			
			foreach ( $this->query_vars as $key => $var ) {
				$vars[] = $key;
			}
			
			return $vars;
		}
	
		/**
		 * Get query vars
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function get_query_vars() {
			
			return $this->query_vars;
		}
	
		/**
		 * Parse the request and look for query vars - endpoints may not be supported
		 * 
		 * @package Social Deals Engine
		 * @since 2.0.7	
		 */
		public function parse_request() {
			
			global $wp;
	
			// Map query vars to their keys, or get them if endpoints are not supported
			foreach ( $this->query_vars as $key => $var ) {
				
				if ( isset( $_GET[ $var ] ) ) {
					$wp->query_vars[ $key ] = $_GET[ $var ];
				} elseif ( isset( $wp->query_vars[ $var ] ) ) {
					$wp->query_vars[ $key ] = $wp->query_vars[ $var ];
				}
			}
		}
		
		/**
		 * Adding Hooks		
		 *
		 * @package Social Deals Engine
		 * @since 2.0.7
		 */
		public function add_hooks() {
			
			//call to add_endpoints for rewriting query vars end points
			add_action( 'init', array( $this, 'add_endpoints' ) );	
	
			if ( ! is_admin() ) {
				
				//call to add_query_vars for adding quert vars
				add_filter( 'query_vars', array( $this, 'add_query_vars'), 0 );
				
				// call to parse_request for mapping query var to their keys
				add_action( 'parse_request', array( $this, 'parse_request'), 0 );			
			}				
		}
	}
}