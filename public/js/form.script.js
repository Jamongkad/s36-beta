$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			close_lightbox();
		}
	});

	$(document).ready(function(){

		$('#fb-login').click(function(){
			FB.login(function(response) {
			   if (response.authResponse) {
			    FB.api('/me', function(response) {
			       fb_connect_success(response);
			       $('#loginType').val('fb');
			     });
			   }
			},{scope:"email,user_location,user_website,user_work_history,user_photos"});
		});

		$('#in-login').click(function(){
			IN.User.authorize(function(q){
				IN.API.Profile("me")
				.fields(["id", "firstName", "lastName","email-address","positions","location", "pictureUrl", "publicProfileUrl"])
    			.result(function(user){
    				$('#loginType').val('ln');
    				user = user.values[0];
    				if(undefined != user.id){
    					var url = 'http://www.linkedin.com/profile/view?id='+user.id;
    					$('#profileLink').val(url);
    				}
    				
					if(undefined != user.firstName){
	            		$('#your_fname').val(user.firstName);
	            		$('#your_fname').removeClass('default-text');
	            	}
	            	if(undefined != user.lastName){
	            		$('#your_lname').val(user.lastName);
	            		$('#your_lname').removeClass('default-text');
	            	}
	            	
	            	if(undefined != user.emailAddress){
	            		$('#your_email').val(user.emailAddress);
	            		$('#your_email').removeClass('default-text');
	            	}

	            	if(undefined != user.positions){
	            		$.each(user.positions.values,function(){
	            			if(this.isCurrent==true){
	            				$('#your_company').val(this.company.name);
	            				$('#your_occupation').val(this.title);
	            			}
	            		});
	            		$('#your_occupation').removeClass('default-text');
	            		$('#your_company').removeClass('default-text');
	            	}
	            	
	            	if(undefined != user.location){
				    	$('#your_city').val(user.location.name);
	            		$('#your_country').val(user.location.country.code);
	            		$('#your_city').removeClass('default-text');
	            		$('#your_country').removeClass('default-text');
	            	}
	            	if(undefined != user.pictureUrl){
	            		$('#preview_photo').attr('src',user.pictureUrl)
	            	}
	            	
				});
			});
			return false;
		});
		$('#tw-login').click(function(){
			  $.oauthpopup({
	            path: '/socialnetwork/twitter',
	            callback: function(){
	            	$('#loginType').val('tw');
	            	$.ajax({
		            url: "/socialnetwork/twitter/userinfo",
		            type: "GET",
			            success: function(data) {
			            	var user = $.parseJSON(data);
			            	if(undefined != user.screen_name){
			            		var url = 'https://twitter.com/'+user.screen_name;
    							$('#profileLink').val(url);
			            	}
			            	if(undefined != user.name){
			            		var name = user.name.split(" ");
			            		$('#your_fname').val($.trim(name[0]));
			            		$('#your_lname').val($.trim(name[1]));
			            		$('#your_fname').removeClass('default-text');
			            		$('#your_lname').removeClass('default-text');
			            	}
			            	if(undefined != user.location){
			            		var location = user.location.split(","); 
						    	$('#your_city').val($.trim(location[0]));
			            		$('#your_country').val($.trim(location[1]));
			            		$('#your_city').removeClass('default-text');
			            	}
			            	if(undefined != user.profile_image_url){
			            		$('#preview_photo').attr('src',user.profile_image_url)
			            	}
			          }
			        });
	            }});
		});

		function submit_feedback(){

			var company, position, website, form_metadata;

			/*get empty values for optional fields with default value*/
			if(!$('#your_company').hasClass('default-text')){
				var company = $('#your_company').val();
			}
			if(!$('#your_occupation').hasClass('default-text')){
				var position = $('#your_occupation').val();
			}
			if(!$('#your_website').hasClass('default-text')){
				var website = $('#your_website').val();
			}
            
            //metadata form collection
            var form_metadata = $(".form-custom-fields").find(":checked, :selected, :text, textarea").map(function() {
                if(this.value) { 
                    if($(this).attr('title') != $(this).val()) {
                        var meta = {
                            'name'  : ($(this).attr('name')) ? $(this).attr('name') : $(this).parent('select').attr('name')
                          , 'value' : $(this).val()
                          , 'type'  : ($(this).attr('type')) ? $(this).attr('type') : "select"
                        };
                        return meta; 
                    }
                }
            }); 

			/*start creating attachment array*/
			//getattached images first
			var uploaded_images = new Array;
			$('#review-images .e_img_check').each(function(){
				uploaded_images.push({
					'url'		   :$(this).find('.img-url').val(),
					'small_url'	   :$(this).find('.img-small-url').val(),
					'medium_url'   :$(this).find('.img-medium-url').val(),
					'large_url'	   :$(this).find('.img-large-url').val()
				});
			});
			//get attached link data
			if($('#hasLink').val() == 1) {
				var attachedLink = {
					title			: $('#link-title').val(),
					description		: $('#link-description').val(),
					image			: $('#link-image').val(),
					url		        : $('#link-url').val(),
					video			: $('#link-video').val(),
				};
			}

			//build attached link and uploaded images array
			var attachments = {
                'attached_link'		:attachedLink,
                'uploaded_images'	:uploaded_images
			};
			/*end attachment*/

            //collect  all data plus attachment data
            var form_data = {
                site_id		: $('#siteId').val(),
                company_id	: $('#companyId').val(),
                title           : $('#feedbackTitle').val(),
                feedback 	: $('#feedbackText').val(),
                rating 		: $('#rating').val(),
                recommend 	: $('#recommend').val(),
                first_name	: $('#your_fname').val(),
                last_name	: $('#your_lname').val(),
                email 		: $('#your_email').val(),
                city 		: $('#your_city').val(),
                country 	: $('#your_country').val(),
                login_type	: $('#loginType').val(),
                profile_link    : $('#profileLink').val(),
                avatar 		: $('#preview_photo').attr('src'),
                avatar_filename	: $('#avatar_filename').val(),
                permission	: $('#your_permission').val(),
                company 	: company,
                position 	: position,
                website 	: website,
                attachments     : attachments,
                metadata        : $.makeArray(form_metadata)
            }            

            /*submit all data for server side scripting*/
            $.ajax({
                type: "POST",
                url: "/submit_feedback",
                dataType: "json",
                data: form_data, 
                success: function(q) {
                    $('.facebook-share-bar').html(q.share_button);
                    $('.twitter-share-bar').html(q.tweet_button);
              }
            }); 
		}

		 function fb_connect_success(obj){
   
			  if(obj.location != undefined) {
			      if(obj.location.name != undefined) {
                      var loc = obj.location.name;
                      var mylocation = loc.split(","); 

                      $('#your_city').val( $.trim(mylocation[0]) );
                      $('#your_city').removeClass('default-text');
                      $('#your_country option').filter(function() { return $.trim($(this).text()) === $.trim(mylocation[1]); }).attr('selected', 'selected');
                  }
			  }
 
			  if(obj.first_name != undefined){
			   $('#your_fname').val( $.trim(obj.first_name) );
			   $('#your_fname').removeClass('default-text');
			  }
			  if(obj.last_name != undefined){
			   $('#your_lname').val( $.trim(obj.last_name) );
			   $('#your_lname').removeClass('default-text');
			  }
			  if(obj.email != undefined){
			   $('#your_email').val( $.trim(obj.email) ); 
			   $('#your_email').removeClass('default-text');
			  }
			  if(obj.work != undefined){
			   if(obj.work[0].employer != undefined){
			    if(obj.work[0].employer.name != undefined){
			     $('#your_company').val( $.trim(obj.work[0].employer.name) ); 
			     $('#your_company').removeClass('default-text');
			    }
			   }
			   if(obj.work[0].position != undefined){
			    if(obj.work[0].position.name != undefined){
			     $('#your_occupation').val( $.trim(obj.work[0].position.name) ); 
			     $('#your_occupation').removeClass('default-text');
			    }
			   }
			  }
			  if(obj.website != undefined){
			   var site = $.trim(obj.website);
			   var matches = site.split(/\r/);//explode the string
			   site = matches.length > 0 ? matches[0] : ""; // put it inside
			   $('#your_website').val( site );
			   $('#your_website').removeClass('default-text');
			  }

			  var photo = 'http://graph.facebook.com/'+obj.id+'/picture?type=large';
			  $('#profileLink').val(obj.link);
			  $('#preview_photo').attr('src',photo);
			  $('#fb_flag').val("1");
		}

		
		//initialize the link preview script!
		$('#feedbackText').linkPreview();
		$('#textEditor').linkPreview();
		//initialize the file upload script! 
		$('#file_uploader').fileupload({
			dropZone: $('#drag-and-drop-area'),
			dataType: 'json',
			add: function(e, data){
				var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
				if( image_types.indexOf( data.files[0].type ) == -1 ){
					var error = ['Please select an image file'];
					display_error_mes(error);
					return false;
				}
				if( data.files[0].size > 2000000 ){
					var error = ['Please upload an image that is less than 2mb'];
					display_error_mes(error);
					return false;
				}
				var max_upload = data.originalFiles.length + $('#uploaded_images_preview .e_img_check').length;
				if(max_upload > 3){
					var error = ['You can only upload up to 3 images'];
					display_error_mes(error);
					return false
				}
				data.submit();
			},progress: function(e, data){
				$('.upload-preview').show('fast');
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('.upload-preview').last().find('.progress-shade').css('width', progress + '%');
			},done: function(e, data){
				$('.upload-preview').hide('fast');
				// append the new images to the html sync it with the review page::
				$('#uploaded_images_preview')
					.append(
						$('<div />')
							.addClass('image-thumb e_img_check')
							.append($('<div class="thumb-img-close"></div>').attr('data-url',data.result[0].delete_url ))
							.append($('<img />').attr({'src':data.result[0].small_url,'width':'100%'}))
							.append($('<input type="hidden" class="img-url"/>').val(data.result[0].url))
							.append($('<input type="hidden" class="img-large-url"/>').val(data.result[0].large_url))
							.append($('<input type="hidden" class="img-medium-url"/>').val(data.result[0].medium_url))
							.append($('<input type="hidden" class="img-small-url"/>').val(data.result[0].small_url))
							); 
				$('#review-images')
					.append(
						$('<div />')
							.addClass('image-thumb e_img_check')
							.append($('<div class="thumb-img-close"></div>').attr('data-url',data.result[0].delete_url ))
							.append($('<img />').attr({'src':data.result[0].small_url,'width':'100%'}).addClass('attachment'))
							.append($('<input type="hidden" class="img-url"/>').val(data.result[0].url))
							.append($('<input type="hidden" class="img-large-url"/>').val(data.result[0].large_url))
							.append($('<input type="hidden" class="img-medium-url"/>').val(data.result[0].medium_url))
							.append($('<input type="hidden" class="img-small-url"/>').val(data.result[0].small_url))
							);
				
				//resize the textbox when done
				scale_feedback_textbox();
				
				//assign close function for each thumbnails
				init_thumbnail_close_btn();
				
				//close the file upload window
				close_file_upload();			}
		});
		// initialize the photo upload script
		$('#your_photo').fileupload({
			dataType: 'json',
			add: function(e, data){
				console.log('in add');
				var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
				if( image_types.indexOf( data.files[0].type ) == -1 ){
					var error = ['Please select an image file'];
					display_error_mes(error);
					return false;
				}
				if( data.files[0].size > 2000000 ){
					var error = ['Please upload an image that is less than 2mb'];
					display_error_mes(error);
					return false;
				}
				data.submit();
			},progress: function(e, data){
				$('.loading-box').fadeIn('fast');
				// delete old photo if the user decides to upload a new one.
				var delete_url = $('#preview_photo').attr('data-url');
				if(delete_url){
					$.post(delete_url);
				}
			},done: function(e, data){
				console.log(e);
				console.log(data);
				$('<img />')
					.attr('src', data.result[0].url)
					.load(function(e){
						var max_ht = 105;
						var img_ht = e.currentTarget.height;
						var margin = 0;
						if(img_ht > max_ht){
							margin = 10;
						}
						$('.loading-box').fadeOut('fast');
						$('#preview_photo').attr({'src':data.result[0].url,'data-url':data.result[0].delete_url}).css('margin-top','-'+margin+'px');
						$('#avatar_filename').val(data.result[0].name);
				});
			}
		});
		
		// initiate the cycle script for the #steps div
		var $steps = $('#formBody').cycle({  fx: 'fade', speed: 100, timeout: 0, before: assign_class });	
		/* clicking back and next buttons */
		$('#next').click(function(){
			var cur_page = $('.current').attr('id');
			if(cur_page == 'step1'){
                /*
				if(validate_feedback()) {
					$steps.cycle('next');
				}
                */
				if(FormValidatePageOne.validate()) {
					$steps.cycle('next');
				}
			}else if(cur_page == 'step2'){
				if(validate_form()) {
					scale_review_textbox();
					synchronize_inputs();
					$steps.cycle('next');
				}
			}else if(cur_page == 'step3'){
				if(push_to_last_window()){
					$steps.cycle('next');
					submit_feedback();
				}
			}
		});
		$('#back').click(function(){
			$steps.cycle('prev');
		});
		/* ========================
		   
		   Below is Rating Function found on the form page.
		   
		   -Pass a variable to the hidden input when a star is clicked.
		   -Check console.log for details.
		   
		   ========================*/
		   
		$('.dynamic-stars .star-container .star').hover(function(){
			var index = $(this).index();
			var rating = "";
			$('.star-container .star').css('background-position','bottom');
			$(this).css('background-position','top');
			rating = convert_rating_to_text(index);
			$('.star-text span').html(rating);
			for(var i = 0;i<index;i++){
				$(this).parent().find('.star:eq('+i+')').css('background-position','top');
			}
			
		},function(){
			var current_rating = $('#rating').val();
			var rating = convert_rating_to_text(current_rating - 1);
			$('.star-text span').html(rating);
			$('.star-container .star').css('background-position','bottom');
			for(var i = 0;i<current_rating;i++){
				$('.star-container').find('.star:eq('+i+')').css('background-position','top');
			}
		}).click(function(){
			// send the rating value to the rating plugin
			var index = $(this).index() + 1;
			console.log('you sent a '+index+' star rating');
			$('#rating').val(index);
		});
		
		/* assign default text on the input fields */
		default_text('.feedback-textarea');
		default_text('.registration-input');
		default_text('.regular-custom-field');

		$('#recommend-checkbox').click(function(){
			if($('#recommend').val() == 1){
				$('#recommend').val(0);
			}else{
				$('#recommend').val(1);
			}
			$(this).toggleClass('checked');
		});
		$('#permission-checkbox').click(function(){
			if($('#your_permission').val() == 1){
				$('#your_permission').val(0);
			}else{
				$('#your_permission').val(1);
			}
			$(this).toggleClass('checked')
		});
		
		/* check email if valid on blur */
		$('#your_email').blur(function(){
			if(!validate_field( $(this).attr('id')   , $(this).val()   , $(this).attr('title')   , "email")){
				display_error_mes(['Please Enter A Valid Email']);
				}
		});
		
		$('.fullscreen-icon,#edit_text_link').click(function(){
			display_text_editor();
		});
		
		init_thumbnail_close_btn();
		scale_feedback_textbox();
	});
	// end of document ready function
	
	function adjust_feedback_textbox_height(val){
		$('#feedbackText').animate({'height':val,'width':357},100);
	}
	function adjust_review_textbox_height(val){
		$('#review-feedback-text').animate({'height':val},100);
	}
	function assign_class(){						
		$(this).parent().find('div.current').removeClass('current'); //find all div that has a current class and remove it
		$(this).addClass('current');								 //add the current class to the active div	
		display_prev_btn($(this).attr('id'));
	}
	function close_file_upload(){
		$('#lightbox-upload-s').fadeOut('fast');
		$('#lightbox-upload-photo-container').fadeOut('fast');
	}
	function close_lightbox(){
		$('#lightbox-s').fadeOut('fast');
		$('#lightbox').fadeOut('fast');
		return 0;
	}
	function close_text_editor(){
		if(validate_feedback($('#textEditor'))){
			$('#lightbox-text-editor-container').fadeOut();
			$('#lightbox-editor-s').fadeOut();
			$('#feedbackText').val($('#textEditor').val());
			$('#review-feedback-text p').html($('#textEditor').val());
			return 0;
		}
	}
	function convert_rating_to_text(val){
		var rating;
		switch(val){
			case 4: rating = "Excellent!";
			break;
			case 3: rating = "Good";
			break;
			case 2: rating = "Average";
			break;
			case 1: rating = "Poor";
			break;
			case 0: rating = "Bad";
			break;
			default: rating = "";
			break;
		}
		return rating;
	}

	function default_text(elem){
		$(elem).focus(function(e){
			if ($(this).val() == $(this)[0].title){
				$(this).removeClass("default-text");
				$(this).val("");
			}
		});
		
		$(elem).blur(function(){
			if ($(this).val() == ""){
				$(this).addClass("default-text");
				$(this).val($(this)[0].title);
			}
		});
		$(elem).blur();   
	}

	function display_error_mes(mes){
		$('.lightbox-message').addClass('error');
		$('.lightbox-message ul').html('').each(function(){
			$.each(mes,function(e,str){
				$('.lightbox-message ul').append('<li>'+str+'</li>');	
			});

		});
		display_lightbox();
	}
	function display_loading(bool){
		if(bool)
		$('.loading-box').fadeIn('fast');
		else
		$('.loading-box').fadeOut('fast');
	}

	function display_lightbox(){
		$('#lightbox').fadeIn();
		$('#lightbox-s').fadeIn();
		return false;
	}

	function display_text_editor(){
		$('#lightbox-text-editor-container').fadeIn('fast');
		$('#lightbox-editor-s').fadeIn('fast');
		$('#textEditor').focus();
		$('#textEditor').val($('#feedbackText').val());
		return false;
	}
	function display_prev_btn(elem){
		var back_btn = $('#back');
		switch (elem){
			case "step1": back_btn.fadeOut();
			break;
			case "step2": back_btn.fadeIn();
			break;
			case "step3": back_btn.fadeIn();
			break;
			case "step4": back_btn.fadeOut();
			break;
			default: back_btn.fadeOut();
			break;
		}
	}
	function init_file_upload(){
		$('.upload-preview').hide();
		if($('#uploaded_images_preview .e_img_check').length >= 3){
			var error = ['You can only upload up to 3 photos'];
			display_error_mes(error);
			return false;
		}else{
			$('#lightbox-upload-s').fadeIn('fast');
			$('#lightbox-upload-photo-container').fadeIn('fast');
		}
	}
	function init_thumbnail_close_btn(){
		$('.thumb-img-close').click(function(){
			var index = $(this).parent().index();
			var review_image_container = $('#review-images');
			var upload_image_container = $('#uploaded_images_preview');
			var delete_url = $(this).attr('data-url');
			console.log(delete_url);
			$.post(delete_url);
			$(this).parent().fadeOut('fast',function(){
				review_image_container.children().eq(index).remove();
				upload_image_container.children().eq(index).remove();
				scale_feedback_textbox();
				scale_review_textbox();
			});
		});
	}	
	function init_thumbnail_vid_close_btn(){
		$('.thumb-vid-close').click(function(){
			$('.thumb-vid-close').parent().parent().fadeOut('fast',function(){
				$(this).remove();
				scale_feedback_textbox();
				scale_review_textbox();
			});
		});
	}	
	function input_is_default_val(elem){
		if($.trim(elem.attr('title')) == $.trim(elem.val())){
			return true;
		}else{
			return false;
		}
	}
	function get_proper_string(elem1,elem2){
		
		var text1 = '';
		var text2 = '';
		
		if(elem1.val().length > 0 && !input_is_default_val(elem1)){
			text1 = elem1.val();
		}
		if(elem2.val().length > 0 && !input_is_default_val(elem2)){
			text2 = elem2.val();
		}
		
		if(text1.length > 0 && text2.length > 0){
			return text1+', '+text2;
		}else if(text1.length == 0 && text2.length > 0){
			return text2;
		}else{
			return text1;
		}
	}

	function push_to_last_window(){
		$('#all-done-textbox').html($('#feedbackText').val());
		$('#back').fadeOut('fast');
		$('#next').fadeOut('fast');
		return true;
	}

    var FormValidatePageOne = new function() {
 
        var me = this;

        this.validate = function() {
            return me.validate_feedbacktext();
        }
       
        this.validate_feedbacktext = function() {
            return false;    
        }
    }

	function validate_feedback(elem) {

		if(!elem) {
			var feedback_elem = $('#feedbackText');	
		} else {
			var feedback_elem = elem;	
		}

		var validated = false;
		var feedback_text = $.trim(feedback_elem.val());
		var error_mes = [];
		if((feedback_text.length <= 0) || (feedback_text == feedback_elem.attr('title'))) {
			error_mes = ['Please Enter A Feedback'];
			display_error_mes(error_mes);
			return false;
		} else {
			return true;
		}

	}

	function validate_email(email) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
		return true;
		}else{
		return false;
		}
	}
	function validate_field(fieldid,value,default_val,type){
		if(type == "regular"){   // check if type is only regular
			if((value.length <= 0) || (value == default_val)){		
				return false;
			}else{
				return true;
			}
		}else if(type == "email"){ //if type is email
			if((value.length <= 0) || (value == default_val)){
				return false;
			}else if(!validate_email(value)){
				return false;	
			}else{
				return true;
			}
		}else if(type == "phone"){
			//phone only allows '+',','," " and numeric values 
			var phone = new RegExp('[+0-9 ,]');
			var notallow = new RegExp('[a-zA-Z]');
			if((!value.match(phone)) || (value.match(notallow))){
				return false;
			}else{
				return true;
			}
		}else if(type == "numeric"){
			//strictly allows numeric values only
			var numeric = new RegExp('[0-9 ]');
			var notallow = new RegExp('[a-zA-Z]');
			if((!value.match(numeric)) || (value.match(notallow))){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	function validate_form(){		
		if($('#formBody').find('.current').attr('id') == "step2"){
			var fname 		= $('#your_fname'); 
			var lname 		= $('#your_lname'); 
			var email		= $('#your_email');
			var city 		= $('#your_city');
			var country 	= $('#your_country');
			if(!validate_field(fname.attr('id'),fname.val(),fname.attr('title'), "regular")){
				fname.focus();
				display_error_mes(['Please Enter Your First Name']);
				return false;
			}else if(!validate_field( lname.attr('id')   , lname.val()   , lname.attr('title')   , "regular")){
				lname.focus();
				display_error_mes(['Please Enter Your Last Name']);
				return false;
			}else if(!validate_field( email.attr('id')   , email.val()   , email.attr('title')   , "email")){
				email.focus();
				display_error_mes(['Please Enter A Valid Email']);
				return false;
			}else if(!validate_field( city.attr('id')    , city.val()    , city.attr('title')    , "regular")){
				city.focus();
				display_error_mes(['Please Enter Your City']);
				return false;
			}else if(!validate_field( country.attr('id') , country.val() , country.attr('title') , "regular")){
				country.focus();
				display_error_mes(['Please Select Your Country']);
				return false;
			}else{
				return true;
			}
		}
	}

	function scale_feedback_textbox(){
        /* set the default textbox height px */
        var default_ht = 280;
        /* set heights of the elements by px */
        var im = 78; // image container
        var vd = 68; // video container
        var cf_box_ht = $('.form-custom-fields').height();


        var active_im = $('.e_img_check').length;
        var active_vd = $('.e_vid_check').length;

        /* conditions */

        if(active_im && !active_vd){
            adjust_feedback_textbox_height(default_ht - (cf_box_ht + im));
        }else if(active_im && active_vd){
            adjust_feedback_textbox_height(default_ht - (cf_box_ht + im + vd));
        }else if(!active_im && active_vd){
            adjust_feedback_textbox_height(default_ht - (cf_box_ht + vd));
        }else{
            adjust_feedback_textbox_height(default_ht - cf_box_ht);
        }
	}

	function scale_review_textbox(){

		/* set the default textbox height px */
		var default_ht = 180;
		var im = 78; // image container
		var vd = 75; // video container
		/* check if containers are active */
		var active_im = $('#review-images .e_img_check').length;
		var active_vd = $('#review-videos .e_vid_check').length;
		/* conditions */
		if(active_im && !active_vd){
			adjust_review_textbox_height(default_ht - im);
		}else if(active_im && active_vd){
			adjust_review_textbox_height(default_ht - (im + vd));
		}else if(!active_im && active_vd){
			adjust_review_textbox_height(default_ht - vd);
		}else{
			adjust_review_textbox_height(default_ht);
		}
		
		
	}
	function synchronize_inputs(){
		
		var feedback_text = $('#feedbackText').val();
		var recommend = $('#recommend').val();
		var fname = $('#your_fname').val();
		var lname = $('#your_lname').val();
		var email = $('#your_email').val();
		var city = $('#your_city');
		var country = $('#your_country');
		var company = $('#your_company');
		var occupation = $('#your_occupation');
		var website = $('#your_website').val();
		var profile_img = $('#preview_photo').attr('src');
		var permission = $('#your_permission').val();
		
		var company_position = get_proper_string(occupation,company);
		var city_country = get_proper_string(city,country);
		var flag = $('#flag');
		flag.removeClass().addClass('flag flag-'+country.val());
		
		$('#review_photo').attr('src',profile_img);
		$('#review-name').html(fname+" "+lname);
		$('#review-company').html(company_position);
		$('#review-location').html(city_country);
		$('#review-feedback-text').html('<p>'+feedback_text+'</p>');
		
		if(permission == 1){
			$('#review-permission').show();
		}else{
			$('#review-permission').hide();
		}
		init_thumbnail_close_btn();
		scale_review_textbox();
	}
