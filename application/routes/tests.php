<?php

Package::load('S36ValueObjects');

return array(
    'GET /tests/test_blob' => Array('needs' => 'EnhanceTestFramework, S36ValueObjects', 'do' => function() { 
        Enhance::runTests();
    }),

    'GET /tests/test_email_new' => function() {

        $user = new DBUser; 
        $feedback = new DBFeedback;

        $vo = new NewFeedbackSubmissionData;

        $factory = new EmailFactory($vo);
        $factory->addresses = $user->pull_user_emails_by_company_id(1);
        $factory->feedback = $feedback->pull_feedback_by_id(40);
 
        $email_pages = $factory->execute();
       
        //Helpers::show_data($email_pages[1]->get_subject());
        return $email_pages[1]->get_message();
    },

    'GET /tests/test_email_published' => function() {
        
        $user = new DBUser; 
        $feedback = new DBFeedback;

        $vo = new PublishedFeedbackNotificationData;
        $vo->publisher_email = "mathew@36stories.com";
 
        $factory = new EmailFactory($vo);
        $factory->addresses = $user->pull_user_emails_by_company_id(1);
        $factory->feedback = $feedback->pull_feedback_by_id(40);
        $email_page = $factory->execute();
         
        return $email_page[1]->get_message();
    },

    'GET /tests/test_email_request' => function() {

        $auth = new S36Auth;
        
        $vo = new RequestFeedbackData;
        $vo->first_name = "Ryan";
        $vo->last_name  = "Chua";

        $factory = new EmailFactory($vo);

        $email_obj = new StdClass;
        $email_obj->email = "ryanchua6@gmail.com";

        $message_obj = new StdClass;
        $message_obj->custom_message = "Mathew would like to know if you think he's awesome and shit.";
        $message_obj->user = $auth->user();
        $message_obj->company = $auth->user_company();
        $message_obj->sites = 1;

        $factory->addresses = Array($email_obj);
        $factory->message = $message_obj;
        $email_page = $factory->execute();
 
        //return $email_page[0]->get_message();
        $emailer = new Email($email_page);
        $emailer->process_email();

    },

    'GET /tests/fetch_category' => function() {
        $category_id = DB::Table('Category')->where('companyId', '=', Input::get('company_id'))
                                            ->where('intName', '=', 'default')->first(Array('categoryId'));

        Helpers::show_data($category_id->categoryid);
    },

    'GET /tests/test_bcc' => function() {

        $postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com", "mathew@dickosaurus");
        Helpers::show_data($postmark->to("wrm932@gmail.com, klemengkid@gmail.com")
                 //->bcc("ryanchua6@gmail.com, wrm932@gmail.com, mathew@36stories.com") 
                 //->bcc("")
                 ->subject("You win some you lose some. As long as the outcome is income.")
                 ->html_message("That's good advice Ryan thanks. Testing False BCC, double email sent.")
                 ->send());

        /*
        $auth = new S36Auth;
        $feedback = new DBFeedback;

        $vo = new FastForwardData;          
        $factory = new EmailFactory($vo);
 
        $email_obj = new StdClass;
        $email_obj->email = "ryanchua6@gmail.com";

        $message_obj = new StdClass;
        $message_obj->bcc = "";
        $message_obj->user = $auth->user();
        $message_obj->comment = "this is a comment";
        $message_obj->feedback = $feedback->pull_feedback_by_id(14);

        $factory->addresses = Array($email_obj);
        $factory->message = $message_obj;
        $email_page = $factory->execute();
        Helpers::show_data($email_page);
        return $email_page[0]->get_message();
        */
    },

    'GET /tests/email_thankyou' => function() { 

        $auth = new S36Auth;
        $userId = $auth->user()->userid;
        $feedbackId = 54;
        $status = "publish";

        $fb = new FeedbackActivity($userId, $feedbackId, $status);
        $activity_check = $fb->log_activity();

        $contact = DB::Table('Contact', 'master')
                      ->join('Feedback', 'Feedback.contactId', '=', 'Contact.contactId')
                      ->where('Feedback.feedbackId', '=', 65)
                      ->first(Array('firstName'));
                      
        return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
            'company_name' => DB::Table('Company', 'master')->where('companyId', '=', 1)->first(array('name'))
          , 'contact_name' => $contact->firstname
          , 'activity_check' => $activity_check
        ));       
    },

    'GET /tests/email_fastforward' => function() {     
        $data = (object)Input::get();
        $auth = new S36Auth;

        $feedback = new DBFeedback;

        $vo = new FastForwardData;          
        $factory = new EmailFactory($vo);
 
        $email_obj = new StdClass;
        $email_obj->email = "wrm932@gmail.com";//$data->email;

        $message_obj = new StdClass;
        $message_obj->bcc = "";
        $message_obj->user = $auth->user();
        $message_obj->comment = "";//$data->email_comment;
        $message_obj->feedback = $feedback->pull_feedback_by_id(59);

        $factory->addresses = Array($email_obj);
        $factory->message = $message_obj;
        $email_page = $factory->execute();
        
        return $email_page[0]->get_message();
        /*
        $emailer = new Email($email_page);
        $emailer->process_email();
        */
    },

    'GET /tests/worklog' => function() {   
        $auth = new S36Auth;
        $userId = $auth->user()->userid;
        $feedbackId = 56;
        $status = "publish";

        $fb = new FeedbackActivity($userId, $feedbackId, $status);
        $result = $fb->log_activity();
        //$check = $fb->check_activity_status();
        //$insert = $fb->insert_new_activity();
        //$update = $fb->update_activity_status();
        Helpers::show_data($result);
    },

    'GET /tests/browser_info' => function() {
        $userinfo = new UserInfo;
        Helpers::show_data($userinfo->get_real_ip_addr());
        Helpers::show_data($userinfo->get_ip_long());
        Helpers::show_data($userinfo->browser()->getBrowser());
    },

    'GET /tests/feedback_submission' => function() {
        
    },

    'GET /tests/test_dbdashboard' => function() {
        $dash = new DBDashboard; 
        $dash->company_id = 3;
        $d = $dash->write_summary();
        Helpers::show_data($d);
    },

    'GET /tests/new_widgets' => function() {
        $dbw = new DBWidget;

        //$widget_obj_modal = $dbw->fetch_widget_by_id('c2wu9'); 
        $widget_obj_embed = $dbw->fetch_widget_by_id('iuz0h'); 

        $obj = base64_decode($widget_obj_embed->widgetobjstring);
        $obj = unserialize($obj);

        Helpers::show_data($obj);
    },

    'GET /tests/update_widget' => function() { 

        $widget_key = 'qtg3d';

        $dbw = new DBWidget;
        $obj = new StdClass;
        $obj->site_id = 1;
        $obj->company_id = 1;
        $obj->base_url = 'http://razer.gearfish.com';
        $obj->theme_name = 'If I could escape ooh yeah';
        $obj->embed_type = 'embedded';
        $obj->embed_block_type = 'embed_block_y';
        $obj->embed_effects = 1;
        $obj->modal_effects = 0;
        $obj->perms = Array(
            'displayName'  => 1
          , 'displayURL' => 1
          , 'displayImg' => 1
          , 'displayCountry' => 1
          , 'displayCompany' => 1
          , 'displaySbmtDate' => 1
          , 'displayPosition' => 1
        );
        $obj->theme_type = 'aglow';
        $dbw->update_widget_by_id($widget_key, $obj);
    }
);
