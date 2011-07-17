<?php

$user = new S36Auth();
$view = View::make('partials/layout');
$feedback = new Feedback;
$category = new Category;

return array(

    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($view, $user, $feedback, $category) {             
        $view->contents = View::make('feedback/modifyfeedback');
        $view->contents->feedback = $feedback->pull_feedback_by_id($id);
        $view->contents->categories = $category->pull_site_categories($user->user()->userid);

        return $view;
    }),

    //Ajax Functions...
    'GET /feedback/changecat' => function() use ($feedback) {
        $feedback_id = Input::get('feedid');
        $cat_id = Input::get('catid');
        $feedback->change_feedback_cat($feedback_id, $cat_id);
    },

    'POST /feedback/changestatus' => function() use ($feedback) {
        $feedback->change_feedback_status(Input::get('feed_id'), 
                                          Input::get('select_val'));
    },

    'POST /feedback/changepriority' => function() use ($feedback) {
        $feedback->change_feedback_priority(Input::get('feed_id'), 
                                            Input::get('select_val'));
    },

    'GET /feedback/makesticky/(:num)' => function($id) use ($feedback){
        $feedback->make_sticky($id, Input::get('state'));
    },

    'GET /feedback/feature/(:num)' => function($id) use ($feedback) {
        print_r($id);
    },
);
