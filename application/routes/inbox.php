<?php

return array( 
    'GET /inbox/(:any?)/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function($filter=False, $choice=False) {

        $limit   = 10;
        $site_id = False;
        $rating  = False;
    
        if(Input::get('limit')) $limit = (int)Input::get('limit');
        if(Input::get('site_id')) $site_id = (int)Input::get('site_id');
        if(Input::get('rating')) $rating = (int)Input::get('rating');

        $feedback = new Feedback;
        $category = new Category;
        $pagination = new ZebraPagination;

        $offset = ($pagination->get_page() - 1) * $limit;

        $records = $feedback->pull_feedback(array('limit'=> $limit, 'offset'=> $offset, 'filter'=> $filter, 
                                                  'choice'=> $choice, 'site_id'=> $site_id, 'rating'=> $rating));
        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);
          
        return View::of_layout()->partial('contents', 'inbox/index', Array(
              'feedback' => $records
            , 'categories' => $category->pull_site_categories()
            , 'pagination' => $pagination->render()
            , 'status' => DB::table('Status', 'master')->get()
            , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high')
        ));
    }), 
);
