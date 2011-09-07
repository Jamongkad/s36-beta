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
                            <?=HTML::image('img/48x48/'.$feed->avatar)?>
                        <?else:?>
                            <?=HTML::image('img/avatar-matthew.png')?>
                        <?endif?>
                    </div>
                    <div class="feedback-details">
                        <?
                        $regex = Helpers::nav_regex();
                        if(!$regex->deleted):
                        ?>
                        <div class="options">
                            <input type="button" class="check" 
                            <?=Helpers::switchable($feed->ispublished, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: 0px bottom"') ?>/>
                            <input type="button" class="save fileas" />
                            <div class="base-popup category-picker-holder">
                                 <div class="popup-arrow"></div>
                                 <ul class="category-picker">
                                     <?foreach($categories as $cat):?> 
                                         <li <?=($feed->category === $cat->name) ? 'class="Matched"' : Null?>>
                                             <?=HTML::link('feedback/changecat/'.$cat->id.'/'.$id.'/'.$feed->contactid.'/'.$feed->siteid, $cat->name)?>
                                         </li>
                                     <?endforeach?>
                                 </ul>
                            </div>
                            <input type="button" class="reply" />
                            <input type="button" class="feature" 
                            <?=Helpers::switchable($feed->isfeatured, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>/>
                            <input type="button" class="contact" /> 
                        </div>
                        <?endif?>
                        <div class="author-info">
                            <h3><?=$feed->firstname?> <?=$feed->lastname?><span><?=$feed->countryname?>, <?=$feed->countrycode?></span></h3>
                            <p><?=$feed->text?></p>
                        </div> 
                        <div class="feedback-meta">
                            <?$rating = $feed->rating?>
                            <?if($rating == 1 || $rating == 2):?>
                                <span class="rating poor">POOR</span>
                            <?endif?>
                            <?if($rating == 3):?>
                                <span class="rating average">AVERAGE</span>
                            <?endif?>
                            <?if($rating == 4):?>
                                <span class="rating good">GOOD</span>
                            <?endif?>
                            <?if($rating == 5):?>
                                <span class="rating excellent">EXCELLENT</span>
                            <?endif?>

                            <span class="permission">LIMITED PERMISSION</span>
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

                        <input type="button" class="flag" 
                        <?=Helpers::switchable($feed->isflagged, $id, URL::to('/feedback/flagfeedback'), ' style="background-position: -100px bottom"') ?>/>
                        <?if($feed->isdeleted == 0):?>
                            <!--<input type="button" class="remove" hrefaction="<?=URL::to('/feedback/deletefeedback/'.$id)?>" />-->
                            <input type="button" class="remove"
                            <?=Helpers::switchable($feed->isdeleted, $id, URL::to('/feedback/change_feedback_state'), ' style="background-position: -60px bottom"') ?>/>
                        <?else:?>
                            <?=HTML::link('/feedback/undodelete/'.$id, 'restore feedback', Array('class' => 'restore-feed'))?>
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
