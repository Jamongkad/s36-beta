<?php

class AddFeedback {
 
    public function create_feedback_with_profile() {
        //TODO: HEY MOTHABITCH! REFACTOR THIS CODE ASAP!!        
        $fb = new DBFeedback;
        $ct = new DBContact;
        $us = new DBUser;
        $bw = new DBBadWords;
        $mt = new DBMetric;
        $userinfo = new UserInfo;

        //fuck naive assumption...
        $countryId = 895;
        if($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $countryId = $country->countryid;
        }
        
        if(Input::get('response_flag') == 1) {
            $mt->company_id = Input::get('company_id');
            $mt->increment_response();
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
          , 'loginType' => Input::get('login_type')
          , 'profileLink' => Input::get('profile_link')
          , 'ipaddress' => $userinfo->get_ip_long()
          , 'browser' => $userinfo->browser()->getBrowser()
        );

        $contact_id = $ct->insert_new_contact($contact_data);

        $permission = Input::get('permission');
        $text = Input::get('feedback');
        
        $category = DB::Table('Category')->where('companyId', '=', Input::get('company_id'))
                                         ->where('intName', '=', 'default')->first(Array('categoryId'));
 
        $feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $contact_id
          , 'categoryId' => $category->categoryid
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => $text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        );

        $new_feedback_id = DB::table('Feedback')->insert_get_id($feedback_data);

        $bw->profanity_detection($text, $new_feedback_id); 
        
        $vo = new NewFeedbackSubmissionData;

        $factory = new EmailFactory($vo);
        $factory->addresses = $us->pull_user_emails_by_company_id(Input::get('company_id'));
        $factory->feedback = $fb->pull_feedback_by_id($new_feedback_id);
 
        $email_pages = $factory->execute();
        
        $email = new Email($email_pages);
        $email->process_email();
        
        $dash = new DBDashboard; 
        $dash->company_id = Input::get('company_id');
        $dash->write_summary();

        //check if sample-avatar if not...delete original photo once done... 
        /*
        $orig_image_dir = Input::get('orig_image_dir');
        preg_match_all("~sample-avatar.png~", $orig_image_dir, $matches);  

        if(Input::get('login_type') == "36") {
            @unlink("/var/www/s36-upload-images".$orig_image_dir);      
        }

        if(!$matches[0] && Input::get('fb_flag') == 0) {
            @unlink("/var/www/s36-upload-images".$orig_image_dir);     
        } 
        */
    }

}
