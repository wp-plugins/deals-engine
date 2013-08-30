<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page Email Tab
 *
 * The code for the plugins settings page email tab
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */
?>
<!-- beginning of the email settings meta box -->
<div id="wps-deals-emails" class="post-box-container">
	<div class="metabox-holder">	
		<div class="meta-box-sortables ui-sortable">
			<div id="general" class="postbox">	
				<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpsdeals' ); ?>"><br /></div>

					<!-- general settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'Emails Settings', 'wpsdeals' ); ?></span>
					</h3>

					<div class="inside">
						<table class="form-table">
							<tbody>
								<tr>
									<td colspan="2" valign="top" scope="row">
										<input type="submit" id="wps-deals-settings-submit" name="wps-deals-settings-submit" class="button-primary" value="<?php _e('Save Changes','wpsdeals');?>" />
									</td>
								</tr>
								
								<?php do_action('wps_deals_add_email_settings_before');?>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[from_email]"><?php _e( 'From Email Address:', 'wpsdeals' ); ?></label>
									</th>
									<td><input type="text" id="wps_deals_options[from_email]" name="wps_deals_options[from_email]" value="<?php echo $wps_deals_options['from_email'];?>" class="large-text" /><br />
										<span class="description"><?php _e('Ex: Your Name &lt;sales@your-domain.com&gt; This is the email address that will be used to send the email to the buyer.','wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[buyer_email_subject]"><?php _e( 'Email Subject:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<input type="text" id="wps_deals_options[buyer_email_subject]" name="wps_deals_options[buyer_email_subject]" value="<?php echo $model->wps_deals_escape_attr( $wps_deals_options['buyer_email_subject'] );?>" class="large-text" /><br />
										<span class="description"><?php _e('This is the subject of the email that will be sent to the buyer.','wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[buyer_email_body]"><?php _e( 'Purchase Receipt:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<textarea id="wps_deals_options[buyer_email_body]" name="wps_deals_options[buyer_email_body]" rows="7" class="large-text"><?php echo $model->wps_deals_escape_attr($wps_deals_options['buyer_email_body']);?></textarea>
										<?php 
												$buyeremail_desc = 'This is the body of the email that will be sent to the buyer. Do not change the email tags (text within the braces { })<br />
												<code>{first_name}</code> - displays the buyer\'s first name<br />
												<code>{last_name}</code> - displays the buyer\'s last name<br />
												<code>{fullname}</code> - displays the buyer\'s first and last name<br />
												<code>{username}</code> - displays the buyer\'s username on the site, if they registered an account<br />
												<code>{product_details}</code> - displays the details for each product for this purchase<br />
												<code>{payment_method}</code> - displays the payment method the buyer used for this purchase<br />
												<code>{purchase_date}</code> - displays the date on which the purchase was made<br />
												<code>{order_id}</code> – displays the Order ID of this purchase<br />
												<code>{sitename}</code> – displays the name of your site<br />
												<code>{subtotal}</code> – displays the subtotal amount of this purchase<br />
												<code>{total}</code> – displays the total amount of this purchase';
												$buyeremail_desc = apply_filters('wps_deals_buyer_email_body_desc',$buyeremail_desc);
										?><br />		
										<span class="description"><?php _e($buyeremail_desc,'wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[notif_email_address]"><?php _e( 'Notification Email Address:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<textarea id="wps_deals_options[notif_email_address]" name="wps_deals_options[notif_email_address]" class="large-text" rows="5"><?php echo $model->wps_deals_escape_attr($wps_deals_options['notif_email_address']);?></textarea><br />
										<span class="description"><?php _e('This is the email address(es) where the admin(s) will be notified of product sales. Separate multiple recipients by a comma.','wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[disable_seller_notif]"><?php _e( 'Disable Admin Notifications:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<input type="checkbox" id="wps_deals_options[disable_seller_notif]" name="wps_deals_options[disable_seller_notif]" value="1" <?php if(isset($wps_deals_options['disable_seller_notif'])) { checked('1',$wps_deals_options['disable_seller_notif']); }?>/><br />
										<span class="description"><?php _e( 'Check this box if you do not want to receive emails when new sales are made.','wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[seller_email_subject]"><?php _e( 'Notification Email Subject:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<input type="text" id="wps_deals_options[seller_email_subject]" name="wps_deals_options[seller_email_subject]" value="<?php echo $model->wps_deals_escape_attr( $wps_deals_options['seller_email_subject'] );?>" class="large-text" /><br />
										<span class="description"><?php _e('This is the subject of the email that will be sent to the admin(s) for record.','wpsdeals');?></span>
									</td>
								</tr>
								
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[seller_email_body]"><?php _e( 'Notification Email Body:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<textarea id="wps_deals_options[seller_email_body]" name="wps_deals_options[seller_email_body]" rows="7" class="large-text"><?php echo $model->wps_deals_escape_attr($wps_deals_options['seller_email_body'])?></textarea>
										<?php 
												$selleremail_desc = 'This is the body of the email that will be sent to the seller. Do not change the email tags (text within the braces { })<br />
												<code>{first_name}</code> - displays the buyer\'s first name<br />
												<code>{last_name}</code> - displays the buyer\'s last name<br />
												<code>{username}</code> - displays the buyer\'s username on the site, if they registered an account<br />
												<code>{product_details}</code> - displays the details for each product for this purchase<br />
												<code>{payment_method}</code> - displays the payment method the buyer used for this purchase<br />
												<code>{subtotal}</code> – displays the subtotal amount of this purchase<br />
												<code>{total}</code> – displays the total amount of this purchase';
												
												$selleremail_desc = apply_filters('wps_deals_seller_email_body_desc',$selleremail_desc);
										?><br />
										<span class="description"><?php _e($selleremail_desc,'wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[update_order_email_subject]"><?php _e( 'Update Order Email Subject:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<input type="text" id="wps_deals_options[update_order_email_subject]" name="wps_deals_options[update_order_email_subject]" value="<?php echo $model->wps_deals_escape_attr( $wps_deals_options['update_order_email_subject'] );?>" class="large-text" /><br />
										<span class="description"><?php _e('This is the subject of the email that will be sent to the buyer when an order will be updated from the backend.','wpsdeals');?></span>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<label for="wps_deals_options[update_order_email]"><?php _e( 'Update Order Email Body:', 'wpsdeals' ); ?></label>
									</th>
									<td>
										<textarea id="wps_deals_options[update_order_email]" name="wps_deals_options[update_order_email]" rows="7" class="large-text"><?php echo $model->wps_deals_escape_attr($wps_deals_options['update_order_email'])?></textarea>
										<?php 
												$update_order_desc = 'This is the body of the email that will be sent to the buyer when the admin updated the order. Do not change the email tags (text within the braces { })<br />
																			<code>{order_id}</code> - displays the Order ID<br />
																			<code>{order_date}</code> - displays the Order Date<br />
																			<code>{status}</code> - displays the Order Status';
												
												$update_order_desc = apply_filters('wps_deals_update_order_email_desc',$update_order_desc);
										?><br />
										<span class="description"><?php _e($update_order_desc,'wpsdeals');?></span>
									</td>
								</tr>
								
								<?php do_action('wps_deals_add_email_settings_after');?>
								
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
</div><!-- #wps-deals-emails -->