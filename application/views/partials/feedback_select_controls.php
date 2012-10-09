<label>Selected</label>
<?//show this when looking at inbox except when in deleted
if(!preg_match('~inbox/deleted/all~', Request::uri(), $matches)):?>

    <?
    $links = Array(
        'none' => '-'
      , 'publish' => 'Publish'
      , 'feature' => 'Feature'
      , 'delete' => 'Delete'
     );

    if(preg_match_all('~inbox/published~', Request::uri(), $matches)) {
        unset($links['publish']);     
        unset($links['feature']);     
    }

    echo Form::select('feed_selection', $links, 'none', 
         array('class' => 'feed-selection', 'hrefaction' => URL::to('/feedback/fire_multiple'), 'base-url' => URL::to('/')) );?> 
<?else:?>
    <?=Form::select('feed_selection', Array(
        'none' => '-'
      , 'restore' => 'Restore'
      , 'remove' => 'Permanently Delete'
     ), 'none', array('class' => 'feed-selection', 'hrefaction' => URL::to('/feedback/fire_multiple'), 'base-url' => URL::to('/')));?>
<?endif?>
