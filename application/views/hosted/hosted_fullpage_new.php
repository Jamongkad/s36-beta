<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::script('/js/master.js'); ?>
<?= HTML::script('/js/s36_client_script.js'); ?>
<?= HTML::style('css/override.css'); ?>
<?= HTML::style('css/s36_client_style.css'); ?>
<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
$(document).ready(function(){
    $('.adminReply').click(function() {
        var my_parent = $(this).parents('.admin-comment-block');
        $.ajax({
            url: "/admin_reply",
            dataType: "json",
            data: {
                feedbackId: $(my_parent).find('.admin-comment-id').val(),
                adminReply: $(my_parent).find('.admin-comment-textbox').val()
            },
            type: "POST",
            success: function(result) {
                if(undefined != result.feedbackid){
                    $(my_parent).find('.admin-comment .admin-message .message').html(result.adminreply);
                    $(my_parent).find('.admin-comment-box').css('display','none');
                    $(my_parent).find('.admin-comment').css('display','block');
                }
          }
        });
    });

    /*lightbox*/
    $('.uploaded-images-close').click(function(){
            $(this).parent().fadeOut();
        });
    $('.the-thumb,.video-circle').click(function(){
        var scroll_offset = $(document).scrollTop();
        var top_offset = scroll_offset + 100;
        $('.lightbox').fadeIn().css('top',top_offset);
    });
    $('.uploaded-image').click(function(){
        var html = '<img src="'+$(this).find(' .the-thumb .large-image-url').val()+'" width="100%" />';
        $('.uploaded-images-content').html(html);
    });
    $('.video-thumb,.video-circle').click(function(){
        var embed_url = $(this).find('.link-url').val().replace('www.youtube.com/watch?v=','www.youtube.com/embed/');
        var html  = '<iframe width="770" height="400" src="'+embed_url+'" frameborder="0" allowfullscreen></iframe>';
        $('.uploaded-images-content').html(html);
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
                            <a href="" class="lightbox-button" onclick="javascript:close_lightbox();">CLOSE</a>
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
                    <?=View::make('hosted/partials/hosted_feedback_partial_view_new', Array('collection' => $feeds))?>
                    <div id="feedback-infinitescroll-landing"></div>
                </div>
            </div>
        </div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
    </div>
</div>
<?= HTML::script('/themes/hosted/fullpage/js/timeline.layout.js'); ?>

