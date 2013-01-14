<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::script('/js/master.js'); ?>
<?= HTML::script('/js/s36_client_script.js'); ?>
<?= HTML::style('css/override.css'); ?>
<?= HTML::style('css/s36_client_style.css'); ?>
<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
$(document).ready(function(){
    $('.adminReply').click(function(){
        var parent = $(this).parents('.admin-comment-block');
        $.ajax({
            url: "/admin_reply",
            dataType: "json",
            data: {
                feedbackId: $(parent).find('.admin-comment-id').val(),
                adminReply: $(parent).find('.admin-comment-textbox').val()
            },
            type: "POST",
            success: function(result) {
                if(undefined != result.feedbackid){
                    $(parent).find('.admin-comment .admin-message .message').html(result.adminreply);
                    $(parent).find('.admin-comment-box').css('display','none');
                    $(parent).find('.admin-comment').css('display','block');
                }
          }
        });
    });
});
</script>


<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
            <div id="coverPhotoContainer">
                <div id="coverPhoto">
                    <img src="img/sample-cover.jpg" />
                </div>
            </div>
           
            <!-- start of Review-aggregate scope -->
            <div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
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
                        <div class="send-button"><a href="javascript:;">Send in feedback</a></div>
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
            
            <div id="feedbackContainer">
                <div id="timelineLayout">
                    <!-- blocks are separated by dates so we create containers for each dates -->
                    <?=View::make('hosted/partials/hosted_feedback_partial_view_new', Array('collection' => $feeds))?>
                </div>
            </div>
        </div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
    </div>
</div>
<?= HTML::script('/themes/hosted/fullpage/js/timeline.layout.js'); ?>
