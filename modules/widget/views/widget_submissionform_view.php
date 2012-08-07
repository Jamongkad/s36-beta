<?if($theme_name !== 'form-dark'):?>
    <?=HTML::style('css/widget_master/form-master.css')?>
<?endif?>
<?=HTML::style('themes/form/'.$theme_name.'.css')?>
<?=HTML::script('/js/widget/form/s36FormModule.js')?>

<?=HTML::script('/js/jquery.jcrop.js')?>
<?=HTML::script('/js/jquery.ajaxfileupload.js')?>
<?=HTML::script('/js/widget/form/cycle.function.js')?>
<?=HTML::script('/js/widget/form/form.js')?>

<?
    $js_scripts = Array(
         '/js/jquery.jcrop.js' 
       , '/js/jquery.ajaxfileupload.js'
       , '/js/widget/form/cycle.function.js'
       , '/js/widget/form/form.js'
    );
?>
<script text="text/javascript">
    <?//foreach($js_scripts as $scripts):?>
       //head.js('<?//=$scripts?>');
    <?//endforeach?>
</script>
<!-- linked in -->
<script type="text/javascript">
	$(document).ready(function(){ 
        S36Form.start_slider();

        $('#s36_pemissions .s36_perm_details').click(function(){
            $('#s36_pemissions .s36_perm_details').removeClass('active_perm');
            $(this).addClass('active_perm');
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

<body style="background:#000">
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

  $(document).ready(function() {
      
    $("#shareToFB").click(function(){
        share_on_facebook();
    });

    function share_on_facebook(){
        FB.login(function(response){
            if (response.status == 'connected'){
                
                var hosted_feedback = 'http://webmumu.com/s36-facebook';	//Link where the user is redirected after clicking Post A Feedback
                var publish = {
                  method: 'stream.publish', 								//Action that will tell facebook to post this message (do not change)
                  message: 'Well I just posted an excellent Feedback!',		//Post message, not the feedback. e.g "I just posted an excellent Feedback for ???"
                  picture : 'https://dev.gearfish.com/img/36logo2.png',		//36Stories Logo or Company Logo?
                  link : 'http://webmumu.com/s36-facebook',					//When the title is clicked, this is where the user is redirected this can be the company page
                  name: 'Webmumu just got an excellent feedback!',			//The Title of the Post. This is the blue link title e.g "Company Name just got an excellent feedback!"
                  caption: 'This is awesome!',								//Optional. small text under the title
                  description: 'Webmumu is an awesome website! Dan Oliver is a good web developer, he is awesome! Very good at web design and development! Works very fast and on time!',	//The Feedback the feedback!!!
                  actions : { name : 'Post A Feedback', link : hosted_feedback}
                };
                
                publishPost(publish);
            }else{
                //console.log('login failed');
            }
        }, {scope:'publish_stream'});
    }
    
    function publishPost(publish){
        FB.api('/me/feed', 'POST', publish, function(response) {
            $('#fb-share-post-success').fadeIn();
        });
    }
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
                        <input type="hidden" id="fb_flag" value="0" />
                        <input type="hidden" id="ln_flag" value="0" />
                        <input type="hidden" id="native_flag" value="0" />

                        <input type="hidden" id="company_name" value="<?=$company_name?>" />
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
                    <h3>Tell us what you think in 200 words or less</h3>
                    <div class="feedback">
                        <textarea id="feedback_text" class="regular-textarea" title="<?=trim($form_question)?>"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- page 2 (permission selection text) -->
            <div id="step_2" class="s36_pages"> 
            	<h1>Give us permission for your feedback</h1>
                <div id="good-feedback-message">
                    <p style="font-size:14px;padding-left:25px;padding-right:15px;padding-top:12px;">
                        Thanks for giving us an excellent/good rating!<br/><br/>
                        Could we feature your positive feedback as a testimonial?
                    </p> 
                </div>
                <div class="step-contents">
                	<div id="s36_pemissions">
                    	<div class="s36_block full">
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
                                        This allows us to use the positive feedback anywhere and everywhere we want. 
                                    </p>
                                </div>
                            </div>
                            </label>
                        </div>
                        <div class="s36_block limited">
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
                                    <p>
                                        This allows us to use the feedback only on the website.
                                    </p>
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
                                <div class="s36_perm_icon">
                                	<div class="s36_perm_icon3"></div>
                                </div>
                                <div class="s36_perm_text">
                                	<h3>Keep your feedback private</h3>
                                    <p>
                                        This feedback is NOT public. 
                                    </p>
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
                        <div id="fb-connect-button">
                            <fb:login-button scope="email,user_location,user_website,user_work_history,user_photos">Connect with Facebook</fb:login-button>
                        </div>
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
            	<h1>Please check your details below</h1>
                <div id="bad-feedback-message">
                    <p style="font-size:14px;padding-left:25px;padding-right:15px;padding-top:25px;">
                        Thanks for your feedback. In order for us to get back to you <br/>fill in your contact details below.
                    </p> 
                </div>
                <input type="hidden" id="profile_link" value="">
                <div class="step-contents">
                	<table id="s36_form" width="100%" border="0" cellpadding="4" cellspacing="4">
                        <tr><td colspan="2"><strong>Required Fields</strong></td>
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
                                <tr><td colspan="2"><strong>Optional info - but great to include!</strong></td></tr> 
                             <tr> 
                             <td><input type="text" id="your_company" value="" class="regular-text" title="Company Name" /></td> 
                             <td><input type="text" value="" id="your_occupation" title="Occupation" class="regular-text required" /></td></tr>   
                            <tr><td colspan="2"><input type="text" id="your_website" class="regular-text long" value="" title="Website Address" />
                            </td></tr>                         
                            <tr bgcolor="#e6e8e8"> 
                                 <td colspan="2"> 
                                     <div class="avatar">  
                                         <?=HTML::image('img/blank-avatar.jpg', false, array( 'id' => 'profile_picture' 
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
                                                 <span id="loading">Uploading Image...</span>  
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
                            <?=HTML::image('img/blank-avatar.jpg', 'Profile Picture', array('id' => 'jcrop_target'))?>
                        </div>
                    </div>
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
            <!--End of Step 5-->

            <!--Start of Step 6--> 
            <div id="step_6" class="s36_pages">
            	<h1>Review your feedback</h1>
                <div class="step-contents">
                	<p style="margin-top: 12px">Just before you submit your feedback, be sure to check it one last time.</p>
                    <div class="review-profile">
                    	<div class="review-avatar s36_align_center">
                            <?=HTML::image('img/blank-avatar.jpg', false, array( 'id' => 'review-photo'
                                                                                , 'width' => 100))?>
                        </div>
                        <div class="review-profile-info">
							<h3 id="review-name"></h3>
                            <h4 id="review-position"></h4>
                            <p  id="review-location"></p>
                            <p  id="review-date"></p>
                            <p><a href="#" id="crop_photo">Adjust Photo (Optional)</a></p>
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
                <h1 id="submission-loader-header">Feedback in transit...</h1>
            	<h1 id="submission-success-header">All Done!</h1>
                <div class="step-contents" style="padding-top:25px">
                    <p id="submission-loader"> 
                        Your feedback is being processed please wait...<br/><br/>
                        <?=HTML::image('img/submission-loader.gif', 'submission')?><br/>
                    </p>
                    <p id="submission-success">
                        Thank you for taking the time to send in your feedback, and we will get back to you very shortly. 
                        Feedback submitted to our team typically takes about 24-48 working hours to be reviewed and processed.
                        <br/><br/>
                        Please press the (X) button on the upper right hand corner of the form to close this box.
                   
                        <div id="share-panel">
                            <div class="all-done-feedback-box">
                                <p></p>
                            </div>
                            <div class="share-buttons">
                                <div class="fb-share-button">
                                    <a href="javascript:;" id="shareToFB">
                                        <?=HTML::image('img/fb-share-btn.png', 'Share to Facebook')?>
                                    </a>
                                </div>
                                <div class="tw-share-button">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://companyname.com" data-text="I recommend co-name, just sent them some great feedback over at co-hosted-page-address. Go check them out!" data-size="large" data-count="none">Tweet</a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                </div>
                            </div>
                            
                            <div id="fb-share-post-success">
                                <span class="share-success">Feedback has been successfully shared on Facebook. Thank you!</span>
                            </div>
                            <br />
                            <br/>
                            <h3>Like us on Facebook and follow us on Twitter</h3>
                            <!--TODO when company sets up FB page on settings reveal fb-like-link
                            <div class="fb-like-link">
                                <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwebmumu.com&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=<?=$fb_app_id?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:380px; height:30px;" allowTransparency="true"></iframe>
                            </div>
                            <div class="tw-follow-link">
                                <a href="https://twitter.com/danoliverC" class="twitter-follow-button" data-show-count="false">Follow @danoliverC</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                            -->
                        </div>
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
        	&nbsp;
        </div>

        <div class="s36_footerbtn">
        	<a href="javascript:;" id="cropbtn" class="s36_btn cropbtn">Crop</a>
            <a href="javascript:;" id="next" class="s36_btn">Next</a>
        </div>
    </div>
</div>
</body>
