<div class="the-feedbacks"> 
    <?foreach($feedback->result as $feed):?>
        <? $id = $feed->id ?>
        <div class="feedback" id="<?=$id?>">
            <div class="left">
                <input type="checkbox" name="id" value="<?=$id?>" class="check-feed-id"/>
                <input type="hidden" name="contact_id" value="<?=$feed->contactid?>" class="contact-feed-id"/>
                <input type="hidden" name="site_id" value="<?=$feed->siteid?>" class="site-feed-id" />
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
                        <div class="options">
                            <?if($feed->rating != "POOR"):?>
                                <input type="button" class="check" tooltip="Publish Feedback" tt_width="85"
                                <?=Helpers::switchable($feed->ispublished, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: 0px bottom"') ?>/>
                            <?else:?>
                                <input type="button" class="check" tooltip="This feedback cannot be published" />
                            <?endif?>
                            <input type="button" class="save fileas" tooltip="Categorize Feedback"/>
                            <div class="base-popup category-picker-holder">
                                 <div class="popup-arrow"></div>
                                 <ul class="category-picker">
                                     <?foreach($categories as $cat):?> 
                                         <li <?=($feed->category === $cat->name) ? 'class="Matched"' : Null?>>
                                             <?=HTML::link('feedback/changecat/', $cat->name, Array(
                                                  'hrefaction' => URL::to('/feedback/change_feedback_state')
                                                , 'class'      => 'cat-picks'
                                                , 'feedid'     => $id
                                                , 'catid'      => $cat->id
                                                , 'state'      => 0
                                             ))?>
                                         </li>
                                     <?endforeach?>
                                 </ul>
                            </div>
                            <input type="button" class="reply" />
                            <?if($feed->rating != "POOR"):?>
                                <input type="button" class="feature" tooltip="Feature Feedback" tt_width="85"
                                <?=Helpers::switchable($feed->isfeatured, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>/>
                            <?else:?>
                                <input type="button" class="feature" tooltip="This feedback cannot be featured"/>
                            <?endif?>
                            <input type="button" class="contact" tooltip="Fast Forward" tt_width="60"/> 
                        </div>
                        <?endif?>
                        <div class="author-info">
                            <h3>
                                <?=$feed->firstname?> <?=$feed->lastname?>
                                <?if($feed->rating != "POOR"):?>
                                    <span><?=$feed->countryname?>, <?=$feed->countrycode?></span>
                                <?endif?>
                            </h3>
                            <p><?=$feed->text?></p>
                        </div> 
                        <div class="feedback-meta">
                            <span class="rating <?=strtolower($feed->rating)?>"><?=$feed->rating?></span>
                            <span class="permission"><?=$feed->permission?></span>
                            <span class="status-change status">
                                Status: <span class="status-target"><?=$feed->status?></span>
                                <select name="status" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changestatus')?>">
                                    <?foreach($status as $option):?>
                                        <?$option_match = str_replace(" ", "", strtolower($option->name));?>  
                                        <option <?=($feed->status == $option_match) ? 'selected' : null?> value="<?=$option_match?>"><?=$option->name?></option>
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

                        <input type="button" class="flag" tooltip="Flag Feedback" tt_width="75" 
                        <?=Helpers::switchable($feed->isflagged, $id, URL::to('/feedback/flagfeedback'), ' style="background-position: -100px bottom"') ?>/>
                        <?if($feed->isdeleted == 0):?>
                            <!--<input type="button" class="remove" hrefaction="<?=URL::to('/feedback/deletefeedback/'.$id)?>" />-->
                            <input type="button" class="remove" tooltip="Delete Feedback" tt_width="84" 
                            <?=Helpers::switchable($feed->isdeleted, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>/>
                        <?else:?>
                            <?=HTML::link('/feedback/undodelete/'.$id, 'restore feedback', Array('class' => 'restore-feed'))?><br/>
                            <?=HTML::link('/feedback/removefeedback/'.$id, 'remove feedback')?>
                        <?endif?>
                    </div>
                </div>
                <span class="status-message"></span>
            </div>
        </div>
    <?endforeach?>

    <div class="c"></div>
</div>
<!-- end of feedback list -->
<div class="admin-sorter-bar">
    <div class="sorter-bar">
        <div class="left">
            <input type="checkbox" class="click-all"/>
        </div>
        <div class="right">
            <div class="g1of3">
                <?=View::make('partials/feedback_select_controls')?>
            </div>
            <div class="g1of3">
                <div class="pagination-text"><?=$pagination?></div>
            </div>
            <!--
            <div class="g1of3">
                <div class="pagination">
                    Page <input type="text" style="width: 30px;" class="pagination-input" value="1" /> of <?=$feedback->total_rows?>
                </div>
            </div>
            -->
        </div>
        <div class="c"></div>
    </div>
</div>
