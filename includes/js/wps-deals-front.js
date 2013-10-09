var dealstimeflag='';
jQuery(document).ready(function($){
	
	//code for count down timer
	if(dealstimeflag != '') { //check time flag to run the timer
		wpsdealscountdown(year,month,day,hour,minute);
	}
	
	jQuery('.wps-deals-navdeal').removeClass('wps-deals-nav1').removeClass('wps-deals-nav2');
	jQuery('div.wps-deals-list:first').show();
	
	jQuery('.wps-deals-active').live('click',function(){
		jQuery('.wps-deals-navdeal span').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.wps-deals-navdeal').removeClass('wps-deals-nav1').removeClass('wps-deals-nav2');
		jQuery(this).parent().parent().children('div.wps-deals-list').hide();
		jQuery('.wps-deals-active').show();
	});
	
	jQuery('.wps-deals-ending-soon').live('click',function(){
		jQuery('.wps-deals-navdeal span').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.wps-deals-navdeal').addClass('wps-deals-nav1');
		jQuery('.wps-deals-navdeal').removeClass('wps-deals-nav2');
		jQuery(this).parent().parent().children('div.wps-deals-list').hide();
		jQuery('.wps-deals-ending-soon').show();
	});
	
	jQuery('.wps-deals-upcoming-soon').live('click',function(){
		jQuery('.wps-deals-navdeal span').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.wps-deals-navdeal').addClass('wps-deals-nav2');
		jQuery('.wps-deals-navdeal').removeClass('wps-deals-nav1');
		jQuery(this).parent().parent().children('div.wps-deals-list').hide();
		jQuery('.wps-deals-upcoming-soon').show();
	});
	
	//add to cart button click
	$('.wps-deals-add-to-cart-button').live('click',function() {
		
		$('.wps-deals-add-to-cart-button').hide();
		
		var postid = $(this).closest('.wps-deals-product-btn').find('.wps-deals-id').val();
		
		var data = {
						action	:	'deals_add_to_cart',
						dealid	:	postid
					};
					
		$('.wps-deals-cart-process-show').show();
		$('.wps-deals-cart-loader').show();
		$.post(Wps_Deals.ajaxurl,data,function(response) {
			//alert(response);
			$('.wps-deals-cart-loader').hide();
			
			result = $.parseJSON(response);
			
			if(result.success == '1') {
				$('.wps-deals-cart-msg').show();
				$('.wps-deals-checkout').show();
				if(result.widgetcontent != undefined && $('.wps-deals-latest-widget').length > 0) { //check widget is activated
					$('.wps-deals-latest-widget').html(result.widgetcontent);
				}
				if(result.redirectstat != '0') {
					//window.location = result.redirect;
					wps_deals_reload( result.redirect );
				}
			} else {
				$('.wps-deals-cart-msg').show();
				$('.wps-deals-cart-msg').html(result.error);
			}
		});
	});
	
	//remove product from cart
	$('.wps-deals-cart-item-remove').live('click', function() {
		
		var details = $('.wps-deals-cart-details');
		var loader = $('.wps-deals-cartdetails-loader');
		var itemid = $(this).attr('item-id');
		var message = $('.wps-deals-cart-success');
		var error = $('.wps-deals-cart-error');
		
		error.hide();
		error.html('');
		
		message.hide();
		message.html('');
		
		var data = {
						action	:	'deals_remove_to_cart',
						dealid	:	itemid
					}
					
		loader.show();
		$.post(Wps_Deals.ajaxurl,data,function(response){
			
			//alert(response);
			var result = $.parseJSON( response );
			
			loader.hide();
			var cartdetails = $( result.detail ).filter( '.wps-deals-cart-details' ).html();
			
			if(result.success == '1') {
				
				message.fadeIn();
				message.html(result.message);
				
				if(result.empty == '1') {
					$('.wps-deals-cart-wrap').html( cartdetails );
				} else {
					details.html( cartdetails );	
					$('.wps_deals_cart_total').html( result.total );
				}
				
			}
			
		});
	});
	
	//remove product from cart
	$('.wps-deals-cart-item-update').live('click', function() {
		
 		var loader = $('.wps-deals-cartdetails-loader');
		var details = $('.wps-deals-cart-details');
		var message = $('.wps-deals-cart-success');
		var button = $(this);
		var error = $('.wps-deals-cart-error');
		
		error.hide();
		error.html('');
		
		message.hide();
		message.html('');
		
		
		var qtystr = '';
		
		$('.wps-deals-cart-item-qty-value').each(function(){
			
			qtystr += $(this).val()+',';
			
		});
		
		var data = {
						action	:	'deals_update_to_cart',
						qtystr	:	qtystr
					};
		
		loader.show();
		$.post(Wps_Deals.ajaxurl,data,function(response) {
			
			//alert(response);
			var result = $.parseJSON(response);
			
			loader.hide();
			
			var cartdetails = $( result.detail ).filter( '.wps-deals-cart-details' ).html();
			
			if(result.success == '1') {
				
				details.html( cartdetails );
				message.fadeIn();
				message.html(result.message);
				
				$('.wps_deals_cart_total').html(result.total);
				
			} else if(result.empty == '1') {
				
				$('.wps-deals-cart-wrap').html( cartdetails );
				
				message.fadeIn();
				message.html(result.message);
			}
			
		});
		
	});
	
	//empty cart
	$('.wps-deals-cart-empty').live('click', function() {
		
		var details = $('.wps-deals-cart-details');
		var loader = $('.wps-deals-cartdetails-loader');
		var button = $(this);
		var message = $('.wps-deals-cart-success');
		var error = $('.wps-deals-cart-error');
		
		error.hide();
		error.html('');
		
		message.hide();
		message.html('');
		
		var data = {
						action	:	'deals_empty_cart'
					};
		
		//details.hide();
		loader.show();
		//button.hide();
		
		$.post(Wps_Deals.ajaxurl,data,function(response) {
			loader.hide();
			
			if(response != '0') {
				
				var cartdetails = $( response ).filter( '.wps-deals-cart-details' ).html();
				$('.wps-deals-cart-wrap').html(cartdetails);
				
			}
		});
	});
	
	//checkout validation
	$('.wps-deals-checkout-btn').live('click',function() {
		
		if(!$(this).hasClass('wps-deals-login-button-submit') 
			&& !$(this).hasClass('wps-deals-reg-button-submit')) {
			
			var error = false;
			var errorstr = '';
			var emailerror 	= false;
			var errel		= $('.wps-deals-cart-user-error');
			var email 		= $('#wps_deals_cart_user_email').val();
			var firstname 	= $('#wps_deals_cart_user_first_name').val();
			var lastname 	= $('#wps_deals_cart_user_last_name').val();
			var terms 		= $('#wps_deals_checkout_agree_terms'); 
			var gateway		= $('#wps_deals_payment_gateways').val();
			
			//hide errors when click on button
			errel.hide();
			errel.html('');
		
			if(gateway == '') {
				error = true;
				errorstr += Wps_Deals.no_payment_selected;
				$('#wps_deals_payment_gateways').addClass('error').removeClass('valid');
			}
			 
			if(email == '') { // check email
				error = true;
				errorstr += Wps_Deals.cart_email_blank;
				$('#wps_deals_cart_user_email').addClass('error').removeClass('valid');
			} else {
				emailerror = wps_deals_valid_email(email);
				if(emailerror != true) {
					error = true;
					errorstr += Wps_Deals.cart_email_invalid;
					$('#wps_deals_cart_user_email').addClass('error').removeClass('valid');
				}
			}
			
			//firstname validation
			if(firstname == '') {
				error = true;
				errorstr += Wps_Deals.cart_firstname_blank;
				$('#wps_deals_cart_user_first_name').addClass('error').removeClass('valid');
			}
			
			//last name validation
			if(lastname == '') {
				error = true;
				errorstr += Wps_Deals.cart_lastname_blank;
				$('#wps_deals_cart_user_last_name').addClass('error').removeClass('valid');
			}
			
			if(Wps_Deals.enableterms == '1' && !terms.is(':checked')) {
				error = true;
				errorstr += Wps_Deals.agree_terms;
			}
			
			if(error == true) {
				errel.fadeIn();
				if( errel.html() == '' ) {
					errel.html( errorstr );
				} else {
					errel.append( errorstr );
				}
				
				//scroll page to focus on error
				$('html, body').animate({ scrollTop: errel.offset().top - 50 }, 500);
				return false;
			}
		}
		
	});
	
	//login form submit
	$('.wps-deals-login-button-submit').live('click',function() {
		
		var error = false;
		var errorstr = '';
		var loginusername 	= $('#wps_deals_cart_login_user_name').val();
		var loginpass 		= $('#wps_deals_cart_login_user_pass').val();
		var errel 			= $('.wps-deals-cart-user-error');
		var terms 			= $('#wps_deals_checkout_agree_terms');
		var gateway			= $('#wps_deals_payment_gateways').val();
		
		//hide errors when click on button
		errel.hide();
		errel.html('');
		
		if(gateway == '') {
			error = true;
			errorstr += Wps_Deals.no_payment_selected;
			$('#wps_deals_payment_gateways').addClass('error').removeClass('valid');
		}
		
		if(loginusername == '' && loginpass == '') { //check user name and password are not empty
			error = true;
			errorstr += Wps_Deals.cart_login_user_pass_blank;
			$('#wps_deals_cart_login_user_name').addClass('error').removeClass('valid');
			$('#wps_deals_cart_login_user_pass').addClass('error').removeClass('valid');
		}
		if(loginusername == '' && loginpass != '') { //check username is empty & password is not empty
			error = true;
			errorstr += Wps_Deals.cart_login_user_blank;
			$('#wps_deals_cart_login_user_name').addClass('error').removeClass('valid');
		}
		if(loginusername != '' && loginpass == '') { //check username is not empty & password is empty
			error = true;
			errorstr += Wps_Deals.cart_login_pass_blank;
			$('#wps_deals_cart_login_user_pass').addClass('error').removeClass('valid');
		}
		
		if(Wps_Deals.enableterms == '1' && !terms.is(':checked')) {
			error = true;
			errorstr += Wps_Deals.agree_terms;
		}
		
		if(error == true) {
			errel.fadeIn();
			if( errel.html() == '' ) {
				errel.html( errorstr );
			} else {
				errel.append( errorstr );
			}
			//scroll page to focus on error
			$('html, body').animate({ scrollTop: errel.offset().top - 50 }, 500);
			return false;
		} else {
			
			var data = {
							action		:	'deals_user_login',
							username	:	loginusername,
							password	:	loginpass
					};
					
			var status;
			$.ajaxSetup({  //This will change behavior of all subsequent ajax requests!!
       		  async: false
			});		
			$.post(Wps_Deals.ajaxurl,data,function(response) {
			 	
				result = $.parseJSON( response );
				
				 if(result.success == '1') {
				 	status = true;
				} else {
					errel.fadeIn();
					errel.html(result.error);
					status = false;
				}
			});
			if(!status) {
				//scroll page to focus on error
				$('html, body').animate({ scrollTop: errel.offset().top - 50 }, 500);
				return false;
			}
		}
	});
	
	//registration form submit
	$('.wps-deals-reg-button-submit').live('click',function() {
		
		var error = false;
		var errorstr 	= '';
		var username 	= $('#wps_deals_cart_reg_user_name').val();
		var pass		= $('#wps_deals_cart_reg_user_pass	').val();
		var repass 		= $('#wps_deals_cart_reg_user_confirm_pass').val();
		var emailerror 	= false;
		var email 		= $('#wps_deals_cart_user_email').val();
		var firstname 	= $('#wps_deals_cart_user_first_name').val();
		var lastname 	= $('#wps_deals_cart_user_last_name').val();
		var errel		= $('.wps-deals-cart-user-error');
		var terms 		= $('#wps_deals_checkout_agree_terms');
		var gateway		= $('#wps_deals_payment_gateways').val();
		
		//hide errors when click on button
		errel.hide();
		errel.html('');
		
		if(gateway == '') {
			error = true;
			errorstr += Wps_Deals.no_payment_selected;
			$('#wps_deals_payment_gateways').addClass('error').removeClass('valid');
		}
		
		if(Wps_Deals.disableguest == '1') {//if guest checkout is disabled then show errors compalsary
			
			if( username == '') {
				error = true;
				errorstr += Wps_Deals.cart_must_reg;
			}
			
		}
		
		if(username != '') { //check user name is not empty
				
			if(pass == '') { //check password and retype password should not empty
				error = true;
				errorstr += Wps_Deals.cart_reg_pass_blank;
				$('#wps_deals_cart_reg_user_pass').addClass('error').removeClass('valid');
			}
			if( repass == '' ) {
				error = true;
				errorstr += Wps_Deals.cart_reg_conf_pass_blank;
				$('#wps_deals_cart_reg_user_confirm_pass').addClass('error').removeClass('valid');
			}
			if(pass != '' && repass != '' && pass != repass) {
				error = true;
				errorstr += Wps_Deals.cart_reg_same_pass;
				$('#wps_deals_cart_reg_user_pass').addClass('error').removeClass('valid');
				$('#wps_deals_cart_reg_user_confirm_pass').addClass('error').removeClass('valid');
			}
			
		} else {
			
			if(username == '' && (pass != '' || repass != '' )) {
				error = true;
				errorstr += Wps_Deals.cart_reg_user_blank;
				$('#wps_deals_cart_reg_user_name').addClass('error').removeClass('valid');
			}
			if(pass != repass) {
				error = true;
				errorstr += Wps_Deals.cart_reg_same_pass;
				$('#wps_deals_cart_reg_user_pass').addClass('error').removeClass('valid');
				$('#wps_deals_cart_reg_user_confirm_pass').addClass('error').removeClass('valid');
			}
			
		}
		
		//email validation	
		if(email == '') { //check email
			error = true;
			errorstr += Wps_Deals.cart_email_blank;
			$('#wps_deals_cart_user_email').addClass('error').removeClass('valid');
		} else {
			emailerror = wps_deals_valid_email(email);
			if(emailerror != true) {
				error = true;
				errorstr += Wps_Deals.cart_email_invalid;
			$('#wps_deals_cart_user_email').addClass('error').removeClass('valid');
			}
		}
		
		if(Wps_Deals.enableterms == '1' && !terms.is(':checked')) {
			error = true;
			errorstr += Wps_Deals.agree_terms;
		}
		
		//firstname validation
		if(firstname == '') {
			error = true;
			errorstr += Wps_Deals.cart_firstname_blank;
			$('#wps_deals_cart_user_first_name').addClass('error').removeClass('valid');
		}
		
		//last name validation
		if(lastname == '') {
			error = true;
			errorstr += Wps_Deals.cart_lastname_blank;
			$('#wps_deals_cart_user_last_name').addClass('error').removeClass('valid');
		}
		
		if(error == true) {
			errel.fadeIn();
			if( errel.html() == '' ) {
				errel.html( errorstr );
			} else {
				errel.append( errorstr );
			}
			//scroll page to focus on error
			$('html, body').animate({ scrollTop: errel.offset().top - 50 }, 500);
			return false;
		} else {
		
			if( username != '' && username != undefined 
				&& pass != ''  	&& pass != undefined 
				&& repass != '' && repass != undefined ) {
				
				var data = {
								action		:	'deals_user_register',
								username	:	username,
								password	:	pass,
								useremail	:	email,
								firstname	:	firstname,
								lastname	:	lastname
						};
						
				var status;	
				
				$.ajaxSetup({  //This will change behavior of all subsequent ajax requests!!
	       		  async: false
				});	
				
				$.post(Wps_Deals.ajaxurl,data,function(response) {
					
					result = $.parseJSON( response );
					 
					  if(result.success == '1') {
					  	//$('#wps_deals_checkout_form').submit();
					  	status = true;
					  	
					} else {
						
						errel.fadeIn();
						errel.html(result.error);
						status = false;
					}
				}); 
				
				if(!status) { 
					$('html, body').animate({ scrollTop: errel.offset().top - 50 }, 500);
					return false;
				}
			}
		}
	});
	
	//front side cart login & registration form
	$('.wps-deals-login-link').live('click',function() {
		$('.wps-deals-reg-wrap').hide();
		$('.wps-deals-guest-details').hide();
		$('.wps-deals-login-form-wrap').show();
		$('.wps-deals-cart-user-error').html('');
		$('.wps-deals-cart-user-error').hide();
		$('.wps-deals-checkout-btn').removeClass('wps-deals-reg-button-submit').addClass('wps-deals-login-button-submit');
		
	});
	//front side cart login & registration form
	$('.wps-deals-class-reg-link').live('click',function() {
		$('.wps-deals-reg-wrap').show();
		$('.wps-deals-guest-details').show();
		$('.wps-deals-login-form-wrap').hide();
		$('.wps-deals-cart-user-error').html('');
		$('.wps-deals-cart-user-error').hide();
		$('.wps-deals-checkout-btn').removeClass('wps-deals-login-button-submit').addClass('wps-deals-reg-button-submit');
	});
	
	//Update Social Count for Facebook to Database
	if ( typeof FB != 'undefined' ) { //check FB is not undefined
		
		FB.Event.subscribe("edge.create", function(href, widget){ 
			
			var wdata = new Array();
			var fbtype = '';
			
			if( widget.className != '') { //facebook button class
				
				var classname = widget.className.split(' ');
				
				if( classname[0] == 'fb-like') { //when facebook like button click
					fbtype = 'fb';
				} 
				if( classname[0] == 'fb-like-box'){ //when facebook fab page like button click
					fbtype = 'fan';
				}
			}
			
			if(widget.id != '') {
	        	wdata = widget.id.split("_");
	        }else {
				wdata[1] = '';
			} 
	        	
			var data = { 
						 	action		:	"deals_update_social_media_values",
						 	postid		:	wdata[1],
						 	type		:	fbtype
					  	};
				
			jQuery.post(Wps_Deals.ajaxurl, data, function(response) {
				//alert(response);
				if( response != '' ) {
					wps_deals_reload();
				}
			});
		});
	}
	
	//Update Social Count for Twitter to Database
	if ( typeof twttr != 'undefined' ) { //check twitter is not undefined
		
		twttr.events.bind('tweet', function(event) {	      		
	  		
	  		var pid = jQuery(event.target.parentNode).attr('data-id');
	  		var wdata = new Array();
			
			if ('tweet' == event.type ) {		      			
	        	
				if(pid != '') {
					wdata = pid.split('_');
				} else {
					wdata[1] = '';
				}
				
				var data = { 
							 	action		:	"deals_update_social_media_values",
							 	postid		:	wdata[1],
							 	type		:	'tw'
						  	};
					
				jQuery.post(Wps_Deals.ajaxurl, data, function(response) {
					
					if( response != '' ) {
						//window.location.reload();
						wps_deals_reload();
					}
					
				});
	  		}
	  	});
	}
		
	//on blur of required field
	$('.wps-deals-cart-text.wps-deals-required, .wps-deals-cart-select.wps-deals-required').live('blur',function() {
		if($(this).val() == '') {
			$(this).removeClass('valid').addClass('error');
		} else {
			$(this).addClass('valid').removeClass('error');
		}
	});
	
	//show payment description data to user on checkout page on change of payment gateways
	$( '#wps_deals_payment_gateways' ).on( 'change', function() {
		
		var paymentgateway = $( this ).val();
		
		if( $( '#wps_deals_'+paymentgateway+'_payment_description').length > 0 ) { //if check particular payment description is added then
			
			$('.wps-deals-payment-description' ).hide();
			$('#wps_deals_'+paymentgateway+'_payment_description').show();
			
		} else {
			//hide description data
			$('.wps-deals-payment-description' ).hide();
		}
	});
	
	
});
//var tz=+5; 
var montharray = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

function wpsdealscountdown(yr,m,d,hr,min){

    theyear=yr;themonth=m;theday=d;thehour=hr;theminute=min;

    //var today=new Date();
    today.setSeconds(today.getSeconds()+1);
  
    var todayy=today.getYear();
	
    if (todayy < 1000) {todayy+=1900;}

    var todaym=today.getMonth();
    
    var todayd=today.getDate();

    var todayh=today.getHours();

    var todaymin=today.getMinutes();

    var todaysec=today.getSeconds();

    var todaystring1=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec;
	
    var todaystring=Date.parse(todaystring1); //
    
    //var todaystring=Date.parse(todaystring1)+(tz*1000*60*60); 
   // alert(todaystring);
   
	
    var futurestring1=(montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min);
	
   // var futurestring=Date.parse(futurestring1)-(today.getTimezoneOffset()*(1000*60));
     var futurestring=Date.parse(futurestring1);

    var dd=futurestring-todaystring;
	
    var dday=Math.floor(dd/(60*60*1000*24)*1);
	
    //var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);
    
    var dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1);

    var dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);

    var dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);

    if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=0){

        jQuery('.wps-deals-days').text('00');

        jQuery('.wps-deals-hrs').text('00');

        jQuery('.wps-deals-mins').text('00');

        jQuery('.wps-deals-secs').text('00');
        
        return;

    }

    else {
		if(dday < 10) {
			dday = '0'+dday; 
		}
		
		if(dhour < 10) {
			dhour = '0'+dhour; 
		}
		
		if(dmin < 10) {
			dmin = '0'+dmin; 
		}
		
		if(dsec < 10) {
			dsec = '0'+dsec; 
		}
		
    	jQuery('.wps-deals-days').text(dday);

        jQuery('.wps-deals-hrs').text(dhour);

        jQuery('.wps-deals-mins').text(dmin);

        jQuery('.wps-deals-secs').text(dsec);

        setTimeout("wpsdealscountdown(theyear,themonth,theday,thehour,theminute)",1000);

    }

}
// validation of email
function wps_deals_valid_email(emailStr) {
	var checkTLD=1;
	var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom=validChars + '+';
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray=emailStr.match(emailPat);
	if (matchArray==null) {
		//alert("Email address seems incorrect (check @ and .'s)");
		return false;
	}
	var user=matchArray[1];
	var domain=matchArray[2];
	// Start by checking that only basic ASCII characters are in the strings (0-127).
	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i)>127) {
			//alert("Ths username contains invalid characters in e-mail address.");
			return false;
		}
	}
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i)>127) {
			//alert("Ths domain name contains invalid characters in e-mail address.");
			return false;
		}
	}
	if (user.match(userPat)==null) {
		//alert("The username doesn't seem to be valid in e-mail address.");
		return false;
	}
	var IPArray=domain.match(ipDomainPat);
	if (IPArray!=null) {
		for (var i=1;i<=4;i++) {
			if (IPArray[i]>255) {
				alert("Destination IP address is invalid!");
				return false;
	   		}
		}
		return true;
	}
	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat)==-1) {
			//alert("The domain name does not seem to be valid in e-mail address.");
			return false;
	   }	
	}
	if (checkTLD && domArr[domArr.length-1].length!=2 && 
		domArr[domArr.length-1].search(knownDomsPat)==-1) {
		//alert("The address must end in a well-known domain or two letter " + "country.");
		return false;
	}

	if (len<2) {
		//alert("This e-mail address is missing a hostname!");
		return false;
	}	
	return true;
}
//********************* END of function for email-id validation  ****************************//

//pagination functions

//function for ajax pagination
function wps_deals_ajax_pagination(pid){
	
	var data = {
					action: 'wps_deals_next_page',
					paging: pid
				};
		
			jQuery('.wps-deals-sales-loader').show();
			jQuery('.wps-deals-paging').hide();
			
			jQuery.post(Wps_Deals.ajaxurl, data, function(response) {
				var newresponse = jQuery(response).filter('.wps-deals-sales').html();
				jQuery('.wps-deals-sales-loader').hide();
				jQuery('.wps-deals-sales').html(newresponse);
			});	
	return false;
}

//Validate Credi Card Info
function wps_deals_validate_cc_info() {
	
	//Credit Card Validation
	if( jQuery( '.wps-deals-cc-wrap' ).is(':visible') ) {
		
		var error = false;
		var errorstr = '';
		var errel		= jQuery('.wps-deals-cart-user-error');
		var cardno 		= jQuery('#wps_deals_card_number').val();
		var cardcvc 	= jQuery('#wps_deals_card_cvc').val();
		var cardname 	= jQuery('#wps_deals_card_name').val();
		var cardexpmonth = jQuery('#wps_deals_card_exp_month').val();
		var cardexpyear = jQuery('#wps_deals_card_exp_year').val();
		
		if( cardno == '' ) {
			error = true;
			errorstr += Wps_Deals.card_no_empty;
		}
		if( cardcvc == '' ) {
			error = true;
			errorstr += Wps_Deals.card_cvc_empty;
		}
		if( cardname == '' ) {
			error = true;
			errorstr += Wps_Deals.card_name_empty;
		}
		if( cardexpmonth == '' ) {
			error = true;
			errorstr += Wps_Deals.card_exp_month_empty;
		}
		if( cardexpyear == '' ) {
			error = true;
			errorstr += Wps_Deals.card_exp_date_empty;
		}
		
		if( error == true ) {
			errel.fadeIn();
			if( errel.html() == '' ) {
				errel.html( errorstr );
			} else {
				errel.append( errorstr );
			}
		}
	}
}
//function to return url with specific parameter
function wps_deals_reload( url ) {
	
	var nowurl = '';
	var redirect = '';
	
	if( typeof url !== 'undefined' ) { //check url is set or not
		redirect = url;	
	} else {
		//current page url
		redirect = jQuery( location ).attr( 'href' );
	}
	// check caching is activated on site or not
	if( Wps_Deals.caching == '1' ) {
		
		//check ? is exist in url or not
		var strexist = redirect.indexOf("?");
		
		if( strexist >= 0 ) {
			redirect = redirect + '&no-caching';
		} else {
			redirect = redirect + '?no-caching';
		}
	}
	
	//redirect to particular url
	window.location = redirect;
}