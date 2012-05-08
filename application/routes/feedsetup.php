<?php
$feedback = new Feedback\Repositories\DBFeedback;
$dbw = new Widget\Repositories\DBWidget;

$form_themes = Helpers::$form_themes;
$tab_themes = Helpers::$tab_themes;
$display_themes = Helpers::$display_themes;

return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw) {
        $widgets = $dbw->fetch_widgets_by_company();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_dashboard_view', Array(
            'widgets' => $widgets
        ));
    }),

    'GET /feedsetup/widget_selection' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_widget_selection');
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

    'GET /feedsetup/edit/(:any)/([a-z]+)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth'
                                                   , 'do' => function($widget_id, $type) use ($form_themes, $display_themes) {  
        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $widget = $wl->widget_obj;
        $themes = $form_themes;
        if($widget->widget_type == 'display') {
            //TODO: this is just bad engineering
            $edit_view = 'feedsetup/feedsetup_editdisplay_view';
            $themes = $display_themes;
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
        }
        
        return View::of_layout()->partial('contents', $edit_view, Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
          , 'form_themes'     => $themes
          , 'themepicker_view' => View::make('feedsetup/partials/feedsetup_formthemes_picker_view', Array('form_themes' => $form_themes))
          , 'iframe_code'     => $wl->load_iframe_code()
          , 'js_code'         => $wl->load_widget_init_js_code()
        ));
    }),

    'GET /feedsetup/wizard/(:any)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth'
                                            , 'do' => function($widget_select=false) use ($feedback, $display_themes) { 

        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_wizard_view', Array(
            'form_themes'  => $display_themes
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'company_id'      => S36Auth::user()->companyid 
          , 'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'widget_select'   => $widget_select
        ));
    }),
    
    'GET /feedsetup/submission_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($form_themes) { 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_create_form_widget_view', Array(
            'site'             => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'company_id'       => S36Auth::user()->companyid
          , 'themepicker_view' => View::make('feedsetup/partials/feedsetup_formthemes_picker_view', Array('form_themes' => $form_themes))
        ));
    }),
    
    'POST /feedsetup/save_form_widget' => function() { 
        $form = new Widget\Entities\FormWidget;
        $form->save();
        echo json_encode(Array(
            'submit' => $form->emit()
        )); 
    },
    
    'POST /feedsetup/save_display_widget' => function() { 
        $display = new Widget\Entities\DisplayWidget;
        $form = new Widget\Entities\FormWidget; 

        $display->save();
        $form->save();
        $display->adopt($form);
        
        echo json_encode(Array(
             'display' => $display->emit()
           , 'submit' => $form->emit()
        ));     
    },

    'GET /feedsetup/formcode_manager/(:any?)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth'
                                                       , 'do' => function($id=false) use ($tab_themes) {

        $wl = new Widget\Services\WidgetLoader($id); 
        $widget = $wl->load();
        $cl = new Widget\Services\ClientRender($widget);  

        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_formcode_manager_view', Array( 
            'widget'          => $widget
          , 'widget_type'     => get_parent_class($widget)
          , 'form_themes'     => $tab_themes
          , 'loader_url'      => $cl->widget_loader_url.$widget->widgetkey
          , 'link_js_output'  => $cl->link_js_output()
          , 'link_native_output' => $cl->iframe_output()
          , 'embed_js_code'   => $wl->load_widget_init_js_code()
          , 'iframe_code'     => $wl->load_iframe_code()
        ));

    }),

    'GET /feedsetup/update_tabtype/(:any?)/(:any?)' => function($widgetkey, $tab_type) use ($dbw) {  
        //TODO: update make a better object mapper for widget objects you dickead.
        $obj = $dbw->fetch_widget_by_id($widgetkey);
        $obj->tab_type = $tab_type;
        $obj->tab_pos = Helpers::tab_position($tab_type);
        $dbw->update_widget_by_id($widgetkey, $obj);
    },

    'GET /feedsetup/delete_widget/(:any)' => function($widget_id) use ($dbw) {
        $dbw->delete_widget($widget_id);
    },

    'GET /feedsetup/generate_code/(:any)' => function($widget_key) {
         $wl = new Widget\Services\WidgetLoader($widget_key); 
         $iframe = $wl->load_iframe_code();
         echo json_encode(Array(
             'html_view' => $iframe
           , 'html_widget_js_code' => $wl->load_widget_init_js_code() 
           , 'html_iframe_code' => $iframe
           , 'height' => $wl->load()->get_height()
           , 'width' => $wl->load()->get_width()
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
        //$wf = new WidgetFactory; 
        $wf = new Widget\Services\WidgetFactory;
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
