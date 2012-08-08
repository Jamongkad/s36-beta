<?=HTML::script('/js/widget/form/s36FormModule.js')?>
<?
    $js_scripts = Array(
         '/js/jquery.jcrop.js' 
       , '/js/jquery.ajaxfileupload.js'
       , '/js/widget/form/cycle.function.js'
       , '/js/widget/form/form.js'
    );
?>
<script text="text/javascript">
    <?foreach($js_scripts as $scripts):?>
       head.js('<?=$scripts?>');
    <?endforeach?>
</script>

<script type="text/javascript">
	$(document).ready(function(){ 

        S36Form.start_slider('long');

		$('.s36_perm_details').click(function(){
			$('.s36_perm_details').css('opacity','0.6').parent().parent().css('border','solid 2px #FFF');
			$(this).css('opacity','1').parent().parent().css('border','solid 2px #CCC');
		});
    });
</script>

<script type="text/javascript" src="https://platform.linkedin.com/in.js">

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
<style type="text/css">
#fb-false-connect{
    background:url(/img/fb-connect-success.jpg) no-repeat;
    width:165px;
    height:22px;
    cursor:pointer;
    margin:0 auto;
}
#step_2,#step_3,#step_4,#step_5,#step_6,#step_7{
    display:none;
}

#edited-textarea {     
    background:#f7f7f7;
    border:1px solid #e1e1e1;
    padding:10px;
    width:360px;
    height:110px;
    font-family:Arial, Helvetica, sans-serif;
}

#submission-loader {
    text-align:center; margin:0 auto
}

#submission-success {
    line-height:22px;
}
</style>

<!-- facebook scripts -->
<div id="fb-root"></div>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
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
<?if(Input::get('test')):?>
    <span id="ajax-submit-feedback" hrefaction="<?=URL::to('/tests/submissionservice')?>"></span>
<?else:?>
     <span id="ajax-submit-feedback" hrefaction="<?=URL::to('/api/submit_feedback')?>"></span>
<?endif?>

<span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
<span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
<span id="ajax-step-metrics" hrefaction="<?=URL::to('/api/check_step')?>"></span>
<!-- end of 36Stories script -->

<div id="bodyWrapper">
	<div id="bodyContent">
    	<!-- form box starts here -->
        <div id="feedbackBox">
        	<div class="block">
            	<div id="s36_pages">
                    <div id="steps">
                        <!-- page 1 (rating and feedback text) -->
                        <div id="step_1" class="s36_pages current">
                            <div class="formTitle">
                                <?if($hosted):?> 
                                    <h2><?=$hosted->submit_form_text?></h2> 
                                <?else:?>
                                    <h2>Share Your Feedback About Us</h2> 
                                <?endif?> 
                            </div>
                            <div class="step-contents">
                                <div style="float:left;width:235px;padding:0px 30px 0px 0px;">
                                	<br /><br />
                                    <h3>Rate your overall experience</h3>
                                    <br /><br /><br />
                                    <h3>Tell us what you think in 200 words or less</h3>
                                </div>
                                <div style="float:left;width:473px;">
                                	<br />
                                    <div id="s36_trackbar">
                                        <input type="hidden" id="cropped_photo" value="0"/ >
                                        <input type="hidden" id="fb_flag" value="0" />
                                        <input type="hidden" id="ln_flag" value="0" />
                                        <input type="hidden" id="native_flag" value="0" />

                                        <input type="hidden" id="company_name" value="<?=$company->company_name?>" />
                                        <input type="hidden" id="domain" value="<?=$site_domain?>" />
                                        <input type="hidden" id="site_id" value="<?=$site_id?>" />
                                        <input type="hidden" id="company_id" value="<?=$company_id?>" />
                                        <input type="hidden" id="response_flag" value="<?=$response?>" />
                                        <input type="hidden" id="rating" value="3" />

                                        <div id="track_ball"></div>
                                        <div id="rate_b"></div>
                                        <div id="rate_p"></div>
                                        <div id="rate_a"></div>
                                        <div id="rate_g"></div>
                                        <div id="rate_e"></div>
                                    </div>
                                    <div id="s36_ratings">
                                        <ul>
                                            <li class="bad">BAD</li>
                                            <li class="poor">POOR</li>
                                            <li class="average">AVERAGE</li> 
                                            <li class="good">GOOD</li>
                                            <li class="excellent">EXCELLENT</li>
                                        </ul>
                                    </div>
                                    <br />
                                    <div class="feedback">
                                        <textarea id="feedback_text" class="regular-textarea reg-text-active" 
                                            <?if($hosted):?>
                                                  title="<?=trim($hosted->submit_form_question)?>"
                                            <?else:?>
                                                  title="<?=trim($form_question)?>"
                                            <?endif?> 
                                            >
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- page 2 (permission selection text) -->
                        <div id="step_2" class="s36_pages">
                            <div class="formTitle">
                            	<h2>Give us permission for your feedback</h2>
                            </div>
                            <div class="step-contents">
                            	<br /><br />
                            	<h3>Thanks for giving us an excellent/good rating! Could we feature your positive feedback as a testimonial?</h3>
                                
                                <div id="s36_pemissions">
                                    <div class="s36_block full">
                                        <div class="s36_perm_radio">
                                            <input type="radio" id="permission1" name="your_permission" value="1" />
                                        </div>
                                        <label for="permission1">
                                        <div class="s36_perm_details">
                                        	<br />
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
                                    <div class="s36_block limited">
                                        <div class="s36_perm_radio">
                                            <input type="radio" id="permission2" name="your_permission" value="2"  />
                                        </div>
                                        <label for="permission2">
                                        <div class="s36_perm_details">
                                        	<br />
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
                                    <div class="s36_block private">
                                        <div class="s36_perm_radio">
                                            <input type="radio" id="permission3" name="your_permission" value="3" />
                                        </div>
                                        <label for="permission3">
                                        <div class="s36_perm_details">
                                        	<br />
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
                        
                        <!-- page 3 (facebook - linkedin connect) -->
                        <div id="step_3" class="s36_pages">
                            <div class="formTitle">
                            	<h2>Attach your profile</h2>
                            </div>
                            <div class="step-contents">
                            	<br /><br />
                                <h3 style="text-align:center">Thank you for granting us permission. Now we need to attach your profile to your feedback.</h3>
                                <br />
                                <div class="s36_block s36_align_center">
                                    <div id="fb-connect-button">
                                    
                                        <fb:login-button scope="email,user_location,user_website,user_work_history,user_photos">Connect with Facebook</fb:login-button>
                                        
                                    </div>
                                    <br />
                                    <style>
                                        .IN-widget{vertical-align:bottom !important;}
                                    </style>
                                    <span style="padding-right:3px;">
                                    If not.. </span>
                                    <br /><br />
                                    <script type="IN/Login" data-onAuth="loadData">
                                        Your <span style="color:#26bcf2">linkedIn</span> account is connected. Please proceed to the next step
                                    </script> <span style=""> ... or <a href="javascript:;" id="s36_create_profile">fill out your profile manually</a>
                                    </span>
                                </div>
                                <br />
                                <div class="s36_block gray">
                                    <div class="warning">
                                        <?=HTML::image('img/ico-warning.png')?>
                                    </div>
                                    <div class="warning-text">
                                        We only use Facebook Connect to retrieve and attach your profile information. We do not post updates on <br /> your wall without your permission. <em>We hate that</em>.
                                    </div>
                                </div>
                                <!--
                                <div class="s36_block gray" style="margin-top:15px;">
                                    <div class="company">
                                        Razer uses 36Stories - a feedback company to help process your feedback
                                    </div>
                                </div>
                                -->
                            </div>
                        </div>
                        
                        <!-- page 4 (profile form and photo upload) -->
                        <div id="step_4" class="s36_pages">
                            <div class="formTitle">
	                            <h2>Please check your details below</h2>
                            </div>
                            <div id="bad-feedback-message">
                                <h3 style="padding-top:25px;text-align:center">
                                    Thanks for your feedback. In order for us to get back to you fill in your contact details below.
                                </h3> 
                            </div>

                            <input type="hidden" id="profile_link" value="">
                            <div class="step-contents">

                                <div id="hostform_info" style="width:50%;float:left;">
                                <table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                                    <tr><td colspan="2"><strong>Required Fields</strong></td></tr>
                                    <tr><td><input type="text" id="your_fname" class="regular-text required" title="First Name" value="" /></td><td><input type="text" id="your_lname" class="regular-text required" title="Last Name" value="" /></td></tr>
                                    <tr><td colspan="2"><input type="text" id="your_email" class="regular-text required long" title="Email Address" value="" /></td></tr>
                                </table>
                                <table id="form_complete" class="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4">
                                    <tr><td><input type="text" id="your_city" class="regular-text required" title="City" value="" /></td><td>
                                    <select id="your_country" class="regular-select required" title="Country">
                                        <option>Country</option>
                                        <?foreach($country as $countries):?>
                                            <option value="<?=$countries->code?>"><?=$countries->name?></option>
                                        <?endforeach?>         
                                    </select>
                                        </td></tr>
                                        <tr><td colspan="2"><strong>Optional info - but great to include!</strong></td></tr>
                                        <tr><td><input type="text" id="your_company" value="" class="regular-text" title="Company Name" /></td><td><input type="text" value="" id="your_occupation" title="Occupation" class="regular-text required" /></td></tr>
                                        <tr><td colspan="2"><input type="text" id="your_website" class="regular-text long" value="" title="Website Address" /></td></tr>
                                </table>
                                </div>

                                <div id="hostform_photo" style="width:50%;float:left;">
                                	<div style="padding:50px 20px;">
                                        <table id="form_complete" class="form_complete" width="100%" border="0" cellpadding="4" cellspacing="4" bgcolor="#e6e8e8" >
                                                <tr class="tr-photo-upload">
                                                    <td>
                                                        <div class="avatar">
                                                            <?=HTML::image('img/blank-avatar.jpg', false, array( 'id' => 'profile_picture'
                                                                                                                , 'style' => 'border:2px solid #CCC;'
                                                                                                                , 'width' => 97))?> 
                                                        </div>
                                                    </td>
                                                    <td valign="top">
                                                        <div class="avatartext">
                                                            <div style="font-weight:normal;">
                                                                <strong>Select your display profile photo.</strong> <br />
                                                                You can also use your company <br />
                                                                logo if you like. <br />
                                                                <div style="margin:5px 0px;"><input type="file" id="your_photo" class="fileupload" name="your_photo" onChange="S36Form.ajax_file_upload()"/> <span id="loading">Uploading Image...</span> </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- page 5 (photo cropper) -->
                        <div id="step_5" class="s36_pages">
                        	<div class="formTitle">
	                            <h2>Adjust and crop your image</h2>
                            </div>
                            <div class="step-contents">
	                            <br />
                            	<div style="width:50%;float:left;">
                                    <div class="s36_block s36_align_center gray" style="padding:15px 0px;">
                                        <div class="jcrop_div">
                                            <?=HTML::image('img/blank-avatar.jpg', 'Profile Picture', array('id' => 'jcrop_target'))?>
                                        </div>
                                        <!-- <a href="javascript:;" onclick="save_crop_image()" class="s36_blue_btn">Save Image</a> -->
                                    </div>
                                </div>
                                <br />
                                <div style="width:50%;float:left;">
                                	<div style="padding:0px 20px;">
                                        <div style="width:100px;text-align:center;font-size:10px;color:#CCC;float:left;">
                                            <div style="margin-bottom:5px">Preview</div>
                                            <div style="width:100px;height:100px;overflow:hidden;">
                                                <?=HTML::image('img/blank-avatar.png', false, array('id' => 'preview'))?>
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
                            </div>
                        </div>
                        
                        <!-- page 6 (review profile and feedback page) -->
                        <div id="step_6" class="s36_pages">
                        	<div class="formTitle">
	                            <h2>Review your feedback</h2>
                            </div>
                            <div class="step-contents">
                            	<br />
                                <h3>Just before you submit in your feedback, be sure to check it one more time.</h3>
                                <div style="width:30%;float:left;">    
                                    <div class="review-profile">
                                        <br />
                                        <div class="review-avatar s36_align_center">
                                            <?=HTML::image('img/blank-avatar.jpg', false, array( 'id' => 'review-photo'
                                                                                                , 'width' => 100))?>
                                        </div>    
                                        <div class="review-profile-info">
                                            <h2 id="review-name"></h2>
                                            <p id="review-position"></p>
                                            <p  id="review-location"></p>
                                            <p  id="review-date"></p>
                                            <p><a href="javascript:;" id="crop_photo">Adjust Photo (Optional)</a></p>
                                        </div>
                                    </div>
								    <div class="review-change-photo"></div>                                    
                                 </div>
                                 <br />
                                 <div style="width:70%;float:left;"> 
                                    <div class="review-feedback-box" id="review-feedback-box">
                                        <div id="review-feedback" class="review-feedback"></div>
                                        <div class="review-edit-feedback">
                                            <a href="javascript:;" id="edit-review-feedback">edit</a>
                                            <a href="javascript:;" id="save-edited-feedback">save</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- page 7 (all done page!) -->
                        <div id="step_7" class="s36_pages">

                            <div class="formTitle"> 
                                <h2 id="submission-loader-header">Feedback in transit...</h2>
                                <h2 id="submission-success-header">All Done!</h2> 
                            </div>
                           
                            <div class="step-contents" style="padding-top:25px">
                                <p id="submission-loader"> 
                                    Your feedback is being processed please wait...<br/><br/>
                                    <?=HTML::image('img/submission-loader.gif', 'submission')?><br/>
                                </p>
                                <p id="submission-success">
                                    Thank you for taking the time to send in your feedback, and we will get back to you very shortly. 
                                    Feedback submitted to our team typically takes about 24-48 working hours to be reviewed and processed.
                                    <br/><br/>
                                    Click <a href="submit">here</a> to submit more feedback.
                                </p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="error-message">
                <div id="the_error"></div>
            </div>
            <div id="s36_footer">
                <div class="s36_footerbtn left">
                    <a href="javascript:;" id="cancel_cropbtn" class="s36_btn cropbtn">Cancel</a>
                    <a href="javascript:;" id="prev" class="s36_btn">Back</a>
                </div>
                
                <div class="s36_footerbtn right">
                    <a href="javascript:;" id="cropbtn" class="s36_btn cropbtn">Crop</a>
                    <a href="javascript:;" id="next" class="s36_btn">Next Step</a>
                </div>
            </div>
        </div>
        <!-- form box ends here -->
