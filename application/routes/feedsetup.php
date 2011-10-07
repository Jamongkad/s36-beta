<?php

$feedback = new Feedback;

return array(
    'GET /feedsetup/(:any)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 

        $feed_options = $feedback->display_embedded_feedback_options(Input::get('site_id'));
        return View::of_layout()->partial('contents', 'inbox/feedsetup_view', Array( 
            'feed_options'    => $feed_options
          , 'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'companyId'       => S36Auth::user()->companyid
        ));
        
    }),

    'POST /feedsetup/render_display_info' => function() use ($feedback) {
        $site_id = Input::get('site_id');
        $feed_options = $feedback->display_embedded_feedback_options($site_id);
        return View::Make('inbox/ajax_views/ajax_display_info_view', Array( 
            'feed_options' => $feed_options
        ));
    },

    'GET /feedsetup/mywidgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {  
        $company_id = S36Auth::user()->companyid;
        $user_theme = new UserTheme;
        $fetched_themes = $user_theme->fetch_themes_by_company_id($company_id);
         
        $links = Array(
            'none' => '-'
          , 'inbox' => 'Inbox'
          , 'publish' => 'Publish'
          , 'feature' => 'Feature'
          , 'delete' => 'Delete'
         );

        return View::of_layout()->partial('contents', 'inbox/mywidgets_view', Array('links' => $links, 'fetched_themes' => $fetched_themes));

    }),

    'GET /feedsetup/get_code/(:num)' => function($user_theme_id) {
        $company_id = S36Auth::user()->companyid;
        $user_theme = new UserTheme; 
        $fetched_theme = $user_theme->fetch_theme_by_id($user_theme_id, $company_id);

        $wg = new WidgetGenerator($fetched_theme);

        $wigi_data = Array(
                'init_code' => $wg->generate_init_code() 
            , 'widget_code' => $wg->generate_widget_code()
        );

        return View::make('inbox/ajax_views/ajax_getcode_view', Array('fetched_theme' => $wigi_data));
    },

    'POST /feedsetup/save_widget' => function() {
        $d = new UserTheme; 
        $d->create_theme( Input::get() );
        return Redirect::to('feedsetup/mywidgets');
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

         $widget_creation_params = new StdClass;
         $widget_creation_params->site_id    = Input::get('siteId');
         $widget_creation_params->company_id = Input::get('companyId');
         $widget_creation_params->embed_type = Input::get('embed_type');
         $widget_creation_params->type       = Input::get('type');
         $widget_creation_params->width      = Input::get('width');
         $widget_creation_params->height     = Input::get('height');
         $widget_creation_params->effect     = Input::get('effect');
         $widget_creation_params->units      = Input::get('units');
         $widget_creation_params->theme_id   = Input::get('themeId');

         $wg = new WidgetGenerator($widget_creation_params);
         if(Input::get('getJSON') == 1) { 
             //generate html code for site integration
             echo json_encode(Array(
                 'init_code'   => $wg->generate_init_code()
               , 'widget_code' => $wg->generate_widget_code()
             ));
         } else {
             //generate preview
             echo View::make('widget::widget_view_index', Array(
                 'iframe_code' => $wg->generate_iframe_code()
             ));
         }
    },

    'POST /feedsetup/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_toggle_feedbackblock(Input::get('column_name'), Input::get('feedblock_id'), $state);
    },

    'POST /feedsetup/delete_code/([0-9]+)/(\w+)' => function($user_theme_id, $widget_type) {
        DB::table('UserThemes', 'master')->where('userThemeId', '=', $user_theme_id)->delete();
    },

    'GET /feedsetup/edit_code/([0-9]+)/(\w+)' => function($user_theme_id, $widget_type) { 
        $company_id = S36Auth::user()->companyid;
        $user_theme = new UserTheme; 
        $fetched_theme = $user_theme->fetch_theme_by_id($user_theme_id, $company_id);
        $view_data = Array(
            'view' => View::make('inbox/ajax_views/ajax_editcode_view', 
                        Array(
                            'fetched_theme' => $fetched_theme
                          , 'effects_options' => DB::table('Effects', 'master')->get()
                          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
                          , 'user_theme_id' => $user_theme_id
                          , 'widget_type' => $widget_type
                          , 'company_id' => $company_id
                      ))->get()
        );

        if($fetched_theme->embed_type == 'embedded') {
            $view_data['width'] = 620;
            $view_data['height'] = 460;
        }

        if($fetched_theme->embed_type == 'modal') {
            $view_data['width'] = 300;
            $view_data['height'] = 400;
        }

        echo json_encode($view_data);
    }, 

    'POST /feedsetup/edit_code' => function() { 
        $user_theme = new UserTheme;
        $d = $user_theme->update_theme(Input::get());
        Helpers::show_data($d);
    }, 

);
