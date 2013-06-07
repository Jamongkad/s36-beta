<?php

use Feedback\Repositories\DBFeedback;

$feedback = new DBFeedback;

return array(

    'GET /api/fullpage_form' => function() {  
         return View::make('fullpageform/form_index');
     },

    'GET /api/profile' => function() {  
         return View::make('fullpageform/form_profile');
     },
     
    'GET /api/review' => function() {  
         return View::make('fullpageform/form_review');
     },

    'GET /api/submission_send' => function() {  
         return View::make('fullpageform/submission_send');
     },

    'POST /api/send_now' => function() {  
         Helpers::dump(Input::get());
     },

     'POST /api/data_pass' => function() {
         $data = Array(
             'firstname' => Input::get('firstname')
           , 'lastname' => Input::get('lastname')
         );
         echo json_encode($data);
     },

    'POST /api/login' => function() {
        $auth = new S36Auth;
        $input = Input::get();
        $company_name = Config::get('application.subdomain');

        $auth->login($input['username'], $input['password'], Array('company' => $company_name)); 
        
        if($auth->check()) {
            $token = $auth->user()->encryptstring;
            echo json_encode(Array('user' => $auth->user(), 'token' => $token));     
        } else {
            echo json_encode(Array('msg' => 'Invalid Login Credentials', 'error' => 'invalid'));
        } 
    },
     
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

    /* Deprecated
    'POST /api/submit_feedback' => Array('do' => function() { 
        $addfeedback = new Feedback\Services\SubmissionService(Input::get());
        $addfeedback->perform(); 
    }), 
    */

    //TODO: REFACTOR THIS BITCH
    'GET /api/email' => Array('needs' => 'S36ValueObjects', 'do'  => function() use ($feedback) {
        
        $encrypt        = new Encryption\Encryption;
        $string_params  = Input::get('params');
        $feedback_id    = Input::get('feedback_id');
        $company_id     = Input::get('company_id');
        $action         = Input::get('action');

        $decrypt_string = $encrypt->decrypt($string_params);
        $params = explode("|", $decrypt_string); 
        $key = Config::get('application.key');
        
        if($action == "publish") {
            $status = "publish";
        } 
       
        if($action == "unpublish") {
            $status = "restore";
        } 

        if($key != null && S36Auth::login($params[0], $params[1])) {   
            $user = new DBUser; 
            //publish feedback this bitch
            $feed_obj = Array('feedid' => $feedback_id);
            $feedbackstate = new Feedback\Services\FeedbackState($status, Array($feed_obj), $company_id);
            $publish_success = $feedbackstate->change_state();
            $feedbackstate->write_summary();

            if($publish_success)  { 
                //since we're already logged in...we just need one property here...the publisher's email
                $publisher = S36Auth::user();
                
                //Record action on activity log
                $fba = new Feedback\Services\FeedbackActivity($publisher->userid, $feedback_id, $status);
                $activity_check = $fba->log_activity();
                
                //if no record of activity
                if(!is_object($activity_check) and $status == "publish") { 
                    $published_data = new Email\Entities\PublishedFeedbackData;
                    $published_data->set_publisher_email($publisher->email)
                                   ->set_feedback($feedback->pull_feedback_by_id($feedback_id))
                                   ->set_sendtoaddresses($user->pull_user_emails_by_company_id($company_id));
                
                    $emailservice = new Email\Services\EmailService($published_data);
                    $emailservice->send_email(); 
                }
                //After publishing feedback logout...
                S36Auth::logout();
                $contact = DB::Table('Contact', 'master')
                              ->join('Feedback', 'Feedback.contactId', '=', 'Contact.contactId')
                              ->where('Feedback.feedbackId', '=', $feedback_id)
                              ->first(Array('firstName'));

                $hostname = Config::get('application.hostname');

                $settings_url = Helpers::make_forward_url($company_id, '/settings');

                return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
                    'company' => DB::Table('Company', 'master')->where('companyId', '=', $company_id)->first(array('name'))
                  , 'contact_name' => $contact->firstname
                  , 'activity_check' => $activity_check
                  , 'status' => $status 
                  , 'settings_url' => $settings_url
                  , 'hostname' => $hostname
                ));       
            } else {
                S36Auth::logout();
                throw new Exception("Feedback $feedback_id was not published!");
            }
        }
    }),  

    'GET /api/create_user' => Array('do' => function() {     

        $encrypt = new Encryption\Encryption;
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
        $encrypt = new Encryption\Encryption;

        $decrypt = $encrypt->decrypt($data['params']);
        $params = explode("|", $decrypt); 
        $key = Config::get('application.key');

        $user = DB::Table('User', 'master')->where('companyId', '=', $data['companyId'])
                                           ->where('username', '=', $params[0])
                                           ->first();

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

            $personal_data = Array( 
                'username' => strtolower($data['username'])  
              , 'password' => crypt($data['password'])
              , 'encryptString' => $encrypt->encrypt(strtolower($data['username'])."|".$data['password'])
              //, 'avatar' => $data['cropped_image_nm']
              , 'confirmed' => 1
            );

            DB::table('User', 'master')
                ->where('User.userId', '=', $data['userId'])
                ->update($personal_data);

            return Redirect::to('complete');
        }
    })
);
