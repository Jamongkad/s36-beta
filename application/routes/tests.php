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
        $factory->feedback = $feedback->pull_feedback_by_id(122);
 
        $email_pages = $factory->execute();
       
        //Helpers::show_data($email_pages[1]);
        return $email_pages[1]->get_message();
    },

    'GET /tests/test_email_published' => function() {
        
        $user = new DBUser; 
        $feedback = new DBFeedback;

        $vo = new PublishedFeedbackNotificationData;
        $vo->publisher_email = "mathew@36stories.com";
 
        $factory = new EmailFactory($vo);
        $factory->addresses = $user->pull_user_emails_by_company_id(1);
        $factory->feedback = $feedback->pull_feedback_by_id(66);
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
        /*
        $postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com");
        Helpers::show_data($postmark->to("wrm932@gmail.com, klemengkid@gmail.com")
                 //->bcc("ryanchua6@gmail.com, wrm932@gmail.com, mathew@36stories.com") 
                 ->bcc("")
                 ->subject("You win some you lose some. As long as the outcome is income.")
                 ->html_message("That's good advice Ryan thanks. Testing False BCC, double email sent.")
                 ->send());
        */
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
    }
);
