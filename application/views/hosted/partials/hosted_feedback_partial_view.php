<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $coll->head, 'type' => 'featured'))?>
    <?endif?>
    
    <?if(property_exists($coll, 'children')):?>
        <?foreach($coll->children as $child):?> 
            <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $child, 'type' => 'normal'))?>
        <?endforeach?>
    <?endif?>
<?endforeach?>
