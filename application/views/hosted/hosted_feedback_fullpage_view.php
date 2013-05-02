<?php if( ! is_null($user) ): ?>
    <div id="notification">
        <div id="notification-design">
            <div id="notification-message">
                Loading... Please Wait... you bits.
            </div>
        </div>
    </div>
    <?=View::make('hosted/partials/fullpage_admin_panel_view', Array('patterns' => $fullpage_patterns, 'panel' => $panel))?>
<?php endif; ?>
<div id="maskDisabler">
 <div id="maskPreloader">
        <div class="loading-icon"></div>
        <div class="loading-text">
            Please wait while we change your layout...
        </div>
    </div>
</div>
<div id="bodyColorOverlay"></div>
<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            <div id="theBarTab" class=""></div>
            <div id="coverPhotoContainer">
                
                <?php if( ! is_null($user) ): ?>
                    
                    <div id="changeCoverButtonIcon">
                        <div id="coverMenuList">
                            <ul>
                                <li id="coverChange">
                                    Change cover photo
                                    <input type="file" id="cv_image" data-url="imageprocessing/upload_coverphoto" style="" />
                                </li>
                                <li id="coverReposition" style="<?= ( is_null($company->coverphoto_src) ? 'display: none;' : '' ); ?>">
                                    Reposition
                                </li>
                                <li id="coverRemove" style="<?= ( is_null($company->coverphoto_src) ? 'display: none;' : '' ); ?>">
                                    Remove
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="dragPhoto">Drag Image to Reposition Cover</div>
                    <div id="saveCoverButton">Save</div>
                    <div id="coverActionButtons">
                        <ul>
                            <li><a id="save_cover_photo" href="javascript:;">Save</a></li>
                            <li><a id="cancel_cover_photo" href="javascript:;">Cancel</a></li>
                        </ul>                   
                    </div>
                    
                <?php endif; ?>
                
                <div id="coverPhoto">
                    <?php if( ! is_null($user) ): ?>
                        <?php $src = ( is_null($company->coverphoto_src) ? 'img/sample-cover.jpg' : '/uploaded_images/coverphoto/' . $company->coverphoto_src ); ?>
                        <input type="hidden" id="hidden_cover_photo" src="<?php echo $src; ?>" style="top: <?php echo (int)$company->coverphoto_top; ?>px; position: relative;" />
                    <?php endif; ?>
                    
                    <?php if( ! is_null($company->coverphoto_src) ): ?>
                        <img width="850px" dir="/uploaded_images/coverphoto/" basename="" src="/uploaded_images/coverphoto/<?php echo $company->coverphoto_src; ?>" style="top: <?php echo $company->coverphoto_top; ?>px; position: relative;" />
                    <?php else: ?>
                        <?php if( ! is_null($user) ): ?>
                            <img dir="/uploaded_images/coverphoto/" basename="" src="img/sample-cover.jpg" />
                        <?php else: ?>
                            <img width="850px" src="img/public-coverphoto.jpg" />
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                
                <!-- social link icons 1/28/2013 -->
                <div id="socialLinkIcons" class="clear">
                    <div class="social-icon fb" style="display: <?= (trim($panel->facebook_url) == '' ? 'none' : ''); ?>;">
                        <a id="fb_url" href="<?= $panel->facebook_url; ?>" target="newtab">
                            <img src="/fullpage/common/img/facebook.png" title="Facebook Page" />
                        </a>
                    </div>
                    <div class="social-icon tw" style="display: <?= (trim($panel->twitter_url) == '' ? 'none' : ''); ?>;">
                        <a id="tw_url" href="<?= $panel->twitter_url; ?>" target="newtab">
                            <img src="/fullpage/common/img/twitter.png" title="Twitter Page" />
                        </a>
                    </div>
                </div>
                
                
                <!-- profile pic -->
                <div id="avatarContainer">
                    <?php if( ! is_null($user) ): ?>
                        <?php $src = ( empty($company->logo) ? '/img/public-profile-pic.jpg' : '/uploaded_images/company_logos/' . $company->logo ); ?>
                        <input type="hidden" id="hidden_company_logo" src="<?php echo $src; ?>" />
                        <input type="hidden" id="company_id" value="<?php echo $user->companyid; ?>" />
                    <?php endif; ?>
                    
                    <?php if( ! empty($company->logo) ): ?>
                        <img basename="" src="/uploaded_images/company_logos/<?php echo $company->logo; ?>" />
                    <?php else: ?>
                        <img basename="" src="/img/public-profile-pic.jpg" width="100%" />
                    <?php endif; ?>
                    
                    <?php if( ! is_null($user) ): ?>
                        <div id="avatarButtonIcon">
                            <div id="avatarMenuList">
                                <ul>
                                    <li><a href="javascript:;">
                                        Change Photo
                                        <input type="file" id="company_logo" data-url="imageprocessing/upload_company_logo" />
                                    </a></li>
                                    <li id="remove_logo" style="<?php echo ( empty($company->logo) ? 'display: none;' : '' ); ?>">
                                        <a href="javascript:;">Remove</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="logoActionButtons">
                            <ul>
                                <li><a id="save_company_logo" href="javascript:;">Save</a></li>
                                <li><a id="cancel_company_logo" href="javascript:;">Cancel</a></li>
                            </ul>                   
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if( $feed_count->published_feed_count == 0 ): ?>
                <div class="hosted-block">
                        <div class="company-description clear">
                            <div class="company-text" style="width:100%">
                                <div id="fullpage_desc" class="<?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( HTML::entities($company->description) ); ?></div>
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
            fullpageCommon.init_toggle_bar(0);
        <?php else:  // then hide the admin bar by default ?>
            fullpageCommon.init_toggle_bar(1);
        <?php endif; ?>

        /*
        / Infinite Scroll
        */
        S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);
        var counter = 0;    

        for(var i=0; i<6; i++) {
            counter += 1; 
            console.log(counter);

            var container = $('#feedback-infinitescroll-landing');
            if( fullpageLayout.layout_name == 'treble' ) {
                container = $('.feedback-list');   
            }
            render_children(container, counter);
        }

        function update() {
            if( $(window).scrollTop() + $(window).height() == $(document).height() ) {
                if( $('#adminWindowBox').length && $('#adminWindowBox').css('display') == 'block' ) return;
                
                counter += 1;
                var page_counter = counter + 1;

                var container = $('#feedback-infinitescroll-landing');
                if( fullpageLayout.layout_name == 'treble' ) {
                    container = $('.feedback-list');   
                }
                /*
                $.ajax({ 
                    async: false,
                    url: '/hosted/fullpage_partial/' + page_counter
                  , success: function(msg) { 
                      var boxes = $(msg);
                      if( fullpageLayout.layout_name == 'treble' ) container.append(boxes.find('.feedback')); 
                      else container.append(boxes); 
                    }
                });
                */
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
