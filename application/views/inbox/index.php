<div class="g4of5 feedback-feeds"> 
    <?foreach($feedback as $feed):?>
        <? $id = $feed->id ?>
        <div class="grids feedback-holder">
            <div class="g3of5">
                <div class="feedback-author"><?=$feed->firstname?> <?=$feed->lastname?></div>
                <p><?=$feed->text?></p>
                <span class="light_blue">Status: </span><span><?=$feed->status?></span>
                <span class="light_blue">Priority: </span><span><?=$feed->priority?></span>
                <span class="light_blue">Rating: </span><span><?=$feed->rating?></span>
                <?=HTML::link('/feedback/modifyfeedback/'.$id, 'Modify Additional info')?> 
            </div>
            <div class="g1of5">
                <?=HTML::link('/feedback/feature/'.$id, 'Mark as Featured');?><br/>
                <?=HTML::link('/feedback/fileas/'.$id, 'File as...');?><br/>
                <?=HTML::link('/feedback/reply/'.$id, 'Reply to User');?><br/>
                <?=HTML::link('/feedback/makesticky/'.$id, 'Mark sticky');?><br/>
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
    <?endforeach?>
</div>
