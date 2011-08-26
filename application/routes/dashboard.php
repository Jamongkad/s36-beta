<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),

    'GET /dashboard/test' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        //looking at the output of this algorithm I wrote....what the fuck am I doing? 
        $fb = new Feedback;
        $data = Array(
            'company_id' => 1 //from session object
          , 'feed_id'    => Array(44, 17, 64, 1, 43) //from post vars
          , 'contact_id' => Array(93, 1)//implode(',', Array(1))
          , 'site_ids'   => implode(',', Array(1, 2))
        ); 

        echo "<pre>";
        print_r($fb->contact_detection($data));
        echo "</pre>";
    }),
);
