<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Linkedin Class
 *
 * Handles all Linkedin functions 
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
if( !class_exists( 'Wps_Deals_Social_LinkedIn' ) ) {
	
	class Wps_Deals_Social_LinkedIn {
		
		var $linkedinconfig,$linkedin;
		
		public function __construct() {
			
		}
		
		/**
		 * Include LinkedIn Class
		 * 
		 * Handles to load Linkedin class
		 * 
		 * @package Social Deals Engine
	 	 * @since 1.0.0
		 */
		public function wps_deals_social_load_linkedin() {
			
			global $wps_deals_options;
		
			//linkedin declaration
			if( !empty( $wps_deals_options['enable_linkedin'] )
				&& !empty( $wps_deals_options['li_app_id'] ) && !empty( $wps_deals_options['li_app_secret'] ) ) {
	
				if( !class_exists( 'LinkedIn' ) ) { // loads the LinkedIn class
					require_once ( WPS_DEALS_SOCIAL_LIB_DIR . '/linkedin/class-linkedin.php'); 
				}
				
				//linkedin api configuration
				$this->linkedinconfig = array(
												'appKey'       => WPS_DEALS_LI_APP_ID,
												'appSecret'    => WPS_DEALS_LI_APP_SECRET,
												'callbackUrl'  => NULL 
										 	);
				
				$this->linkedin = new LinkedIn( $this->linkedinconfig ); 
				
				return true;
				
			} else {
				
				return false;	
			}
		}
		
		/**
		 * Linkedin Initialize
		 * 
		 * Handles LinkedIn Login Initialize
		 * 
		 * @package Social Deals Engine
		 * @since 1.0.0
		 * 
		 */	
		public function wps_deals_initialize_linkedin() {
		
			global $wps_deals_options;
			
			
			//check enable linkedin & linkedin application id & linkedin application secret are not empty
			if( !empty( $wps_deals_options['enable_linkedin'] ) && !empty( $wps_deals_options['li_app_id'] ) 
				&& !empty( $wps_deals_options['li_app_secret'] ) ) {
			
				//check $_GET['wpsocialdeals'] equals to linkedin
				if( isset( $_GET['wpsocialdeals'] ) && $_GET['wpsocialdeals'] == 'linkedin' ) {
					
					//load linkedin class
					$linkedin = $this->wps_deals_social_load_linkedin();
					
					//check linkedin loaded or not
					if( !$linkedin ) return false;	
					// code will excute when user does connect with linked in
					if( isset( $_REQUEST[LINKEDIN::_GET_TYPE] ) && $_REQUEST[LINKEDIN::_GET_TYPE] == 'initiate' ) { // if user allows access to linkedin and wpsocial is linkedin or not
						
						// check for the correct http protocol (i.e. is this script being served via http or https)
						$protocol = is_ssl() ? 'https' : 'http';
						
						// set the callback url
						$this->linkedinconfig['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ( ( ( $_SERVER['SERVER_PORT'] != LINKEDIN_PORT_HTTP ) && ( $_SERVER['SERVER_PORT'] != LINKEDIN_PORT_HTTP_SSL ) ) ? ':' . $_SERVER['SERVER_PORT'] : '' ) . $_SERVER['PHP_SELF'] . '?wpsocialdeals=linkedin&' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
						$this->linkedin = new LinkedIn( $this->linkedinconfig );
						  
						// check for response from LinkedIn
						$_GET[LINKEDIN::_GET_RESPONSE] = ( isset( $_GET[LINKEDIN::_GET_RESPONSE] ) ) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
					  
						if( !$_GET[LINKEDIN::_GET_RESPONSE] ) { // this code get executed when the user clicks on the button and linkedin does ask for permission 
							
							// LinkedIn hasn't sent us a response, the user is initiating the connection
							// send a request for a LinkedIn access token
							$response = $this->linkedin->retrieveTokenRequest();
							   
							if( $response['success'] === TRUE) {
								// store the request token
								$_SESSION['wps_deals_linkedin_oauth']['linkedin']['request'] = $response['linkedin'];
								 
									// redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
									wp_redirect( LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
									exit;
								} else {
									// bad token request
									echo __('Request token retrieval failed','wpsdeals');
								}		        
						  } else { //this code will execute when the user clicks on the allow access button on linkedin
						  
								// LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
								$response = $this->linkedin->retrieveTokenAccess( $_SESSION['wps_deals_linkedin_oauth']['linkedin']['request']['oauth_token'], $_SESSION['wps_deals_linkedin_oauth']['linkedin']['request']['oauth_token_secret'], $_GET['oauth_verifier'] );
							   
								if( $response['success'] === TRUE ) {
									
									// the request went through without an error, gather user's 'access' tokens
									$_SESSION['wps_deals_linkedin_oauth']['linkedin']['access'] = $response['linkedin'];
								  
									// set the user as authorized for future quick reference
									$_SESSION['wps_deals_linkedin_oauth']['linkedin']['authorized'] = TRUE;
								   
									//get profile data
									$this->linkedin = new LinkedIn( $this->linkedinconfig );
									$this->linkedin->setTokenAccess( $_SESSION['wps_deals_linkedin_oauth']['linkedin']['access'] );
									$this->linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
									
									//add user data to session for further user
									$resultdata = array();
									$response = $this->linkedin->profile( '~:(id,first-name,last-name,picture-url,email-address,date-of-birth,public-profile-url)' );
									//convert xml object to simple array
							        $resultdata = json_decode( json_encode( ( array ) simplexml_load_string( $response['linkedin'] ) ), 1 );
							        
							        //set user data to sesssion for further use
							        $_SESSION['wps_deals_linkedin_user_cache'] = $resultdata;
									
									// redirect the user back to the demo page
									wp_redirect($_SERVER['PHP_SELF']);
									exit;
								} else {
									// bad token access
									echo __( 'Access token retrieval failed', 'wpsdeals' );
								}
						  } //end else
					  
					} //end if $_REQUEST[LINKEDIN::_GET_TYPE] == 'initiate'
					
				} //end if to check $_GET['wpsocialdeals'] equals to linkedin
			}
			
		}
		
		/**
		 * Get LinkedIn Auth URL
		 * 
		 * Handles to return linkedin auth url
		 * 
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_social_linkedin_auth_url() {
			
			//load linkedin class 
			$linkedin = $this->wps_deals_social_load_linkedin();
			
			if( !$linkedin ) return false;
			
			$li_authurl = add_query_arg( array( 'wpsocialdeals' => 'linkedin', LINKEDIN::_GET_TYPE => 'initiate' ), get_permalink() );
			
			return $li_authurl;
		}
		
		/**
		 * Get LinkedIn User Data
		 *
		 * Function to get LinkedIn User Data
		 *
		 * @package Social Deals Engine
		 * @since 1.0.0
		 */
		public function wps_deals_social_get_linkedin_user_data() {
		
			$user_profile_data = '';
			
			if ( isset( $_SESSION['wps_deals_linkedin_user_cache'] ) && !empty( $_SESSION['wps_deals_linkedin_user_cache'] ) ) {
			
				$user_profile_data = $_SESSION['wps_deals_linkedin_user_cache'];
			}
			return $user_profile_data;
		}
	}
}
?>