<div class="g4of5">
    
    <?foreach($feedback as $feed):?>
        <div style="padding: 10px; background-color: #fff; border-bottom: solid 1px #e4e4e4 ">
            <b><?=$feed->firstname?> <?=$feed->lastname?></b>
            <p style="font-size: 0.8em"><?=$feed->text?></p>
            <span class="light_blue">Status:</span><span><?=$feed->status?></span>
            <span class="light_blue">Priority:</span><span><?=$feed->priority?></span>
            <?=HTML::link('/', 'Modify Additional info')?> 
        </div>
    <?endforeach?>
</div>
