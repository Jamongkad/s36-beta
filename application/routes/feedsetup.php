<?php

$feedback = new DBFeedback;
$dbw = new DBWidget;

return array(
    'GET /feedsetup/all' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw) {
        $widgets = $dbw->fetch_widgets_by_company();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_dashboard_view', Array(
            'widgets' => $widgets
        ));
    }),

    'GET /feedsetup/overview/(:any)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($type) use ($dbw) { 
 
        $widgy = $dbw->fetch_paginated_widgets($type);

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
          , 'widgets' => $widgy->widget
          , 'pagination' => $widgy->pagination

        ));
    }),

    'GET /feedsetup/ajax_overview/(:any?)/(:any?)' => function($type=False, $page=False) use ($dbw) {

        $widgy = $dbw->fetch_paginated_widgets($type);
 
        $view =  View::make('feedsetup/ajax_views/ajax_overview_view', Array(
            'widgets' => $widgy->widget
          , 'pagination' => $widgy->pagination
          , 'widget_type' => $type
        ))->get();

        $view_data = Array(
            'view' => $view
        );

        echo json_encode($view_data);
    },

    'GET /feedsetup/edit/([0-9]+)/([a-z]+)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($widget_id, $type) {  
        $wl = new WidgetLoader($widget_id); 
        $widget = $wl->widget_obj;
        if($widget->widgetobj->widget_type == 'display') {
            $edit_view = 'feedsetup/feedsetup_edit_view';
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
        }
        /*
        Helpers::show_data($wl);
        Helpers::show_data($edit_view);
        */
        return View::of_layout()->partial('contents', $edit_view, Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
          , 'iframe_code'     => $wl->load_iframe_code()
          , 'js_code'         => $wl->load_widget_js_code()
        ));
    }),

    'POST /feedsetup/update_widget' => function() use ($dbw) {
        $data = Input::get(); 
        $site = DB::Table('Site')->where('siteId', '=', $data['site_id'])->first(Array('domain'));
        $perm_factory = new Permission($data);
        $perms = $perm_factory->cherry_pick('feedbacksetupdisplay');        
        $data['perms'] = $perms;
        $data['widget_type'] = 'display';
        $data['site_nm'] = $site->domain;
        $dbw->update_widget_by_id($data['widgetkey'], (object)$data); 
    },

    'GET /feedsetup/display_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_createwidget_view', Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'company_id'      => S36Auth::user()->companyid 
        )); 
    }),

    'GET /feedsetup/submission_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_form_widgets_view', Array(
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'company_id'      => S36Auth::user()->companyid
        ));
    }),
     
    'POST /feedsetup/save_widget' => function() use ($dbw) {
        $data = Input::get();

        $rules = Array(
            'theme_name' => 'required'
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

            $site = DB::Table('Site')->where('siteId', '=', $data['site_id'])->first(Array('domain'));
            $perm_factory = new Permission($data);
            $perms = $perm_factory->cherry_pick('feedbacksetupdisplay');        
            $data['perms'] = $perms;
            $data['widget_type'] = 'display';
            $data['site_nm'] = $site->domain; 

            $data_object = (object)$data;
            //Helpers::show_data($data);
            if(!$widgetkey = $data['widgetkey']) {
                //save widget
                $save_result = $dbw->save_widget( $data_object );         
                echo json_encode($save_result);
            } else {
                //update widget     
                $update_result = $dbw->update_widget_by_id( $widgetkey, $data_object );
                echo json_encode( $update_result ); 
            }
        }       
    },

    'POST /feedsetup/save_form_widget' => function() use ($dbw) {
        $data = Input::get();
        $site = DB::Table('Site')->where('siteId', '=', $data['site_id'])->first(Array('domain'));  
        $data['widget_type'] = 'submit';
        $data['site_nm'] = $site->domain;
        $data['embed_type'] = 'form';
        
        $data_object = (object)$data;
        //Helpers::show_data($data);
        if(!$widgetkey = $data['widgetkey']) {
            //save widget 
            $save_result = $dbw->save_widget( $data_object );         
            echo json_encode( $save_result ); 
            //echo json_encode(Array('status' => 'save'));
        } else {
            //update widget      
            $update_result = $dbw->update_widget_by_id( $widgetkey, $data_object );
            echo json_encode( $update_result );   
            //echo json_encode(Array('status' => 'update'));
        }
    },

    'GET /feedsetup/generate_code/(:any)' => function($widget_key) {

         $wl = new WidgetLoader($widget_key); 
         $iframe = $wl->load_iframe_code();

         echo json_encode(Array(
             'html_view' => $iframe
           , 'html_widget_js_code' => $wl->load_widget_js_code() 
           , 'html_iframe_code' => $iframe
           , 'width' => $wl->widget_obj->width
           , 'height' => $wl->widget_obj->height
         ));
    },
    
    //TODO: something is wrong here...
    'GET /feedsetup/preview_widget_style/(:any)' => function($theme) {
        $width  = 447;
        $height = 590;
        $frame_url = Config::get('application.deploy_env').'/feedsetup/preview_widget/'.$theme;
        $iframe = Helpers::render_iframe_code($frame_url, $width, $height);
        $data = Array('html_view' => $iframe, 'width' => $width, 'height' => $height);
        echo json_encode($data);
    },

    'GET /feedsetup/preview_widget/(:any)' => function($theme) {
        $option = new StdClass;
        $option->site_id    = 1;
        $option->company_id = 1;
        $option->form_text  = "This is an example form";
        $option->theme_type = $theme;
        $option->widget = "form";
        $wf = new WidgetFactory($option);
        $load_widget = $wf->load_widget();
        return $load_widget->render();
    }
    
);
