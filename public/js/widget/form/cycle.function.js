// PageCycle Functions

/*
||-----------------------------------------------
||  Assign required parameters and elements used
||-----------------------------------------------
*/
var init = 0;
var debug = 1;

function PageCycle() {	
	this.cur_step 		= $('#steps').find('.current').attr('id');
	this.rating 		= S36Form.selected_rating();
	this.default_photo 	= "img/blank-avatar.png";
	this.is_photo 		= $('#profile_picture').attr('src');
	this.review_photo 	= $('#review-photo').attr('src');
	this.next_button	= $('#next');
	this.prev_button	= $('#prev');
	this.crop_button	= $('#cropbtn');
	this.cancel_crop_button	= $('#cancel_cropbtn');
	this.feedback 		    = $('#feedback_text').val();
}

/*
||-------------------------------------------
||  Move the form to the next page
||--------------------------------------------
*/

PageCycle.prototype.cycle_next = function() {
		
	if(this.cur_step == "step_1"){
		
		return this._check_page_one(true);
		
	}else if(this.cur_step == "step_2"){
		
		return this._check_page_two(true);
		
	}else if(this.cur_step == "step_3"){
		
		return this._check_page_three(true);
		
	}else if(this.cur_step == "step_4"){
		
		return this._check_page_four(true);
		
	}else if(this.cur_step == "step_5"){
		
		return this._check_page_five(true);
		
	}else if(this.cur_step == "step_6"){
		
		return this._check_page_six(true);
		
	}else if(this.cur_step == "step_7"){
		
		return this._check_page_seven(true);
		
	}		
}

/*
||-------------------------------------------
||  Move the form to the previous page
||--------------------------------------------
*/

PageCycle.prototype.cycle_prev = function() {
		
	if(this.cur_step == "step_2"){
		
		return this._check_page_two(false);
		
	}else if(this.cur_step == "step_3"){
		
		return this._check_page_three(false);
		
	}else if(this.cur_step == "step_4"){
		
		return this._check_page_four(false);
		
	}else if(this.cur_step == "step_5"){
		
		return this._check_page_five(false);
		
	}else if(this.cur_step == "step_6"){
		
		return this._check_page_six(false);
		
	}else if(this.cur_step == "step_7"){
		
		return this._check_page_seven(false);
		
	}else{
		
		return false;
		
	}
}


/*
||---------------------------------------------------------------------
||  Page checker -- validation below (^_^)
||---------------------------------------------------------------------
*/
	
	/*
	||---------------------------------------
	||  Check Page One
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_one = function(next){

	
		/*------------------------
		|  Next button pressed
		-------------------------*/

	        this._debug("Page 1");	

            if($("#feedback_text").val() == $("#feedback_text").attr('title')) { 
				S36Form.add_error("Please provide feedback."); 
                return false 
            }

            if((this.rating == 5) || (this.rating == 4) || (this.rating == 3)) {
                //console.log(this.rating);    
                $('#good-feedback-message').show();  
                $('#bad-feedback-message').hide();
            } else { 
                $('#good-feedback-message').hide();
                $('#bad-feedback-message').show();
            }
            
			if(this.feedback.length > 0){
				if((this.rating == 2) || (this.rating == 1)){
					S36Form.show_complete_form(false); 
					return 3;
				}else{
					S36Form.show_complete_form(true);
					return 1;
				}
			}else{
				S36Form.add_error("Please provide feedback."); 
				return false;
			}
	}
	
	/*
	||---------------------------------------
	||  Check Page Two
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_two = function(next){
		
		/*------------------------
		|  Next button pressed
		-------------------------*/	
        this._debug("Page 2");
        //console.log(this.rating);
		if(next){	
			var permission = $('[name="your_permission"]:checked').size();
            var fb_profile_check = $('#fb_flag').val();
			if(permission <= 0){
				S36Form.add_error('Please select your permission for your feedback.');
				return false;
			} else if(fb_profile_check == 1) {
                return 3; 
            } else {
				this.next_button.hide();
				return 2;
			}
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/
		
		else{
			return 0;
		}
	}
	
	/*
	||---------------------------------------
	||  Check Page Three
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_three = function(next){
		
		/*------------------------
		|  Next button pressed
		-------------------------*/	
	    this._debug("Page 3");	
		if(next){
			return 3;
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/	
		
		else{
			this.next_button.show();
			return 1;
		}
	}
	
	/*
	||---------------------------------------
	||  Check Page Four (The profile form and photo upload)
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_four = function(next){
						
		/*------------------------
		|  Next button pressed
		-------------------------*/
	    this._debug("Page 4");	
		var that = this;
        var bad_rating;
		if(next){	
			if((this.rating == 2) || (this.rating == 1)){
				var val = S36Form.validate_form('partial'); // validate_form returns 3;
				var bad_rating = true;
                console.log(val);
			}else{
				var val = S36Form.validate_form('full'); 	// validate_form returns 3;
				var bad_rating = false;
                console.log(val);
			}
			if(val){ 
				// if form is validated..				
				// assign all values to the review slide, argument: false if not from jcrop				
                that._jcrop_initializer();
				S36Form.assign_to_review(this.is_photo);
				$('#crop_photo').click(function(e){
                    that._cropper_page();
                    e.preventDefault();
				});
	
				if(S36Form.strstr(this.is_photo,'media.linkedin.com')){
                    if($('#ln_flag').val() == 1) {
                        $('#crop_photo').hide();
                    }
					return 5;
				}else{
					if (bad_rating) {
						this.next_button.hide();
						S36Form.send_form_data();
						return 6;
					}else{
						return 5;
					}
				}
				
			}
			else{
				return false;
			}
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/	
		
		else{
			if((this.rating == 2) || (this.rating == 1)){
                //this.next_button.hide();
				S36Form.show_complete_form(false);
				return 0;
			}else{ 
                this.next_button.hide();
                S36Form.show_complete_form(true);
				return 2;
			}
		}
	}
	
	/*
	||---------------------------------------
	||  Check Page Five (This is the cropper page!)
	||---------------------------------------
	*/	
	
	PageCycle.prototype._check_page_five = function(next){
	
		/*------------------------
		|  Next button pressed
		-------------------------*/	
	    this._debug("Page 5");	
		if(next){
			if(this.default_photo != this.review_photo){
				return 5;	
			}else{
				$('#crop_status').html('<img src="img/error-ico.png" /> Please Crop Your Photo.');
				return false;
			}
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/	
		
		else{
			return 3;
		}
	}
	
	/*
	||---------------------------------------
	||  Check Page Six
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_six = function(next){
		
		/*------------------------
		|  Next button pressed
		-------------------------*/
	    this._debug("Page 6");		
        
		if(next){
			this.next_button.hide();
			S36Form.send_form_data();	
			return 6;
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/	
		
		else{
			return 3;
		}
	} 
	
	/*
	||---------------------------------------
	||  Check Page Seven
	||---------------------------------------
	*/
	
	PageCycle.prototype._check_page_seven = function(next){
		
		/*------------------------
		|  Next button pressed
		-------------------------*/	
	    this._debug("Page 7");	
		if(next){
			$('#steps').cycle('destroy');
			parent.s36_closeLightbox();
			return false;
		}
		
		/*------------------------
		|  Previous button pressed
		-------------------------*/	
		
		else{
			this.next_button.html("Next");
			return 5;
		}
	}
	
	
/*
||---------------------------------------
||  The Cropper 
||---------------------------------------
*/
PageCycle.prototype._jcrop_initializer = function(){
	this._debug("Cropper Page");		
	if(init <= 0){
	   init = 1;
	   S36Form.init_jcrop();
       $('#steps').cycle(4);
	}else{
	   S36Form.jcrop_api.release();
	   S36Form.jcrop_api.setImage(this.is_photo);
	   S36Form.jcrop_api.setSelect(['40','20','190','170']);
	}
}

PageCycle.prototype._cropper_page = function() { 
    $('#steps').cycle(4);
	S36Form.show_crop_buttons();
}

/*
||---------------------------------------
||  Debugger Toggle
||---------------------------------------
*/
PageCycle.prototype._debug = function(page) {
    if(debug) {
        console.log(page)     
    }
}
