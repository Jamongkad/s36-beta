<?php if($collection): ?>
<?php foreach ($collection as $feed_group => $feed_list) :  ?>
    <div class="feedback-list">
    <?php foreach ($feed_list as $feed) :
        $admin_avatar               = ($feed->feed_data->admin_avatar) ? $feed->feed_data->admin_avatar : '/img/48x48-blank-avatar.jpg';
        $admin_companyname          = ($feed->feed_data->admin_fullpagecompanyname) ? $feed->feed_data->admin_fullpagecompanyname : $feed->feed_data->admin_companyname; 
        $feedback_id                = $feed->feed_data->id;
        $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
        $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
        $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
        $avatar                     = (!empty($feed->feed_data->avatar)) ? Config::get('application.avatar48_dir').'/'.$feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
        $attachments                = (!empty($feed->feed_data->attachments)) ? $feed->feed_data->attachments : false;
        $vote_count                 = $feed->feed_data->vote_count;
        $voted                      = $feed->feed_data->useful;
        $flagged                    = $feed->feed_data->flagged_as_inappr;
        $metadata                   = $feed->feed_data->metadata;
        $is_recommended             = $feed->feed_data->isrecommended;
        $position                   = $feed->feed_data->position;
        $company_name               = $feed->feed_data->companyname;
        $city                       = $feed->feed_data->city;
        $country_name               = $feed->feed_data->countryname;
    ?>

    <div class="feedback <?=$feedback_main_class?>" fid="<?=$feedback_id;?>">
    <?=$tw_marker?>
    <div class="<?=$feedback_main_class?>-contents">
        <!-- feedback header -->
        <div class="feedback-header clear">
            <div class="reviews clear">
                <div class="ratings <?=($feed->feed_data->isfeatured == 1) ? 'clear' : ''?>">
                    <div class="feedback-timestamp"><?=$feed->feed_data->daysago?></div>
                    <div class="stars blue clear"><div class="star_rating" rating="<?=$feed->feed_data->int_rating;?>"></div></div>
                </div>
            </div>
            <div class="author">
                <div class="author-avatar"><img src="<?=$avatar?>" width="100%" /></div>  
                <div class="author-information">
                    <div class="author-name clear">
                        <span class="first_name"><?= HTML::entities($feed->feed_data->firstname); ?></span>
                        <span class="last_name"><?= HTML::entities($feed->feed_data->lastname); ?></span>
                        <span class="last_name_ini"><?= HTML::entities(substr($feed->feed_data->lastname, 0, 1)); ?>.</span>
                    </div>
                    <div class="author-company">
                        <span class="job" style="display: <?= ( trim($position) == '' ? 'none' : '' );?>;">
                            <?= HTML::entities($position); ?><span class="company_comma" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">, </span>
                        </span>
                        <span class="company" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">
                            <?= HTML::entities($company_name); ?>
                        </span>
                    </div>
                    <div class="author-location-info clear">
                        <div class="author-location">
                            <span class="city" style="display: <?= ( trim($city) == '' ? 'none' : '' );?>;">
                                <?= HTML::entities($city); ?><span class="location_comma" style="display: <?= ( trim($country_name) == '' ? 'none' : '' );?>;">, </span>
                            </span>
                            <span class="country" style="display: <?= ( trim($country_name) == '' ? 'none' : '' );?>;">
                                <?= HTML::entities($country_name); ?>
                            </span>
                        </div>
                        <div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                    </div>
                </div>  
            </div>
        </div>
        <!-- end of feedback header -->
        <!-- feedback text bubble -->
        <div class="feedback-text-bubble">
            <div class="feedback-tail"></div>
                <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                    <span class="vote_count"><?php echo $vote_count; ?></span>
                    <? if($vote_count > 1): ?>
                        people
                    <? else: ?>
                        person 
                    <? endif; ?>
                        found this useful
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
                <p><?= HTML::entities($feed->feed_data->text);?></p>
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
                                    <?php $thumb_url = ($feed->feed_data->isfeatured == 1) ? Config::get('application.attachments_medium').'/'.$uploaded_image->name : Config::get('application.attachments_small').'/'.$uploaded_image->name ?>
                                    <a class="fullpage-fancybox" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="uploaded-images-<?=$feedback_id?>">
                                        <img src="<?=$thumb_url?>" width="100%" />
                                    </a>
                                    <input type="hidden" class="image-name" value="<?=$uploaded_image->name?>"/>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; //endif uploaded images ?>

                <?php if(isset($attachments->attached_link)): ?>                       
                    <?
                    $attached_url = Helpers::secure_link($attachments->attached_link->url);
                    $attached_image = Helpers::secure_link($attachments->attached_link->image);
                    $attachment_desc = $attachments->attached_link->description;
                    $attachment_desc = ($attachment_desc == substr($attachment_desc, 0, 80) ? $attachment_desc : substr($attachment_desc, 0, 80) . '...');
                    ?>
                    <div class="uploaded-link">
                        <div class="padded-5">
                                <div class="form-video-meta">
                                    <?php if($attachments->attached_link->video=='yes'): ?>
                                        <div class="video-thumb">
                                            <a class="fancybox-video" href="<?=$attached_url?>" rel="uploaded-videos-<?=$feedback_id?>">
                                                <div class="video-circle"></div>
                                                <div class="the-thumb">
                                                    <img src="<?=$attached_image?>" width="100%" />
                                                </div>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="video-thumb">
                                            <a href="<?=$attached_url?>" target="_blank">
                                                <img src="<?=$attached_image?>" width="100%">
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="video-details">
                                        <h3><?= HTML::entities($attachments->attached_link->title); ?></h3>
                                        <p><?= HTML::entities($attachment_desc); ?></p>
                                    </div>
                                </div>
                            </div>
                    </div>
                <?php endif; //endif attached link ?>
                </div>
            <?php endif; ?>
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
                            <!-- <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span> -->
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
                <?php endif; ?>
        </div>
        <!-- end of feedback text bubble -->
        <!-- feedback user actions -->
        <div class="feedback-options clear">
            <div class="feedback-icon-list clear">
                <?php if( $is_recommended ): ?>
                    <div class="feedback-icon">
                        <div class="feedback-icon-class recommend-icon active-icon"></div>
                        <div class="icon-tooltip">
                         <div class="icon-tooltip-text">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
                            <div class="icon-tooltip-tail"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="feedback-icon">
                    <div class="feedback-icon-class useful-icon vote-action <?= ($voted ? 'active-icon off' : ''); ?>"></div>
                    <div class="icon-tooltip">
                        <div class="icon-tooltip-text">
                            <?php if( $voted ): ?>
                                You found this useful
                            <?php else: ?>
                                Was this useful?
                            <?php endif; ?>
                        </div>
                        <div class="icon-tooltip-tail"></div>
                    </div>
                </div>
                <div class="feedback-icon">
                    <div class="feedback-icon-class flag-icon <?= ($flagged ? 'undo_flag_inapp active-icon' : 'flag-as-inapp'); ?>"></div>
                    <div class="icon-tooltip">
                        <div class="icon-tooltip-text">
                            <?php if( $flagged ): ?>
                                Undo flag
                            <?php else: ?>
                                Flag as Inappropriate
                            <?php endif; ?>
                        </div>
                        <div class="icon-tooltip-tail"></div>
                    </div>
                </div>
                <div class="feedback-icon">
                    <div class="feedback-icon-class share-icon"></div>
                    <div class="icon-tooltip">
                     <div class="icon-tooltip-text">Share</div>
                        <div class="icon-tooltip-tail"></div>
                    </div>
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
                                data-text="<?=$feed->feed_data->text?>"
                                class="tw_share_dummy">Tweet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of feedback user actions -->
    </div>
    </div>

    <?php endforeach; //endforeach feed_list ?>
    </div><!-- end div feed-list -->

<?php endforeach; //endforeach collection ?>
<?php endif; //endif collection ?>
