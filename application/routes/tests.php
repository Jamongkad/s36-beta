<?php
Package::load('S36ValueObjects');
return array(
    'GET /tests/test_blob' => Array('needs' => 'EnhanceTestFramework, S36ValueObjects', 'do' => function() { 
        Enhance::runTests();
    }),

    'GET /tests/test_email_new' => function() {
        $user = new DBUser; 
        $feedback = new Feedback\Repositories\DBFeedback;
 
        $submission_data = new Email\Entities\NewFeedbackSubmissionData;
        $submission_data->set_feedback($feedback->pull_feedback_by_id(90))
                        ->set_sendtoaddresses($user->pull_user_emails_by_company_id(2));

        $emailservice = new Email\Services\EmailService($submission_data);
        Helpers::dump($emailservice->execute()); 
    },

    'GET /tests/test_email_published' => function() {    
        $user = new DBUser; 
        $feedback = new Feedback\Repositories\DBFeedback;
         
        $published_data = new Email\Entities\PublishedFeedbackData;
        $published_data->set_publisher_email("ryanchua6@gmail.com")
                       ->set_feedback($feedback->pull_feedback_by_id(90))
                       ->set_sendtoaddresses($user->pull_user_emails_by_company_id(2));
    
        $emailservice = new Email\Services\EmailService($published_data);
        Helpers::dump($emailservice->execute()); 
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
        $feedback = new Feeback\Repositories\DBFeedback;

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

        $feedback = new Feedback\Repositories\DBFeedback;

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
        Helpers::show_data($result);
    },

    'GET /tests/test_dbdashboard' => function() {
        $dash = new DBDashboard; 
        $dash->company_id = 1;
        $d = $dash->write_summary();
        Helpers::show_data($d);
    },

    'GET /tests/widget_data/(:any)' => function($widget_id) {
        $dbw = new Widget\Repositories\DBWidget;
        $widget = $dbw->fetch_widget_by_id($widget_id);
        Helpers::dump($widget);
    },

    'GET /tests/pull_feedback' => function() {        
        $params = Array(
            'company_id'   => 1 
          , 'site_id'      => 1
          , 'is_published' => 1
          , 'is_featured'  => 1
        );
        
        $feedback = new Feedback\Repositories\DBFeedback;
        $data = $feedback->pull_feedback_by_company($params);
        Helpers::show_data($data);
    },

    'GET /tests/inboxservice' => function() {
        $inbox_service = new Feedback\Services\InboxService;
        $filters = array(
              'limit'=> 2
            , 'site_id'=> false 
            , 'filter'=> 'all'
            , 'choice'=> false
            , 'date'  => false
            , 'rating' => false
            , 'category' => false
            , 'priority' => false //low medium high
            , 'status' => false //new inprogress closed
        );
        Helpers::dump($inbox_service->set_filters($filters));  
        Helpers::dump($inbox_service->present_feedback());
    }, 

    'GET /tests/compress' => function() {
        $yui = new YUICompressor\YUICompressor("/usr/share/yui-compressor/yui-compressor.jar", "/tmp", Array('type' => 'js'));
        $yui->addFile('js/jquery-1.7.1.min.js');
        $yui->addFile('js/s36application.js');
        print($yui->compress());
    },

    'GET /tests/redis' => function() { 

        $yui = new YUICompressor\YUICompressor("/usr/share/yui-compressor/yui-compressor.jar", "/tmp", Array('type' => 'js'));
        $redis = new redisent\Redis;

        $yui->addFile('js/s36LightBox.js');
        $yui->addFile('js/ZClip.js');
        $yui->addFile('js/Checky.js');
        $yui->addFile('js/DropDownChange.js');
        $yui->addFile('js/InboxStatusChange.js');
        $yui->addFile('js/InboxFilters.js');
        $yui->addFile('js/FeedSetup.js');
        $yui->addFile('js/Status.js');
        $yui->addFile('js/s36application.js');
        $minified_js = $yui->compress();

        $redis->set("cache:main_js", $minified_js);
    }, 

    'GET /tests/get_redis_cache' => function() { 
        $redis = new redisent\Redis;
        $main_js = $redis->get("cache:main_js");
        $plugin_js = $redis->get("cache:plugin_js");
        return View::make("partials/cache_output", Array('main_js' => $main_js, 'plugin_js' => $plugin_js))->get();
    },

    //reserved route for Leica testing
    'GET /tests/leica' => function() {
        return View::make('tests/leica_view');
    }
);
