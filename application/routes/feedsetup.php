<?php
return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/feedsetup_view');
    }),

    'GET /feedsetup/displaysetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {  
        return View::of_layout()->partial('contents', 'inbox/displaysetup_view');
    }),

    'GET /feedsetup/displaypreview' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/displaypreview_view');
    }),
);
