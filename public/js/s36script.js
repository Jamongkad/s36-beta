var jcrop_api;
/* 
Form interactions. Text boxes and Combo boxes style changer
*/
function default_text(){
		$(".regular-text").focus(function(i){          		 
				if ($(this).val() == $(this)[0].title){
					$(this).removeClass("reg-text-active");
					$(this).val("");
				}
			});
		$(".regular-text").blur(function(){
				if ($.trim($(this).val()) == ""){
					$(this).addClass("reg-text-active");
					$(this).val($(this)[0].title);
				}else{
					//validate_field function arguments : element ID, element's user input value, element's default value, type = regular or email
					if($(this).attr('id') == "your_fname"){																
						if(!validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
							add_error('Please Enter Your First Name');
						}else{
							hide_error();
						}
					}else if($(this).attr('id') == "your_lname"){														
						if(!validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
							add_error('Please Enter Your Last Name');
						}else{
							hide_error();	
						}
					}else if($(this).attr('id') == "your_email"){														
						if(!validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "email")){
							add_error('Please Enter A Valid Email');
						}else{
							hide_error();	
						}
					}else if($(this).attr('id') == "your_city"){														
						if(!validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
							add_error('Please Enter Your City');
						}else{
							hide_error();
						}
					}
					//show_permission();
				}
			});
		$(".regular-select").focus(function(i){
            $(this).removeClass("reg-text-active");
            if ($(this).val() != $(this)[0].title){
                $(this).removeClass("reg-text-active");
            }
        });

		$(".regular-select").blur(function(){
				if ($(this).val() == $(this)[0].title){
					$(this).addClass("reg-text-active");
					$(this).val($(this)[0].title);
				}else{
					if($(this).attr('id') == "your_country"){
						if(!validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
							add_error('Please Select Your Country');
						}else{
							hide_error();
						}
					}
					//show_permission();
				}
		});
		$(".regular-text").blur();
		$(".regular-select").blur();
}

/* 
This function will display the permission selection screen once the user has filled out the required fields
*/
function show_permission(){
		var fname 		= $('#your_fname'); 
		var lname 		= $('#your_lname'); 
		var email		= $('#your_email');
		var city 		= $('#your_city');
		var country 	= $('#your_country');
		//validate_field function arguments : element ID, element's user input value, element's default value, type = regular|email|phone|numeric
		if((validate_field( fname.attr('id')   , fname.val()   , fname.attr('title')   , "regular")) &&
		   (validate_field( lname.attr('id')   , lname.val()   , lname.attr('title')   , "regular")) &&
		   (validate_field( email.attr('id')   , email.val()   , email.attr('title')   , "email")) &&
		   (validate_field( city.attr('id')    , city.val()    , city.attr('title')    , "regular")) &&
		   (validate_field( country.attr('id') , country.val() , country.attr('title') , "regular"))){
		   $('#feedback_permission').fadeIn('fast');
		}
			
	}
function check_permission(){
		var permission = $('[name="your_permission"]:checked').size();
		if(permission <= 0){
			add_error('Please Select a Permission for your feedback');
			return false;
		}else{
			return true;
		}
	}
/*
This function validates the form and displays an error message once it detects an invalid input
*/
function validate_form(form){		

		var fname 		= $('#your_fname'); 
		var lname 		= $('#your_lname'); 
		var email		= $('#your_email');
		var city 		= $('#your_city');
		var country 	= $('#your_country');

		//validate_field function arguments : element ID, element's user input value, element's default value, type = regular|email|phone|numeric
		if(!validate_field(       fname.attr('id')    , fname.val()    , fname.attr('title')    , "regular")){
			fname.focus();
			add_error('Please Enter Your First Name');
			return false;
		}else if(!validate_field( lname.attr('id')   , lname.val()   , lname.attr('title')   , "regular")){
			lname.focus();
			add_error('Please Enter Your Last Name');
			return false;
		}else if(!validate_field( email.attr('id')   , email.val()   , email.attr('title')   , "email")){
			email.focus();
			add_error('Please Enter A Valid Email');
			return false;
		}else if((!validate_field( city.attr('id')    , city.val()    , city.attr('title')    , "regular")) && (form == "full")){
			city.focus();
			add_error('Please Enter Your City');
			return false;
		}else if((!validate_field( country.attr('id') , country.val() , country.attr('title') , "regular")) && (form == "full")){
			country.focus();
			add_error('Please Select Your Country');
			return false;
		}else{
			return 4;
		}
		
	}
	//end of validation

/*
This function validates a textfield. Parameters: ID of input tag, the value, its default value e.g: your name, type: email|numeric|regular|phone
*/
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
/*
This function checks a string if it is a valid email address
*/
function validate_email(email) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
	    return true;
	}else{
	    return false;
	}
}
/*
Function for displaying errors.
*/
function add_error(str){
		$('.error-message').fadeOut('fast',function(){
			$('#the_error').html(str);
			$('.error-message').fadeIn('fast');
		});
	}
/*
Hide any displayed error messages
*/
function hide_error(){
		$('.error-message').fadeOut('fast');
	}
/*
Display the previous button
*/
function display_prev_btn(id){		
		if((id == "step_1") || (id == "step_7")){
			$('#prev').fadeOut('fast');	
		}else{
			$('#prev').fadeIn('fast');
		}
	}

/*
Function for the jCycle script which adjusts the height of its parent div based on its next contents
*/
function assignClass(curr, next, opts, fwd) {
		var rating = selected_rating();
		var index = opts.currSlide;									 
		var $ht = $(this).height();									 //get the height of the next slide
		$(this).parent().find('div.current').removeClass('current'); //find all div that has a current class and remove it
		$(this).addClass('current');								 //add the current class to the active div	
		display_prev_btn($(this).attr('id'));						 
	}
/*
File upload input type styling
*/
(function($) {
    
    $.fn.filestyle = function(options) {
                
        /* TODO: This should not override CSS. */
        var settings = {
            width : 250
        };
                
        if(options) {
            $.extend(settings, options);
        };
                        
        return this.each(function() {
            
            var self = this;
            var wrapper = $("<div>")
                            .css({
                                "width": settings.imagewidth + "px",
                                "height": settings.imageheight + "px",
                                "background": "url(" + settings.image + ") 0 0 no-repeat",
                                "background-position": "right",
                                "display": "inline",
                                "position": "absolute",
                                "overflow": "hidden",
								"cursor": "pointer"
                            });
                            
            var filename = $('<input class="file">')
                             .addClass($(self).attr("class"))
                             .css({
                                 "display": "inline",
                                 "width": settings.width + "px"
                             });

            $(self).before(filename);
            $(self).wrap(wrapper);

            $(self).css({
                        "position": "relative",
                        "height": settings.imageheight + "px",
                        "width": settings.width + "px",
                        "display": "inline",
                        "cursor": "pointer",
                        "opacity": "0.0"
                    });

            if ($.browser.mozilla) {
                if (/Win/.test(navigator.platform)) {
                    $(self).css("margin-left", "-142px");                    
                } else {
                    $(self).css("margin-left", "-168px");                    
                };
            } else {
                $(self).css("margin-left", settings.imagewidth - settings.width + "px");                
            };

            $(self).bind("change", function() {
                filename.val($(self).val());
            });
      
        });
        

    };
    
})(jQuery);


/*
Function which grabs the json response of facebook connect and assigns its values to the 36stories form.
*/
function fb_connect_success(obj){

		if(obj.location != undefined){

			if(obj.location.name != undefined){
			var loc = obj.location.name;
			var location = loc.split(","); 
	
			$('#your_city').val( $.trim(location[0]) );
			$('#your_country').val( $.trim(location[1]) );
			}
	
		}

		if(obj.first_name != undefined){
			$('#your_fname').val( $.trim(obj.first_name) );
		}
		if(obj.last_name != undefined){
			$('#your_lname').val( $.trim(obj.last_name) );
		}
		if(obj.email != undefined){
			$('#your_email').val( $.trim(obj.email) );	
		}
		if(obj.work != undefined){
			if(obj.work[0].employer != undefined){
				if(obj.work[0].employer.name != undefined){
					$('#your_company').val( $.trim(obj.work[0].employer.name) );	
				}
			}
			if(obj.work[0].position != undefined){
				if(obj.work[0].position.name != undefined){
					$('#your_occupation').val( $.trim(obj.work[0].position.name) );	
				}
			}
		}
		if(obj.website != undefined){
			$('#your_website').val( $.trim(obj.website) );
		}
		$('#fb_flag').val("1");
		var photo = 'http://graph.facebook.com/'+obj.id+'/picture?type=large';		
		change_jcrop_div(200);
		change_images(photo, obj);
		default_text();	
		var fb_text = $.trim($('#feedback_text').val());
		if(fb_text == ""){
			$('#steps').cycle(0);
		}else{
			$('#steps').cycle(3);
		}
	}
/*
function for the thumbnail preview of the cropping script
*/
function showPreview(coords) {

	var rx = 100 / coords.w;
	var ry = 100 / coords.h;
	var target = $('#jcrop_target');
	var hgt = target.height();
	var wdt = target.width();
	
	$('#x').val(coords.x);
	$('#y').val(coords.y);
	$('#w').val(coords.w);
	$('#h').val(coords.h);
	
	$('#preview').css({
		width: Math.round(rx * wdt) + 'px',
		height: Math.round(ry * hgt) + 'px',
		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		marginTop: '-' + Math.round(ry * coords.y) + 'px'
	});
};


/*
Function for uploading images using ajax
*/
function ajaxFileUpload() {
		//starting setting some animation when the ajax starts and completes
		var loader = $('#loading');
		
		loader.fadeIn();
		$.ajaxFileUpload ({
            url: $("#ajax-upload-url").attr('hrefaction'),//'/widget/form/upload',
            secureuri:false,
            fileElementId:'your_photo',
            dataType: 'json',
            success: function (data, status) {	 
               
                if(data.error == null) {     
                    change_images(data.dir);
                    change_jcrop_div(data.wid);
                    loader.fadeOut(function(){$(this).html("loading...")});
                    
                    //if user uploads different photo while logged into fb
                    if($('#fb_flag').val() == 1) {
                        $('#fb_flag').val("2");
                    }

                } else { 
                    loader.html(data.error);
                }

            },
            error: function (data, status, e) {
                console.log(data);
            }
		});
	}  
/*
Function that changes the images based on its dir parameter where dir is the location of the image
*/
function change_images(dir, fbObj){ 

    var file = (fbObj) ? dir : "/" + dir;

    $('#profile_picture').attr('src',file);
    $('#jcrop_target').attr('src',file);
    $('#preview').attr('src',file);
}

/* 
Function where the user crops an image and saves it to a folder <(-_-)>
*/
function save_crop_image(){
		$('#crop_button').removeClass('highlight');
		hide_error();
        var fb_login = $("#fb_flag").val();
		var x_coords = $('#x').val();
		var y_coords = $('#y').val();
		var wd = $('#w').val();
		var ht = $('#h').val();
		var cropped_photo = $('#preview').attr('src');
		var status = $('#crop_status');
		var oldphoto = $('#cropped_photo').val();
		
		status.html(' Cropping Photo...');
		
		$.ajax({
			  //url: "crop.php",
              url: $("#ajax-crop-url").attr('hrefaction'),
			  method: 'GET',
			  data: "&src="+cropped_photo+"&x_coords="+x_coords+"&y_coords="+y_coords+"&wd="+wd+"&ht="+ht+"&oldphoto="+oldphoto+"&fb_login="+fb_login,
			  success: function(data){
				    status.fadeOut('fast',function(){
						status.html(' <img src="/img/check-ico.png" /> Photo Successfully Cropped! ');
						status.fadeIn();
						assign_to_review("/uploaded_cropped/150x150/"+data);
						
						$('#cropped_photo').val(data);
					});
			  }
			});
	}
/*
Function for initializing jCrop
*/

function init_jcrop(){
		$('#jcrop_target').Jcrop({
			setSelect: ['40','20','190','170'],
			boxWidth: 350,
			boxHeight: 230,
			onChange: showPreview,
			onSelect: showPreview,
			aspectRatio: 1
		},function(){
			jcrop_api = this;
			var jcwid = $('.jcrop-holder').width();
			change_jcrop_div(jcwid);
		});
		
	}
/*
Change the jCrop div based on the image width
*/
function change_jcrop_div(width){
		width = Math.round(width);
		$('div.jcrop_div').css({'width':width});
	}
/*
Assign the form values to blank html tags for preview purposes
*/	
function assign_to_review(photo){
		
		$('#review-photo').attr('src','images/blank-avatar.png');
		
		var feedback 	=	$('#feedback_text').val();
		var fname 		=   $('#your_fname').val();
		var lname 		=   $('#your_lname').val();
		var email 		=   $('#your_email').val();
		var city 		=   $('#your_city').val();
		var country 	= 	$('#your_country').val();
		var position	= 	$('#your_occupation').val();
		var company		= 	$('#your_company').val();
		var flag_class  =	get_flag(country); 
		var flag 		=   '<div class="flag '+flag_class+'"></div>';
		var location 	=   '<div class="review-location">'+city+', '+country+'</div>';
		if(!photo){
			var photo = $('#your_photo').attr('src');
		}
		
		if(position == "Occupation"){
			position = "";
		}
		if(company == "Company Name"){
			company  = "";
		}
		$('#review-name').html(fname +" "+lname);
		$('#review-position').html(position +" "+company);
		$('#review-location').html(location+" "+flag);
		//$('#review-date').html("Aug 4, 2011");
		$('#review-photo').attr('src',photo);
		$('#review-feedback').html(feedback);
		
	}
function get_flag(country){
	var country_flag = country.toLowerCase();
	var flag_class = "flag-";
	return flag_class + country_flag;
}
/*
Function when edit link is clicked on the preview page
*/
function edit_feedback(){
		$('#edit-review-feedback').fadeOut('fast');
		$('#save-edited-feedback').fadeIn('fast');
		var feedback = $('#review-feedback');
		var textform = '<textarea class="regular-textarea" id="edited-textarea">'+feedback.html()+'</textarea>';
		feedback.html(textform);
	}
/*
Function when save link is clicked on the preview page
*/	
function save_edited_feedback(){
		var feedback = $('#review-feedback');
		var editedtext = $('#edited-textarea');		
		$('#edit-review-feedback').fadeIn('fast');
		$('#save-edited-feedback').fadeOut('fast');
		feedback.html(editedtext.val());
		$('#feedback_text').val(editedtext.val());
	}
function selected_rating(){
		var rating = $('#rating').val();
		return rating;
	}
/*
Customized trackbar inspired by Henry Castor lol
*/
function start_slider(){
		$('#rate_e').click(function(){ slide_track_to('-1px'  ,'5'); });
		$('#rate_g').click(function(){ slide_track_to('+100px','4'); });
		$('#rate_a').click(function(){ slide_track_to('+189px','3'); });
		$('#rate_p').click(function(){ slide_track_to('+278px','2'); });
		$('#rate_b').click(function(){ slide_track_to('+365px','1'); });
	}
/*
Animate the trackball or cursor to a specified location
*/
function slide_track_to(y,rating){
		$('#track_ball').animate({'left':y});
		$('#rating').val(rating);
	}
/*
Form adjustments if set to true then show the complete form else show only the name and email
*/	
function show_complete_form(arg){
		if(arg){
			$('#form_complete').show();
		}else{
			$('#form_complete').hide();
		}
	}

function send_form_data(){
		// grab all form data
		var cit = $('#your_city');
		var cou = $('#your_country');
		var pos = $('#your_occupation');
		var com = $('#your_company');
		var web = $('#your_website');
		
		var cit_title = cit.attr('title');
		var cou_title = cou.attr('title');
		var pos_title = pos.attr('title');
		var com_title = com.attr('title');
		var web_title = web.attr('title');
		
		var country  = '';
		var city 	 = '';
		var position = '';
		var company  = '';
		var website	 = '';
		var rating 	 = selected_rating();
		
		if(rating != 2 && rating != 1){
			var country  = cou.val() == cou_title ? '' : cou.val();
			var city 	 = cit.val() == cit_title ? '' : cit.val();
			var position = pos.val() == pos_title ? '' : pos.val();
			var company  = com.val() == com_title ? '' : com.val();
			var website	 = web.val() == web_title ? '' : web.val();
		}
		
		// check avatar
		var preview = $('#preview').attr('src');
		var avatar = '';
		avatar = preview != "/img/sample-avatar.png" ? preview : '';
		
		// check permissions if
		var per = $('[name="your_permission"]:checked');
		var perm = per.length > 0 ? per.val() : '';
		
		var form_data = {
			fb_flag:		$('#fb_flag').val(),
			site_id:		$('#site_id').val(),
			company_id: 	$('#company_id').val(),
		   	rating: 		$('#rating').val(),
		   	feedback:		$('#feedback_text').val(),
			first_name: 	$('#your_fname').val(),
			last_name:  	$('#your_lname').val(),
			email: 			$('#your_email').val(),
			country: 		country,
			city: 			city,
			position: 		position,
			company: 		company,
			website: 		website,
			permission: 	perm,
			cropped_image_nm: $('#cropped_photo').val() == '0' ? '' : $('#cropped_photo').val(),
			orig_image_dir: avatar
		};
		
		console.log(form_data);
		$.ajax({
		     type: "POST"
		   , url:  $("#ajax-submit-feedback").attr('hrefaction')//"/api/submit_feedback"
		   , dataType: "json"
		   , data: form_data
		   , success: function(data){
			  	console.log(data);
			 }
		   , error: function(e){
			 	console.log(e);
			 }
		});
	}
// END OF 36stories Javascript
