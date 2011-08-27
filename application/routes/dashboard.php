<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),

    'GET /dashboard/test' => function() {  
        $ct = new Contact;
        //fuck naive assumption...

        $name = explode(" ", Input::get('name'));
        $contact_data = Array(
            'siteId'    => 1
          , 'firstName' => "Mathew"
          , 'lastName'  => "Wong"
          , 'email'     => "wrm932@gmail.com"
          , 'countryId' => 166
          , 'position'  => "CTO"
          , 'city'      => "Manila"
          , 'companyName' => "Zenith Labs"
          , 'website'   => "http://www.mathew.com"
          , 'avatar'    => "penguin.png"
        );
        //$ct->insert_new_contact($contact_data);
        $id = db::table('Contact')->insert_get_id($contact_data);
        print_r($id);
    },
);
