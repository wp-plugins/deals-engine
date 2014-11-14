<?php 

/**
 * Template For Terms and conditions
 * 
 * Handles to return design of terms and conditions
 * 
 * Override this template by copying it to
 * yourtheme/deals-engine/checkout/checkout-footer/terms.php
 *
 * @package Social Deals Engine
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>											
<div class="wps-deals-details row-fluid">
	<div class="span8">
		<input type="checkbox" id="wps_deals_checkout_agree_terms" name="wps_deals_checkout_agree_terms" value="1"/>
		<a href="#myModal" role="button" data-toggle="modal"><?php echo $agreelabel;?></a>
	</div>
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo $agreelabel;?></h3>
	</div>
	<div class="modal-body">
		<?php echo $termscontent;?>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div><!--#myModal-->