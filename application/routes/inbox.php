<?php

return array( 
    'GET /inbox/(:any?)/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function($filter=False, $choice=False) {

        $limit = 10;

        if(Input::get('limit')) $limit = (int)Input::get('limit');

        $feedback = new Feedback;
        $category = new Category;
        $pagination = new ZebraPagination;

        $offset = ($pagination->get_page() - 1) * $limit;

        $records = $feedback->pull_feedback($limit, $offset, $filter, $choice);
        /*
        $embedded_block = $feedback->show_embedded_block();
        print_r($embedded_block);
        */       
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
