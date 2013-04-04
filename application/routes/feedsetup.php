<?php
$feedback = new Feedback\Repositories\DBFeedback;
$dbw = new Widget\Repositories\DBWidget;
$hosted = new Hosted\Repositories\DBHostedSettings;
$widget_themes = new Widget\Repositories\DBWidgetThemes;
$themes = new Themes\Repositories\DBThemes; 
$company_name = Config::get('application.subdomain');
$tab_themes  = Helpers::$tab_themes;

return array(
    'GET /feedsetup' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function() use ($dbw, $hosted) {
        $widgets = $dbw->fetch_widgets_by_company();
        $hosted->set_hosted_settings(Array('company_id'  =>  S36Auth::user()->companyid));
            
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_index_view', Array(
            'widgets' => $widgets, 'hosted_full_page' => null
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

        $wl = new Widget\Services\WidgetLoader($widget_id, $load_submission_form=True); 
        $widget = $wl->widget_obj;

        $widget_themes->build_menu_structure();

        if($widget->widgettype == 'display') {
            $edit_view = 'feedsetup/feedsetup_editdisplay_view';
            $theme_type = $widget->theme_type;
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
            $theme_type = explode("-", $widget->widgetattr->theme_type);
            $theme_type = $theme_type[1];
        }
        
        return View::of_layout()->partial('contents', $edit_view, Array( 
            'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
          , 'iframe_code'     => $wl->load_iframe_code()
          , 'js_code'         => $wl->load_widget_init_js_code()
          , 'themes'          => $widget_themes->perform()->collection
          , 'themes_parent'   => $widget_themes->get_parent($theme_type)
          , 'main_themes'     => $widget_themes->main_themes()
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

        $hosted->set_hosted_settings(Array('company_id'  =>  $company_id));
        $hosted_settings = $hosted->hosted_settings();
        $themes = $themes->get_themes();  

        //$widget_themes->build_menu_structure();
        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_hosted_edit_view', Array( 
            'themes' => $themes
          , 'hosted_full_page' => $hosted_settings 
          //'themes' => $widget_themes->perform()->collection
          //,'themes_parent' => $widget_themes->get_parent($hosted_settings->theme_type)
          //,'main_themes' => $widget_themes->main_themes()
        ));
    },

    'POST /feedsetup/update_hosted_settings' => Array('name' => 'update_hosted_settings', 'before' => 's36_auth', 'do' => function() use ($hosted) {  
        $input = Input::get();
        if($input['update_background_image']=='true'){
            $file_name  = 'hosted_background_'.S36Auth::user()->companyid.'.jpg';
            $orig_path  = Config::get('application.uploaded_images_dir').'/hosted_background/'.$input['background_image'];
            $final_path = Config::get('application.uploaded_images_dir').'/hosted_background/'.$file_name;

            if(file_exists($final_path)){
                unlink($final_path);
            }
            exec("convert {$orig_path} {$final_path}"); //convert and rename uploaded image using image magick
            unlink($orig_path);
            $input['background_image'] = $file_name;
        }
        $hosted->set_hosted_settings($input);
        $hosted->save();
        return Redirect::to('feedsetup/hosted_editor/'.Input::get('company_id'));  
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

        $wl = new Widget\Services\WidgetLoader($widget_key, $load_submission_form=True); 
        $widget = $wl->widget_obj;

        if($formstructure = $widget->formstructure) {
            $data = Array('form_structure' => $formstructure);
            $form_render = new Widget\Services\Formbuilder\Formbuilder($data);
            echo $form_render->render_json();
        }
    },

    'POST /feedsetup/buildmetadata_options' => function() { 
        //lets run some validations...
        if(Input::has('frmb')) {

            $validation = Array();
            foreach(Input::get('frmb') as $controls) {
                
                if($controls['cssClass'] != 'input_text') { 
                    if(!$controls['title']) {
                        $validation[] = $controls['groupId'];
                    }

                    if($controls['values']) {  
                        foreach($controls['values'] as $elements) {
                            if(!$elements['value']) {
                                $validation[] = $elements['id'];
                            }
                        }
                    }
                } else {
                    if(!$controls['values']) {
                        $validation[] = $controls['groupId'];     
                    } 
                }
            }

            echo json_encode(Array(
                'validation' => $validation
            ));   
        }

        /*
        if(Input::has('frmb') and Input::has('form_id')) {
            $form = new Widget\Services\Formbuilder\Formbuilder(Input::get());
            $data = $form->get_encoded_form_array();

            $dbw = new Widget\Repositories\DBWidgetMetadata(Input::get('form_id'), Input::get('company_id'), $data['form_structure']);
        
            if(!$dbw->metadata_exists()) { 
                return $dbw->save();
            } else {                
                return $dbw->update();
            }
        } else {
            return $dbw->delete();
        } 
        */
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

        $wl = new Widget\Services\WidgetLoader($id, $load_submission_form=True); 
        $widget = $wl->load();
        $cl = new Widget\Services\ClientRender($widget);  

        $widget_themes->build_menu_structure();
        $widget_themes->build_tab_themes();

        return View::of_layout()->partial('contents', 'feedsetup/feedsetup_formcode_manager_view', Array( 
            'widget'          => $widget
          , 'widget_type'     => get_parent_class($widget)
          , 'form_themes'     => $widget_themes->perform()->tab_themes
          , 'themes'          => $widget_themes->perform()->collection
          , 'loader_url'      => $cl->widget_loader_url.$widget->widget_options->widgetkey
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
    'GET /feedsetup/preview_widget_style' => function() {
        $width  = 447;
        $height = 590;       
        //frame url to insert into fucking iframe...sigh the work arounds we must doooooooooo
        $frame_url = Config::get('application.deploy_env').'/feedsetup/preview_widget?submit_form_text='.Input::get('submit_form_text')
                                                                                .'&submit_form_question='.Input::get('submit_form_question');
        $iframe = Helpers::render_iframe_code($frame_url, $width, $height);
        $data = Array('html_view' => $iframe, 'width' => $width, 'height' => $height);
        return json_encode($data); 
    },
    
    //this muthafucka gets called by JS code
    'GET /feedsetup/preview_widget' => function() {
        $wf = new Widget\Services\WidgetFactory;
        $option = new StdClass;
        $option->widgetstoreid    = 1;
        $option->companyid = 1;
        $option->siteid = 1;
        $option->domain = 'https://mathew.com';
        $option->name = Config::get('application.subdomain');
        $option->widget = 'form';

        $fakewidget = new StdClass;
        $fakewidget->theme_type = 'form-aglow';
        $fakewidget->widget = 'form';
        $fakewidget->widgetkey = 'sample';  
        $fakewidget->tab_type = 'tab-l-aglow';
        $fakewidget->tab_pos  = 'l';
        $fakewidget->submit_form_text = Input::get('submit_form_text');
        $fakewidget->submit_form_question  = Input::get('submit_form_question');

        $option->widgetattr = $fakewidget;

        $load_widget = $wf->load_widget($option);
        return $load_widget->render_html();
    },
);
