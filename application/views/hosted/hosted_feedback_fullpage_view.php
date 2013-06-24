<?php if( ! is_null($user) ): ?>
    <div id="notification">
        <div id="notification-design">
            <div id="notification-message">
                Loading... Please Wait... you bits.
            </div>
        </div>
    </div>
    <?//=View::make('hosted/partials/fullpage_admin_panel_view', Array('patterns' => $fullpage_patterns, 'panel' => $panel))?>
<?php endif; ?>
<div id="maskDisabler">
 <div id="maskPreloader">
        <div class="loading-icon"></div>
        <div class="loading-text">
            Please wait while we change your layout...
        </div>
    </div>
</div>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>
            
            <div id="companySummaryContainer">
                
                <div class="hosted-block">
                    <div class="company-description clear">
                        <div class="company-rating">
                            <div class="dynamic-stars-container">
                                <div class="dynamic-stars">
                                    <div class="star-ratings clear">
                                        <div class="star-container clear">
                                            <div id="1" class="star <?= ($company->avg_rating >= 1 ? 'full' : ''); ?>"></div>
                                            <div id="2" class="star <?= ($company->avg_rating >= 2 ? 'full' : ''); ?>"></div>
                                            <div id="3" class="star <?= ($company->avg_rating >= 3 ? 'full' : ''); ?>"></div>
                                            <div id="4" class="star <?= ($company->avg_rating >= 4 ? 'full' : ''); ?>"></div>
                                            <div id="5" class="star <?= ($company->avg_rating >= 5 ? 'full' : ''); ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review-count"><strong>Based on <?php echo $company->total_feedback; ?> reviews.</strong> Rate us!</div>
                        </div>
                        <div class="company-text">
                            <div class="company-text-content">
                                <? // keep the content of #fullpage_desc in one line. ?>
                                <div id="fullpage_desc" class="break-word <?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( Helpers::urls_to_links(HTML::entities($company->description)) ); ?></div>
                                <?php if( ! is_null($user) ): ?>
                                    <textarea id="fullpage_desc_textbox" rows="3"></textarea>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- end of .hosted-block (ratings and description) -->
                
                <div id="theHostedFormContainer">
                    <!-- added for form -->
                    <div class="padded-10">
                        <div id="formBox">
                            <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="rating" name="rating" value="0" />
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
                                    </div><!-- the text editor popup -->
                                    <!-- the image upload popup -->
                                    <div id="lightbox-upload-photo-container">
                                        <div id="lightbox-upload-photo-close" onclick="javascript:close_file_upload()">close X</div>
                                        <div id="upload-white-area">
                                            <div id="drag-and-drop-area">
                                                <h2>Drag Photos on this area</h2>
                                                <p>or</p>
                                                <p><input type="file" multiple id="file_uploader" data-url="server/" /></p>
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
                                                    <a href="javascript:;" class="lightbox-button" onclick="javascript:close_lightbox();">OK</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of lightbox -->
                                    <div id="formBody">
                                        <!-- form window 1 -->
                                        <div id="step1" class="form-page" style="display:none">
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
                                                            <?php
                                                                // temporary.
                                                                $form_text = '';
                                                                $form_question = '';
                                                            ?>
                                                            <div class="form-feedback-title">
                                                                <!-- <input type="text" class="regular-custom-field" title="Enter Your Feedback Title" id="feedbackTitle" /> -->
                                                                <input id="feedbackTitle" type="text" class="regular-custom-field" value="" placeholder="<?=($form_text) ? $form_text : 'Please Enter Your Feedback'?>" name="title" maxlength="35" />
                                                            </div>
                                                            <div class="form-feedback-textbox">
                                                                <!-- <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div> -->
                                                                <!-- <textarea id="feedbackText" class="feedback-textarea" title="Please Enter Your Feedback"></textarea> -->
                                                                <textarea id="feedbackText" class="feedback-textarea" placeholder="<?=($form_question) ? $form_question : 'Please Enter Your Feedback'?>"></textarea>
                                                            </div>
                                                            <!-- start of the image upload -->
                                                            <div class="form-add-image">
                                                                <a href="javascript:;" class="video-icon" title="Just paste any link in the feedback text box and we'll do the rest" alt="Just paste any link in the feedback text box and we'll do the rest"></a><a href="#" class="image-icon" id="addImage" title="Upload Images" alt="Upload Images" >Add Image(s)</a><span> - optional (3 maximum)</span>
                                                            </div>
                                                            
                                                            <!-- end of uploads -->
                                                            <!-- end of feedback form -->
                                                            <div class="form-recommendation-text clear">
                                                                <div class="form-green-thumbs">Would you recommend this to your friends? </div>
                                                                <input type="hidden" id="recommend" name="recommend" value="1" />
                                                                <div id="recommend-checkbox" class="form-recommend-checkbox checked"><span>Yes</span></div>
                                                            </div>
                                                            <!--
                                                            <div class="form-recommendation-text clear">
                                                                <div class="title">Would you recommend this to your friends? <label class="label"><input type="checkbox" name="" checked /> Yes</label></div>
                                                            </div>
                                                            -->
                                                        </div>
                                                    </div>    
                                                    <div class="form-right-side">
                                                        <!-- start of thumbs up! -->
                                                        <div class="form-custom-fields">
                            
                                                            <!-- checkbox structure -->
                                                            <div class="form-field-block">
                                                                <div class="checkbox-container clear">
                                                                    <div class="title">
                                                                        Do you eat cockroaches?
                                                                    </div>
                                                                    <div class="inputs">
                                                                        <label class="label"><input type="checkbox" name="baloney" /> Definitely</label>
                                                                        <label class="label"><input type="checkbox" name="baloney" /> Sometimes</label>
                                                                        <label class="label"><input type="checkbox" name="baloney" /> Occasionally</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- select structure -->
                                                            <div class="form-field-block">
                                                                <div class="title">
                                                                        What is the name of your pet?
                                                                </div>
                                                                <div class="inputs">
                                                                    <select class="regular-custom-field">
                                                                        <option>Kenwell</option>
                                                                        <option>Robert</option>
                                                                        <option>Cow</option>
                                                                        <option>Chameleon</option>
                                                                        <option>Baloney</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- radio button structure -->
                                                            <div class="form-field-block">
                                                                <div class="radio-container clear">
                                                                    <div class="title">
                                                                        Do you even lift?
                                                                    </div>
                                                                    <div class="inputs">
                                                                        <label class="label"><input type="radio" name="baloney" /> Yes</label>
                                                                        <label class="label"><input type="radio" name="baloney" /> No</label>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <!-- end of thumbs up -->
                                                        
                                                    </div>
                                                </div><!-- end of grids -->
                                                <!-- end of form upload -->
                                            </div>
                                            <!-- end of form page body window 1 -->
                                        </div>
                                        <div id="step2" class="form-page">
                                            
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
                                                            <span>or fill out your profile manually..</span>
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
                                                                        <option value="au">Australia</option>
                                                                        <option value="us">United States</option>
                                                                        <option value="ph">Philippines</option>
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
                                                                    <input type="file" id="your_photo" data-url="server/" />
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
                                                                <div id="review-feedback-title-container" class="feedback-text">
                                                                    <!-- <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div> -->
                                                                    
                                                                    <!-- <div id="review-feedback-title-text" class="feedback-title-box">
                                                                        <p>Your feedback Title Here</p>
                                                                    </div>
                                                                    <div class="feedback-edit clear"><a href="javascript:;" id="edit_text_link" class="edit-text">edit</a></div> -->
                                                                    
                                                                    <p id="review-feedback-title" class="break-word"></p>
                                                                    <p><a href="javascript:;" id="edit_feedback_title" class="edit-text">edit</a></p>
                                                                </div>
                                                                <div id="review-feedback-text-container" class="feedback-text">
                                                                    <!-- <div class="fullscreen-icon" alt="Expand Textbox" title="Expand Textbox"></div> -->
                                                                    <div id="review-feedback-text" class="feedback-box">
                                                                        <p></p>
                                                                    </div>
                                                                    <div class="feedback-edit clear"><a href="javascript:;" id="edit_text_link" class="edit-text">edit</a></div>
                                                                </div>
                                                                <div class="review-permission" id="review-permission">
                                                                    <h2><img src="/img/check-ico.png" /> You allowed this feedback to be published</h2>
                                                                </div>
                                                                <div id="review-images" class="form-image-thumbs clear">
                                                                    
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
                                                                <div id="review-videos" class="form-video-thumbs clear"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-right-side">
                                                        <div class="profile-review-block clear">
                                                            <div class="user-avatar" style="max-height:105px;overflow:hidden;">
                                                                <img src="img/facebook-blank-avatar.jpg" width="100" id="review_photo" />
                                                            </div>
                                                            <div class="user-details">
                                                                <div id="review-name" class="user-name">Leica Chang</div>
                                                                <div class="user-position" id="review-company"></div>
                                                                <div class="user-location clear"><span id="review-location"></span><span id="flag" class="flag flag-ph"></span></div>
                                                                <div class="user-date">
                                                                    <?php echo date("F d, Y") ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="review-rating-stars">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- end of form page body window 1 -->
                                            
                                        </div>
                                        <div id="step4" class="form-page" style="display:none" >
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
                                                <div id="all-done-feedback-title-container" class="feedback-text clear">
                                                    <p id="all-done-feedback-title" class="break-word"></p>
                                                </div>
                                                <div id="all-done-box">
                                                    <div id="all-done-textbox" class="all-done-feedback-box">
                                                        <h1>This is the feedback title</h1>
                                                        <p>test</p>
                                                    </div>
                                                </div>
                                                <div id="share-boxes" class="clear">
                                                    <div class="facebook-share-bar"></div>
                                                    <div class="twitter-share-bar"></div>
                                                </div>
                                                <? /*<div id="share-boxes" class="clear">
                                                    <div class="facebook-share-bar"><a href="#"><img src="img/fb-share-btn.png" /></a></div>
                                                    <div class="twitter-share-bar"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://companyname.com" data-text="I recommend co-name, just sent them some great feedback over at co-hosted-page-address. Go check them out!" data-size="large" data-count="none">Tweet</a>
                                                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                                    </div>
                                                </div>
                                                <div id="like-boxes">
                                                    <h2 class="like-us-title">Like us on facebook and follow us on Twitter!</h2>
                                                    <div class="like-button">
                                                        <!-- like button here -->
                                                        <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwebmumu.com&amp;send=false&amp;layout=standard&amp;width=350&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=307884662596382" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:380px; height:30px;" allowTransparency="true"></iframe>
                                                    </div>
                                                    <div class="twitter-button">
                                                        <a href="https://twitter.com/danoliverC" class="twitter-follow-button" data-show-count="false">Follow @danoliverC</a>
                                                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                                    </div>
                                                </div>*/ ?>
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
                </div> <!-- end of #theHostedFormContainer -->
                
                <div class="hosted-block">
                    <div class="company-reviews clear">
                        <div class="company-recommendation">
                            <?php if( $company->total_feedback != 0 ): ?>
                                <div class="green-thumb">
                                    <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                                    of our customers recommend us to their friends.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div> <!-- end of .hosted-block (recommendation) -->
                
            </div><!-- end of #companySummaryContainer -->
            <?php echo HTML::script('/fullpage/common/js/fullpage_form_script.js');  // temporary. ?>
            
            
            
            
            <div id="blankHostedPage"> <? // temporary. ?>
                <h1 class="first-head">Hey! Looks like you're the first one here. </h1>
                <h1>Send in some feedback for <?php echo ucfirst(HTML::entities($company->company_name)); ?> by clicking below.</h1>
                <p class="send-button" widgetkey="<?=$company->widgetkey?>">
                    <a href="javascript:;">
                        Send in feedback
                    </a>
                </p>
            </div>
            
            <?php if( $feed_count->published_feed_count == 0 ): ?>
                <div class="hosted-block">
                    <div class="company-description clear">
                        <div class="company-text" style="width:100%">
                            <div id="fullpage_desc" class="break-word <?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( Helpers::urls_to_links(HTML::entities($company->description)) ); ?></div>
                        </div>
                    </div>
                </div>
                <div id="blankHostedPage">
                    <h1 class="first-head">Hey! Looks like you're the first one here. </h1>
                    <h1>Send in some feedback for <?php echo ucfirst(HTML::entities($company->company_name)); ?> by clicking below.</h1>
                    <p class="send-button" widgetkey="<?=$company->widgetkey?>">
                        <a href="javascript:;">
                            Send in feedback
                        </a>
                    </p>
                </div>
            <?php endif; ?>
            
            
            <?php if( $feed_count->published_feed_count > 0 ): ?>
                <div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
                    <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" />
                    <? /*<div class="hosted-block">
                        <div class="company-description clear">
                            <div class="company-text">
                                <? // keep the content of fullpage_desc_text in one line. ?>
                                <div id="fullpage_desc" class="break-word <?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( Helpers::urls_to_links(HTML::entities($company->description)) ); ?></div>
                                <?php if( ! is_null($user) ): ?>
                                    <textarea id="fullpage_desc_textbox" rows="3"></textarea>
                                <?php endif; ?>
                            </div>
                            <div class="send-button" widgetkey="<?=$company->widgetkey?>">
                                <a href="javascript:;">
                                    Send in feedback
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hosted-block">
                        <div class="company-reviews clear">
                            <div class="company-recommendation">
                                <?php if( $company->total_feedback != 0 ): ?>
                                    <div class="green-thumb">
                                        <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                                        of our customers recommend us to their friends.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="company-rating">
                                <?php if( $company->total_feedback != 0 ): ?>
                                    <div class="review-count">Based on <span itemprop="count"><?php echo $company->total_feedback; ?></span> reviews</div>
                                    <div class="stars blue clear"><div class="star_rating" rating="<?php echo round($company->avg_rating); ?>"></div></div>
                                    <meta itemprop="rating" content="<?php echo round($company->avg_rating); ?>" /><!-- for rich snippets. -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>*/ ?>
                </div>

                <!-- lightbox notification -->
                <!-- <div id="lightboxNotification"> <? // commented out because we already have this in form. ?>
                    <div class="lightbox-pandora">
                        <div class="lightbox-header">Oops! Something went wrong..</div>
                        <div class="lightbox-body">
                            <div class="lightbox-message error">
                                <ul>
                                    <li>Error Message</li><li>Error Message</li>
                                </ul>
                            </div>
                            <div class="lightbox-buttons">
                                <a href="javascript:;" class="lightbox-button">CLOSE</a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- end of lightbox notification -->
                <div id="feedbackContainer">
                    <div id="threeColumnLayout" class="hosted-layout">
                        <?=View::make('hosted/partials/fullpage_'.strtolower($panel->theme_name).'_layout_view', Array('collection' => $feeds, 'user' => $user))?>
                        <div id="feedback-infinitescroll-landing"></div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php
/*
|--------------------------------------------------------------------------
| Start adding JS and CSS Initialization and Override
|--------------------------------------------------------------------------
*/
?>
<?= HTML::style('/fullpage/layout/'.strtolower($panel->theme_name).'/css/S36FullpageLayout'.ucfirst($panel->theme_name).'.css'); ?>
<?= HTML::script('/fullpage/layout/'.strtolower($panel->theme_name).'/js/S36FullpageLayout'.ucfirst($panel->theme_name).'.js'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        var fullpageCommon = new S36FullpageCommon;
        var fullpageLayout = fullpageCommon.create_layout('<?php echo $panel->theme_name; ?>'); 
        fullpageLayout.init_fullpage_layout(fullpageCommon); // initialize document ready of the current layout javascripts
        fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
        
        <?php if($user): //then display the admin bar by default ?> 
            var fullpageAdmin  = new S36FullpageAdmin(fullpageLayout);
            fullpageAdmin.init_fullpage_admin();
        <?php endif; ?>

        /*
        / Infinite Scroll
        */
        S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);

        var container = $('#feedback-infinitescroll-landing');
        if( fullpageLayout.layout_name == 'treble' ) {
            container = $('.feedback-list');   
        }

        var counter = 0;    
        //lets get the first 6 months of feedback if there are any...
        for(var i=0; i<<?=$feed_advance_count?>; i++) {
            counter += 1; 
            var pg_c = counter + 1;

            render_children(container, pg_c);
        }

        function update() {
            if( $(window).scrollTop() + $(window).height() == $(document).height() ) {
                if( $('#adminWindowBox').length && $('#adminWindowBox').css('display') == 'block' ) return;
                
                counter += 1;
                var page_counter = counter + 1;

                render_children(container, page_counter);
            }
            
            fullpageLayout.init_fullpage_layout(fullpageCommon); // initialize document ready of the current layout javascripts
            fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
            S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);

        }

        function render_children(container, counter) { 
            $.ajax({ 
                async: false,
                url: '/hosted/fullpage_partial/' + counter
              , success: function(msg) { 
                  var boxes = $(msg);
                  if( fullpageLayout.layout_name == 'treble' ) container.append(boxes.find('.feedback')); 
                  else container.append(boxes); 
                }
            });
        }
        //rate limit this bitch
        var throttled = _.throttle(update, 1000);
        $(window).scroll(throttled);
        /*
        / FancyBox
        */

        $("a.the-thumb-ajs").fancybox({
          openEffect : 'none',
          closeEffect : 'none'
         });

        $(".fullpage-fancybox").fancybox({
          openEffect : 'none',
          closeEffect : 'none'
         });
        $(".fancybox-video").click(function() {
            $.fancybox({
                'padding'       : 0,
                'autoScale'     : false,
                'transitionIn'  : 'none',
                'transitionOut' : 'none',
                'title'         : this.title,
                'width'         : 640,
                'height'        : 385,
                'href'          : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                'type'          : 'swf',
                'swf'           : {
                    'wmode'             : 'transparent',
                    'allowfullscreen'   : 'true'
                }
            });
            return false;
        });
    });
</script>

<? if($user): ?> 
<?= HTML::script('/js/angular.compilehtml.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/controllers/S36QuickInbox.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/directives/S36QuickInboxDirectives.js'); ?>
<?= HTML::script('/fullpage/admin/js/quickinbox/services/S36QuickInboxServices.js'); ?>
<? endif ?>
<?php 
/*
/ In-line css for fullpage
*/
?>
<div id="fullpage_css"><?php echo $fullpage_css; ?></div>

<div id="flagBoxDiv" style="display:none">
<div id="flagBox">
<input class="flag-feedback-id" type="hidden" value=""/>
<div class="flagbox-content">
        <div class="flagbox-head">
            <h2>Flag as Inappropriate</h2>
        </div>
        <div class="alert-message" style="display:none">
        </div>
        <div id="report_type_list" class="flagbox-body">
            <div class="padded-5">
                <ul>
                <?php
                foreach($reportTypes as $report_id=>$report_desc):
                ?>
                    <li>
                        <input class="feedbackReportItem flag-item-<?=$report_id?>" type="radio" name="flag-item" value="<?=$report_id?>" />
                        <label id="flag-item-<?=$report_id?>" class="reportTypeLabel"><?=$report_desc?></label>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="flagbox-foot">
                <div class="fdback-buttons">
                    <ul>
                        <li><a class="continue_report" href="#">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Cancel</a></li>
                    </ul>                   
                </div>
            </div>
        </div>
        
        <div id="report_user_info" class="flagbox-body" style="display:none">
            <div class="padded-5">
                <ul>
                    <li>To Continue, Fill up the fields below <br /><br /></li>
                        <li>
                            <label>Your Name :</label><br />
                            <input id="report_name" type="text" name="flagger-name" class="regular-text" title="Your Name" />
                        </li>
                        <li>
                            <label>Your Email :</label><br />
                            <input id="report_email" type="text" name="flagger-email" class="regular-text" title="Your Email" />
                        </li>
                        <li>
                            <label>Your Company (optional) :</label><br />
                            <input id="report_company" type="text" name="flagger-company" class="regular-text" title="Your Company (optional)" />
                        </li>
                        <li>
                            <label>Comments (optional) :</label><br />
                            <textarea id="report_comment" title="Comments"></textarea>
                        </li>
                    </ul>
                </div>
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a id="back_report" href="#">Back</a></li>
                        <li><a class="continue_report" href="#">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Cancel</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

        <div id="report_final" class="flagbox-body" style="display:none">
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="#">Close</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

    </div>
</div>
</div>
