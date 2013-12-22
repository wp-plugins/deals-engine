<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Facebook Class
 *
 * Handles all facebook functions
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
if( !class_exists( 'Wps_Deals_Social_Facebook' ) ) {
	
	class Wps_Deals_Social_Facebook {
		
		var $facebook;
		
		public function __construct() {
			
		}
		
		/**
		 * Include Facebook Class
		 * 
		 * Handles to load facebook class
		 * 
		 * @package Social Deals Engine
	 	 * @since 1.0.0
		 */
		public function wps_deals_social_load_facebook() {
			
			global $wps_deals_options;
			
			//check facebook is enable and facebook application id & secrets are not empty
			if( !empty( $wps_deals_options['enable_facebook'] ) 
				&& !empty( $wps_deals_options['fb_app_id'] ) && !empty($wps_deals_options['fb_app_secret']) ) {
				
				if( !class_exists( 'Facebook' ) ) { // loads the facebook class
					require_once ( WPS_DEALS_SOCIAL_LIB_DIR . '/facebook/facebook.php' );
				}
	
				$this->facebook = new Facebook( array(
								'appId' => WPS_DEALS_FB_APP_ID,
								'secret' => WPS_DEALS_FB_APP_SECRET,
								'cookie' => true
							));
				return true;
				
			} else {
				
				return false;
			}
			
		}
		/**
		 * Get Facebook User
		 * 
		 * Handles to return facebook user id
		 * 
		 * @package Social Deals Engine
		 * @since 1.0.0
		 * 
		 */
		public function wps_deals_social_get_fb_user() {
			
			//load facebook class
			$facebook = $this->wps_deals_social_load_facebook();
			
			//check facebook class is exis or not
			if( !$facebook ) return false;
				
				$user = $this->facebook->getUser();
				return $user;
			
		}
		
		/**
		 * Facebook User Data
		 *
		 * Getting the all the needed data of the connected Facebook user.
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_social_get_fb_userdata( $user ) {
			
			
			//load facebook class
			$facebook = $this->wps_deals_social_load_facebook();
			
			//check facebook class is exis or not
			if( !$facebook ) return false;
			
				$fb = array();
				$fb = $this->facebook->api( '/'.$user );
				$fb['picture'] = $this->wps_deals_social_fb_get_profile_picture( array( 'type' => 'square' ), $user );
				return  $fb;
		}
		
		/**
		 * User Image
		 *
		 * Getting the the profile image of the connected Facebook user.
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_social_fb_get_profile_picture( $args=array(), $user ) {
			
			if( isset( $args['type'] ) && !empty( $args['type'] ) ) {
				$type = $args['type'];
			} else {
				$type = 'large';
			}
			$url = 'https://graph.facebook.com/' . $user . '/picture?type=' . $type;
			return $url;
		}
		/**
		 * Check Application Permission
		 *
		 * Handles to check facebook application
		 * permission is given by user or not
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_check_fb_app_permission( $perm="" ) {
			
			$data = '1';
			if( !empty( $perm ) ) {
				$userID = $this->wps_deals_social_get_fb_user();
				$accToken = $this->wps_deals_social_fb_getaccesstoken();
				$url = "https://api.facebook.com/method/users.hasAppPermission?ext_perm=$perm&uid=$userID&access_token=$accToken&format=json";
				$data = json_decode( $this->wps_deals_social_get_data_from_url( $url ) );			
			}
			return $data;
		}
		
		/**
		 * Access Token
		 *
		 * Getting the access token from Facebook.
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_social_fb_getaccesstoken() {
			
			//load facebook class
			$facebook = $this->wps_deals_social_load_facebook();
			
			//check facebook class is exis or not
			if( !$facebook ) return false;
			
			return $this->facebook->getAccessToken();
		}
		
		/**
		 * Get Data From URL
		 *
		 * Handles to get data from url
		 * via CURL
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		
		public function wps_deals_social_get_data_from_url( $url ) {
		
			$data = wp_remote_get( $url, array( 'sslverify'   => false ) );
			return $data['body'];
		}
	}
}
?>