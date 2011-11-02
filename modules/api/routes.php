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
        $addfeedback = new AddFeedback;
        $addfeedback->create_feedback_with_profile(); 
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

            $user = new User; 
            //flick feedback publish this bitch
            $feed_obj = Array('feedid' => $feedback_id);
            $feedback_model = new Feedback;
            $feedback_model->_toggle_multiple('publish', array($feed_obj)); 

            //since we're already logged in...we just need one property here...the publisher's email
            $publisher = S36Auth::user();

            $vo = new PublishedFeedbackNotificationData;
            $vo->publisher_email = $publisher->email;
     
            $factory = new EmailFactory($vo);
            $factory->addresses = $user->pull_user_emails_by_company_id($company_id);
            $factory->feedback = $feedback_model->pull_feedback_by_id($feedback_id);
            $email_pages = $factory->execute();
           
            $email = new Email($email_pages);
            $email->process_email();

            //After publishing feedback logout...
            S36Auth::logout();
            return View::make('email/thankyou_view');
        }

    }
);
