<?php

$feedback = new Feedback;

return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/feedsetup_view');
    }),

    'GET /feedsetup/displaysetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {  
        return View::of_layout()->partial('contents', 'inbox/displaysetup_view');
    }),

    'GET /feedsetup/displaypreview' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'inbox/displaypreview_view');
    }),

    'GET /feedsetup/displayfeedback' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) {     
        return View::of_layout()->partial('contents', 'inbox/displayfeedback_view', Array(
            'feed_options' => $feedback->display_embedded_feedback_options()
        ));
    }),

    'POST /feedsetup/toggle_feedback_display' => function() use ($feedback) {

        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_toggle_feedbackblock(Input::get('column_name'), Input::get('feedblock_id'), $state);

    }
);
