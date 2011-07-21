<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /inbox' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function() use ($user, $view) {

        $limit = 10; $offset = 0;

        if(Input::get('limit') || Input::get('offset')) {
            $limit = (int)Input::get('limit');
            $offset = (int)Input::get('offset');
        }

        $feedback = new Feedback;
        $category = new Category;

        $user_id = $user->user()->userid;         
        $view->contents = View::make('inbox/index');
        $view->contents->feedback = $feedback->pull_feedback($user_id, $limit, $offset);
        $view->contents->categories = $category->pull_site_categories($user_id);
        $view->contents->status = DB::table('Status', 'master')->get();
        $view->contents->priority_obj = (object)Array(0 => 'low', 60 => 'medium', 100 => 'high');
        return $view;

    }),
);
