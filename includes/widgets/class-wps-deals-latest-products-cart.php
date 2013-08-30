<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'wps_deals_latest_prodcuts_cart_widget' );

/**
 * Register the Reviews Widget
 *
 * @package Social Deals Engine
 * @since 1.0.
 */
function wps_deals_latest_prodcuts_cart_widget() {
	register_widget( 'Wps_Deals_Latest_Products_Cart_Lists' );
}

/**
 * Wps_Fbre_Reviews Widget Class.
 *
 * This class handles everything that needs to be handled with the widget:
 * to show latest products added in cart
 *
 * @package Social Deals Engine
 * @since 1.0.
 */
class Wps_Deals_Latest_Products_Cart_Lists extends WP_Widget {

	var $render;

	/**
	 * Widget setup.
	 */
	function Wps_Deals_Latest_Products_Cart_Lists() {
	
		global $wps_deals_render;
		
		$this->render = $wps_deals_render;
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wps-deals-latest-products-cart', 'description' => __( 'A social deals widget, which lets you display deals that added to cart by users.', 'wpsdeals' ) );

		/* Create the widget. */
		$this->WP_Widget( 'wps-deals-latest-products-cart', __( 'Deals Engine - Cart', 'wpsdeals' ), $widget_ops );
	
	}
	
	/**
	 * Outputs the content of the widget
	 */
	function widget( $args, $instance ) {
	
		global $wpdb,$post,$wps_deals_options;
		
		extract( $args );
		
		$html = '';
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		//limit to show orders
		//$limit = $instance['limit'];
		
		if($post->ID != $wps_deals_options['payment_checkout_page'])  { //if current page is checout page then dont show cart widget
		
			echo $before_widget;
			
			if ( $title )
				echo $before_title . $title . $after_title;
			
				$html .= '<div class="wps-deals-latest-widget">';
				
				$html .= $this->render->wps_deals_cart_widget_content();
			
				$html .= '</div><!--.wps-deals-latest-widget-->';
			
			echo $html;
	    	echo $after_widget;
		}
	    
    }
	
	/**
	 * Updates the widget control options for the particular instance of the widget
	 */
	function update( $new_instance, $old_instance ) {
	
        $instance = $old_instance;
		
		/* Set the instance to the new instance. */
		$instance = $new_instance;
		
		/* Input fields */
        $instance['title'] = strip_tags( $new_instance['title'] ); 
		$instance['limit'] = strip_tags( $new_instance['limit'] ); 
		
        return $instance;
		
    }
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
	
		$defaults = array( 'title' => __('Deals In Your Cart', 'wpsdeals'));
		
        $instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpsdeals'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<?php /*<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'wpsdeals'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $instance['limit']; ?>" />
		</p>*/?>

		<?php
	}
}