jQuery(document).ready(function($){
	
	//apply discount codes to cart
	$('.wps-deals-cart-discount-apply').live('click', function() {
		
		var discode = $('.wps-deals-cart-discount-code').val();
		var error = false;
		var errorel = $('.wps-deals-cart-error');
		var loader = $('.wps-deals-cartdetails-loader');
		var details = $('.wps-deals-cart-details');
		var success = $('.wps-deals-cart-success');
		var errorstr = '';
		
		errorel.hide();
		errorel.html('');
		
		if(discode == '') {
			error = true;
			errorstr += Wps_Disc.code_blank;
		}
		
		if(error == true) {
			
			errorel.show();
			errorel.html(errorstr);
			return false;
			
		} else {
		
			var data = {
							action	:	'deals_apply_discounts',
							code	:	discode	
						};
			loader.show();
			
			$.post(Wps_Disc.ajaxurl,data,function(response) {
				loader.hide();
				alert(response);
				result = $.parseJSON(response);
				
				if(result.success == '1') {
					
					details.html(result.detail);
					success.fadeIn();
					success.html(result.message);
					
				} else {
					errorel.fadeIn();
					errorel.html(result.error);
					return false;
				}
			
			});
		}
	});
	
	//remove discount
	$('.wps-deals-cart-remove-discount').live('click', function() {
		
		var error = false;
		var errorel = $('.wps-deals-cart-error');
		var loader = $('.wps-deals-cartdetails-loader');
		var details = $('.wps-deals-cart-details');
		var success = $('.wps-deals-cart-success');
		var errorstr = '';
		
		loader.show();
		
		var data = {
							action	:	'deals_remove_discounts',
					};	
		
		$.post(Wps_Disc.ajaxurl,data,function(response) {
			loader.hide();
			//alert(response);
			result = $.parseJSON(response);
			
			if(result.success == '1') {
				
				details.html(result.detail);
				success.fadeIn();
				success.html(result.message);
				
			} else {
				errorel.fadeIn();
				errorel.html(result.error);
				return false;
			}
		
		});
	});
	
});