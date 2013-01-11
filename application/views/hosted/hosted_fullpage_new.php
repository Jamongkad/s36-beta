<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::script('/js/master.js'); ?>
<?= HTML::script('/js/s36_client_script.js'); ?>
<?= HTML::style('css/override.css'); ?>
<?= HTML::style('css/s36_client_style.css'); ?>

<script type="text/javascript">
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
                    <?php 
                    //echo "<pre>"; print_r($feeds); echo "</pre>";
                    if($feeds):
                    foreach ($feeds as $feed_group => $feed_list) : 
                    ?>
                    <div class="feedback-block">
                        <div class="feedback-spine"></div>                
                        <div class="spine-spacer"></div>
                        <div class="feedback-date">
                            <h2><?=date('M d',$feed_group)?></h2>
                            <span><?=ucfirst(Helpers::relative_time($feed_group))?></span>
                        </div>
                        <div class="spine-spacer"></div>
                        <div class="feedback-list">
                            <?php
                            foreach ($feed_list as $feed) : 
                                $feedback_main_class         = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
                                $feedback_content_class      = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
                                $tw_marker                   = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
                                $author_name        = $feed->feed_data->firstname.' '.$feed->feed_data->lastname;
                                $author_company     = $feed->feed_data->position.', '.$feed->feed_data->companyname;
                                $author_location    = $feed->feed_data->city.', '.$feed->feed_data->countryname;
                                $text               = $feed->feed_data->text;
                                $feedback_id = $feed->feed_data->id;
                                $author_first_name = $feed->feed_data->firstname;
                                $vote_count = $feed->feed_data->vote_count;
                                $voted = $feed->feed_data->useful;
                                $flagged = $feed->feed_data->flagged;
                                $product = '6-Pac Abs Workout DVD';
                                $pricing = 'Good';
                                $quality = 'Excellent';
                            ?>
                            <div class="feedback <?=$feedback_main_class?>" fid="<?php echo $feedback_id; ?>">
                                <?=$tw_marker?>
                                <div class="<?=$feedback_content_class?>">
                                    <!-- feedback header -->
                                    <div class="feedback-header clear">
                                        <div class="author">
                                            <div class="author-avatar"><img src="<?=$feed->feed_data->avatar?>" width="48" height="48" /></div>
                                            <div class="author-information">
                                                <div class="author-name clear"><?= HTML::entities($author_name); ?></div>
                                                <div class="author-company"><?= HTML::entities($author_company); ?></div>
                                                <div class="author-location-info clear">
                                                    <div class="author-location"><?= HTML::entities($author_location); ?></div><div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                                                </div>
                                                <div class="custom-meta-data clear">
                                                    <?php if( $product != '' ): ?>
                                                        <div class="meta-data"><span class="meta-name">Product : </span><span class="meta-value"> <?= HTML::entities($product); ?></span></div>
                                                    <?php endif; ?>
                                                    <?php if( $pricing != '' ): ?>
                                                        <div class="meta-data"><span class="meta-name">Pricing : </span><span class="meta-value"> <?= HTML::entities($pricing); ?></span></div>
                                                    <?php endif; ?>
                                                    <?php if( $quality != '' ): ?>
                                                        <div class="meta-data"><span class="meta-name">Quality : </span><span class="meta-value"> <?= HTML::entities($quality); ?></span></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="reviews clear">
                                            <div class="ratings">
                                                <div class="feedback-timestamp">Posted 3 hours ago</div>
                                                <!--<div class="feedback-timestamp">Posted <?= Helpers::relative_time($feed->feed_data->date); ?></div>-->
                                                <div class="star_rating" rating="3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of feedback header -->
                                    <!-- feedback text bubble -->
                                    <div class="feedback-text-bubble">
                                        <div class="feedback-tail"></div>
                                        <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                                            <span class="vote_count"><?php echo $vote_count; ?></span> people found this useful
                                        </div>
                                        <div class="feedback-text">
                                            <p><?= nl2br(HTML::entities($text)); ?></p>                                            
                                        </div>
                                        <div class="additional-contents">
                                            <!-- is it an image? -->
                                            <div class="uploaded-images clear">
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample.jpg" width="100%" />
                                                    </div>
                                                </div>
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample.jpg" width="100%" />
                                                    </div>
                                                </div>
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample-bg.jpg" width="100%" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- a video -->
                                            <div class="uploaded-video">
                                                <div class="padded-5">
                                                    <iframe width="293" height="220" src="" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            <!-- or just a preview link? -->
                                            <div class="uploaded-link">
                                                <div class="padded-5">
                                                    <div class="form-video-meta">
                                                        <div class="video-thumb">
                                                            <img src="http://i2.ytimg.com/vi/e9iDr1kFZDo/hqdefault.jpg" width="100%">
                                                        </div>
                                                        <div class="video-details">
                                                            <h3>Happy Tree Friends - Remains To Be See...</h3>
                                                            <p>Watch the NEW Happy Tree Friends episode "Bottled Up"! (Model ship not included) - http://bit.ly/UnwakV Do you want extra exclusive content? Circle us on Goo...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if( ! is_null($user) ): ?>
                                            <div class="admin-comment-block">
                                                <div class="admin-comment-box">
                                                    <div class="admin-comment-textbox-container">
                                                        <textarea class="admin-comment-textbox"></textarea>
                                                    </div>
                                                    <div class="admin-comment-leave-a-reply">
                                                        <span class="admin-logged-session">Logged in as <a href="#"><?php echo HTML::entities($user->fullname); ?></a></span>
                                                        <input type="button" class="regular-button" value="Post Comment" />
                                                    </div>
                                                </div>
                                                <!--
                                                <div class="admin-comment">
                                                    <div class="admin-name">Amy from Acme Inc says..</div>
                                                    <div class="admin-message clear">
                                                        <div class="admin-avatar"><img src="images/samchloe.png" width="32" height="32" /></div>
                                                        <div class="message">Great choice!</div>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <!-- end of feedback text bubble -->
                                    <!-- feedback user actions -->
                                    <div class="feedback-options clear">
                                        <div class="feedback-recommendation">
                                            <div class="green-thumb">Recommended by <?php echo HTML::entities($author_first_name); ?> to friends</div>
                                            <?php if( $voted != 1 ): ?>
                                                <div class="vote-block">
                                                    <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="feedback-actions clear">
                                            <?php if( $flagged != 1 ): ?>
                                                <span class="flag-as">Flag as inappropriate</span>
                                            <?php endif; ?>
                                            <span class="share-button">
                                                Share
                                                <div class="share-box">
                                                 <div class="share-box-arrow"></div>
                                                    <div class="btn-block">
                                                        <div class="fb_like_dummy" 
                                                            data-href="<?=URL::to('single/'.$feed->feed_data->id)?>"
                                                            data-layout="button_count"
                                                            data-send="false" 
                                                            data-width="80" 
                                                            data-show-faces="false"></div>
                                                    </div>
                                                    <div class="btn-block">
                                                        <a href="<?=URL::to('single/'.$feed->feed_data->id)?>"
                                                            data-url="<?=URL::to('single/'.$feed->feed_data->id)?>"
                                                            data-text="<?=$text?>"
                                                            class="tw_share_dummy">Tweet</a>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- end of feedback user actions -->
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    endforeach;
                    endif;
                    ?>
                    <?=View::make('hosted/partials/hosted_feedback_partial_view', Array('collection' => $feeds))?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?= HTML::script('/themes/hosted/fullpage/js/timeline.layout.js'); ?>