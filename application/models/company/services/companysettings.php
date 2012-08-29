<?php namespace Company\Services;

use Input, Exception, Helpers, StdClass;
use Company\Repositories\DBCompany;
use Imagine;

class CompanySettings {
    
    private $files, $filename, $errors;

    public function __construct() {
        $this->upload_dir = "/var/www/s36-upload-images/uploaded_tmp/";
        $this->company_dir = "/var/www/s36-upload-images/company_logos/";
    }

    public function upload_companylogo($files)  {

        $this->files = $files; 
        $filename = $this->files['your_photo']['name'];
        $final_file = $this->upload_dir.$filename;

        //check if photo is a part of the files array
        if($filename) { 
            if($this->files['your_photo']['error'] > 0) {
                $this->errors = "Return Code: " . $this->files['your_photo']['error'];
            } else if(file_exists($final_file) or file_exists($this->company_dir.$filename)) {
                $this->errors = $filename . " already exists.";
            } else {

                $move_attempt = move_uploaded_file($this->files['your_photo']['tmp_name'], $final_file);           

                if($move_attempt) { 
                    $imagine = new Imagine\Gd\Imagine();
                    $size = new Imagine\Image\Box(250, 180);
                    $mode = Imagine\Image\ImageInterface::THUMBNAIL_INSET;

                    $options = Array('quality' => 100);
                    $imagine->open($final_file)
                            ->thumbnail($size, $mode)
                            ->save($this->company_dir.$filename, $options);

                    unlink($final_file);     
                    $this->filename = $filename;
                }
            }
        }     
    }

    public function save_companysettings() {
        if($this->errors == False) { 
            //if no errors then let's save to DB
            $post_data = (object)Input::get();

            //if a new file has been uploaded
            if($this->filename) {
                if($post_data->logo) {
                    unlink($this->company_dir.$post_data->logo);          
                }
               
                $post_data->logo = $this->filename;  
            } 
            
            if(!$this->is_sociallinks_empty($post_data->social_links)) {
                $post_data->social_links = $this->jsonify_sociallinks($post_data->social_links);
            } else {
                $post_data->social_links = Null;     
            }
            
            Helpers::dump($post_data);
            /*
            $db = new DBCompany;
            $db->update_companyinfo($post_data);
            */
        }
    }

    public function jsonify_sociallinks($social_links) {
        $array = array_filter($social_links, function($arr) { if($arr) return $arr; });
        return json_encode($array);
    }

    public function is_sociallinks_empty($social_links) {
        foreach($social_links as $link) return empty($link);
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
