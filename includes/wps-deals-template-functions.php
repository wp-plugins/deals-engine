<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Templates Functions
 *
 * Handles to manage templates of plugin
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 *
 */ 


/**
 * Returns the path to the Deals templates directory
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
function wps_deals_get_templates_dir() {
	
	return apply_filters( 'wps_deals_template_dir', WPS_DEALS_DIR . '/includes/templates/' );
	
}
/**
 * Get template part.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */ 
function wps_deals_get_template_part( $slug, $name='' ) {
	
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/deals-engine/slug-name.php
	if ( $name )
		$template = locate_template( array ( $slug.'-'.$name.'.php', wps_deals_get_templates_dir().$slug.'-'.$name.'.php' ) );

	// Get default slug-name.php
	if ( !$template && $name && file_exists( wps_deals_get_templates_dir().$slug.'-'.$name.'.php' ) )
		$template = wps_deals_get_templates_dir().$slug.'-'.$name.'.php';

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/deals-engine/slug.php
	if ( !$template )
		$template = locate_template( array ( $slug.'.php', wps_deals_get_templates_dir().$slug.'.php' ) );

	if ( $template )
		load_template( $template, false );
}


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 * 
 */
function wps_deals_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	
	if ( ! $template_path ) $template_path = WPS_DEALS_BASENAME . '/';//wps_deals_get_templates_dir();
	if ( ! $default_path ) $default_path = wps_deals_get_templates_dir();
	
	// Look within passed path within the theme - this is priority
	
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);
	
	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters('wps_deals_locate_template', $template, $template_name, $template_path);
}

/**
 * Get other templates (e.g. deals attributes) passing attributes and including the file.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 * 
 */

function wps_deals_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	
	if ( $args && is_array($args) )
		extract( $args );

	$located = wps_deals_locate_template( $template_name, $template_path, $default_path );
	
	do_action( 'wps_deals_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wps_deals_after_template_part', $template_name, $template_path, $located, $args );
}

/************************************ Call Different Templates Functions ***************************/

if( !function_exists( 'wps_deals_home_header' ) ) {
	
	/**
	 * Load Home Header Template
	 * 
	 * Handles to load home page header template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_header() {
		
		$today	= wps_deals_current_date();
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		$home_meta_args = array( 
								array ( 	
											'key' => $prefix.'show_on_home',
											'value' => '1',
											'compare' => '=',
											'type' => 'STRING'
										),
								array (
											'key' => $prefix.'start_date',
											'value' => $today,
											'compare' => '<=',
											'type' => 'STRING'
										),
								array (
											'key' => $prefix.'end_date',
											'value' => $today,
											'compare' => '>=',
											'type' => 'STRING'
										)
					 		);
		$home_deal = array( 
								'post_type' 		=> WPS_DEALS_POST_TYPE, 
								'post_status' 		=> 'publish' , 
								'posts_per_page'	=> 1, 
								'meta_query' 		=> $home_meta_args,
								'order'				=> 'DESC',
								'orderby'			=> 'rand'
							);
							
		$loop_home = null;
		$loop_home = new WP_Query();
		$loop_home->query( $home_deal );
		
		//home page header template
		wps_deals_get_template( 'home/home-header.php', array( 'loop' => $loop_home ));
		
	}
	
}

if( !function_exists( 'wps_deals_home_content' ) ) {

	/**
	 * Load Home Content Template
	 * 
	 * Handles to load home page content template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_content( $category = '' ) {
		
		global $wps_deals_options;
		
		//check disable more deals is set or not
		if( empty( $wps_deals_options['disable_more_deals'] ) ) {
		
			//home page content template
			wps_deals_get_template( 'home/home-content.php' , array( 'category' => $category ) );
		
		} 
	}
}

if( !function_exists( 'wps_deals_home_navigations' ) ) {
	/**
	 * Load Home Page More Deals Navigation Template
	 * 
	 * Handles to load home page more deals
	 * navigation bar
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_navigations() {
		//home page navigation template
		wps_deals_get_template( 'home/home-content/home-navigation.php' );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_active' ) ) {
	/**
	 * Load Home Content Active Deals Template
	 * 
	 * Handles to home page active 
	 * deals template 
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_more_deal_active( $category ) {
		
		global $wps_deals_options;
		
		$today	= wps_deals_current_date();
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get page limit from plugin settings page
		$pagelimit = isset($wps_deals_options['deals_per_page']) ? $wps_deals_options['deals_per_page'] : -1;
		
		$homeargs = array(  
							'post_type' 	=> WPS_DEALS_POST_TYPE, 
							'post_status'	=> 'publish' , 
							'posts_per_page' => $pagelimit 
						);
		
		$activemetaquery = array( 
										array (
													'key' 		=> $prefix.'start_date',
													'value' 	=> $today,
													'compare' 	=> '<=',
													'type' 		=> 'STRING'
												),
										array (
													'key'		=> $prefix.'end_date',
													'value' 	=> $today,
													'compare'	=> '>=',
													'type'		=> 'STRING'
												)
									);
									
		$activeargs = array_merge( $homeargs, array( 'meta_query' => $activemetaquery ) );
	
		if( isset( $category ) && !empty( $category ) ) { //check category id is set or not
			$activeargs[WPS_DEALS_POST_TAXONOMY] = $category;
		}
		
		//counter timer script
		wp_enqueue_script( 'wps-deals-countdown-timer-scripts' );
		
		//active deals template
		wps_deals_get_template( 'home/home-content/more-deals.php', array( 'args' => $activeargs, 'tab' => 'active' ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_ending' ) ) {

	/**
	 * Load Home Content Ending Deals Template
	 * 
	 * Handles to home page ending 
	 * deals template 
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_more_deal_ending( $category ) {
		
		global $wps_deals_options;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		$today	= wps_deals_current_date();
			
		//get page limit from plugin settings page
		$pagelimit = isset($wps_deals_options['deals_per_page']) ? $wps_deals_options['deals_per_page'] : -1;
		
		$homeargs = array(  
							'post_type' 	=> WPS_DEALS_POST_TYPE, 
							'post_status'	=> 'publish' , 
							'posts_per_page' => $pagelimit 
						);
		
		//get end deals days from settings page
		$ending_days = $wps_deals_options['ending_deals_in'];
		$ending_deals_days = date('Y-m-d H:i:s', strtotime('+'.$ending_days.' days'));
			
		$endmetaquery = array( 
								array ( 	
											'key' => $prefix . 'end_date',
											'value' => $ending_deals_days,
											'compare' => '<=',
											'type' => 'STRING'
										),
								array ( 	
											'key' => $prefix . 'start_date',
											'value' => $today,
											'compare' => '<=',
											'type' => 'STRING'
										),
								array ( 	
											'key' => $prefix . 'end_date',
											'value' => $today,
											'compare' => '>=',
											'type' => 'STRING'
										)
						 );
							 
		$argsend = array_merge( $homeargs, array( 'meta_query'	=> $endmetaquery ) );
						 
		if( isset( $category ) && !empty( $category ) ) { //check category id is set or not
			$args_end[WPS_DEALS_POST_TAXONOMY] = $category;
		}
		//ending deals template
		wps_deals_get_template( 'home/home-content/more-deals.php', array( 'args' => $argsend, 'tab' => 'ending-soon' ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_upcoming' ) ) {
	/**
	 * Load Home Content Upcoming Deals Template
	 * 
	 * Handles to home page upcoming 
	 * deals template 
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_more_deal_upcoming( $category ) {
		
		global $wps_deals_options;
		
		$today	= wps_deals_current_date();
		
		$prefix = WPS_DEALS_META_PREFIX;	
		
		//get page limit from plugin settings page
		$pagelimit = isset($wps_deals_options['deals_per_page']) ? $wps_deals_options['deals_per_page'] : -1;
		
		$homeargs = array(  
							'post_type' 	=> WPS_DEALS_POST_TYPE, 
							'post_status'	=> 'publish' , 
							'posts_per_page' => $pagelimit 
						);
						
						
		//get upcoming deals days from settings page
		$upcoming_days = $wps_deals_options['upcoming_deals_in'];
		$upcoming_deal_days = date('Y-m-d H:i:s', strtotime('+'.$upcoming_days.' days'));
		
		$upcomingmetaquery = array( 
									array ( 	
												'key' 		=> $prefix . 'start_date',
												'value'		=> $upcoming_deal_days,
												'compare'	=> '<=',
												'type' 		=> 'STRING'
											),
									array(		
												'key' 		=> $prefix . 'start_date',
												'value' 	=> $today,
												'compare' 	=> '>',
												'type' 		=> 'STRING'
										)
								 );
		
		$argsupcoming = array_merge( $homeargs, array( 'meta_query' => $upcomingmetaquery ) );
		
		if( isset( $category ) && !empty( $category ) ) { //check category id is set or not
			$argsupcoming[WPS_DEALS_POST_TAXONOMY] = $category;
		}
		
		//upcoming deals template
		wps_deals_get_template( 'home/home-content/more-deals.php', array( 'args' => $argsupcoming, 'tab' => 'upcoming-soon' ) );

	}
}

if( !function_exists( 'wps_deals_home_header_content' ) ) {
	/**
	 * Load Home Page Header Left Content Template
	 * 
	 * Handles to load home page header 
	 * left side content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_header_content() {
		
		global $post,$wps_deals_price;

		$prefix = WPS_DEALS_META_PREFIX;
		
		//product price
		$productprice = $wps_deals_price->wps_deals_get_price($post->ID);
		
		// get the value for the deal main image from the post meta box
		$deal_main_image = get_post_meta( $post->ID, $prefix . 'main_image', true );
		
		//home deal image
		$image_url = isset( $deal_main_image['src'] ) && !empty( $deal_main_image['src'] ) ? $deal_main_image['src'] : WPS_DEALS_URL.'includes/images/deals-no-image-big.jpg';
		
		$args = array( 
						'dealtitle'		=>	get_the_title( $post->ID ),
						'imgurl'		=>	$image_url,
						'price'			=>	$wps_deals_price->get_display_price( $productprice, $post->ID ),
						'dealurl'		=>	get_permalink($post->ID),
						'description'	=>	get_the_excerpt()
					);
		
		//home page header deal left content template
		wps_deals_get_template( 'home/home-header/header-content.php', $args );
	}
}

if( !function_exists( 'wps_deals_home_header_timer' ) ) {
	/**
	 * Load Home Page End Deal Timer Template
	 * 
	 * Handles to load home page end deal timer
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_header_timer() {
		
		global $post,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for the deal end date from the post meta box
		$enddatemeta = get_post_meta($post->ID,$prefix.'end_date',true);
		
		if( !empty( $enddatemeta ) ) { //check deal end date 
			
			$timerargs = array();
			
			$enddate = strtotime( $enddatemeta );
			$timerargs['year']			=	date( 'Y', $enddate );
			$timerargs['month']			=	date( 'm', $enddate );
			$timerargs['day']			=	date( 'd', $enddate );
			$timerargs['hours']			=	date( 'H', $enddate );
			$timerargs['minute']		=	date( 'i', $enddate );
			$timerargs['seconds']		=	date( 's', $enddate );

			//counter timer script
			wp_enqueue_script( 'wps-deals-countdown-timer-scripts' );
			//show home page header timer template
			wps_deals_get_template( 'home/home-header/header-timer.php', $timerargs );
		}
		
		
		
	}
}


if( !function_exists( 'wps_deals_home_header_discount' ) ) {
	/**
	 * Load Home Page Deal Discount Box Template
	 * 
	 * Handles to load home page deal discount box template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_header_discount() {
		
		global $post,$wps_deals_price;
		
		//discount 
		$discount = $wps_deals_price->wps_deals_get_discount( $post->ID );
		
		//show home page header discount templage
		wps_deals_get_template( 'home/home-header/header-discount.php', array( 'discount' => $discount ) );
		
	}
}

if( !function_exists( 'wps_deals_home_header_dealvalue' ) ) {
	
	/**
	 * Load Home Page Deal Value Template
	 * 
	 * Handles to load home page deal value
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_header_dealvalue() {
		
		global $post,$wps_deals_price;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for normal price from the post meta box
		$normalprice = get_post_meta( $post->ID,$prefix.'normal_price',true );
		
		$displaynormalprice = $wps_deals_price->get_display_price( $normalprice, $post->ID );
		
		//show home page header deal value template
		wps_deals_get_template( 'home/home-header/header-value.php', array( 'normalprice' => $displaynormalprice ) );
		
	}
}

if( !function_exists( 'wps_deals_home_header_dealsave' ) ) {
	/**
	 * Load Home Page Deal Saving Price Box Template
	 * 
	 * Handles to load home page deal saving price
	 * box template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_header_dealsave() {
		
		global $post,$wps_deals_price;
	
		//saving price
		$yousave = $wps_deals_price->wps_deals_get_savingprice($post->ID);
		
		//show home page header saving price box template
		wps_deals_get_template( 'home/home-header/header-save.php', array( 'savingprice' => $yousave ) );
		
	}
}

if( !function_exists( 'wps_deals_home_header_ratings' ) ) {
	/**
	 * Load Home Page Ratings Template
	 * 
	 * Handles to load home page ratings 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_header_ratings() {
		
		if( class_exists( 'Wps_Fbre_Model' ) ) { // check if the social review engine plugin is activated
	
			global $wps_fbre_model,$post;
			
			$rating = round( $wps_fbre_model->wps_fbre_post_average_ratings( $args = array( 'post_id' => $post->ID ) ) );
		
			//show home page header ratings template
			wps_deals_get_template( 'home/home-header/ratings.php', array( 'rating' => $rating ) );
		}
	}
}

if( !function_exists( 'wps_deals_social_facebook' ) ) {
	/**
	 * Load Social Facebook Button Template
	 * 
	 * Handles to show facebook button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_facebook() {
		
		global $post,$wps_deals_options;
		
		//check facebook button is enable or not
		if( isset( $wps_deals_options['social_buttons'] ) && in_array('facebook',$wps_deals_options['social_buttons']))  {
			
			//social button facebook template
			wp_enqueue_script( 'facebook' );
			wps_deals_get_template( 'social-buttons/facebook.php', array( 'dealurl' => get_permalink( $post->ID ), 'dealid' => $post->ID ) );
		}
	}
	
}

if( !function_exists( 'wps_deals_social_twitter' ) ) {
	/**
	 * Load Social Twitter Button Template
	 * 
	 * Handles to load twitter button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_twitter() {
		
		global $post,$wps_deals_options;
		
		//check twitter button is enable or not
		if( isset( $wps_deals_options['social_buttons'] ) && in_array('twitter',$wps_deals_options['social_buttons']))  {
			
			$twitteruser = isset($wps_deals_options['tw_user_name']) ? $wps_deals_options['tw_user_name'] : '';
			
			$args = array( 
							'dealurl'	=>	get_permalink( $post->ID ), 
							'dealid'	=>	$post->ID,
							'dealtitle'	=>	get_the_title( $post->ID ),
							'twitteruser' => $twitteruser );
			
			//twitter scripts
			wp_enqueue_script( 'twitter' );
			//social button twitter template
			wps_deals_get_template( 'social-buttons/twitter.php', $args );
		}
	}
	
}


if( !function_exists( 'wps_deals_social_google' ) ) {
	
	/**
	 * Load Social Google+ Button Template
	 * 
	 * Handles to load google+ button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_google() {
		
		global $post,$wps_deals_options;
		
		//check google+ button is enable or not
		if( isset( $wps_deals_options['social_buttons'] ) && in_array('google',$wps_deals_options['social_buttons']))  {
			
			$args = array( 
							'dealurl'	=>	get_permalink( $post->ID ), 
							'dealid'	=>	$post->ID
						);

			//google+ script
			wp_enqueue_script( 'google' );		
			//social google+ button template
			wps_deals_get_template( 'social-buttons/google.php', $args );
			
			//call ajax when user will share content to google plus
		?>	
			<script type="text/javascript">
				function wps_deals_gp_share_<?php echo $post->ID;?>( res ){
					
					//check user shared deal on google plus or not
					if( res.type == 'confirm' ) {	
						var data = { 
										postid	: '<?php echo $post->ID;?>',
										action	: 'deals_update_social_media_values',
										type	: 'gp'
									};
				
						jQuery.post( '<?php echo admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) );?>', data, function( response ) {
							if(response != '') {
								//window.location.reload();
								wps_deals_reload();
							}
						});
					}
				}
			</script>
			
		<?php
		
		}
	}
	
}

if( !function_exists( 'wps_deals_social_buttons' ) ) {
	/**
	 * Load Social Buttons Template
	 * 
	 * Handles to load social buttons
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_buttons() {
		
		//social buttons template
		wps_deals_get_template( 'social-buttons/social-buttons.php' );
		
	}
}

if( !function_exists( 'wps_deals_home_header_see_deal' ) ) {
	/**
	 * Load Big See Deal Button Template
	 * 
	 * Handles to load big see deal button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_header_see_deal() {
		
		//load big see deal button template
		wps_deals_get_template( 'buttons/deal-button-big.php');
	}
}

if( !function_exists( 'wps_deals_home_more_deal_price_flag' ) ) {
	/**
	 * Load Price Flag with Price Template
	 * 
	 * Handles to load price flag with price
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */	
	function wps_deals_home_more_deal_price_flag() {
		
		global $post,$wps_deals_price;
		
		//product price
		$dealprice = $wps_deals_price->wps_deals_get_price( $post->ID );
		$displayprice = $wps_deals_price->get_display_price( $dealprice, $post->ID );
		
		//price flag with price template
		wps_deals_get_template( 'home/home-content/price-flag-small.php', array( 'displayprice' => $displayprice ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_image' ) ) {
	/**
	 * Load More Deal Image Template for Home Page
	 * 
	 * Handles to load more deal image template
	 * for home page
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	function wps_deals_home_more_deal_image() {
		
		global $post;

		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for the deal main image from the post meta box		
		$deal_image = $deal_main_image = get_post_meta( $post->ID, $prefix . 'main_image', true );
		
		$dealimg = !empty( $deal_image['src'] ) ? $deal_image['src'] : WPS_DEALS_URL.'includes/images/deals-no-image-big.jpg';
		
		//more deals deal image template
		wps_deals_get_template( 'home/home-content/deal-image.php', array( 'dealimg' => $dealimg, 'dealurl'  => get_permalink( $post->ID ), 'dealtitle' => get_the_title($post->ID) ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_normal_price' ) ) {
	/**
	 * Load Normal Priec Template
	 * 
	 * Handles to load normal price template
	 * to show deal normal price
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_more_deal_normal_price() {
		
		global $post,$wps_deals_price;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for normal price from the post meta box
		$normalprice = get_post_meta($post->ID,$prefix.'normal_price',true);
		
		$displaynormalprice = $wps_deals_price->get_display_price( $normalprice, $post->ID );
		
		//deal normal price template
		wps_deals_get_template( 'home/home-content/deal-value.php', array( 'normalprice' => $displaynormalprice ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_discount' ) ) {
	/**
	 * Load Deal Discount Template
	 * 
	 * Handles to load deal discount template
	 * in home page more deals
	 *  
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_more_deal_discount() {
		
		global $post,$wps_deals_price;
		
		//discount 
		$discount = $wps_deals_price->wps_deals_get_discount( $post->ID );
		
		//deal discount template
		wps_deals_get_template( 'home/home-content/deal-discount.php', array( 'discount' => $discount ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_saving' ) ) {
	/**
	 * Load Deal Saving Price Template
	 * 
	 * Handles to load deal saving price template
	 * in home page more deals
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_more_deal_saving() {
		
		global $post,$wps_deals_price;
	
		//saving price
		$yousave = $wps_deals_price->wps_deals_get_savingprice($post->ID);
					
		
		//show deal image on home page content
		wps_deals_get_template( 'home/home-content/deal-save.php', array( 'savingprice' => $yousave ) );
	}
}

if( !function_exists( 'wps_deals_home_more_deal_footer_time' ) ) {
	
	/**
	 * Load Deal End Timer Template
	 * 
	 * Handles to load deal end timer template
	 * in home page more deals
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_home_more_deal_footer_time() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for end date & time of deals from the post meta box
		$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
		
		$args = array( 
							'year'		=>	date( 'Y', strtotime( $enddate ) ),
							'month'		=>	date( 'm', strtotime( $enddate ) ),
							'day'		=>	date( 'd', strtotime( $enddate ) ),
							'hours'		=>	date( 'H', strtotime( $enddate ) ),
							'minute'	=>	date( 'i', strtotime( $enddate ) ),
							'seconds'	=>	date( 's', strtotime( $enddate ) )
						);
	
		//deal timer template
		wps_deals_get_template( 'home/home-content/timer.php', $args );
		
	}
}

if( !function_exists( 'wps_deals_home_more_deal_footer_see_deal' ) ) {
	
	/**
	 * Load Small See Deal Button Template
	 * 
	 * Handles to load small see deal button
	 * template in home page more deals
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	
	function wps_deals_home_more_deal_footer_see_deal() {
		
		global $post;
		
		//show deal image on home page content
		wps_deals_get_template( 'buttons/deal-button-small.php', array( 'dealurl' => get_permalink($post->ID) ) );
	}
}
/*************************** Single Deals Page Template ******************************/
/**
 * Single Deals Template Functions
 * 
 * Handles to Show Single Deal
 * page
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 */
if( !function_exists( 'wps_deals_single_header' ) ){

	/**
	 * Load Single Deal Header Template
	 * 
	 * Handles to load single deal header template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_header() {
	
		//counter timer script
		wp_enqueue_script( 'wps-deals-countdown-timer-scripts' );
		//single deal header template
		wps_deals_get_template( 'single-deal/single-header.php' );
	}
	
}
if( !function_exists( 'wps_deals_single_content' ) ){

	/**
	 * Load Single Deal Content Template
	 * 
	 * Handles to load single deal content
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_content() {
	
		//single deal content template
		wps_deals_get_template( 'single-deal/single-content.php' );
	}
	
}
if( !function_exists( 'wps_deals_single_header_left' ) ){

	/**
	 * Load Single Deal Header Left Template
	 * 
	 * Handles to load single deal header
	 * left part template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_header_left() {
	
		//single deal left part template
		wps_deals_get_template( 'single-deal/single-header/header-left.php' );
	}
	
}
if( !function_exists( 'wps_deals_single_description' ) ){

	/**
	 * Load Single Deal Description template
	 * 
	 * Handles to load single deal description
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_description() {
	
		//single deal description template
		wps_deals_get_template( 'single-deal/single-content/description.php' );
	}
	
}

if( !function_exists( 'wps_deals_single_add_to_cart' ) ) {
	
	/**
	 * Load Single Deal Add to Cart Button Template
	 * 
	 * Handles to load add to cart button template
	 * on single deal page
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_add_to_cart() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//today's date time
		//$today = date('Y-m-d H:i:s');
		$today	= wps_deals_current_date();
		
		//get the value for available deals from the post meta box
		$available = get_post_meta($post->ID,$prefix.'avail_total',true);
		
		//get the value for start date & time of deals from the post meta box
		$startdate = get_post_meta($post->ID,$prefix.'start_date',true);
		
		//get the value for end date & time of deals from the post meta box
		$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
		
		//when deal expired
		$dealexpired = false;
	
		if ( $available == '' ) {
			//$availdeals =  __('Unlimited','wpsdeals');
		} else if ( intval( $available ) == 0 ) {
			//$availdeals =  __('Out of Stock','wpsdeals');
			$dealexpired = true;
		} else {}
		 
		//if deal is active and deals is not in upcoming list or not out of stock
		if( $enddate >= $today && $startdate <= $today && $dealexpired != true ) {
			
			//add to cart  buttons template
			wps_deals_get_template( 'single-deal/single-header/add-to-cart.php' );
		}
	}
}

if( !function_exists( 'wps_deals_single_dimsale_box' ) ) {
	
	/**
	 * Load Single Deal Dimsale Box Template
	 * 
	 * Handles to load single deal dimsale
	 * box template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_dimsale_box() {
		
		global $post,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// Get deal type
		$wps_deal_type = $wps_deals_model->wps_deals_get_deal_type( $post->ID );
		
		if( $wps_deal_type != 'affiliate' )	{
				
			//today's date time
			//$today = date('Y-m-d H:i:s');
			$today	= wps_deals_current_date();
			
			//get the value for available deals from the post meta box
			$available = get_post_meta($post->ID,$prefix.'avail_total',true);
			
			//get the value for start date & time of deals from the post meta box
			$startdate = get_post_meta($post->ID,$prefix.'start_date',true);
			
			//get the value for end date & time of deals from the post meta box
			$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
			
			//when deal expired
			$dealexpired = false;
		
			if ( $available == '' ) {} //check availble  is empty or not
			elseif ( intval( $available ) == 0 ) { $dealexpired = true; } 
			else {}
			
			//get dimsale ratio
			$dimsaleratio = get_post_meta( $post->ID, $prefix.'inc_ratio', true );
			
			//get dimsale price 
			$dimsaleprice = get_post_meta( $post->ID, $prefix.'inc_price', true );
			
			//get dimsale is activated
			$dimsaleamt = get_post_meta($post->ID, $prefix.'nxt_inc_period', true);
		
			$lefttext = '';
			
			if(!empty( $dimsaleprice ) && !empty( $dimsaleratio ) ) {
				$leftcopies = ( $dimsaleratio - $dimsaleamt );
				$lefttext = apply_filters( 'wps_deals_dim_sale_text',sprintf( __('Only %1$s left at this price', 'wpsdeals' ), $leftcopies ) ); 
			}
			//if deal is active and deals is not in upcoming list or not out of stock
			if( $enddate >= $today && $startdate <= $today && $dealexpired != true ) {
				
				//dim sale box template
				wps_deals_get_template( 'single-deal/single-header/dim-sale.php', array( 'lefttext' => $lefttext ) );
			}
		}	
	}
	
}

if( !function_exists( 'wps_deals_single_deal_expired' ) ) {
	
	/**
	 * Load Single Deal Expired Template
	 * 
	 * Handles to load single deal expired
	 * template
	 *  
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_expired() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//today's date time
		$today	= wps_deals_current_date();
		
		//get the value for available deals from the post meta box
		$available = get_post_meta($post->ID,$prefix.'avail_total',true);
		
		//get the value for start date & time of deals from the post meta box
		$startdate = get_post_meta($post->ID,$prefix.'start_date',true);
		
		//get the value for end date & time of deals from the post meta box
		$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
		
		//when deal expired
		$dealexpired = false;
	
		//expired label
		$expiredtext = __( 'Deal expired', 'wpsdeals' );
		
		if ( $available == '' ) {
			//$availdeals =  __('Unlimited','wpsdeals');
		} elseif ( intval( $available ) == 0  && $enddate >= $today) { // deal out of stock
			$expiredtext = __( 'Sold Out', 'wpsdeals' );
			$dealexpired = true;
		} else {
			//nothing to do
		}
		
		if( $enddate <= $today || $dealexpired == true ) {
			
			//deal expired template
			wps_deals_get_template( 'single-deal/single-header/add-to-cart/expired.php', array( 'expiredtext' => $expiredtext ) );
		}
		
	}
	
}

if( !function_exists( 'wps_deals_single_deal_details' ) ) {
	
	/**
	 * Load Single Deal Details Template 
	 * 
	 * Handles to load single deal details
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_details() {
		
		//deal details template
		wps_deals_get_template( 'single-deal/single-header/deal-details.php' );
		
	}
	
}

if( !function_exists( 'wps_deals_single_deal_timer' ) ) {
	
	/**
	 * Load Single Deal Timer Template
	 * 
	 * Handles to load single deal timer 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_timer() {
		
		global $post,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//today's date time
		$today	= wps_deals_current_date();
		
		//get the value for start date & time of deals from the post meta box
		$startdate = get_post_meta($post->ID,$prefix.'start_date',true);
		
		//get the value for end date & time of deals from the post meta box
		$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
		
		if( $enddate >= $today ) { //check if the deal is still active
			
			if(!empty($enddate) || !empty($startdate)) { //check end date is not empty or startdate is not empty
				if( $startdate >= $today)  { // check startdate is greater than today 
					$counterdate = $startdate;
				} else {
					$counterdate = $enddate;
				}
			}
			
			$args = array( 
							'startdate'	=>	$startdate, 
							'enddate'	=>	$enddate,
							'today'		=>	$today,
							'year'		=>	date( 'Y', strtotime( $counterdate ) ),
							'month'		=>	date( 'm', strtotime( $counterdate ) ),
							'day'		=>	date( 'd', strtotime( $counterdate ) ),
							'hours'		=>	date( 'H', strtotime( $counterdate ) ),
							'minute'	=>	date( 'i', strtotime( $counterdate ) ),
							'seconds'	=>	date( 's', strtotime( $counterdate ) )
						);
			
			//deal timer template
			wps_deals_get_template( 'single-deal/single-header/deal-end-timer.php',  $args );
		}
		
	}
	
}

if( !function_exists( 'wps_deals_single_deal_avail_bought' ) ) {
	
	/**
	 * Load Single Deal Available & Bought Box Template
	 * 
	 * Handles to load single deal available & bought
	 * box tempalte
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_avail_bought() {
		
		global $post,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// Get deal type
		$wps_deal_type = $wps_deals_model->wps_deals_get_deal_type( $post->ID );
		if( $wps_deal_type != 'affiliate' )	{ // Check deal type is not affiliate
				
			//today's date time
			$today	= wps_deals_current_date();
			
			//get the value for end date & time of deals from the post meta box
			$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
			
			//get the available_bought value from the meta box
			$available_bought = get_post_meta($post->ID,$prefix.'available_bought',true);
			
			if( $enddate >= $today ) { //check if the deal is still active
					
				//available and bought box template
				wps_deals_get_template( 'single-deal/single-header/avail-bought.php', array( 'availablebought' => $available_bought ) );
				
			}
		}
	}
	
}

if( !function_exists( 'wps_deals_single_deal_ratings' ) ) { 
	
	/**
	 * Load Single Deal Ratings Template
	 * 
	 * Handles to single deal ratings 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_ratings() {
		
		if( class_exists( 'Wps_Fbre_Model' ) ) { // check if the social review engine plugin is activated
			
			global $post,$wps_fbre_model;
			
			$rating = round( $wps_fbre_model->wps_fbre_post_average_ratings( $args = array( 'post_id' => $post->ID ) ) );
		
			//ratings template
			wps_deals_get_template( 'single-deal/single-header/ratings.php', array( 'rating' => $rating ) );
		}
		
	}
}
if( !function_exists( 'wps_deals_single_deal_img' ) ) { 
	
	/**
	 * Load Single Deal Image Tempalte
	 * 
	 * Handles to load single deal image 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_deal_img() {
		
		global $post,$wps_deals_price;
		
		//product price
		$productprice = $wps_deals_price->wps_deals_get_price($post->ID);
		
		//get the value for main image of deal from the post meta box		
		$dealimage = get_the_post_thumbnail( $post->ID, 'wpsdeals-single', array( 	'alt' => __('Deal Image','wpsdeals'), 
																					'title'	=> trim( strip_tags( $post->post_title ) ) 
																				) );
		
		$imgurl = !empty( $dealimage ) ? $dealimage : '<img src="'.WPS_DEALS_URL.'includes/images/deals-no-image-big.jpg'.'" alt="'.__('Deal Image','wpsdeals').'" />';
		
		$dealprice = $wps_deals_price->get_display_price( $productprice, $post->ID );
					
		//deal image template
		wps_deals_get_template( 'single-deal/single-header/deal-image.php', array( 'price' => $dealprice, 'dealimg'	=> $imgurl ) );
	}
}

if( !function_exists( 'wps_deals_single_footer' ) ) {

	/**
	 * Load Single Deal Footer Template
	 * 
	 * Handles to load single deal footer
	 * content template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_footer() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for terms and conditions of deals from the post meta box
		$termsconditions = get_post_meta($post->ID,$prefix.'terms_conditions',true);
		
		//get the value for address of deal from the post meta box
		$address = get_post_meta($post->ID,$prefix.'address',true);
		
		//get the value for business URL of deal from the post meta box
		$business_url = get_post_meta($post->ID,$prefix.'bus_web_url',true);
		
		// get the business title from the post meta box
		$business_title = get_post_meta($post->ID,$prefix.'business_title',true);
		
		// get the business logo from the post meta box
		$business_logo = get_post_meta($post->ID,$prefix.'business_logo',true);
		
		// get the business address from the post meta box
		$business_address = get_post_meta($post->ID,$prefix.'business_address',true);
		
		if( !empty( $business_title ) || !empty( $address ) || !empty( $business_logo ) || !empty( $business_address ) || !empty( $business_url ) || !empty( $termsconditions ) ) {
		
			//footer content template
			wps_deals_get_template( 'single-deal/single-footer.php' );
		}
	}
	
}

if( !function_exists( 'wps_deals_purchase_link_button' ) ) {
	/**
	 * Load Purchase Link Button Template
	 * 
	 * Handles to load single deal purchase link button
	 * when purchase link is not empty
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_purchase_link_button() {
		
		global $post,$wps_deals_price,$wps_deals_options,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the purchase link for affiliate products 
		$purchaselink = get_post_meta($post->ID,$prefix.'purchase_link',true);
		
		//product price
		$productprice = $wps_deals_price->wps_deals_get_price( $post->ID );
		
		//display price
		$displayprice = $wps_deals_price->get_display_price( $productprice, $post->ID  );
		
		//get add to cart button 
		$addtocart_post = get_post_meta($post->ID,$prefix.'add_to_cart',true);
		if( !empty( $addtocart_post ) ) {
			$addcartbtntext = $addtocart_post;
		} else {
			$addcartbtntext = isset($wps_deals_options['add_to_cart_text']) && !empty($wps_deals_options['add_to_cart_text']) ? $wps_deals_options['add_to_cart_text'] : __('Add to Cart', 'wpsdeals');
		}
		
		if( !empty( $purchaselink ) ) {
					
			wps_deals_get_template( 'single-deal/single-header/add-to-cart/purchase-link-cart-button.php', array( 'addcartbtntext' => $addcartbtntext, 'displayprice' => $displayprice, 'purchaselink' => $purchaselink ) );
			
		}
	}
}
if( !function_exists( 'wps_deals_add_to_cart_button' ) ) {
	
	/**
	 * Load Single Deal Add to Cart Button Template
	 * 
	 * Handles to load single deal add to cart
	 * button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_add_to_cart_button() {
		
		global $post,$wps_deals_options,$wps_deals_price,$wps_deals_model;
		
		$prefix = WPS_DEALS_META_PREFIX;
			
		//product price
		$productprice = $wps_deals_price->wps_deals_get_price( $post->ID );
		
		//display price
		$displayprice = $wps_deals_price->get_display_price( $productprice,$post->ID );
		
		//get checkout url 
		$checkouturl = get_permalink( $wps_deals_options['payment_checkout_page'] );
		
		//get the purchase link for affiliate products 
		$purchaselink = get_post_meta( $post->ID,$prefix.'purchase_link',true );
		
		//get add to cart button 
		$addtocart_post = get_post_meta( $post->ID,$prefix.'add_to_cart',true );
		
		if( !empty( $addtocart_post ) ) {	
			$addcartbtntext = $addtocart_post;
		} else { 
			$addcartbtntext = isset($wps_deals_options['add_to_cart_text']) && !empty($wps_deals_options['add_to_cart_text']) 
								? $wps_deals_options['add_to_cart_text'] : __('Add to Cart', 'wpsdeals');
		}
			
		$args = array( 
						'addcartbtntext'	=>	$addcartbtntext, 
						'displayprice'		=>	$displayprice, 
						'dealid'			=>	$post->ID, 
						'checkouturl' 		=>	$checkouturl );
			
		//add to cart button template
		wps_deals_get_template( 'single-deal/single-header/add-to-cart/add-to-cart-button.php', $args );
		
	}
}

if( !function_exists( 'wps_deals_buy_now_button' ) ) {
	
	/**
	 * Load Single Deal Buy Now Button Template
	 * 
	 * Handles to load single deal buy now
	 * button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_buy_now_button() {
		
		global $post,$wps_deals_options,$wps_deals_price;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		$dealurl = get_permalink( $post->ID );
			
		//product price 
		$productprice = $wps_deals_price->wps_deals_get_price( $post->ID );
			
		//display price
		$displayprice = $wps_deals_price->get_display_price( $productprice,$post->ID );
		
		//get the buy now test from meta
		$buynowtext = get_post_meta( $post->ID,$prefix.'buy_now',true );
		
		// Check user is not logged in and disable guest checkout from misc settings
		if( !is_user_logged_in() && !empty( $wps_deals_options['disable_guest_checkout'] ) ) {
			$payurl = wp_login_url( $dealurl );
		} else {
			$payurl = add_query_arg( array( 'dealsaction' => 'buynow', 'dealid' => $post->ID ), $dealurl );	
		}
		
		$args = array( 
						'payurl' 			=>  $payurl, 
						'displayprice'		=>	$displayprice, 
						'dealid'			=>	$post->ID, 
						'buynowtext'		=>	!empty( $buynowtext ) ? $buynowtext : __('Buy Now', 'wpsdeals')
					);
			
		//buy now button template
		wps_deals_get_template( 'single-deal/single-header/buy-now-button.php', $args );
		
	}
}

if( !function_exists( 'wps_deals_single_normalprice' ) ) {
		
	/**
	 * Load Single Deal Normal Price Template
	 * 
	 * Handles to load single deal normal price
	 * template 
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_normalprice() {
		
		global $post,$wps_deals_price;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for normal price from the post meta box
		$normalprice = get_post_meta($post->ID,$prefix.'normal_price',true);
		
		$displayprice = $wps_deals_price->get_display_price( $normalprice, $post->ID );
		
		//show normal value template
		wps_deals_get_template( 'single-deal/single-header/deal-value.php', array( 'price' => $displayprice ) );
		
	}
}

if( !function_exists( 'wps_deals_single_discount' ) ) {
		
	/**
	 * Load Single Deal Discount Template
	 * 
	 * Handles to load single deal discount
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_discount() {
		
		global $post,$wps_deals_price;
		
		//discount 
		$discount = $wps_deals_price->wps_deals_get_discount($post->ID);
		
		//show deal discount template
		wps_deals_get_template( 'single-deal/single-header/deal-discount.php', array( 'discount' => $discount ) );
		
	}
}
if( !function_exists( 'wps_deals_single_save' ) ) {
		
	/**
	 * Load Single Deal Saving Price Template
	 * 
	 * Handles to show single deal saving 
	 * price template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_save() {
		
		global $post,$wps_deals_price;
		
		//saving price
		$yousave = $wps_deals_price->wps_deals_get_savingprice($post->ID);	
		
		//show deal saving price template
		wps_deals_get_template( 'single-deal/single-header/deal-save.php', array( 'savingprice' => $yousave ) );
		
	}
}
if( !function_exists( 'wps_deals_single_available' ) ) {
		
	/**
	 * Load Single Deal Available Box Template
	 * 
	 * Handles to show single deal available box
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_available() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for available deals from the post meta box
		$avail = get_post_meta($post->ID,$prefix.'avail_total',true);
		
		//when deal expired
		$dealexpired = false;
		
		if ( $avail == '' ) {
			$available =  __('Unlimited','wpsdeals');
		} elseif ( intval( $avail ) == 0 ) {
			$available =  __('Out of Stock','wpsdeals');
			$dealexpired = true;
		} else {
			$available = $avail;
		}
		 
		//show deal available template
		wps_deals_get_template( 'single-deal/single-header/avail-bought/available.php', array( 'available' => $available ) );
		
	}
}
if( !function_exists( 'wps_deals_single_bought' ) ) {
		
	/**
	 * Load Single Deal Bought Box Template
	 * 
	 * Handles to load single deal bought box
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_bought() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for bought deals from the post meta box
		$boughts = get_post_meta($post->ID,$prefix.'boughts',true);
		$boughts = isset($boughts) && !empty($boughts) ? $boughts : '0';
		
		//bought box template
		wps_deals_get_template( 'single-deal/single-header/avail-bought/bought.php', array( 'bought' => $boughts ) );
	}
}

if( !function_exists( 'wps_deals_single_business_title' ) ) {
		
	/**
	 * Load Single Business Title Template
	 * 
	 * Handles to single deal business title
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_business_title() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the business title from the post meta box
		$businesstitle = get_post_meta($post->ID,$prefix.'business_title',true);
	
		//business title template
		if( !empty( $businesstitle ) ) { //check business title is not empty
			wps_deals_get_template( 'single-deal/single-footer/business-title.php', array( 'businesstitle' => $businesstitle ) );
		}
	}
}
if( !function_exists( 'wps_deals_single_business_location' ) ) {
		
	/**
	 * Load Single Deal Business Location Map Template
	 * 
	 * Handles to load single deal business
	 * location map template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_business_location() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		//show google map
		$gmapaddress = get_post_meta( $post->ID, $prefix.'address', true );
		$address = str_replace("'", "&prime;", $gmapaddress);
		
		
		if( !empty( $address ) ) { //check business title is not empty
			
			wp_enqueue_script('wps-deals-google-map');
			wp_enqueue_script('wps-deals-map-script');
		
			//business location map templatte	
			wps_deals_get_template( 'single-deal/single-footer/business-location-map.php' );
			
		}
	}
}
if( !function_exists( 'wps_deals_single_business_logo' ) ) {
		
	/**
	 * Load Single Deal Business Logo Template
	 * 
	 * Handles to single deal business logo
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_business_logo() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the business logo from the post meta box
		$business_logo = get_post_meta($post->ID,$prefix.'business_logo',true);
		
		
		if( !empty( $business_logo['src'] ) ) { //check business title is not empty
			
			//business logo template
			wps_deals_get_template( 'single-deal/single-footer/business-logo.php', array( 'imgurl' => $business_logo['src'] ) );
			
		}
	}
}
if( !function_exists( 'wps_deals_single_business_address' ) ) {
		
	/**
	 * Load Single Deal Business Address Template
	 * 
	 * Handles to load single deal business address
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_business_address() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the business address from the post meta box
		$business_address = get_post_meta($post->ID,$prefix.'business_address',true);
		
		
		if( !empty( $business_address ) ) { //check business title is not empty
			
			//business address template	
			wps_deals_get_template( 'single-deal/single-footer/business-address.php', array( 'address' => $business_address ) );
			
		}
	}
}
if( !function_exists( 'wps_deals_single_business_link' ) ) {
		
	/**
	 * Load Single Deal Business Link Template 
	 * 
	 * Handles to load single deal business
	 * link template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_business_link() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for business URL of deal from the post meta box
		$business_url = get_post_meta($post->ID,$prefix.'bus_web_url',true);
		
		
		if( !empty( $business_url ) ) { //check business title is not empty
			
			//business link template	
			wps_deals_get_template( 'single-deal/single-footer/business-link.php', array( 'businesslink' => $business_url ) );
			
		}
	}
}
if( !function_exists( 'wps_deals_single_terms_conditions' ) ) {
		
	/**
	 * Load Single Deal Terms & Condition Template
	 * 
	 * Handles to load single deal terms & condition
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_single_terms_conditions() {
		
		global $post;
	
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for terms and conditions of deals from the post meta box
		$termsconditions = get_post_meta($post->ID,$prefix.'terms_conditions',true );
		
		if( !empty( $termsconditions ) ) { //check terms and conditions
			
			//terms and conditions template	
			wps_deals_get_template( 'single-deal/single-footer/terms.php', array( 'termsconditions' => $termsconditions ) );
			
		}
	}
}

/*************************** Orders Deals Page Template ******************************/

if( !function_exists( 'wps_deals_order_view_content_before' ) ) {

	/**
	 * Load Cheque Payment Message Template 
	 * 
	 * Handles to show cheque payment message content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.1
	 */
	function wps_deals_order_view_content_before( $order_id ) {
		
		global $wps_deals_model, $wps_deals_options;
		
		// get the value for the order details from the post meta box
		$order_details = $wps_deals_model->wps_deals_get_post_meta_ordered( $order_id );
		
		$payment_method = isset( $order_details['payment_method'] ) ? $order_details['payment_method'] : '';
	
		// Check payment method is cheque payment and not empty customer message from settings
		if( $payment_method == 'cheque' && isset( $wps_deals_options['cheque_customer_msg'] )
			 && !empty( $wps_deals_options['cheque_customer_msg'] ) ) {
		
			//cheque payment message details template
			wps_deals_get_template( 'orders/order-cheque-payment-message.php', array( 'cheque_customer_msg' => nl2br( $wps_deals_options['cheque_customer_msg'] ) ) );
		
		}
	}
}
if( !function_exists( 'wps_deals_orders_content' ) ) {

	/**
	 * Load Orders Template 
	 * 
	 * Handles to load orders template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_orders_content() {
		
		//order details template
		wps_deals_get_template( 'orders/orders.php' );
	}
}
if( !function_exists( 'wps_deals_orders_listing_content' ) ) {

	/**
	 * Load Orders Listing Table Template 
	 * 
	 * Handles to load orders listing table template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_orders_listing_content( $ordereddeals, $paging ) {
		
		//order details template
		wps_deals_get_template( 'orders/orders-listing/orders-listing.php', array(	'ordereddeals'	=> $ordereddeals, 
																					'paging'		=> $paging ) );
	}
}
if( !function_exists( 'wps_deals_orders_complete_content' ) ) {

	/**
	 * Load Orders Complete Template
	 * 
	 * Handles to load orders complete 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_orders_complete_content() {
		
		//order complete details template
		wps_deals_get_template( 'orders/order-complete-details.php' );
	}
}
if( !function_exists( 'wps_deals_orders_cancel_content' ) ) {

	/**
	 * Load Orders Cancel Template
	 * 
	 * Handles to load orders cancel 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_orders_cancel_content() {
		
		//order cancel template
		wps_deals_get_template( 'orders/order-cancel-details.php' );
	}
}

/*************************** Checkout Deals Page Template ******************************/

if( !function_exists( 'wps_deals_checkout_header' ) ) {
	
	/**
	 * Load Checkout Header Template
	 * 
	 * Handles to load checkout header
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_header() {
		
		//credit card validator script
		wp_enqueue_script( 'wps-deals-credit-card-validator-scripts' );
		//checkout header template
		wps_deals_get_template( 'checkout/checkout-header.php' );
	}
	
}

if( !function_exists( 'wps_deals_checkout_content' ) ) {
	
	/**
	 * Load Checkout Content Template
	 * 
	 * Handles to load checkout content
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_content() {
		
		//no payment gateway selected
		wps_deals_get_template( 'checkout/checkout-content.php' );
	}
	
}

if( !function_exists( 'wps_deals_checkout_footer' ) ) {

	/**
	 * Load Checkout Footer Template
	 * 
	 * Handles to load checkout footer
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_footer() {
		
		$paymentgatway = wps_deals_get_enabled_gateways();
		
		if( !empty( $paymentgatway )  ) { //check payment gateways
			
			//checkout footer template
			wps_deals_get_template( 'checkout/checkout-footer.php' );
			
		} else {
			//no payment gateway selected template
			wps_deals_get_template( 'checkout/checkout-footer/no-payment-gatway.php' );
		}
	}
}

if( !function_exists( 'wps_deals_cart_details' ) ) {
	
	/**
	 * Load Checkout Cart Details Template
	 * 
	 * Handles to load checkout cart details
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_details() {
		
		//cart details table template
		wps_deals_get_template( 'checkout/checkout-header/cart-details.php' );
		
	}
}

if( !function_exists( 'wps_deals_cart_action_buttons' ) ) {
	
	/**
	 * Load Cart Actions Buttons Template
	 * 
	 * Handles to load cart action buttons
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_action_buttons() {
		
		//cart actions buttons template
		wps_deals_get_template( 'checkout/checkout-header/cart-action-buttons.php' );
		
	}
}

if( !function_exists( 'wps_deals_cart_empty_button' ) ) {
	
	/**
	 * Load Cart Empty Button Template
	 * 
	 * Handles to load cart empty button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_empty_button() {
		
		//cart empty button template
		wps_deals_get_template( 'checkout/checkout-header/cart-action-buttons/cart-empty-button.php' );
		
	}
}

if( !function_exists( 'wps_deals_cart_update_button' ) ) {
	
	/**
	 * Load Cart Update Button Template
	 * 
	 * Handles to load update cart button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_update_button() {
		
		//cart update button template
		wps_deals_get_template( 'checkout/checkout-header/cart-action-buttons/cart-update-button.php' );
		
	}
}

if( !function_exists( 'wps_deals_display_description' ) ) {
	
	/**
	 * Load Cheque Payment Description Template
	 * 
	 * Handles to load cheque payment description
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_display_description() {
		
		global $wps_deals_options;
		
		//get enable payment methods
		$enablepayments = wps_deals_get_enabled_gateways();
		$defaultgateway = $wps_deals_options['default_payment_gateway'];
		
		//check only banktransfer is enable only one payment gateway
		//if banktransfer is selected in default gateway
		if( array_key_exists( 'cheque', $enablepayments ) && 
			( count( $enablepayments ) == 1 || $defaultgateway == 'cheque' ) ) {
			$enablebankdesc = ' wps-deals-payment-description-show';
		} else {
			$enablebankdesc = ' wps-deals-payment-description-none';
		}
		
		$cheque_customer_msg = isset( $wps_deals_options['cheque_customer_msg'] ) ? $wps_deals_options['cheque_customer_msg'] : '';
		
		if( !empty( $cheque_customer_msg ) ) {
			//cheque description template
			wps_deals_get_template( 'checkout/checkout-footer/cheque-payment-description.php', array( 	'description' 	=> nl2br( $cheque_customer_msg ),
																										'enablebankdesc'=> $enablebankdesc ) );
		}
		
	}
}

if( !function_exists( 'wps_deals_cart_social_login' ) ) {
	
	/**
	 * Load Checkout Social Login Buttons Template
	 * 
	 * Handles to load checkout social login buttons
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_social_login() {
		
		global $wps_deals_options, $wps_deals_session;
		
		//check user is not logged in and social login is enable or not for any one service
		if( !is_user_logged_in() && wps_deals_enable_social_login() ) {
			
			// get redirect url from settings
			$defaulturl = isset( $wps_deals_options['login_redirect_url'] ) && !empty( $wps_deals_options['login_redirect_url'] ) 
								? $wps_deals_options['login_redirect_url'] : wps_deals_get_current_page_url();
			
			//redirect url for shortcode
			$defaulturl = isset( $redirect_url ) && !empty( $redirect_url ) ? $redirect_url : $defaulturl; 
			
			//session create for redirect url
			$wps_deals_session->set( 'wps_deals_stcd_redirect_url', $defaulturl );
			
			// get title from settings
			$login_heading = isset( $wps_deals_options['login_heading'] ) ? $wps_deals_options['login_heading'] : __( 'Login with Social Media', 'wpsdeals' );
			
			// get redirect url from settings
			$login_redirect_url = isset( $wps_deals_options['login_redirect_url'] ) ? $wps_deals_options['login_redirect_url'] : '';
			
			//load social login buttons template
			wps_deals_get_template( 'checkout/checkout-content/social.php', array( 	'title' 			=> $login_heading,
																					'login_redirect_url'=> $login_redirect_url
																					) );
			
			//enqueue social front script
			wp_enqueue_script( 'wps-deals-social-front-scripts' );
		}
	}
}

if( !function_exists( 'wps_deals_social_login_shortcode' ) ) {
	
	/**
	 * Load Shortcode Social Login Buttons Template
	 * 
	 * Handles to load shortcode social login buttons
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_shortcode( $title = '', $redirect_url = '' ) {
		
		global $wps_deals_options;
		
		// get title from settings
		$login_heading = isset( $wps_deals_options['login_heading'] ) ? $wps_deals_options['login_heading'] : __( 'Login with Social Media', 'wpsdeals' );
		$login_heading = !empty( $title ) ? $title : $login_heading; // check title first from shortcode
		
		// get redirect url from settings
		$login_redirect_url = isset( $wps_deals_options['login_redirect_url'] ) ? $wps_deals_options['login_redirect_url'] : '';
		$login_redirect_url = !empty( $redirect_url ) ? $redirect_url : $login_redirect_url; // check redirect url first from shortcode
		
		//load social login buttons template
		wps_deals_get_template( 'checkout/checkout-content/social.php', array( 	'title' 			=> $login_heading,
																				'login_redirect_url'=> $login_redirect_url
																				) );
		
		//enqueue social front script
		wp_enqueue_script( 'wps-deals-social-front-scripts' );
	}
}

if( !function_exists( 'wps_deals_checkout_payment_gateways' ) ) {
	
	/**
	 * Load Checkout Payment Gateways Template
	 * 
	 * Handles to load checkout payment gateway 
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_payment_gateways() {
		
		global $wps_deals_options;
		
		$paymentgatway = wps_deals_get_enabled_gateways();
		
		//check default gateway is set or not and it is enabled or not
		if( isset( $wps_deals_options['default_payment_gateway'] ) 
			&& array_key_exists( $wps_deals_options['default_payment_gateway'], $paymentgatway ) ) {
			$defaultgatway = $wps_deals_options['default_payment_gateway'];
		} else {
			$defaultgatway = 'paypal';
		}
		
		//payment gateway template
		wps_deals_get_template( 'checkout/checkout-footer/payment-gateway.php', array( 'paymentgatway' => $paymentgatway, 'defaultgatway' => $defaultgatway ));
		
	}
	
}
if( !function_exists( 'wps_deals_checkout_user_form' ) ) {
	
	/**
	 * Load Checkout User Register & Login Form Template
	 * 
	 * Handles to load checkout user register & login form
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_user_form() {

		global $wps_deals_options;
				
		if(!is_user_logged_in() && (!empty($wps_deals_options['show_login_register']) || !empty($wps_deals_options['disable_guest_checkout']))) { //check user is not logged in and show login and register option is selected from backend
			
			//load user form template
			wps_deals_get_template( 'checkout/checkout-footer/user-form.php' );
					
		}
	}
}

if( !function_exists( 'wps_deals_cart_user_reg_form' ) ) {
	
	/**
	 * Load Cart User Register Form Template
	 * 
	 * Handles to load user register form
	 * on single deal page
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_user_reg_form() {

		//registration form template
		wps_deals_get_template( 'checkout/checkout-footer/user-form/registration-form.php' );
		
	}
	
}

if( !function_exists( 'wps_deals_cart_user_login_form' ) ) {
	
	/**
	 * Load Cart User Login Form Template
	 * 
	 * Handles to load user login form
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_user_login_form() {

		//login form template
		wps_deals_get_template( 'checkout/checkout-footer/user-form/login-form.php' );
		
	}
	
}

if( !function_exists( 'wps_deals_cart_user_personal_details' ) ) {
	
	/**
	 * Load Cart User Personal Details Template
	 * 
	 * Handles to load user personal details
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_user_personal_details() {
		
		//personal details template
		wps_deals_get_template( 'checkout/checkout-footer/personal-details.php' );
		
	}
}
if( !function_exists( 'wps_deals_cart_user_billing_details' ) ) {
	
	/**
	 * Load Cart User Billing Details Template
	 * 
	 * Handles to load user billing details
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_user_billing_details() {
		
		global $current_user, $wps_deals_options;
		
		//check billing is enable from settings page
		if( isset( $wps_deals_options['enable_billing'] ) && !empty( $wps_deals_options['enable_billing'] ) ) {
		
			$prefix = WPS_DEALS_META_PREFIX;
			
			//get user billing data saved
			$userbillingdata	=	get_user_meta( $current_user->ID, $prefix.'billing_details', true );
			
			//get user country from saved
			$usercountry		=	isset( $userbillingdata['country'] ) ? $userbillingdata['country'] : '';
			//get user company name
			$usercompany		=	isset( $userbillingdata['company'] ) ? $userbillingdata['company'] : '';
			//get user address1 
			$useraddress1		=	isset( $userbillingdata['address1'] ) ? $userbillingdata['address1'] : '';
			//get user address2 
			$useraddress2		=	isset( $userbillingdata['address2'] ) ? $userbillingdata['address2'] : '';
			//get user city or town
			$usercity			=	isset( $userbillingdata['city'] ) ? $userbillingdata['city'] : '';
			//get user state or county
			$userstate			=	isset( $userbillingdata['state'] ) ? $userbillingdata['state'] : '';
			//get user post code
			$userpostcode		=	isset( $userbillingdata['postcode'] ) ? $userbillingdata['postcode'] : '';
			//get user phone
			$userphone			=	isset( $userbillingdata['phone'] ) ? $userbillingdata['phone'] : '';
			
			//get statelist from country
			$statesfrom =  wps_deals_get_states_from_country( $usercountry );
			$states = !empty( $statesfrom ) ? $statesfrom : '';
			
			//data pased to template
			$billingargs = array( 
									'countries'		=>	wps_deals_get_country_list(),
									'usercountry'	=>	$usercountry,
									'usercompany'	=>	$usercompany,
									'useraddress1'	=>	$useraddress1,
									'useraddress2'	=>	$useraddress2,
									'usercity'		=>	$usercity,
									'userstate'		=>	$userstate,
									'userpostcode'	=>	$userpostcode,
									'userphone'		=>	$userphone,
									'statelist'		=>	$states
								);
			
			//billing details template
			wps_deals_get_template( 'checkout/checkout-footer/billing-details.php', $billingargs );
			
		} //end if to check enable billing or not
	}
}
if( !function_exists( 'wps_deals_cart_agree_terms' ) ) {
	
	/**
	 * Load Cart Agree Terms & Conditions Template
	 * 
	 * Handles to load agree terms & conditions
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_agree_terms() {

		global $wps_deals_options;
		
		if( !empty( $wps_deals_options['enable_terms'] ) ) { //check if agree terms is enabled from backend
		
			$agreelabel = isset($wps_deals_options['terms_label']) && !empty($wps_deals_options['terms_label']) ? $wps_deals_options['terms_label'] : '';
			
			 $args = array( 
				 			'termscontent'	=>	wpautop( $wps_deals_options['terms_content'] ),
				 			'agreelabel' 	=>	$agreelabel
			 			 );
			 			 
			//terms and conditions template
			wps_deals_get_template( 'checkout/checkout-footer/terms.php', $args );
		}
	}
}
if( !function_exists( 'wps_deals_checkout_order_total_button' ) ) {
	
	/**
	 * Load Checkout Order Total & Place Your Order Button  Template
	 * 
	 * Handles to load checkout order total & 
	 * place your order button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_checkout_order_total_button() {
		
		//cart button and total template
		wps_deals_get_template( 'checkout/checkout-footer/order-total-button.php' );
		
	}
}

if( !function_exists( 'wps_deals_empty_cart_message' ) ) {
	
	/**
	 * Load Cart Empty Message Template
	 * 
	 * Handles to load cart empty message
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_empty_cart_message() {
		
		//cart empty template
		wps_deals_get_template( 'checkout/checkout-header/cart-empty.php' );
		
	}
}

if( !function_exists( 'wps_deals_cart_order_total_footer' ) ) {
	
	/**
	 * Load Cart Order Total In Footer Template
	 * 
	 * Handles to load cart order total in footer
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_order_total_footer() {
		
		//cart order total template
		wps_deals_get_template( 'checkout/checkout-footer/order-total-button/order-total.php' );
		
	}
}


if( !function_exists( 'wps_deals_cart_place_order_button_footer' ) ) {
	
	/**
	 * Load Cart Place Your Order Button Template
	 * 
	 * Handles to load cart place 
	 * your order button in footer template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_place_order_button_footer() {
		
		//cart place your order button template
		wps_deals_get_template( 'checkout/checkout-footer/order-total-button/place-your-order-button.php' );
		
	}
}

if( !function_exists( 'wps_deals_social_login_facebook' ) ) {
	
	/**
	 * Load Checkout Social Login Facebook Template
	 * 
	 * Handles to load checkout social login 
	 * facebook button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_facebook() {
		
		global $wps_deals_options;	
		
		// check facebook is enable
		if( !empty( $wps_deals_options['enable_facebook'] ) ) {
		
	
			$fbimgurl = isset( $wps_deals_options['fb_icon_url'] ) && !empty( $wps_deals_options['fb_icon_url'] ) 
						? $wps_deals_options['fb_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/facebook.png';
				
			//load facebook button template
			wps_deals_get_template( 'checkout/checkout-content/social/facebook.php', array( 'fbiconurl' => $fbimgurl ) );

			//enqueue Facebook scripts
			wp_enqueue_script( 'facebook' );
			wp_enqueue_script( 'wps-deals-social-fbinit' );

		}
		
	}	
}

if( !function_exists( 'wps_deals_social_login_twitter' ) ) {
	
	/**
	 * Load Checkout Social Login Twitter Template
	 * 
	 * Handles to load social login 
	 * twitter button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_twitter() {
		
		global $wps_deals_options,$wps_deals_social_twitter;	
		
		//social twitter class
		$socialtwitter = $wps_deals_social_twitter;
		
		// check twitter is enable
		if( !empty( $wps_deals_options['enable_twitter'] ) ) {
			
			$twimgurl = isset( $wps_deals_options['tw_icon_url'] ) && !empty( $wps_deals_options['tw_icon_url'] ) 
						? $wps_deals_options['tw_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/twitter.png';
			
			//load twitter button template
			wps_deals_get_template( 'checkout/checkout-content/social/twitter.php', array( 'twiconurl' => $twimgurl ) );
			
			if ( WPS_DEALS_TW_CONSUMER_KEY != '' && WPS_DEALS_TW_CONSUMER_SECRET != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-tw-redirect-url" id="wps_deals_social_tw_redirect_url" name="wps_deals_social_tw_redirect_url" value="<?php echo $socialtwitter->wps_deals_social_get_twitter_auth_url();?>" />
				<?php
			
			}
		
		}
	}	
}

if( !function_exists( 'wps_deals_social_login_googleplus' ) ) {
	
	/**
	 * Load Checkout Social Login Google+ Template
	 * 
	 * Handles to load social login google+ button
	 * template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_googleplus() {
		
		global $wps_deals_options,$wps_deals_social_google;	
		
		//social google class
		$socialgoogle = $wps_deals_social_google;
		
		// check google plus is enable
		if( !empty( $wps_deals_options['enable_gplus'] ) ) {
			
			$gpimgurl = isset( $wps_deals_options['gplus_icon_url'] ) && !empty( $wps_deals_options['gplus_icon_url'] ) 
						? $wps_deals_options['gplus_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/google_plus.png';
			
			//load googleplus button template
			wps_deals_get_template( 'checkout/checkout-content/social/googleplus.php', array( 'gpiconurl' => $gpimgurl ) );
			
			if( WPS_DEALS_GP_CLIENT_ID != '' && WPS_DEALS_GP_CLIENT_SECRET != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-gp-redirect-url" id="wps_deals_social_gp_redirect_url" name="wps_deals_social_gp_redirect_url" value="<?php echo $socialgoogle->wps_deals_social_get_google_auth_url();?>"/>							
				<?php
			}
		} 
	}	
}

if( !function_exists( 'wps_deals_social_login_linkedin' ) ) {
	
	/**
	 * Load Checkout Social Login LinkedIn Template
	 * 
	 * Handles to load social login 
	 * linkedin button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_linkedin() {
		
		global $wps_deals_options,$wps_deals_social_linkedin;	
		
		//social linkedin class
		$sociallinkedin = $wps_deals_social_linkedin;
		
		// check linkedin is enable
		if( !empty( $wps_deals_options['enable_linkedin'] ) ) {
			
			$liimgurl = isset( $wps_deals_options['li_icon_url'] ) && !empty( $wps_deals_options['li_icon_url'] ) 
						? $wps_deals_options['li_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/linkedin.png';
			//load linkedin button template
			wps_deals_get_template( 'checkout/checkout-content/social/linkedin.php', array( 'liiconurl' => $liimgurl ) );
			
			if( WPS_DEALS_LI_APP_ID != '' && WPS_DEALS_LI_APP_SECRET != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-li-redirect-url" id="wps_deals_social_li_redirect_url" name="wps_deals_social_li_redirect_url" value="<?php echo $sociallinkedin->wps_deals_social_linkedin_auth_url();?>"/>						
				<?php
			}
		}
	}	
}

if( !function_exists( 'wps_deals_social_login_yahoo' ) ) {
	
	/**
	 * Load Checkout Social Login Yahoo Template
	 * 
	 * Handles to load social login 
	 * yahoo button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_yahoo() {
		
		global $wps_deals_options,$wps_deals_social_yahoo;	
		
		//social yahoo class
		$socialyahoo = $wps_deals_social_yahoo;
		
		// check yahoo is enable
		if( !empty( $wps_deals_options['enable_yahoo'] ) ) {

			$yhimgurl = isset( $wps_deals_options['yh_icon_url'] ) && !empty( $wps_deals_options['yh_icon_url'] ) 
						? $wps_deals_options['yh_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/yahoo.png';
			
			//load yahoo button template
			wps_deals_get_template( 'checkout/checkout-content/social/yahoo.php', array( 'yhiconurl' => $yhimgurl ) );
			
			if( WPS_DEALS_YH_CONSUMER_KEY != '' && WPS_DEALS_YH_CONSUMER_SECRET != '' && WPS_DEALS_YH_APP_ID != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-yh-redirect-url" id="wps_deals_social_yh_redirect_url" name="wps_deals_social_yh_redirect_url" value="<?php echo $socialyahoo->wps_deals_social_get_yahoo_auth_url();?>"/>						
				<?php
			}
		}
	}	
}

if( !function_exists( 'wps_deals_social_login_foursquare' ) ) {
	
	/**
	 * Load Checkout Social Login Yahoo Template
	 * 
	 * Handles to load social login 
	 * foursquare button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_foursquare() {
		
		global $wps_deals_options,$wps_deals_social_foursquare;	
		
		//social foursquare class
		$socialfoursquare = $wps_deals_social_foursquare;
		
		// check foursquare is enable
		if( !empty( $wps_deals_options['enable_foursquare'] ) ) {

			$fsimgurl = isset( $wps_deals_options['fs_icon_url'] ) && !empty( $wps_deals_options['fs_icon_url'] ) 
						? $wps_deals_options['fs_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/foursquare.png';
			
			//load foursquare button template
			wps_deals_get_template( 'checkout/checkout-content/social/foursquare.php', array( 'fsiconurl' => $fsimgurl ) );
			
			if( WPS_DEALS_FS_CLIENT_ID != '' && WPS_DEALS_FS_CLIENT_SECRET != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-fs-redirect-url" id="wps_deals_social_fs_redirect_url" name="wps_deals_social_fs_redirect_url" value="<?php echo $socialfoursquare->wps_deals_social_get_foursquare_auth_url();?>"/>						
				<?php
			}
		}
	}	
}
if( !function_exists( 'wps_deals_social_login_windowslive' ) ) {
	
	/**
	 * Load Checkout Social Login Windows Live Template
	 * 
	 * Handles to load checkout social login 
	 * facebook button template
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_login_windowslive() {
		
		global $wps_deals_options,$wps_deals_social_windowslive;	
		
		//windows live class
		$socialwindowslive = $wps_deals_social_windowslive;
		
		
		// check windowslive is enable
		if( !empty( $wps_deals_options['enable_windowslive'] ) ) {
		
	
			$wlimgurl = isset( $wps_deals_options['wl_icon_url'] ) && !empty( $wps_deals_options['wl_icon_url'] ) 
						? $wps_deals_options['wl_icon_url'] : WPS_DEALS_SOCIAL_URL.'/images/windowslive.png';
				
			//load windowslive button template
			wps_deals_get_template( 'checkout/checkout-content/social/windowslive.php', array( 'wliconurl' => $wlimgurl ) );

			if( WPS_DEALS_WL_CLIENT_ID != '' && WPS_DEALS_WL_CLIENT_SECRET != '' ) {
				
				?>
					<input type="hidden" class="wps-deals-social-wl-redirect-url" id="wps_deals_social_wl_redirect_url" name="wps_deals_social_wl_redirect_url" value="<?php echo $socialwindowslive->wps_deals_social_get_windowslive_auth_url();?>"/>						
				<?php
			}
			
		}
		
	}
}
if( !function_exists( 'wps_deals_localize_map_script' ) ) {
	
	/**
	 * Add Localize Script for Individual Post Data
	 * 
	 * Handles to add localize script for individual post data
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_localize_map_script() {
		
		global $post;
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		// get the value for the google map address from the post meta box
		$gmapaddress = get_post_meta( $post->ID, $prefix.'address', true );
		$gmapaddress = isset($gmapaddress) && !empty($gmapaddress) ? $gmapaddress : '';
		
		// get the value for the google map popup content from the post meta box
		$gmappopupcontent = get_post_meta( $post->ID, $prefix.'gmaps_popup_content', true );
		$gmappopupcontent = isset($gmappopupcontent) && !empty($gmappopupcontent) ? $gmappopupcontent : '';
		
		// get the value for the google map popup max width from the post meta box
		$gmapwidth = get_post_meta( $post->ID, $prefix.'gmap_popup_width', true );
		
		$popupmaxwidth = isset($gmapwidth) && !empty($gmapwidth) ? $gmapwidth : '220';
		
		$address = str_replace("'", "&prime;", $gmapaddress);
		
		if (!empty($gmappopupcontent)) {
			$popupcontent =  '<div class="wps-deals-gmap-popup-content">'.$gmappopupcontent.'</div>';
		} else {
			$popupcontent = $address;
		}
		
		wp_localize_script( 'wps-deals-map-script', 'Wps_Deals_Map', array( 
																				'URL' 			=>	WPS_DEALS_URL,
																			   	'address'		=>	$address,
																			   	'popupcontent' 	=> 	$popupcontent,
																			  	'popupmaxwidth'	=>	$popupmaxwidth
																		  	) );
	}
}
/*************************** My Account Page Template ******************************/
/**
 * My Account Template Functions
 * 
 * Handles to show my account page content
 * 
 * @package Social Deals Engine
 * @since 1.0.0
 **/
if( !function_exists( 'wps_deals_my_account_address_success_msg' ) ) {
	/**
	 * My Account Address Success Message
	 * 
	 * Handles to show my account page address success message
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_address_success_msg() {
		
		global $wps_deals_message;
		
		$success_message = '';
		if ( $wps_deals_message->size( 'my_account_msg' ) > 0 ) {
			// if we need to display the error message, we will do it here
			$success_message = $wps_deals_message->output( 'my_account_msg' );
		}
	
		//load my account page address success message template
		wps_deals_get_template( 'my-account/address-success-message.php', array( 'success_message' => $success_message ) );
		
	}
}
if( !function_exists( 'wps_deals_my_account_top_content' ) ) {
	/**
	 * My Account Top Content
	 * 
	 * Handles to show my account page top content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_top_content() {
		
		global $current_user, $wps_deals_options;
		
		$change_password_page = isset( $wps_deals_options['change_password'] ) && !empty( $wps_deals_options['change_password'] ) ? $wps_deals_options['change_password'] : ''; 
		
		$changepasswordlink = get_permalink( $change_password_page );
		
		//load my account page top content template
		wps_deals_get_template( 'my-account/top-content.php', array( 'username' => $current_user->display_name, 'changepasswordlink' => $changepasswordlink ) );
		
	}
}
if( !function_exists( 'wps_deals_my_account_available_downloads' ) ) {
	/**
	 * My Account Available Downloads
	 * 
	 * Handles to show my account page available downloads
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_available_downloads() {
		
		global $current_user, $wps_deals_model;
		
		//model class
		$model = $wps_deals_model;
		
		///get recent 5 orders
		$orders = $model->wps_deals_get_sales( array( 'author' => $current_user->ID, 'posts_per_page' => '5' ) );
		
		//if orders are not empty then show recent orders
		if( !empty( $orders ) ) {
			
			$downloadfiles = array();
				
			foreach ( $orders as $key => $order ) {
				
				//get ordered files
				$orderedfiles = $model->wps_deals_get_ordered_file_list( $order['ID'] );
				
				// get the value for the order details from the post meta box
				$order_details = $model->wps_deals_get_post_meta_ordered( $order['ID'] );
				
				//payment status value
				$payment_status_val = $model->wps_deals_get_ordered_payment_status( $order['ID'], true );

				foreach ( $order_details['deals_details'] as $product ) {
					
					//check payment status is completed and order download files should not empty
					if( $payment_status_val == '1' 
						&& !empty( $orderedfiles[$product['deal_id']] ) && is_array( $orderedfiles[$product['deal_id']] ) ) {
						
						foreach ( $orderedfiles[$product['deal_id']] as $key => $file ) {
							
							//get file name from deal id and file key
							$filename = $model->wps_deals_get_download_file_name( $product['deal_id'], $key );
							
							if( !empty( $filename ) ) { // check file name is exist or not
								
								//make file display to user
								$filename = sprintf( __( '%s - %s','wpsdeals' ), get_the_title( $product['deal_id'] ), $filename );
								$downloadfiles[] = '<a href="'.$file.'" target="_blank">'.$filename.'</a>';
								
							}
						}
					}
				}
				
			} //orders loop end
			
			if( !empty( $downloadfiles ) ) {
				
				//load my account page available downloads template
				wps_deals_get_template( 'my-account/available-downloads.php', array( 'downloadfiles' => $downloadfiles )  );
			}
		}
	}
}
if( !function_exists( 'wps_deals_my_account_recent_orders' ) ) {
	/**
	 * My Account Recent Orders
	 * 
	 * Handles to show my account page top content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_recent_orders() {
		
		global $current_user, $wps_deals_model;
		//model class
		$model = $wps_deals_model;
		
		///get recent 5 orders
		$orders = $model->wps_deals_get_sales( array( 'author' => $current_user->ID, 'posts_per_page' => '5' ) );
		
		//if orders are not empty then show recent orders
		if( !empty( $orders ) ) {
			
			//collect order data to single array
			$orderdata = array();
			
			$downloadfiles = array();
				
			foreach ( $orders as $key => $order ) {
				
				//order ID
				$orderdata[$key]['order_id']		=	$order['ID'];
				//ordered date
				$orderdata[$key]['order_date']		=	$model->wps_deals_get_date_format( $order['post_date'] );
				//payment status
				$orderdata[$key]['payment_status']	=	$model->wps_deals_get_ordered_payment_status( $order['ID'] );
				//ordered deal details
				$orderdetails						=	$model->wps_deals_get_post_meta_ordered( $order['ID'] );
				//order total
				$orderdata[$key]['order_total']		=	$orderdetails['display_order_total'];
				//order deal count
				$orderdata[$key]['deal_count']		=	count( $orderdetails['deals_details'] );
								
			} //orders loop end
			
			//load my account page recent orders template
			wps_deals_get_template( 'my-account/recent-orders.php', array( 'orderdata' => $orderdata )  );
		}
		
	}
}
if( !function_exists( 'wps_deals_my_account_addresses' ) ) {
	/**
	 * My Account My Addresses
	 * 
	 * Handles to show my account page my addresses
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_addresses( $currentpage = '' ) {
		
		global $wps_deals_options;
		
		$billingargs = array();
		$my_account_addresses = array();
		
		//check billing is enable from settings page
		if( isset( $wps_deals_options['enable_billing'] ) && !empty( $wps_deals_options['enable_billing'] ) ) {
		
			$my_account_addresses['billing'] = __( 'Billing Details', 'wpsdeals' );
										
		} //end if to check enable billing or not
		
		$my_account_addresses = apply_filters( 'wps_deals_my_account_addresses', $my_account_addresses );
		
		$address_title = '';
		if( !empty( $my_account_addresses ) && count( $my_account_addresses ) > 1 ) {
			$address_title = __( 'My Addresses', 'wpsdeals' );
		} else if( !empty( $my_account_addresses ) ) {
			$address_title = __( 'My Address', 'wpsdeals' );
		}
		$billingargs['address_title'] =	$address_title;
		$billingargs['my_account_addresses'] = $my_account_addresses;
		
		if( !empty( $currentpage ) && $currentpage == 'edit_address' ) { // Check current page is edit address page
			$billingargs['emptymessage'] = __( 'This feature is not available.', 'wpsdeals' );
		}
		//load my account page my addresses template
		wps_deals_get_template( 'my-account/my-addresses.php', $billingargs );
		
	}
}
if( !function_exists( 'wps_deals_my_account_billing_address' ) ) {
	/**
	 * My Account Billing Address
	 * 
	 * Handles to show my account billing address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_billing_address( $key, $title ) {
			
		global $current_user, $wps_deals_options;
		
		//check billing is enable from settings page
		if( isset( $wps_deals_options['enable_billing'] ) && !empty( $wps_deals_options['enable_billing'] ) ) {
		
			$prefix = WPS_DEALS_META_PREFIX;
			
			//get user billing data saved
			$userbillingdata	=	get_user_meta( $current_user->ID, $prefix.'billing_details', true );
			
			//get user country from saved
			$usercountry		=	isset( $userbillingdata['country'] ) ? wps_deals_get_country_name( $userbillingdata['country'] ) : '';
			//get user state or county
			$userstate			=	isset( $userbillingdata['state'] ) ? wps_deals_get_state_name ( $userbillingdata['state'], $userbillingdata['country'] ) : '';
			//get user company name
			$usercompany		=	isset( $userbillingdata['company'] ) ? $userbillingdata['company'] : '';
			//get user address1 
			$useraddress1		=	isset( $userbillingdata['address1'] ) ? $userbillingdata['address1'] : '';
			//get user address2 
			$useraddress2		=	isset( $userbillingdata['address2'] ) ? $userbillingdata['address2'] : '';
			//get user city or town
			$usercity			=	isset( $userbillingdata['city'] ) ? $userbillingdata['city'] : '';
			//get user post code
			$userpostcode		=	isset( $userbillingdata['postcode'] ) ? $userbillingdata['postcode'] : '';
			//get user phone
			$userphone			=	isset( $userbillingdata['phone'] ) ? $userbillingdata['phone'] : '';
			
			//data pased to template
			$billingargs = array( 
									'billingkey'		=>	$key,
									'billingtitle'		=>	$title,
									'billingcountry'	=>	$usercountry,
									'billingstate'		=>	$userstate,
									'billingcompany'	=>	$usercompany,
									'billingaddress1'	=>	$useraddress1,
									'billingaddress2'	=>	$useraddress2,
									'billingcity'		=>	$usercity,
									'billingpostcode'	=>	$userpostcode,
									'billingphone'		=>	$userphone,
									'billingalldata'	=>	$userbillingdata
								);
			
			//billing details template
			do_action( 'wps_deals_display_address', $billingargs );
			
		} //end if to check enable billing or not
		
	}
}
if( !function_exists( 'wps_deals_my_account_login_content' ) ) {
	/**
	 * My Account Login Content
	 * 
	 * Handles to show my account login content
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_my_account_login_content() {
		
		global $wps_deals_options;
		
		$lost_password_page = isset( $wps_deals_options['lost_password'] ) && !empty( $wps_deals_options['lost_password'] ) ? $wps_deals_options['lost_password'] : ''; 
		
		$lostpasswordlink = get_permalink( $lost_password_page );
		
		//load login template
		wps_deals_get_template( 'my-account/login.php', array( 'lostpasswordlink' => $lostpasswordlink ) );
	}
}	
if( !function_exists( 'wps_deals_display_address' ) ) {
	/**
	 * Display Billing Address
	 * 
	 * Handles to show billing address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_display_address( $billingargs ) {
		
		global $wps_deals_options;
		
		$address_key = isset( $billingargs['billingkey'] ) ? $billingargs['billingkey'] : '';
		
		$editlink = '';
		//Check Edit Address Page is not empty from general setting
		if( isset( $wps_deals_options['edit_adderess'] ) && !empty( $wps_deals_options['edit_adderess'] ) ) {
			$editlink = add_query_arg( array( 'wps_deals_address' => $address_key ), get_permalink( $wps_deals_options['edit_adderess'] ) );
		}
		$billingargs['editlink'] = $editlink;
		
		//load billing addresses template
		wps_deals_get_template( 'my-account/billing-address.php', $billingargs );
	}
}
if( !function_exists( 'wps_deals_edit_address_content' ) ) {
	/**
	 * Edit Billing Address
	 * 
	 * Handles to edit billing address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_edit_address_content() {
		
		if( isset( $_GET['wps_deals_address'] ) && !empty( $_GET['wps_deals_address'] ) ) {
		
			do_action( 'wps_deals_edit_' . $_GET['wps_deals_address'] . '_address' );
			
		} else {
			
			do_action( 'wps_deals_edit_address_page', 'edit_address' );
		}
	}
}
if( !function_exists( 'wps_deals_edit_billing_address' ) ) {
	/**
	 * Edit Billing Address
	 * 
	 * Handles to edit billing address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_edit_billing_address() {
		
		//load edit billing addresses template
		wps_deals_get_template( 'my-account/edit-billing-address.php' );
	}
}
if( !function_exists( 'wps_deals_change_password_content' ) ) {
	/**
	 * Change Address Page
	 * 
	 * Handles to show change address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_change_password_content() {
		
		//load change password template
		wps_deals_get_template( 'my-account/change-password.php' );
	}
}
if( !function_exists( 'wps_deals_lost_password_content' ) ) {
	/**
	 * Lost Address Page
	 * 
	 * Handles to show lost address
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_lost_password_content() {
		
		global $wpdb, $wps_deals_message;
		
		$password_form = '';
		$error 	= false;
		
		if( isset( $_GET['wps_deal_user_key'] ) && !empty( $_GET['wps_deal_user_key'] )
			&& isset( $_GET['wps_deals_user_name'] ) && !empty( $_GET['wps_deals_user_name'] ) ) {
			
			$key 	= $_GET['wps_deal_user_key'];
			$login 	= $_GET['wps_deals_user_name'];
			
			$key = preg_replace( '/[^a-z0-9]/i', '', $key );
	
			if ( empty( $key ) || ! is_string( $key ) ) {
				
				$wps_deals_message->add( 'lostpassword', __( '<span><strong>ERROR : </strong>Invalid key.', 'wpsdeals' ), 'error' );
				$error = true;
			}
	
			if ( empty( $login ) || ! is_string( $login ) ) {
				
				$wps_deals_message->add( 'lostpassword', __( '<span><strong>ERROR : </strong>Invalid key.', 'wpsdeals' ), 'error' );
				$error = true;
			}
	
			$user = $wpdb->get_row( "SELECT * FROM $wpdb->users WHERE user_activation_key = '{$key}' AND user_login = '{$login}'" );
	 
			if ( empty( $user ) ) {
				
				$wps_deals_message->add( 'lostpassword', __( '<span><strong>ERROR : </strong>Invalid key.', 'wpsdeals' ), 'error' );
				$error = true;
			}
			
			if( !$error ) {
				$password_form = 'reset';
			}
			
		}
		
		if( !empty( $password_form ) ) {
			
			$user_args = array(
									'wps_deals_reset_key' 	=> $key,
									'wps_deals_reset_login' => $login,
								);
			
			//load change password template
			wps_deals_get_template( 'my-account/change-password.php', $user_args );
			
		} else {
			//load lost password template
			wps_deals_get_template( 'my-account/lost-password.php' );
		}
	}
}
if ( ! function_exists( 'wps_deals_get_sidebar' ) ) {

	/**
	 * Sidebar Template
	 * 
	 * Handles to show sidebar tempate
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 **/
	function wps_deals_get_sidebar() {
		
		//load sidebar template
		wps_deals_get_template( 'sidebar/sidebar.php' );
	}
}

?>