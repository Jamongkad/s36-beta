<?php

Package::load('S36ValueObjects');

return array(
    'GET /api/pull_feedback' => function() { 

        $company_id = false;
        $site_id = false;
        $is_published = 0;
        $is_featured = 0;
        
        if(Input::get('company_id')) {
            $company_id = (int)Input::get('company_id');   
        }

        if(Input::get('site_id')) {
            $site_id = (int)Input::get('site_id');   
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
        );

        $feedback = new Feedback;
        $data = $feedback->pull_feedback_by_company($params); 
        echo "s36_feedback(" . json_encode($data) . ")";
    }, 

    'POST /api/submit_feedback' => function() {
        $fb = new Feedback;
        $ct = new Contact;
        $us = new User;

        //fuck naive assumption...
        $countryId = null;
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
          , 'permission' => Input::get('permission')
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        );

        $new_feedback_id = DB::table('Feedback')->insert_get_id($feedback_data);

        $vo = new NewFeedbackSubmissionData;

        $factory = new EmailFactory($vo);
        $factory->company_id = Input::get('company_id');
        $factory->feedback_id = Input::get('feedback_id');
        $email_pages = $factory->execute();
        
        $email = new Email($email_pages);
        $email->process_email();
    }, 

    'GET /api/publish' => function() { 

        $encrypt = new Crypter;
        $string  = Input::get('params');
        $feedback_id = Input::get('feedback_id');
        $company_id  = Input::get('company_id');

        $decrypt = $encrypt->decrypt($string);
        $params = explode("|", $decrypt); 
        $key = Config::get('application.key');
        
        //decrypt string use user and password to authenticate into application. 
        if($key != null && S36Auth::login($params[0], $params[1])) {  
            
            //flick feedback publish this bitch
            $feed_obj = Array('feedid' => $feedback_id);
            $feedback_model = new Feedback;
            $feedback_model->_toggle_multiple('publish', array($feed_obj)); 

            //since we're already logged in...we just need one property here...the publisher's email
            $publisher = S36Auth::user();

            $vo = new PublishedFeedbackNotificationData;
            $vo->publisher_email = $publisher->email;
           
            $factory = new EmailFactory($vo);
            $factory->company_id = $company_id;
            $factory->feedback_id = $feedback_id;
            $email_page = $factory->execute(); 

            //Send email logic goes here...    
            Helpers::show_data($email_page);
            //After publishing feedback logout...
            S36Auth::logout();
        }

    }
);
