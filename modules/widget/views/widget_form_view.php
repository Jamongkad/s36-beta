<?php
//TODO push this to routes...
// GEARFISH - fb
define('YOUR_APP_ID', '171323469605899');
define('YOUR_APP_SECRET', 'b60766ccb12c32c92029a773f7716be8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Feedback Form</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?=HTML::style('themes/'.strtolower($themeColor->name).'/form_default.css')?>
<?=HTML::style('css/flags.css')?>

<?=HTML::script('js/jquery-1.6.2.min.js')?>
<?=HTML::script('js/jquery.cycle.all.min.js')?>
<?=HTML::script('js/jquery.jcrop.js')?>
<?=HTML::script('js/jquery.ajaxfileupload.js')?>
<?=HTML::script('js/s36script.js')?>

<script type="text/javascript">
	$(document).ready(function(){
		
		//hide what to write, error message
		$('#s36_whattowrite').hide();
		//$('#s36_error').hide();
		
		$('#s36_tip').click(function(){
			$('#s36_whattowrite').slideToggle();
		});
		
		$('#loading').hide();
		$('#feedback_permission').hide();
		$('#prev').hide();
		$('.error-message').hide();
		
		// toggle class for each list items
		$('#leave_fb'). click(function(){ $(this).parent().find('li').removeClass(); $(this).addClass('active'); });
		$('#browse_fb').click(function(){ $(this).parent().find('li').removeClass(); $(this).addClass('active'); });

		// initiate the cycle script for the #steps div
		var $steps = $('#steps').cycle({  fx: 'fade', speed: 100, timeout: 0, before: assignClass });	
		
		// move to the manual form if the user doesn't want to connect to facebook:
		$('#create_wo_facebook').click(function(){ $steps.cycle(3); });
		
		// when clicking the next button
		$('#next').click(function(){
				var next = cycle_next();
				if(next)			//if returned true, then cycle the form to the next ui
                    hide_error();		//hide errors
                    $steps.cycle(next);	//cycle
			});
		$('#prev').click(function(){
				var prev = cycle_prev();
				if(prev)			//if returned true, then cycle the form to the prev ui
                    hide_error();		//hide errors
                    $steps.cycle(prev);	//cycle
			});
		// added
		// assign crop script to crop btn
		$('#cropbtn').hide();
		$('#cropbtn').click(function(){
			
			var crop_success = save_crop_image();
			if( crop_success.statusText == 'success' ){
				$steps.cycle(5);	
				// show the next btn
				$('#next').show();				
				// hide the crop btn						
				$('#cropbtn').hide();
				
			}
			
		});
		//end added
		// start the rating slider
		start_slider();
		$('#edit-review-feedback').click(function(){edit_feedback()});
		$('#save-edited-feedback').hide();
		$('#save-edited-feedback').click(function(){save_edited_feedback()});
		
		default_text();

	});
	
	/* end of document ready function. below are custom functions for this form */	
	var init = 0;
	function cycle_next(){
		var cur_step = $('#steps').find('.current').attr('id');
		var rating = selected_rating();
                            
		var default_photo 	= '<?=HTML::image('img/blank-avatar.png')?>';
		var is_photo 		= $('#profile_picture').attr('src');
		var review_photo 	= $('#review-photo').attr('src');
		
		// return this function with a number if the form validation is successful
		if(cur_step == "step_1"){
			var feedback = $('#feedback_text').val();
			if(feedback.length > 0){
				// check the rating				
				if((rating == "2") || (rating == "1")){
					show_complete_form(false);
					console.log("move to 3");
					return 3;
				}else{
					show_complete_form(true);
					console.log("move to 1");
					return 1;
				}
			}else{
				add_error("Please Provide a Feedback"); return false;
			}
		}

        if(cur_step == "step_2"){
            var permission = $('[name="your_permission"]:checked').size();
            if(permission <= 0){
                add_error('Please Select a Permission for your feedback');
                return false;
            }else{
                console.log("move to 2 and 3");
                return 2;
            }
		}
        
        if(cur_step == "step_3"){
			console.log("move to 3 part 2"); 
			return 3;
		}
        
        if(cur_step == "step_4"){
			// the form validations 

			if((rating == "2") || (rating == "1")){
				var val = validate_form('partial'); // validate_form returns 3;
				var crop = false;
			}else{
                //check if avatar is blank...
                if($('#profile_picture').attr('src').match(/blank-avatar/)) {
                    add_error('Profile Photo required...negroes');
                    return false;    
                }

				var val = validate_form('full'); 	// validate_form returns 3;
				var crop = true;
			}

			if(val){						
				// assign all values to the review slide, argument: false if not from jcrop
				assign_to_review(false);

                if(strstr(is_photo, 'media.linkedin.com')) {
                    save_linkedin_image();
                    return 5; 
                }

				if(crop){
					if(is_photo == default_photo){
						console.log("move to 5");
						return 5;
					}else{
						if(init <= 0){
							init = 1;
							init_jcrop();
						}else{
							jcrop_api.release();
							jcrop_api.setImage(is_photo);
							jcrop_api.setSelect(['40','20','190','170']);
						}
						// added
						// hide the next button
						$('#next').hide();				
						// show the crop btn						
						$('#cropbtn').show();
						// end added
						return val;
					}
				}else{
					console.log("move to 5 part two");
					return 5;
				}
			} else{
				return false;
			}
		}

        if(cur_step == "step_5"){ 
                var is_cropped = $('#is_cropped').val();
				if(is_cropped != 0){
                    //what this means is blank avatar is already replaced by the uploaded photo.
					console.log("move to 5 part three");
					return 5;	
				}else{
					$('#crop_button').addClass('highlight');
					add_error("Please crop your photo"); 
					//$('#crop_status').html('<img src="img/error-ico.png" /> Please Crop Your Photo.');
					return false;
				}
		}
        
        if(cur_step == "step_6"){
			$('#next').html("Close");
			send_form_data();	
			console.log("move to 6");	
			return 6;			
		}
        
        if(cur_step == "step_7"){
			$('#steps').cycle('destroy');
			parent.s36_closeLightbox();
			//window.close();
			return false;
		}		
	}// end of cycle next

	function cycle_prev(){
		var cur_step = $('#steps').find('.current').attr('id');
		var rating = selected_rating();
			if(cur_step == "step_2"){
				return 0;
			}
            
            if(cur_step == "step_3"){
				return 1;
			}
            
            if(cur_step == "step_4"){
				
				if((rating == "2") || (rating == "1")){
					show_complete_form(false);
					return 0;
				}else{
					show_complete_form(true);
					return 2;
				}
			}
            
            if(cur_step == "step_5"){
               // added
				// hide the next button
				$('#next').show();				
				// show the crop btn						
				$('#cropbtn').hide();
				// end added
				return 3;
			}
            
            if(cur_step == "step_6"){
		        var default_photo 	= '<?=HTML::image('img/blank-avatar.png')?>';
				var is_photo = $('#profile_picture').attr('src');
				if((is_photo == default_photo) || (rating == "2") || (rating == "1")){
					return 3;
				}else{
					// added
					// hide the next button
					$('#next').hide();				
					// show the crop btn						
					$('#cropbtn').show();
					//end added
					return 4;
				}
			}
            
            if(cur_step == "step_7"){
				$('#next').html("Next");
				return 5;
			}else{
				return false;
			}
		}//end of cycle prev
</script>

<!-- linked in -->
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key:   zmekq26qusj2
  authorize: true
</script>

</head>
<span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
<span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
<span id="ajax-submit-feedback" hrefaction="<?=URL::to('/api/submit_feedback')?>"></span>

<body style="background:#000">
<!-- facebook scripts -->
<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
  FB.init({appId: '<?php echo YOUR_APP_ID ?>', status: true,
		   cookie: false, xfbml: true});
  FB.Event.subscribe('auth.login', function(response) {
	FB.api('/me', function(user) {
	   if(user != null) {
		  //alert(dump(user)); //debugger
		  console.log('fb connect');
		  fb_connect_success(user);
	   }else{
		  alert('error logging in to facebook');  
	   }
	 });        
  });
</script>
<!-- end of facebook script -->

<div id="s36_main">
	<div id="s36_whitebar"></div>
    
    <div id="s36_pages">
    	<div id="steps">
            <!--Step 1 of Form-->	
        	<div id="step_1" class="s36_pages">
                <h1>Share Your Feedback About Us</h1>
                <div class="step-contents">
                	<br />
                	<h3>Rate your overall experience</h3>
                    <br />
                    <div id="s36_trackbar">
                        <input type="hidden" id="cropped_photo" value="0"/ >
                        <input type="hidden" id="is_cropped" value="0" />

                        <input type="hidden" id="fb_flag" value="0" />
                        <input type="hidden" id="ln_flag" value="0" />

                        <input type="hidden" id="site_id" value="<?=$siteId?>" />
                        <input type="hidden" id="company_id" value="<?=$companyId?>" />
                        <input type="hidden" id="rating" value="5" />
                        <div id="track_ball"></div>
                        <div id="rate_e"></div>
                        <div id="rate_g"></div>
                        <div id="rate_a"></div>
                        <div id="rate_p"></div>
                        <div id="rate_b"></div>
                    </div>
                    <div id="s36_ratings">
                        <ul>
                            <li class="excellent">EXCELLENT</li>
                            <li class="good">GOOD</li>
                            <li class="average">AVERAGE</li> 
                            <li class="poor">POOR</li>
                            <li class="bad">BAD</li>
                        </ul>
                    </div>
                    <br />
                    <h3>Tell us what you think in 200 words or less <a href="javascript:;" id="s36_tip" class="s36_tip">What to write?</a></h3>
                    <br />
                    <div id="s36_whattowrite">
                    	<h4>This is a customisable-field in backend</h4>
                        <ul>
                        	<li>Where did you hear bout us?
							<li>Were there previous products you were unsatisfied with?</li>
							<li>Was there anything you didn't expect?</li>
                        </ul>
                    </div>
                    <br />
                    <div class="feedback">
                        <textarea id="feedback_text" class="regular-textarea"></textarea>
                    </div>
                </div>
            </div>
            <!--end of Step 1--> 

            <!--Step 2 of Form-->
            <div id="step_2" class="s36_pages">
            	<h1>Give us permission for your feedback</h1>
                <div class="step-contents">
                	<div id="s36_pemissions">
                    	<div class="s36_block">
                        	<div class="s36_perm_radio">
                            	<input type="radio" id="permission1" name="your_permission" value="1" />
                            </div>
                            <label for="permission1">
                            <div class="s36_perm_details">
                                <div class="s36_perm_icon">
                                	<div class="s36_perm_icon1"></div>
                                </div>
                                <div class="s36_perm_text">
                                	<h3>Yes, with full permission</h3>
                                    <p>This allows us to use the positive feedback anywhere and everywhere we want. </p>
                                </div>
                            </div>
                            </label>
                        </div>
                        <div class="s36_block">
                        	<div class="s36_perm_radio">
                            	<input type="radio" id="permission2" name="your_permission" value="2" />
                            </div>
                            <label for="permission2">
                            <div class="s36_perm_details">
                                <div class="s36_perm_icon">
                                	<div class="s36_perm_icon2"></div>
                                </div>
                                <div class="s36_perm_text">
                                	<h3>Yes, but with limited permission</h3>
                                    <p>This allows us to use the feedback only on the website.</p>
                                </div>
                            </div>
                            </label>
                        </div>
                        <div class="s36_block">
                        	<div class="s36_perm_radio">
                            	<input type="radio" id="permission3" name="your_permission" value="3" />
                            </div>
                            <label for="permission3">
                            <div class="s36_perm_details">
                                <div class="s36_perm_icon">
                                	<div class="s36_perm_icon3"></div>
                                </div>
                                <div class="s36_perm_text">
                                	<h3>Keep your feedback private</h3>
                                    <p>This feedback is NOT public.</p>
                                </div>
                            </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div> 
            <!--End of Step 2-->
 
            <!--Start of Form 3-->
            <div id="step_3" class="s36_pages">
            	<h1>Attach your profile</h1>
                <div class="step-contents">
                	<p>Thank your for granting us permission. <br />Now we need to attach your profile to your feedback.</p>
                    <br />
                    <div class="s36_block s36_align_center">
                        <fb:login-button perms="email,user_location,user_website,user_work_history,user_photos">Connect with Facebook</fb:login-button>
                        <br />
                        <br />
                        <script type="IN/Login" data-onAuth="loadData">
							Your <span style="color:#26bcf2">linkedIn</span> account is connected. Please proceed to the next step
                        </script>
                        <br />
                        <br />
                        <a href="javascript:;" id="create_wo_facebook">
                        <?=HTML::image('img/36stories-btn.png')?>
                        </a>
                    </div>
                    <br />
                    <div class="s36_block gray">
                        <div class="warning">
                            <?=HTML::image('img/ico-warning.png')?>
                        </div>
                        <div class="warning-text">
                        	We only use Facebook Connect to retrieve and attach your profile information. We do not post updates on your wall without your permission. <em>We hate that</em>.
                        </div>
                    </div>
                    <div class="s36_block gray" style="margin-top:15px;">
                        <div class="company">
                        	<?=$company_name->name?> uses 36Stories - a feedback company to help process your feedback
                        </div>
                    </div>
                </div>
            </div> 
            <!--End of Step 3-->

            <!--Start of Form 4-->
            <div id="step_4" class="s36_pages">
            	<h1>Please Check your details below</h1>
                <div class="step-contents">
                	<table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="text" id="your_fname" class="regular-text required" title="First Name" value="" /></td><td><input type="text" id="your_lname" class="regular-text required" title="Last Name" value="" /></td></tr>
                        <tr><td colspan="2"><input type="text" id="your_email" class="regular-text required long" title="Email Address" value="" /></td></tr>
                    </table>
                    <table id="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="text" id="your_city" class="regular-text required" title="City" value="" /></td><td><select id="your_country" class="regular-select required" title="Country"><option>Country</option>
                                    <?foreach($country as $countries):?>
                                        <option value="<?=$countries->code?>"><?=$countries->name?></option>
                                    <?endforeach?>
                                    
                                </select></td></tr>
                         	<tr><td><input type="text" id="your_company" value="" class="regular-text" title="Company Name" /></td><td><input type="text" value="" id="your_occupation" title="Occupation" class="regular-text required" /></td></tr>
                            <tr><td colspan="2"><input type="text" id="your_website" class="regular-text long" value="" title="Website Address" /></td></tr>
                            <tr bgcolor="#e6e8e8">
                                <td colspan="2">
                                    <div class="avatar">

                                    <?=HTML::image('img/blank-avatar.png', false, array( 'id' => 'profile_picture'
                                                                                        , 'style' => ' border:2px solid #CCC;'
                                                                                        , 'width' => 97))?>
                                    
                                    </div>
                                    <div class="avatartext">
                                        <div style="padding-left:10px;font-weight:bold;">
                                            Select your display profile photo. <br />
                                            You can also use your company <br />
                                            logo if you like. <br />
                                            <div style="margin:5px 0px;"><input type="file" id="your_photo" class="fileupload" name="your_photo" onChange="ajaxFileUpload()"/> <span id="loading">loading...</span> </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    </table>
                </div>
            </div> 
            <!--End of Step 4-->

            <!--Start of Step 5-->
            <div id="step_5" class="s36_pages">
            	<h1>Adjust and crop your image</h1>
                <div class="step-contents">
                	<div class="s36_block s36_align_center gray" style="padding:15px 0px;">
                    	<div class="jcrop_div">
                            <?=HTML::image('img/sample-avatar.png', 'Profile Picture', array('id' => 'jcrop_target'))?>
                        </div>
                        <!--
                        <a href="javascript:;" onclick="save_crop_image()" class="s36_blue_btn">Save Image</a>
                        -->
                    </div>
                    <div style="width:100px;text-align:center;font-size:10px;color:#CCC;float:left;">
                    	<div style="margin-bottom:5px">Preview</div>
                        <div style="width:100px;height:100px;overflow:hidden;">
                               <?=HTML::image('img/sample-avatar.png', false, array('id' => 'preview'))?>
                        </div>
                    </div>
                    <div style="width:200px;float:left;margin-left:10px;">
                    	<h3 style="margin-left:3px;margin-top:10px;">is this to your liking?</h3>
                        <div id="test_showcoords"></div>
                        <span id="crop_status"></span>
                        <form>
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />
                        </form>
                    </div>
                </div>
            </div>
            <!--End of Step 5-->

            <!--Start of Step 6--> 
            <div id="step_6" class="s36_pages">
            	<h1>Review your feedback</h1>
                <div class="step-contents">
                	<p>Just before you submit in your feedback, be sure to check it one more time.</p>
                    <div class="review-profile">
                    	<div class="review-avatar s36_align_center">

                            <?=HTML::image('img/blank-avatar.png', false, array( 'id' => 'review-photo'
                                                                                , 'width' => 100))?>
                        </div>
                        <div class="review-profile-info">
							<h3 id="review-name"></h3>
                            <h4 id="review-position"></h4>
                            <p  id="review-location"></p>
                            <p  id="review-date"></p>
                        </div>
                    </div>
                    <div class="review-change-photo"></div>
                    <div class="review-feedback-box" id="review-feedback-box">
                    	<div id="review-feedback" class="review-feedback"></div>
                        <div class="review-edit-feedback">
                            <a href="javascript:;" id="edit-review-feedback">edit</a>
                            <a href="javascript:;" id="save-edited-feedback">save</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="step_7" class="s36_pages">
            	<h1>All Done!</h1>
                <div class="step-contents">
                    <p style="line-height:22px;">Thank you for taking the time to send in your feedback, and we will get back to you very shortly. Feedback submitted t our team typically takes about 24-48 working hours to be reviewed and processed.</p>
                </div>
            </div>
            <!--End of Step 6-->
        </div>
    </div>
    <div class="error-message">
    	<div id="the_error"></div>
    </div>
    <div id="s36_footer">
    	<div class="s36_footerbtn">
        	<a href="javascript:;" id="prev" class="s36_btn">Back</a>
        </div>
        <div class="s36_footertext">
        	Powered by 36Stories
        </div>
        <div class="s36_footerbtn">
        	<a href="javascript:;" id="cropbtn" class="s36_btn cropbtn">Crop</a>
            <a href="javascript:;" id="next" class="s36_btn">Next</a>
        </div>
    </div>
</div>
</body>
</html>
