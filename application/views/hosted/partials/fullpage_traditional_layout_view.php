<?php if($collection): ?>
<div id="traditionalV2"> 
    <?php foreach ($collection as $feed_group => $feed_list) :  ?>
    <div class="feedback-list">
        <?php foreach ($feed_list as $feed) :
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
            <?php if($feed->feed_data->isfeatured == 1): ?>
            <div class="feedback regular-featured" fid="<?=$feedback_id?>">
                <div class="regular-featured-contents clear">
                    <!-- feedback header -->
                    <div class="feedback-header">
                        <div class="author clear">
                            <div class="author-avatar">
                                <?if($feed->feed_data->displayimg == 1):?>
                                    <img src="<?=$avatar?>" width="150" height="150" />
                                <?endif?>
                            </div>    
                            <div class="author-information">
                                <div class="author-name">
                                    <span class="first_name"><?= HTML::entities($feed->feed_data->firstname); ?></span>
                                    <span class="last_name"><?= HTML::entities($feed->feed_data->lastname); ?></span>
                                    <span class="last_name_ini"><?=(strlen($feed->feed_data->lastname)>0) ? HTML::entities(substr($feed->feed_data->lastname, 0, 1)).'.' : '' ?></span>
                                </div>
                                <div class="author-company">
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
                                <div class="author-location-info ">
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
                                <div class="custom-meta-data ">
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
                            </div>  
                        </div>
                    </div>
                    <div class="reviews clear">
                        <div class="ratings clear">
                            <div class="stars blue clear">
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star half"></div>    
                            </div>
                            <?if($feed->feed_data->displaysbmtdate == 1):?>
                                <div class="feedback-timestamp">Posted <?=$feed->feed_data->daysago?></div>
                            <?endif?>
                            <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                                <span class="vote_count"><?php echo $vote_count; ?></span> 
                                <? if($vote_count > 1): ?>
                                    people
                                <? else: ?>
                                    person 
                                <? endif; ?>
                                     found this useful
                            </div>
                        </div>
                    </div>
                    <!-- end of feedback header -->
                    
                    <!-- feedback text bubble -->
                    <div class="feedback-text-bubble">
                        <div class="feedback-text">
                            <h1><?=$feed->feed_data->title?></h1>
                            <p><?= nl2br($feed->feed_data->text);?></p>
                        </div>
                        <!--
                        <div class="admin-comment-block">
                            <div class="admin-comment-box">
                                <div class="admin-comment-textbox-container">
                                    <textarea class="admin-comment-textbox"></textarea>
                                </div>
                                <div class="admin-comment-leave-a-reply">
                                    <span class="admin-logged-session">Logged in as <a href="#">Chris Davidson</a></span><input type="button" class="regular-button" value="Post Comment" />
                                </div>
                            </div>
                            <!--
                            <div class="admin-comment">
                                <div class="admin-name">Amy from Acme Inc says..</div>
                                <div class="admin-message clear">
                                    <div class="admin-avatar"><img src="fullpage/common/img/samchloe.png" width="32" height="32" /></div>
                                    <div class="message">Great choice!</div>
                                </div>
                            </div>
                            -->
                        </div>
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
                                                <a class="fullpage-fancybox" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="uploaded-images-<?=$feedback_id?>">
                                                    <img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>" width="100%" />
                                                </a>
                                                <input type="hidden" class="image-name" value="<?=$uploaded_image->name?>"/>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; //endif uploaded images ?>

                        <?php if(isset($attachments->attached_link)):                     
                            $attached_video     = ($attachments->attached_link->video=='yes') ? true : false;
                            $attached_url       = Helpers::secure_link($attachments->attached_link->url);
                            $attached_image     = Helpers::secure_link($attachments->attached_link->image);
                            $attachment_title   = $attachments->attached_link->title;
                            $attachment_desc    = $attachments->attached_link->description;
                            $attachment_desc    = ($attachment_desc == substr($attachment_desc, 0, 80) ? $attachment_desc : substr($attachment_desc, 0, 80) . '...');
                        ?>
                        <div class="uploaded-link">
                            <div class="padded-5">
                                <div class="form-video-meta">
                                    <?php if($attached_video): ?>
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
                                        <h3><?= HTML::entities($attachment_title); ?></h3>
                                        <p><?= HTML::entities($attachment_desc); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; //endif attached link ?>
                        </div>
                    <?php endif; //endif attachments ?>

                    <!-- end of additional info block -->
                    <!-- end of feedback text bubble -->
                    <!-- feedback user actions -->
                    <div class="feedback-options clear">
                        <div class="feedback-recommendation">
                            <?php if( $is_recommended ): ?>
                                <div class="green-thumb">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
                            <?php endif; ?>
                        </div>
                        <div class="feedback-vote">
                            <span class="vote-action <?= ($voted != 1 ? '' : 'hidden'); ?>">
                                Was this useful? <a href="#" class="small-btn-pin">Yes</a>
                            </span>
                        </div>
                        <div class="feedback-actions clear">
                            <span class="flag-as"><?=(!$flagged) ? 'Flag as inappropriate' : 'Undo flag' ?></span>
                            <span class="share-button">
                                Share
                            </span>
                            <div class="single_page_link"><a href="/single/<?=$feedback_id;?>">...</a></div>
                        </div>    
                    </div>
                    <!-- end of feedback user actions -->
                </div>
            <?php else: ?>
            <div class="feedback regular" fid="<?=$feedback_id?>">
                <div class="regular-contents">
                    <!-- feedback header -->
                    <div class="feedback-header">
                        <div class="author clear">
                            <div class="author-avatar">
                                <?if($feed->feed_data->displayimg == 1):?>
                                    <img src="<?=$avatar?>" width="48" height="48" />
                                <?endif?>
                            </div>
                            <div class="author-information">
                                <div class="author-name">
                                    <span class="first_name"><?= HTML::entities($feed->feed_data->firstname); ?></span>
                                    <span class="last_name"><?= HTML::entities($feed->feed_data->lastname); ?></span>
                                    <span class="last_name_ini"><?=(strlen($feed->feed_data->lastname)>0) ? HTML::entities(substr($feed->feed_data->lastname, 0, 1)).'.' : '' ?></span>
                                </div>
                                <div class="author-company">

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
                                <div class="author-location-info ">
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
                                <div class="custom-meta-data ">
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
                            </div>
                        </div>
                        <div class="reviews clear">
                            <div class="ratings clear">
                                <div class="stars blue clear">
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star half"></div>    
                                </div>
                                <?if($feed->feed_data->displaysbmtdate == 1):?>
                                    <div class="feedback-timestamp">Posted <?=$feed->feed_data->daysago?></div>
                                <?endif?>
                                <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                                    <span class="vote_count"><?php echo $vote_count; ?></span> 
                                    <? if($vote_count > 1): ?>
                                        people
                                    <? else: ?>
                                        person 
                                    <? endif; ?>
                                         found this useful
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of feedback header -->
                    
                    <!-- feedback text bubble -->
                    <div class="feedback-text-bubble">
                        <div class="feedback-text">
                            <h1><?=$feed->feed_data->title?></h1>
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
                                                    <a class="fullpage-fancybox" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="uploaded-images-<?=$feedback_id?>">
                                                        <img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>" width="100%" />
                                                    </a>
                                                    <input type="hidden" class="image-name" value="<?=$uploaded_image->name?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; //endif uploaded images ?>

                            <?php if(isset($attachments->attached_link)):                     
                                $attached_video     = ($attachments->attached_link->video=='yes') ? true : false;
                                $attached_url       = Helpers::secure_link($attachments->attached_link->url);
                                $attached_image     = Helpers::secure_link($attachments->attached_link->image);
                                $attachment_title   = $attachments->attached_link->title;
                                $attachment_desc    = $attachments->attached_link->description;
                                $attachment_desc    = ($attachment_desc == substr($attachment_desc, 0, 80) ? $attachment_desc : substr($attachment_desc, 0, 80) . '...');
                            ?>
                            <div class="uploaded-link">
                                <div class="padded-5">
                                    <div class="form-video-meta">
                                        <?php if($attached_video): ?>
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
                                            <h3><?= HTML::entities($attachment_title); ?></h3>
                                            <p><?= HTML::entities($attachment_desc); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; //endif attached link ?>
                            </div>
                        <?php endif; //endif attachments ?>
                            <!-- end of additional info block
                            <div class="admin-comment-block">
                                <div class="admin-comment-box">
                                    <div class="admin-comment-textbox-container">
                                        <textarea class="admin-comment-textbox"></textarea>
                                    </div>
                                    <div class="admin-comment-leave-a-reply">
                                        <span class="admin-logged-session">Logged in as <a href="#">Chris Davidson</a></span><input type="button" class="regular-button" value="Post Comment" />
                                    </div>
                                </div>
                                <!--
                                <div class="admin-comment">
                                    <div class="admin-name">Amy from Acme Inc says..</div>
                                    <div class="admin-message clear">
                                        <div class="admin-avatar"><img src="fullpage/common/img/samchloe.png" width="32" height="32" /></div>
                                        <div class="message">Great choice!</div>
                                    </div>
                                </div>
                                -->
                        </div>
                    </div>
                    <!-- end of feedback text bubble -->
                    <!-- feedback user actions -->
                    <div class="feedback-options clear">
                        <div class="feedback-recommendation">
                            <?php if( $is_recommended ): ?>
                                <div class="green-thumb">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
                            <?php endif; ?>
                        </div>
                        <div class="feedback-vote">
                            <span class="vote-action <?= ($voted != 1 ? '' : 'hidden'); ?>">
                                Was this useful? <a href="#" class="small-btn-pin">Yes</a>
                            </span>
                        </div>
                        <div class="feedback-actions clear">
                            <span class="flag-as"><?=(!$flagged) ? 'Flag as inappropriate' : 'Undo flag' ?></span>
                            <span class="share-button">
                                Share
                            </span>
                            <div class="single_page_link"><a href="/single/<?=$feedback_id;?>">...</a></div>
                        </div>    
                    </div>
                    <!-- end of feedback user actions -->
                </div>
            <?php endif; ?>
        
        <?php endforeach; //endforeach feed_list ?>
    </div>
    <?php endforeach; //endforeach collection ?>
</div>
<?php endif; //endif collection ?>
