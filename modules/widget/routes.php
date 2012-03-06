<?php

return array(

    'GET /widget/widget_loader/(:any)' => function($widget_key) {
        $wl = new WidgetLoader($widget_key);   
        return $wl->load()->render_data();
    },
    
    //these routes are used by js loaders for source construction
    'GET /widget/tab_position' => function() {
        echo Helpers::tab_position_css_output();
    },
     
    'GET /widget/js_output' => function() { 
        $wl = new WidgetLoader(Input::get('widgetId'));  
        $js = new ClientRender($wl->load());
        return $js->js_output();
    },
    //end of these muthafuckas

    'POST /widget/form/crop' => function() {
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
