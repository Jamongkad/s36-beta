<?php

$feedback = new Feedback;

return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 
        return View::of_layout()->partial('contents', 'inbox/feedsetup_view', Array( 
            'feed_options' => $feedback->display_embedded_feedback_options()
          , 'effects_options' => DB::table('Effects', 'master')->get()
        ));
    }),

    'GET /feedsetup/mywidgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {  
        return View::of_layout()->partial('contents', 'inbox/mywidgets_view');
    }),

    'POST /feedsetup/save_widget' => function() {
        print_r($_POST);
    },

    'GET /feedsetup/preview_widget' => function() {
        
    },

    'POST /feedsetup/generate_code' => function() {
        
    },

    'POST /feedsetup/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_toggle_feedbackblock(Input::get('column_name'), Input::get('feedblock_id'), $state);
    },
);
