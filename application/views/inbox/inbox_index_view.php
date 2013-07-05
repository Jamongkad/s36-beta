<script>
//admittedly a much clean|insane means of seperating serverside variables.
//acts as global data object to be access by angularjs objects
var backend_vars = {
    current_inbox_state: "<?=$inbox_state?>"
  , default_category_id: "<?=$admin_check->categoryid?>"
}
</script>

<div class="checky-box-container" ng-controller="CheckyBox" style="display:none">
    <div class="j-j5-ji">
        <div class="checky-bar">
            <span ng-switch on="status_selection"> 
                <span ng-switch-when="feature">
                    Feedback has been featured on your page. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="publish">
                    Feedback has been published on your page. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="fileas">
                    Feedback has been filed.
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="delete">
                    Feedback has been deleted. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="restore">
                    Feedback has been restored. 
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="remove">
                    Feedback has been permanently removed. 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
                <span ng-switch-when="inbox">
                    Feedback has been returned to the inbox.
                    <a undo class="undo" href="#" ng-click="undo()">undo</a> 
                    <a close class="close-checky" href="#" ng-click="close()">close</a>
                </span> 
            </span>
        </div>
    </div>
</div>

<div id="theInbox" ng-controller="FeedbackControl" >
    <div id="theInboxSorter">
        <div class="grids">
            <div class="sorter-block sorter-checkbox">
                <div class="sorter-block-box">
                    <input class="sorter-checkbox" type="checkbox" ng-click="select_all($event)"/>
                </div>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Selected</span>
                <span class="sorter-block-box">
                    <?//show this when looking at inbox except when in deleted
                    if(!preg_match('~inbox/deleted/all~', Request::uri(), $matches)):?>

                        <?
                         $links = Array(
                             'none' => '-'
                           , 'publish' => 'Publish'
                           , 'feature' => 'Feature'
                           , 'delete' => 'Delete'
                         );

                         if(preg_match_all('~inbox/published~', Request::uri(), $matches)) {
                             unset($links['publish']);     
                             unset($links['feature']);     
                         }

                         echo Form::select('feed_selection', $links, 'none', Array('ng-model' => 'status_select_value', 'ng-change' => 'change_value_status()'));?> 
                    <?else:?>
                        <?=Form::select('feed_selection', Array(
                            'none' => '-'
                          , 'restore' => 'Restore'
                          , 'remove' => 'Permanently Delete'
                         ), 'none', Array('ng-model' => 'status_select_value', 'ng-change' => 'change_value_status()'));?>
                    <?endif?>
                </span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Date</span>
                <span class="sorter-block-box">
                    <select ng-model="date_filter" ng-change="filter('date')">
                        <option value="none">-</option>
                        <option value="date_new">Newest</option>
                        <option value="date_old">Oldest</option>
                    </select>
                </span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Priority</span>
                <span class="sorter-block-box">
                    <select ng-model="priority_filter" ng-change="filter('priority')">
                        <option value="none">-</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Status</span>
                <span class="sorter-block-box">
                    <select ng-model="status_filter" ng-change="filter('status')">
                        <option value="none">-</option>
                        <option value="new">New</option>
                        <option value="inprogress">In progress</option>
                        <option value="closed">Closed</option>
                    </select> 
                </span>
            </div>
            <div class="sorter-block">
                <span class="sorter-block-name">Rating</span>
                <span class="sorter-block-box"> 
                    <select ng-model="rating_filter" ng-change="filter('rating')">
                        <option value="none">-</option>
                        <?foreach(array_reverse(range(1, 5)) as $rating):?>
                            <option value="<?=$rating?>"><?=$rating?></option>
                        <?endforeach?> 
                    </select>
                </span>
            </div>
        </div>
    </div>
    
<?if($feedback != null):?>
    <div id="theInboxFeeds">
        <?foreach($feedback as $feeds):?>
            <div class="feedback-group">
                <div class="feedback-date-header">
                    <strong><?=date("jS F, l Y", $feeds->unix_timestamp)?> (<?=$feeds->daysago?>)</strong>
                </div>
                <?php foreach($feeds->children as $feed):?>
                    <div class="dialog-form" feedid="<?=$feed->id?>">
                        <?=View::make('feedback/reply_to_view', array('user' => $admin_check, 'feedback'=> $feed, 'reply_message' => $reply_message))?>
                    </div>
                    <div class="dashboard-feedback grids" <?=($feed->isfeatured) ? 'style="background-color: #FFFFE0"' : null?> 
                         feedback="<?=$feed->id?>" 
                         score="<?=$feed->int_rating?>"
                         permission="<?=$feed->int_perm?>"
                         catid="<?=$feed->categoryid?>">
                        <div class="custom-checkbox">
                            <input 
                             class="feed-checkbox" 
                             type="checkbox" 
                             value="<?=$feed->id?>" 
                             ng-click="update_selection($event, <?=$feed->id?>)"
                             feedcheckbox 
                             />
                        </div>
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
                                        <div class="feedback-custom-attachments uploaded-images-and-links">
                                            <input type="hidden" class="attachment_feedback_id" value="<?=$feed->id?>"/>
                                            <?php 
                                            /*
                                            | Start Video and Web Link Attachment
                                            */
                                            if(isset($attachments->attached_link)):
                                            ?>
                                            <div class="image-block attached_link custom-att" style="width:100%;margin-bottom:15px">
                                                <input type="hidden" class="link-title" value="<?=$attachments->attached_link->title?>"/>
                                                <input type="hidden" class="link-description" value="<?=$attachments->attached_link->description?>"/>
                                                <input type="hidden" class="link-image" value="<?=$attachments->attached_link->image?>"/>
                                                <input type="hidden" class="link-url" value="<?=$attachments->attached_link->url?>"/>
                                                <input type="hidden" class="link-video" value="<?=$attachments->attached_link->video?>"/>
                                                <div class="delete-block" delete-block>x</div>
                                                    <?php 
                                                    //video attachments
                                                    if($attachments->attached_link->video=='yes'){?>
                                                        <a class="inbox-fancybox-video" 
                                                           href="<?=str_replace('http','https',$attachments->attached_link->url)?>" 
                                                           rel="inbox-videos-<?=$feed->id?>" 
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
                                                                <div class="custom-att uploaded_image <?=$width;?>">
                                                                    <div class="delete-block" delete-block>x</div>
                                                                    <div class="the-thumb">
                                                                        <a class="inbox-fancybox-image" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="inbox-images-<?=$feed->id?>">

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
                                    <?if($feed->intname != "default"):?>
                                        <span class="feedback-details-status">Filed As: </span><span class="feedback-details-rating filed"><?=$feed->intname?></span>
                                    <?endif?>
                                    <span class="feedback-details-modify">
                                        <?=HTML::link('/feedback/modifyfeedback/'.$feed->id, 'Modify Additional Info')?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-feedback-actions grids">
                            <div class="feedback-action-menu">
                                <div class="grids">
                                    <div class="action-sprite action-delete" transform 
                                         ng-click="feedback_status($event)"
                                         data-feed='{"id": "<?=$feed->id?>", "catid": "<?=$feed->categoryid?>"
                                                   , "status": <?=($feed->isdeleted == 1) ? '"remove"' : '"delete"'?>}'
                                         ></div>
                                    <div class="action-delete-tooltip <?=($feed->isdeleted == 1) ? "permanent-tooltip" : null?>"></div>
                                </div>
                                <div class="action-gap"></div>
                                <div class="grids">
                                    <!--beginning of feedback controls -->
                                    <ul class="action-gray-menu">
                                        <?if($feed->rating != "POOR" and $feed->permission_css != 'private-permission'):?>
                                            <?if($admin_check->inbox_approve == 0) :?>
                                                <li class="action-sprite publish">
                                                    <div class="action-tooltip">
                                                        <span>Disabled</span>
                                                        <div class="action-tooltip-arrow"></div>
                                                    </div>
                                                </li>
                                            <?else:?>
                                                <li class="action-sprite publish" transform 
                                                    ng-click="feedback_status($event)" publish
                                                    data-feed='{  "id": "<?=$feed->id?>", "catid": "<?=$feed->categoryid?>"
                                                                , "status": <?=($feed->ispublished) ? '"inbox"' : '"publish"'?>
                                                                , "origin": <?=($feed->ispublished) ? '"publish"' : '"inbox"'?>}'
                                                    <?=($feed->ispublished) ? "style='background-position: -32px -31px'" : null?> 
                                                    <?=($feed->ispublished) ? "return-policy=1" : "return-policy=0"?> 
                                                    > 
                                                    <div class="action-tooltip">
                                                        <span>
                                                            <?if($feed->ispublished):?>
                                                                Return to Inbox
                                                            <?else:?>
                                                                Publish Feedback 
                                                            <?endif?>
                                                        </span>
                                                        <div class="action-tooltip-arrow"></div>
                                                    </div>
                                                </li>
                                            <?endif?>
                                        <?else:?>
                                            <li class="action-sprite publish">
                                                <div class="action-tooltip">
                                                    <span>This feedback cannot be published.</span>
                                                    <div class="action-tooltip-arrow"></div>
                                                </div>
                                            </li>
                                        <?endif?>

                                        <?if($feed->rating != "POOR" and $feed->permission_css != 'private-permission'):?>
                                            <?if($admin_check->inbox_feature == 0) :?>
                                                <li class="action-sprite feature">
                                                    <div class="action-tooltip">
                                                        <span>Disabled</span>
                                                        <div class="action-tooltip-arrow"></div>
                                                    </div>
                                                </li>
                                            <?else:?>
                                                <li class="action-sprite feature" transform 
                                                    ng-click="feedback_status($event)" feature
                                                    data-feed='{  "id": "<?=$feed->id?>", "catid": "<?=$feed->categoryid?>"
                                                                , "status": <?=($feed->isfeatured) ? '"inbox"' : '"feature"'?>
                                                                , "origin": <?=($feed->isfeatured) ? '"feature"' : '"inbox"'?>}'
                                                    <?=($feed->isfeatured) ? "style='background-position: -64px -31px'" : null?>
                                                    <?=($feed->isfeatured) ? "return-policy=1" : "return-policy=0"?> 
                                                    >
                                                    <div class="action-tooltip">
                                                        <span>
                                                            <?if($feed->isfeatured):?>
                                                                Return to Inbox
                                                            <?else:?>
                                                                Feature Feedback
                                                            <?endif?>
                                                        </span>
                                                        <div class="action-tooltip-arrow"></div>
                                                    </div>
                                                </li>
                                            <?endif?>
                                        <?else:?>
                                            <li class="action-sprite feature">
                                                <div class="action-tooltip">
                                                    <span>This feedback cannot be featured.</span>
                                                    <div class="action-tooltip-arrow"></div>
                                                </div>
                                            </li>
                                        <?endif?>
                                        
                                        <?if($feed->email):?>
                                            <li class="action-sprite reply" feedid="<?=$feed->id?>" my-reply>
                                                <div class="action-tooltip">
                                                    <span>Reply to User</span>
                                                    <div class="action-tooltip-arrow"></div>
                                                </div>
                                            </li>
                                        <?else:?>
                                            <li class="action-sprite reply">
                                                <div class="action-tooltip">
                                                    <span>No email available</span>
                                                    <div class="action-tooltip-arrow"></div>
                                                </div>
                                            </li>
                                        <?endif?>

                                        <li class="action-sprite contact">
                                            <div class="action-tooltip">
                                                <span>Fast Forward</span>
                                                <div class="action-tooltip-arrow"></div>
                                            </div>
                                            <?if($admin_check->ffemail1 || $admin_check->ffemail2 || $admin_check->ffemail3):?>
                                                <div class="the-categories-menu">
                                                    <div class="the-category-arrow"></div>
                                                    <div class="the-categories-menu-content">
                                                        <div class="the-categories small-text">
                                                           <ul class="grids block-style">
                                                               <?if($admin_check->ffemail1):?>
                                                                    <li id="email1">
                                                                        <span>
                                                                            <a ng-click="fast_forward('<?=$admin_check->ffemail1?>', <?=$feed->id?>)">
                                                                                <?=$admin_check->ffemail1?>
                                                                            </a>
                                                                        </span>
                                                                    </li>
                                                               <?endif?>
                                                               <?if($admin_check->ffemail2):?>
                                                                    <li id="email1">
                                                                        <span>
                                                                            <a ng-click="fast_forward('<?=$admin_check->ffemail2?>', <?=$feed->id?>)">
                                                                                <?=$admin_check->ffemail2?>
                                                                            </a>     
                                                                        </span>
                                                                    </li>
                                                               <?endif?>
                                                               <?if($admin_check->ffemail3):?>
                                                                    <li id="email1">
                                                                        <span>
                                                                           <a ng-click="fast_forward('<?=$admin_check->ffemail3?>', <?=$feed->id?>)">
                                                                              <?=$admin_check->ffemail3?>
                                                                           </a>
                                                                        </span>
                                                                    </li>
                                                               <?endif?> 
                                                           </ul>
                                                            <p><a class="manage-categories-link" href="/settings">Configure Fast Forward Settings</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?else:?>
                                                <div class="the-categories-menu">
                                                    <div class="the-category-arrow"></div>
                                                    <p><a class="manage-categories-link" href="/settings">Configure Fast Forward Settings</a></p>
                                                </div>
                                            <?endif?>

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
                                                            <?foreach($categories as $cat):?>
                                                                <li>
                                                                    <a href="#" 
                                                                       class="cat-picks"
                                                                       <?=(($feed->category === $cat->name) ? ' style="background: #cd5555"' : Null)?>
                                                                       category-pick
                                                                       transform
                                                                       ng-click="feedback_status($event)"                                                                       
                                                                       data-feed='{"id": "<?=$feed->id?>"
                                                                                , "catid": "<?=$cat->id?>"
                                                                                , "status": "fileas"
                                                                                <?if($inbox_state == "publish") {
                                                                                    echo ($feed->isfeatured) ? ', "origin": "feature"' : ', "origin": "publish"';
                                                                                } 
                                                                                ?>
                                                                               }'>
                                                                        <?=$cat->name?>
                                                                    </a>
                                                                </li>
                                                            <?endforeach?>
                                                        </ul>
                                                        <a class="manage-categories-link" href="/settings">Manage Categories</a>
                                                    </div>
                                                    <div class="false-border"></div>
                                                    <div class="the-categories-options">
                                                        <div class="categories-combo">
                                                            <span class="category-combo-name">Status </span>
                                                            <span>
                                                                <select statuschange feedid="<?=$feed->id?>">
                                                                    <?foreach($status as $option):?>
                                                                        <?$option_match = str_replace(" ", "", strtolower($option->name));?>
                                                                        <option <?=($feed->status == $option->name) ? 'selected' : null?> value="<?=$option_match?>">
                                                                            <?=$option->name?>
                                                                        </option>
                                                                    <?endforeach?>
                                                                </select> 
                                                            </span>
                                                        </div>
                                                        <div class="categories-combo">
                                                            <span class="category-combo-name">Priority </span>
                                                            <span>
                                                                <select prioritychange feedid="<?=$feed->id?>">
                                                                    <?foreach($priority_obj as $key => $val):?>
                                                                        <option <?=($feed->priority == $val) ? 'selected' : null?>  value="<?=$key?>">
                                                                            <?=ucfirst($val)?>
                                                                        </option>
                                                                    <?endforeach?>
                                                                </select> 
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="false-border"></div>
                                                    <div class="the-categories-delete">
                                                        <a href="#" class="delete-button" transform 
                                                           ng-click="feedback_status($event)"
                                                           data-feed='{"id": "<?=$feed->id?>", "catid": "<?=$feed->categoryid?>", "status": "delete"}'
                                                        ></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="action-sprite flag-action" 
                                            ng-click="flag_feedback($event)" flag
                                            data-feed='{"id": "<?=$feed->id?>", "catid": "<?=$feed->categoryid?>", "status": "flag"}' 
                                            <?=($feed->isflagged) ? "style='background-position: -194px -31px'" : null?> 
                                            <?=($feed->isflagged) ? "return-policy=1" : "return-policy=0"?>>
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
        <div class="c"></div> 
        <?if($pagination):?>
            <div style="padding:10px 2px 30px">
                <?=$pagination?>
            </div>
        <?endif?>
    </div>
<?else:?>
    <div class="woops">
        <h2 class="woops-header">Woops. There is no feedback here.</h2>
        <?if(!$feedback_present):?>
        <br/><br/>
            <p class="woops-content">
                <?if($filter == 'all'):?>
                    Have you <?=HTML::link('feedsetup', 'set up your feedback form', Array('class' => 'woops-a'))?>
                    on your website already?
                <?else:?>
                    Looks like you haven’t <?=$filter?> any feedback from your <?=HTML::link('inbox/all', 'inbox', Array('class' => 'woops-a'))?> yet.. <br/>either that,
                    have you set up your <?=HTML::link('feedsetup' , 'feedback form', Array('class' => 'woops-a'))?> on your website already?
                <?endif?>
            </p>
        <?endif?>
    </div>
    <br/><br/>
<?endif?>
</div>
