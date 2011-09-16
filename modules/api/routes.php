<?php

return array(
    'GET /api/pull_feedback' => function() { 

        $company_id = false;
        $site_id = false;
        $is_published = 0;
        $is_featured = 0;
        $limit = 10;
        $offset = 0;
        
        if(Input::get('company_id')) {
            $company_id = (int)Input::get('company_id');   
        }

        if(Input::get('site_id')) {
            $site_id = (int)Input::get('site_id');   
        }

        if(Input::get('offset')) { 
            $offset = (int)Input::get('offset');
        }

        if(Input::get('limit')) {
            $limit = (int)Input::get('limit');   
        }

        if(Input::get('is_published')) {
            $is_published = (int)Input::get('is_published');   
        }

        if(Input::get('is_featured')) {
            $is_featured = (int)Input::get('is_featured');   
        }

        $params = Array(
            'company_id' => $company_id
          , 'site_id' => $site_id
          , 'is_published' => $is_published
          , 'is_featured' => $is_featured
          , 'limit' => $limit
          , 'offset' => $offset
        );

        $feedback = new Feedback;
        $data = $feedback->pull_feedback_by_company($params);
        /*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        */
        echo "s36_feedback(" . json_encode($data) . ")";
    }, 

    'POST /api/submit_feedback' => function() {
        $fb = new Feedback;
        $ct = new Contact;

        //fuck naive assumption...

        $countryId = Null;
        if($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $countryId = $country->countryid;
        }

        $contact_data = Array(
            'siteId'    => Input::get('site_id')
          , 'firstName' => Input::get('first_name')
          , 'lastName'  => Input::get('last_name')
          , 'email'     => Input::get('email')
          , 'countryId' => $countryId
          , 'position'  => Input::get('position')
          , 'city'      => Input::get('city')
          , 'companyName' => Input::get('company')
          , 'website'   => Input::get('email')
          , 'avatar'    => Input::get('cropped_image_nm')
        );

        $contact_id = $ct->insert_new_contact($contact_data);
        
        $feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $contact_id
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => Input::get('feedback')
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        );

        DB::table('Feedback')->insert($feedback_data);
    },

    'GET /api/test_blob' => function() {
        $db = DB::connection('master')->pdo;
        $sth = $db->prepare("SELECT * FROM Theme WHERE companyId = 1");
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        echo "<style type='text/stylesheet'>";
        print_r($result->interfacesettings);
        echo "</style>";
    }
);
