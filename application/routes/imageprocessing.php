<?php
use \Imagine\Image\Box;
use \Imagine\Image\Point;

return array(
    'GET /imageprocessing'=>array('name'=>'imageprocessing','do'=>function(){
        var_dump($imagine);
    }),

    'POST /imageprocessing/upload_coverphoto'=>array('name'=>'upload_coverphoto', 'do' => function() {
        print_r(Input::all());
        /*
        $file       = 'clientLogoImg';
        $targetpath = "uploaded_images/coverphoto/";
        $options    = array(
            'width'      => 800,
            'height'     => 500
        );
        upload($file, $targetpath, $options);
        */
    }),
);

function upload($file, $targetpath="uploaded_images/coverphoto/", $options=null){

        $error      = Null;
        $msg        = Null;
        $filedir    = Null;
        $width      = Null;

        if(empty($file))        { die("Please provide a file to be uploaded");}
        if(empty($targetpath))  { die("Please set the target path for the uploaded file");}

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
            ($_FILES[$file]['type']     != "image/gif")  && 
            ($_FILES[$file]['type']     != "image/pjpeg")&& 
            ($_FILES[$file]['type']     != "image/x-png")&& 
            ($_FILES[$file]['type']     != "image/png")){
            $error = 'Please Upload Image Files Only';
        }else{
            $imagine = new \Imagine\Gd\Imagine();
            $filename     = date("Ydmhis").$_FILES[$file]['name'];
            $filedir      = $targetpath.$filename;
            $image = $imagine->open($_FILES[$file]['tmp_name']);
            if(isset($options['width']) && isset($options['height'])){
                $image->resize(new Box($options['width'], $options['height']));
            }
            $image->save($filedir, array('quality'=>100));
        }
         echo json_encode(Array(
            "error" => $error
          , "msg"   => $filedir
          , "wid"   => $width
        )); 
}
