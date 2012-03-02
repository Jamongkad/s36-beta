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
        } else if (this.tagName.toLowerCase() == 'option') {
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

    var slide_track_to = function(y, rating) {
		$('#track_ball').animate({'left':y});
		$('#rating').val(rating); 
    };

    this.show_complete_form = function(arg) {
		if (arg) {
		    $('#form_complete').show();
		} else {
			$('#form_complete').hide();
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

    this.start_slider = function() {
        var that = this;
		$('#rate_e').click(function(){ that.slide_track_to('-1px'  ,'5'); });
		$('#rate_g').click(function(){ that.slide_track_to('+100px','4'); });
		$('#rate_a').click(function(){ that.slide_track_to('+189px','3'); });
		$('#rate_p').click(function(){ that.slide_track_to('+278px','2'); });
		$('#rate_b').click(function(){ that.slide_track_to('+365px','1'); }); 
    };

    this.selected_rating = function() { 
	    var rating = $('#rating').val();
		return rating;
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
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
            return true;
        }else{
            return false;
        }
    };

    this.validate_field = function(fieldid, value, default_val, type) {
        var that = this;
	    if(type == "regular"){   // check if type is only regular
			if((value.length <= 0) || (value == default_val)){		
				return false;
			}else{
				return true;
			}
		}else if(type == "email"){ //if type is email
			if((value.length <= 0) || (value == default_val)){
				return false;
			}else if(!that.validate_email(value)){
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

    this.change_images = function(dir, img) {

        var file;

        if(img == 'fb' || img == 'ln') {
            file = dir;     
        }

        if(img == 'native') {
            file = "/" + dir;
        }

        $('#profile_picture').attr('src',file);
        $('#jcrop_target').attr('src',file);
        $('#preview').attr('src',file);
        $('#crop_photo').show(); 
    };

    this.default_text = function() { 
        var that = this;

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
                    if(!that.validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
                        that.add_error('Please Enter Your First Name');
                    }else{
                        that.hide_error();
                    }
                }else if($(this).attr('id') == "your_lname"){														
                    if(!that.validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
                        that.add_error('Please Enter Your Last Name');
                    }else{
                        that.hide_error();	
                    }
                }else if($(this).attr('id') == "your_email"){														
                    if(!that.validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "email")){
                        that.add_error('Please Enter A Valid Email');
                    }else{
                        that.hide_error();	
                    }
                }else if($(this).attr('id') == "your_city"){														
                    if(!that.validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
                        that.add_error('Please Enter Your City');
                    }else{
                        that.hide_error();
                    }
                }
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
                    if(!that.validate_field( $(this).attr('id') , $(this).val() , $(this)[0].title , "regular")){
                        that.add_error('Please Select Your Country');
                    }else{
                        that.hide_error();
                    }
                }
            }
		});
		$(".regular-text").blur();
		$(".regular-select").blur();
    };

    this.assign_class = function(curr, next, opts, fwd)  { 
        var that = this; 
		var rating = that.selected_rating();
		var index = opts.currSlide;									 
		var $ht = $(this).height();									 //get the height of the next slide
		$(this).parent().find('div.current').removeClass('current'); //find all div that has a current class and remove it
		$(this).addClass('current');								 //add the current class to the active div	
		this.display_prev_btn($(this).attr('id'));						 
    };

    this.fb_connect_success = function(obj) { 
        var that = this;
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
                console.log("location success!");
                console.log(loc);
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

		$('#fb_flag').val("1");
		var photo = 'http://graph.facebook.com/'+obj.id+'/picture?type=large';		
		that.change_jcrop_div(200);
		that.change_images(photo, 'fb');
		that.default_text();	
		var fb_text = $.trim($('#feedback_text').val());
		if(fb_text == ""){
			$('#steps').cycle(0);
		}else{
			$('#next').show();
			$('#steps').cycle(3);
		}
    };

    this.validate_form = function(form) {
        var that = this;
	    var fname 		= $('#your_fname'); 
		var lname 		= $('#your_lname'); 
		var email		= $('#your_email');
		var city 		= $('#your_city');
		var country 	= $('#your_country');

		//validate_field function arguments : element ID, element's user input value, element's default value, type = regular|email|phone|numeric
		if(!that.validate_field( fname.attr('id')    , fname.val()    , fname.attr('title')    , "regular")){
			fname.focus();
			add_error('Please Enter Your First Name');
			return false;
		}else if(!that.validate_field( lname.attr('id')   , lname.val()   , lname.attr('title')   , "regular")){
			lname.focus();
			that.add_error('Please Enter Your Last Name');
			return false;
		}else if(!that.validate_field( email.attr('id')   , email.val()   , email.attr('title')   , "email")){
			email.focus();
			that.add_error('Please Enter A Valid Email');
			return false;
		}else if((!that.validate_field( city.attr('id')    , city.val()    , city.attr('title')    , "regular")) && (form == "full")){
			city.focus();
			that.add_error('Please Enter Your City');
			return false;
		}else if((!that.validate_field( country.attr('id') , country.val() , country.attr('title') , "regular")) && (form == "full")){
			country.focus();
			that.add_error('Please Select Your Country');
			return false;
		}else{
			return 4;
		}    
    };

    var show_preview = function(coords) {
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

    this.init_jcrop = function() { 
        var that = this;
        $('#jcrop_target').Jcrop({
            setSelect: ['40','20','190','170'],
            boxWidth: 350,
            boxHeight: 230,
            onChange: that.show_preview,
            onSelect: that.show_preview,
            aspectRatio: 1
        },function(){
            that.jcrop_api = this;
            var jcwid = $('.jcrop-holder').width();
            that.change_jcrop_div(jcwid);
        });
    };

    var get_flag = function() {
        var country_flag = country.toLowerCase();
        var flag_class = "flag-";
        return flag_class + country_flag; 
    };

    this.assign_to_review = function(photo) {
        var that = this;
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
		$('#review-photo').attr('src',photo);
		$('#review-feedback').html(feedback); 
    };

    this.ajax_file_upload = function() { 
        //starting setting some animation when the ajax starts and completes
        var loader = $('#loading');
        var that = this;
        
        loader.fadeIn();
        $.ajaxFileUpload ({
            url: $("#ajax-upload-url").attr('hrefaction'),
            secureuri:false,
            fileElementId:'your_photo',
            dataType: 'json',
            success: function (data, status) {	 
               
                if(data.error == null) {     
                    that.change_images(data.dir, 'native');
                    that.change_jcrop_div(data.wid);
                    loader.fadeOut(function(){$(this).html("loading...")});
                                        
                    if($('#fb_flag').val() == 1) {
                        $('#fb_flag').val(2);
                    }
                   
                } else { 
                    loader.html(data.error);
                }

            },
            error: function (data, status, e) {
                console.log(data);
            }
        });
    };

    this.load_linkedin_data = function() {
        var that = this;
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

            $('#ln_flag').val("1");
            if(profile.pictureUrl != undefined){
                photo = profile.pictureUrl;
            }
            that.change_jcrop_div(200);
            that.change_images(photo, 'ln');

            var fb_text = $.trim($('#feedback_text').val());
            if(fb_text != ""){
                $('#steps').cycle(3);
            }
        });    
    };
    
    this.save_crop_image = function() {
        var that = this;
		$('#crop_button').removeClass('highlight');
		that.hide_error();
        var fb_login = $("#fb_flag").val();
		var x_coords = $('#x').val();
		var y_coords = $('#y').val();
		var wd = $('#w').val();
		var ht = $('#h').val();
		var cropped_photo = $('#preview').attr('src');
		var status = $('#crop_status');
		var oldphoto = $('#cropped_photo').val();
		
		status.html(' Cropping Photo...');
		
		return $.ajax({
              url: $("#ajax-crop-url").attr('hrefaction'),
			  method: 'GET',
              async: false,
			  data: "&src="+cropped_photo+"&x_coords="+x_coords+"&y_coords="+y_coords+"&wd="+wd+"&ht="+ht+"&oldphoto="+oldphoto+"&fb_login="+fb_login,
			  success: function(data){
				    status.fadeOut('fast',function(){
						status.html(' <img src="/img/check-ico.png" /> Photo Successfully Cropped! ');
						status.fadeIn();
						that.assign_to_review("/uploaded_cropped/150x150/"+data);
						
						$('#cropped_photo').val(data);
                        $('#is_cropped').val(1);
					});
			  }
			});
        
    };

    this.save_linkedin_image = function() {
        var that = this;   
        that.hide_error();

        var ln_login = $("#ln_flag").val();
        var x_coords = 0;
        var y_coords = 0;
        var wd = 80;
        var ht = 80;
        var cropped_photo = $('#profile_picture').attr('src');		
        var oldphoto = $('#cropped_photo').val();
        return $.ajax({ 
              url: $("#ajax-crop-url").attr('hrefaction'),
              method: 'GET',
              async: false,
              data: "&src="+cropped_photo+"&x_coords="+x_coords+"&y_coords="+y_coords+"&wd="+wd+"&ht="+ht+"&oldphoto="+oldphoto+"&ln_login="+ln_login,
              success: function(data){ 
                    that.assign_to_review("/uploaded_cropped/150x150/"+data);
                    $('#cropped_photo').val(data);
                    $('#is_cropped').val(1);
              }
        });

    };

    var login_type = function() { 
        var ln = $("#ln_flag");
        var fb = $("#fb_flag");

        if(ln.val() == 1) {
            return "ln";
        }

        if(fb.val() == 1) {
            return "fb";
        }

        return "36";
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
        var that = this;
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
		var rating 	 = that.selected_rating();
		
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
			fb_flag:		$('#fb_flag').val(),
			site_id:		$('#site_id').val(),
			company_id: 	$('#company_id').val(),
		   	rating: 		$('#rating').val(),
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
			cropped_image_nm: $('#cropped_photo').val() == '0' ? '' : $('#cropped_photo').val(),
			orig_image_dir: avatar
		};	
		//console.log(form_data);
		$.ajax({
		     type: "POST"
		   , url:  $("#ajax-submit-feedback").attr('hrefaction')
		   , dataType: "json"
		   , data: form_data
		   , success: function(data){
			  	console.log(data);
			 }
		   , error: function(e){
			 	console.log(e);
			 }
		}); 
    };

    this.save_edited_feedback = function() {
        var that = this; 
        var feedback = $('#review-feedback');
        var editedtext = $('#edited-textarea');		
         //check if there is a feedback
        var text = editedtext.val();
        if(text.length > 0){
            that.hide_error();
            $('#edit-review-feedback').fadeIn('fast');
            $('#save-edited-feedback').fadeOut('fast');
            feedback.html(editedtext.val());
            $('#feedback_text').val(text);
            console.log(text);
        }else{
            editedtext.focus();
            that.add_error('Please Provide a Feedback');
        } 
    };

    this.edit_feedback = function() {
        var that = this;
		$('#edit-review-feedback').fadeOut('fast');
		$('#save-edited-feedback').fadeIn('fast');
		var feedback = $('#review-feedback');
		var textform = '<textarea class="regular-textarea" id="edited-textarea">'+feedback.html()+'</textarea>';
		feedback.html(textform);
        
        $('#edited-textarea').focus(function(){
            $(this).blur(function(){
                that.save_edited_feedback();
            });
        }); 
    };
};
// END OF 36stories Javascript
