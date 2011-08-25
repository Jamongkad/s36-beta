<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),

    'GET /dashboard/test' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        $fb = new Feedback;
        $data = Array(
            'company_id' => 1
          , 'feed_id' => 47
          , 'contact_id' => 93
          , 'site_ids' => implode(',', Array(2))
        ); 

        echo "<pre>";
        print_r($fb->contact_detection_query($data));
        echo "</pre>";
    }),
);
