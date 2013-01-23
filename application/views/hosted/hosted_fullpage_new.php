<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::script('/js/s36_client_script.js'); ?>
<?= HTML::style('css/override.css'); ?>
<?= HTML::style('css/s36_client_style.css'); ?>

<?php if( ! is_null($user) ): ?>
    <?= HTML::style('admin/admin.css'); ?>
    <?= HTML::style('admin/jcarousel.skin.css'); ?>
    <?= HTML::script('admin/jcycle.js'); ?>
    <?= HTML::script('js/jquery.ui.widget.js'); ?>
    <?= HTML::script('js/jquery.iframe-transport.js'); ?>
    <?= HTML::script('js/jquery.fileupload.js'); ?>
    <?= HTML::script('admin/jquery.jcarousel.min.js'); ?>
    <?= HTML::script('admin/admin.js'); ?>
<?php endif; ?>

<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
$(document).ready(function(){});
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
<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer" itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
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
            </div>
           
            <!-- start of Review-aggregate scope -->
            <div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
                <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" /><!-- for rich snippets. -->
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
            <!-- end of Review-aggregate scope -->
            
            <!-- lightbox notification -->
            <div class="lightbox-s"></div>
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
                            <a href="#" class="lightbox-button error-close-button">CLOSE</a>
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
                <div id="timelineLayout">
                    <!-- blocks are separated by dates so we create containers for each dates -->
                    <?=View::make('hosted/partials/hosted_feedback_partial_view_new', Array('collection' => $feeds, 'user' => $user))?>
                    <div id="feedback-infinitescroll-landing"></div>
                </div>
            </div>
        </div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
    </div>
</div>

<?=HTML::script('/themes/hosted/fullpage/js/timeline.layout.js'); ?>
