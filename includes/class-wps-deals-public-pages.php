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
	
	var $model,$scripts,$render,$cart,$currency,$price;
	
	public function __construct() {
		
		global $wps_deals_model,$wps_deals_scripts,$wps_deals_render,
				$wps_deals_cart,$wps_deals_currency,$wps_deals_price;
		
		$this->model = $wps_deals_model;
		$this->scripts = $wps_deals_scripts;
		$this->render = $wps_deals_render;
		$this->cart = $wps_deals_cart;
		$this->currency = $wps_deals_currency;
		$this->price = $wps_deals_price;
		
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
		
		$quntity = trim($_POST['qtystr'],',');
		$resultdata = array();
		//if(isset($quntity) && !empty($quntity)) {
			
		$qtyarr = explode(',',$quntity);
		$args = array('quantity'	=>	$qtyarr);
		
		$result = $this->cart->update($args);
		
		
		$cartdata = $this->cart->getproduct();
		
		if(empty($cartdata)) { //check cart data is empty or not
			$resultdata['empty'] = '1';
			$this->cart->cartempty();
		} else {
			$cart = $this->cart->get();
			$resultdata['message'] = __('Cart Updated Successfully.','wpsdeals');
			$resultdata['success'] = '1';
			$resultdata['total'] = $this->currency->wps_deals_formatted_value($cart['total']);
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
			
			$resultdata['message'] = __('Product removed from cart successfully.','wpsdeals');
			
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
			$resultdata['message'] = __('Error while removing product from cart.','wpsdeals');
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
					$result['error'] = __('<span><strong>ERROR</strong>: Invalid username.</span>','wpsdeals');
				}
				if(empty($result['error']) && !empty($invalid_password)) { //check user password is valid or not
					$result['error'] = __('<span><strong>ERROR</strong>: The password you entered for the username <strong>'.$creds['user_login'].'</strong> is incorrect.</span>','wpsdeals');
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
		
		//deals main page
		$dealsshoppage = $wps_deals_options['deals_main_page']; 
		
		//deals ordered page
		$dealorderedpage = $wps_deals_options['ordered_page']; 
		
		$find = array( 'deals-engine.php' );
		$file = '';
		
		if ( is_single() && get_post_type() == WPS_DEALS_POST_TYPE ) {

			$file 	= 'single-deal.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;

		} else if ( is_post_type_archive( WPS_DEALS_POST_TYPE ) || is_page( $dealsshoppage ) ) { //check it is deals shop page

			$file 	= 'home-deals.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;

		} elseif ( is_page( $dealorderedpage ) ) { //check it is ordered deals page
			
			$file 	= 'ordered-deals.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;
			
		} elseif ( is_page( $wps_deals_options['payment_thankyou_page'] ) ) { //order complete page
			
			$file 	= 'order-complete.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;
			
		} elseif ( is_page( $wps_deals_options['payment_cancel_page'] ) ) { //order cancel page
			
			$file 	= 'order-cancel.php';
			$find[] = $file;
			$find[] = 'deals-engine/' . $file;
			
		} elseif ( is_page( $wps_deals_options['payment_checkout_page'] ) ) { //order cancel page
			
			$file 	= 'checkout-deals.php';
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
		
		//template loader
		add_filter( 'template_include', array( $this, 'wps_deals_load_template' ) );
		
	}
	
}
?>