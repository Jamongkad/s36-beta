<?php

return array( 
    'GET /inbox/(:any?)/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function($filter=False, $choice=False) {  
        /*
        print_r("Filter: ".$filter."<br>");
        print_r("Filter Choice: ".$choice."<br>"); 
        print_r(Input::get()); 

        $inbox = new Feedback\Services\InboxService; 
        $filters = array(
              'limit'=> 10
            , 'offset'=> 0
            , 'site_id'=> false 
            , 'filter'=> $filter
            , 'choice'=> $choice
            , 'date'  => false
            , 'rating' => false
            , 'category' => false
            , 'priority' => false //low medium high
            , 'status' => false //new inprogress closed
        );
        Helpers::dump($inbox->set_filters($filters));  
        Helpers::dump($inbox->present_feedback());
        */
        
        $limit   = 10;
        $site_id = False;
        $rating  = False;
    
        if(Input::get('limit'))   $limit   = (int)Input::get('limit');
        if(Input::get('site_id')) $site_id = (int)Input::get('site_id');
        if(Input::get('rating'))  $rating  = (int)Input::get('rating');

        $feedback = new Feedback\Repositories\DBFeedback;
        $pagination = new ZebraPagination; 
        $pagination->selectable_pages(4);

        $offset = ($pagination->get_page() - 1) * $limit;
        $records = $feedback->pull_feedback(array('limit'=> $limit, 'offset'=> $offset, 'filter'=> $filter, 
                                                  'choice'=> $choice, 'site_id'=> $site_id, 'rating'=> $rating));
        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);

        $admin_check = S36Auth::user();
        $category = new DBCategory;
        $view_data = Array(
              'feedback' => $records
            , 'pagination' => $pagination->render()
            , 'admin_check' => $admin_check
            , 'categories' => $category->pull_site_categories()
            , 'status' => DB::table('Status', 'master')->get()
            , 'inbox_state' => Helpers::inbox_state($filter)
            , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high') 
        );
        
        if(!Input::get('_pjax')) { 
            return View::of_layout()->partial('contents', 'inbox/inbox_index_view', $view_data);
        } else {
            echo View::make('inbox/inbox_index_view', $view_data);
        }

  
    }), 
);
