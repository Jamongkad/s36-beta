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

    'GET /feedback/requestfeedback' => Array('before' => 's36_auth', 'do' => function() {
        
    }),

    'GET /feedback/addfeedback' => Array('before' => 's36_auth', 'do' => function() {
        
    }),

    'GET /feedback/deletedfeedback' => Array('before' => 's36_auth', 'do' => function() {
        
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
    
    'POST /feedback/featurefeedback' => function() use ($feedback){
        $feedback->_change_feedback('isFeatured', Input::get('feedid'), Input::get('state'));
    },
 
    'POST /feedback/publishfeedback' => function() use ($feedback){
        $feedback->_change_feedback('isPublished', Input::get('feedid'), Input::get('state'));
    },

    'GET /feedback/deletefeedback/(:num)' => function($id) use ($feedback, $user) {
        $feedback->_change_feedback('isDeleted', $id, 1);
        $undo_result = $feedback->fetched_delete_feedback($user->user()->userid);
        echo json_encode($undo_result);
    },

    'GET /feedback/undodelete/(:any)' => function($id) use ($feedback, $user) {  
        if($id == "all") {
            $feedback->undo_deleted_feedback($user->user()->userid);
        } else {
            $feedback->_change_feedback('isDeleted', $id, 0);     
        } 
    }
);
