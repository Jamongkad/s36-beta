<?php namespace Company\Services;

use Input, Helpers;
use Exception, StdClass;
use Company\Repositories\DBCompany;
use Feedback\Repositories\DBSocialFeedback;
use Feedback\Repositories\TWFeedback; 
use \Feedback\Services\SocialFeedback;

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

            $db = new DBCompany;
            $dbsocial = new DBSocialFeedback;  

            if($post_data->twitter_username) { 
                ////Helpers::dump("Twitter Intent is there");
                $twitter = new TWFeedback; 

                $social_services = Array(
                    'twitter' => $twitter->pull_tweets_for($post_data->twitter_username)
                ); 
                $socialfeedback = new SocialFeedback($social_services, $dbsocial);

                $company = $db->get_company_info($post_data->companyid);
                //Helpers::dump($company);

                //check if Company has existing twitter name
                if($company->twitter_username) {
                    //Helpers::dump("ok we have a twitter link");
                    //Helpers::dump($post_data->twitter_username);
                    //Helpers::dump($company->twitter_username);
                    if($post_data->twitter_username != $company->twitter_username) {
                        //Helpers::dump("shit dont match");
                        //erase old twitter feeds
                        $socialfeedback->clear_social_feeds();
                        //replace with new
                        $socialfeedback->save_social_feeds();
                    }
                } else {
                    //Helpers::dump("Create new social feed");
                    //no existing twitter link? ok then make a new one
                    $socialfeedback->save_social_feeds(); 
                }
            }  
            $db->update_companyinfo($post_data);
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
