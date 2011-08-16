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
        echo "(" . json_encode(array('name' => "Mathew", "age" => 29)) . ")";
    }
);
