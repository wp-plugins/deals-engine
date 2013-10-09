<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * About Box
 *
 * Show more information about the plugin, incl. support & docs links.
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */	
 ?>

<div id="wps-deals-about" class="post-box-container about">

	<div id="poststuff" class="metabox-holder">

		<div id="post-body" class="has-sidebar">

			<div id="post-body-content" class="has-sidebar-content">

				<div id="about_settings_postbox" class="postbox">										

					<h3 class="hndle">
						<span style="vertical-align: top;"><?php esc_attr_e( 'WPSocial', 'wpsdeals' ); ?></span>
					</h3>									

					<div class="inside">

						<table class="form-table">
							<tr>
								<th>
									<?php _e( 'Plugin:', 'wpsdeals' ); ?>
								</th>
								<td>
									<a href="http://wpsocial.com/social-deals-engine-plugin-for-wordpress/" title="<?php _e( 'Social Deals Engine', 'wpsdeals' ); ?>" target="_blank"><?php _e( 'Social Deals Engine', 'wpsdeals' ); ?></a>
								</td>
							</tr>
									
							<tr>
								<th>
									<?php _e( 'Version:', 'wpsdeals' ); ?>
								</th>
								<td>
									<?php echo WPS_DEALS_VERSION; ?>
								</td>
							</tr>
									
							<tr>
								<th>
									<?php _e( 'Author:', 'wpsdeals' ); ?>
								</th>
								<td>
									<?php _e( 'WPSocial.com', 'wpsdeals' ); ?>
								</td>
							</tr>
							
							<tr>
								<th>
									<?php _e( 'Documentation:', 'wpsdeals' ); ?>
								</th>
								<td>
									<p><?php _e( 'Not quite sure how to use the plugin? Visit our Knowledge Base to learn how to use it properly.', 'wpsdeals' ); ?>	<a href="http://support.wpsocial.com/support/home" title="<?php _e( 'Social Deals Engine Docs', 'wpsdeals' ); ?>" target="_blank"><?php _e( 'Social Deals Engine Knowledge Base', 'wpsdeals' ); ?></a></p>
								</td>
							</tr>
						</table><!-- .form-table -->											

					</div><!-- .inside -->					

				</div><!-- #general_settings_postbox -->								

			</div><!-- #post-body-content -->

		</div><!-- #post-body -->

	</div><!-- #poststuff -->

</div><!-- #wps-deals-about -->	



<?php // Get RSS Feed(s)

	include_once(ABSPATH . WPINC . '/feed.php');

	// Get a SimplePie feed object from the specified feed source.
	$rss = fetch_feed( 'http://www.wpsocial.com/feed/' );

	if ( !is_wp_error( $rss ) ) : // Checks that the object is created correctly     

	// Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity(5); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems); 
	
	endif;
?>

<div id="wps-social" class="post-box-container about">

	<div id="poststuff" class="metabox-holder">

		<div id="post-body" class="has-sidebar">

			<div id="post-body-content" class="has-sidebar-content">

				<div id="about_settings_postbox" class="postbox">										

					<h3 class="hndle">
						<span style="vertical-align: top;"><?php esc_attr_e( 'Latest News from WPSocial', 'wpsdeals' ); ?></span>
					</h3>									

					<div class="inside">
								
						<table class="form-table">
							<tr valign="top">
								<td>
									<ul <?php if ( $maxitems == 0 ) { echo ''; } else { echo 'style="margin-top: -16px;"'; } ?>>
										<?php 
											if ( $maxitems == 0 ) echo '<li>' . __( 'No items.', 'wpsdeals' ) . '</li>';
											else
											
											// Loop through each feed item and display each item as a hyperlink.
											foreach ( $rss_items as $item ) : 
										?>
											<li>
												<div class="icon-option">
													<a href='<?php echo esc_url( $item->get_permalink() ); ?>' title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/wps.png'; ?>" alt="WPSocial News" title="<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>" />									
													<?php echo esc_html( $item->get_title() ); ?></a>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
							
							<tr>
								<td valign="middle">
									<div class="icon-option"><a href="http://www.facebook.com/WPSocial" target="_blank"><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/facebook.png'; ?>" alt="WPSocial Facebook" title="<?php _e( 'Like WPSocial on Facebook', 'wpsdeals' ); ?>" /><?php _e( 'Like WPSocial on Facebook', 'wpsdeals' ); ?></a></div>
									<div class="icon-option"><a href="https://plus.google.com/105389611532237339285" target="_blank"><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/google-plus.png'; ?>" alt="WPSocial Google+" title="<?php _e( 'Circle WPSocial on Google+', 'wpsdeals' ); ?>" /><?php _e( 'Circle WPSocial on Google+', 'wpsdeals' ); ?></a></div>
									<div class="icon-option"><a href="http://twitter.com/#!/wpsocial" target="_blank"><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/twitter.png'; ?>" alt="WPSocial Twitter" title="<?php _e( 'Follow WPSocial on Twitter', 'wpsdeals' ); ?>" /><?php _e( 'Follow WPSocial on Twitter', 'wpsdeals' ); ?></a></div>
									<div class="icon-option"><a href="http://www.wpsocial.com/feed" target="_blank"><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/rss.png'; ?>" alt="Subscribe with RSS" title="<?php _e( 'Subscribe with RSS', 'wpsdeals' ); ?>" /><?php _e( 'Subscribe with RSS', 'wpsdeals' ); ?></a></div>
									<div class="icon-option"><a href="http://www.wpsocial.com/newsletter" target="_blank"><img src="<?php echo WPS_DEALS_URL . 'includes/images/icons/email.png'; ?>" alt="Subscribe by email" title="<?php _e( 'Subscribe by email', 'wpsdeals' ); ?>" /><?php _e( 'Subscribe by email', 'wpsdeals' ); ?></a></div>
									<div class="clear"></div>
								</td>
							</tr>									
						</table><!-- .form-table -->								

					</div><!-- .inside -->					

				</div><!-- #general_settings_postbox -->								

			</div><!-- #post-body-content -->

		</div><!-- #post-body -->

	</div><!-- #poststuff -->

</div><!-- #wps-social-about -->			