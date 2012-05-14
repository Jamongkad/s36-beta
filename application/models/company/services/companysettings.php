<?php namespace Company\Services;

use Input, Exception, Helpers, StdClass;
use Company\Repositories\DBCompany;

class CompanySettings {
    
    private $files, $filename, $errors;

    public function upload_companylogo($files)  {

        $this->files = $files; 
        $filename = $this->files['your_photo']['name'];
        $upload_dir = "/var/www/s36-upload-images/uploaded_tmp/";
        $company_dir = "/var/www/s36-upload-images/company_logos/";
        $final_file = $upload_dir.$filename;

        //check if photo is a part of the files array
        if($filename) { 
            if($this->files['your_photo']['error'] > 0) {
                $this->errors = "Return Code: " . $this->files['your_photo']['error'];
            } else if(file_exists($final_file) or file_exists($company_dir.$filename)) {
                $this->errors = $filename . " already exists.";
            } else {
                $move_attempt = move_uploaded_file($this->files['your_photo']['tmp_name'], $final_file);           
                if($move_attempt == True) {
                    $imagesize = getimagesize($final_file);
                    list($width, $height, $type, $attr) = $imagesize;

                    if($width !== 250 and $height !== 180) {
                        $this->errors = "Company logo is not the right size. Please adjust it to 250px width and 180px height.";
                        unlink($final_file);
                    } else {
                        if(!copy($final_file, "/var/www/s36-upload-images/company_logos/".$filename)) {
                            $this->errors = "Failed to copy file to company logo folder"; 
                        } else {
                            unlink($final_file);     
                            $this->filename = $filename;
                        } 
                    }              
                } 
            }
        }     
    }

    public function save_companysettings() {
        if($this->errors == False) { 
            //if no errors then let's save to DB
            $post_data = (object)Input::get();
            if($this->filename) {
                $post_data->logo = $this->filename;     
            }
             
            $db = new DBCompany;
            $db->save_settings($post_data);
        }
    }

    public function get_errors() { 
        if($this->errors)     
            return $this->errors;
    }

    public function get_filename() {
        if($this->filename)     
            return $this->filename;
    }
}
