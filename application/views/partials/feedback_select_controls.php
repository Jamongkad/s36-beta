<label>SELECTED</label>
<?//show this when looking at inbox except when in deleted
if(!preg_match_all('/inbox\/deleted/', Request::uri(), $matches)):?>
    <?=Form::select('delete_selection', Array(
        'none' => '-'
      , 'inbox' => 'Inbox'
      , 'publish' => 'Publish'
      , 'feature' => 'Feature'
      , 'delete' => 'Delete'
     ), 'none', array('class' => 'delete-selection', 'hrefaction' => URL::to('/feedback/fire_multiple')));?>
<?else:?>
    <?=Form::select('delete_selection', Array(
        'none' => '-'
      , 'restore' => 'Restore'
      , 'remove' => 'Permanently Delete'
     ), 'none', array('class' => 'delete-selection', 'hrefaction' => URL::to('/feedback/fire_multiple')));?>
<?endif?>
