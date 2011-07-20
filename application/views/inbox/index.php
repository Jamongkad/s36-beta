<div class="the-feedbacks"> 
    <?foreach($feedback as $feed):?>
        <? $id = $feed->id ?>
        <div class="feedback">
            <div class="left">
                <input type="checkbox" />
            </div>
            <div class="right">
                <div class="g4of5">
                    <div class="feedback-avatar"> 
                        <?=HTML::image('img/avatar-matthew.png')?>
                    </div>
                    <div class="feedback-details">
                        <div class="options">
                            <input type="button" class="check" />
                            <input type="button" class="save" />
                            <input type="button" class="reply" />

                            <input type="button" class="feature makesticky" 
                                   state="<?=(($feed->issticked == 0) ? 'Make Sticky' : 'Stickied')?>" 
                                   hrefaction="<?=URL::to('/feedback/makesticky/'.$id)?>" 
                                   <?=(($feed->issticked == 0) ? null : ' style="background-position: -60px bottom"')?>/>

                            <input type="button" class="contact" />
                        </div>
                        <div class="author-info">
                            <h3><?=$feed->firstname?> <?=$feed->lastname?><span><?=$feed->countryname?>, <?=$feed->countrycode?>P</span></h3>
                            <p><?=$feed->text?></p>
                        </div>
                        <div class="feedback-meta">
                            <?$rating = $feed->rating?>
                            <?if($rating == 1):?>
                                <span class="rating poor">POOR</span>
                            <?endif?>
                            <?if($rating == 2):?>
                                <span class="rating average">AVERAGE</span>
                            <?endif?>
                            <?if($rating == 3 || $rating == 4):?>
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
                                        <option <?=($feed->priority == $val) ? 'selected' : null?> value="<?=$key?>"><?=$val?></option>
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

                        <input type="button" class="flag" />
                        <input type="button" class="remove" />
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="grids feedback-holder">
            <div class="g3of5">
                <div class="feedback-author"><?=$feed->firstname?> <?=$feed->lastname?></div>
                <p><?=$feed->text?></p>
                <span class="light_blue">Status: </span>
                <span class="status-change">
                    <span class="status-target"><?=$feed->status?></span>
                    <select name="status" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changestatus')?>">
                        <?foreach($status as $option):?>
                            <?$option_match = str_replace(" ", "", strtolower($option->name));?>  
                            <option <?=($feed->status == $option_match) ? 'selected' : null?> value="<?=$option_match?>"><?=$option->name?></option>
                        <?endforeach?>
                    </select> 
                </span>
                <span class="light_blue">Priority: </span>
                <span class="priority-change">
                    <span class="priority-target"><?=$feed->priority?></span>
                    <select name="priority" feedid="<?=$id?>" feedurl="<?=URL::to('feedback/changepriority')?>">
                        <?foreach($priority_obj as $key => $val):?>
                            <option <?=($feed->priority == $val) ? 'selected' : null?> value="<?=$key?>"><?=$val?></option>
                        <?endforeach?>
                    </select>
                </span>

                <span class="light_blue">Rating: </span><span><?=$feed->rating?></span>
                <?=HTML::link('/feedback/modifyfeedback/'.$id, 'Modify Additional info')?> 
            </div>
            <div class="g1of5">
                <?=HTML::link('/feedback/feature/'.$id, 'Mark as Featured');?><br/>

                <div class="category-picker-box">
                <?=HTML::link('/feedback/fileas/'.$id, 'File as...', array('class' => 'fileas'));?><br/>
                    <div class="category-picker-holder">
                         <ul class="category-picker">
                             <?foreach($categories as $cat):?> 
                                 <li <?=($feed->category === $cat->name) ? 'class="Matched"' : Null?>>
                                     <?=HTML::link('feedback/changecat?catid='.$cat->id.'&feedid='.$feed->id, $cat->name)?>
                                 </li>
                             <?endforeach?>
                         </ul>
                    </div>
                </div>

                <?=HTML::link('/feedback/reply/'.$id, 'Reply to User');?><br/>
                <?=HTML::link('/feedback/makesticky/'.$id, (($feed->issticked == 0) ? 'Make Sticky' : 'Stickied'), array('class' => 'makesticky'));?><br/>
                <?=HTML::link('/feedback/delete/'.$id, 'Delete Feedback Entry');?><br/>
            </div>

            <div class="g1of5"> 
                <? $date = $feed->date;
                   $unix = strtotime($date);
                ?>   
                <div class="date"><?=date('F j, Y', $unix);?></div>
                <div class="time"><?=date('h:i:m a', $unix);?></div>
            </div>
        </div>
        -->
    <?endforeach?>
    <div class="c"></div>
</div>
