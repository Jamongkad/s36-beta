<?php

return array(
    
    'GET /widget/widget_loader/(:any)' => function($widget_key) {
        //only submission forms will load :(
        $wl = new Widget\Services\WidgetLoader($widget_key, $load_submission_form=True); 
        return $wl->load()->render_html();
    },
    
    //these routes are used by js loaders for source construction
    'GET /widget/tab_position' => function() {
        echo Helpers::tab_position_css_output();
    },
     
    'GET /widget/js_output' => function() { 
        $wl = new Widget\Services\WidgetLoader(Input::get('widgetId'), $load_submission_form=True); 
        $js = new Widget\Services\ClientRender($wl->load());
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
