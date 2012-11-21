<?php
use \Imagine\Image\Box;
use \Imagine\Image\Point;
$company = new Company\Repositories\DBCompany;

return array(
    'POST /imageprocessing/upload_coverphoto' => array('name'=>'upload_coverphoto', 'do' => function() {
        $file = Input::all();
        $options    = array(
            'width'      => 800
          , 'height'     => 500
          , 'targetpath' => 'uploaded_images/coverphoto/'
        );
        upload($file['clientLogoImg'], $options);
    }),

    'POST /imageprocessing/savecoverphoto' => function() use ($company) { 
        $data = Input::all();
        $user = S36Auth::user();
        $data['company_id'] = $user->companyid;
        //$company->update_coverphoto($data);
        echo json_encode($data);
    }
);

function upload($file, $options=null){

    $error      = Null;
    $msg        = Null;
    $filedir    = Null;

    if(empty($file)) { die("Please provide a file to be uploaded");}
    if(empty($options['targetpath'])) { die("Please set the target path for the uploaded file");}

    if(!empty($file['error']))
    {
      switch($file['error'])
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
        default:
          $error = 'No error code avaiable';
      }
    } elseif(empty($file['tmp_name']) || $file['tmp_name'] == 'none') {
        $error = 'No file was uploaded..';
    } else {
        $imagine = new \Imagine\Gd\Imagine();
        $filename     = date("Ydmhis").'-'.$file['name'];
        $filedir      = $options['targetpath'].$filename;
        $image = $imagine->open($file['tmp_name']);
        if(isset($options['width']) && isset($options['height'])){
            $image->resize(new Box($options['width'], $options['height']));
        }
        $image->save($filedir, array('quality'=>100));
    }

    echo json_encode(Array(
        "error" => $error
      , "msg"   => $filedir
    )); 
}
