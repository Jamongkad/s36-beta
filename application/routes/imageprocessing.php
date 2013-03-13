<?php

$company = new Company\Repositories\DBCompany;
$user = S36Auth::user();

return array(
    'POST /imageprocessing/upload_coverphoto' => array('name'=>'upload_coverphoto', 'do' => function() use ($user) {
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action'; 
        
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_coverphoto'
            , 'upload_dir' => Config::get('application.uploaded_images_dir').'/tmp/coverphoto_' . $user->companyid . '/'
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/tmp/coverphoto_' . $user->companyid . '/'
            , 'param_name' => 'files'
            , 'width'      => 800
            , 'height'     => 500
        );     

        new JqueryFileUploader($options); 
    }),
    
    'POST /imageprocessing/upload_avatar' => array('name'=>'upload_avatar', 'do' => function() {
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_avatar'
            , 'file_name'   => md5(uniqid()).'.jpg'
            , 'upload_dir' => Config::get('application.uploaded_images_dir').'/avatar/'
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/avatar/'
            , 'param_name' => 'files'
            , 'image_versions' => array(
                '48x48' => array(
                    'max_width'     => 48,
                    'max_height'    => 48,
                    'use_external_library' => True
                ),
                '150x150' => array(
                    'max_width'     => 150,
                    'max_height'    => 150,
                    'use_external_library' => True
                )
            )
        );
        new JqueryFileUploader($options); 
    }),
    
    // saving of cover photo in db and deletion of old cover photo.
    'POST /imageprocessing/savecoverphoto' => function() use ($company, $user) {
        
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $data       = Input::all();
        $tmp_dir    = Config::get('application.uploaded_images_dir').'/tmp/coverphoto_' . $user->companyid . '/';
        $file_name  = 'coverphoto_'.$user->companyid.'.jpg'; //set the final filename
        $orig_path  = $tmp_dir . $data['name'];
        $final_path = Config::get('application.uploaded_images_dir').'/coverphoto/'.$file_name;
        
        if( is_readable($final_path) ) unlink($final_path);
        exec('convert "' . $orig_path . '" "' . $final_path . '"'); //convert and rename uploaded image using image magick
        
        // delete the temporary uploads.
        $tmp_uploads = scandir( $tmp_dir );
        if( count($tmp_uploads) ){
            foreach( $tmp_uploads as $v ){
                if( $v == '.' || $v == '..' ) continue;
                unlink( $tmp_dir . $v );
            }
        }
        
        //save to database
        $company->update_coverphoto(array(
            'company_id'    =>$user->companyid,
            'file_name'     =>$file_name,
            'top'           =>$data['top']
        ));
        
    },

    'POST /imageprocessing/FormImageUploader' => array('do'=> function() {
        $options = array(
              'script_url'    => JqueryFileUploader::get_full_url().'/imageprocessing/FormImageUploader'
            , 'file_name'   => md5(uniqid()).'.jpg'
            , 'upload_dir'  => Config::get('application.uploaded_images_dir').'/form_upload/'
            , 'upload_url'  => JqueryFileUploader::get_full_url() . '/uploaded_images/form_upload/'  
            , 'image_versions' => array(
                'large' => array(
                    'max_width'     => 800,
                    'max_height'    => 1200,
                ),
                'medium' => array(
                    'max_width'     => 200,
                    'max_height'    => 200,
                    'use_external_library' => True
                ),
                'small' => array(
                    'max_width'     => 80,
                    'max_height'    => 80,
                    'use_external_library' => True
                )
            )
        );
        new JqueryFileUploader($options); 
    }),

    'GET /imageprocessing/linkpreview' => array('name' => 'linkpreview', 'do' => function() {
        $link_preview = new LinkPreview();
        $link_preview->text_crawler();
    }),

    'POST /imageprocessing/upload_hosted_background_image' => array('name' => 'upload_hosted_background_image', 'do' => function() use ($user) {

        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_hosted_background_image'
            , 'upload_dir' => Config::get('application.uploaded_images_dir').'/hosted_background/'
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/hosted_background/'
            , 'param_name' => 'files'
        );     

        new JqueryFileUploader($options);         
    }),

);
