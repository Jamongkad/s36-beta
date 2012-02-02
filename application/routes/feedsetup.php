<?php

$feedback = new DBFeedback;

return array(
    'GET /feedsetup/all' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() {
        $dbw = new DBWidget;
        $widgets = $dbw->fetch_widgets_by_company();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_dashboard_view', Array(
            'widgets' => $widgets
        ));

    }),

    'GET /feedsetup/overview/(:any)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($type) { 
        //TODO: Paginate this motherfucka
        $dbw = new DBWidget;
        $widgets = $dbw->fetch_widgets_by($type, $limit=3, $offset=0);

        if($type == 'display') {
            $link_text = 'Display Widgets';
            $link_href = 'display_widgets';
        } else {
            $link_text = 'Submission Forms';
            $link_href = 'submission_widgets';
        }

        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_overview_view', Array(
            'overview_type' => $type
          , 'link_text' => $link_text
          , 'link_href' => $link_href
          , 'widgets' => $widgets
        ));
    }),

    'GET /feedsetup/ajax_overview/(:any)' => function($type) {
        $dbw = new DBWidget;
        $widgets = $dbw->fetch_widgets_by($type, $limit=3, $offset=0);
        Helpers::show_data($widgets);
        /*
        $view_data = Array(
            'view' => View::make('feedsetup/ajax_views/ajax_overview_view', Array('widgets' => $widgets))->get()
        );
         
        echo json_encode($view_data);
        */
    },

    'GET /feedsetup/display_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_view', Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'companyId'       => S36Auth::user()->companyid
          , 'input'           => Array(  'site_id' => null, 'company_id' => null, 'theme_name' => null, 'embed_effects' => null
                                       , 'modal_effects' => null, 'feedid' => null, 'perms' => Array(), 'theme_type' => null
                                       , 'embed_type' => null)
        )); 
    }),

    'GET /feedsetup/submission_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_form_widgets_view');
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
        $user_theme = new DBUserTheme;
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

    'GET /feedsetup/stream' => Array('name' => 'stream', 'before' => 's36_auth', 'do' => function() {   
        return View::of_layout()->partial('contents', 'inbox/stream_index_view');
    }),

    'GET /feedsetup/get_code/(:num)' => function($user_theme_id) {
        $company_id = S36Auth::user()->companyid;
        $user_theme = new DBUserTheme; 
        $fetched_theme = $user_theme->fetch_theme_by_id($user_theme_id, $company_id);

        $wg = new WidgetGenerator($fetched_theme);

        $wigi_data = Array(
                'init_code' => $wg->generate_init_code() 
            , 'widget_code' => $wg->generate_widget_code()
        );

        return View::make('inbox/ajax_views/ajax_getcode_view', Array('fetched_theme' => $wigi_data));
    },

    'POST /feedsetup/save_widget' => function() {
        /*
        $d = new DBUserTheme; 
        $d->create_theme( Input::get() );
        return Redirect::to('feedsetup/mywidgets');
        */
        $data = Input::get();

        $rules = Array(
            'theme_name' => 'required'
          , 'site_id' => 'required'
          , 'embed_type' => 'required'
          , 'perms' => 'required'
        );

        $validator = Validator::make($data, $rules);
 
        if(!$validator->valid()) {

            $json_data = Array(
                'data' => $data
              , 'errors' => $validator->errors
            );
            echo json_encode($json_data);

        } else { 

            $dbw = new DBWidget;
            $perm_factory = new Permission($data);
            $perms = $perm_factory->cherry_pick('feedbacksetupdisplay');        
            $data['perms'] = $perms;
            $data['widget_type'] = 'display';
            $dbw->save_widget( (object)$data );
        
        }
       
    },

    'GET /feedsetup/generate_code' => function() {
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
        $user_theme = new DBUserTheme; 
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
        $user_theme = new DBUserTheme;
        $d = $user_theme->update_theme(Input::get());
        Helpers::show_data($d);
    }, 

);
