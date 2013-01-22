<?php
use \Imagine\Image\Box;
use \Imagine\Image\Point;
$company = new Company\Repositories\DBCompany;

return array(
    'POST /imageprocessing/upload_coverphoto' => array('name'=>'upload_coverphoto', 'do' => function() {
        // if the user is not logged in, return error msg.
        if( ! is_object(S36Auth::user()) ) return 'You should be logged in to do this action';
        
        $file = Input::all();
        $options = array(
              'script_url' => get_full_url().'/imageprocessing/coverphoto'
            , 'file_name'  => date("mdyhis").'.jpg'
            , 'upload_dir' => '/var/www/s36-upload-images/uploaded_images/coverphoto/'
            , 'upload_url' => get_full_url() .'/uploaded_images/coverphoto/'
            , 'param_name' => 'files'
            , 'width'      => 800
            , 'height'     => 500
            , 'image_versions' => array()
        );     

        return new JqueryFileUploader($options); 
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
        return new JqueryFileUploader($options); 
    }),
    
    // saving of cover photo in db and deletion of old cover photo.
    'POST /imageprocessing/savecoverphoto' => function() use ($company) {
        $user = S36Auth::user();
        
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $data = Input::all();
        $data['company_id'] = $user->companyid;
        return $company->update_coverphoto($data);
    },

    'POST /imageprocessing/FormImageUploader'=>array('name'=>'FormImageUploader','do'=>function(){
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
        return new JqueryFileUploader($options); 
    }),

    'GET /imageprocessing/linkpreview'=>array('name'=>'linkpreview','do'=>function(){
        $link_preview = new LinkPreview();
        $link_preview->text_crawler();
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


