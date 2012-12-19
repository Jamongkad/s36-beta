/* 
Form interactions. Text boxes and Combo boxes style changer
*/

// OPTION SELECT PLUGIN
$.fn.selected = function(select) {
    if (select == undefined) select = true;
    return this.each(function() {
        var t = this.type;
        if (t == 'checkbox' || t == 'radio') {
            this.checked = select;
        } 
        
        if (this.tagName.toLowerCase() == 'option') {
            var $sel = $(this).parent('select');
            if (select && $sel[0] && $sel[0].type == 'select-one') {
                // deselect all other options
                $sel.find('option').selected(false);
            }
            this.selected = select;
        }
    });
};

var S36Form = new function() {

    var jcrop_api;
    var that = this;

    this.show_preview = function(coords) {
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

    this.slide_track_to = function(y, rating) {
		$('#track_ball').animate({'left':y});
		$('#rating').val(rating); 
    };

    this.show_complete_form = function(arg) {
		if (arg) {
		    $('#form_complete').show();
            $('#hostform_info').removeAttr('style');
            $('#hostform_info').css({'width': '50%', 'float': 'left'});
            $('#hostform_photo').show();
		} else { 
			$('#form_complete').hide();
            $('#hostform_info').css({'width': '50%', 'position': 'absolute', 'left': '25%'});
            $('#hostform_photo').hide();
		} 
    };

    this.strstr = function(haystack, needle, bool) {
        var pos = 0;
        haystack += '';
        pos = haystack.indexOf(needle);
        if (pos == -1) {
            return false;
        } else {
            if (bool) {
                return haystack.substr(0, pos);
            } else {
                return haystack.slice(pos);
            }
        } 
    };

    this.start_slider = function(length) {
        length = typeof length !== 'undefined' ? length : 'short';

        if(length === 'short') { 
            /* just incase someone out there changes his mind again
            $('#rate_e').click(function(){ that.slide_track_to('-1px'  ,'5'); });
            $('#rate_g').click(function(){ that.slide_track_to('+100px','4'); });
            $('#rate_a').click(function(){ that.slide_track_to('+189px','3'); });
            $('#rate_p').click(function(){ that.slide_track_to('+278px','2'); });
            $('#rate_b').click(function(){ that.slide_track_to('+365px','1'); }); 
            */

            $('#rate_b').click(function(){ that.slide_track_to('-1px'  , 1); });
            $('#rate_p').click(function(){ that.slide_track_to('+100px', 2); });
            $('#rate_a').click(function(){ that.slide_track_to('+189px', 3); });
            $('#rate_g').click(function(){ that.slide_track_to('+278px', 4); });
            $('#rate_e').click(function(){ that.slide_track_to('+365px', 5); }); 
        } else { 
            /*
            $('#rate_e').click(function(){ that.slide_track_to('0px'  ,'5'); });
            $('#rate_g').click(function(){ that.slide_track_to('+117px','4'); });
            $('#rate_a').click(function(){ that.slide_track_to('+223px','3'); });
            $('#rate_p').click(function(){ that.slide_track_to('+332px','2'); });
            $('#rate_b').click(function(){ that.slide_track_to('+435px','1'); });
            */

            $('#rate_b').click(function(){ that.slide_track_to('0px'  , 1); });
            $('#rate_p').click(function(){ that.slide_track_to('+117px', 2); });
            $('#rate_a').click(function(){ that.slide_track_to('+223px', 3); });
            $('#rate_g').click(function(){ that.slide_track_to('+332px', 4); });
            $('#rate_e').click(function(){ that.slide_track_to('+435px', 5); });
        }
    };

    this.add_error = function(str)  {
		$('.error-message').fadeOut('fast',function(){
			$('#the_error').html(str);
			$('.error-message').fadeIn('fast');
		}); 
    };

    this.hide_error = function() { 
		$('.error-message').fadeOut('fast');
    };

    this.validate_email = function(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email); 
    };

    this.validate_url = function(url) {
        //var re = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        var re = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
        return re.test(url)
    };

    this.validate_field = function(value, default_val, type) {
        
	    if(type == "regular") {   // check if type is only regular
			if((value.length <= 0) || (value == default_val)){		
				return false;
			}else{
				return true;
			}
		} 
        
        if(type == "email"){ //if type is email
			if((value.length <= 0) || (value == default_val)){
				return false;
			}else if(!that.validate_email(value)){
				return false;	
			}else{
				return true;
			}
		}
        
        if(type == "website"){ //if type is url
            if(value !== default_val) { 
                console.log("String detected");
                if(!that.validate_url(value)){
                    console.log("Not a valid Url");
                    return false;	
                }		
            }
            return true;
        }

        if(type == "phone"){
			//phone only allows '+',','," " and numeric values 
			var phone = new RegExp('[+0-9 ,]');
			var notallow = new RegExp('[a-zA-Z]');
			if((!value.match(phone)) || (value.match(notallow))){
				return false;
			}else{
				return true;
			}
		}
        
        if(type == "numeric"){
			//strictly allows numeric values only
			var numeric = new RegExp('[0-9]');
			var notallow = new RegExp('[a-zA-Z]');
			if((!value.match(numeric)) || (value.match(notallow))){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
        
    };

    this.display_prev_btn = function(id) {
	    if((id == "step_1") || (id == "step_7")){
			$('#prev').fadeOut('fast');	
		}else{
			$('#prev').fadeIn('fast');
		} 
    };
    
    this.change_jcrop_div = function(width) {
        var width = Math.round(width);
        $('div.jcrop_div').css({'width':width}); 
    };

    this.change_images = function(img_nm, img_src) {

        var file;

        if(img_src == 'fb' || img_src == 'ln') {
            file = img_nm;     
        }

        if(img_src == 'native') {
            file = "/" + img_nm;
        }

        $('#profile_picture').attr('src', file);
        $('#jcrop_target').attr('src', file);
        $('#preview').attr('src', file);
        $('#crop_photo').show(); 
    };

    this.default_text = function() { 
        
		$(".regular-text, .regular-textarea").focus(function(i){          		 
            if ($(this).val() == $(this)[0].title){
                $(this).removeClass("reg-text-active");
                $(this).val("");
            }
		});

		$(".regular-text, .regular-textarea").blur(function(){
            if ($.trim($(this).val()) == ""){
                $(this).addClass("reg-text-active");
                $(this).val($(this)[0].title);
            }
		});
 
		$(".regular-select").focus(function(i){
            $(this).removeClass("reg-text-active");
            if ($(this).val() != $(this)[0].title){
                $(this).removeClass("reg-text-active");
            }
        });
		$(".regular-text, .regular-textarea").blur();
		$(".regular-select").blur();
    };

    this.selected_rating = function() { 
	    var rating = $('#rating').val();
		return rating;
    };

    this.assign_class = function(curr, next, opts, fwd)  { 
		var rating = that.selected_rating();
		var index = opts.currSlide;									 
		var $ht = $(this).height();									 //get the height of the next slide
		$(this).parent().find('div.current').removeClass('current'); //find all div that has a current class and remove it
		$(this).addClass('current');								 //add the current class to the active div	
		that.display_prev_btn($(this).attr('id'));						 
    };

    this.fb_connect_success = function(obj) { 
        
		if(obj.location != undefined){

			if(obj.location.name != undefined){
                var loc = obj.location.name;
                var location = loc.split(","); 

                console.log($.trim(location[0]));

                $('#your_city').val( $.trim(location[0]) );
			
                $('#your_country option').each(function(){
                    if($.trim(location[1]) == $(this).text()){
                        $(this).selected(true);
                    }
                });
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
            var site = $.trim(obj.website);
            var matches = site.split(/\r/);//explode the string
            site = matches.length > 0 ? matches[0] : ""; // check if there are matches
            $('#your_website').val( site );
		}

        if(obj.link != undefined) {
            $("#profile_link").val( $.trim(obj.link) );
        }

		var photo = 'https://graph.facebook.com/'+obj.id+'/picture?type=large';		
		that.change_jcrop_div(200);
		that.change_images(photo, 'fb');
		that.default_text();	
        
		var feedback_text = $.trim($('#feedback_text').val());
		if(feedback_text == ""){
			$('#steps').cycle(0);
		}

        if($('#steps').find('.current').attr('id') == "step_3"){
            $('#next').show();
            $('#steps').cycle(3);
        }

        $('#fb_flag').val(1);
        $('#native_flag').val(0);
        $('#ln_flag').val(0);
        
        $('#fb-connect-button').empty().html('<div id="fb-false-connect"></div>');
        $('#fb-false-connect').click(function(){
            $('#steps').cycle(3); 
            $('#next').show();
        }); 
    };

    this.linkedin_connect_success = function() {
        IN.API.Profile("me")
        .fields(["id", "firstName", "lastName", "pictureUrl","headline","positions","location","public-profile-url"])
        .result(function(result) {
            var photo;
            var profile  = result.values[0]; 
            var position = profile.positions.values[0].title;
            var company  = profile.positions.values[0].company.name;
            var fname	   = profile.firstName;
            var lname	   = profile.lastName;
            var country  = profile.location.name;	 
            var profile_link = profile.publicProfileUrl;

            $('#your_city').val( $.trim(location[0]) );
            $('#your_country option').each(function(){
                if($.trim(location[1]) == $(this).text()){
                    $(this).selected(true);
                }
            });

            $('#your_fname').val( $.trim(fname) );
            $('#your_lname').val( $.trim(lname) );
            $('#your_company').val( $.trim(company) );	
            $('#your_occupation').val( $.trim(position) );	
            $("#profile_link").val( $.trim(profile_link) );
            if(profile.pictureUrl != undefined){
                photo = profile.pictureUrl;
            }
            that.change_jcrop_div(200);
            that.change_images(photo, 'ln');

            var feedback_text = $.trim($('#feedback_text').val());
            if(feedback_text == ""){
                $('#steps').cycle(0);
            }

            if($('#steps').find('.current').attr('id') == "step_3"){
                $('#next').show();
                $('#steps').cycle(3);
            }

            $('#ln_flag').val(1);
            $('#native_flag').val(0);
            $('#fb_flag').val(0);
        });    
    };

    this.s36_connect_success = function() {    
        $('#native_flag').val(1);
    };

    this.validate_form = function(form) {
   
        var fname 		= $('#your_fname'); 
        var lname 		= $('#your_lname'); 
        var email		= $('#your_email');
        var city 		= $('#your_city');
        var country 	= $('#your_country');
        var website     = $('#your_website');

        //validate_field function arguments : element ID, element's user input value, element's default value, type = regular|email|phone|numeric 
        if(!that.validate_field(fname.val(), fname.attr('title'), "regular") ){
            fname.focus();
            that.add_error('Please Enter Your First Name');
            return false;
        }
        
        if(!that.validate_field(lname.val(), lname.attr('title'), "regular")){
            lname.focus();
            that.add_error('Please Enter Your Last Name');
            return false;
        }
        
        if(!that.validate_field(email.val(), email.attr('title'), "email")){
            email.focus();
            that.add_error('Please Enter A Valid Email');
            return false;
        }

        if(!that.validate_field(website.val(), website.attr('title'), "website")){
            website.focus();
            that.add_error('Please Enter A Valid URL');
            return false;
        }

        if(form === 'full') { 
            if((!that.validate_field(city.val(), city.attr('title'), "regular"))){
                city.focus();
                that.add_error('Please Enter Your City');
                return false;
            }
            
            if((!that.validate_field(country.val(), country.attr('title'), "regular"))){
                country.focus();
                that.add_error('Please Select Your Country');
                return false;
            }    
        }

        return 4;
    
		that.hide_error();
    };

    this.init_jcrop = function() {  
        $('#jcrop_target').Jcrop({
            setSelect: ['40','20','190','170'],
            boxWidth: 350,
            boxHeight: 230,
            onChange: that.show_preview,
            onSelect: that.show_preview,
            aspectRatio: 1
        }, function() {
            console.log('re-initialize crop');
            that.jcrop_api = this;
            var jcwid = $('.jcrop-holder').width();
            that.change_jcrop_div(jcwid);
        });
    };

    this.get_flag = function(country) {
        var country_flag = country.toLowerCase();
        var flag_class = "flag-";
        return flag_class + country_flag; 
    };

    this.assign_to_review = function(photo) {
        
		$('#review-photo').attr('src','/img/blank-avatar.png');
		
		var feedback 	=	$('#feedback_text').val();
		var fname 		=   $('#your_fname').val();
		var lname 		=   $('#your_lname').val();
		var email 		=   $('#your_email').val();
		var city 		=   $('#your_city').val();
		var country 	= 	$('#your_country').val();
		var position	= 	$('#your_occupation').val();
		var company		= 	$('#your_company').val();
		var flag_class  =	that.get_flag(country); 
		var flag 		=   '<div class="flag-form '+flag_class+'"></div>';
		var my_location =   '<div class="review-location">'+camel_case(city)+', '+camel_case(country)+'</div>';
		if(!photo){
			var photo = $('#your_photo').attr('src');
		}
		
		if(position == "Occupation"){
			position = "";
		}
		if(company == "Company Name"){
			company  = "";
		}

        var review_position;
        if(position && company) {
            review_position = position + ", " + company;
        }

        if(position && company == false) { 
            review_position = position;
        }

        if(position == false && company) {
            review_position = company; 
        }

        $("#next").fadeOut("fast");
        $("#back").fadeOut("fast");

		$('#review-name').html(camel_case(fname + " " + lname));
		$('#review-position').html(camel_case(review_position));
		$('#review-location').html(my_location + " " + flag);
		$('#review-photo').attr('src', photo).load(function() {
            $('#next').fadeIn('fast');
        })
		$('#review-feedback').html(feedback); 
    };

    this.ajax_file_upload = function() { 
        //starting setting some animation when the ajax starts and completes
        var loader = $('#loading');
        loader.fadeIn();  
        //console.log("Fading Out");
        $("#next").fadeOut("fast");
        $("#back").fadeOut("fast");
        $.ajaxFileUpload ({
            url: $("#ajax-upload-url").attr('hrefaction'),
            secureuri:false,
            fileElementId:'your_photo',
            dataType: 'json',
            success: function (data, status) {	  
                if(data.error == null) {     
                    that.change_images(data.dir, 'native');
                    that.fetch_new_image(data.dir);
                    that.change_jcrop_div(data.wid);
                } else { 
                    loader.html(data.error);
                } 
            },
            error: function (data, status, e) {
                console.log(data);
            }
        });
    };

    this.fetch_new_image = function(src){
        console.log(src);
        $('#loading').html('Crunching Image...');
        $('<img />').attr('src', "/" + src)
        .load(function(){
            $('.profile').append( $(this) );
            $('#next').fadeIn('fast');
            $('#loading').fadeOut('fast',function(){
                $(this).html('Uploading Image...');
            });
        });
    };
 
    this.save_crop_image = function() {
		that.hide_error();
        that.hide_crop_buttons();
		$('#crop_button').removeClass('highlight');
		var x_coords = $('#x').val();
		var y_coords = $('#y').val();
		var wd = $('#w').val();
		var ht = $('#h').val();
		var cropped_photo = $('#preview').attr('src');
		var crop_status = $('#crop_status');
		var oldphoto = $('#cropped_photo').val();	
		crop_status.html(' Cropping Photo...');
       
        $.ajax({ 
            url: $("#ajax-crop-url").attr('hrefaction')
          , type: "POST" 
          , data: {src: cropped_photo, x_coords: x_coords, y_coords: y_coords, wd: wd, ht: ht, oldphoto: oldphoto, login_type: that.login_type()}
          , success: function(data) {
                crop_status.html(' <img src="/img/check-ico.png" /> Photo Successfully Cropped! ');
                crop_status.fadeIn();
                that.assign_to_review("/uploaded_cropped/150x150/"+data);				
                $('#cropped_photo').val(data);
			    $('#steps').cycle(5);
          }
        });
    };
     
    //used for data insertion
    this.login_type = function() { 
        var ln = $("#ln_flag");
        var fb = $("#fb_flag");
        var nt = $("#native_flag");

        if(ln.val() == 1) {
            return "ln";
        }

        if(fb.val() == 1) {
            return "fb";
        }
        
        if(nt.val() == 1) {
            return "36";     
        } 
    };

    this.show_crop_buttons = function() {
        $('#next').hide();
        $('#prev').hide();
        $('#cancel_cropbtn').show();
        $('#cropbtn').show(); 
    };

    this.hide_crop_buttons = function() { 
        $('#next').show();
        $('#prev').show();
        $('#cancel_cropbtn').hide();
        $('#cropbtn').hide();
    };

    this.send_form_data = function() {
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
		var rating 	 = this.selected_rating();
		
		if(rating != 2 && rating != 1){
			var country  = cou.val() == cou_title ? '' : cou.val();
			var city 	 = cit.val() == cit_title ? '' : cit.val();
			var position = pos.val() == pos_title ? '' : pos.val();
			var company  = com.val() == com_title ? '' : com.val();
			var website	 = web.val() == web_title ? '' : web.val();
		}	
		// check avatar
		var preview = $('#preview').attr('src');
		var avatar;
		avatar = preview != "/img/sample-avatar.png" ? preview : '';
		
		// check permissions if
		var per = $('[name="your_permission"]:checked');
		var perm = per.length > 0 ? per.val() : '';
		
		var form_data = {
			site_id:		$('#site_id').val(),
			company_id: 	$('#company_id').val(),
            rating:         $('#rating').val(),
		   	feedback:		$('#feedback_text').val(),
			first_name: 	$('#your_fname').val(),
			last_name:  	$('#your_lname').val(),
			email: 			$('#your_email').val(),
            response_flag:  $('#response_flag').val(),
            profile_link:   $('#profile_link').val(),
            login_type:     that.login_type(),
			country: 		country,
			city: 			city,
			position: 		position,
			company: 		company,
			website: 		website,
			permission: 	perm,
			cropped_image_nm: $('#cropped_photo').val() == 0 ? 0 : $('#cropped_photo').val(),
			orig_image_dir: avatar
		};	

		$.ajax({
		     type: "POST"
		   , url:  $("#ajax-submit-feedback").attr('hrefaction')
		   , dataType: "json"
		   , data: form_data
           , success: function() {
                 //opera fix scumbag webbrowser
                 $("#submission-loader").hide();
                 $("#submission-loader-header").hide();
                 $("#submission-success").show();
                 $("#submission-success-header").show();
                 $("#next").hide();

                 //if rating is excellent allow user to share his feedback on facebook.
                 if($("#rating").val() == 5) {
                     //feedback text will clear upon FB sharing
                     $("#share-panel").show();
                     $("#success-message-excellent").show();
                     $("#success-message-ord").hide();
                     var feedback_phrase = "Just sent " + $("#company_name").val() + " this feedback: " + $("#feedback_text").val();
                     var domain = "<br/><br/>\n\n\n\nBe sure to visit them at http://" + $("#domain").val();
                     $(".all-done-feedback-box").html(feedback_phrase + domain);
                 } else {
                     $("#feedback_text").val("");     
                     $("#success-message-excellent").hide();
                     $("#success-message-ord").show(); 
                 } 
            }
		}); 
    };

    this.save_edited_feedback = function() {
        
        var feedback = $('#review-feedback');
        var editedtext = $('#edited-textarea');		

        if(editedtext.length > 0) {
            var text = editedtext.val();     
            if(text.length > 0){
                that.hide_error();
                $('#edit-review-feedback').fadeIn('fast');
                $('#save-edited-feedback').fadeOut('fast');
                feedback.html(editedtext.val());
                $('#feedback_text').val(text);
                $("#next").fadeIn("fast");
            }else{
                editedtext.focus();
                that.add_error('Please provide feedback.');
                $("#next").fadeOut("fast");
            } 
        }
    };
    
    //create textarea when edit-review-feedback is clicked
    this.edit_feedback = function() {
		$('#edit-review-feedback').fadeOut('fast');
		$('#save-edited-feedback').fadeIn('fast');
		var feedback = $('#review-feedback');
		var textform = '<textarea id="edited-textarea">'+feedback.html()+'</textarea>';
		feedback.html(textform);
        
        $('#edited-textarea').focus(function(){
            $(this).blur(function(){
                that.save_edited_feedback();
            });
        }); 
    }; 
    
};
// END OF 36stories Javascript
//helper functions
function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function strtolower(str) {
    return (str+'').toLowerCase();
}

function camel_case(str) {
    if(typeof str === "undefined") {
        return "";
    } 
    return ucwords(strtolower(str));
}
