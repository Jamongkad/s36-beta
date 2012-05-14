<?php namespace Company\Services;

use Input, Exception, Helpers, StdClass;
use Company\Repositories\DBCompany;

class CompanySettings {
    
    private $files;

    public function upload_companylogo($files)  {
        $this->files = $files; 
        $filename = $this->files['your_photo']['name'];
        $upload_dir = "/var/www/s36-upload-images/uploaded_tmp/";
        if($this->files['your_photo']['name']) { 
            if($this->files['your_photo']['error'] > 0) {
                echo "Return Code: " . $this->files['your_photo']['error'] . "<br/>";
            } else if(file_exists($upload_dir.$filename)) {
                echo $filename . " already exists.";
            } else {
                $move = move_uploaded_file($this->files['your_photo']['tmp_name'], $upload_dir.$filename);           
                if($move) {
                    list($width, $height, $type, $attr, $mime) = getimagesize($upload_dir.$filename);
                    Helpers::dump($width);    
                    Helpers::dump($height);
                    Helpers::dump($type);
                    Helpers::dump($attr);
                    Helpers::dump($mime);

                } 
            }
        } else {
            echo "No photo";
        }
    }
}
