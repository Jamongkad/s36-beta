<label>SELECTED</label>
<?//show this when looking at inbox except when in deleted
if(!preg_match_all('/inbox\/deleted/', Request::uri(), $matches)):?>
    <?
    $links = Array(
        'none' => '-'
      , 'inbox' => 'Inbox'
      , 'publish' => 'Publish'
      , 'feature' => 'Feature'
      , 'delete' => 'Delete'
     );

    if(preg_match_all('~inbox/all~', Request::uri(), $matches)) {
        unset($links['inbox']);     
    }

    if(preg_match_all('~inbox/published~', Request::uri(), $matches)) {
        unset($links['publish']);     
    }

    if(preg_match_all('~inbox/featured~', Request::uri(), $matches)) {
        unset($links['feature']);     
    }

    echo Form::select('delete_selection', $links, 'none', 
         array('class' => 'delete-selection', 'hrefaction' => URL::to('/feedback/fire_multiple'), 'base-url' => URL::to('/')) );?>
<?else:?>
    <?=Form::select('delete_selection', Array(
        'none' => '-'
      , 'restore' => 'Restore'
      , 'remove' => 'Permanently Delete'
     ), 'none', array('class' => 'delete-selection', 'hrefaction' => URL::to('/feedback/fire_multiple'), 'base-url' => URL::to('/')));?>
<?endif?>
