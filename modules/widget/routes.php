<?php

return array(
    'GET /widget/test' => function() {
        return View::make('widget::widget_view_index');
    },

    'GET /widget/form' => function() {
        return View::make('widget::widget_form_view', array(
            'country' => DB::Table('Country', 'master')->get()
        ));
    },

    'GET /widget/form/crop' => function() { 
    
        $x  = $_GET['x_coords'];
        $y  = $_GET['y_coords'];
        $wd = $_GET['wd'];
        $ht = $_GET['ht'];		
        $src = "/var/www/s36-beta/public/".$_GET['src'];
        $ophoto = $_GET['oldphoto'];
        
        /*
        if((strlen(trim($ophoto)) > 0) || ($ophoto == "0")){
            @unlink("/var/www/s36-upload-images/uploaded_cropped/150x150/".$ophoto);
            @unlink("/var/www/s36-upload-images/uploaded_cropped/48x48/".$ophoto);		
        }
        */

        if($ophoto != 0){
            @unlink("/var/www/s36-upload-images/uploaded_cropped/150x150/".$ophoto);
            @unlink("/var/www/s36-upload-images/uploaded_cropped/48x48/".$ophoto);		
        }

        $targ_w = $targ_h = 150;
        $jpeg_quality = 100;
                    
                    if(strstr(strtolower($src),"graph.facebook.com")){
                        $extension = ".jpg";
                    }else{
                        $extension = strtolower(strrchr($src, '.'));
                    }
                    
                    switch($extension)
                    {
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
