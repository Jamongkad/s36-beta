<?php

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
          , 'permission' => Input::get('permission')
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        );

        $new_feedback_id = DB::table('Feedback')->insert_get_it($feedback_data);
        /*
        $email = new Email;
        $email->latest_feedback(Input::get('company_id'), $new_feedback_id);
        
        $user_contacts = $us->pull_users_by_company_id(Input::get('company_id'));
        $feedback_data = $fb->pull_feedback_by_id($feedback_id);

        $notification = new EmailNotification($user_contacts, $feedback_data);
        */
       
    },

    'GET /api/test_blob' => function() {
        Package::load('EnhanceTestFramework');
        Enhance::runTests();
    },

    'GET /api/test_email' => function() {
        $emailObj = new Email;

        $user = new User;
        $email = $user->pull_user_emails_by_company_id(2);

        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);

        $target = new NewFeedbackSubmission($email, $feedback, "36Stories New Feedback Notification");
        //return $target->get_message(); 
        //Helpers::show_data($email);
        $emailObj->process_email($target);
    }
);
