<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Google Class
 *
 * Handles all google functions 
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
if( !class_exists( 'Wps_Deals_Social_Google' ) ) {
	
	class Wps_Deals_Social_Google {
		
		var $google, $googleplus, $googleoauth2, $_google_user_cache;
		
		public function __construct(){
			
		}
		
		/**
		 * Include google Class
		 * 
		 * Handles to load google class
		 * 
		 * @package Social Deals Engine
	 	 * @since 1.0.0
		 */
		public function wps_deals_social_load_google() {
			
			global $wps_deals_options;
			
			//google class declaration
			if( !empty( $wps_deals_options['enable_gplus'] ) 
				&& !empty( $wps_deals_options['gplus_client_id'] ) && !empty( $wps_deals_options['gplus_client_secret'] ) ) {
			 
				if( !class_exists( 'apiClient' ) ) { // loads the Google class
					require_once ( WPS_DEALS_SOCIAL_LIB_DIR . '/google/src/apiClient.php' ); 
				}
				if( !class_exists( 'apiPlusService' ) ) { // Loads the google plus service class for user data
					require_once ( WPS_DEALS_SOCIAL_LIB_DIR . '/google/src/contrib/apiPlusService.php' ); 
				}
				if( !class_exists( 'apiOauth2Service' ) ) { // loads the google plus service class for user email
					require_once ( WPS_DEALS_SOCIAL_LIB_DIR . '/google/src/contrib/apiOauth2Service.php' ); 
				}
				
				// Google Objects
				$this->google = new apiClient();
				$this->google->setApplicationName( "Google+ PHP Starter Application" );
				$this->google->setClientId( WPS_DEALS_GP_CLIENT_ID );
				$this->google->setClientSecret( WPS_DEALS_GP_CLIENT_SECRET );
				$this->google->setRedirectUri( WPS_DEALS_GP_REDIRECT_URL );
				$this->google->setScopes( array( 'https://www.googleapis.com/auth/plus.me','https://www.googleapis.com/auth/userinfo.email' ) );
				
				$this->googleplus = new apiPlusService( $this->google ); 
				$this->googleoauth2 = new apiOauth2Service( $this->google );
				
				return true;
									  
			} else {
		
				return false;
			}	
		}
		
		/**
		 * Initializes Google Plus API
		 * 
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_initialize_google() {
		
			//Google integration begins here 		
			// not isset state condition required, else google code executed when facebook called 
			//and check wpsocialdeals is equal to google
			if( isset( $_GET['code'] ) && !isset( $_GET['state'] ) 
				&& isset( $_GET['wpsocialdeals'] ) && $_GET['wpsocialdeals'] == 'google' ) {
			
				//load google class	
				$google = $this->wps_deals_social_load_google();
			
				//check google class is loaded or not
				if( !$google ) return false;		
				
				//generate new access token
				$this->google->authenticate();
				$gplus_access_token = $this->google->getAccessToken();
				
				//check access token is set or not
				if ( !empty( $gplus_access_token ) ) {
				
					$userdata = $this->googleplus->people->get('me');
					$useremail = $this->googleoauth2->userinfo->get(); // to get email
					
					$_SESSION['wps_deals_google_user_cache'] = $userdata;
					$_SESSION['wps_deals_google_user_cache']['email'] = $useremail['email'];
				}
			
			}
			
		}
		
		/**
		 * Get Google User Data
		 * 
		 * @param Social Deals Engine
		 * @since 1.0.0
		 */	
		public function wps_deals_social_get_google_user_data() {
			
			$user_profile_data = '';
			
			if ( isset($_SESSION['wps_deals_google_user_cache'] ) && !empty( $_SESSION['wps_deals_google_user_cache'] ) ) {
			
				$user_profile_data = $_SESSION['wps_deals_google_user_cache'];
			}
			
			return $user_profile_data;
		}
		
		/**
		 * Get Google Authorize URL 
		 *  
		 * @param Social Deals Engine
		 * @since 1.0.0
		 */		
		public function wps_deals_social_get_google_auth_url() {
			
			//load google class
			$google = $this->wps_deals_social_load_google();
			
			//check google class is loaded
			if( !$google ) return false;
			
				$url = $this->google->createAuthUrl();
				$authurl = isset( $url ) ? $url : '';
				
			return $authurl;
		}
	}
}
?>