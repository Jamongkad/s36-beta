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
        $limit = 5; 
        $pagination = new ZebraPagination; 
        $pagination->method('url');
        $pagination->base_url('/feedsetup/ajax_overview/'.$type);
    
        $widgy = widgenator($type, $limit, $pagination);

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

    'GET /feedsetup/ajax_overview/(:any?)/(:any?)' => function($type=False, $page=False) {

        $limit = 5;
        $pagination = new ZebraPagination; 
        $pagination->method('url');

        $widgy = widgenator($type, $limit, $pagination);
 
        $view =  View::make('feedsetup/ajax_views/ajax_overview_view', Array(
            'widgets' => $widgy->widget
          , 'pagination' => $widgy->pagination
        ))->get();

        $view_data = Array(
            'view' => $view
        );

        echo json_encode($view_data);
    },

    'GET /feedsetup/edit/([0-9]+)/([a-z]+)' => Array('name' => 'feedsetup', 'before' => 's36_auth', 'do' => function($widget_id, $type) { 
        $dbw = new DBWidget;
        $widget = $dbw->fetch_widget_by_id($widget_id); 
        //Helpers::show_data($widget->widgetobj);
        if($widget->widgetobj->widget_type == 'display') {
            $edit_view = 'feedsetup/feedsetup_edit_view';
        } else { 
            $edit_view = 'feedsetup/feedsetup_editform_view';
        }

        return View::of_layout()->partial('contents', $edit_view, Array( 
            'site'            => DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'effects_options' => DB::table('Effects', 'master')->get()
          , 'themes'          => DB::table('Theme', 'master')->where_in('themeId', array(1,2))->get()
          , 'company_id'      => S36Auth::user()->companyid
          , 'widget'          => $widget
        ));

    }),

    'POST /feedsetup/update_widget' => function() {
        $data = Input::get(); 
        $dbw = new DBWidget;
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
     
    'POST /feedsetup/save_widget' => function() {
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

            $dbw = new DBWidget;
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
                echo json_encode( Array('status' => 'update', 'widget' => $data_object ) ); 
            }

        }       
    },

    'POST /feedsetup/save_form_widget' => function() {
        $data = Input::get();
        $dbw = new DBWidget;
        $site = DB::Table('Site')->where('siteId', '=', $data['site_id'])->first(Array('domain'));  
        $data['widget_type'] = 'submit';
        $data['site_nm'] = $site->domain;
        Helpers::show_data( (object)$data );
        //$dbw->save_widget( (object)$data );          
    },

    'GET /feedsetup/generate_code/(:any)' => function($widget_key) {

         $wl = new WidgetLoader($widget_key); 
         $frame_url = Config::get('application.deploy_env').'/widget/widget_loader/'.$widget_key; 
         $iframe = "<span style='z-index:100001'>
                    <iframe id='s36Widget' 
                            allowTransparency='true' 
                            height={$wl->widget_obj->height}
                            width={$wl->widget_obj->width}
                            frameborder='0' 
                            scrolling='no' 
                            src='$frame_url'>Insomnia wooohooooh</iframe>
                    </span>";

         echo json_encode(Array(
             'html_view' => $iframe
           , 'html_widget_js_code' => $wl->load_widget_js_code() 
           , 'width' => $wl->widget_obj->width
           , 'height' => $wl->widget_obj->height
         ));
    },
    
);

function widgenator($type, $limit, $pagination) {  
    $dbw = new DBWidget;

    $offset = ($pagination->get_page() - 1) * $limit;

    $widgets = $dbw->fetch_widgets_by($type, $limit, $offset);

    $pagination->records($widgets->total_rows);
    $pagination->records_per_page($limit);

    $result = new stdClass;
    $result->widget = $widgets;
    $result->pagination = $pagination->render();

    return $result;
}
