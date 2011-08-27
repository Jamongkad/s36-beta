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
        echo "s36_feedback(" . json_encode($data) . ")";
    }, 

    'POST /api/submit_feedback' => function() {
        $fb = new Feedback;
        $ct = new Contact;

        //fuck naive assumption...
        $name = explode(" ", Input::get('name'));
        $contact_data = (Object)Array(
            'siteId'    => Input::get('site_id')
          , 'firstName' => $name[0]
          , 'lastName'  => $name[1]
          , 'email'     => Input::get('email')
          , 'countryId' => Input::get('country')
          , 'position'  => Input::get('position')
          , 'city'      => Input::get('city')
          , 'companyName' => Input::get('company')
          , 'website'   => Input::get('email')
          , 'avatar'    => Input::get('cropped_image_dir')
        );
        $ct->insert_new_contact($contact_data);
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
