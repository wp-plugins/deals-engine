<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page General Tab
 *
 * The code for the plugins settings page general tab
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
	//get all pages					
	$get_pages = get_pages(); 
?>
<!-- beginning of the general settings meta box -->
<div id="wps-deals-general" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="general" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsdeals' ); ?>"><br /></div>

					<!-- general settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'General Settings', 'wpsdeals' ); ?></span>
					</h3>

					<div class="inside">
					
					<table class="form-table">
						<tbody>
							<!-- General Settings Start -->
							<tr>
								<td colspan="2" valign="top" scope="row">
									<span class="wps-deals-settings-sep-first"><?php _e( 'General Settings', 'wpsdeals' ); ?></span>
									<input type="submit" id="wps-deals-settings-submit" name="wps-deals-settings-submit" class="button-primary" value="<?php _e('Save Changes','wpsdeals');?>" />
								</td>
							</tr>
							<?php 
									//adding something before general settings	
									do_action('wps_deals_add_general_settings_before');
							?>
							<tr>
								<th scope="row">
									<label for="wps_deals_options[del_all_options]"><?php _e( 'Delete Options:', 'wpsdeals' ); ?></label>
								</th>
								<td>
									<input type="checkbox" name="wps_deals_options[del_all_options]" id="wps_deals_options[del_all_options]" value="1" <?php if ( isset( $wps_deals_options['del_all_options'] ) ) { checked( '1', $wps_deals_options['del_all_options'] ); } ?> /><br />
									<span class="description"><?php _e( 'Check this box if you want to delete all options and tables from the database which have been created by the plugin. They will then only be deleted, when you deactivate the plugin.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[enable_testmode]"><?php _e('Enable Test Mode:', 'wpsdeals');?></label>
								</th>
								<td>
									<input type="checkbox" id="wps_deals_options[enable_testmode]" name="wps_deals_options[enable_testmode]" value="1" <?php if(isset($wps_deals_options['enable_testmode'])) { checked('1',$wps_deals_options['enable_testmode']); }?>/><br />
									<span class="description"><?php _e( 'While in test mode no live transactions are processed. To fully use the test mode, you must have a sandbox (test) account for the payment gateway you are testing.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[caching]"><?php _e('Caching:', 'wpsdeals');?></label>
								</th>
								<td>
									<input type="checkbox" id="wps_deals_options[caching]" name="wps_deals_options[caching]" value="1" <?php if( isset( $wps_deals_options['caching'] ) ) { checked('1',$wps_deals_options['caching']); }?>/><br />
									<span class="description"><?php _e( 'Check this box, if you use a caching plugin. For more information visit  our <a href="http://wpsocial.com/knowledgebase/" target="_blank">Knowledge Base</a>', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[disable_twitter_bootstrap]"><?php _e('Disable Twitter Bootstrap:', 'wpsdeals');?></label>
								</th>
								<td>
									<input type="checkbox" id="wps_deals_options[disable_twitter_bootstrap]" name="wps_deals_options[disable_twitter_bootstrap]" value="1" <?php if(isset($wps_deals_options['disable_twitter_bootstrap'])) { checked('1',$wps_deals_options['disable_twitter_bootstrap']); }?>/><br />
									<span class="description"><?php _e( 'Check this box, if your theme does already include the Twitter Bootstrap framework.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[deals_size]"><?php _e( 'Size:', 'wpsdeals');?></label>
								</th>
								<td>
									<select id="wps_deals_options[deals_size]" name="wps_deals_options[deals_size]">
										<option value="small" <?php selected('small',$wps_deals_options['deals_size'],true);?>><?php _e('Small','wpsdeals');?></option>		
										<option value="medium" <?php selected('medium',$wps_deals_options['deals_size'],true);?>><?php _e('Medium','wpsdeals');?></option>
										<option value="large" <?php selected('large',$wps_deals_options['deals_size'],true);?>><?php _e('Large','wpsdeals');?></option>
									</select><br />
									<span class="description"><?php _e( 'Choose the size for the deals. This will then use different sizes for the fonts so that they fit in to your theme.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[disable_more_deals]"><?php _e('Disable More Deals:', 'wpsdeals');?></label>
								</th>
								<td>
									<input type="checkbox" id="wps_deals_options[disable_more_deals]" name="wps_deals_options[disable_more_deals]" value="1" <?php if(isset($wps_deals_options['disable_more_deals'])) { checked('1',$wps_deals_options['disable_more_deals']); }?>/><br />
									<span class="description"><?php _e( 'Check this box, if you don\'t want to display the Active, Ending Soon and Upcomming Deals on your deals page.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[ending_deals_in]"><?php _e( 'Ending Deals:', 'wpsdeals' ); ?></label>
								</th>
								<td>
									<input type="text" id="wps_deals_options[ending_deals_in]" name="wps_deals_options[ending_deals_in]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['ending_deals_in']);?>" class="small-text"/><br />
									<span class="description"><?php _e('Enter a number of days here. If you enter 2 as example, then all deals which will end within 2 days will be displayed within the "Ending Soon" tab.','wpsdeals');?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[upcoming_deals_in]"><?php _e( 'Upcoming Deals:', 'wpsdeals' ); ?></label>
								</th>
								<td>
									<input type="text" id="wps_deals_options[upcoming_deals_in]" name="wps_deals_options[upcoming_deals_in]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['upcoming_deals_in']);?>" class="small-text"/><br />
									<span class="description"><?php _e('Enter a number of days here. If you enter 2 as example, then all deals which will start within 2 days will be displayed within the "Upcoming Deals" tab.','wpsdeals');?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[deals_per_page]"><?php _e( 'Deals Per Page:', 'wpsdeals' ); ?></label>
								</th>
								<td>
									<input type="text" id="wps_deals_options[deals_per_page]" name="wps_deals_options[deals_per_page]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['deals_per_page']);?>" class="small-text"/><br />
									<span class="description"><?php _e('Enter the number of deals you want to display.','wpsdeals');?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label><?php _e( 'Social Connect Buttons:', 'wpsdeals' ); ?></label>
								</th>
								<td>
									<?php 
										$socialbuttons = array(
																'facebook'	=> __( 'Facebook','wpsdeals' ),
																'twitter'	=> __( 'Twitter','wpsdeals' ),
																'google'	=> __( 'Google+','wpsdeals' )
															);
										$socialbuttons = apply_filters('wps_deals_social_settings_options',$socialbuttons); 
										
										foreach ($socialbuttons as $key => $value ) {
									?>
											<input type="checkbox" name="wps_deals_options[social_buttons][]" id="wps_deals_options_<?php echo $key;?>" value="<?php echo $key;?>" <?php if ( isset( $wps_deals_options['social_buttons'] ) && in_array($key,$wps_deals_options['social_buttons']) ) { echo 'checked="checked"';} ?> />
											<label for="wps_deals_options_<?php echo $key;?>"><?php echo $value; ?></label><br />
									<?php } ?>
									<span class="description"><?php _e( 'Choose which social sharing buttons you want to display.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[tw_user_name]"><?php _e( 'Twitter Username:', 'wpsdeals' ); ?></label>
								</th>
								<td><input type="text" id="wps_deals_options[tw_user_name]" name="wps_deals_options[tw_user_name]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['tw_user_name']);?>" class="large-text"/><br />
									<span class="description"><?php _e('Enter your Twitter Username.','wpsdeals');?></span>
								</td>
							</tr>
							
							<?php do_action('wps_deals_add_general_settings_after_socialbuttons');?>
							
							<!-- Page Settings Start -->
							<tr>
								<td colspan="2" valign="top" scope="row">
									<span class="wps-deals-settings-sep-first"><?php _e( 'Pages Settings', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wps_deals_options[deals_main_page]"><?php _e( 'Deals Overview / Home Page:', 'wpsdeals' );?></label>
								</th>
								<td>
									<select id="wps_deals_options[deals_main_page]" name="wps_deals_options[deals_main_page]">
										<option value=""><?php _e('--Select A Page--','wpsdeals');?></option>
										<?php foreach ( $get_pages as $page ) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['deals_main_page'], true ); ?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the Deals Overview / Home Page whcih does show all deals you enabled to show on the Homepage.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[payment_checkout_page]"><?php _e( 'Checkout Page:', 'wpsdeals' );?></label>
								</th>
								<td>
									<select id="wps_deals_options[payment_checkout_page]" name="wps_deals_options[payment_checkout_page]">
										<option value=""><?php _e('--Select A Page--','wpsdeals');?></option>
										<?php foreach ( $get_pages as $page ) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['payment_checkout_page'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the checkout page where buyers will complete their purchases.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[payment_thankyou_page]"><?php _e( 'Thank You Page:', 'wpsdeals' );?></label>
								</th>
								<td>
									<select id="wps_deals_options[payment_thankyou_page]" name="wps_deals_options[payment_thankyou_page]">
										<option value=""><?php _e('--Select A Page--','wpsdeals');?></option>
										<?php foreach ( $get_pages as $page ) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['payment_thankyou_page'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the page buyers are sent to after completing their purchases.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[payment_cancel_page]"><?php _e( 'Cancel Page:', 'wpsdeals' );?></label>
								</th>
								<td>
									<select id="wps_deals_options[payment_cancel_page]" name="wps_deals_options[payment_cancel_page]">
										<option value=""><?php _e('--Select A Page--','wpsdeals');?></option>
										<?php foreach ( $get_pages as $page ) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['payment_cancel_page'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the page buyers are sent to, if their transaction has been cancelled or failed.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[ordered_page]"><?php _e( 'Order History Page:', 'wpsdeals' );?></label>
								</th>
								<td>
									<select id="wps_deals_options[ordered_page]" name="wps_deals_options[ordered_page]">
										<option value=""><?php _e('--Select A Page--','wpsdeals');?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['ordered_page'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the order history page where buyers will see all details for their purchases.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[my_account_page]"><?php _e( 'My Account Page:', 'wpsdeals');?></label>
								</th>
								<td>	
									<select id="wps_deals_options[my_account_page]" name="wps_deals_options[my_account_page]">
										<option value=""><?php _e( '--Select A Page--', 'wpsdeals' );?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['my_account_page'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the my account page where buyers will see all details for their account.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[edit_adderess]"><?php _e( 'Edit Address Page:', 'wpsdeals');?></label>
								</th>
								<td>	
									<select id="wps_deals_options[edit_adderess]" name="wps_deals_options[edit_adderess]">
										<option value=""><?php _e( '--Select A Page--', 'wpsdeals' );?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['edit_adderess'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the edit address page where buyers can change their addresses for their account.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[change_password]"><?php _e( 'Change Password Page:', 'wpsdeals');?></label>
								</th>
								<td>	
									<select id="wps_deals_options[change_password]" name="wps_deals_options[change_password]">
										<option value=""><?php _e( '--Select A Page--', 'wpsdeals' );?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['change_password'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the change password page where buyers can change their account password.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[logout]"><?php _e( 'Logout Page:', 'wpsdeals');?></label>
								</th>
								<td>	
									<select id="wps_deals_options[logout]" name="wps_deals_options[logout]">
										<option value=""><?php _e( '--Select A Page--', 'wpsdeals' );?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['logout'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the logout page where buyers can logout.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[lost_password]"><?php _e( 'Lost Password Page:', 'wpsdeals');?></label>
								</th>
								<td>	
									<select id="wps_deals_options[lost_password]" name="wps_deals_options[lost_password]">
										<option value=""><?php _e( '--Select A Page--', 'wpsdeals' );?></option>
										<?php foreach ($get_pages as $page) { ?>
												<option value="<?php echo $page->ID;?>" <?php selected( $page->ID, $wps_deals_options['lost_password'], true );?>><?php _e( $page->post_title );?></option>
										<?php } ?>
									</select><br />
									<span class="description"><?php _e( 'This is the lost password page where buyers can get their account password.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							<?php
							
									//do action to add some settings after page settings
									do_action('wps_deals_add_general_settings_pages_after');
							?>
							<!-- Page Settings End-->
							<!-- Currency Settings Start -->
							<tr>
								<td colspan="2" valign="top" scope="row">
									<span class="wps-deals-settings-sep-first"><?php _e( 'Currency Settings', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[currency]"><?php _e( 'Currency:', 'wpsdeals');?></label>
								</th>
								<td>
									<?php $currencies = wps_deals_currency_data();?>
										<select id="wps_deals_options[currency]" name="wps_deals_options[currency]">
											<?php	foreach ( $currencies as $key => $value ) { ?>
														<option value="<?php echo $key;?>" <?php selected( $key, $wps_deals_options['currency'], true );?>><?php echo $value;?></option>		
											<?php	} ?>
										</select><br />
									<span class="description"><?php _e( 'Choose your currency. Note that some payment gateways have currency restrictions.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[currency_position]"><?php _e( 'Currency Sign Position:', 'wpsdeals');?></label>
								</th>
								<td>
									<select id="wps_deals_options[currency_position]" name="wps_deals_options[currency_position]">
										<option value="before" <?php selected( 'before', $wps_deals_options['currency_position'], true );?>><?php _e('Before - $10','wpsdeals');?></option>
										<option value="after" <?php selected( 'after', $wps_deals_options['currency_position'], true );?>><?php _e('After - 10$','wpsdeals');?></option>
									</select><br />
									<span class="description"><?php _e( 'Choose the location of the currency sign.', 'wpsdeals' ); ?></span>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="wps_deals_options[thounsands_seperator]"><?php _e( 'Thousands Separator:', 'wpsdeals' ); ?></label>
								</th>
								<td><input type="text" id="wps_deals_options[thounsands_seperator]" name="wps_deals_options[thounsands_seperator]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['thounsands_seperator']);?>" class="small-text"/><br />
									<span class="description"><?php _e('The symbol (usually , or .) to separate thousands.','wpsdeals');?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[decimal_seperator]"><?php _e( 'Decimal Separator:', 'wpsdeals' ); ?></label>
								</th>
								<td><input type="text" id="wps_deals_options[decimal_seperator]" name="wps_deals_options[decimal_seperator]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['decimal_seperator']);?>" class="small-text"/><br />
									<span class="description"><?php _e('The symbol (usually , or .) to separate decimal points.','wpsdeals');?></span>
								</td>
							</tr>
							
							<tr>
								<th scope="row">
									<label for="wps_deals_options[decimal_places]"><?php _e( 'Decimal Places:', 'wpsdeals' ); ?></label>
								</th>
								<td><input type="text" id="wps_deals_options[decimal_places]" name="wps_deals_options[decimal_places]" value="<?php echo $model->wps_deals_escape_attr($wps_deals_options['decimal_places']);?>" class="small-text"/><br />
									<span class="description"><?php _e('Number of decimal places.','wpsdeals');?></span>
								</td>
							</tr>
							
							<!-- Currency Settings End -->
							<?php do_action('wps_deals_add_general_settings_after');?>
							<tr>
								<td colspan="2" valign="top" scope="row">
									<input type="submit" id="wps-deals-settings-submit" name="wps-deals-settings-submit" class="button-primary" value="<?php _e('Save Changes','wpsdeals');?>" />
								</td>
							</tr>
							
						</tbody>
					 </table>
					 
				</div><!-- .inside -->
			</div><!-- #general -->
		</div><!-- .meta-box-sortables ui-sortable -->
	</div><!-- .metabox-holder -->
</div><!-- #wps-deals-general -->