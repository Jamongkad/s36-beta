<?if($collection->head):?>
    <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $collection->head, 'type' => 'featured'))?>
<?endif?>

<?if($collection->children):?>
    <?foreach($collection->children as $child):?> 
        <?=View::make('hosted/partials/hosted_feedback_unit_view', Array('feed' => $child, 'type' => 'normal'))?>
    <?endforeach?>
<?endif?>
