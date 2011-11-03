<?php

class AddFeedback {

    public function create_feedback_with_profile() {
        
        $fb = new Feedback;
        $ct = new Contact;
        $us = new User;
        $bw = new BadWords;

        //fuck naive assumption...
        $countryId = 895;
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

        $permission = Input::get('permission');
        $text = Input::get('feedback');
 
        $feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $contact_id
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => $text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        );

        $new_feedback_id = DB::table('Feedback')->insert_get_id($feedback_data);

        $isProfane = $badwords->profanity_detection($text); 
        
        DB::table('Feedback', 'master')
             ->where('feedbackId', '=', $new_feedback_id)
             ->update(Array(
                          'text' => $text
                        , 'hasProfanity' => ($isProfane) ? 1 : 0
                      ));

        $vo = new NewFeedbackSubmissionData;

        $factory = new EmailFactory($vo);
        $factory->addresses = $us->pull_user_emails_by_company_id(Input::get('company_id'));
        $factory->feedback = $fb->pull_feedback_by_id($new_feedback_id);
 
        $email_pages = $factory->execute();
        
        $email = new Email($email_pages);
        $email->process_email();

        //check if sample-avatar if not...delete original photo once done... 
        $orig_image_dir = Input::get('orig_image_dir');
        preg_match_all("~sample-avatar.png~", $orig_image_dir, $matches);  
        if(!$matches[0]) {
            @unlink("/var/www/s36-upload-images".$orig_image_dir);     
        } 
    }

}
