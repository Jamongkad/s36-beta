<?php

return array(
    'GET /widget/test' => function() {
        return View::make('widget::widget_view_index');
    },

    'GET /widget/form' => function() {
        return View::make('widget::widget_form_view', array(
            'siteId'    => Input::get('siteId')
          , 'companyId' => Input::get('companyId') 
          , 'themeColor' => DB::Table('Theme', 'master')->where('themeId', '=', Input::get('themeId'))->first(array('name'))
          , 'country' => DB::Table('Country', 'master')->get()
          , 'company_name' => DB::Table('Company', 'master')->where('companyId', '=', Input::get('companyId'))->first(array('name'))
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

        $feedback = new Feedback;       
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

    'GET /widget/modal' => function() {
        #print_r(new Widget\ProfileImage);
        $feedback = new Feedback;
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

        //TODO: refactor this mothafucka!! 
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

        $fb_login = Input::get('fb_login');
        $ln_login = Input::get('ln_login');
        $x  = Input::get('x_coords');
        $y  = Input::get('y_coords');
        $wd = Input::get('wd');
        $ht = Input::get('ht');
        $src = null;


        if($fb_login == 1 || $fb_login == 2) {
            $src = fb_photo_check($fb_login, Input::get('src'));     
        }

        if($ln_login == 1) {
            $src = Input::get('src');
        }
 

        $ophoto = Input::get('oldphoto');
        
        if($ophoto != 0){
            @unlink("/var/www/s36-upload-images/uploaded_cropped/150x150/".$ophoto);
            @unlink("/var/www/s36-upload-images/uploaded_cropped/48x48/".$ophoto);		
        }

        $targ_w = $targ_h = 150;
        $jpeg_quality = 100;
                    
        if( strstr(strtolower($src),"graph.facebook.com") || strstr(strtolower($src), "media.linkedin.com") ){
            $extension = ".jpg";
        }else{
            $extension = strtolower(strrchr($src, '.'));
        }

        echo $extension;
        /*        
        switch($extension) {
            case '.jpg':
            case '.jpeg':
                $img_r150 = @imagecreatefromjpeg($src);
                $img_r48 = @imagecreatefromjpeg($src);
                break;
            case '.gif':
                $img_r150 = @imagecreatefromgif($src);
                $img_r48 = @imagecreatefromgif($src);
                break;
            case '.png':
                $img_r150 = @imagecreatefrompng($src);
                $img_r48 = @imagecreatefrompng($src);
                break;
            default:
                $img_r150 = false;
                $img_r48 = false;
                break;
        }
                    
        $dst_r150 = ImageCreateTrueColor( $targ_w, $targ_h ); 
        $dst_r48 = ImageCreateTrueColor( 48, 48 ); 
        $date = date("mdyhis");
        
        $out150 = "/var/www/s36-upload-images/uploaded_cropped/150x150/".$date."-cropped.jpg";
        $out48 = "/var/www/s36-upload-images/uploaded_cropped/48x48/".$date."-cropped.jpg";
        
        imagecopyresampled($dst_r150,$img_r150,0,0,$x,$y,$targ_w,$targ_h,$wd,$ht);
        imagejpeg($dst_r150,$out150,$jpeg_quality);
        
        imagecopyresampled($dst_r48,$img_r48,0,0,$x,$y,48,48,$wd,$ht);
        imagejpeg($dst_r48,$out48,$jpeg_quality);
        
        echo $date."-cropped.jpg";
        */

    },

    'POST /widget/form/upload' => function() { 
        $error = Null;
        $msg = Null;
        $filedir = Null;
        $width = Null;
        $file = 'your_photo';

        if(!empty($_FILES[$file]['error']))
        {
            switch($_FILES[$file]['error'])
            {

                case '1':
                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;
                case '2':
                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;
                case '3':
                    $error = 'The uploaded file was only partially uploaded';
                    break;
                case '4':
                    $error = 'No file was uploaded.';
                    break;

                case '6':
                    $error = 'Missing a temporary folder';
                    break;
                case '7':
                    $error = 'Failed to write file to disk';
                    break;
                case '8':
                    $error = 'File upload stopped by extension';
                    break;
                case '999':
                default:
                    $error = 'No error code avaiable';
            }
        }elseif(empty($_FILES[$file]['tmp_name']) || $_FILES[$file]['tmp_name'] == 'none'){
            $error = 'No file was uploaded..';
        }elseif(($_FILES[$file]['type'] != "image/jpeg") && 
                ($_FILES[$file]['type'] != "image/gif")  && 
                ($_FILES[$file]['type'] != "image/pjpeg")&& 
                ($_FILES[$file]['type'] != "image/x-png")&& 
                ($_FILES[$file]['type'] != "image/png")){
                $error = 'Please Upload Image Files Only'.$_FILES[$file]['type'];
        }else{
                                
                $filename = date("Ydmhis").$_FILES[$file]['name'];
                $filedir = "uploaded_tmp/".$filename;
                $maxwidth = 350;
                $maxheight = 230;
                $move = move_uploaded_file($_FILES[$file]['tmp_name'],"/var/www/s36-upload-images/uploaded_tmp/".$filename);
                if($move){    
                     //start image resizing..
                     $resizeObj = new Resize($filedir);
                     $resizeObj->resizeImage($maxwidth, $maxheight, 'auto');
                     $resizeObj->saveImage($filedir, 100);
                     
                     //get the optimal dimensions
                     $dims = $resizeObj->getDimensions($maxwidth, $maxheight, 'auto'); 
                     $width = $dims['optimalWidth'];
                }       
        } 

        echo json_encode(Array(
            "error" => $error
          , "dir" => $filedir
          , "wid" => $width
        ));
    }
);

//helper functions will move to seperate file later on
function fb_photo_check($fb_login, $photo_src) {    
    if($fb_login == 1) return $photo_src;
    if($fb_login == 2) return "/var/www/s36-beta/public/".$photo_src;
    
    return "/var/www/s36-beta/public/".$photo_src;
}


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
