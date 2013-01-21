<!-- blocks are separated by dates so we create containers for each dates -->
<?php
if($collection):
foreach ($collection as $feed_group => $feed_list) : 
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
            $feedback_id                = $feed->feed_data->id;
            $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
            $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
            $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
            $avatar                     = '/uploaded_images/avatar/48x48/'.$feed->feed_data->avatar;
            $author_name                = $feed->feed_data->firstname.' '.$feed->feed_data->lastname;
            $author_company             = $feed->feed_data->position.', '.$feed->feed_data->companyname;
            $author_location            = $feed->feed_data->city.', '.$feed->feed_data->countryname;
            $text                       = $feed->feed_data->text;
            $attachments                = (!empty($feed->feed_data->attachments)) ? $feed->feed_data->attachments : false;
            $vote_count                 = $feed->feed_data->vote_count;
            $voted                      = $feed->feed_data->useful;
            $flagged                    = $feed->feed_data->flagged_as_inappr;
            $metadata                   = $feed->feed_data->metadata;
        ?>
        <div class="feedback <?=$feedback_main_class?>" fid="<?=$feedback_id;?>">
            <?=$tw_marker?>
            <div class="<?=$feedback_content_class?>">
                <!-- feedback header -->
                <div class="feedback-header clear">
                    <div class="author">
                        <div class="author-avatar"><img src="<?=$avatar?>" width="48" height="48" /></div>
                        <div class="author-information">
                            <div class="author-name clear"><?= HTML::entities($author_name); ?></div>
                            <div class="author-company"><?= HTML::entities($author_company); ?></div>
                            <div class="author-location-info clear">
                                <div class="author-location"><?= HTML::entities($author_location); ?></div><div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                            </div>
                            <div class="custom-meta-data clear">
                                <?php if( ! is_null($metadata) ): ?>
                                    <?php foreach( $metadata as $group ): ?>
                                        <?php foreach( $group as $item ): ?>
                                            <div class="meta-data">
                                                <span class="meta-name"><?= HTML::entities( ucwords(str_replace('_', ' ', $item[0]->name)) ); ?> : </span>
                                                <span class="meta-value"> <?= HTML::entities($item[0]->value); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>  
                    </div>
                    <div class="reviews clear">
                        <div class="ratings <?=($feed->feed_data->isfeatured == 1) ? 'clear' : ''?>">
                            <div class="feedback-timestamp"><?=$feed->feed_data->daysago?></div>
                            <div class="star_rating" rating="3"></div>
                        </div>
                        <?php if($feed->feed_data->isfeatured == 1): ?>
                            <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                                <span class="vote_count"><?php echo $vote_count; ?></span> people found this useful
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- end of feedback header -->
                <!-- feedback text bubble -->
                <div class="feedback-text-bubble">
                    <div class="feedback-tail"></div>
                    <?php if($feed->feed_data->isfeatured != 1): ?>
                        <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                            <span class="vote_count"><?php echo $vote_count; ?></span> people found this useful
                        </div>
                    <?php endif; ?>
                    <div class="feedback-text">
                        <p><?=$text?></p>                                            
                    </div>

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
                    <?php endif; ?>

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
                    <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?
                $companyname = (isset($user->fullpagecompanyname)) ? $user->fullpagecompanyname : Null;
                $admin_avatar = (isset($feed->feed_data->admin_avatar)) ? $feed->feed_data->admin_avatar : '/img/48x48-blank-avatar.jpg';
                print_r(isset($feed->feed_data->admin_avatar));
                print_r($feed->feed_data->admin_avatar);
                $admin_companyname = (isset($feed->feed_data->admin_fullpagecompanyname)) ? $feed->feed_data->admin_fullpagecompanyname : $feed->feed_data->admin_companyname;
                ?>
                    <?php if(isset($user) && !empty($user)): ?>
                        <div class="admin-comment-block">

                            <div class="admin-comment" <?=(!$feed->feed_data->admin_reply) ? 'style="display:none"' : null?>>
                                <div class="admin-name">
                                    <?=$user->fullname?> from <?=$companyname?> says.. 
                                    <a href="#" feedid="<?=$feed->feed_data->id?>" class="admin-delete-reply" style="float:right">[delete your reply]</a>
                                </div>
                                <div class="admin-message clear">
                                    <div class="admin-avatar"><img src="<?=$admin_avatar?>" width="32" height="32" /></div>
                                    <div class="message"><?=$feed->feed_data->admin_reply?></div>
                                </div>
                            </div>

                            <div class="admin-comment-box" <?=($feed->feed_data->admin_reply) ? 'style="display:none"' : null?>>
                                <input type="hidden" class="admin-comment-id" value="<?=$feed->feed_data->id?>">
                                <input type="hidden" class="admin-user-id" value="<?=$user->userid?>">
                                <div class="admin-comment-textbox-container">
                                    <textarea class="admin-comment-textbox"><?=$feed->feed_data->admin_reply?></textarea>
                                </div>
                                <div class="admin-comment-leave-a-reply">
                                    <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span>
                                    <input type="button" class="adminReply regular-button" value="Post Comment" />
                                </div>
                            </div>
                                 
                        </div>
                    <?php else:?>
                        <?if($feed->feed_data->admin_reply):?>
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
                    <div class="feedback-recommendation">
                        <div class="green-thumb">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
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
