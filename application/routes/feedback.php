<?php

$feedback = new Feedback;
$category = new Category;

return array(
    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($feedback, $category) {             
        return View::of_layout()->partial('contents', 'feedback/modifyfeedback', Array(
             'feedback' => $feedback->pull_feedback_by_id($id)
           , 'categories' => $category->pull_site_categories()
        ));
    }),

    'GET /feedback/requestfeedback' => Array('before' => 's36_auth', 'do' => function() {
        print_r("Requesting Feedback"); 
    }),

    'GET /feedback/addfeedback' => Array('before' => 's36_auth', 'do' => function() {
        print_r("Adding Feedback");
    }),

    'GET /feedback/deletedfeedback' => Array('before' => 's36_auth', 'do' => function() use ($feedback) { 
        $undo_result = $feedback->fetch_deleted_feedback();
        echo "<pre>";
        echo print_r($undo_result);
        echo "</pre>";
    }),

    //Ajax Functions...
    'POST /feedback/changecat/(:num)/(:num)/(:num)/(:num)' => function($cat_id, $feed_id, $contact_id, $site_id) use ($feedback) {
        //TODO: this could be better 
        $feed_obj = Array('feedid' => $feed_id, 'siteid' => $site_id, 'contact_id' => $contact_id);

        if($cat_id == 1) {
            $feedback->_toggle_multiple('fileas', Array($feed_obj), ",isArchived = 0, categoryId = $cat_id");     
        } else {  
            $feedback->_toggle_multiple('fileas', Array($feed_obj), ",isArchived = 1, categoryId = $cat_id");     
        }
 
    },

    'POST /feedback/changestatus' => function() use ($feedback) { 
        $feedback->_change_feedback('status', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/changepriority' => function() use ($feedback) { 
        $rating_table = Array(
            'low' => 0
          , 'medium' => 60
          , 'high' => 100
        ); 
        $feedback->_change_feedback('priority', Input::get('feed_id'), $rating_table[Input::get('select_val')]);
    },

    'POST /feedback/flagfeedback' => function() use ($feedback) {  
        $feed_id = Input::get('feed_ids');
        $feedback->_change_feedback('isFlagged', $feed_id[0], Input::get('state'));
    },
     
    'POST /feedback/change_feedback_state' => function() use ($feedback) { 
        $feed_ids = Input::get('feed_ids');
        $mode     = Input::get('col');
        $state    = Input::get('state');
        
        if($state == 0) {
            $mode = 'inbox';
        }       

        $feedback->_toggle_multiple($mode, $feed_ids);
    },

    'POST /feedback/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_change_feedback(Input::get('column_name'), Input::get('feedid'), $state);
    },

    'POST /feedback/fire_multiple' => function() use ($feedback) {
        $feed_ids    = Input::get('feed_ids');
        $mode        = Input::get('col');

        if($mode == 'remove') {
            $feedback->_permanent_delete($feed_ids);
        } else {
            $feedback->_toggle_multiple($mode, $feed_ids);     
        } 

    },
    
    'GET /feedback/deletefeedback/(:num)' => function($id) use ($feedback) {
        $feedback->_change_feedback('isDeleted', $id, 1);
        $undo_result = $feedback->fetch_deleted_feedback();
        echo json_encode($undo_result);
    },

    'GET /feedback/undodelete/(:any)' => function($id) use ($feedback) {  
        if($id == "all") {
            $feedback->undo_deleted_feedback();
        } else {
            $feedback->_change_feedback('isDeleted', $id, 0);     
        } 
    },

    'GET /feedback/samplefeeds/(:any?)/(:any?)' => function($filter=False, $choice=False) use ($feedback) {

        $limit = 10;
        $site_id = False;

        $feedback = new Feedback;
        $category = new Category;
        $pagination = new ZebraPagination;

        $offset = ($pagination->get_page() - 1) * $limit;
        $records = $feedback->pull_feedback($limit, $offset, $filter, $choice, $site_id);

        echo json_encode($records);

    }
);
