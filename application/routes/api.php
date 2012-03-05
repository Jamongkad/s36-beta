<?php

$feedback = new DBFeedback;

return array(
     
    'GET /api/pull_feedback' => function() use($feedback) { 

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

        $data = $feedback->pull_feedback_by_company($params); 
        echo "s36_feedback(" . json_encode($data) . ")";
    }, 

    'POST /api/submit_feedback' => Array('needs' => 'S36ValueObjects', 'do' => function() { 

        $addfeedback = new AddFeedback;
        $addfeedback->create_feedback_with_profile(); 
        /*
        $profile_img = new Widget\ProfileImage();
        $profile_img->auto_crop(Input::get('orig_image_dir'), Input::get('login_type'));
        */
    }), 

    'GET /api/publish' => Array('needs' => 'S36ValueObjects', 'do' => function() { 

        $encrypt = new Crypter;
        $string_params  = Input::get('params');
        $feedback_id = Input::get('feedback_id');
        $company_id  = Input::get('company_id');

        $decrypt_string = $encrypt->decrypt($string_params);
        $params = explode("|", $decrypt_string); 
        $key = Config::get('application.key');
        
        //decrypt string use username and password to authenticate into application. 
        if($key != null && S36Auth::login($params[0], $params[1])) {  

            $user = new DBUser; 
            $status = 'publish';
            
            //publish feedback this bitch
            $feed_obj = Array('feedid' => $feedback_id);
            $feedback_model = new DBFeedback;
            $feedback_model->_toggle_multiple($status, array($feed_obj)); 

            //since we're already logged in...we just need one property here...the publisher's email
            $publisher = S36Auth::user();
 
            $fba = new FeedbackActivity($publisher->userid, $feedback_id, $status);
            $activity_check = $fba->log_activity();
            
            //if no record of activity
            if(!is_object($activity_check)) { 
                $vo = new PublishedFeedbackNotificationData;
                $vo->publisher_email = $publisher->email;
         
                $factory = new EmailFactory($vo);
                $factory->addresses = $user->pull_user_emails_by_company_id($company_id);
                $factory->feedback = $feedback_model->pull_feedback_by_id($feedback_id);
                $email_pages = $factory->execute();
                $email = new Email($email_pages);
                $email->process_email();
            }

            //After publishing feedback logout...
            S36Auth::logout();

            $contact = DB::Table('Contact', 'master')
                          ->join('Feedback', 'Feedback.contactId', '=', 'Contact.contactId')
                          ->where('Feedback.feedbackId', '=', $feedback_id)
                          ->first(Array('firstName'));

            return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
                'company_name' => DB::Table('Company', 'master')->where('companyId', '=', $company_id)->first(array('name'))
              , 'contact_name' => $contact->firstname
              , 'activity_check' => $activity_check
            ));       
        } else {
            print_r("Something went wrong");
        }

    }),

    'GET /api/create_user' => Array('do' => function() {     

        $encrypt = new Crypter;
        $string  = Input::get('params');
        $company_id = Input::get('company_id');

        $decrypt = $encrypt->decrypt($string);
        $params = explode("|", $decrypt); 
        $key = Config::get('application.key');

        $user = DB::Table('User', 'master')->where('companyId', '=', $company_id)
                                           ->where('username', '=', $params[0])
                                           ->first();
        if($key != null) {  
            return View::of_home_layout()->partial('contents', 'home/user_auth_view', Array(
                'user_data' => $params, 'company_id' => $company_id, 'admin_details' => $user, 'encrypt_string' => $string, 'errors' => Array()
            ));
        }
    }),

    'POST /api/create_user' => Array('do' => function() {

        $data = Input::get();  
        $encrypt = new Crypter;

        $decrypt = $encrypt->decrypt($data['params']);
        $params = explode("|", $decrypt); 
        $key = Config::get('application.key');

        $user = DB::Table('User', 'master')->where('companyId', '=', $data['companyId'])
                                           ->where('username', '=', $params[0])
                                           ->first();

        $personal_data = Array( 
            'username' => strtolower($data['username'])  
          , 'password' => crypt($data['password'])
          , 'encryptString' => $encrypt->encrypt(strtolower($data['username'])."|".$data['password'])
          , 'avatar' => $data['cropped_image_nm']
          , 'confirmed' => 1
        );

        $rules = Array(
            'username' => 'required'
          , 'password' => 'min:8|confirmed|required' 
        );

        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/user_auth_view', Array(
                'user_data' => $params, 'company_id' => $data['companyId'], 'admin_details' => $user, 'encrypt_string' => $data['params']
              , 'errors' => $validator->errors
            ));
        } else { 
            DB::table('User', 'master')
                ->where('User.userId', '=', $data['userId'])
                ->update($personal_data);

            return Redirect::to('complete');
        }
    })
);
