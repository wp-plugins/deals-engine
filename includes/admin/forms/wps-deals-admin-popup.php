<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortocde UI
 *
 * This is the code for the pop up editor, which shows up when an user clicks
 * on the deals engine icon within the WordPress editor.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 * 
 **/

?>

<div class="wps-deals-popup-content">

	<div class="wps-deals-header">
		<div class="wps-deals-header-title"><?php _e( 'Add A Social Deals Engine Shortcode', 'wpsdeals' );?></div>
		<div class="wps-deals-popup-close"><a href="javascript:void(0);" class="wps-deals-close-button"><img src="<?php echo WPS_DEALS_URL;?>includes/images/tb-close.png"></a></div>
	</div>
	
	<div class="wps-deals-popup">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label><?php _e( 'Select A Shortcode', 'wpsdeals' );?></label>		
					</th>
					<td>
						<select id="wps_deals_shortcodes">				
							<option value=""><?php _e( '--Select A Shortcode--', 'wpsdeals' );?></option>
							<option value="wps_deals"><?php _e( 'Deals List', 'wpsdeals' );?></option>
							<option value="wps_deals_by_category"><?php _e( 'Deals By Category', 'wpsdeals' );?></option>
							<option value="wps_deals_checkout"><?php _e( 'Checkout', 'wpsdeals' );?></option>
							<option value="wps_deals_order_complete"><?php _e( 'Order Complete', 'wpsdeals' );?></option>
							<option value="wps_deals_order_cancel"><?php _e( 'Order Cancel', 'wpsdeals' );?></option>
							<option value="wps_deals_orders"><?php _e( 'Deals Orders', 'wpsdeals' );?></option>
							<option value="wps_deals_social_login"><?php _e( 'Social Login', 'wpsdeals' );?></option>
							<?php
									//do action for adding shortcode option for backend popup
									do_action( 'wps_deals_admin_shortcodes_option_after' );
							?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="wps_deals_by_category_options" class="wps-deals-shortcodes-options">
		
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'Select Deals Category:', 'wpsdeals' );?></label>		
						</th>
						<td>
							<?php 
									$catargs = array(
														'type'                     => WPS_DEALS_POST_TYPE,
														'child_of'                 => '0',
														'parent'                   => '',
														'orderby'                  => 'name',
														'order'                    => 'DESC',
														'hide_empty'               => '1',
														'hierarchical'             => '1',
														'exclude'                  => '',
														'include'                  => '',
														'number'                   => '',
														'taxonomy'                 => WPS_DEALS_POST_TAXONOMY,
														'pad_counts'               => false 
													);
									$dealscategories = get_categories( $catargs );
							?>
							<select id="wps_deals_category_id">
									<option value=""><?php _e( '--Select Category--','wpsdeals' );?></option>
								<?php
										foreach ( $dealscategories as $cat ) { ?>
											<option value="<?php echo $cat->slug;?>"><?php echo $cat->name;?></option>
								<?php	}
								?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			
		</div><!--wps_deals_by_category_options-->
		
		<div id="wps_deals_social_login_options" class="wps-deals-shortcodes-options">
		
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="wps_deals_title"><?php _e( 'Social Login Title:', 'wpsdeals' );?></label>		
						</th>
						<td>
							<input type="text" id="wps_deals_title" class="regular-text" value="<?php _e( 'Prefer to Login with Social Media', 'wpsdeals' );?>" /><br/>
							<span class="description"><?php _e( 'Enter a social login title.', 'wpsdeals' );?></span>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="wps_deals_redirect_url"><?php _e( 'Redirect URL:', 'wpsdeals' );?></label>		
						</th>
						<td>
							<input type="text" id="wps_deals_redirect_url" class="regular-text" value="" /><br/>
							<span class="description"><?php _e( 'Enter a redirect URL for users after they login with social media. The URL must start with http://', 'wpsdeals' );?></span>
						</td>
					</tr>
				</tbody>
			</table>
			
		</div><!--wps_deals_social_login_options-->
		
		<?php
				//do action for adding shortcode option for backend popup
				do_action( 'wps_deals_admin_shortcodes_option_content_after' );
		?>
		
		<div id="wps_deals_insert_container" >
			<input type="button" class="button-secondary" id="wps_deals_insert_shortcode" value="<?php _e( 'Insert Shortcode', 'wpsdeals' ); ?>">
		</div>
		
	</div><!--.wps-deals-popup-->
	
</div><!--.wps-deals-popup-content-->
<div class="wps-deals-popup-overlay"></div>