<?php namespace Feedback\Entities;

use Input, DB, UserInfo;

class ContactDetails { 

    private $country_id = 895;
    private $avatar, $position, $city, $company, $website, $profilelink, $ipaddress, $browser;

    public function insert_contact() { 
        if ($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $this->country_id = $country->countryid;
        }
    }
}
