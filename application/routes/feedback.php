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
        
    }),

    'GET /feedback/addfeedback' => Array('before' => 's36_auth', 'do' => function() {
        
    }),

    'GET /feedback/deletedfeedback' => Array('before' => 's36_auth', 'do' => function() use ($feedback) { 
        $undo_result = $feedback->fetch_deleted_feedback();
        echo "<pre>";
        echo print_r($undo_result);
        echo "</pre>";
    }),

    //Ajax Functions...
    'GET /feedback/changecat' => function() use ($feedback) {
        $feedback_id = Input::get('feedid');
        $cat_id = Input::get('catid');
        $feedback->_change_feedback('categoryId', $feedback_id, $cat_id);
    },

    //TODO: Duplicate code find a way to abstract this
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
        $feedback->_change_feedback('isFlagged', Input::get('feedid'), Input::get('state'));
    },
    
    'POST /feedback/featurefeedback' => function() use ($feedback){
        $feedback->_change_feedback('isFeatured', Input::get('feedid'), Input::get('state'));
    },
 
    'POST /feedback/publishfeedback' => function() use ($feedback){
        $feedback->_change_feedback('isPublished', Input::get('feedid'), Input::get('state'));
    },

    'POST /feedback/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_change_feedback(Input::get('column_name'), Input::get('feedid'), $state);
    },

    'POST /feedback/fire_multiple' => function() use ($feedback) {

        $feed_ids = Input::get('feed_ids');
        $mode     = Input::get('col');
        $feedback->_toggle_multiple($mode, $feed_ids);
        /*
        $currentUrl = preg_match('~index.php/([A-Za-z0-9|/]+)~', Input::get('curl'), $match) ;
        $currentUrl = explode('/', $match[1]);
        $filter = (array_key_exists(1, $currentUrl)) ? $currentUrl[1] : False;
        $choice = (array_key_exists(2, $currentUrl)) ? $currentUrl[2] : False;
        
        $limit = 10;
        $site_id = False;

        if(Input::get('limit')) $limit = (int)Input::get('limit');
        if(Input::get('site_id')) $site_id = (int)Input::get('site_id');

        $feedback = new Feedback;
        $pagination = new ZebraPagination;

        $offset = ($pagination->get_page() - 1) * $limit;

        $records = $feedback->pull_feedback($limit, $offset, $filter, $choice, $site_id);

        $pagination->records($records->total_rows);
        $pagination->records_per_page($limit);
  
        echo $records;
        */
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
