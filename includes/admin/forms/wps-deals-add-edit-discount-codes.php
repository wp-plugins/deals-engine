<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Add/Edit Discount
 *
 * Handle Add / Edit Discount
 * 
 * @package Discount Table
 *
 */

global $wps_deals_model, $errmsg,$error; //make global for error message to showing errors
	
	$model = $wps_deals_model;

	$prefix = WPS_DEALS_META_PREFIX;
	
$html = '';  //start string varible with blank

	//set default value as blank for all fields
	//preventing notice and warnings
	$data = array( 
					$prefix.'discount_name'				=> '',
					$prefix.'discount_code' 				=> '',
					$prefix.'discount_type' 				=> '', 
					$prefix.'discount_amount' 			=> '',
					$prefix.'discount_start_date'			=> '',
					$prefix.'discount_expiration_date'	=> '',
					$prefix.'discount_min_amount' 		=> '',
					$prefix.'_discount_max_use' 			=> ''
				);
	if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['disc_id']) && !empty($_GET['disc_id'])) { //check action & id is set or not
		
		//discount page title
		$discount_lable = __('Edit Discount Code', 'wpsdeals');
		
		//discount page submit button text either it is Add or Update
		$discount_btn = __('Update', 'wpsdeals');
		
		//get the discount id from url to update the data and get the data of discount to fill in editable fields
		$post_id = $_GET['disc_id'];
		
		//get the data from discount id
		$getpost = get_post( $post_id );
		//assign retrived data to current page fields data to show filled in fields
		$data['wps_deals_discount_name'] = $getpost->post_title;
		$data['wps_deals_discount_code'] = get_post_meta($post_id,$prefix.'discount_code',true);
		$data['wps_deals_discount_type'] = get_post_meta($post_id,$prefix.'discount_type',true);
		$data['wps_deals_discount_amount'] = get_post_meta($post_id,$prefix.'discount_amount',true);
		$data['wps_deals_discount_start_date'] = get_post_meta($post_id,$prefix.'discount_start_date',true);
		$data['wps_deals_discount_expiration_date'] = get_post_meta($post_id,$prefix.'_discount_expiration_date',true);
		$data['wps_deals_discount_min_amount'] = get_post_meta($post_id,$prefix.'discount_min_amount',true);
		$data['wps_deals_discount_max_use'] = get_post_meta($post_id,$prefix.'discount_max_use',true);
		$data['wps_deals_discount_status'] = get_post_meta($post_id,$prefix.'discount_status',true);
		
		//when error occured in edit then override the values with $_POST
		if($error != true) {
			$data = $data;
		} else {
			$data = $_POST;
		}
	} else {
		//discount page title
		$discount_lable = __('Add New Discount Code', 'wpsdeals');
		
		//discount page submit button text either it is Add or Update
		$discount_btn = __('Save', 'wpsdeals');
		
		//if when error occured then assign $_POST to be field fields with none error fields
		if($_POST) { //check if $_POST is set then set all $_POST values
			$data = $_POST;
		}
	}
	
	//if start date is not empty then replace to proper format
	if(!empty($data['wps_deals_discount_start_date'])){
		$data['wps_deals_discount_start_date'] = date('d-m-Y',strtotime($data['wps_deals_discount_start_date']));
	}
	//if expiration date is not empty then replace to proper format
	if(!empty($data['wps_deals_discount_expiration_date'])){
		$data['wps_deals_discount_expiration_date'] = date('d-m-Y',strtotime($data['wps_deals_discount_expiration_date']));
	}
	
	$html .= '<div class="wrap">';
	
	$html .= '<!-- wpsocial logo -->
				<img src="'.WPS_DEALS_URL . 'includes/images/wps-logo.png" class="wpsocial-logo deals-sales-logo" alt="WPSocial.com Logo" />';
	
	$html .= '<h2>'.__( $discount_lable , 'wpsdeals');
	$html .= '<a class="add-new-h2" href="edit.php?post_type='.WPS_DEALS_POST_TYPE.'&page=wps-deals-discount-codes">'.__('Back','wpsdeals').'</a></h2>';
	
	$html .= '<div id="wps-deals-discount" class="post-box-container">
				
					<div class="metabox-holder">	
				
						<div class="meta-box-sortables ui-sortable">
				
							<div id="discount" class="postbox">	
				
								<div class="handlediv" title="'. __( 'Click to toggle', 'wpsdeals' ).'"><br /></div>
				
									<h3 class="hndle">
										<span style="vertical-align: top;">'. __( $discount_lable, 'wpsdeals' ).'</span>
									</h3>
				
										<div class="inside">';
	
	$html .= '								<form action="" method="POST" id="wps-deals-add-edit-form">
													<input type="hidden" name="page" value="wps-deals-add-edit-discount-codes" />
													
												<div id="wps-deals-require-message"><strong>(</strong> <span class="wps-deals-require">*</span> <strong>) '. __( 'Required fields', 'wpsdeals' ).'</strong></div>
													
													<table class="form-table wps-deals-discount-codes"> 
														<tbody>';
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Name:', 'wpsdeals' ).'</strong><span class="wps-deals-require"> * </span></label>
														</th>
														<td width="30%"><input type="text" id="wps_deals_discount_name" name="wps_deals_discount_name" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_name']).'" class="large-text"/><br />
															<span class="description">'.__( 'The name of this discount.', 'wpsdeals' ).'</span>
														</td>
														<td class="wps-deals-required-error">';
															if(isset($errmsg['wps_deals_discount_name']) && !empty($errmsg['wps_deals_discount_name'])) { //check error message for discount title
																$html .= '<div>'.$errmsg['wps_deals_discount_name'].'</div>';
															}
	$html .= '											</td>
												 	</tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Code:', 'wpsdeals' ).'</strong><span class="wps-deals-require"> * </span></label>
														</th>
														<td width="30%"><input type="text" id="wps_deals_discount_code" name="wps_deals_discount_code" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_code']).'" class="large-text"/><br />
															<span class="description">'.__( 'Enter a code for this discount, such as 10PERCENT.', 'wpsdeals' ).'</span>
														</td>
														<td class="wps-deals-required-error">';
															if(isset($errmsg['wps_deals_discount_code']) && !empty($errmsg['wps_deals_discount_code'])) { //check error message for discount title
																$html .= '<div>'.$errmsg['wps_deals_discount_code'].'</div>';
															}
	$html .= '											</td>
													 </tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Type:', 'wpsdeals').'</strong></label>
														</th>
														<td width="30%"><select id="wps_deals_discount_type" name="wps_deals_discount_type">';
															$type_array = array(
																					'0'		=>	__( 'Flat amount', 'wpsdeals' ),
																					'1'		=>	__( 'Percentage', 'wpsdeals' )
																			);
															foreach ($type_array as $key => $value) {
																$html .= '<option value="'.$key.'" '.selected($key,$data['wps_deals_discount_type'],false).'>'.$value.'</option>';
															}
	$html .= '												</select><br />
															<span class="description">'.__( 'The kind of discount to apply for this discount..', 'wpsdeals' ).'</span>';
	$html .= '											</td>
												 	</tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Amount:', 'wpsdeals' ).'</strong><span class="wps-deals-require"> * </span></label>
														</th>
														<td width="30%"><input type="text" id="wps_deals_discount_amount" name="wps_deals_discount_amount" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_amount']).'" class="medium-text"/><br />
															<span class="description">'.__( 'The amount of this discount code..', 'wpsdeals' ).'</span>
														</td>
														<td class="wps-deals-required-error">';
															if(isset($errmsg['wps_deals_discount_amount']) && !empty($errmsg['wps_deals_discount_amount'])) { //check error message for discount title
																$html .= '<div>'.$errmsg['wps_deals_discount_amount'].'</div>';
															}
	$html .= '											</td>
													</tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Start Date:', 'wpsdeals' ).'</strong></label>
														</th>
														<td><input type="text" class="medium-text wps-deals-date" id="wps_deals_discount_start_date" name="wps_deals_discount_start_date" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_start_date']).'" /><br />
															<span class="description">'.__( 'Enter the start date for this discount code, leave blank. If entered, the discount can only be used after or on this date.', 'wpsdeals' ).'</span>
														</td>
													 </tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Expiration date:', 'wpsdeals' ).'</strong></label>
														</th>
														<td ><input type="text" class="medium-text wps-deals-date" id="wps_deals_discount_expiration_date" name="wps_deals_discount_expiration_date" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_expiration_date']).'"/><br />
															<span class="description">'.__( 'Enter the expiration date for this discount code, For no expiration, leave blank.', 'wpsdeals' ).'</span>
														</td>
													 </tr>';
										
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Minimum Amount:', 'wpsdeals' ).'</strong></label>
														</th>
														<td width="30%"><input type="text" class="medium-text" id="wps_deals_discount_min_amount" name="wps_deals_discount_min_amount" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_min_amount']).'"/><br />
															<span class="description">'.__( 'The minimum amount that must be purchased before this discount can be used. Leave blank for no minimum.', 'wpsdeals' ).'</span>
														</td>
												 	</tr>';										
												
	$html .= '										<tr>
														<th scope="row">
															<label><strong>'.__( 'Max Uses:', 'wpsdeals' ).'</strong></label>
														</th>
														<td width="30%"><input type="text" class="medium-text" id="wps_deals_discount_max_use" name="wps_deals_discount_max_use" value="'.$model->wps_deals_escape_attr($data['wps_deals_discount_max_use']).'" /><br />
															<span class="description">'.__( 'The maximum number of times this discount can be used. Leave blank for unlimited.', 'wpsdeals' ).'</span>
														</td>
													</tr>';

		if(isset($_GET['disc_id']) && !empty($_GET['disc_id'])) {
		
			$html .= '								<tr>
														<th scope="row">
															<label><strong>'.__( 'Status:', 'wpsdeals' ).'</strong></label>
														</th>
														<td width="30%">
															<select name="wps_deals_discount_status">
																<option value="1" '.selected('1',$data['wps_deals_discount_status'],false).'>'.__('Active','wpsdeals').'</option>
																<option value="0" '.selected('0',$data['wps_deals_discount_status'],false).'>'.__('Inactive','wpsdeals').'</option>
															</select><br />
															<span class="description">'.__( 'The status of this discount code.', 'wpsdeals' ).'</span>
														</td>
													</tr>';
		}
										
	$html .= '										<tr>
														<td colspan="3">
															<input type="submit" class="button-primary margin_button" name="wps_deals_discount_save" id="wps_deals_discount_save" value="'.$discount_btn.'" />
														</td>
													</tr>';
	
	$html .= '								</tbody>
										</table>
									</form>
								</div><!-- .inside -->
					
							</div><!-- #discount -->
				
						</div><!-- .meta-box-sortables ui-sortable -->
				
					</div><!-- .metabox-holder -->
				
				</div><!-- #wps-discount-general -->
				
				<!-- end of the discount meta box -->';
	
	$html .= '</div><!-- .wrap -->';
	
	echo $html;
?>