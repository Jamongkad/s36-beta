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

    'GET /widget/embedded' => function() {
        //TODO: Consider using EffectId and fetch from DB for easier integration
        $company_id = null;
        $site_id = null;
        $is_published = 0;
        $is_featured = 0;
        
        if(Input::get('companyId')) {
            $company_id = (int)Input::get('companyId');    
        }

        if(Input::get('siteId')) {
            $site_id = (int)Input::get('siteId');   
        }
 
        if(Input::get('is_published')) {
            $is_published = (int)Input::get('is_published');      
        }
        
        if(Input::get('is_featured')) {
            $is_featured = (int)Input::get('is_featured');      
        }
       
        $params = Array(
            'company_id'   => $company_id
          , 'site_id'      => $site_id
          , 'is_published' => $is_published
          , 'is_featured'  => $is_featured
        );

        $feedback = new DBFeedback;       
        $data = $feedback->pull_feedback_by_company($params);
        $themeCSS = DB::Table('Theme', 'master')->where('themeId', '=', Input::get('themeId'))->first(array('embeddedCSS'));

        return View::make('widget::widget_embedded_view', array( 
            'feedback'   => $data
          , 'themeCSS'   => trim($themeCSS->embeddedcss)
          , 'units'		 => Input::get('units') ? Input::get('units') : 3
          , 'feedback_grid' => Input::get('units') ? getRightClass(Input::get('units')) : getRightClass(3)
          , 'transition' => Input::get('transition') ? Input::get('transition') : 'scrollVert'
          , 'speed'      => Input::get('speed') ? Input::get('speed') : 500
          , 'timeout'    => Input::get('timeout') ? Input::get('timeout') : 5000
          , 'type'       => Input::get('type') ? Input::get('type') : 'horizontal'
        ));
    },

    'GET /widget/embedded_proto/(:any)/(:any)/(:num)' => function($widget_id, $username, $company_id) {

        $dbu = new DBUser;
        $user_obj = new StdClass;
        $user_obj->username = $username;
        $user_obj->company_id = $company_id;
        $user_result = $dbu->pull_user($user_obj);

        if($user_result) { 
            $dbw = new DBWidget;
            $widget_obj = $dbw->fetch_widget_by_id($widget_id); 
            $obj = base64_decode($widget_obj->widgetobjstring);
            $obj = unserialize($obj); 

            $params = Array(
                'company_id'   => $obj->company_id
              , 'site_id'      => $obj->site_id
              , 'is_published' => 1
              , 'is_featured'  => 1
            );

            $feedback = new DBFeedback;       
            $data = $feedback->pull_feedback_by_company($params);
            $data->block_display = $obj->perms;
            return View::of_widget_layout()->partial('contents', 'widget::widget_embedded_hor_view', Array('result' => $data));
            #return View::of_widget_layout()->partial('contents', 'widget::widget_embedded_ver_view', Array('result' => $data));
        } else {
            throw new Exception("Invalid Widget paramaters!");
        }
    },

    'GET /widget/modal' => function() {
        $feedback = new DBFeedback;
        $company_id = null;
        $site_id = null;
        $is_published = 0;
        $is_featured = 0;
        $limit = 10;
        $offset = 0;
        
        if(Input::get('companyId')) $company_id = (int)Input::get('companyId'); 

        if(Input::get('siteId')) $site_id = (int)Input::get('siteId');

        if(Input::get('offset')) $offset = (int)Input::get('offset');
        
        if(Input::get('limit')) $limit = (int)Input::get('limit');   
        
        if(Input::get('is_published')) $is_published = (int)Input::get('is_published');   
        
        if(Input::get('is_featured')) $is_featured = (int)Input::get('is_featured');   
       
        $params = Array(
            'company_id'   => $company_id
          , 'site_id'      => $site_id
          , 'is_published' => $is_published
          , 'is_featured'  => $is_featured
          , 'limit'        => $limit
          , 'offset'       => $offset
        );
        
        $data = $feedback->pull_feedback_by_company($params);

        $themeCSS = DB::Table('Theme', 'master')->where('themeId', '=', Input::get('themeId'))->first(array('modalCSS'));

        return View::make('widget::widget_modal_view', array( 
            'feedback'      => $data
          , 'themeCSS'      => trim($themeCSS->modalcss)
          , 'units'		    => Input::get('units') ? Input::get('units') : 3 
          , 'transition'    => Input::get('transition') ? Input::get('transition') : 'scrollVert'
          , 'speed'         => Input::get('speed') ? Input::get('speed') : 500
          , 'timeout'       => Input::get('timeout') ? Input::get('timeout') : 5000
        ));
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
    }
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
