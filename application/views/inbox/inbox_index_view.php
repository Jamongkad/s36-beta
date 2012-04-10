<?if($feedback != null):?>
<div class="the-feedbacks"> 
        <?foreach($feedback as $feeds):?>

            <div style="padding:12px; float:left">
                <?=date("jS F, l Y", $feeds->unix_timestamp)?> <!--(<?=$feeds->daysago?>)-->
                (<abbr class="timeago" title="<?=date("Y-m-d h:i:s", $feeds->unix_timestamp)?>"></abbr>)
            </div>

            <?foreach($feeds->children as $feed):?>
            <p></p>
            <? $id = $feed->id ?>
            <div class="feedback" id="<?=$id?>">
                <div class="left">      
                    <input type="checkbox" name="id" value="<?=$id?>" class="check-feed-id"/>
                    <input type="hidden" name="rating" value="<?=$feed->rating?>" class="feed-ratings" />
                    <input type="hidden" name="contact_id" value="<?=$feed->contactid?>" class="contact-feed-id"/>
                    <input type="hidden" name="site_id" value="<?=$feed->siteid?>" class="site-feed-id" />
                    <input type="hidden" name="cat_id" value="<?=$feed->categoryid?>" class="category-feed-id"/>
                    <input type="hidden" name="inbox_state" value="<?=$inbox_state?>" class="inbox-state"/>
                </div>
                <div class="right">
                    <div class="g4of5">
                        <div class="feedback-avatar"> 
                            <?if($feed->avatar):?> 
                                <?=HTML::image('uploaded_cropped/48x48/'.$feed->avatar)?>
                            <?else:?>
                                <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                            <?endif?>
                        </div>

                        <div class="feedback-details">
                            <?
                            $regex = Helpers::nav_regex();
                            if(!$regex->deleted):
                            ?>
                            <!-- email picker block -->
                            <div class="base-popup fast-forward-holder" id="<?=$id?>">
                                <div class="popup-arrow"></div>
                                <div class="email-list">
                                    <?if($admin_check->ffemail1 || $admin_check->ffemail2 || $admin_check->ffemail3):?>
                                    <ul class="email-picker">
                                        <?if($admin_check->ffemail1):?>
                                            <li id="email1"> 
                                                <?=($admin_check->alias1) ? $admin_check->alias1 : "Name 1"?> : <a href="javascript:;"><?=$admin_check->ffemail1?></a> 
                                            </li>
                                        <?endif?>
                                        <?if($admin_check->ffemail2):?>
                                            <li id="email2"> 
                                                <?=($admin_check->alias2) ? $admin_check->alias2 : "Name 2"?> : <a href="javascript:;"><?=$admin_check->ffemail2?></a> 
                                            </li>
                                        <?endif?>
                                        <?if($admin_check->ffemail3):?>
                                            <li id="email3"> 
                                                <?=($admin_check->alias3) ? $admin_check->alias3 : "Name 3"?> : <a href="javascript:;"><?=$admin_check->ffemail3?></a> 
                                            </li>
                                        <?endif?>
                                    </ul>
                                    <?else:?>
                                        <?=HTML::link('settings', 'Configure your fast forward settings')?> 
                                    <?endif?>

                                    <?=Form::open('feedback/fastforward', 'POST', array('class' => 'ff-form'))?>
                                        <?=Form::hidden('email')?>
                                        <?=form::hidden('feed_id', $id)?>
                                        <div class="ff-forward-to"></div>
                                        <div class="popup-border"></div>
                                        <?=Form::textarea('email_comment', "(Optional message)", array('class' => 'small popup-textarea'))?>
                                        <div class="popup-border"></div>
                                        <div class="popup-button">
                                            <input type="submit" class="button" value="SEND" />
                                        </div>
                                    <?=Form::close()?>
                                </div>
                            </div>
                            <!-- end email picker block -->
                            <!-- category picker -->
                            <div class="base-popup category-picker-holder" id="<?=$id?>">
                                <div class="popup-arrow"></div>
                                <div>File this feedback as:</div>
                                <ul class="category-picker" id="<?=$feed->categoryid?>">
                                  <?foreach($categories as $cat):?> 
                                     <li>
                                          <?=HTML::link('feedback/changecat/', $cat->name, Array(
                                               'hrefaction' => URL::to('/feedback/change_feedback_state')
                                             , 'class'      => 'cat-picks'.(($feed->category === $cat->name) ? ' Matched' : Null)
                                             , 'feedid'     => $id
                                             , 'catid'      => $cat->id
                                             , 'cat-state'  => $cat->intname
                                             , 'state'      => 0
                                          ))?>
                                      </li>
                                  <?endforeach?>
                                </ul>
                                <div><?=HTML::link('settings', 'manage categories →')?></div>
                                <div class="popup-border"></div>
                                <div class="grids">
                                    <div class="label g1of2">Status</div>
                                    <div class="dropdown g1of2">
                                        <select class="catmenu-status" name="status" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changestatus')?>">
                                            <?foreach($status as $option):?>
                                                <?$option_match = str_replace(" ", "", strtolower($option->name));?>  
                                                <option <?=($feed->status == $option->name) ? 'selected' : null?> value="<?=$option_match?>"><?=$option->name?></option>
                                            <?endforeach?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="popup-border"></div>
                                <div class="grids">
                                    <div class="label g1of2">Priority</div>
                                    <div class="dropdown g1of2">
                                        <select class="catmenu-priority" name="priority" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changepriority')?>">
                                            <?foreach($priority_obj as $key => $val):?>
                                                <option <?=($feed->priority == $val) ? 'selected' : null?> value="<?=$val?>"><?=$val?></option>
                                            <?endforeach?>
                                        </select>
                                    </div>
                                </div>
                                <div class="popup-border"></div> 
                                <div class="grids" style="text-align: center">
                                    <input type="button" class="popup-delete" 
                                    <?=Helpers::switchable($feed->isdeleted, $id, $feed->categoryid, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>
                                    value="" />
                                </div> 
                            </div>
                            <!-- end of category picker-->

                            <div class="options">
                                <?if($feed->rating != "POOR"):?>
                                    <?if($admin_check->inbox_approve == 0):?>
                                        <input type="button" class="check" tooltip="Option Disabled" tt_width="75" style="background-position: 0px -51px"/>
                                    <?else:?>
                                        <input type="button" class="check" tooltip="<?=($feed->ispublished) ? "Return to Inbox" : "Publish Feedback"?>"  tt_width="85"
                                        <?=Helpers::switchable($feed->ispublished, $id, $feed->categoryid, URL::to('/feedback/change_feedback_state'), ' style="background-position: 0px -34px"') ?>/>
                                    <?endif?>
                                <?else:?>
                                    <input type="button" class="check" tooltip="This feedback cannot be published" tt_width="165" 
                                                                                                                   style="background-position: 0px -51px !important;"/>
                                <?endif?>
                                <input type="button" class="save fileas" id="<?=$id?>" tooltip="Categorize Feedback"/>
                                <input type="button" class="reply" hrefaction="<?=URL::to('/feedback/reply_to/'.$id)?>" tooltip="Reply to user" tt_width="65"/>

                                <?if($feed->rating != "POOR"):?>
                                    <?if($admin_check->inbox_feature == 0) :?>
                                        <input type="button" class="feature" tooltip="Option Disabled" tt_width="75" style="background-position: -60px -51px;" />
                                    <?else:?>
                                        <input type="button" class="feature" tooltip="<?=($feed->isfeatured) ? "Return to Inbox" : "Feature Feedback"?>" tt_width="85"
                                        <?=Helpers::switchable($feed->isfeatured, $id, $feed->categoryid, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px -34px"') ?>/>
                                    <?endif?>
                                <?else:?>
                                    <input type="button" class="feature" tooltip="This feedback cannot be featured" tt_width="160" 
                                                                                                                    style="background-position: -60px -51px;"/>
                                <?endif?>
                                <?if($admin_check->inbox_fastforward == 0):?>
                                    <input type="button" class="contact" tooltip="Option Disabled" tt_width="75" style="opacity:0.2; filter:alpha(opacity=40)"/> 
                                <?else:?>
                                    <input type="button" class="contact" id="<?=$id?>" tooltip="Fast Forward" tt_width="60"/> 
                                <?endif?>
                            </div>
                            <?endif?>
                            <div class="author-info">
                                <h3>
                                    <?=$feed->firstname?> <?=$feed->lastname?>
                                    <?if($feed->rating != "POOR"):?>
                                        <span><?=$feed->countryname?>, <?=$feed->countrycode?></span>
                                    <?endif?>

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
                                </h3>
                                <p><?=strip_tags($feed->text)?></p>
                            </div> 
                            <div class="feedback-meta">
                                <span class="rating <?=strtolower($feed->rating)?>"><?=$feed->rating?></span>
                                <span class="permission"><?=$feed->permission?></span>
                                <span class="status-change status"> Status: <span class="status-target"><?=$feed->status?></span>
                                    <select name="status" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changestatus')?>">
                                        <?foreach($status as $option):?>
                                            <?$option_match = str_replace(" ", "", strtolower($option->name));?>  
                                            <option <?=($feed->status == $option->name) ? 'selected' : null?> value="<?=$option_match?>"><?=$option->name?></option>
                                        <?endforeach?>
                                    </select> 
                                </span>
                                <span class="priority-change priority">
                                    Priority: <span class="priority-target"><?=$feed->priority?></span>
                                    <select name="priority" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changepriority')?>">
                                        <?foreach($priority_obj as $key => $val):?>
                                            <option <?=($feed->priority == $val) ? 'selected' : null?> value="<?=$val?>"><?=$val?></option>
                                        <?endforeach?>
                                    </select>
                                </span>
                                <span class="modify">
                                    <?=HTML::link('/feedback/modifyfeedback/'.$id, 'Modify Additional info')?> 
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="g1of5">
                        <div class="timestamp">
                            <? $date = $feed->date;
                               $unix = strtotime($date);
                            ?>   
                            <div class="date"><?=date('F j, Y', $unix);?></div>
                            <div class="time"><?=date('h:i:m a', $unix);?></div>
                            <?if($admin_check->inbox_flag == 0):?>
                                <input type="button" class="flag" tooltip="Option Disabled" tt_width="84"  style="opacity:0.4; filter:alpha(opacity=40)"/>
                            <?else:?>
                                <input type="button" class="flag" tooltip="Flag Feedback" tt_width="75" 
                                <?=Helpers::switchable($feed->isflagged, $id, $feed->categoryid, URL::to('/feedback/flagfeedback'), ' style="background-position:-100px -17px;"') ?>/>
                            <?endif?>

                            <?if($feed->isdeleted == 0):?>
                                <?if($admin_check->inbox_delete == 0):?>
                                    <input type="button" class="remove"  tooltip="Option Disabled" tt_width="84" style="opacity:0.4; filter:alpha(opacity=40)"/>
                                <?else:?>
                                    <input type="button" class="remove" tooltip="Delete Feedback" tt_width="84" 
                                    <?=Helpers::switchable($feed->isdeleted, $id, $feed->categoryid, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>/>
                                <?endif?>
                            <?else:?>
                                <?=HTML::link('/feedback/restorefeedback/'.$id, 'restore feedback', Array('class' => 'restore-feed'))?><br/>
                                <?=HTML::link('/feedback/removefeedback/'.$id, 'remove feedback', Array('class' => 'perm-delete'))?>
                            <?endif?>
                        </div>
                    </div>
                    <span class="status-message"></span>
                </div>
            </div>
            <?endforeach?>
        <?endforeach?>
    <div class="c"></div>
    
    <?if($pagination):?>
        <div style="padding:10px 28px 30px"> 
            <?=$pagination?>
        </div>
    <?endif?>
</div>
<?else:?>
      <div class="woops">
            <h2 class="woops-header">Woops. There's no feedback here.</h2><br/><br/>
            <p class="woops-content">Have you <?=HTML::link('feedsetup', 'set up your feedback form', Array('class' => 'woops-a'))?> 
                on your website already?
            </p>
      </div>
<?endif?>
<!-- end of feedback list -->
