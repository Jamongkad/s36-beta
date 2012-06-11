<?php namespace Feedback\Entities;

use Input, DB, UserInfo;

class ContactDetails { 

    private $country_id = 895;
    private $position
          , $city
          , $company
          , $website
          , $profilelink;

    private $contact_data = Array();

    public function __construct() {
         $this->userinfo = new UserInfo;
    }

    public function insert_contact() { 

        $this->avatar = Input::get('cropped_image_nm');

        if ($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $country_id = $country->countryid;
        }

        if ($this->avatar == '0' and Input::get('rating') > 2) {
            //$this->avatar = $profile_img->auto_resize(Input::get('orig_image_dir'), Input::get('login_type'));
            $this->position = Input::get('position');
            $this->city    = Input::get('city');
            $this->company = Input::get('company');
            $this->website = Input::get('website');
            $this->profilelink = Input::get('profile_link');
        }  

        $login_type = (Input::get('login_type')) ? Input::get('login_type') : '36';

        $this->contact_data = Array(
            'siteId'    => Input::get('site_id')
          , 'firstName' => Input::get('first_name')
          , 'lastName'  => Input::get('last_name')
          , 'email'     => Input::get('email')
          , 'countryId' => $country_id
          , 'avatar'    => $this->avatar
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
}
