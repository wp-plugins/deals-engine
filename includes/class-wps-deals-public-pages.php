<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Public Pages Class
 *
 * Handles all the different features and functions
 * for the front end pages.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
class Wps_Deals_Public_Pages	{
	
	public $model,$scripts,$render,$cart,$currency,$price,$message;
	
	public function __construct() {
		
		global $wps_deals_model,$wps_deals_scripts,$wps_deals_render,
				$wps_deals_cart,$wps_deals_currency,$wps_deals_price,
				$wps_deals_message;
		
		$this->model 	= $wps_deals_model;
		$this->scripts	= $wps_deals_scripts;
		$this->render	= $wps_deals_render;
		$this->cart		= $wps_deals_cart;
		$this->currency	= $wps_deals_currency;
		$this->price	= $wps_deals_price;
		$this->message	= $wps_deals_message;
		
	}
	
	/**
	 * AJAX Call for Add to Cart
	 * 
	 * Handles to add deal into Shopping Cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	public function wps_deals_add_to_cart_product() {

		//get options values from settings page
		global $wps_deals_options;
		
		$dealid = $_POST['dealid'];
		
		$quntity = '1';
		$resultdata = array();
		
		if(get_post_type($dealid) != WPS_DEALS_POST_TYPE) { //check post type is deal type
			return;
		}
		
		//get the current product is in cart or not
		$incart = $this->cart->item_in_cart($dealid);
			
			$cartdata = array(	
									'dealid'	=>	$dealid,
									'quantity'	=>	$quntity
							 );
							
			$result = $this->cart->add($cartdata);
			
		//product added
		if($result == true) {
			$resultdata['success'] = '1';
			$resultdata['redirectstat'] = '0';
			$resultdata['widgetcontent'] = $this->render->wps_deals_cart_widget_content();
			if(!empty($wps_deals_options['redirect_to_checkout'])) {
				$resultdata['redirectstat'] = '1';
				$resultdata['redirect'] = get_permalink($wps_deals_options['payment_checkout_page']);
			}
		} else {
			$resultdata['error'] = __('Error in add to cart in product','wpsdeals'); 
		}
		
		echo json_encode($resultdata);
		exit;
	}
	
	/**
	 * AJAX Call for Update Product to Cart 
	 * 
	 * Handles to updating product to cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_update_to_cart_product(){
		
		$quntity	= trim( $_POST['qtystr'],',' );
		$resultdata	= array();
		//if(isset($quntity) && !empty($quntity)) {
		
		$qtyarr		= array_map('intval', explode( ',', $quntity ) );
		$args		= array( 'quantity'	=> $qtyarr );
		
		$result		= $this->cart->update($args);
		
		$cartdata	= $this->cart->getproduct();
		
		//do action for change cart via ajax
		do_action( 'wps_deals_cart_ajax' );
		
		if(empty($cartdata)) { //check cart data is empty or not
			$resultdata['empty'] = '1';
			$this->cart->cartempty();
		} else {
			$cart = $this->cart->get();
			$resultdata['message'] = '<span>' . __( 'Cart Updated Successfully.', 'wpsdeals' ) . '</span>';
			$resultdata['success'] = '1';
			$carttotal = $this->currency->wps_deals_formatted_value($cart['total']);
			$resultdata['total'] = apply_filters( 'wps_deals_checkout_total_html', $carttotal, $cart );
		}
		
		ob_start();
		//do action for refreshing div via ajax
		do_action( 'wps_deals_checkout_header_content_ajax' );
		$resultdata['detail'] = ob_get_clean();//;
		
		//} else {
			//$resultdata['message'] = __('Error while updated cart','wpsdeals');
		//}
		echo json_encode( $resultdata );
		exit;
		
	}
	
	/**
	 * AJAX Call for Remove Product from Cart
	 * 
	 * Handles to removing product from cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_remove_to_cart_product() {
		
		$dealid = $_POST['dealid'];
		$resultdata = array();
		if(isset($dealid) && !empty($dealid)) {
			
			//remove item from cart
			$result = $this->cart->remove($dealid);
			
			//do action for change cart via ajax
			do_action( 'wps_deals_cart_ajax' );
		   
			$resultdata['message'] = '<span> ' . __( 'Item removed from cart successfully.', 'wpsdeals' ) . '</span>';
			
			//get cart details
			ob_start();
			//do action for refreshing div via ajax
			do_action( 'wps_deals_checkout_header_content_ajax' );
			$resultdata['detail'] = ob_get_clean();
			
			$resultdata['success'] = '1';
			
			$cart = $this->cart->get();
			$resultdata['total'] = $this->currency->wps_deals_formatted_value($cart['total']);
			
			$cartdata = $this->cart->getproduct();
			if(empty($cartdata)) {
				$resultdata['empty'] = '1';
			}
			
		} else {
			$resultdata['message'] = '<span>' . __( 'Error while removing item from cart.', 'wpsdeals' ) . '</span>';
		}
		echo json_encode($resultdata);
		exit();
	}
	/**
	 * AJAX Call to Empty Cart
	 * 
	 * Handles to remove all product from cart
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_empty_cart_product() {
		
		//do cart empty
		$result = $this->cart->cartempty();
		ob_start();
		//do action for refreshing div via ajax
		do_action( 'wps_deals_checkout_header_content_ajax' );
		echo ob_get_clean();
		exit;
	}
	/**
	 * AJAX call when user will checkout with login data
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_checkout_user_login() {
		
		global $wps_deals_options;
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$creds = array();
		$creds['user_login'] = $username;
		$creds['user_password'] = $password;
		$creds['remember'] = false;
		
		if(!empty($creds['user_login']) && !empty($creds['user_password'])) { //check user login and user password is not empty
			
			$user = wp_signon( $creds, false );
			
			$result = array();
			
			if ( is_wp_error($user) ) {
			   
				$invalid_username = isset($user->errors['invalid_username']) ? $user->errors['invalid_username'] : '';
				$invalid_password = isset($user->errors['incorrect_password']) ? $user->errors['incorrect_password'] : '';
				
				if(!empty($invalid_username)) { //check user login is valid or not
					$result['error'] = __( '<span><strong>ERROR</strong>: Invalid username.</span>', 'wpsdeals' );
				}
				if(empty($result['error']) && !empty($invalid_password)) { //check user password is valid or not
					$result['error'] = __( '<span><strong>ERROR</strong>: The password you entered for the username <strong>'.$creds['user_login'].'</strong> is incorrect.</span>', 'wpsdeals' );
				} 
				
			} else {
				
				//action will call on user register on checkout page
				do_action( 'wps_deals_checkout_user_login', $user );
				
				//user logged in successfully
				$result['success'] = '1'; 
			}
		}
		
		echo json_encode($result);
		exit;
	}
	
	/**
	 * AJAX Call for User Registration
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_checkout_user_registration() {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
		//$retypepassword = $_POST['retypepass'];
		$email = $_POST['useremail'];
		
		$errorstr = '';
		$result = array();
		
		if( username_exists( $username ) ) {
			
			$errorstr .= __('<span><strong>ERROR</strong>: This username is already registered. Please choose another one.</span>','wpsdeals');
			
			if( empty($email) ) { 
				$errorstr .= __('<span><strong>ERROR</strong>: Please type your e-mail address.</span>','wpsdeals');
			}
			
		} elseif (email_exists( $email )) {
			
			$errorstr .= __('<span><strong>ERROR</strong>: This email is already registered, please choose another one.</span>','wpsdeals');
			
		} else {
		
			$user_id = wp_create_user( $username, $password, $email );	
			
			if(!empty($user_id)) {
				
				update_user_meta($user_id,'first_name',$firstname);
				update_user_meta($user_id,'last_name',$lastname);
				
				//make user to logged in
				wp_set_auth_cookie( $user_id, false); 
				
				//action will call on user register on checkout page
				do_action( 'wps_deals_checkout_user_register', $user_id );
				
				$result['success'] = '1';
					
			} else {
				$errorstr .= __('<span><strong>ERROR</strong>: User Registration Failed.','wpsdeals');
			}
		}
		
		if(!empty($errorstr)) {
			$result['error'] = $errorstr;
		} 
		echo json_encode($result);
		exit;
	}
	/**
	 * AJAX call 
	 * 
	 * Handles to show details of with ajax
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_orders() {

		if ( is_user_logged_in() ) {
			ob_start();
			//wps_deals_get_template_part( 'ordered', 'deals' );
			//do action to load ordered deals html via ajax
			do_action( 'wps_deals_orders_content' );
			echo ob_get_clean();
			exit;
		} else {
			return __('You have not ordered any deals yet.','wpsdeals');
		}
	}
	/**
	 * AJAX Call
	 * 
	 * Handles to ajax call to store social count to the database
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 * 
	 */
	public function wps_deals_update_social_count() {
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		if(isset($_POST['postid']) && !empty($_POST['postid'])) { //check post id is not empty or not
			
			$type = $_POST['type'];
			$postid = $_POST['postid'];
			
			if($type == 'fb') { //if facebook 
				
				$fbcount = get_post_meta( $postid, $prefix.'social_fb_count', true );
				$fbcount = !empty($fbcount) ? $fbcount : '0';
				$fbcount += 1;
				update_post_meta( $postid, $prefix.'social_fb_count', $fbcount );
				
			} elseif ($type == 'tw') {
				
				$twcount = get_post_meta( $postid, $prefix.'social_tw_count', true );
				$twcount = !empty($twcount) ? $twcount : '0';
				$twcount += 1;
				update_post_meta( $postid, $prefix.'social_tw_count', $twcount );
				
			} elseif ($type == 'gp') { //google plus button
				
				$gpcount = get_post_meta( $postid, $prefix.'social_gp_count', true );
				$gpcount = !empty($gpcount) ? $gpcount : '0';
				$gpcount += 1;
				update_post_meta( $postid, $prefix.'social_gp_count', $gpcount );
				
			} elseif ($type == 'fan') { //fan page like button
				
				$fanpagecount = get_post_meta( $postid, $prefix.'social_fan_page_count', true );
				$fanpagecount = !empty($fanpagecount) ? $fanpagecount : '0';
				$fanpagecount += 1;
				update_post_meta( $postid, $prefix.'social_fan_page_count', $fanpagecount );
				
			}
			
			//do action to do update social media data
			do_action('wps_deals_update_social_data',$postid,$type);
			echo '1';
		}
		exit;
		
	}
	
	/**
	 * Load Page Template
	 * 
	 * Handles to load page template for deals pages
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 * 
	 */
	public function wps_deals_load_template( $template ) {
		
		global $wps_deals_options;
		
		$find = array( 'deals-engine.php' );
		$file = '';
		
		if ( is_single() && get_post_type() == WPS_DEALS_POST_TYPE ) {

			$file 	= 'deals-single.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;

		} elseif ( is_post_type_archive( WPS_DEALS_POST_TYPE ) || is_tax( WPS_DEALS_POST_TAXONOMY ) ) {
			
			$file 	= 'deals-archive.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;
			
		}
		
		if ( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = wps_deals_get_templates_dir() . $file;
		}
		
		return $template;
	}
	/**
	 * Redirect Template
	 * 
	 * Handles to redirects before content is output - hooked into template_redirect so is_page works.
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0 
 	 */
	public function wps_deals_template_redirect() {
		
		global $wps_deals_options;
		
		// My account page redirects ( logged out )
		if ( !is_user_logged_in() && 
			( is_page( wps_deals_get_page_id( 'change_password' ) ) || is_page( wps_deals_get_page_id( 'edit_adderess' ) ) 
				|| is_page( wps_deals_get_page_id( 'ordered_page' ) ) ) ) {
			
			//redirect to my account page
			wps_deals_send_on_my_account_page();
			
		}
		
		// Logout 
		elseif ( is_page( wps_deals_get_page_id( 'logout' ) ) ) {
			
			wp_redirect( str_replace( '&amp;', '&', wp_logout_url( get_permalink( $wps_deals_options['my_account_page'] ) ) ) );
			exit;
		}
		// Force SSL
		//check unforce SSL is set & not empty then redirect to http URL to https URL
		elseif ( isset( $wps_deals_options['force_ssl_checkout'] ) && !empty( $wps_deals_options['force_ssl_checkout'] ) && ! is_ssl() ) {
	
			//check the current page is checkout page or my account page or child page of my account page
			if ( wps_deals_is_checkout() || wps_deals_is_account() || apply_filters( 'wps_deals_force_ssl_checkout', false ) ) {
				//check if there is http exist in request uri
				if ( strpos( $_SERVER['REQUEST_URI'], 'http' ) === 0 ) {
					wp_safe_redirect( preg_replace( '|^http://|', 'https://', $_SERVER['REQUEST_URI'] ) );
					exit;
				} else {
					//check there is https exist in request uri
					wp_safe_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
					exit;
				} //end else
				
			} //end if to check is checkout page or is account page
			
		} //end if to check force ssl checkout is checked & is it not SSL
		
		//Unforce SSL
		//check unforce SSL is set & not empty then redirect to https url to http url
		elseif ( isset( $wps_deals_options['force_ssl_checkout'] ) && !empty( $wps_deals_options['force_ssl_checkout'] )
				&& isset( $wps_deals_options['unforce_ssl_checkout'] ) && !empty( $wps_deals_options['unforce_ssl_checkout'] ) 
				&& is_ssl() && $_SERVER['REQUEST_URI'] && !wps_deals_is_checkout() 
				&& !is_page( wps_deals_get_page_id( 'payment_thankyou_page' ) )
				&& !wps_deals_is_account() && apply_filters( 'wps_deals_unforce_ssl_checkout', true ) ) {	
					
			if ( strpos( $_SERVER['REQUEST_URI'], 'http' ) === 0 ) {
				wp_safe_redirect( preg_replace( '|^https://|', 'http://', $_SERVER['REQUEST_URI'] ) );
				exit;
			} else {
				wp_safe_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
				exit;
			}
		} //end if to check force ssl checkout is checked & is it not SSL
	}
	
	/**
	 * Call to return state list from Country Code
	 * 
	 * Handles to return state list from country code
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0 
	 **/
	public function wps_deals_state_list_from_country() {
		
		$country = isset( $_POST['country'] ) && !empty( $_POST['country'] ) ? $_POST['country'] : '';
		
		$stateid 	= isset( $_POST['stateid'] ) ? $_POST['stateid'] : '';
		//$stateclass = isset( $_POST['stateclass'] ) ? $_POST['stateclass'] : '';
		$statename	= isset( $_POST['statename'] ) ? $_POST['statename'] : '';
		//$stateplaceholder	= isset( $_POST['stateplaceholder'] ) ? $_POST['stateplaceholder'] : '';
		
		//get states from country
		$states = wps_deals_get_states_from_country( $country );
		
		//check states not empty
		if( !empty( $states ) &&  is_array( $states ) ) {
			
			$statefield = '<select name="'.$statename.'" id="'.$stateid.'" class="deals-cart-select wps-deals-required billing-country wps-deals-state-combo">';
			$statefield .= '<option value="">'.__( 'Select State / County&hellip;', 'wpsdeals' ).'</option>';
			foreach ( $states as $statekey => $state ) {
				$statefield .= '<option value="'.$statekey.'">'.$state.'</option>';
			}
			
			$statefield .= '</select>';
		} else {
			
			$statefield = '<input type="text" name="'.$statename.'" id="'.$stateid.'" value="" class="wps-deals-cart-text wps-deals-required wps-deals-state-combo" placeholder="'.__( 'State / County', 'wpsdeals' ).'"/>';
			
		}
		
		echo $statefield;
		exit;
	}
	
	/**
	 * Manage Billing Address
	 *
	 * Handles to manage billing address from
	 * my account > edit address page
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_manage_billing_address() {
		
		global $wps_deals_options, $current_user;
		
		$prefix = WPS_DEALS_META_PREFIX;
	
		if( isset( $_POST['wps_deals_save_billing_address'] ) && !empty( $_POST['wps_deals_save_billing_address'] )
			&& isset( $_POST['wps_deals_billing_details'] ) && !empty( $_POST['wps_deals_billing_details'] ) ) {
			
			//valid billing details
			$userbilling	= wps_deals_valid_billing_data();
			
			if( $userbilling ) {
				
				//save billing to user meta
				update_user_meta( $current_user->ID, $prefix.'billing_details', $_POST['wps_deals_billing_details'] );
				
				$successmsg = __( '<span>Address changed successfully.</span>', 'wpsdeals' );
				$this->message->add_session( 'my_account_msg', $successmsg, 'success' );
				
				//redirect to my account page
				wps_deals_send_on_my_account_page();
				
			} else {
				
				//redirect to edit address page
				wps_deals_send_on_edit_adderess_page( array( 'wps_deals_address' => 'billing' ) );
				
			}
		}
	}
	
	/**
	 * Change Password
	 *
	 * Handles to change password from
	 * my account > change password page
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_change_password() {
		
		global $wpdb, $wps_deals_options, $current_user;
		
		$prefix = WPS_DEALS_META_PREFIX;
	
		//Check change password button is click or not
		if( isset( $_POST['wps_deals_change_password'] ) && !empty( $_POST['wps_deals_change_password'] ) ) {
			
			$error = false;
			$new_password = $re_enter_password = '';
			
			if( isset( $_POST['wps_deals_reset_key'] ) && !empty( $_POST['wps_deals_reset_key'] )
				&& isset( $_POST['wps_deals_reset_login'] ) && !empty( $_POST['wps_deals_reset_login'] ) ) {
				
				$key 	= $_POST['wps_deals_reset_key'];
				$login 	= $_POST['wps_deals_reset_login'];
				
				$user = $wpdb->get_row( "SELECT * FROM $wpdb->users WHERE user_activation_key = '{$key}' AND user_login = '{$login}'" );
		
				if ( empty( $user ) ) {
					
					$this->message->add( 'changepassword', __( '<span><strong>ERROR : </strong>Invalid key.', 'wpsdeals' ), 'multierror' );
					$error = true;
					
				} else {
					
					$user_id = $user->ID;
				}
					
			} else {
				$user_id = $current_user->ID;
			}
			
			
			if( isset( $_POST['wps_deals_new_password'] ) && !empty( $_POST['wps_deals_new_password'] ) ) {
				$new_password = $_POST['wps_deals_new_password'];
			} else {
				$this->message->add( 'changepassword', __( '<span><strong>ERROR : </strong>Please enter new password.</span>','wpsdeals' ),'multierror');
				$error = true;
			}
			
			if( isset( $_POST['wps_deals_re_enter_password'] ) && !empty( $_POST['wps_deals_re_enter_password'] ) ) {
				$re_enter_password = $_POST['wps_deals_re_enter_password'];
			} else {
				$this->message->add( 'changepassword', __( '<span><strong>ERROR : </strong>Please enter re-enter new password.</span>','wpsdeals' ),'multierror');
				$error = true;
			}
			
			if( !empty( $new_password ) && !empty( $re_enter_password ) && $new_password != $re_enter_password ) {
				$this->message->add( 'changepassword', __( '<span><strong>ERROR : </strong>Passwords do not match, please enter your password.</span>','wpsdeals' ),'multierror');
				$error = true;
			}
			
			if( !$error ) {
				
				wp_update_user( array ( 'ID' => $user_id, 'user_pass' => $new_password ) ) ;
				
				$successmsg = __( '<span>Password changed successfully.</span>', 'wpsdeals' );
				$this->message->add_session( 'my_account_msg', $successmsg, 'success' );
				
				//redirect to my account page
				wps_deals_send_on_my_account_page();
				
			}
		}
	}
	
	/**
	 * Lost Password
	 *
	 * Handles to lost password from
	 * my account > lost password page
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_lost_password() {
		
		global $wps_deals_options, $wpdb;
		
		$prefix = WPS_DEALS_META_PREFIX;
	
		//Check lost password button is click or not
		if( isset( $_POST['wps_deals_reset_password'] ) && !empty( $_POST['wps_deals_reset_password'] ) ) {
			
			$error = false;
			
			//check username or email is empty
			if( !isset( $_POST['wps_deals_user_email'] ) || empty( $_POST['wps_deals_user_email'] ) ) {
	
				$this->message->add_session( 'lostpassword', __( '<span><strong>ERROR : </strong>Please enter username or e-mail address.</span>','wpsdeals' ), 'error' );
				$error = true;
	
			} else if ( isset( $_POST['wps_deals_user_email'] ) && strpos( $_POST['wps_deals_user_email'], '@' ) ) { // check email-id
	
				if( is_email( $_POST['wps_deals_user_email'] ) ) { // check email validation
					
					$user_data = get_user_by( 'email', trim( $_POST['wps_deals_user_email'] ) );
					if ( empty( $user_data ) ) { // check user exist

						$this->message->add_session( 'lostpassword', __( '<span><strong>ERROR : </strong>There is no user registered with that email address.', 'wpsdeals' ), 'error' );
						$error = true;
					}
				} else {
					
					$this->message->add_session( 'lostpassword', __( '<span><strong>ERROR : </strong>Please enter valid e-mail address.</span>','wpsdeals' ), 'error' );
					$error = true;
		
				}
	
			} else {
	
				$login = trim( $_POST['wps_deals_user_email'] );
	
				$user_data = get_user_by( 'login', $login );
				
				if ( empty( $user_data ) ) { // check user exist

					$this->message->add_session( 'lostpassword', __( '<span><strong>ERROR : </strong>Invalid username or e-mail.', 'wpsdeals' ), 'error' );
					$error = true;
				}
				
			}

			// add do action for validate post field
			do_action( 'wps_deals_lost_password_post' );

			if ( !empty( $user_data ) ) { // Check user is exist
				
				$allow = apply_filters('wps_deals_allow_password_reset', true, $user_data->ID);
	
				if ( ! $allow ) { // Check permission not allow for reset password
		
					$this->message->add_session( 'lostpassword', __( '<span><strong>ERROR : </strong>Password reset is not allowed for this user.', 'wpsdeals' ), 'error' );
					$error = true;
				}
			}
			
			if( !$error ) {
				
				// defining user_login ensures we return the right case in the email
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;

				$key = $wpdb->get_var( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = '{$user_login}'" );
		
				if ( empty( $key ) ) {
		
					// Generate something random for a key...
					$key = wp_generate_password( 20, false );
		
					do_action('wps_deals_retrieve_password_key', $user_login, $key);
		
					// Now insert the new md5 key into the db
					$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );
					
				}
		
				//Send email for reset password
				$args = array(
									'user_key' 		=> $key,
									'user_name' 	=> $user_login,
									'user_email' 	=> $user_email,
								);
								
				$this->model->wps_deals_send_reset_password_email( $args );
				
				// Send email notification
				do_action( 'wps_deals_reset_password_notification', $user_login, $key );

				$successmsg = __( '<span>Check your e-mail for the confirmation link.</span>', 'wpsdeals' );
				$this->message->add_session( 'lostpasswordsuccess', $successmsg, 'success' );
				
			}
			
			//redirect to lost password page
			wps_deals_send_on_lost_password_page();
			
		}
	}
	
	/**
	 * Register
	 *
	 * Handles to register from
	 * create an account page
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_register() {
		
		// Check register button is click
		if( isset( $_POST['wps_deals_register_submit'] ) && !empty( $_POST['wps_deals_register_submit'] ) ) {
			
			$username = $password = $email = '';
	 		$error = false;
	 		
	 		if( isset( $_POST['wps_deals_reg_user_name'] ) && !empty( $_POST['wps_deals_reg_user_name'] ) ) { //check user name
				$username = $_POST['wps_deals_reg_user_name'];
	 		} else {
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter username.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( isset( $_POST['wps_deals_reg_user_firstname'] ) && !empty( $_POST['wps_deals_reg_user_firstname'] ) ) { //check user first anme
				$firstname = $_POST['wps_deals_reg_user_firstname'];
	 		} else {
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter first name.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( isset( $_POST['wps_deals_reg_user_lastname'] ) && !empty( $_POST['wps_deals_reg_user_lastname'] ) ) { //check user last name
				$lastname = $_POST['wps_deals_reg_user_lastname'];
	 		} else {
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter last name.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( isset( $_POST['wps_deals_reg_user_email'] ) && !empty( $_POST['wps_deals_reg_user_email'] ) ) { //check user email
	 			if( is_email( $_POST['wps_deals_reg_user_email'] ) ) { //check user email is valid
		 			$email = $_POST['wps_deals_reg_user_email'];
	 			} else {
	 				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter your valid e-mail address.', 'wpsdeals' ), 'multierror' );
					$error = true;
	 			}
	 		} else {
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter your e-mail address.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( !( isset( $_POST['wps_deals_reg_user_pass'] ) && !empty( $_POST['wps_deals_reg_user_pass'] ) ) ) { //check user password is empty
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter password.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( !( isset( $_POST['wps_deals_reg_user_confirm_pass'] ) && !empty( $_POST['wps_deals_reg_user_confirm_pass'] ) ) ) { //check user confirm password is empty
				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Please enter confirm password.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( isset( $_POST['wps_deals_reg_user_pass'] ) && !empty( $_POST['wps_deals_reg_user_pass'] )
	 			&& isset( $_POST['wps_deals_reg_user_confirm_pass'] ) && !empty( $_POST['wps_deals_reg_user_confirm_pass'] ) ) { //check password & confirm password
	 			if( $_POST['wps_deals_reg_user_pass'] == $_POST['wps_deals_reg_user_confirm_pass'] ) { //check both password are metch
					
	 				$password = $_POST['wps_deals_reg_user_pass'];
	 			} else {
	 				$this->message->add( 'register', __( '<span><strong>ERROR : </strong>Password and confirm password must be same.', 'wpsdeals' ), 'multierror' );
					$error = true;
	 			}
	 		} else { 
	 			$error = true;
	 		}
		  
	 		if( !$error ) { // Check username, password, confirm password and email are not empty
	 			
				if( username_exists( $username ) ) {
					
					$this->message->add( 'register', __( '<span><strong>ERROR : </strong>This username is already registered. Please choose another one.</span>','wpsdeals' ), 'multierror' );
					
				} else if( email_exists( $email ) ) {
					
					$this->message->add( 'register', __( '<span><strong>ERROR : </strong>This email is already registered, please choose another one.</span>','wpsdeals' ), 'multierror' );
					
				} else {
				
					$user_id = wp_create_user( $username, $password, $email );	
					
					if(!empty($user_id)) {
						
						update_user_meta($user_id,'first_name',$firstname);
						update_user_meta($user_id,'last_name',$lastname);
						
						//make user to logged in
						wp_set_auth_cookie( $user_id, false); 
						
						//action will call on user register on create an account page
						do_action( 'wps_deals_user_register', $user_id );
						
						//redirect to lost password page
						wps_deals_send_on_create_account_page();
						
					} else {
						
						$this->message->add( 'register', __( '<span><strong>ERROR : </strong>User Registration Failed.','wpsdeals' ), 'multierror' );
					}
				}
				
	 		}
		}
	}
	
	/**
	 * Login
	 *
	 * Handles to login from
	 * my account page
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_login() {
		
		if( isset( $_POST['wps_deals_login_submit'] ) && !empty( $_POST['wps_deals_login_submit'] ) ) {
			
			$creds = array();
	 		$error = false;
	 		
	 		if( isset( $_POST['wps_deals_user_name'] ) && !empty( $_POST['wps_deals_user_name'] ) ) { //check user name
				$creds['user_login'] = $_POST['wps_deals_user_name'];
	 		} else {
				$this->message->add( 'login', __( '<span><strong>ERROR : </strong>Please enter your username.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
	 		if( isset( $_POST['wps_deals_user_pass'] ) && !empty( $_POST['wps_deals_user_pass'] ) ) { //check user password
				$creds['user_password'] = $_POST['wps_deals_user_pass'];
	 		} else {
	 			$this->message->add( 'login', __( '<span><strong>ERROR : </strong>Please enter your password.', 'wpsdeals' ), 'multierror' );
				$error = true;
	 		}
			if( isset($_POST['wps_deals_remember'] ) && !empty( $_POST['wps_deals_remember'] ) ) { //check remember me check box in login form
				$creds['remember'] = true;
			} else {
				$creds['remember'] = false; 
			}
		  
	 		if( !$error ) { // Check username and password are not empty
	 			
	 			$user = wp_signon( $creds, false );
	 			
	 			if ( is_wp_error( $user ) ) { //check error given by wordpress
	 				
	 				if( isset( $user->errors['invalid_username'] ) && !empty( $user->errors['invalid_username'] ) ) { //check user name is invalid
	 					$this->message->add( 'login', __( '<span><strong>ERROR : </strong>Invalid username.', 'wpsdeals' ), 'multierror' );
	 				} 
	 				
	 				if( isset( $user->errors['incorrect_password'] ) && !empty( $user->errors['incorrect_password'] ) ) { //check user password is incorrect
	 					$this->message->add( 'login', __( '<span><strong>ERROR : </strong>The password you entered for username <strong>'.$creds['user_login'].'</strong> is incorrect.', 'wpsdeals' ), 'multierror' );
	 				}
	 			} else {
	 				
					//redirect to my account page
					wps_deals_send_on_my_account_page();
					
	 			}
	 			
	 		}
		}
	}
	
	/**
	 * Cron Job For Price Update
	 * 
	 * Handle to update price of all deals
	 * using cron job
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function wps_deals_scheduled_set_price_meta() {
		
		global $wps_deals_options, $wpdb;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		$deals = $this->model->wps_deals_get_data();
		
		if( !empty($deals) ) {
			
			foreach ( $deals as $deal ) {
				
				// Check deal is not empty
				if( isset($deal['ID']) && !empty($deal['ID']) ) {
					
					$normal_price	= get_post_meta( $deal['ID'], $prefix.'normal_price', true );
					$sale_price		= get_post_meta( $deal['ID'], $prefix.'sale_price', true );
					$price			= get_post_meta( $deal['ID'], $prefix.'price', true );
					
					// check the price meta is set or not
					if( !$price ) {
						
						// If sale price not empty then update price as sale price
						if( !empty( $sale_price ) ) {
							
							update_post_meta( $deal['ID'], $prefix.'price', $sale_price );
							
						} else if( $normal_price ) {
							
							update_post_meta( $deal['ID'], $prefix.'price', $sale_price );
							
						}
					}
				}
			}
		}
	}
	
	/**
	 * Adding Hooks
	 *
	 * Adding proper hoocks for the public pages.
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		//ajax call to click on add to cart button
		add_action( 'wp_ajax_deals_add_to_cart', array($this, 'wps_deals_add_to_cart_product'));
		add_action( 'wp_ajax_nopriv_deals_add_to_cart',array( $this, 'wps_deals_add_to_cart_product'));
		
		//ajax call to click on update cart
		add_action( 'wp_ajax_deals_update_to_cart', array($this, 'wps_deals_update_to_cart_product'));
		add_action( 'wp_ajax_nopriv_deals_update_to_cart',array( $this, 'wps_deals_update_to_cart_product'));
		
		//ajax call to click on update cart
		add_action( 'wp_ajax_deals_remove_to_cart', array($this, 'wps_deals_remove_to_cart_product'));
		add_action( 'wp_ajax_nopriv_deals_remove_to_cart',array( $this, 'wps_deals_remove_to_cart_product'));
		
		//ajax call to click on update cart
		add_action( 'wp_ajax_deals_empty_cart', array($this, 'wps_deals_empty_cart_product'));
		add_action( 'wp_ajax_nopriv_deals_empty_cart',array( $this, 'wps_deals_empty_cart_product'));
		
		//ajax call to click on checkout with user login
		add_action( 'wp_ajax_deals_user_login', array($this, 'wps_deals_checkout_user_login'));
		add_action( 'wp_ajax_nopriv_deals_user_login',array( $this, 'wps_deals_checkout_user_login'));
		
		//ajax call to click on checkout with user registration process
		add_action( 'wp_ajax_deals_user_register', array($this, 'wps_deals_checkout_user_registration'));
		add_action( 'wp_ajax_nopriv_deals_user_register',array( $this, 'wps_deals_checkout_user_registration'));
		
		//ajax pagination
		add_action( 'wp_ajax_wps_deals_next_page', array( $this, 'wps_deals_orders' ) );
		add_action( 'wp_ajax_nopriv_wps_deals_next_page', array( $this, 'wps_deals_orders' ) );
		
		//ajax call to update data to database this action will be using in add on also
		add_action( 'wp_ajax_deals_update_social_media_values', array( $this, 'wps_deals_update_social_count' ) );
		add_action( 'wp_ajax_nopriv_deals_update_social_media_values', array( $this, 'wps_deals_update_social_count' ) );
		
		//ajax call action to return state list from contry code
		add_action( 'wp_ajax_deals_state_from_country', array( $this, 'wps_deals_state_list_from_country' ) );
		add_action( 'wp_ajax_nopriv_deals_state_from_country', array( $this, 'wps_deals_state_list_from_country' ) );
		
		//template loader
		add_filter( 'template_include', array( $this, 'wps_deals_load_template' ) );
		
		//template redirect
		add_action( 'template_redirect', array( $this, 'wps_deals_template_redirect' ) );

		//email actions to fire email to admin & user
		$emailactions = array( 
								'wps_deals_order_status_pending_to_completed', 
								'wps_deals_order_status_pending_to_onhold' 
							);
		
		//add action to call on payment status change
		foreach ( $emailactions as $action ) {
			add_action( $action, 'wps_deals_send_order_notification', 10, 3 );
		}
		
		//add action to manage billing address from my account > edit address page
		add_action( 'init', array( $this, 'wps_deals_manage_billing_address' ) );
		
		//add action to change password from my account > change password page
		add_action( 'init', array( $this, 'wps_deals_change_password' ) );
		
		//add action to lost password from my account > lost password page
		add_action( 'init', array( $this, 'wps_deals_lost_password' ) );
		
		//add action to login from my account page
		add_action( 'init', array( $this, 'wps_deals_login' ) );
		
		//add action to register from create an account page
		add_action( 'init', array( $this, 'wps_deals_register' ) );
		
		// add action to set price depentds on sale_price or normal_price
		add_action( 'wps_deals_scheduled_set_price_meta', array( $this, 'wps_deals_scheduled_set_price_meta' ) );
	}
}
?>