<?php

return array(

    'GET /widget/widget_loader/(:any)' => function($widget_key) {
        $wl = new Widget\Services\WidgetLoader($widget_key); 
        return $wl->load()->render_data();
    },
    
    //these routes are used by js loaders for source construction
    'GET /widget/tab_position' => function() {
        echo trim(Helpers::tab_position_css_output());
    },
     
    'GET /widget/js_output' => function() { 
        $wl = new Widget\Services\WidgetLoader( Input::get('widgetId') ); 
        $js = new Widget\Services\ClientRender( $wl->load() );
        return $js->js_output();
    },
    //end of these muthafuckas
    'POST /widget/form/crop' => function() {
        $img_upload = (object)Input::get();
        $profile_img = new Profile\Services\ProfileImage();
        $profile_img->crop($img_upload);     
    },

    'POST /widget/form/upload' => function() { 
        $profile_img = new Profile\Services\ProfileImage();
        $profile_img->upload();
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
