<?php namespace Company\Services;

use Input, Exception, Helpers, StdClass;
use Company\Repositories\DBCompany;

class CompanySettings {
    
    private $files;

    public function upload_companylogo($files)  {
        $this->files = $files; 
        $filename = $this->files['your_photo']['name'];
        $upload_dir = "/var/www/s36-upload-images/uploaded_tmp/";
        $final_file = $upload_dir.$filename;

        //check if photo is a part of the files array
        if($filename) { 
            if($this->files['your_photo']['error'] > 0) {
                echo "Return Code: " . $this->files['your_photo']['error'] . "<br/>";
            } else if(file_exists($final_file)) {
                echo $filename . " already exists.";
            } else {
                $move = move_uploaded_file($this->files['your_photo']['tmp_name'], $final_file);           
                if($move) {
                    $imagesize = getimagesize($final_file);
                    Helpers::dump($imagesize);
                    list($width, $height, $type, $attr) = $imagesize;

                    if($width !== 250 and $height !== 180) {
                        echo "Company logo is not the right size. Please adjust it to 250px width and 180px height.";
                    } else {
                        if(!copy($final_file, "/var/www/s36-upload-images/company_logos/".$filename)) {
                            echo "Failed to copy file to company logo folder"; 
                        }
                    }              

                    unlink($final_file);
                } 
            }
        } else {
            echo "No photo";
        }
    }
}
