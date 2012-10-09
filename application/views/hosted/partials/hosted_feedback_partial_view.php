<?if($collection):?>
    <?if(is_array($collection)):?>
        <?foreach($collection as $collect):?>
            <?=View::make('hosted/partials/hosted_feedback_iter_view', Array('collection' => $collect))?>
        <?endforeach?>
    <?else:?> 
        <?=View::make('hosted/partials/hosted_feedback_iter_view', Array('collection' => $collection))?>
    <?endif?>
<?endif?>
