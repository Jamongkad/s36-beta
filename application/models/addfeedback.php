<?php

class AddFeedback {
 
    public function create_feedback_with_profile() {
        //TODO: HEY MOTHABITCH! REFACTOR THIS CODE ASAP!!        
        $fb = new Feedback\Repositories\DBFeedback;
        $ct = new DBContact;
        $us = new DBUser;
        $bw = new DBBadWords;
        $mt = new DBMetric;
        $userinfo = new UserInfo;
        $profile_img = new Widget\ProfileImage();
    
        //fuck naive assumption...
        $countryId = 895;
        if ($country_input = Input::get('country')) {
            $country = DB::table('Country', 'master')->where('code', '=', $country_input)->first();           
            $countryId = $country->countryid;
        }

        $company_id = Input::get('company_id');
        
        if (Input::get('response_flag') == 1) {
            $mt->company_id = $company_id;
            $mt->increment_response();
        }
        
        $avatar = Input::get('cropped_image_nm');
        $position = "";
        $city     = "";
        $company  = "";
        $website  = "";
        $profilelink = "";
        //fucking js integers
        //TODO: this could be better...if Feedback is not bad then fill out these fields for data insertion.
        if ($avatar == '0' and Input::get('rating') > 2) {
            $avatar = $profile_img->auto_resize(Input::get('orig_image_dir'), Input::get('login_type'));
            $position = Input::get('position');
            $city    = Input::get('city');
            $company = Input::get('company');
            $website = Input::get('website');
            $profilelink = Input::get('profile_link');
        }  

        $contact_data = Array(
            'siteId'    => Input::get('site_id')
          , 'firstName' => Input::get('first_name')
          , 'lastName'  => Input::get('last_name')
          , 'email'     => Input::get('email')
          , 'countryId' => $countryId
          , 'avatar'    => $avatar
          , 'position'  => $position
          , 'city'      => $city
          , 'companyName' => $company
          , 'website'     => $website
          , 'profileLink' => $profilelink
            //if bad feedback just regard as 36s login type
          , 'loginType'   => (Input::get('login_type')) ? Input::get('login_type') : '36' 
          , 'ipaddress'   => $userinfo->get_ip_long()
          , 'browser' => $userinfo->browser()->getBrowser()
        );

        $contact_id = $ct->insert_new_contact($contact_data);

        $permission = Input::get('permission');
        $text = Input::get('feedback');
        
        $category = DB::Table('Category')->where('companyId', '=', $company_id)
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
          , 'dtAdded' => date('Y-m-d H:i:s')
        );

        $new_feedback_id = DB::table('Feedback')->insert_get_id($feedback_data);

        $bw->profanity_detection($text, $new_feedback_id); 

        $submission_data = new Email\Entities\NewFeedbackSubmissionData;
        $submission_data->set_feedback($fb->pull_feedback_by_id($new_feedback_id))
                        ->set_sendtoaddresses($us->pull_user_emails_by_company_id($company_id));

        $emailservice = new Email\Services\EmailService($submission_data);
        $emailservice->send_email();

        $dash = new DBDashboard; 
        $dash->company_id = $company_id;
        $dash->write_summary();

        //Upon new feedback always invalidate cache       
        $halcyon = new Halcyonic\Services\HalcyonicService;
        $halcyon->save_latest_feedid();
    }
}
