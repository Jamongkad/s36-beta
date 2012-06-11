<?php namespace Feedback\Entities;

use Input, DB;

class ContactDetails { 
    private $country_id = 895;

    public function insert_contact() { 
        if ($country_input = Input::get('country')) {
            print_r($country_input);
            //$country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            //$this->country_id = $country->countryid;
        }
    }
}
