<?php if( ! is_null($user) ): ?>

<div id="notification">
    <div id="notification-design">
        <div id="notification-message">
            Loading... Please Wait... you bits.
        </div>
    </div>
</div>
<?=View::make('hosted/partials/fullpage_admin_panel_view', Array('patterns' => $fullpage_patterns, 'panel' => $panel) )?>
<?php endif; ?>

<div id="bodyColorOverlay"></div>
<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            <div id="theBarTab" class=""></div>
            <div id="coverPhotoContainer">
                
                
                    <?php if( ! is_null($user) ): ?>
                        <div id="changeCoverButton">
                            <div id="changeButtonText">            
                                <span>Change Cover</span>
                            </div>
                            <input type="file" id="cv_image" data-url="imageprocessing/upload_coverphoto" style="" />
                        </div>
                        <div id="saveCoverButton">
                            Save Cover
                        </div>
                        <div id="dragPhoto">
                            Drag Image to Reposition Cover
                        </div>
                    <?php endif; ?>
                    
                    <div id="coverPhoto">
                        <?php if( is_null($company->coverphoto_src) ): ?>
                            <img dir="/uploaded_images/coverphoto/" basename="" src="img/sample-cover.jpg" />
                        <?php else: ?>
                            <img width="850px" dir="/uploaded_images/coverphoto/" basename="" src="/uploaded_images/coverphoto/<?php echo $company->coverphoto_src; ?>" style="top: <?php echo $company->coverphoto_top; ?>px; position: relative;" />
                        <?php endif; ?>
                    </div>
                
                
                <!-- social link icons 1/28/2013 -->
                <div id="socialLinkIcons" class="clear">
                    <div class="social-icon fb"><a id="fb_url" href="<?= $panel->facebook_url; ?>">
                        <img src="/fullpage/common/img/facebook.png" title="Facebook Page" />
                    </a></div>
                    <div class="social-icon tw"><a href="<?= $panel->twitter_url; ?>">
                        <img src="/fullpage/common/img/twitter.png" title="Twitter Page" />
                    </a></div>
                </div>
            </div>

        <div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
        <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" />
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                        <? // keep the content of fullpage_desc_text in one line. ?>
                        <div id="fullpage_desc" class="<?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( HTML::entities($company->description) ); ?></div>
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
                            <div class="green-thumb">
                                <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                                of our customers recommend us to their friends.
                            </div>
                        </div>
                        <div class="company-rating">
                            <div class="review-count">Based on <span itemprop="count"><?php echo $company->total_feedback; ?></span> reviews</div>
                            <div class="stars blue clear"><div class="star_rating" rating="<?php echo round($company->avg_rating); ?>"></div></div>
                            <meta itemprop="rating" content="<?php echo round($company->avg_rating); ?>" /><!-- for rich snippets. -->
                        </div>
                    </div>
            </div>
        </div>

            <!-- lightbox notification -->
            <div id="lightboxNotification">
                <div class="lightbox-pandora">
                    <div class="lightbox-header">Oops! Something went wrong..</div>
                    <div class="lightbox-body">
                        <div class="lightbox-message error">
                            <ul>
                                <li>Error Message</li><li>Error Message</li>
                            </ul>
                        </div>
                        <div class="lightbox-buttons">
                            <a href="#" class="lightbox-button">CLOSE</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of lightbox notification -->
            <!-- lightbox container -->
            <div class="lightbox-s"></div>
            <div class="lightbox">
                <div class="uploaded-images-close"></div>
                <div class="uploaded-images-popup">
                    <div class="uploaded-images-container">
                        <div class="uploaded-images-view">
                            <div class="uploaded-images-content">
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of lightbox container -->
            
            <div id="feedbackContainer">
                <?=View::make('hosted/partials/fullpage_'.strtolower($hosted->theme_name).'_layout_view', Array('collection' => $feeds, 'user' => $user))?>
            </div>
            <div id="feedback-infinitescroll-landing"></div> 
        </div>
    </div>
</div>

<?php
/*
|--------------------------------------------------------------------------
| Start adding some JS and CSS Initialization and Override
|--------------------------------------------------------------------------
*/
?>

<?= HTML::style('/fullpage/layout/'.strtolower($hosted->theme_name).'/css/S36FullpageLayout'.ucfirst($hosted->theme_name).'.css'); ?>
<?= HTML::script('/fullpage/layout/'.strtolower($hosted->theme_name).'/js/S36FullpageLayout'.ucfirst($hosted->theme_name).'.js'); ?>
<?= HTML::style('/fullpage/common/css/override.css');  // moved here from application/views/partials/fullpage_header.php. ?>
<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
    $(document).ready(function(){
        var fullpageCommon = new S36FullpageCommon;
        var fullpageLayout = new S36FullpageLayout<?php echo ucfirst($hosted->theme_name); ?>;
        fullpageLayout.init_fullpage_layout(); // initialize document ready of the current layout javascripts
        fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
        <?php if( ! is_null($user) ): //then display the admin bar by default ?>
            var fullpageAdmin  = new S36FullpageAdmin(fullpageLayout);
            fullpageAdmin.init_fullpage_admin();
            fullpageCommon.init_toggle_bar(0);
        <?php else:  // then hide the admin bar by default ?>
            fullpageCommon.init_toggle_bar(1);
        <?php endif; ?>

        /*
        / Infinite Scroll
        */
        S36FeedbackActions.initialize_actions();
        var counter = 0;    
        function update() {
           if($(window).scrollTop() + $(window).height() == $(document).height()) {

                //if admin window is present disable infinite scroll
                if( $('#adminWindowBox').length && $('#adminWindowBox').css('display') == 'block' ) return;

                counter += 1;
                var page_counter = counter + 1;
                var container = $('#feedback-infinitescroll-landing'); 
                $.ajax({ 
                    url: '/hosted/fullpage_partial/' + page_counter
                  , success: function(msg) { 
                      var boxes = $(msg);
                      container.append(boxes); 
                      S36FeedbackActions.initialize_actions();
                    }
                });
           }
        }
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
        $(window).scroll(throttled);
    });
</script>
<?php 
/*
/ In-line css for fullpage
*/
echo $fullpage_css;
?>
