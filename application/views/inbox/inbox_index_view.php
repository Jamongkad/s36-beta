<div id="theInbox">
    <div id="theInboxSorter">
        <div class="grids">
            <div class="sorter-block sorter-checkbox">
                <div class="sorter-block-box"><input type="checkbox" /></div>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Selected</span>
                <span class="sorter-block-box"><select><option>-</option><option>Publish</option></select></span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Date</span>
                <span class="sorter-block-box"><select><option>-</option><option>Newest</option></select></span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Priority</span>
                <span class="sorter-block-box"><select><option>-</option><option>Low</option></select></span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Status</span>
                <span class="sorter-block-box"><select><option>-</option><option>In Progress</option></select></span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Rating</span>
                <span class="sorter-block-box"><select><option>-</option><option>5</option></select></span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Display</span>
                <span class="sorter-block-box"><select><option>-</option><option>10</option></select></span>
            </div>
        </div>
    </div>

    <div id="theInboxFeeds">
        <?foreach($feedback as $feeds):?>
            <div class="feedback-group">
                <div class="feedback-date-header">
                    <strong><?=date("jS F, l Y", $feeds->unix_timestamp)?> (<?=$feeds->daysago?>)</strong>
                </div>
                <?php foreach($feeds->children as $feed):?>
                    <div class="dashboard-feedback grids">
                        <div class="custom-checkbox"><input type="checkbox" /></div>
                        <div class="feedback-avatar">
                            <?if($feed->origin == 's36'):?>
                                <?if($feed->avatar):?>
                                    <?=HTML::image('uploaded_images/avatar/small/'.$feed->avatar, false, array('class' => 'small-avatar'))?>
                                <?else:?>
                                    <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                                <?endif?>
                            <?endif?>

                            <?if($feed->origin == 'tw'):?>
                                <img src="<?=$feed->avatar?>" />
                            <?endif?>
                        </div>
                        <div class="feedback-contents">
                            <div class="responsive-padding">
                                <div class="feedback-title"><?=$feed->title?></div>
                                <div class="feedback-text">
                                    <?=$feed->text?>
                                    <?=($feed->origin == 'tw') ? ' via '.'<a style="color:#567aa7" href="'.$feed->profilelink.'/status/'.$feed->socialid.'">Twitter</a>': null?>
                                </div>
                                <div class="feedback-author">
                                    <span class="feedback-author-name"><?=$feed->firstname?> <?=$feed->lastname?></span>
                                    <span class="feedback-author-location"> 
                                        <?if($feed->origin == 's36'):?>
                                            <?if($feed->rating != "POOR"):?>
                                               <span><?=$feed->countryname?>, <?=$feed->countrycode?></span>
                                            <?endif?>
                                        <?endif?>
                                    </span>
                                    <span class="splitter">|</span>
                                    <? $date = $feed->date; $unix = strtotime($date); ?>
                                    <span class="feedback-author-date"><?=date('F j, Y', $unix);?></span>
                                    <span class="feedback-author-time"><?=date('h:i:m a', $unix);?></span>
                                    <span class="feedback-author-src"> 
                                        <?if($feed->logintype == 'fb'):?>
                                            <span class="author-social fb">
                                                <a <?=(($feed->profilelink) ? "href='{$feed->profilelink}' target=_" : "href='#'")?>>
                                                    <?=HTML::image('img/small-fb-icon.png')?>
                                                    Facebook Verified
                                                </a>
                                            </span>
                                        <?endif?>

                                        <?if($feed->logintype == 'ln'):?>
                                            <span class="author-social in">
                                                <a <?=(($feed->profilelink) ? "href='{$feed->profilelink}' target=_" : "href='#'")?>>
                                                    <?=HTML::image('img/small-in-icon.png')?>
                                                    LinkedIn Verified
                                                </a>
                                            </span>
                                        <?endif?>
                                    </span>
                                </div>
                                <?
                                $metadata = (!empty($feed->metadata)) ? $feed->metadata : false;
                                $attachments = (!empty($feed->attachments)) ? $feed->attachments : false;
                                $reports = (!empty($feed->reports)) ? $feed->reports : false;
                                ?>
                                <?if($metadata || $attachments || $reports):?>
                                <div class="feedback-custom-block">
                                    <?if($metadata):?>
                                        <div class="feedback-custom-metas grids">
                                            <?foreach($metadata as $key => $val):?>
                                                <?foreach($val as $k => $v):?>
                                                    <div class="feedback-custom-meta">
                                                        <?if($key == 'select'):?>
                                                            <span class="custom-meta-name"><?=ucwords($k)?>:</span>
                                                        <?endif?>
                                                        <?if($key == 'checkbox' || $key == 'radio' || $key == 'text'):?>
                                                            <span class="custom-meta-name"><?=ucwords(str_replace("_", " ", $k));?>:</span>
                                                        <?endif?>
                                                        <?
                                                        $prefix = "";
                                                        $value_list = "";
                                                        foreach($v as $d) {
                                                            $value_list .= "<span class='custom-meta-value'>" . $prefix . $d->value . "</span>";
                                                            $prefix = ", ";
                                                        }
                                                        echo $value_list;
                                                        ?>
                                                    </div>
                                                <?endforeach?>
                                            <?endforeach?>
                                        </div>
                                    <?endif?>
                                    <?if($attachments):?>
                                        <div class="feedback-custom-attachments">
                                            <input type="hidden" class="attachment_feedback_id" value="<?=$feed->id?>"/>
                                            <?php 
                                            /*
                                            | Start Video and Web Link Attachment
                                            */
                                            if(isset($attachments->attached_link)):
                                            ?>
                                            <div class="image-block attached_link" style="width:100%;margin-bottom:15px">
                                                <input type="hidden" class="link-title" value="<?=$attachments->attached_link->title?>"/>
                                                <input type="hidden" class="link-description" value="<?=$attachments->attached_link->description?>"/>
                                                <input type="hidden" class="link-image" value="<?=$attachments->attached_link->image?>"/>
                                                <input type="hidden" class="link-url" value="<?=$attachments->attached_link->url?>"/>
                                                <input type="hidden" class="link-video" value="<?=$attachments->attached_link->video?>"/>
                                                <div class="delete-block">x</div>
                                                    <?php 
                                                    //video attachments
                                                    if($attachments->attached_link->video=='yes'){?>
                                                        <a class="inbox-fancybox-video" 
                                                           href="<?=str_replace('http','https',$attachments->attached_link->url)?>" 
                                                           rel="inbox-videos-<?=$id?>" 
                                                           style="display:block">
                                                            <div class="video-circle"></div>
                                                            <div class="the-thumb">
                                                                <img src="<?=$attachments->attached_link->image?>" width="100%" />
                                                            </div>
                                                        </a>
                                                    <?php
                                                    } else {
                                                    //web link
                                                    ?>
                                                        <div class="attached-link-thumb">
                                                            <a href="<?=$attachments->attached_link->url?>" target="_blank">
                                                                <img src="<?=$attachments->attached_link->image?>" width="100%" />
                                                            </a>
                                                        </div>
                                                        <div class="attached-link-details">
                                                            <h3><?=$attachments->attached_link->title?></h3>
                                                            <p style="font-size:10px"><?=$attachments->attached_link->description?></p>
                                                        </div>   
                                                    <?php } ?>
                                            </div>
                                            <br/>
                                            <?php 
                                            /*
                                            | End Video and Web Link Attachment
                                            */
                                            endif;
                                            /*
                                            | Start Image Attachments
                                            */
                                            if(isset($attachments->uploaded_images)):
                                            ?>
                                            <?php
                                                if(count($attachments->uploaded_images) == 1) $width='';
                                                if(count($attachments->uploaded_images) == 2) $width='g1of2';
                                                if(count($attachments->uploaded_images) == 3) $width='g1of3';
                                                ?>
                                                <div class="feedback-custom-attachments">
                                                    <div class="feedback-custom-att-container">
                                                        <div class="grids">
                                                            <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                                                                <div class="custom-att <?=$width;?>">
                                                                    <div class="delete-block">x</div>
                                                                    <div class="the-thumb">
                                                                        <a class="inbox-fancybox-image" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="inbox-images-<?=$id?>">

                                                                        <?if(count($attachments->uploaded_images) == 1):?>
                                                                            <img src="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" width="100%" />
                                                                        <?else:?>
                                                                            <img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>" width="100%" />
                                                                        <?endif?>

                                                                        </a>
                                                                        <input type="hidden" class="image-name" value="<?=$uploaded_image->name?>"/>
                                                                        <input type="hidden" class="small-image-url" value="<?=Config::get('application.attachments_small').'/'.$uploaded_image->name?>"/>
                                                                        <input type="hidden" class="medium-image-url" value="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>"/>
                                                                        <input type="hidden" class="large-image-url" value="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>"/>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            /*
                                            | End Image Attachments
                                            */
                                            endif;
                                            ?>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <?if($reports):?>
                                        <div style="color:#6499CD; font-size:11px; font-weight:bold">Feedback has been flagged:</div>
                                        <div class="custom-meta-list grids">
                                            <?foreach($reports as $report):?>
                                                <div style="color: #a2a2a2; font-weight: normal">
                                                    <?=$report['reporttype'];?>: <?=$report['reportcount']?>
                                                </div>
                                            <?endforeach?>
                                        </div>
                                    <?endif?>
                                    <!--
                                    <div class="feedback-custom-attachments">
                                        <div class="feedback-custom-att-container">
                                            <div class="grids">
                                                <div class="custom-att">
                                                    <img src="/fullpage/admin/img/budoc.jpg" width="100%"/>
                                                </div>
                                                <div class="custom-att g1of3">
                                                    <img src="/fullpage/admin/img/gels.jpg" width="100%"/>
                                                </div>
                                                <div class="custom-att g1of3">
                                                    <img src="/fullpage/admin/img/yassi.jpg" width="100%"/>
                                                </div>
                                                <div class="custom-att g1of3">
                                                    <img src="/fullpage/admin/img/jasmin.jpg" width="100%"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                </div>
                                <?endif?>
                                <div class="feedback-details">
                                    <span class="feedback-details-rating <?=strtolower($feed->rating)?>">
                                        <?=$feed->rating?>
                                    </span>
                                    <span class="feedback-details-privacy"><?=$feed->permission?></span>
                                    <span class="feedback-details-status">
                                        Status : <small><?=$feed->status?></small>
                                    </span>
                                    <span class="feedback-details-status">
                                        Priority : <small><?=ucfirst($feed->priority)?></small>
                                    </span>
                                    <span class="feedback-details-modify">
                                        <?=HTML::link('/feedback/modifyfeedback/'.$feed->id, 'Modify Additional Info')?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-feedback-actions grids" params='<?=json_encode($feed)?>'>
                            <div class="feedback-action-menu" ng-controller="FeedbackControl">
                                <div class="grids">
                                    <div class="action-sprite action-delete"></div>
                                    <div class="action-delete-tooltip"></div>
                                </div>
                                <div class="action-gap"></div>
                                <div class="grids">
                                    <!--beginning of feedback controls -->
                                    <ul class="action-gray-menu">
                                        <li class="action-sprite publish">
                                            <div class="action-tooltip">
                                                <span>Publish Feedback</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                        </li>
                                        <li class="action-sprite feature">
                                            <div class="action-tooltip">
                                                <span>Feature Feedback</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                        </li>
                                        <li class="action-sprite reply">
                                            <div class="action-tooltip">
                                                <span>Reply to User</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                        </li>
                                        <li class="action-sprite contact">
                                            <div class="action-tooltip">
                                                <span>Fast Forward</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                        </li>
                                        <li class="action-sprite save">
                                            <div class="action-tooltip">
                                                <span>Categorize Feedback</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                            <div class="the-categories-menu">
                                                <div class="the-category-arrow"></div>
                                                <div class="the-categories-menu-content">
                                                    <div class="the-categories">
                                                        <h3>File this feedback as : </h3>
                                                        <ul class="grids">
                                                            <li><a href="#">General</a></li>
                                                            <li><a href="#">Miscelleanous</a></li>
                                                            <li><a href="#">Price</a></li>
                                                            <li><a href="#">Problems/Bugs</a></li>
                                                            <li><a href="#">Suggestions</a></li>
                                                        </ul>
                                                        <a class="manage-categories-link" href="#">Manage Categories</a>
                                                    </div>
                                                    <div class="false-border"></div>
                                                    <div class="the-categories-options">
                                                        <div class="categories-combo">
                                                            <span class="category-combo-name">Status </span><span><select><option>New</option></select></span>
                                                        </div>
                                                        <div class="categories-combo">
                                                            <span class="category-combo-name">Priority </span><span><select><option>New</option></select></span>
                                                        </div>
                                                    </div>
                                                    <div class="false-border"></div>
                                                    <div class="the-categories-delete">
                                                        <a href="#" class="delete-button"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action-sprite flag-action">
                                            <div class="action-tooltip">
                                                <span>Flag Feedback</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!--end of feedback controls -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?endforeach?>
        <!--
        <div class="dashboard-feedback grids">
            <div class="custom-checkbox"><input type="checkbox" /></div>
            <div class="feedback-avatar"><img src="/fullpage/admin/img/sample-inbox-image2.jpg" width="100%" /></div>
            <div class="feedback-contents">
                <div class="responsive-padding">
                    <div class="feedback-title">Stay fit and healthy. This is so cool! </div>
                    <div class="feedback-text"><p>I've been to a few gyms before and I can confidently say that The Fitness Center 
stands tall among others. It has a wide range of fitness equipment; from free 
weights to machines, gym balls to thread mills, and skipping ropes to exercise 
mats. Staff are friendly and accommodating, too. It was a fun experience and 
I'd be looking forward to my next visit. </p><p>I've been to a few gyms before and I can confidently say that The Fitness Center 
stands tall among others. It has a wide range of fitness equipment; from free 
weights to machines, gym balls to thread mills, and skipping ropes to exercise 
mats. Staff are friendly and accommodating, too. It was a fun experience and 
I'd be looking forward to my next visit. </p><p>I've been to a few gyms before and I can confidently say that The Fitness Center 
stands tall among others. It has a wide range of fitness equipment; from free 
weights to machines, gym balls to thread mills, and skipping ropes to exercise 
mats. Staff are friendly and accommodating, too. It was a fun experience and 
I'd be looking forward to my next visit. </p><p>I've been to a few gyms before and I can confidently say that The Fitness Center 
stands tall among others. It has a wide range of fitness equipment; from free 
weights to machines, gym balls to thread mills, and skipping ropes to exercise 
mats. Staff are friendly and accommodating, too. It was a fun experience and 
I'd be looking forward to my next visit. </p></div>
                    <div class="feedback-author">
                        <span class="feedback-author-name">Kc Cayamanda</span>
                        <span class="feedback-author-location">Philippines, PH</span>
                        <span class="splitter">|</span>
                        <span class="feedback-author-date">March 29, 2013</span>
                        <span class="feedback-author-time">04:31:03 pm</span>
                        <span class="feedback-author-src">Facebook Verified</span>
                    </div>
                    
                    <div class="feedback-details">
                        <span class="feedback-details-rating good">
                            GOOD
                        </span>
                        <span class="feedback-details-privacy">PRIVATE</span>
                        <span class="feedback-details-status">
                            Status : <small>New</small>
                        </span>
                        <span class="feedback-details-status">
                            Priority : <small>High</small>
                        </span>
                        <span class="feedback-details-modify"><a href="#">Modify Additional Info</a></span>
                    </div>
                </div>
            </div>
            <div class="dashboard-feedback-actions grids">
                <div class="feedback-action-menu">
                    <div class="grids">
                        <div class="action-sprite action-delete"></div>
                        <div class="action-delete-tooltip"></div>
                    </div>
                    <div class="action-gap"></div>
                    <div class="grids">
                        <ul class="action-gray-menu">
                            <li class="action-sprite publish"></li>
                            <li class="action-sprite feature"></li>
                            <li class="action-sprite reply"></li>
                            <li class="action-sprite contact"></li>
                            <li class="action-sprite save"></li>
                            <li class="action-sprite flag-action"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="c"></div> 
        <?if($pagination):?>
            <div style="padding:10px 2px 30px">
                <?=$pagination?>
            </div>
        <?endif?>
    </div>
</div>
