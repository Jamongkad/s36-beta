<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Contact\Repositories\DBContact;
use Input, DB, UserInfo, Profile\Services\ProfileImage, Helpers;

class ContactDetails extends FeedbackDataTypes { 

    private $country_id = 895;
    private $position = false;
    private $city = false;
    private $company = false;
    private $website = false;
    private $profilelink = false;

    private $contact_data = Array();
    private $contact_id;

    public function __construct($post_data) {
        $this->post_data = $post_data;
        $this->userinfo = new UserInfo;
        $this->profile_img = new ProfileImage;
    }

    public function read_data() { 

        $avatar = Input::get('cropped_image_nm');

        $country_id = 895;
        if ($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $country_id = $country->countryid;
        }

        $rating_check = Input::get('rating') > 3;    
        //if no cropped photo and feedback rating is above average
        if ($avatar == '0' and $rating_check) {

            $orig_image_dir = Input::get('orig_image_dir');
            
            //if original image directory does not contain blank-avatar name...assume a photo will be auto cropped
            if(strpos($orig_image_dir, 'blank-avatar') === false) {
                $avatar = $this->profile_img->auto_resize($orig_image_dir, Input::get('login_type'));     
            }   
        }  
        
        //If rating is above average get profile information
        if($rating_check) { 
            $this->position = $this->_sentence_case(Input::get('position'));
            $this->city     = $this->_sentence_case(Input::get('city'));
            $this->company  = $this->_sentence_case(Input::get('company'));
            $this->website  = Input::get('website');
            $this->profilelink = Input::get('profile_link');
        }

        $login_type = (Input::get('login_type')) ? Input::get('login_type') : '36';

        $this->contact_data = Array(
            'siteId'    => Input::get('site_id')
          , 'firstName' => $this->_sentence_case(Input::get('first_name'))
          , 'lastName'  => $this->_sentence_case(Input::get('last_name'))
          , 'email'     => Input::get('email')
          , 'countryId' => $country_id
          , 'avatar'    => $avatar
          , 'position'  => $this->position
          , 'city'      => $this->city
          , 'companyName' => $this->company
          , 'website'     => $this->website
          , 'profileLink' => $this->profilelink
          , 'loginType'   => $login_type 
          , 'ipaddress'   => $this->userinfo->get_ip_long()
          , 'browser' => $this->userinfo->browser()->getBrowser()
        ); 
    }

    public function write_new_contact() {
        $dbcontact = new DBContact;        
        $this->contact_id = $dbcontact->insert_new_contact($this->contact_data);
    }
    
    public function get_contact_id() {
        if($this->contact_id)
            return $this->contact_id;     
    }

    public function _sentence_case($string) {
        return ucwords(strtolower($string));
    }
}
