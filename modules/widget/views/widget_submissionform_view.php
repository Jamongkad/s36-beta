<?=HTML::style('themes/form/'.$theme_name.'.css')?>
<?=HTML::script('js/jquery.jcrop.js')?>
<?=HTML::script('js/jquery.ajaxfileupload.js')?>
<?=HTML::script('js/s36FormModule.js')?>
<?=HTML::script('js/cycle.function.js')?>
<?=HTML::script('js/widget/form.js')?>

<!-- linked in -->
<script type="text/javascript" src="http://platform.linkedin.com/in.js">

  <?if($env == 'dev' or $env == 'local'):?>
  //DEV API KEY
  api_key: zmekq26qusj2
  <?endif?>

  <?if($env == 'prod'):?>
  //PROD API KEY
  api_key: 1b773lzkdw3f
  <?endif?>
  authorize: true
</script>

<body style="background:#000">
<!-- facebook scripts -->
<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
  FB.init({appId: '<?=$fb_app_id?>', status: true,
		   cookie: false, xfbml: true});
  FB.Event.subscribe('auth.login', function(response) {
	FB.api('/me', function(user) {
	   if(user != null) {
		  S36Form.fb_connect_success(user);
	   }else{
		  alert('error logging in to facebook');  
	   }
	 });        
  });
</script>
<!-- end of facebook script -->

<!-- 36Stories DataExchange URLs -->
<span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
<span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
<span id="ajax-submit-feedback" hrefaction="<?=URL::to('/api/submit_feedback')?>"></span>
<span id="ajax-step-metrics" hrefaction="<?=URL::to('/api/check_step')?>"></span>
<!-- end of 36Stories script -->

<div id="s36_main">
	<div id="s36_whitebar"></div>    
    <div id="s36_pages">
    	<div id="steps">  
        	<!-- page 1 (rating and feedback text) -->
        	<div id="step_1" class="s36_pages">
                <h1><?=$form_text?></h1>
                <div class="step-contents">
                	<br />
                	<h3>Rate your overall experience</h3>
                    <br />
                    <div id="s36_trackbar">
                        <input type="hidden" id="cropped_photo" value="0"/ >
                        <input type="hidden" id="is_cropped" value="0" />

                        <input type="hidden" id="fb_flag" value="0" />
                        <input type="hidden" id="ln_flag" value="0" />
                        <input type="hidden" id="native_flag" value="0" />

                        <input type="hidden" id="site_id" value="<?=$site_id?>" />
                        <input type="hidden" id="company_id" value="<?=$company_id?>" />
                        <input type="hidden" id="response_flag" value="<?=$response?>" />
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
                    <h4>Tells us what you think in 200 words or less <a href="javascript:;" id="s36_tip" class="s36_tip">What to write?</a></h4>
                    <div id="s36_whattowrite">
                    	<h4><?=$form_question?></h4>
                    </div>
                    <div class="feedback">
                        <textarea id="feedback_text" class="regular-textarea"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- page 2 (permission selection text) -->
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
                                    <p>
                                        By selecting this option you are giving us full permission to publish or feature your feedback in any form we deem fit. 
                                    </p>
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
                                    <p>By selecting this option you are giving us limited permission to publish or feature your feedback on our website only.</p>
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
                                    <p>By selecting this option you are telling us to keep your feedback private and within the confines of our business organization.</p>
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
                	<p>Thank you for granting us permission. <br />Now we need to attach your profile to your feedback.</p>
                    <div class="s36_block s36_align_center">
                        <?=HTML::image('img/facebook-blank-avatar.jpg', 'fb', Array('style' => 'margin-bottom:10px;'))?><br/>
                        <fb:login-button scope="email,user_location,user_website,user_work_history,user_photos">Connect with Facebook</fb:login-button>
                        <br />
                        <br />
                        <style>
							.IN-widget{vertical-align:bottom !important;}
						</style>
                       	<span style="padding-right:3px;">If not.. </span>
                        <br /><br />
                        <script type="IN/Login" data-onAuth="S36Form.linkedin_connect_success">
							Your <span style="color:#26bcf2">linkedIn</span> account is connected. Please proceed to the next step
                        </script> 
                        <span style=""> or <a href="#" id="s36_create_profile">fill out your profile manually</a></span>
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
                </div>
            </div> 
            <!--End of Step 3-->

            <!--Start of Form 4-->
            <div id="step_4" class="s36_pages">
            	<h1>Please Check your details below</h1>
                <input type="hidden" id="profile_link" value="">
                <div class="step-contents">
                	<table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        <td><input type="text" id="your_fname" class="regular-text required" title="First Name" value="" /></td>
                        <td><input type="text" id="your_lname" class="regular-text required" title="Last Name" value="" /></td></tr>
                        <tr><td colspan="2"><input type="text" id="your_email" class="regular-text required long" title="Email Address" value="" /></td></tr>
                    </table>
                    <table id="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="text" id="your_city" class="regular-text required" title="City" value="" /></td><td>
                        
                            <select id="your_country" class="regular-select required" title="Country">
                            <option>Country</option>
                                <?foreach($country as $countries):?>
                                    <option value="<?=$countries->code?>"><?=$countries->name?></option>
                                <?endforeach?>         
                            </select>
                            
                            </td></tr>
                         	<tr>
                            <td><input type="text" id="your_company" value="" class="regular-text" title="Company Name" /></td>
                            <td><input type="text" value="" id="your_occupation" title="Occupation" class="regular-text required" /></td></tr>
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
                                            <div style="margin:5px 0px;">
                                            <input type="file" id="your_photo" class="fileupload" name="your_photo" onChange="S36Form.ajax_file_upload()"/> 
                                                <span id="loading">loading...</span> 
                                            </div>
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
                	<p>Just before you submit your feedback, be sure to check it one last time.</p>
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
                            <p><a href="#" id="crop_photo">Crop Photo</a></p>
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
            
            <!-- page 7 (all done page!) -->
            <div id="step_7" class="s36_pages">
            	<h1>All Done!</h1>
                <div class="step-contents">
                    <p style="line-height:22px;">
                    Thank you for taking the time to send in your feedback, and we will get back to you very shortly. Feedback submitted to our team typically takes about 24-48 working hours to be reviewed and processed.
                    </p>
                </div>
            </div>
            
        </div>
    </div>
    <div class="error-message">
    	<div id="the_error"></div>
    </div>
    <div id="s36_footer">
    	<div class="s36_footerbtn">
        	<a href="javascript:;" id="cancel_cropbtn" class="s36_btn cropbtn">Cancel</a>
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
