<?php if($collection): ?>
<div id="threeColumnLayout">
<?php foreach ($collection as $feed_group => $feed_list) :  ?>
    <div class="feedback-list">
    <?php foreach ($feed_list as $feed) :
        $admin_avatar               = ($feed->feed_data->admin_avatar) ? $feed->feed_data->admin_avatar : '/img/48x48-blank-avatar.jpg';
        $admin_companyname          = ($feed->feed_data->admin_fullpagecompanyname) ? $feed->feed_data->admin_fullpagecompanyname : $feed->feed_data->admin_companyname; 
        $feedback_id                = $feed->feed_data->id;
        $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
        $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
        $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
        $avatar                     = Config::get('application.avatar48_dir').'/'.$feed->feed_data->avatar;
        $attachments                = (!empty($feed->feed_data->attachments)) ? $feed->feed_data->attachments : false;
        $vote_count                 = $feed->feed_data->vote_count;
        $voted                      = $feed->feed_data->useful;
        $flagged                    = $feed->feed_data->flagged_as_inappr;
        $metadata                   = $feed->feed_data->metadata;
    ?>

    <div class="feedback <?=$feedback_main_class?>" fid="<?=$feedback_id;?>">
    <?=$tw_marker?>
    <div class="<?=$feedback_main_class?>-contents">
        <!-- feedback header -->
        <div class="feedback-header clear">
            <div class="author">
                <div class="author-avatar"><img src="<?=$avatar?>" width="48" height="48" /></div>  
                <div class="author-information">
                    <div class="author-name clear">
                        <span class="first_name"><?= HTML::entities($feed->feed_data->firstname); ?></span>
                        <span class="last_name"><?= HTML::entities($feed->feed_data->lastname); ?></span>
                    </div>
                    <div class="author-company">
                        <span class="job"><?= HTML::entities($feed->feed_data->position); ?></span>
                        <span class="company_comma">,</span>
                        <span class="company"><?= HTML::entities($feed->feed_data->companyname); ?></span>
                    </div>
                    <div class="author-location-info clear">
                        <div class="author-location">
                            <span class="city"><?= HTML::entities($feed->feed_data->city); ?></span>
                            <span class="location_comma">,</span>
                            <span class="country"><?= HTML::entities($feed->feed_data->countryname); ?></span>
                        </div>
                        <div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                    </div>
                </div>  
            </div>
            <div class="reviews clear">
                <div class="ratings clear">
                    <div class="feedback-timestamp"><?=$feed->feed_data->daysago?></div>
                    <div class="star_rating" rating="<?=$feed->feed_data->int_rating;?>"></div>
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
            <div class="custom-meta-data clear">
                <?php if( ! is_null($metadata) ): ?>
                    <?php foreach( $metadata as $group ): ?>
                        <?php foreach( $group as $item ): ?>
                            <div class="meta-data">
                                <span class="meta-name"><?= HTML::entities( ucwords(str_replace('_', ' ', $item[0]->name)) ); ?> : </span>
                                <span class="meta-value"><?= HTML::entities($item[0]->value); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="feedback-text">
                <?= HTML::entities($feed->feed_data->text);?>
            </div>
                    <!-- are there any additional info uploaded?? -->
            <?php if($attachments): ?>
            <div class="additional-contents">
            <!-- is it an image? -->
            <?php if(isset($attachments->uploaded_images)): ?>
                <div class="uploaded-images clear">
                    <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                    <div class="uploaded-image">
                        <div class="padded-5">
                            <div class="the-thumb">
                                <input type="hidden" class="large-image-url" value="<?=$uploaded_image->large_url?>"/>
                                <img src="<?=$uploaded_image->small_url?>" width="100%" />
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; //endif uploaded images ?>

            <?php if(isset($attachments->attached_link)): ?>                       
                <div class="uploaded-link">
                    <div class="padded-5">
                        <div class="form-video-meta">
                            <?php if($attachments->attached_link->video=='yes'): ?>
                                <div class="video-thumb">
                                    <div class="video-circle"></div>
                                    <div class="the-thumb">
                                        <input type="hidden" class="link-url" value="<?=$attachments->attached_link->url?>"/>
                                        <img src="<?=$attachments->attached_link->image?>" width="100%">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="video-thumb">
                                    <a href="<?=$attachments->attached_link->url?>" target="_blank">
                                        <img src="<?=$attachments->attached_link->image?>" width="100%">
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="video-details">
                                <h3><?=$attachments->attached_link->title?></h3>
                                <p><?=$attachments->attached_link->description?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; //endif attached link ?>
            </div>
            <?php endif; //endif attachments ?>

            <!-- end of additional info block -->
            <?php if(isset($user) && !empty($user)): ?>
                <div class="admin-comment-block">
                    <div class="admin-comment" <?=(!$feed->feed_data->admin_reply) ? 'style="display:none"' : null?>>
                        <div class="admin-name">
                            <?=$user->fullname?> from <?=$admin_companyname?> says.. 
                            <a href="#" feedid="<?=$feed->feed_data->id?>" class="admin-delete-reply" style="float:right">[x]</a>
                        </div>
                        <div class="admin-message clear">
                            <div class="admin-avatar"><img src="<?=$admin_avatar?>" width="32" height="32" /></div>
                            <div class="message"><?=$feed->feed_data->admin_reply?></div>
                        </div>
                    </div>

                    <div class="admin-comment-box" feedid="<?=$feed->feed_data->id?>" <?=($feed->feed_data->admin_reply) ? 'style="display:none"' : null?>>
                        <input type="hidden" class="admin-comment-id" value="<?=$feed->feed_data->id?>">
                        <input type="hidden" class="admin-user-id" value="<?=$user->userid?>">
                        <div class="admin-comment-textbox-container">
                            <textarea class="admin-comment-textbox"></textarea>
                        </div>
                        <div class="admin-comment-leave-a-reply">
                            <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span>
                            <input type="button" class="adminReply regular-button" value="Post Comment" />
                        </div>
                    </div>
                </div>
                <?php else:?>
                    <?if($feed->feed_data->admin_reply && $feed->feed_data->admin_username):?>
                        <div class="admin-comment-block">
                            <div class="admin-comment">
                                <div class="admin-name"><?=$feed->feed_data->admin_fullname?> from <?=$admin_companyname?> says..</div>
                                <div class="admin-message clear">
                                    <div class="admin-avatar">
                                    <img src="<?=$admin_avatar?>" width="32" height="32" /></div>
                                    <div class="message"><?=$feed->feed_data->admin_reply?></div>
                                </div>
                            </div>
                        </div>
                    <?endif?>
            <?php endif; //endif admin reply?>
        </div>
        <!-- end of feedback text bubble -->
        <!-- feedback user actions -->
        <div class="feedback-options clear">
            <div class="feedback-recommendation">
                <div class="green-thumb">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
            </div>
            <?php if( $voted != 1 ): ?>
                <div class="feedback-vote">
                    <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a></span>
                </div>
            <?php endif; ?>
            <div class="feedback-actions clear">
                <span class="flag-as">Flag as inappropriate</span>
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

    <?php endforeach; //endforeach feed_list ?>
    </div><!-- end div feed-list -->

<?php endforeach; //endforeach collection ?>
</div><!-- end div threeColumnLayout -->
<?php endif; //endif collection ?>