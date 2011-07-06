<div class="g4of5">
    
    <?foreach($feedback as $feed):?>
        <div class="grids" style="padding: 10px; background-color: #fff; border-bottom: solid 1px #e4e4e4 ">
            <div class="g1of2">
                <div style="font-size: 0.9em; font-weight: bold"><?=$feed->firstname?> <?=$feed->lastname?></div>
                <p style="font-size: 0.77em"><?=$feed->text?></p>
                <span class="light_blue">Status:</span><span><?=$feed->status?></span>
                <span class="light_blue">Priority:</span><span><?=$feed->priority?></span>
                <?=HTML::link('/', 'Modify Additional info')?> 
            </div>

            <div class="g1of2">
                <div style="font-size: 0.9em; font-weight: bold"><?=$feed->firstname?> <?=$feed->lastname?></div>
                <p style="font-size: 0.77em"><?=$feed->text?></p>
                <span class="light_blue">Status:</span><span><?=$feed->status?></span>
                <span class="light_blue">Priority:</span><span><?=$feed->priority?></span>
                <?=HTML::link('/', 'Modify Additional info')?> 
            </div>
        </div>
    <?endforeach?>
</div>
