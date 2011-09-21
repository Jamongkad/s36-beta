<?php

$feedback = new Feedback;

return array(
    'GET /feedsetup/(:any)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 

        return View::of_layout()->partial('contents', 'inbox/feedsetup_view', Array( 
            'feed_options'    => $feedback->display_embedded_feedback_options()
          , 'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->get()
          , 'companyId'       => S36Auth::user()->companyid
        ));

    }),

    'GET /feedsetup/mywidgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {  
        return View::of_layout()->partial('contents', 'inbox/mywidgets_view');
    }),

    'POST /feedsetup/save_widget' => function() {
        $d = new UserTheme; 
        echo "<pre>";
        print_r($d->createTheme( Input::get() ));
        echo "</pre>";
    },

    'GET /feedsetup/preview_widget' => function() {
        $postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com");

        if($postmark->to("danolivercalpatura@yahoo.com")->subject("36Stories Feedback Notification")->plain_message("I am the Manila Miracle Man. I need a drink...")->send()){
            echo "Message sent";
        } else {
           echo "Message not sent";
        }
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
