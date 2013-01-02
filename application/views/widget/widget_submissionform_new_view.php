<?=HTML::style('css/widget_master/new_form.css');?>
<?//=HTML::style('css/jquery.formbuilder.css')?>
<?=HTML::script('js/jcycle.js');?>
<?=HTML::script('js/jquery.ui.widget.js');?>
<?=HTML::script('js/jquery.iframe-transport.js');?>
<?=HTML::script('js/jquery.fileupload.js');?>
<?=HTML::script('https://cloud.github.com/downloads/bytespider/jsOAuth/jsOAuth-1.3.6.min.js');?>
<?=HTML::script('js/jquery.oauth.js');?>

<!-- file upload js requirements -->

<!-- link preview js -->
<?=HTML::script('js/link.preview.js');?>
<!-- link preview js -->
<!--[if lt IE 8]>
    <script src="js/ie7.js"></script>
<![endif]-->
<?
$facebook_username = Null;
$twitter_username = Null;
if($twitter = $company_social->fetch_social_account('twitter')) {
    $tw = Helpers::unwrap($twitter->socialaccountvalue);
    $twitter_username = $tw['accountName'];
}

if($facebook = $company_social->fetch_social_account('facebook')) {
    $fb = Helpers::unwrap($facebook->socialaccountvalue);
    $facebook_username = $fb['accountName'];
}
?>

<div id="fb-root"></div>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
FB.init({appId: '<?=$fb_app_id?>', status: true, cookie: true});   
</script>

<script type="text/javascript" src="https://platform.linkedin.com/in.js">

  <?if($env == 'dev' or $env == 'local'):?>
  //DEV API KEY
  api_key: 1m2dv6lkxpoa
  <?endif?>

  <?if($env == 'prod'):?>
  //PROD API KEY
  api_key: 1b773lzkdw3f
  <?endif?>

  authorize: true
  scope: r_fullprofile r_emailaddress
</script>
 
<?=HTML::script('js/form.script.js');?>

<div id="formBox">
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="rating" name="rating" value="5" />
    <input type="hidden" id="loginType" name="loginType" value="36" />
    <input type="hidden" id="profileLink" name="profileLink" value="" />
    <input type="hidden" id="companyId" value="<?=$company_id?>" />
    <input type="hidden" id="siteId" name="siteId" value="<?=$site_id?>" />
    <div id="formContainer">
        <!-- the popup/lightbox shadow -->
        <div id="lightbox-s"></div>
        <div id="lightbox-upload-s"></div>
        <div id="lightbox-editor-s"></div>
        <!-- end of lightbox shadow -->
        <!-- the text editor popup -->
        <div id="lightbox-text-editor-container">
            <div id="editor-white-area">
                <h2 class="text-editor-title">Feedback Text Editor</h2>
                <div class="editor-container-box">
                    <textarea id="textEditor" class="feedback-textarea small" title="Please Enter Your Feedback"  style="height:450px;width:348px;"></textarea>
                </div>
                <div class="editor-buttons">
                    <a href="#" class="lightbox-button" onclick="javascript:close_text_editor();">Save</a>
                </div>
            </div>
        </div>
        <!-- the text editor popup -->
        <!-- the image upload popup -->
        <div id="lightbox-upload-photo-container">
            <div id="lightbox-upload-photo-close" onclick="javascript:close_file_upload()">close X</div>
            <div id="upload-white-area">
                <div id="drag-and-drop-area">
                    <h2>Drag Photos on this area</h2>
                    <p>or</p>
                    <p><input type="file" multiple id="file_uploader" data-url="/imageprocessing/FormImageUploader/" /></p>
                    <script type="text/javascript">

                    </script>
                </div>
                <div id="upload-status-area">
                    <div class="upload-preview">
                        <span>Uploading...</span>
                        <div class="progress-shade"></div>
                    </div>
                </div>
            </div>
        </div>  
        <!-- end of image upload popup -->
        
        <!-- the lightbox -->
        <div id="lightbox">
            <div class="lightbox-pandora">
                <div class="lightbox-header">Oops! Something went wrong..</div>
                <div class="lightbox-body">
                    <div class="lightbox-message error">
                        <ul>
                            
                        </ul>
                    </div>
                    <div class="lightbox-buttons">
                        <a href="#" class="lightbox-button" onclick="javascript:close_lightbox();">OK</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of lightbox -->
        <div id="formBody">
            <!-- form window 1 -->
            <div id="step1" class="form-page" style="display:none;">
                <div class="form-page-head">
                    <h1>Share your feedback</h1>
                </div>
                <div class="form-page-body">
                    <!-- star ratings -->
                    <h2><?=($form_text) ? $form_text : "Rate your overall experience"?></h2>
                    <div class="dynamic-stars">
                        <div class="star-ratings clear">
                            <div class="star-container clear">
                                <div id="1" class="star full"></div>
                                <div id="2" class="star full"></div>
                                <div id="3" class="star full"></div>
                                <div id="4" class="star full"></div>
                                <div id="5" class="star full"></div>
                            </div>
                            <div class="star-text">
                                <span class="">Excellent!</span>
                            </div>
                        </div>
                    </div>
                    <!-- end of star ratings -->

                    <!-- start of form title -->
                    <div class="form-feedback-title">
                        <div class="form-field-block">
                            <input id="feedbackTitle" type="text" class="regular-custom-field" value="" title="Title of your feedback" name="title" />
                        </div>
                    </div>
                    <!-- end of form title -->
                     
                    <!-- start of feedback form -->
                    <div class="form-feedback-textbox">
                        <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div>
                        <textarea id="feedbackText" class="feedback-textarea" title="<?=($form_question) ? $form_question : 'Please Enter Your Feedback'?>"></textarea>
                    </div>
                    <!-- end of feedback form -->

                    <!-- start custom fields block -->
                    <?if($form_render):?>
                        <div class="form-custom-fields">
                            <?=$form_render->render_metadata()?>
                        </div>
                    <?endif?>
                    <!-- end of custom fields block -->
                    
                    <!-- start of thumbs up! -->
                    <div class="form-recommendation-text clear">
                        <div class="form-green-thumbs">Would you recommend this to your friends? </div>
                        <input type="hidden" id="recommend" name="recommend" value="1" />
                        <div id="recommend-checkbox" class="form-recommend-checkbox checked"><span>Yes</span></div>
                    </div>
                    <!-- end of thumbs up -->
                    
                    <!-- start of the image upload -->
                    <div class="form-add-image">
                        <a href="javascript:;" class="video-icon" title="Just paste any link in the feedback text box and we'll do the rest" alt="Just paste any link in the feedback text box and we'll do the rest"></a><a href="#" class="image-icon" title="Upload Images" alt="Upload Images" onclick="init_file_upload()">Add Image(s)</a><span> - optional (3 maximum)</span>
                    </div>
                    
                    <div id="uploaded_images_preview" class="form-image-thumbs clear">
                   
                    </div>
                    <!-- end of uploads -->
                    
                    <!-- start of video upload -->
                    <!-- 
                    <div class="form-add-video">
                        <a href="#" class="video-icon">Add Video</a> 
                        <div class="form-video-url" style="display:none">
                            <label>Enter Youtube Link : </label> <input type="text" class="regular-text" />
                        </div>
                    </div>
                    -->
                    <div class="form-video-thumbs clear"></div>
                    
                    <!-- end of form upload -->
                </div>
                <!-- end of form page body window 1 -->
                
            </div>
            <div id="step2" class="form-page">
                <div class="form-page-head">
                    <h1>Attach your profile</h1>
                </div>
                <div class="form-page-body">
                    <!-- start of social buttons -->
                    <div class="social-buttons clear">
                        <div class="button-container">
                            <a id="fb-login" href="javascript:;"><img src="/img/btn-fb.png" /></a>
                        </div>

                        <div class="button-container">
                            <a id="tw-login" href="javascript:;"><img src="/img/btn-tw.png" /></a>
                        </div>
                        <div class="button-container">
                            <a id="in-login" href="javascript:;"><img src="/img/btn-in.png" /></a>
                        </div>
                    </div>
                    <span>or fill out your profile manually..</span>
                    <!-- end of social buttons -->
                    
                    <!-- registration form -->
                    <div class="registration-form">
                        <div class="two-clm-in clear">
                            <div class="clm one">
                                <input type="text" id="your_fname" name="fname" class="registration-input" title="First Name" />
                            </div>
                            <div class="clm two">
                                <input type="text" id="your_lname" name="lname" class="registration-input" title="Last Name" />
                            </div>
                        </div>
                        <div class="one-clm-in">
                            <div class="clm">
                                <input type="text" id="your_email" name="email" class="registration-input" title="Email Address" />
                            </div>
                        </div>
                        <div class="two-clm-in clear">
                            <div class="clm one">
                                <input type="text" id="your_city" name="city" class="registration-input" title="City" />
                            </div>
                            <div class="clm two">
                                <select class="registration-input default-text" name="country" id="your_country" title="Country">
                                       <option>Country</option>
                                    <?php foreach($countries->get() as $country): ?>
                                       <option value='<?=strtolower($country->code)?>'><?=$country->name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="two-clm-in clear">
                            <div class="clm one">
                                <input type="text" class="registration-input" name="company" id="your_company" title="Company Name (optional)" />
                            </div>
                            <div class="clm two">
                                <input type="text" class="registration-input" name="position" id="your_occupation" title="Occupation (optional)" />
                            </div>
                        </div>
                        <div class="one-clm-in">
                            <div class="clm">
                                <input type="text" class="registration-input" name="website" id="your_website" title="Website (optional)"/>
                            </div>
                        </div>
                        <div class="one-clm-in clear">
                            <div class="registration-avatar" style="overflow:hidden;max-height:105px;">
                                <img src="/img/facebook-blank-avatar.jpg" id="preview_photo" width="105" />
                            </div>
                            <div class="registration-avatar-inst">
                                <h2>Select your display profile photo.</h2>
                                <p>You can also use your company logo if 
you like.</p>
                                <input type="file" id="your_photo" data-url="/imageprocessing/FormImageUploader/" />
                            </div>
                        </div>
                        <div class="one-clm-in">
                            <h2 class="h2-fix">Give us permission to feature your review on our page?</h2>
                            <div class="permission">
                                <input type="hidden" id="your_permission" value="1" />
                                <div id="permission-checkbox" class="permission-checkbox checked"></div>
                                <span>Yes, I allow you to publish my profile and feedback.</span>
                            </div>
                        </div>
                    </div>
                    <!-- end of registration form -->
                </div>
                <!-- end of form page body window 1 -->
                
            </div>
            <div id="step3" class="form-page" style="display:none">
                <div class="form-page-head">
                    <h1>Review your feedback</h1>
                </div>
                <div class="form-page-body">
                    
                    <span>Just before you send in your feedback, be sure to check it 
one more time.</span>
                    
                    <!-- start of profile review block -->
                    <div class="profile-review-block clear">
                        <div class="user-avatar" style="max-height:105px;overflow:hidden;">
                            <img src="/img/facebook-blank-avatar.jpg" width="100" id="review_photo" />
                        </div>
                        <div class="user-details">
                            <div id="review-name" class="user-name">Leica Chang</div>
                            <div class="user-position" id="review-company"></div>
                            <div class="user-location clear"><span id="review-location"></span><span id="flag" class="flags flag-ph"></span></div>
                            
                            <div class="user-date">
                                <?php echo date("F d, Y") ?>
                            </div>
                        </div>
                    </div>
                    <!-- end of profile review block -->
                    <!-- start of feedback details -->
                    <div class="feedback-details">
                        <div class="dynamic-stars">
                            <div class="star-ratings clear">
                                <div class="star-container clear">
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                </div>
                                <div class="star-text">
                                    <span class="">Excellent!</span>
                                </div>
                            </div>
                        </div>
                        <div id="review-feedback-text-container" class="feedback-text">
                            <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div>
                            <div id="review-feedback-text" class="feedback-box">
                                <p></p>
                            </div>
                            <div class="feedback-edit clear"><a href="javascript:;" id="edit_text_link" class="edit-text">edit</a></div>
                        </div>
                        <div class="review-permission" id="review-permission">
                            <h2><img src="/img/check-ico.png" /> You allowed this feedback to be published</h2>
                        </div>
                        <div id="review-images" class="form-image-thumbs clear"></div>
                        <div id="review-videos" class="form-video-thumbs clear"></div>
                        <!-- end of uploads -->
                        
                        <div id="link-data">
                            <input type="hidden" id="hasLink" name="link-title"  value="0" />
                            <input type="hidden" id="link-title" name="link-title"  value="" />
                            <input type="hidden" id="link-description" name="link-description" value="" />
                            <input type="hidden" id="link-image" name="link-image" value="" />
                            <input type="hidden" id="link-url" name="link-url"  value="" />
                            <input type="hidden" id="link-video" name="link-video"  value="" />
                            <input type="hidden" id="link-attachments" name="link-attachments" value="" />
                        </div>

                    </div>
                </div>
                <!-- end of form page body window 1 -->
                
            </div>
            <div id="step4" class="form-page" style="display:none" >
                <div class="form-page-head">
                    <h1>All done!</h1>
                </div>
                <div class="form-page-body">
                    
                    <h2>Thank you for sending in your feedback!</h2>
                    <br />
                    <br />
                    <p>We'd greatly appreciate it if you would share your feedback 
with others!</p>
                    <br />
                    <!-- start of feedback details -->
                    <div class="feedback-details">
                        <div class="static-stars">
                            <div class="star-ratings clear">
                                <div class="star-container clear">
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="all-done-box">
                        <div id="all-done-textbox" class="all-done-feedback-box">
                            <p>test</p>
                        </div>
                    </div>
                    <div id="share-boxes" class="clear">
                        <div class="facebook-share-bar"></div>
                        <div class="twitter-share-bar"></div>
                    </div>
                    <div id="like-boxes">
                        <h2 class="like-us-title">Like us on facebook and follow us on Twitter!</h2>
                        <?if($facebook_username and $twitter_username):?>
                            <div class="like-button">
                                <iframe src="//www.facebook.com/plugins/like.php?href=<?=$facebook_username?>&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=<?=$fb_app_id?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:380px; height:30px;" allowTransparency="true"></iframe>
                            </div>
                            <div class="twitter-button">
                                <a href="<?=$twitter_username?>" class="twitter-follow-button" data-show-count="false">Follow @<?=$company_name?></a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                        <?endif?>

                        <?if($facebook_username and $twitter_username == false):?>
                            <div class="like-button">
                                <iframe src="//www.facebook.com/plugins/like.php?href=<?=$facebook_username?>&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=<?=$fb_app_id?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:380px; height:30px;" allowTransparency="true"></iframe>
                            </div>
                        <?endif?>

                        <?if($facebook_username == false and $twitter_username):?>
                            <div class="twitter-button">
                                <a href="<?=$twitter_username?>" class="twitter-follow-button" data-show-count="false">Follow @<?=$company_name?></a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                        <?endif?>

                    </div>
                </div>
                <!-- end of form page body window 4 -->
            </div>
            <!-- end of form window -->
        </div>
        <div id="formFoot">
            <div class="form-buttons">
                <div class="form-button-left">
                    <a href="javascript:;" class="form-button" style="display:none;" id="back">Back</a>
                </div>
                <div class="loading-box">
                    <span>Processing.. <img src="/img/loading.gif" /></span>
                </div>
                <div class="form-button-right">
                    <a href="javascript:;" class="form-button" id="next">Next Step</a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
