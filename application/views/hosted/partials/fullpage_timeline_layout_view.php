<?php if($collection): ?>
<?php foreach ($collection as $feed_group => $feed_list) : ?>
<div class="feedback-block">
    <div class="feedback-spine"></div>                
    <div class="spine-spacer"></div>
    <div class="feedback-date">
    <h2><?=date('M d',$feed_group)?></h2>
    <!--
    <span><?=ucfirst(Helpers::relative_time($feed_group))?></span>
    -->
    </div>
    <div class="spine-spacer"></div>
    <!--start feedback-list -->
    <div class="feedback-list">
        <?php
        
        foreach ($feed_list as $feed) : 
            $admin_avatar               = ( ! is_null($user) ? '/uploaded_images/admin_avatar/' . $user->avatar : '/img/48x48-blank-avatar.jpg' );
            $admin_avatar               = ($feed->feed_data->admin_avatar) ? '/uploaded_images/admin_avatar/' . $feed->feed_data->admin_avatar : $admin_avatar;
            $admin_companyname          = ($feed->feed_data->admin_fullpagecompanyname) ? $feed->feed_data->admin_fullpagecompanyname : $feed->feed_data->admin_companyname; 
            $feedback_id                = $feed->feed_data->id;
            $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
            $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
            $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
            $avatar                     = Helpers::avatar_render($feed->feed_data->avatar, $feed->feed_data->origin);
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
        <div class="<?=$feedback_content_class?>">
        <!-- feedback header -->
        <div class="feedback-header clear">
            <div class="author">
                <div class="author-avatar">
                    <?if($feed->feed_data->displayimg == 1):?>
                        <img src="<?=$avatar?>" width="100%" />
                    <?endif?>
                </div> 
                <div class="author-information">
                    <div class="author-name break-word clear">
                        <span class="first_name"><?= HTML::entities($feed->feed_data->firstname); ?></span>
                        <span class="last_name"><?= HTML::entities($feed->feed_data->lastname); ?></span>
                        <span class="last_name_ini"><?=(strlen($feed->feed_data->lastname)>0) ? HTML::entities(substr($feed->feed_data->lastname, 0, 1)).'.' : '' ?></span>
                    </div>
                    <?php if( trim($tw_marker) == '' ): ?>
                        <div class="author-company break-word">

                            <?if($feed->feed_data->displaycompany == 1 && $feed->feed_data->displayposition == 1):?>                            
                                <span class="job" style="display: <?= ( trim($position) == '' ? 'none' : '' );?>;">
                                    <?= HTML::entities($position); ?><span class="company_comma" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">, </span>
                                </span>
                                <span class="company" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">
                                    <?= HTML::entities($company_name); ?>
                                </span>
                            <?endif?>

                            <?if($feed->feed_data->displaycompany == 1 && $feed->feed_data->displayposition == 0):?>                            
                                <span class="company" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">
                                    <?= HTML::entities($company_name); ?> 
                                </span>
                            <?endif?>

                            <?if($feed->feed_data->displaycompany == 0 && $feed->feed_data->displayposition == 1):?>                            
                                <span class="job" style="display: <?= ( trim($position) == '' ? 'none' : '' );?>;">
                                    <?= HTML::entities($position); ?><span class="company_comma" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;"></span>
                                </span>
                            <?endif?>

                        </div>
                        <div class="author-location-info break-word clear">
                            <?if($feed->feed_data->displaycountry == 1):?>
                                <div class="author-location">
                                    <span class="city" style="display: <?= ( trim($city) == '' ? 'none' : '' );?>;">
                                        <?= HTML::entities($city); ?><span class="location_comma" style="display: <?= ( trim($country_name) == '' ? 'none' : '' );?>;">, </span>
                                    </span>
                                    <span class="country" style="display: <?= ( trim($country_name) == '' ? 'none' : '' );?>;">
                                        <?= HTML::entities($country_name); ?>
                                    </span>
                                </div>
                                <div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                            <?endif?>
                        </div>
                        <div class="custom-meta-data break-word clear">
                            <?php if( ! is_null($metadata) ): ?>
                                <?php foreach( $metadata as $key => $val ): ?>
                                    <?php foreach( $val as $k => $v ): ?>
                                        <div class="meta-data">
                                            <?if($key == 'select'):?>
                                                <span class="meta-name"><?=HTML::entities( ucwords($k) )?>:</span>
                                            <?endif?>
                                            <?if($key == 'checkbox' || $key == 'radio' || $key == 'text'):?>
                                                <span class="meta-name"><?=HTML::entities( ucwords(str_replace("_", " ", $k)) );?>:</span>
                                            <?endif?>
                                            <?
                                            $prefix = "";
                                            $value_list = "";
                                            foreach($v as $d) {
                                                $value_list .= "<span class='meta-value'>" . HTML::entities($prefix . $d->value) . "</span>";
                                                $prefix = ", ";
                                            }
                                            echo $value_list;
                                            ?> 
                                        </div>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>  
            </div>
            <div class="reviews clear">
                <div class="ratings clear"> 
                    <!-- <div class="stars blue clear"><div class="star_rating" rating="<?=$feed->feed_data->int_rating;?>"></div></div> -->
                    <?if($feed->feed_data->displaysbmtdate == 1):?>
                        <div class="feedback-timestamp"><?=$feed->feed_data->daysago?></div>
                    <?endif?>
                    <div class="stars blue clear">
                        <div class="star <?= ($feed->feed_data->int_rating >= 1 ? 'full' : ''); ?>"></div>
                        <div class="star <?= ($feed->feed_data->int_rating >= 2 ? 'full' : ''); ?>"></div>
                        <div class="star <?= ($feed->feed_data->int_rating >= 3 ? 'full' : ''); ?>"></div>
                        <div class="star <?= ($feed->feed_data->int_rating >= 4 ? 'full' : ''); ?>"></div>
                        <div class="star <?= ($feed->feed_data->int_rating >= 5 ? 'full' : ''); ?>"></div>
                    </div>
                </div>
                <?php if($feed->feed_data->isfeatured == 1): ?>
                <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                    <span class="vote_count"><?php echo $vote_count; ?></span> 
                    <? if($vote_count > 1): ?>
                        people
                    <? else: ?>
                        person 
                    <? endif; ?>
                         found this useful
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
                    <span class="vote_count"><?php echo $vote_count; ?></span>
                    <? if($vote_count > 1): ?>
                        people
                    <? else: ?>
                        person 
                    <? endif; ?>
                         found this useful
                </div>
            <?php endif; ?>
            <div class="feedback-text break-word"> 
                <h1 class="<?=($feed->feed_data->isfeatured == 1) ? "reg-featured" : "reg"?>"><?=$feed->feed_data->title?></h1>
                <p><?= nl2br($feed->feed_data->text);?></p>
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
                        <div class="admin-name break-word">
                            <!-- <?=$admin_companyname?> says.. -->
                            <a href="#" feedid="<?=$feed->feed_data->id?>" class="admin-delete-reply" style="float:right">[x]</a>
                        </div>
                        <div class="admin-message clear">
                            <div class="admin-avatar"><img src="<?= '/uploaded_images/company_logos/comment/' . $feed->feed_data->company_logo; ?>" width="32" height="32" /></div>
                            <div class="message break-word"><?= Helpers::fb_comment_str($feed->feed_data->admin_reply); ?></div>
                        </div>
                    </div>
                    
                    <? // admin comment box. ?>
                    <div class="admin-comment-box" feedid="<?=$feed->feed_data->id?>" <?=($feed->feed_data->admin_reply) ? 'style="display:none"' : null?>>
                        <input type="hidden" class="admin-comment-id" value="<?=$feed->feed_data->id?>">
                        <input type="hidden" class="admin-user-id" value="<?=$user->userid?>">
                        <div class="admin-comment-textbox-container">
                            <div class="admin-avatar">
                                <img src="<?= '/uploaded_images/company_logos/comment/' . $feed->feed_data->company_logo; ?>" width="32" height="32" />
                            </div>
                            <textarea class="admin-comment-textbox" placeholder="Leave a comment as <?=$admin_companyname;?>..."></textarea>
                        </div>
                        <div class="admin-comment-leave-a-reply" STYLE="DISPLAY: NONE;">
                            <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span>
                            <input type="button" class="adminReply regular-button" value="Post Comment" />
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <? // posted admin comment. ?>
                <?if($feed->feed_data->admin_reply && $feed->feed_data->admin_username):?>
                    <div class="admin-comment-block">
                        <div class="admin-comment">
                            <!-- <div class="admin-name break-word"><?=$admin_companyname?> says..</div> -->
                            <div class="admin-message clear">
                                <div class="admin-avatar"><img src="<?= '/uploaded_images/company_logos/comment/' . $feed->feed_data->company_logo; ?>" width="32" height="32" /></div>
                                <div class="message break-word"><?= Helpers::fb_comment_str($feed->feed_data->admin_reply); ?></div>
                            </div>
                        </div>
                    </div>
                <?endif?>
            <?php endif; ?>
        </div><!-- end of feedback text bubble -->
        
        <!-- feedback user actions -->
        <div class="feedback-options clear">
            <div class="feedback-icon-list clear">
                <div class="feedback-recommendation">
                    <?php if( $is_recommended ): ?>
                        <div class="green-thumb break-word">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
                    <?php endif; ?>
                    <div class="vote-block" <?=(!$is_recommended) ? 'style="padding-top:5px"' : null?>>
                        <span class="vote-action <?= ($voted != 1 ? '' : 'hidden'); ?>">
                            Was this useful? <a href="#" class="small-btn-pin">Yes</a>
                        </span>
                    </div>
                </div>
                <!-- <?php if( $is_recommended ): ?>
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
                </div> -->
                <div style="float: right;">
                    <div class="flag-feedback feedback-icon <?=($flagged!=1) ? 'flag-feedback-fancy' : '' ?>" fid="<?=$feedback_id;?>">
                        <div id="flag-feedback-icon-<?=$feedback_id;?>" class="feedback-icon-class flag-icon <?= ($flagged ? 'undo_flag_inapp active-icon' : 'flag-as-inapp'); ?>"></div>
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
                    <div class="feedback-icon share-feedback">
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
                    <div class="single_page_link"><a href="/single/<?=$feedback_id;?>">...</a></div>
                </div>
            </div>
        </div>
        <!-- end of feedback user actions -->
        </div>
    </div>
    <?php endforeach; //endforeach feed_list ?>
    </div> 
    <!--end feedback-list -->

</div>
<?php endforeach; //endforeach collection ?>
<?php endif; //endif collection?>
