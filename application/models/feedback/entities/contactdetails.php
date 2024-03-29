<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Contact\Repositories\DBContact;
use DB, UserInfo, Profile\Services\ProfileImage, Helpers;
use SimpleArray;

class ContactDetails extends FeedbackDataTypes { 

    public $bypass_profilephoto = False;

    private $country_id     = 895;
    private $position       = false;
    private $city           = false;
    private $company        = false;
    private $website        = null;
    private $profilelink    = false;
    private $contact_data   = Array();
    private $contact_id;

    public function __construct(SimpleArray $post_data) {
        $this->post_data    = $post_data;
        $this->userinfo     = new UserInfo;
        $this->profile_img  = new ProfileImage;
    }

    public function generate_data() { 

        $country_id = 895;
        if ($country_input = $this->post_data->get('country')) {
            $country    = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $country_id = $country->countryid;
        }

        $post_login_type = $this->post_data->get('login_type');
        
        $this->position     = $this->_sentence_case($this->post_data->get('position'));
        $this->city         = $this->_sentence_case($this->post_data->get('city'));
        //$this->company      = $this->_sentence_case($this->post_data->get('company'));
        $this->company      = $this->post_data->get('company');
        $this->company      = ( $this->company == strtoupper($this->company) ? $this->company : $this->_sentence_case($this->post_data->get('company')) );
        $this->website      = $this->post_data->get('website');
        $this->profilelink  = $this->post_data->get('profile_link');
        $logintype          = ($post_login_type) ? $post_login_type : '36';
        $avatar             = $this->post_data->get('avatar_filename');

        if($this->bypass_profilephoto == False) {            
            if(strpos($this->post_data->get('avatar'),'blank-avatar') === false) {
            if($logintype!='36'){
                $avatar = $this->profile_img->auto_resize($this->post_data->get('avatar'), $logintype);
            }}
        }

        $contact_info = Array(
            'siteId'      => $this->post_data->get('site_id')
          , 'firstName'   => $this->_sentence_case($this->post_data->get('first_name'))
          , 'lastName'    => $this->_sentence_case($this->post_data->get('last_name'))
          , 'email'       => $this->post_data->get('email')
          , 'countryId'   => $country_id
          , 'avatar'      => $avatar
          , 'position'    => $this->position
          , 'city'        => $this->city
          , 'companyName' => $this->company
          , 'website'     => $this->website
          , 'profileLink' => $this->profilelink
          , 'loginType'   => $logintype 
          , 'ipaddress'   => $this->userinfo->get_ip_long()
          , 'browser'     => $this->userinfo->browser()->getBrowser()
        ); 

        return $contact_info;
    }
     
    private function _sentence_case($string) {
        return ucwords(strtolower($string));
    }
}
