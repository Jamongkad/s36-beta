<?php namespace Company\Services;

use Input, Helpers;
use Exception, StdClass;
use Company\Repositories\DBCompany;
//use Feedback\Repositories\DBSocialFeedback;
//use Feedback\Repositories\TWFeedback; 
use \Feedback\Services\SocialFeedback;

use Imagine;

class CompanySettings {
    
    private $files, $filename, $errors;

    public function __construct($company_id = null) {
        $this->upload_dir  = "/var/www/s36-upload-images/uploaded_tmp/";
        $this->company_dir = "/var/www/s36-upload-images/company_logos/";
        $this->dbcompany   = new DBCompany;
        $this->company_id = $company_id;
        //$this->twitter     = new TWFeedback;  
    }

    public function upload_companylogo($files)  {
        
        $this->files = $files; 
        $filename = $this->files['your_photo']['name'];
        $final_file = $this->upload_dir.$filename;
        $valid_filetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/png');

        //check if photo is a part of the files array
        if($filename) { 
            
            // check the file type.
            if( ! in_array($this->files['your_photo']['type'], $valid_filetypes) ){
                $this->errors = 'Invalid file type.';
            }
            
            if($this->files['your_photo']['error'] > 0) {
                $this->errors = "Return Code: " . $this->files['your_photo']['error'];
            }else if( file_exists($final_file) or file_exists($this->company_dir.$filename) ) {
                // no need for this error.
                //$this->errors = $filename . " already exists.";    
            } else {

                $move_attempt = move_uploaded_file($this->files['your_photo']['tmp_name'], $final_file);           

                if($move_attempt) { 
                    $imagine = new Imagine\Gd\Imagine();
                    $size = new Imagine\Image\Box(250, 180);
                    $mode = Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    // rename the logo file to avoid overwriting of files.
                    $logo_filename = 'logo_' . $this->company_id . '.' . pathinfo($filename, PATHINFO_EXTENSION);

                    $imagine->open($final_file)
                            ->thumbnail($size, $mode)
                            //->save($this->company_dir.$filename, Array('quality' => 100));
                            ->save($this->company_dir . $logo_filename, Array('quality' => 100));

                    unlink($final_file);     
                    $this->filename = $logo_filename;
                }
            }
        }     

    }

    public function save_companysettings() {
        if($this->errors == False) { 
            $post_data = (object)Input::get();
            //if a new file has been uploaded
            if($this->filename) {
                if($post_data->logo) {
                    unlink($this->company_dir.$post_data->logo);          
                } 
                $post_data->logo = $this->filename;  
            } 
            
            $this->dbcompany->update_companyinfo($post_data);
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
