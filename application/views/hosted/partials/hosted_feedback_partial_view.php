<?if($collection):?>
    <?if(is_array($collection)):?>
        <?foreach($collection as $collect):?>
            <?if($collect->head):?>
                <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $collect->head, 'type' => 'featured'))?>
            <?endif?>

            <?if($collect->children):?>
                <?foreach($collect->children as $child):?> 
                    <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $child, 'type' => 'normal'))?>
                <?endforeach?>
            <?endif?>
        <?endforeach?>
    <?endif?>
<?endif?>
