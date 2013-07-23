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
            , 'image_versions' => array(
                array(
                    'max_width'     => 850,
                    'max_height'    => 500
                )
            )
        );     

        new JqueryFileUploader($options); 
    }),
    
    // saving of cover photo in db and deletion of old cover photo.
    'POST /imageprocessing/savecoverphoto' => function() use ($company, $user) {
        
        // if the user is not logged in, return error msg.
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $data = Input::all();
        $file_name = '';  // we need this default shit.
        
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        if( ! in_array($data['action'], array('change', 'reposition', 'remove')) ) return 'Invalid cover photo action';
        
        
        // deal with the uploaded image if changing coverphoto.
        if( $data['action'] == 'change' ){
            
            // upload the cover photo to where it belongs.
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
            
        }
        
        
        // set the db data for cover photo actions.
        $cover_data['change']['companyId'] = $user->companyid;
        $cover_data['change']['coverphoto_src'] = $file_name;
        $cover_data['change']['coverphoto_top'] = $data['top'];
        
        $cover_data['reposition']['companyId'] = $user->companyid;
        $cover_data['reposition']['coverphoto_top'] = $data['top'];
        
        $cover_data['remove']['companyId'] = $user->companyid;
        $cover_data['remove']['coverphoto_src'] = null;
        $cover_data['remove']['coverphoto_top'] = null;
        
        
        //save to database
        $company->update_coverphoto( $cover_data[ $data['action'] ] );
        
    },
    
    'POST /imageprocessing/upload_company_logo' => array('name'=>'upload_company_logo', 'do' => function() use ($user) {
        
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $upload_dir    = Config::get('application.uploaded_images_dir').'/uploaded_tmp/';
        $filename      = 'logo_' . $user->companyid . '.' . pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION);
        $orig_filename = $_FILES['files']['name'][0];
        
        // remove the existing logo.
        //if( file_exists($upload_dir . $filename) ) unlink($upload_dir . $filename);
        
        // remove the existing logos in our sub folders.
        if( file_exists($upload_dir . 'main/' . $filename) ) unlink($upload_dir . 'main/' . $filename);
        if( file_exists($upload_dir . 'comment/' . $filename) ) unlink($upload_dir . 'comment/' . $filename);
        
        // upload the image in tmp dir.
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_company_logo'
            , 'upload_dir' => Config::get('application.uploaded_images_dir').'/uploaded_tmp/'
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/uploaded_tmp/'
            , 'param_name' => 'files'
            , 'file_name'  => $filename
            , 'image_versions' => array(
                'main' => array(
                    'max_width'     => 300,
                    'max_height'    => 300,
                ),
                'comment' => array(
                    'max_width'     => 32,
                    'max_height'    => 32
                )
            )
        );
        
        new JqueryFileUploader($options);
        
        // remove the original upload duplicate.
        if( file_exists($upload_dir . $orig_filename) && is_file($upload_dir . $orig_filename) ) unlink($upload_dir . $orig_filename);
        
        // remove also the duplicate outside our sub folders.
        if( file_exists($upload_dir . $filename) && is_file($upload_dir . $filename) ) unlink($upload_dir . $filename);
        
    }),
    
    'POST /imageprocessing/save_company_logo' => function() use($user) {
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action'; 
        
        $filename = Input::get('basename');
        $tmp_dir  = Config::get('application.uploaded_images_dir') . '/uploaded_tmp/';
        $perm_dir = Config::get('application.uploaded_images_dir') . '/company_logos/';
        
        $main_src = $tmp_dir . 'main/' . $filename;
        $main_des = $perm_dir . 'main/' . $filename;
        
        $comment_src = $tmp_dir . 'comment/' . $filename;
        $comment_des = $perm_dir . 'comment/' . $filename;
        
        if( file_exists($main_src) && is_file($main_src) ) rename($main_src, $main_des);
        if( file_exists($comment_src) && is_file($comment_src) ) rename($comment_src, $comment_des);
        
        
        $logo_data['change']['logo'] = $filename;
        $logo_data['remove']['logo'] = null;
        
        DB::table('Company')->where('companyId', '=', $user->companyid)->update( $logo_data[ Input::get('action') ] );
    },
    
    'POST /imageprocessing/upload_admin_avatar' => function() use($user) {
        $upload_dir    = Config::get('application.uploaded_images_dir').'/uploaded_tmp/';
        $filename      = 'avatar_' . $user->userid . '.' . pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION);
        $orig_filename = $_FILES['files']['name'][0];
        
        // remove the existing admin avatar.
        if( file_exists($upload_dir . $filename) ) unlink($upload_dir . $filename);
        
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_admin_avatar'
            , 'upload_dir' => $upload_dir
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/uploaded_tmp/'
            , 'param_name' => 'files'
            , 'file_name'  => $filename
            , 'image_versions' => array(
                array(
                    'max_width'     => 48,
                    'max_height'    => 48
                )
            )
        );
        
        new JqueryFileUploader($options);
        
        // remove the original upload duplicate.
        if( file_exists($upload_dir . $orig_filename) && is_file($upload_dir . $orig_filename) ) unlink($upload_dir . $orig_filename);
    },
    
    'POST /imageprocessing/upload_avatar' => array('name'=>'upload_avatar', 'do' => function() {
        $options = array(
              'script_url' => JqueryFileUploader::get_full_url().'/imageprocessing/upload_avatar'
            , 'file_name'  => md5(uniqid()).'.jpg'
            , 'upload_dir' => Config::get('application.uploaded_images_dir').'/avatar/'
            , 'upload_url' => JqueryFileUploader::get_full_url() .'/uploaded_images/avatar/'
            , 'param_name' => 'files'
            , 'overwrite' => true
            , 'image_versions' => array(
                'small' => array(
                    'max_width'     => 48,
                    'max_height'    => 48,
                ),
                'medium' => array(
                    'max_width'     => 150,
                    'max_height'    => 150
                )
            )
        );
        $result = new JqueryFileUploader($options);
        
        //we just need the versioned images. Remove the original uploaded image
        // [no need to specify this. delete_url is doing the work already. image versions are included in deletion.]
        //unlink($options['upload_dir'].$options['file_name']);
        // [what we need to do is remove the uploaded image with original filename.]
        $orig_image = $options['upload_dir'] . $_FILES['files']['name'][0];
        if( file_exists($orig_image) && is_file($orig_image) ) unlink($orig_image);
        
        
        //remove previous upload for the current session
        // [no need to specify this. delete_url is doing the work already. image versions are included in deletion.]
        // if(Session::get('uploaded_avatar')){
        //     foreach($options['image_versions'] as $versions=>$value){
        //         unlink($options['upload_dir'].$versions.'/'.Session::get('uploaded_avatar'));
        //     }
        //     Session::put('uploaded_avatar',$options['file_name']);
        // }else{
        //     Session::put('uploaded_avatar',$options['file_name']);
        // }
    }),
    
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
                ),
                'small' => array(
                    'max_width'     => 80,
                    'max_height'    => 80
                )
            )
        );
        $result = new JqueryFileUploader($options);
        
        
        // remove the uploaded image with original filename.
        $orig_image = $options['upload_dir'] . $_FILES['files']['name'][0];
        if( file_exists($orig_image) && is_file($orig_image) ) unlink($orig_image);
    }),

    //'GET /imageprocessing/linkpreview' => array('name' => 'linkpreview', 'do' => function() {  // replaced with $_POST because $_GET has char limit.
    'POST /imageprocessing/linkpreview' => array('name' => 'linkpreview', 'do' => function() {
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
