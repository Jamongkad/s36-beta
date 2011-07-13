<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(

    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($view, $user) {     

        $feedback = new Feedback;
        $category = new Category;
        
        $view->contents = View::make('feedback/modifyfeedback');
        $view->contents->feedback = $feedback->pull_feedback_by_id($id);
        $view->contents->categories = $category->pull_site_categories($user->user()->userid);
        $view->contents->id = $id;

        return $view;
    }),

    'GET /feedback/feature/(:num)' => function($id) use($user) {
        print_r($id);
    },
);
