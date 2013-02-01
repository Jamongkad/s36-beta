<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
</script>
<?php if( ! is_null($user) ): ?>
<div id="notification">
    <div id="notification-design">
        <div id="notification-message">
            Loading... Please Wait... you bits.
        </div>
    </div>
</div>
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
                    <div class="social-icon"><a href="#"><img src="/fullpage/common/img/facebook.png" title="Facebook Page" /></a></div>
                    <div class="social-icon"><a href="#"><img src="/fullpage/common/img/twitter.png" title="Twitter Page" /></a></div>                    
                </div>
            </div>

        <div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
        <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" />
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                      <div id="desc_text" itemprop="summary"><?= nl2br( HTML::entities($company->description) ); ?></div>
                            <?php if( ! is_null($user) ): ?>
                                <div id="desc_textbox_con">
                                    <textarea id="desc_textbox" rows="3"><?=$company->description?></textarea>
                                </div>
                                <div id="action_buttons">
                                    <div class="edit action_button" title="Edit"></div>
                                    <div class="save action_button" title="Save"></div>
                                    <div class="cancel action_button" title="Cancel"></div>
                                </div>
                            <?php endif; ?>
                    </div>
                    <div class="send-button" widgetkey="<?=$company->widgetkey?>"><a href="javascript:;">Send in feedback</a></div>
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
                            <a href="#" class="lightbox-button" onclick="javascript:close_lightbox();">CLOSE</a>
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
                           
                                <!--  if video 
                                <iframe width="770" height="400" src="http://www.youtube.com/embed/qg6r-IeH7ss" frameborder="0" allowfullscreen></iframe>
                
                                <!-- if image 
                                
                                <img src="fullpage/common/img/sample-inbox-image2.jpg" width="100%" /> -->
                            </div> 
                            <!--
                            <div class="uploaded-images-name">Example-name-2012.jpg</div>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of lightbox container -->
            
            <div id="feedbackContainer">
                <?=View::make('hosted/partials/fullpage_treble_layout_view', Array('collection' => $feeds, 'user' => $user))?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        var fullpageCommon = new S36FullpageCommon;
        var fullpageLayout = new S36FullpageLayoutTreble;
            fullpageLayout.init_fullpage_layout(); // initialize document ready of the current layout javascripts
            fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
        <?php if( ! is_null($user) ): //then display the admin bar by default ?>
            var fullpageAdmin  = new S36FullpageAdmin(fullpageLayout);
                fullpageAdmin.init_fullpage_admin();
                fullpageCommon.init_toggle_bar(0);
        <?php else:  // then hide the admin bar by default ?>
                fullpageCommon.init_toggle_bar(1);
        <?php endif; ?>

        
    });
</script>

<?php //echo $display->display_options_generate_css(); ?>