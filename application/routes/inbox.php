<?php

$user = new S36Auth();

return array( 
    'GET /inbox/(:any?)' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function($filter=False) use ($user) {

        $user_id = $user->user()->userid;         
        $limit = 10;

        if(Input::get('limit')) $limit = (int)Input::get('limit');

        $feedback = new Feedback;
        $category = new Category;
        $pagination = new ZebraPagination;

        $records = $feedback->pull_feedback($user_id, $limit, ($pagination->get_page() - 1) * $limit, $filter);

        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);

        return View::make('partials/layout')->partial('contents', 'inbox/index', Array(
              'feedback' => $records
            , 'categories' => $category->pull_site_categories($user_id)
            , 'pagination' => $pagination->render()
            , 'status' => DB::table('Status', 'master')->get()
            , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high')
        ));
    }), 
);
