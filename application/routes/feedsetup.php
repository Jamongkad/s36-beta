<?php

$feedback = new DBFeedback;
$dbw = new DBWidget;
//TODO: DO SOMETHING ABOUT THIS!!
$form_themes = array(
    'aglow'=>'Aglow'
  , 'silver'=>'Silver'
  , 'chrome'=>'Chrome'
  , 'classic'=>'Classic'
  , 'black'=>'Black'
  , 'silver-gray'=>'Silver Gray'
  , 'ocean-blue'=>'Ocean Blue'
  , 'forest-green'=>'Forest Green'
  , 'mandarin'=>'Mandarin'
  , 'sleek-orange'=>'Sleek Orange'
  , 'thin-red'=>'Thin Red'
);

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

    'GET /feedsetup/edit/([0-9]+)/([a-z]+)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($widget_id, $type) use ($form_themes) {  
        $wl = new WidgetLoader($widget_id); 
        $widget = $wl->widget_obj;
        if($widget->widget_type == 'display') {
            //TODO: this is just bad engineering
            $edit_view = 'feedsetup/feedsetup_editdisplay_view';
            $form_themes = Array( 
                'aglow'=>'Aglow'
              , 'silver'=>'Silver'
              , 'chrome'=>'Chrome'
              , 'classic'=>'Classic'
            );
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
        }
        
        return View::of_layout()->partial('contents', $edit_view, Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
          , 'form_themes'     => $form_themes
          , 'iframe_code'     => $wl->load_iframe_code()
          , 'js_code'         => $wl->load_widget_js_code()
        ));
    }),
    
    'GET /feedsetup/display_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback) { 
        $form_themes = Array( 
            'aglow'=>'Aglow'
          , 'silver'=>'Silver'
          , 'chrome'=>'Chrome'
          , 'classic'=>'Classic'
        );
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_create_display_widget_view', Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'company_id'      => S36Auth::user()->companyid 
          , 'form_themes'     => $form_themes
        )); 
    }),

    'GET /feedsetup/submission_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($form_themes) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_create_form_widget_view', Array(
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'form_themes'     => $form_themes
        ));
    }),
     
    'POST /feedsetup/save_widget' => function() {
        $wdm = new WidgetDataManager;
        $wdm->create_and_save_widget();
    },

    'GET /feedsetup/delete_widget/([0-9]+)' => function($widget_id) use ($dbw) {
        $dbw->delete_widget($widget_id);
    },

    'GET /feedsetup/generate_code/(:any)' => function($widget_key) {

         $wl = new WidgetLoader($widget_key); 
         $iframe = $wl->load_iframe_code();

         echo json_encode(Array(
             'html_view' => $iframe
           , 'html_widget_js_code' => $wl->load_widget_js_code() 
           , 'html_iframe_code' => $iframe
         ));

    },
    
    //TODO: something is wrong here...
    'GET /feedsetup/preview_widget_style/(:any)' => function($theme) {
        $width  = 447;
        $height = 590;       
        //frame url to insert into fucking iframe...sigh the work arounds we must doooooooooo
        $frame_url = Config::get('application.deploy_env').'/feedsetup/preview_widget/'.$theme
                                                          .'?submit_form_text='.Input::get('submit_form_text').'&submit_form_question='.Input::get('submit_form_question');
        $iframe = Helpers::render_iframe_code($frame_url, $width, $height);
        $data = Array('html_view' => $iframe, 'width' => $width, 'height' => $height);
        echo json_encode($data); 
    },
    
    //this muthafucka gets called by JS code
    'GET /feedsetup/preview_widget/(:any?)' => function($theme=false) {
        $wf = new WidgetFactory;
        $option = new StdClass;
        $option->site_id    = 1;
        $option->company_id = 1;
        $option->submit_form_text = Input::get('submit_form_text');
        $option->submit_form_question  = Input::get('submit_form_question');
        $option->theme_type = ($theme=='undefined') ? 'form-aglow' : $theme;
        $option->widget = 'form';
        $option->widgetkey = 'sample';  
        $option->tab_type = 'tab-l-aglow';
        $option->tab_pos  = 'l';
        $load_widget = $wf->load_widget($option);
        return $load_widget->render_data();
    },
);
