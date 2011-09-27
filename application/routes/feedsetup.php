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

    'GET /feedsetup/generate_code' => function() {
         $base_url   = URL::to('/');
         $site_id    = Input::get('siteId');
         $company_id = Input::get('companyId');
         $form_url = $base_url."widget/form?siteId=$site_id&companyId=$company_id"; 
         
         //make this dynamic based on form options
         $widget_src = $base_url."widget/modal?siteId=$site_id&companyId=$company_id&is_published=1&is_featured=1";

         return "
                <link rel='stylesheet' type='text/css' href='{$base_url}css/s36_client_style.css' />
                <script type='text/javascript' src='{$base_url}js/s36_client_script.js'></script>
                <script type='text/javascript'>	
                        DomReady.ready(function() {
                            var siteId = $site_id;
                            var companyId = $company_id;
                            var s36_button_opts = {
                                siteId 		: siteId
                              , companyId 	: companyId
                              , form_url  : $form_url 
                            }
                            var m_option_1 = {
                                target 		: 's36m_widget_1'
                              , siteId 		: siteId
                              , companyId 	: companyId
                              , transition 	: 'fade'
                              , template 	: 'default'
                              , widget_src	: '{$widget_src}'
                            }
                            
                            var s36_button = s36_create_widget_button(s36_button_opts);
                            var m_widget_1 = s36_modal_widget(m_option_1);
                            
                        });
                </script>
                ";
    },

    'POST /feedsetup/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_toggle_feedbackblock(Input::get('column_name'), Input::get('feedblock_id'), $state);
    },
);
