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
            $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
            $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
            $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
            $author_name                = $feed->feed_data->firstname.' '.$feed->feed_data->lastname;
            $author_company             = $feed->feed_data->position.', '.$feed->feed_data->companyname;
            $author_location            = $feed->feed_data->city.', '.$feed->feed_data->countryname;
            $text                       = $feed->feed_data->text;
            $attachments                = (!empty($feed->feed_data->attachments)) ? json_decode($feed->feed_data->attachments) : false;
        ?>
        <div class="feedback <?=$feedback_main_class?>">
            <?=$tw_marker?>
            <div class="<?=$feedback_content_class?>">
                <!-- feedback header -->
                <div class="feedback-header clear">
                    <div class="author">
                        <div class="author-avatar"><img src="<?=$feed->feed_data->avatar?>" width="48" height="48" /></div>   
                        <div class="author-information">
                            <div class="author-name clear"><?=$author_name?></div>
                            <div class="author-company"><?=$author_company?></div>
                            <div class="author-location-info clear">
                                <div class="author-location"><?=$author_location?></div><div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                            </div>
                            <div class="custom-meta-data clear">
                                <!--
                                <div class="meta-data"><span class="meta-name">Product Purchased : </span><span class="meta-value"> Spaghetti Bolognese</span></div>
                                <div class="meta-data"><span class="meta-name">Quality : </span><span class="meta-value"> Excellent</span></div>
                                -->
                            </div>
                        </div>  
                    </div>
                    <div class="reviews clear">
                        <div class="ratings">
                            <div class="feedback-timestamp">Posted 3 hours ago</div>
                            <div class="stars blue clear">
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star full"></div>
                                <div class="star half"></div>    
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of feedback header -->
                <!-- feedback text bubble -->
                <div class="feedback-text-bubble">
                    <div class="feedback-tail"></div>
                    <div class="rating-stat">87 of 98 people found this useful</div>
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
                                    <img src="<?=$uploaded_image->small_url?>" width="100%" />
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($attachments->attached_link)): ?>
                        <!-- a video -->
                        <?php /*
                        <div class="uploaded-video">
                            <div class="padded-5">
                                <iframe width="293" height="220" src="" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        */ ?>
                        <!-- or just a preview link? -->
                        <div class="uploaded-link">
                            <div class="padded-5">
                                <div class="form-video-meta">
                                    <div class="video-thumb">
                                        <img src="<?=$attachments->attached_link->image?>" width="100%">
                                    </div>
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
                <?php if(isset($user) && !empty($user)): ?>
                <div class="admin-comment-block">
                    <?php if(empty($feed->feed_data->adminreply)): ?>
                        <div class="admin-comment-box">
                        <input type="hidden" class="admin-comment-id" value="<?=$feed->feed_data->id?>">
                        <div class="admin-comment-textbox-container">
                            <textarea class="admin-comment-textbox"></textarea>
                            </div>
                            <div class="admin-comment-leave-a-reply">
                            <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span>
                            <input type="button" class="adminReply regular-button" value="Post Comment" />
                            </div>
                        </div>
                        <div class="admin-comment" style="display:none">
                            <div class="admin-name"><?=$user->fullname?> from <?=$user->fullpagecompanyname?> says..</div>
                            <div class="admin-message clear">
                                <div class="admin-avatar"><img src="<?=$user->avatar?>" width="32" height="32" /></div>
                                <div class="message"><?=$feed->feed_data->adminreply?></div>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="admin-comment">
                            <div class="admin-name"><?=$user->fullname?> from <?=$user->fullpagecompanyname?> says..</div>
                            <div class="admin-message clear">
                                <div class="admin-avatar"><img src="<?=$user->avatar?>" width="32" height="32" /></div>
                                <div class="message"><?=$feed->feed_data->adminreply?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
                </div>
                <!-- end of feedback text bubble -->
                <!-- feedback user actions -->
                <div class="feedback-options clear">
                    <div class="feedback-recommendation">
                        <div class="green-thumb">Recommended by Leica to friends</div>
                        <div class="vote-block">
                            <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a> <a href="#" class="small-btn-pin">No</a></span>
                        </div>
                    </div>
                    <div class="feedback-actions clear">
                        <span class="flag-as">Flag as inappropriate</span>
                        <span class="share-button">Share</span>
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
