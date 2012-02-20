<?php

return array(
    'GET /widget/form' => function() {

        $env = Config::get('application.env_name');
        if($env == 'dev') { 
            $fb_id = '171323469605899';
            $fb_secret = 'b60766ccb12c32c92029a773f7716be8';
        }

        if($env == 'prod') { 
            $fb_id = '259670914062599';
            $fb_secret = '8e0666032461a99fb538e5f38ac7ef93';
        }

        return View::make('widget::widget_form_view', array(
            'siteId'    => Input::get('siteId')
          , 'companyId' => Input::get('companyId') 
          , 'response' => Input::get('response')
          , 'themeColor' => DB::Table('Theme', 'master')->where('themeId', '=', Input::get('themeId'))->first(array('name'))
          , 'country' => DB::Table('Country', 'master')->get()
          , 'company_name' => DB::Table('Company', 'master')->where('companyId', '=', Input::get('companyId'))->first(array('name'))
          , 'fb_app_id' => $fb_id  
          , 'env' => $env
        ));
    },

    'GET /widget/widget_loader/(:any)' => function($widget_key) {
        $wl = new WidgetLoader($widget_key);   
        return $wl->render("view");
    },

    'GET /widget/js_output' => function() { 
        $widget_id = Input::get('widgetId');
        $wl = new WidgetLoader($widget_id); 
        
        $tab_type = null;
        $tab_pos = null;
        if($wl->widget_obj->widgettype == 'submit') { 
            $tab_type = $wl->widget_obj->widgetobj->tab_type;
            $tab_pos = $wl->widget_obj->widgetobj->tab_pos;
        }

        $data = Array(
            'deploy_url' => Config::get('application.deploy_env')
          , 'width' => $wl->widget_obj->width
          , 'height' => $wl->widget_obj->height
          , 'widgettype' => $wl->widget_obj->widgettype
          , 'widgetkey' => $wl->widget_obj->widgetkey
          , 'tab_type' => $tab_type
          , 'tab_pos' => $tab_pos
        );
        return View::make('widget::widget_js_output', $data);
    },

    'GET /widget/form/crop' => function() { 
        $img_upload = (object)Input::get();
        $profile_img = new Widget\ProfileImage();
        $profile_img->crop($img_upload);     
    },

    'POST /widget/form/upload' => function() { 
        $profile_img = new Widget\ProfileImage();
        $profile_img->upload();
    },

    'GET /widget/profile' => function() {
        $tests = (object)Input::get();
        $profile_img = new Widget\ProfileImage($tests);
        Helpers::show_data($profile_img);    
    },
);

function getRightClass($units){
    if($units == '1'){
        $class = "g1of1";
    }elseif($units == '2'){
        $class = "g1of2";
    }elseif($units == '3'){
        $class = "g1of3";
    }elseif($units == '4'){
        $class = "g1of4";
    }elseif($units == '5'){
        $class = "g1of5";
    }
    return $class;
}
