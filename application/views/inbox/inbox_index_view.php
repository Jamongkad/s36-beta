<div id="theInbox">
    <div id="theInboxSorter">
        <div class="grids">
            <div class="sorter-block sorter-checkbox">
                <div class="sorter-block-box"><input type="checkbox" /></div>
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

                         echo Form::select('feed_selection', $links, 'none');?> 
                    <?else:?>
                        <?=Form::select('feed_selection', Array(
                            'none' => '-'
                          , 'restore' => 'Restore'
                          , 'remove' => 'Permanently Delete'
                         ), 'none');?>
                    <?endif?>
                </span>
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
        </div>
    </div>

    <div id="theInboxFeeds">
        <?foreach($feedback as $feeds):?>
            <div class="feedback-group">
                <div class="feedback-date-header">
                    <strong><?=date("jS F, l Y", $feeds->unix_timestamp)?> (<?=$feeds->daysago?>)</strong>
                </div>
                <?php foreach($feeds->children as $feed):?>
                    <div class="dashboard-feedback grids" <?=($feed->isfeatured) ? 'style="background-color: #FFFFE0"' : null?>>
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
                                    <span class="feedback-details-modify">
                                        <?=HTML::link('/feedback/modifyfeedback/'.$feed->id, 'Modify Additional Info')?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-feedback-actions grids">
                            <div class="feedback-action-menu" ng-controller="FeedbackControl">
                                <div class="grids">
                                    <div class="action-sprite action-delete" ng-click="delete_feedback(<?=$feed->id?>)"></div>
                                    <div class="action-delete-tooltip"></div>
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
                                                <li class="action-sprite publish" ng-click="publish_feedback(<?=$feed->id?>)" publish
                                                    <?=($feed->ispublished) ? "style='background-position: -32 -31px'" : null?>> 
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
                                                <li class="action-sprite feature" ng-click="feature_feedback(<?=$feed->id?>)" feature
                                                    <?=($feed->isfeatured) ? "style='background-position: -64px -31px'" : null?>>
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
                                            <li class="action-sprite reply" ng-click="reply_feedback(<?=$feed->id?>)">
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

                                        <li class="action-sprite contact" ng-click="fast_forward(<?=$feed->id?>)">
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
                                        <li class="action-sprite flag-action" ng-click="flag_feedback(<?=$feed->id?>)">
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
</div>
