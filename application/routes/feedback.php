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
        $feedback->_change_feedback('categoryId', $feedback_id, $cat_id);
    },

    'POST /feedback/changestatus' => function() use ($feedback) {
        $feedback->_change_feedback('status', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/changepriority' => function() use ($feedback) { 
        $feedback->_change_feedback('priority', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/flagfeedback' => function() use ($feedback) {  
        $feedback->_change_feedback('isFlagged', Input::get('feedid'), Input::get('state'));
    },
    
    'POST /feedback/makesticky' => function() use ($feedback){
        $feedback->_change_feedback('isSticked', Input::get('feedid'), Input::get('state'));
    },
 
    'POST /feedback/publishfeedback' => function() use ($feedback){
        $feedback->_change_feedback('isPublished', Input::get('feedid'), Input::get('state'));
    },

    'DELETE /feedback/deletefeedback/(:num)' => function($id) use ($feedback) {
        print_r($id);
    },

    'GET /feedback/feature/(:num)' => function($id) use ($feedback) {
        print_r($id);
    },
);
