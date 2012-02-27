<?php

return array(
    /*
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
    */

    'GET /widget/widget_loader/(:any)' => function($widget_key) {
        $wl = new WidgetLoader($widget_key);   
        return $wl->load()->render_data();
    },
    
    //these routes are used by js loaders for source construction
    'GET /widget/tab_position' => function() {
        return Helpers::tab_position_css_output();
    },
     
    'GET /widget/js_output' => function() { 
        $wl = new WidgetLoader(Input::get('widgetId'));  
        $js = new ClientRender($wl->load());
        return $js->js_output();
    },
    //end of these muthafuckas

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
