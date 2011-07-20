<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /inbox' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function() use ($user, $view) {

        $limit = null; $offset = null;

        if(Input::get('limit') || Input::get('offset')) {
            $limit = Input::get('limit');
            $offset = Input::get('offset');
        }

        print_r($limit);
        print_r($offset);

        $feedback = new Feedback;
        $category = new Category;

        $user_id = $user->user()->userid;         
        $view->contents = View::make('inbox/index');
        $view->contents->feedback = $feedback->pull_feedback($user_id, 50, 0);
        $view->contents->categories = $category->pull_site_categories($user_id);
        $view->contents->status = DB::table('Status', 'master')->get();
        $view->contents->priority_obj = (object)Array(0 => 'low', 60 => 'medium', 100 => 'high');
        return $view;
    }),
);
