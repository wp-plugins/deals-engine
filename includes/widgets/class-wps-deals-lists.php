<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'wps_deals_lists_widget' );

/**
 * Register the Reviews Widget
 *
 * @package Social Deals Engine
 * @since 1.0.
 */
function wps_deals_lists_widget() {
	register_widget( 'Wps_Deals_Lists' );
}

/**
 * Wps_Fbre_Reviews Widget Class.
 *
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update for displaying submitted reviews.
 *
 * @package Social Deals Engine
 * @since 1.0.
 */
class Wps_Deals_Lists extends WP_Widget {

	var $model,$render,$currency;

	/**
	 * Widget setup.
	 */
	function Wps_Deals_Lists() {
	
		global $wps_deals_model,$wps_deals_render,$wps_deals_currency,$wps_deals_price;
		
		$this->model = $wps_deals_model;
		$this->render = $wps_deals_render;
		$this->currency = $wps_deals_currency;
		$this->price = $wps_deals_price;
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wps-deals-lists', 'description' => __( 'A social deals widget, which lets you display deals to purchase by users.', 'wpsdeals' ) );

		/* Create the widget. */
		$this->WP_Widget( 'wps-deals-lists', __( 'Deals Engine - Deals', 'wpsdeals' ), $widget_ops );
	
	}
	
	/**
	 * Outputs the content of the widget
	 */
	function widget( $args, $instance ) {
	
		global $wpdb,$post,$wps_deals_options;
		
		extract( $args );
		
		$prefix = WPS_DEALS_META_PREFIX;
		
		//get the value for deals listing page
		$dealspage = $wps_deals_options['deals_main_page'];
		
		//counter timer script
		wp_enqueue_script( 'wps-deals-countdown-timer-scripts' );
		
		//current date and time
		$today = wps_deals_current_date('Y-m-d H:i:s');
		
		$title 			= apply_filters( 'widget_title', $instance['title'] );
		$limit 			= $instance['limit'];
		$disable_price 	= $instance['disable_price'];
		$disable_timer 	= $instance['disable_timer'];
		
		/* all active deals listing start */
		$dealsmetaquery = array( 
								
								array(		
											'key' => $prefix.'start_date',
											'value' => $today,
											'compare' => '<=',
											'type' => 'STRING'
									),
								array(
											'key' => $prefix.'end_date',
											'value' => $today,
											'compare' => '>=',
											'type' => 'STRING'
									)
							 );
		$this_post = $post->ID;
		$argswidget = array( 'post_type' => WPS_DEALS_POST_TYPE, 'posts_per_page' => $limit, 'post__not_in' => array( $this_post ), 'meta_query' => $dealsmetaquery );
		
		$loop = null;
		$loop = new WP_Query();
		$loop->query( $argswidget );
		
		$html = '';
		
		if( $loop->have_posts() ) {
        	
        	echo $before_widget;
        
        	$html .= '<div class="wps-deals-widget-content">';
        	
    	   	if ( $title )
				
				$alldeals = '<div class="wps-deals-widget-after-title"><a href="'.get_permalink($dealspage).'">'.__('See All','wpsdeals').'</a></div>';
				
	            echo $before_title . $title . $alldeals . $after_title;
        	
        	while ( $loop->have_posts() ) : $loop->the_post();
		
				if($post->post_status == 'publish') { //check post type is published
	        	
					// get the value of image url from the post meta box
					//$imgurl = get_post_meta($post->ID,$prefix.'main_image',true);
					
					// get the value for the deal main image from the post meta box
					$imgurl = get_post_meta( $post->ID, $prefix . 'main_image', true );
					
					//home deal image
					$imgsrc = isset( $imgurl['src'] ) && !empty( $imgurl['src'] ) ? $imgurl['src'] : WPS_DEALS_URL.'includes/images/deals-no-image-big.jpg';
					
					// get the value for deal price from the post meta box
					$normalprice = get_post_meta($post->ID,$prefix.'normal_price',true);
					
					// get the value for deal sale price from the post meta box
					$saleprice = get_post_meta($post->ID,$prefix.'sale_price',true);
					
					//get the value for start date & time of deals from the post meta box
					$startdate = get_post_meta($post->ID,$prefix.'start_date',true);
					
					//get the value for end date & time of deals from the post meta box
					$enddate = get_post_meta($post->ID,$prefix.'end_date',true);
					
					//calculate saving price
					$yousave = $this->price->wps_deals_get_savingprice($post->ID);
					
					//get product price
					$price = $this->price->wps_deals_get_price($post->ID);
					
					//product price 
					$productprice = $this->price->get_display_price( $price, $post->ID );
					
					//discount 
					$discount = $this->price->wps_deals_get_discount($post->ID);
					
			        $html .= '<div class="wps-deals-widget-parent">';
			        
			        $html .= ' 		<div class="wps-deals-sub-content">';
										
			        
					$html .= '			<div class="wps-deals-img-flag-small widget-flag">'.$productprice.'</div>
										<div align="center" class="wps-deals-widget-img">
											<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">
												<img src="'.$imgsrc.'" alt="'.__('Deal Image','wpsdeals').'" />
											</a>
										</div>';
					
					//check price is disable or not
					if( empty( $disable_price ) ) {
					
						$html .= '		<div class="wps-deals-widget-price-box">
											<div class="wps-deals-widget-price">
												<span>'.__('Deal Value','wpsdeals').'</span>
												<div>'.$this->price->get_display_price( $normalprice, $post->ID ).'</div>
											</div>';
												
						$html .= '			<div class="wps-deals-widget-price-middle">
												<span>'.__('Discount','wpsdeals').'</span>
												<div>'.$discount.'</div>
											</div>';
												
						$html .= '			<div class="wps-deals-widget-price-last">
												<span>'.__('You Save','wpsdeals').'</span>
												<div>'.$yousave.'</div>
											</div>
										</div>';
					}
					$html .= '		</div><!--.wps-deals-sub-content-->';

					$html .= '		<div class="wps-deals-contentdeal-footer footer-widget">';

					//check timer is disable or not
					if( empty( $disable_timer ) ) {
					
						$endyear		=	date( 'Y', strtotime( $enddate ) );
						$endmonth		=	date( 'm', strtotime( $enddate ) );
						$endday			=	date( 'd', strtotime( $enddate ) );
						$endhours		=	date( 'H', strtotime( $enddate ) );
						$endminute		=	date( 'i', strtotime( $enddate ) );
						$endseconds		=	date( 's', strtotime( $enddate ) );
						
						$html .= '		<div class="wps-deals-timing wps-deals-end-timer" 
											timer-year="'.$endyear.'"
											timer-month="'.$endmonth.'"
											timer-day="'.$endday.'"
											timer-hours="'.$endhours.'"
											timer-minute="'.$endminute.'"
											timer-second="'.$endseconds.'">
											<span class="timer-icon-small"></span>
										</div>';
					
					}
					$html .= '			<div class="wps-deals-btn-small"><a href="'.get_permalink($post->ID).'">'.__('See Deal','wpsdeals').'</a></div>
									</div>';
					
					 $html .= '</div><!--.wps-deals-parent-->';
				}
				
			endwhile;
			
			//end container
        	$html .= '</div><!--.wps-deals-widget-content-->';
        
			echo $html;
			echo $after_widget;
        }
	
		wp_reset_query();  
    }
	
	/**
	 * Updates the widget control options for the particular instance of the widget
	 */
	function update( $new_instance, $old_instance ) {
	
        $instance = $old_instance;
		
		/* Set the instance to the new instance. */
		$instance = $new_instance;
		
		/* Input fields */
        $instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['limit'] 			= strip_tags( $new_instance['limit'] );
		$instance['disable_price'] 	= strip_tags( $new_instance['disable_price'] );
		$instance['disable_timer'] 	= strip_tags( $new_instance['disable_timer'] );
		
        return $instance;
		
    }
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
	
		$defaults = array( 'title' => __('More Great Deals', 'wpsdeals'), 'limit' => '3', 'disable_price' => '', 'disable_timer' => '');
		
        $instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpsdeals'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'wpsdeals'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $instance['limit']; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'disable_price' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'disable_price' ); ?>" value="1" <?php checked( $instance['disable_price'],'1', true ); ?> />
			<label for="<?php echo $this->get_field_id( 'disable_price' ); ?>"><?php _e( 'Disable Price Box', 'wpsdeals'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'disable_timer' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'disable_timer' ); ?>" value="1" <?php checked( $instance['disable_timer'], '1', true ); ?> />
			<label for="<?php echo $this->get_field_id( 'disable_timer' ); ?>"><?php _e( 'Disable Timer', 'wpsdeals'); ?></label>
		</p>

		<?php
	}
}