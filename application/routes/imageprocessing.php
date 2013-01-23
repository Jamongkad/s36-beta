<?php

$company = new Company\Repositories\DBCompany;
$user = S36Auth::user();

return array(
    'POST /imageprocessing/upload_coverphoto' => array('name'=>'upload_coverphoto', 'do' => function() use ($user) {
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action'; 

        $options = array(
              'script_url' => get_full_url().'/imageprocessing/upload_coverphoto'
            //, 'file_name'  => date("mdyhis").'.jpg'
            , 'file_name'  => 'sample.jpg'
            //, 'overwrite'  => true;
            , 'upload_dir' => '/var/www/s36-upload-images/uploaded_images/coverphoto/'
            , 'upload_url' => get_full_url() .'/uploaded_images/coverphoto/'
            , 'param_name' => 'files'
            , 'width'      => 800
            , 'height'     => 500
            , 'image_versions' => array()
        );     

        new JqueryFileUploader($options); 
    }),

    'POST /imageprocessing/upload_avatar' => array('name'=>'upload_avatar', 'do' => function() {
        $options = array(
              'script_url' => get_full_url().'/imageprocessing/upload_avatar'
            , 'file_name'  => date("mdyhis").'.jpg'
            , 'upload_dir' => 'uploaded_images/avatar/'
            , 'upload_url' => get_full_url() .'/uploaded_images/avatar/'
            , 'param_name' => 'files'
            , 'image_versions' => array(
                '48x48' => array(
                    'max_width'     => 48,
                    'max_height'    => 48,
                ),
                '150x150' => array(
                    'max_width'     => 150,
                    'max_height'    => 150
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
        $file_name  = 'coverphoto_'.$user->companyid.'.jpg'; //set the final filename
        $orig_path  = Config::get('application.uploaded_images_dir').'/coverphoto/'.$data['name'];
        $final_path = Config::get('application.uploaded_images_dir').'/coverphoto/'.$file_name;

        if(file_exists($final_path)){
            unlink($final_path);
        }
        exec("convert {$orig_path} {$final_path}"); //convert and rename uploaded image using image magick
        unlink($orig_path);
        //save to database
        $company->update_coverphoto(array(
            'company_id'    =>$user->companyid,
            'file_name'     =>$file_name,
            'top'           =>$data['top']
        ));
    },

    'POST /imageprocessing/FormImageUploader'=>array('name' => 'FormImageUploader', 'do'=> function() {
        $options = array(
            'script_url'    => get_full_url().'/imageprocessing/FormImageUploader'
            , 'file_name'  => date("mdyhis").'.jpg'
            , 'upload_dir'  => 'uploaded_images/form_upload/'
            , 'upload_url'  => get_full_url() . '/uploaded_images/form_upload/'  
            , 'image_versions' => array(
                'large' => array(
                    'max_width'     => 800,
                    'max_height'    => 1200,
                ),
                'medium' => array(
                    'max_width'     => 350,
                    'max_height'    => 600,
                ),
                'small' => array(
                    'max_width'     => 80,
                    'max_height'    => 80
                )
            )
        );
        new JqueryFileUploader($options); 
    }),

    'GET /imageprocessing/linkpreview'=>array('name' => 'linkpreview', 'do' => function() {
        $link_preview = new LinkPreview();
        $link_preview->text_crawler();
    }),

    'POST /imageprocessing/upload_hosted_background_image' => array('name' => 'upload_hosted_background_image', 'do' => function() use ($user) {

        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $options = array(
              'script_url' => get_full_url().'/imageprocessing/upload_hosted_background_image'
            , 'file_name'  => date("mdyhis").'-'.$user->companyid.'.jpg'/*'company_background_image_' . $user->companyid . '.jpg'*/
            , 'upload_dir' => '/var/www/s36-upload-images/uploaded_images/hosted_background/'
            , 'upload_url' => get_full_url() .'/uploaded_images/hosted_background/'
            , 'param_name' => 'files'
            , 'image_versions' => array()
        );     

        new JqueryFileUploader($options);         
    }),

);

/*additional methods*/
function get_full_url() {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    return
        ($https ? 'https://' : 'http://').
        (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
        ($https && $_SERVER['SERVER_PORT'] === 443 ||
        $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
}


