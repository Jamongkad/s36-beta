<div id="theHostedFormContainer" style="display:none">
    <div id="hostedFormCloseBtn"></div>
    <!-- added for form -->
    <div class="padded-10">
        <div id="formBox">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="loginType" name="loginType" value="36" />
                <input type="hidden" id="profileLink" name="profileLink" value="" />
                <input type="hidden" id="companyId" value="<?= $company_id; ?>" />
                <input type="hidden" id="siteId" name="siteId" value="<?= $site_id; ?>" />
                <input type="hidden" id="avatar_filename" value=""/>
                <input type="hidden" id="recommend" name="recommend" value="1" />
                <input type="hidden" id="your_permission" value="1" />
                <div id="link-data">
                    <input type="hidden" id="hasLink" name="link-title"  value="0" />
                    <input type="hidden" id="link-title" name="link-title"  value="" />
                    <input type="hidden" id="link-description" name="link-description" value="" />
                    <input type="hidden" id="link-image" name="link-image" value="" />
                    <input type="hidden" id="link-url" name="link-url"  value="" />
                    <input type="hidden" id="link-video" name="link-video"  value="" />
                    <input type="hidden" id="link-attachments" name="link-attachments" value="" />
                </div>
                <div id="formContainer">
                    <!-- the popup/lightbox shadow -->
                    <div id="lightbox-s"></div>
                    <div id="lightbox-upload-s"></div>
                    <div id="lightbox-editor-s"></div>
                    <!-- end of lightbox shadow -->
                    <!-- the text editor popup -->
                    <div id="lightbox-text-editor-container">
                        <div id="editor-white-area">
                            <div id="feedback_text_stuff" style="display: none;">
                                <h2 class="text-editor-title">Feedback Text Editor</h2>
                                <div class="editor-container-box">
                                    <textarea id="textEditor" class="feedback-textarea small" title="Please Enter Your Feedback"></textarea>
                                </div>
                                <div class="editor-buttons">
                                    <a href="javascript:;" class="lightbox-button" onclick="javascript:close_text_editor();">Save</a>
                                </div>
                            </div>
                            <div id="feedback_title_stuff" style="display: none;">
                                <h2 class="text-editor-title">Feedback Title Editor</h2>
                                <input type="text" id="feedback_title_editor" class="regular-custom-field" maxlength="35" title="Please Enter Feedback Title" style="width: 89%; margin-left: 5px;" />
                                <div class="editor-buttons">
                                    <a href="javascript:;" class="lightbox-button" onclick="javascript:close_text_editor('feedback_title');">Save</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- the text editor popup -->
                    <!-- the image upload popup -->
                    <div id="lightbox-upload-photo-container">
                        <div id="lightbox-upload-photo-close" onclick="javascript:close_file_upload()">close X</div>
                        <div id="upload-white-area">
                            <div id="drag-and-drop-area">
                                <h2>Drag photos on this area</h2>
                                <p>or</p>
                                <p><input type="file" multiple id="file_uploader" data-url="/imageprocessing/FormImageUploader/" /></p>
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
                            <div class="lightbox-header">Oops! Something went wrong.</div>
                            <div class="lightbox-body">
                                <div class="lightbox-message error">
                                    <ul>
                                        
                                    </ul>
                                </div>
                                <div class="lightbox-buttons">
                                    <a href="javascript:;" class="lightbox-button" onclick="javascript:close_lightbox();">OK</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of lightbox -->
                    <div id="formBody">
                        <!-- form window 1 -->
                        <div id="step1" class="form-page current" style="display:block;height:341px">
                            <div class="form-page-body">
                                <!-- star ratings -->
                                <div class="grids">
                                    <div class="rate-title-container">
                                        <h2 class="rate-title">Thanks for rating us <span class="rating_num">4</span> out of 5 stars (<span class="rating_text">Good</span>)!</h2>
                                    </div>
                                </div>
                                <!-- end of star ratings -->
                                
                                <div class="grids">
                                    <div class="form-left-side">
                                        <div class="pad-right">
                                            
                                            <!-- start of feedback form -->
                                            <div class="form-feedback-title">
                                                <input id="feedbackTitle" type="text" class="regular-custom-field" value="" placeholder="Describe us in a single sentence<? //=($form_text) ? $form_text : 'Please Enter Your Feedback'?>" name="title" maxlength="35" />
                                            </div>
                                            <div class="form-feedback-textbox">
                                                <textarea id="feedbackText" class="feedback-textarea" placeholder="What are your thoughts about us?<? //=($form_question) ? $form_question : 'Please Enter Your Feedback'?>"></textarea>
                                            </div>
                                            
                                            <div class="form-recommendation-text clear">
                                                <div class="form-green-thumbs">Would you recommend this to your friends? </div>
                                                <div id="recommend-checkbox" class="form-recommend-checkbox checked"><span>Yes</span></div>
                                            </div>
                                            
                                            <!-- start of the image upload -->
                                            <div class="form-add-image">
                                                <a href="javascript:;" class="video-icon" title="Just paste any link in the feedback text box and we'll do the rest" alt="Just paste any link in the feedback text box and we'll do the rest"></a><a href="#" class="image-icon" id="addImage" title="Upload Images" alt="Upload Images" >Add Image(s)</a><span> - optional (3 maximum)</span>
                                            </div>
                                            <? // keep this div in one line. ?>
                                            <div id="uploaded_images_preview" class="form-image-thumbs clear"></div>
                                            <!-- end of the image upload -->
                                            
                                            <!-- start of video upload -->
                                            <? // keep this div in one line. ?>
                                            <div id="uploaded_video_preview" class="form-video-thumbs clear"></div> 
                                            <!-- end of video upload -->
                                            
                                            <!-- end of feedback form -->
                                        </div>
                                    </div>    
                                    <div class="form-right-side">
                                        <div class="form-custom-fields">
                                            
                                            <? // feedback metadata. ?>
                                            <?if($form_render):?>
                                                <?=$form_render->render_metadata()?>
                                            <?endif?>
                                            
                                        </div>
                                    </div>
                                </div><!-- end of grids -->
                                <!-- end of form upload -->
                            </div>
                            <!-- end of form page body window 1 -->
                        </div>
                        <div id="step2" class="form-page" style="display:none">
                            
                            <div class="form-page-body">
                                <!-- start of social buttons -->
                                <div class="grids">
                                    <div class="form-left-side">
                                        <div id="facebookForm">
                                            <div class="prefill-text">
                                                <div class="prefill-facebook-icon">
                                                    To save you time, the registration form below has been prefilled using your Facebook profile.
                                                </div>
                                            </div>
                                        </div>
                                        <div id="regularForm">
                                            <div class="social-buttons clear">
                                                <div class="button-container">
                                                    <a id="fb-login" href="javascript:;"><img src="/img/fb-connect-btn.png" /></a>
                                                </div>
                                            </div>
                                            <span>or fill out your profile manually.</span>
                                        </div>
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
                                                    <input maxlength='20' type="text" id="your_city" name="city" class="registration-input" title="City" />
                                                </div>
                                                <div class="clm two">
                                                    <select class="registration-input default-text" id="your_country" title="Country">
                                                        <option>Country</option>
                                                        <?php foreach($countries->get() as $country): ?>
                                                           <option value='<?=strtoupper($country->code)?>'><?=$country->name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="two-clm-in clear">
                                                <div class="clm one">
                                                    <input maxlength='20' type="text" class="registration-input" name="company" id="your_company" title="Company Name (optional)" maxlength="100" />
                                                </div>
                                                <div class="clm two">
                                                    <input maxlength='20' type="text" class="registration-input" name="position" id="your_occupation" title="Occupation (optional)" maxlength="100" />
                                                </div>
                                            </div>
                                            <div class="one-clm-in">
                                                <div class="clm">
                                                    <input type="text" class="registration-input" name="website" id="your_website" title="Website (optional)" maxlength="100" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-right-side">
                                        <div class="profile-avatar-container">
                                            <div class="one-clm-in clear">
                                                <div class="registration-avatar" style="overflow:hidden;max-height:105px;">
                                                    <img src="/img/facebook-blank-avatar.jpg" id="preview_photo" width="105" />
                                                </div>
                                                <div class="registration-avatar-inst">
                                                    <h2>Select your display profile photo.</h2>
                                                    <p>You can also use your company logo if you like.</p>
                                                    <input type="file" id="your_photo" data-url="/imageprocessing/upload_avatar/" />
                                                </div>
                                            </div>
                                            <div class="one-clm-in">
                                                <h2 class="h2-fix">Give us permission to feature your review on our page?</h2>
                                                <div class="permission">
                                                    <div id="permission-checkbox" class="permission-checkbox checked"></div>
                                                    <span>Yes, I allow you to publish my profile and feedback.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of form page body window 1 -->
                            
                        </div>
                        <div id="step3" class="form-page" style="display:none">
                            
                            <div class="form-page-body">
                                <h2>Just before you send in your feedback, be sure to check it one more time.</h2>
                                <!-- start of profile review block -->
                                <div class="review-page-spacer">
                                    <div class="grids">
                                    <div class="form-left-side">
                                        <div class="pad-right">
                                            <div class="feedback-details">
                                                <div id="review-feedback-title-container" class="feedback-text break-word">
                                                    <p id="review-feedback-title" class="break-word feedback-title-box"></p>
                                                    <div class="feedback-edit clear"><a href="javascript:;" id="edit_feedback_title" class="edit-text">edit</a></div>
                                                </div>
                                                <div id="review-feedback-text-container" class="feedback-text break-word">
                                                    <!-- <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div> -->
                                                    <div id="review-feedback-text" class="feedback-box">
                                                        <p></p>
                                                    </div>
                                                    <div class="feedback-edit clear"><a href="javascript:;" id="edit_text_link" class="edit-text">edit</a></div>
                                                </div>
                                                <div class="review-permission" id="review-permission">
                                                    <h2><img src="/img/check-ico.png" /> You allowed this feedback to be published</h2>
                                                </div>
                                                
                                                <div id="review-images" class="form-image-thumbs clear"></div>
                                                <div id="review-videos" class="form-video-thumbs clear"></div><br/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-right-side">
                                        <div class="profile-review-block clear">
                                            <div class="user-avatar" style="max-height:105px;overflow:hidden;">
                                                <img src="img/facebook-blank-avatar.jpg" width="100" id="review_photo" />
                                            </div>
                                            <div class="user-details">
                                                <div id="review-name" class="user-name break-word">Leica Chang</div>
                                                <div class="user-position break-word" id="review-company"></div>
                                                <div class="user-location clear break-word"><span id="review-location"></span><span id="flag" class="flag flag-ph"></span></div>
                                                <div class="user-date">
                                                    <?php echo date("F d, Y") ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-rating-stars">
                                            <div class="static-stars">
                                                <div class="star-ratings clear">
                                                    <div class="star-container clear">
                                                        <div class="star full"></div>
                                                        <div class="star full"></div>
                                                        <div class="star full"></div>
                                                        <div class="star full"></div>
                                                        <div class="star full"></div>
                                                    </div>
                                                    <div class="star-text">
                                                        <span>Excellent!</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- end of form page body window 1 -->
                            
                        </div>
                        <div id="step4" class="form-page" style="display:none">
                            <div class="form-page-body">
                                <h2>Thank you for sending in your feedback!</h2>
                                <br />
                                <p>We'd greatly appreciate it if you would share your feedback with others!</p>
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
                                    <div id="all-done-textbox" class="all-done-feedback-box break-word">
                                        <h1 id="all-done-feedback-title" class="break-word">This is the feedback title</h1>
                                        <p>you don't say?</p>
                                    </div>
                                </div>
                                <div id="share-boxes" class="clear">
                                    <div class="facebook-share-bar"></div>
                                    <div class="twitter-share-bar"></div>
                                </div>
                            </div>
                            <!-- end of form page body window 4 -->
                        </div>
                        <!-- end of form window -->
                    </div>
                    <div id="formFoot">
                        <div class="form-buttons grids">
                            <div class="form-button-left">
                                <a href="javascript:;" class="form-button" style="display:none;" id="back">Back</a>
                            </div>
                            <div class="loading-box">
                                <span>Processing.. <img src="img/loading.gif" /></span>
                            </div>
                            <div class="form-button-right">
                                <a href="javascript:;" class="form-button" id="next">Next Step</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><br/> <!-- end of #theHostedFormContainer -->