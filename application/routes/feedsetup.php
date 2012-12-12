<?php
$feedback = new Feedback\Repositories\DBFeedback;
$dbw = new Widget\Repositories\DBWidget;
$hosted = new Widget\Repositories\DBHostedSettings;
$widget_themes = new Widget\Repositories\DBWidgetThemes;
$themes = new Themes\Repositories\DBThemes; 
$company_name = Config::get('application.subdomain');
$tab_themes  = \Helpers::$tab_themes;

return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw, $hosted) {
        $widgets = $dbw->fetch_widgets_by_company();
        $hosted->set_hosted_settings(Array('companyId'  =>  S36Auth::user()->companyid));
            
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_index_view', Array(
            'widgets' => $widgets, 'hosted_full_page' => $hosted->hosted_settings()
        ));
    }),

    'GET /feedsetup/widget_selection' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw) { 
        $single_submit_widget = $dbw->fetch_single_submission_widget();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_widget_selection', Array('single_submit_widget' => $single_submit_widget));
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
        ))->get();

        $view_data = Array(
            'view' => $view
        );

        echo json_encode($view_data);
    },

    'GET /feedsetup/edit/(:any)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($widget_id) use ($widget_themes) { 

        $wl = new Widget\Services\WidgetLoader($widget_id); 
        $widget = $wl->widget_obj;

        $widget_themes->build_menu_structure();

        if($widget->widget_type == 'display') {
            $edit_view = 'feedsetup/feedsetup_editdisplay_view';
            $theme_type = $widget->theme_type;
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
            $theme_type = explode("-", $widget->theme_type);
            $theme_type = $theme_type[1];
        }
        
        $form_render = Null;
        if($widget->formstructure) {
            $data = Array('form_structure' => $widget->formstructure);
            $form_render = new Widget\Services\Formbuilder\Formbuilder($data);    
            $form_render = $form_render->generate_html();
        }

        return View::of_layout()->partial('contents', $edit_view, Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
          , 'iframe_code'     => $wl->load_iframe_code()
          , 'js_code'         => $wl->load_widget_init_js_code()
          , 'themes'        =>  $widget_themes->perform()->collection
          , 'themes_parent' => $widget_themes->get_parent($theme_type)
          , 'main_themes'   => $widget_themes->main_themes()
        ));

    }),

    'GET /feedsetup/wizard/(:any)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth'
                                            , 'do' => function($widget_select=false) use ($feedback, $widget_themes) { 

        $widget_themes->build_menu_structure();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_wizard_view', Array(
            'themes' =>  $widget_themes->perform()->collection
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'company_id'      => S36Auth::user()->companyid 
          , 'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'widget_select'   => $widget_select
          , 'main_themes' => $widget_themes->main_themes()
        ));
    }),
    
    'GET /feedsetup/submission_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($widget_themes) { 

        $widget_themes->build_menu_structure();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_create_form_widget_view', Array(
            'site'             => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'company_id'       => S36Auth::user()->companyid
          , 'themes'      =>  $widget_themes->perform()->collection
          , 'main_themes' => $widget_themes->main_themes()
        ));
    }),

    'GET /feedsetup/hosted_widgets' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($feedback, $widget_themes) {
       
        $widget_themes->build_menu_structure();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_hosted_wizard_view', Array(  
            'themes' =>  $widget_themes->perform()->collection
          , 'company_id' => S36Auth::user()->companyid 
          , 'main_themes' => $widget_themes->main_themes()
        ));
    }),

    'GET /feedsetup/hosted_editor/([0-9]+)' => function($company_id) use ($hosted, $widget_themes, $themes) { 

        $hosted->set_hosted_settings(Array('companyId'  =>  $company_id));
        $widget_themes->build_menu_structure();
        $hosted_settings = $hosted->hosted_settings();
        $themes = $themes->get_themes();
        
        Helpers::dump($hosted_settings);
 
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_hosted_edit_view', Array( 
            'themes' => $themes
          , 'hosted_full_page' => $hosted_settings 
          //'themes' => $widget_themes->perform()->collection
          //,'themes_parent' => $widget_themes->get_parent($hosted_settings->theme_type)
          //,'main_themes' => $widget_themes->main_themes()
        ));
    },

    'POST /feedsetup/update_hosted_settings' => Array('name' => 'update_hosted_settings', 'before' => 's36_auth', 'do' => function() use ($hosted,$company_name) { 
      $company = new \Company\Repositories\DBCompany;
      $company_info = $company->get_company_info($company_name);
      $hosted->set_hosted_settings(Array('companyId'  =>  $company_info->companyid));
      $hosted_settings = $hosted->hosted_settings();
      $input = Input::get();
      $input['background_image'] = $hosted_settings->background_image;
      if(isset($_FILES['hosted_background']) && !empty($_FILES['hosted_background']['name'])){
        $file       = 'hosted_background';
        $targetpath = "uploaded_images/hosted_background/";
        $options    = array('rename'=>S36Auth::user()->companyid);
        $result     = json_decode(\Helpers::upload_image($file,$targetpath,$options));
        $input['background_image'] = $result->filename;
      }
        $hosted->set_hosted_settings($input);
        $hosted->save();
        return Redirect::to('feedsetup');  
    }),
    
    'POST /feedsetup/save_form_widget' => function() { 
       
        $form_data = new Widget\Entities\FormValueObject(Input::get());

        $form = new Widget\Entities\FormWidget;
        $form->set_widgetdata($form_data->data()); 
        $form->save();
        echo json_encode(Array(
            'submit' => $form->emit()
        ));  
        
    },

    'GET /feedsetup/load_formbuilder/(:any?)' => function($widget_key) {     

        $wl = new Widget\Services\WidgetLoader($widget_key); 
        $widget = $wl->widget_obj;

        if($formstructure = $widget->formstructure) {
            $data = Array('form_structure' => $formstructure);
            $form_render = new Widget\Services\Formbuilder\Formbuilder($data);
            return $form_render->render_json();
        }
    },

    'POST /feedsetup/buildmetadata_options' => function() { 
        if(Input::has('frmb') and Input::has('form_id')) {
            $form = new Widget\Services\Formbuilder\Formbuilder(Input::get());
            $data = $form->get_encoded_form_array();

            $metadata_exists = DB::table('WidgetFormMetadata', 'master')
                                   ->where('widgetStoreId', '=', Input::get('form_id'))->first();

            if(!$metadata_exists) { 
                return DB::table('WidgetFormMetadata', 'master')->insert(Array(
                    'widgetStoreId' => Input::get('form_id')
                  , 'companyId'     => Input::get('company_id')
                  , 'formStructure' => $data['form_structure']
                ));
            } else {                
                return DB::table('WidgetFormMetadata', 'master')
                           ->where('widgetStoreId', '=', Input::get('form_id'))
                           ->where('companyId', '=', Input::get('company_id'))
                           ->update(array('formStructure' => $data['form_structure']));
            }
        } else {
            return DB::table('WidgetFormMetadata', 'master')
                       ->where('widgetStoreId', '=', Input::get('form_id'))
                       ->delete();
        } 
    },
    
    'POST /feedsetup/save_display_widget' => function() {  

        $display_data = new Widget\Entities\DisplayValueObject(Input::get());
        $form_data    = new Widget\Entities\FormValueObject(Input::get());

        $display = new Widget\Entities\DisplayWidget;
        $display->set_widgetdata($display_data->data());

        $form = new Widget\Entities\FormWidget; 
        $form->set_widgetdata($form_data->data());

        $display->save();
        $form->save();
        $display->adopt($form);
        
        echo json_encode(Array(
             'display' => $display->emit()
           , 'submit' => $form->emit()
        ));     
    },

    'GET /feedsetup/formcode_manager/(:any?)' => Array(  'name' => 'feedsetup', 'before' => 's36_auth'
                                                       , 'do' => function($id=false) use ($tab_themes, $widget_themes) {

        $wl = new Widget\Services\WidgetLoader($id); 
        $widget = $wl->load();
        $cl = new Widget\Services\ClientRender($widget);  

        $widget_themes->build_menu_structure();
        $widget_themes->build_tab_themes();

        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_formcode_manager_view', Array( 
            'widget'          => $widget
          , 'widget_type'     => get_parent_class($widget)
          , 'form_themes'     => $widget_themes->perform()->tab_themes
          , 'themes'          => $widget_themes->perform()->collection
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
