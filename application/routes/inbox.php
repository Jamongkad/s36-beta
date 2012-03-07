<?php

return array( 
    'GET /inbox/(:any?)/(:any?)/(:any?)' => Array(  'name' => 'inbox', 'before' => 's36_auth'
                                                  , 'do' => function($filter=False, $choice=False, $sort=False) {       
        $limit   = 10;
        $site_id = False;
        $rating  = False;
    
        if(Input::get('limit'))   $limit   = (int)Input::get('limit');
        if(Input::get('site_id')) $site_id = (int)Input::get('site_id');
        if(Input::get('rating'))  $rating  = (int)Input::get('rating');

        $feedback = new DBFeedback;
        $category = new DBCategory;
        $pagination = new ZebraPagination; 
        $pagination->selectable_pages(3);
        $admin_check = S36Auth::user();

        $offset = ($pagination->get_page() - 1) * $limit;
        $records = $feedback->pull_feedback(array('limit'=> $limit, 'offset'=> $offset, 'filter'=> $filter, 
                                                  'choice'=> $choice, 'site_id'=> $site_id, 'rating'=> $rating));
        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);

        $view_data = Array(
              'feedback' => $records
            , 'categories' => $category->pull_site_categories()
            , 'pagination' => $pagination->render()
            , 'status' => DB::table('Status', 'master')->get()
            , 'admin_check' => $admin_check
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
