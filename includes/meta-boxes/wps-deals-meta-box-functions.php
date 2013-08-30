<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * get meta pages
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_get_meta_pages() {
	
	$args = array(WPS_DEALS_POST_TYPE);
	
	// Check for which post type we need to add the meta box
	if( $args == 'all' ) {
		$pages = get_post_types( array( 'public' => true ), 'names' );
	} else {
		$pages = $args;
	}
	
	return $pages;
}

/**
 * meta value
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_meta_value( $field ) {
	
	global $post;
	
	$meta = get_post_meta( $post->ID, $field['id'], true );
	$meta = isset( $meta ) ? $meta : '';
	
	if( !in_array( $field['type'], array( 'image', 'repeater', 'file', 'cond', 'fileadvanced' ) ) ) {
		$meta = is_array( $meta ) ? array_map( 'esc_attr', $meta ) : esc_attr( $meta );
	}
	
	return $meta;
}

/**
 * Begin Tab Content Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_tab_content_begin( $echo = true ) {
	
	$html = '';
	
	$html .= '<table class="form-table">';
	
	$html .= '<tbody>';
	
	if( $echo ) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * End Tab Content Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_tab_content_end( $echo = true ) {
	
	$html = '';
	
	$html .= '</tbody>';
	
	$html .= '</table>';
	
	if( $echo ) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Begin Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_show_field_begin( $field ) {

	$field_begin = '';
	
	$field_begin .= '<tr valign="top">';
	$field_begin .= "<th>";
	
	if ( isset($field['name']) && !empty($field['name']) ) {
		$field_begin .= "<label for='{$field['id']}'>{$field['name']}</label>";
	}
	
	$field_begin .= '</th>';
	$field_begin .= '<td>';
	
	return $field_begin;
}

/**
 * End Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public 
 */
function wps_deals_show_field_end( $field, $meta=NULL ,$group = false) {

	$field_end = '';
	
	if ( isset($field['desc']) && !empty($field['desc']) ) {
		$field_end .= "<div><span class='description'>{$field['desc']}</span></div></td>";
	} else {
		$field_end .= "</td>";
	}
	
	$field_end .= '</tr>';
	
	return $field_end;
}
	   
/**
 * Show Field Hidden.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_hidden( $args, $echo = true ) {  

	$html = '';
	
	$new_field = array( 'type' => 'hidden', 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$html .= "<input type='hidden' class='regular-text {$field['class']} ' name='{$field['id']}' id='{$field['id']}' value='{$meta}'/>";

	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
} 
	   
/**
 * Show Field Text.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_text( $args, $echo = true ) {  
	
	$html = '';
	
	$new_field = array( 'type' => 'text', 'name' => __('Text Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );
	
	$meta = wps_deals_meta_value( $field );
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<input type='text' class='wps-deals-meta-text regular-text {$field['class']} ' name='{$field['id']}' id='{$field['id']}' value='{$meta}' />";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
} 
     
/**
 * Show Field Textarea.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_textarea( $args, $echo = true ) {
	
	$html = '';
	
	$new_field = array( 'type' => 'textarea', 'name' => __('Textarea Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<textarea class='wps-deals-meta-textarea large-text {$field['class']} ' name='{$field['id']}' id='{$field['id']}' cols='60' rows='10'>{$meta}</textarea>";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
}
	   
/**
 * Show Field Paragraph.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_paragraph( $args, $echo = true ) {  

	$html = '';
	
	$new_field = array( 'type' => 'paragraph', 'value' => '', 'class' => '' );
	$field = array_merge( $new_field, $args );

	$html .= "<p class='wps-deals-meta-paragraph {$field['class']} '>".$field['value']."</p>";

	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
} 

/**
 * Show Field Checkbox.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_checkbox( $args, $echo = true ) {
	
	$html = '';
	
	$new_field = array( 'type' => 'checkbox', 'name' => __('Checkbox Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<input type='checkbox' class='wps-deals-meta-checkbox {$field['class']} ' name='{$field['id']}' id='{$field['id']}'" . checked(!empty($meta), true, false) . " />";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
}

/**
 * Show Checkbox List Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_checkbox_list( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'checkbox_list', 'name' => __('Checkbox List Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if( ! is_array( $meta ) ) {
		$meta = (array) $meta;
	}

	$html .= wps_deals_show_field_begin( $field );
	
	$cb_html = array();
	
	foreach ($field['options'] as $key => $value) {
		$cb_html[] = "<input type='checkbox' class='wps-deals-meta-checkbox_list {$field['class']} ' name='{$field['id']}[]' value='{$key}'" . checked( in_array( $key, $meta ), true, false ) . " /> {$value}";
	}
	
	$html .= implode( '<br />' , $cb_html );
	  
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
}

/**
 * Show Field Select.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_select( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'select', 'name' => __('Select Field', 'wpsdeals'), 'multiple' => false, 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if( ! is_array( $meta ) ) {
		$meta = (array) $meta;
	}

	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<select class='wps-deals-meta-select {$field['class']} ".($field['multiple'] ? 'wps-deals-meta-multiple-select' : 'wps-deals-meta-single-select')."' name='{$field['id']}" . ( $field['multiple'] ? "[]' id='{$field['id']}' multiple='multiple'" : "'" ) . ">";
	
	foreach ( $field['options'] as $key => $value ) {
		$html .= "<option value='{$key}'" . selected( in_array( $key, $meta ), true, false ) . ">{$value}</option>";
	}
	
	$html .= "</select>";	
		
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
}

/**
 * Show Radio Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public 
 */
function wps_deals_add_radio( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'radio', 'name' => __('Radio Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if( ! is_array( $meta ) ) {
		$meta = (array) $meta;
	}
  
	$html .= wps_deals_show_field_begin( $field );
	
	foreach ( $field['options'] as $key => $value ) {
		$html .= "<input type='radio' class='wps-deals-meta-radio {$field['class']} ' name='{$field['id']}' value='{$key}'" . checked( in_array( $key, $meta ), true, false ) . " /> <span class='wps-deals-meta-radio-label'>{$value}</span>";
	}
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
	
}

/**
 * Show Date Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_datetime( $args, $echo = true ) {

	$html = '';
	
	$new_field = array('type' => 'datetime','format'=>'d MM, yy','name' => __('Date Time Field', 'wpsdeals'), 'class' => '');
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if(isset($meta) && !empty($meta) && !is_array($meta)) { //check datetime value is set & not array & not empty
		$meta = date('d-m-Y h:i a',strtotime($meta));
	} else {
		$meta = '';
	}
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<input type='text' class='wps-deals-meta-datetime {$field['class']} ' name='{$field['id']}' id='{$field['id']}' rel='{$field['format']}' value='{$meta}' size='30' />";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show Image Field.
 *
 * @param array $field 
 * @param array $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_image( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'image', 'name' => __('Image Field','wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$html .= wps_deals_show_field_begin( $field );
	
	$html .= wp_nonce_field( "wps-deals-meta-delete-mupload_{$field['id']}", "nonce-delete-mupload_".$field['id'], false, false );

	$meta = wps_deals_meta_value( $field );
	
	if( is_array( $meta ) ) {
		if( isset( $meta[0] ) && is_array( $meta[0] ) ) {
			$meta = $meta[0];
		}
	}
	
	if( is_array( $meta ) && isset( $meta['src'] ) && $meta['src'] != '' ) {
		$html .= "<span class='mupload_img_holder'><img src='".$meta['src']."' style='width: 150px;' /></span>";
		$html .= "<input type='hidden' name='".$field['id']."[id]' id='".$field['id']."[id]' value='".$meta['id']."' />";
		$html .= "<input type='hidden' name='".$field['id']."[src]' id='".$field['id']."[src]' value='".$meta['src']."' />";
		$html .= "<input class='wps-deals-meta-delete_image_button button-secondary' type='button' rel='".$field['id']."' value='" . __( 'Delete Image', 'wpsdeals' ) . "' />";
	} else {
		$html .= "<span class='mupload_img_holder'></span>";
		$html .= "<input type='hidden' name='".$field['id']."[id]' id='".$field['id']."[id]' value='' />";
		$html .= "<input type='hidden' name='".$field['id']."[src]' id='".$field['id']."[src]' value='' />";
		$html .= "<input class='wps-deals-meta-upload_image_button button-secondary {$field['class']} ' type='button' rel='".$field['id']."' value='" . __( 'Upload Image', 'wpsdeals' ) . "' />";
	}
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show Wysiwig Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_wysiwyg( $args ) {

	global $wp_version;
	
	$html = '';
	
	$new_field = array( 'type' => 'wysiwyg', 'name' => __('WYSIWYG Editor Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$html .= wps_deals_show_field_begin( $field );

	echo $html;
	
	// Add TinyMCE script for WP version < 3.3
	if ( version_compare( $wp_version, '3.2.1' ) < 1 ) {
		echo "<textarea class='wps-deals-meta-wysiwyg theEditor large-text {$field['class']} ' name='{$field['id']}' id='{$field['id']}' cols='60' rows='10'>{$meta}</textarea>";
	} else {
		// Use new wp_editor() since WP 3.3
		wp_editor( html_entity_decode($meta), $field['id'], array( 'editor_class' => 'wps-deals-meta-wysiwyg' ) );
	}

	$html = wps_deals_show_field_end( $field );
	
	echo $html;
}

/**
 * Show File Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_fileadvanced( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'fileadvanced', 'name' => __('Advanced File Field','wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$namesarr = $field;
	$namesarr['id'] = $namesarr['id'].'_name';
	$namesmeta = wps_deals_meta_value( $namesarr );
	
	if ( ! is_array( $meta ) ) {
		$meta = (array) $meta;
	}

	$html .= wps_deals_show_field_begin( $field );

	if( ! empty( $meta ) ) {
		$nonce = wp_create_nonce( 'at_ajax_delete' );
		//echo '<div style="margin-bottom: 10px"><strong>' . __( 'Uploaded files', 'wpsdeals' ) . '</strong></div>';
		//echo '<ol class="wps-deals-meta-upload">';
			
			foreach( ( array )$meta as $key => $att ) {
				// if (wp_attachment_is_image($att)) continue; // what's image uploader for?
				//echo "<li>";
				if(!empty($att)) {
					$splitname = pathinfo( $att );
					$filename = isset( $namesmeta[$key] ) && !empty( $namesmeta[$key] ) ? $namesmeta[$key] : $splitname['filename'];
					$html .= "<div class='file-input-advanced'>";
					$html .= "<input type='text' name='{$field['id']}_name[]' value='{$filename}' style='width:15%;' class='wps-deals-upload-file-name' placeholder='".__('File Name','wpsdeals')."'/>";
					$html .= "<input type='text' name='{$field['id']}[]' value='".$att."' style='width:80%;' class='wps-deals-upload-file-link' placeholder='http://'/>";
					$html .= "<span class='wps-deals-upload-files'><a class='wps-deals-upload-fileadvanced {$field['class']} ' href='javascript:void(0);'>".__( 'Upload a File','wpsdeals')."</a></span>";
					$html .= "<a href='javascript:void(0);' class='wps-deals-delete-fileadvanced'><img src='".WPS_DEALS_META_URL."/images/delete-16.png' alt='".__('Delete','wpsdeals')."'/></a>";
					$html .= "</div><!-- End .file-input-advanced -->";
				}
				//echo "</li>";
			}
		//echo '</ol>';
	} 
	if(empty($meta[0])){
		
		$html .= "<div class='file-input-advanced'>";
		$html .= "<input type='text' name='{$field['id']}_name[]' value='' style='width:15%;' class='wps-deals-upload-file-name' placeholder='".__('File Name','wpsdeals')."'/>";
		$html .= "<input type='text' name='{$field['id']}[]' value='' style='width:80%;' class='wps-deals-upload-file-link' placeholder='http://'/>";
		$html .= "<span class='wps-deals-upload-files'><a class='wps-deals-upload-fileadvanced' href='javascript:void(0);'>".__( 'Upload a File','wpsdeals')."</a></span>";
		$html .= "<a href='javascript:void(0);' class='wps-deals-delete-fileadvanced'><img src='".WPS_DEALS_META_URL."/images/delete-16.png' alt='".__('Delete','wpsdeals')."'/></a>";
		$html .= "</div><!-- End .file-input-advanced -->";
	}
	// show form upload
	//echo "<div class='new-files1'>";
	
	$html .= "<a class='wps-deals-meta-add-fileadvanced button' href='javascript:void(0);'>" . __( 'Add more files', 'wpsdeals' ) . "</a>";
	//echo "</div><!-- End .new-files -->";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show Color Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_color( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'color', 'name' => __('ColorPicker Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if ( empty( $meta ) ) {
		$meta = '#';
	}
	  
	$html .= wps_deals_show_field_begin( $field );
	
	if( wp_style_is( 'wp-color-picker', 'registered' ) ) { //iris color picker since 3.5
		$html .= "<input class='wps-deals-meta-color-iris".( isset( $field['class'] )? " {$field['class']}": "")."' type='text' name='{$field['id']}' id='{$field['id']}' value='{$meta}' size='8' />";  
	} else {
		$html .= "<input class='wps-deals-meta-color".( isset( $field['class'] )? " {$field['class']}": "")."' type='text' name='{$field['id']}' id='{$field['id']}' value='{$meta}' size='8' />";
		$html .= "<input type='button' class='wps-deals-meta-color-select button' rel='{$field['id']}' value='" . __( 'Select a color' ,'wpsdeals') . "'/>";
		$html .= "<div style='display:none' class='wps-deals-meta-color-picker' rel='{$field['id']}'></div>";
	}

	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show Date Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_date( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'date', 'format'=>'d MM, yy', 'name' => ___('Date Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$meta = !is_array($meta) ? $meta : '' ;
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<input type='text' class='wps-deals-meta-date {$field['class']} ' name='{$field['id']}' id='{$field['id']}' rel='{$field['format']}' value='{$meta}' size='30' />";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show time field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public 
 */
function wps_deals_add_time( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'time', 'format'=>'hh:mm', 'name' => __('Time Field', 'wpsdeals'), 'ampm' => false, 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	$ampm = ($field['ampm'])? 'true' : 'false';
	
	$html .= wps_deals_show_field_begin( $field );
	
	$html .= "<input type='text' class='wps-deals-meta-time {$field['class']} ' name='{$field['id']}' id='{$field['id']}' data-ampm='{$ampm}' rel='{$field['format']}' value='{$meta}' size='30' />";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}

/**
 * Show File Field.
 *
 * @param string $field 
 * @param string $meta 
 * @since 1.0
 * @access public
 */
function wps_deals_add_file( $args, $echo = true ) {

	$html = '';
	
	$new_field = array( 'type' => 'file', 'name' => __('File Field', 'wpsdeals'), 'class' => '' );
	$field = array_merge( $new_field, $args );

	$meta = wps_deals_meta_value( $field );
	
	if ( ! is_array( $meta ) ) {
		$meta = (array) $meta;
	}

	$html .= wps_deals_show_field_begin( $field );
	
	if( ! empty( $meta ) ) {
		$nonce = wp_create_nonce( 'at_ajax_delete' );
		$html .= '<div style="margin-bottom: 10px"><strong>' . __( 'Uploaded files', 'wpsdeals' ) . '</strong></div>';
		$html .= '<ol class="wps-deals-meta-upload">';
		
			foreach( ( array )$meta[0] as $key => $att ) {
				// if (wp_attachment_is_image($att)) continue; // what's image uploader for?
				$html .= "<li>" . wp_get_attachment_url( $att) . " (<a class='wps-deals-meta-delete-file' href='#' rel='{$nonce}|$key|{$field['id']}|{$att}'>" . __( 'Delete', 'wpsdeals' ) . "</a>)</li>";
			}
		$html .= '</ol>';
	}

	// show form upload
	$html .= "<div class='wps-deals-meta-file-upload-label'>";
	$html .= "<strong>" . __( 'Upload new files', 'wpsdeals' ) . "</strong>";
	$html .= "</div>";
	$html .= "<div class='new-files'>";
	$html .= "<div class='file-input'>";
	$html .= "<input type='file' name='{$field['id']}[]' class=' {$field['class']} ' />";
	$html .= "</div><!-- End .file-input -->";
	$html .= "<a class='wps-deals-meta-add-file button' href='#'>" . __( 'Add more files', 'wpsdeals' ) . "</a>";
	$html .= "<div class='clear'></div>";
	$html .= "</div><!-- End .new-files -->";
	
	$html .= wps_deals_show_field_end( $field );
	
	if($echo) {
		echo $html;
	} else {
		return $html;
	}
}
?>