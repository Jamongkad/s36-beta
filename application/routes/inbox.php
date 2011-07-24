<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /inbox' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function() use ($user, $view) {

        $user_id = $user->user()->userid;         
        $limit = 10;

        if(Input::get('limit')) $limit = (int)Input::get('limit');

        $feedback = new Feedback;
        $category = new Category;
        $pagination = new ZebraPagination;

        $records = $feedback->pull_feedback($user_id, $limit, ($pagination->get_page() - 1) * $limit);

        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);
        
        $view->contents = View::make('inbox/index');
        $view->contents->feedback = $records;
        $view->contents->categories = $category->pull_site_categories($user_id);
        $view->contents->pagination = $pagination->render();
        $view->contents->status = DB::table('Status', 'master')->get();
        $view->contents->priority_obj = (object)Array(0 => 'low', 60 => 'medium', 100 => 'high');
        return $view;

    }),
 
);
