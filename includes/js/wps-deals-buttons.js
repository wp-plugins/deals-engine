// JavaScript Document
jQuery(document).ready(function($) {
//Start Shortcode Popup
(function() {
    tinymce.create('tinymce.plugins.wpsdealsengine', {
        init : function(ed, url) {
        	
            ed.addButton('wpsdealsengine', {
                title : 'Social Deals Engine',  
                image : url+'/images/wps-icon.png',
                onclick : function() {
                    
					$( '.wps-deals-popup-overlay' ).fadeIn();
                    $( '.wps-deals-popup-content' ).fadeIn();
                     
                    $( '#wps_deals_shortcodes' ).val('');
                    $( '#wps_deals_insert_container' ).hide();
 				}
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
 
    tinymce.PluginManager.add('wpsdealsengine', tinymce.plugins.wpsdealsengine);
})();
	
	//close popup window
	$( '.wps-deals-close-button, .wps-deals-popup-overlay' ).live( 'click',function (){
		
		$( '.wps-deals-popup-overlay' ).fadeOut();
        $( '.wps-deals-popup-content' ).fadeOut();
        
	});
	
	//show insert shortcode buttons
	$( '#wps_deals_shortcodes' ).on( 'change',function() {
		
		if( $( this ).val() != '') {
			$( '#wps_deals_insert_container' ).show();
			$( '.wps-deals-shortcodes-options').hide();
			
			switch ( $( this ).val() ) {
				
				case 'wps_deals_by_category'	:
						
						$( '#wps_deals_by_category_options' ).show();
						break;
				
			}
			
		} else {
			
			$( '#wps_deals_insert_container' ).hide();
			$( '.wps-deals-shortcodes-options').hide();
		}
		
	});
	
	
	$('#wps_deals_insert_shortcode').live('click',function(){
		
		var dealsshortcode = $('#wps_deals_shortcodes').val();
		var dealsshortcodestr = '';
			
			if(dealsshortcode  != '') {
				
				wpsDealsSwitchDefaultEditorVisual();
				
				switch(dealsshortcode) {
					
					case 'wps_deals_by_category'	:
								var catid = $( '#wps_deals_category_id' ).val();
								dealsshortcodestr	+= '['+dealsshortcode+' category="'+catid+'"][/'+dealsshortcode+']';
								break;
					case 'wps_deals' 				:
					case 'wps_deals_checkout' 		:
					case 'wps_deals_order_complete' :
					case 'wps_deals_order_cancel' 	:
					case 'wps_deals_orders'			:
					
								dealsshortcodestr	+= '['+dealsshortcode+'][/'+dealsshortcode+']';
								break;
					default:
									break;
				}
			 	
			 	 //send_to_editor(str);
		        tinymce.get('content').execCommand('mceInsertContent',false, dealsshortcodestr);
		  		jQuery('.wps-deals-popup-overlay').fadeOut();
				jQuery('.wps-deals-popup-content').fadeOut();
		}
		
	});
});
//switch wordpress editor to visual mode
function wpsDealsSwitchDefaultEditorVisual() {
	if (jQuery('#content').hasClass('html-active')) {
		switchEditors.go(editor, 'tinymce');
	}
}