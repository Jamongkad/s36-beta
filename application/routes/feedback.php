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

        return $view;
    }),

    //Ajax Functions...
    'GET /feedback/changecat' => function() use ($user) {
        $feedback_id = Input::get('feedid');
        $cat_id = Input::get('catid');
        $feedback = new Feedback;
        $feedback->change_feedback_cat($feedback_id, $cat_id);
    },

    'POST /feedback/changestatus' => function() {
        print_r($_POST);
    },

    'GET /feedback/makesticky/(:num)' => function($id) {
        $feedback = new Feedback;
        $feedback->make_sticky($id, Input::get('state'));
    },

    'GET /feedback/feature/(:num)' => function($id) use($user) {
        print_r($id);
    },
);
