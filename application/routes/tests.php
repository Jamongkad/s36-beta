<?php

Package::load('S36ValueObjects');

return array(
    
    'GET /tests' => function() {
        print_r("Hallo welcome to the 36Stories Test Suite! - Mathew");
    },

    'GET /tests/test_blob' => Array('needs' => 'EnhanceTestFramework, S36ValueObjects', 'do' => function() { 
        Enhance::runTests();
    }),

    'GET /tests/test_validator' => function() {
        $test = new SimpleValidator\SimpleValidator;
        Helpers::dump($test);
    }, 

    'GET /tests/test_email_new' => function() {
        $user = new DBUser; 
        $feedback = new Feedback\Repositories\DBFeedback;
 
        $submission_data = new Email\Entities\NewFeedbackSubmissionData;
        $submission_data->set_feedback($feedback->pull_feedback_by_id(90))
                        ->set_sendtoaddresses($user->pull_user_emails_by_company_id(1));

        $emailservice = new Email\Services\EmailService($submission_data);
        Helpers::dump($emailservice->send_email()); 
    },

    'GET /tests/test_email_published' => function() {    
        $user = new DBUser; 
        $feedback = new Feedback\Repositories\DBFeedback;
         
        $published_data = new Email\Entities\PublishedFeedbackData;
        $published_data->set_publisher_email("ryanchua6@gmail.com")
                       ->set_feedback($feedback->pull_feedback_by_id(90))
                       ->set_sendtoaddresses($user->pull_user_emails_by_company_id(1));
    
        $emailservice = new Email\Services\EmailService($published_data);
        Helpers::dump($emailservice->send_email()); 
    },

    'GET /tests/test_email_request' => function() {
        $auth = new S36Auth; 
        $request_data = new Email\Entities\RequestFeedbackData;
        $request_data->sendto = (object) Array(
            'first_name' => 'Ryan'
          , 'last_name' => 'Chua'
          , 'email' => 'wrm932@gmail.com'
        );
        $request_data->message = 'Dan is gay...';
        $request_data->from = $auth->user(); 
        $request_data->sites = 1;
        $request_data->widgetkey = 'ovns8';
        $emailservice = new Email\Services\EmailService($request_data);
        $emailservice->send_email();
    },

    'GET /tests/test_email_invite' => function() {
        $invite_data = new Email\Entities\InvitationData; 
        $invite_data->invitee_info_id(15);
        $invite_data->set_publisher_email(S36Auth::user()->email);
        $invite_data->account_owner = S36Auth::user()->fullname;
        $invite_data->message = "Mathew is kewl";

        $emailservice = new Email\Services\EmailService($invite_data);
        Helpers::dump($emailservice->send_email());
    },

    'GET /tests/test_email_fastforward' => function() {     
        $data = (object)Input::get();
        $auth = new S36Auth;
        
        $feedback = new Feedback\Repositories\DBFeedback;
        $fastdata = new Email\Entities\FastForwardData;

        $fastdata->sendto = "wrm932@gmail.com";
        $fastdata->from = ucfirst($auth->user()->username);
        $fastdata->email_comment = "Mathew is kewl";
        $fastdata->feedback = $feedback->pull_feedback_by_id(213);
        $fastdata->receiver_details();
        $fastdata->make_forward_url();

        $emailservice = new Email\Services\EmailService($fastdata);
        Helpers::dump($emailservice->send_email());
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

    'GET /tests/test_email_replyto' => function() {        
        $feedback  = new Feedback\Repositories\DBFeedback;
        $replydata = new Email\Entities\ReplyData;
        
        $replydata->subject = "Mathew is a dickie";
        $replydata->bcc = Array(
            "wrm932@gmail.com" 
          , "karen_cayamanda@yahoo.com"
          , "klemengkid@gmail.com"
        );
        $replydata->sendto = "wrm932@gmail.com";
        $replydata->from = (object) Array(
            "replyto" => "ryanchu6@gmail.com"
          , "username"  => "Mathew"
        );
        $replydata->message = "Mathew is kewl";
        $replydata->feedback = $feedback->pull_feedback_by_id(213);
                 
        $emailservice = new Email\Services\EmailService($replydata);
        Helpers::dump($emailservice->send_email()); 
    },

    'GET /tests/test_email_resend' => function() {
        $admin = new DBadmin; 
        $data = Input::get();
        $opts = new StdClass; 
        $opts->username = "wrm932@gmail.com";
        $opts->options = Array('company' => Input::get('subdomain'));
        $user = $admin->fetch_admin_details($opts);

        $data = new Email\Entities\ResendPasswordData;
        $data->user_data = $user;
        $data->get_host();
        $data->reset_key();

        $emailservice = new Email\Services\EmailService($data);
        Helpers::dump($emailservice->send_email()); 
    },

    'GET /tests/widget_data/(:any)' => function($widget_id) {
        $dbw = new Widget\Repositories\DBWidget;
        $widget = $dbw->fetch_widget_by_id($widget_id);
        Helpers::dump($widget);
    },

    'GET /tests/default_widget/(:any)' => function($company_id) {
        $dbw = new Widget\Repositories\DBWidget;
        $widget = $dbw->fetch_canonical_widget($company_id);
        Helpers::dump($widget);
    },

    'GET /tests/pull_feedback' => function() {        
        $params = Array(
            'company_id'   => 1 
          , 'site_id'      => 1
          , 'is_published' => 0
          , 'is_featured'  => 1
        );
        
        $feedback = new Feedback\Repositories\DBFeedback;
        $data = $feedback->pull_feedback_by_company($params);
        Helpers::show_data($data);
    },

    'GET /tests/inboxservice/(:num)' => function($company_id) {

        $inbox_service = new Feedback\Services\InboxService;
        $time_start = microtime(True);

        $filters = array(
              'limit'=> 10
            , 'site_id'=> false 
            , 'filter'=> 'published' //(new arrivals) all (show only) featured published
            , 'choice'=> 'all' //positive negative neutral profanity flagged mostcontent
            , 'date'  => false //date_new date_old
            , 'rating' => false //5 4 3 2 1
            , 'category' => false 
            , 'priority' => false //low medium high
            , 'status' => false //new inprogress closed
            , 'company_id' => $company_id
        );
        $inbox_service->ignore_cache = True;
        $inbox_service->set_filters($filters);
        $feedback = $inbox_service->present_feedback();
        Helpers::dump($feedback);
                 
        $time_end = microtime(True);
        $time = $time_end - $time_start;
        Helpers::dump("New Algorithm: ".$time." seconds");

    }, 

    'GET /tests/compress' => function() {
        $yui = new YUICompressor\YUICompressor("/usr/share/yui-compressor/yui-compressor.jar", "/tmp", Array('type' => 'js'));
        $js_scripts = Array( 
             'js/jquery.jcrop.js' 
           , 'js/jquery.ajaxfileupload.js'
           , 'js/s36FormModule.js'
           , 'js/cycle.function.js'
           , 'js/widget/form.js'
        );

        foreach($js_scripts as $js_file) {
            $yui->addFile($js_file);
        }

        $compressed_file = $yui->compress();

        print($compressed_file);
    },

    'GET /tests/redis' => function() { 
        $redis = new redisent\Redis;       
    }, 

    'POST /tests/submissionservice' => function() {
        $contact = new Feedback\Entities\ContactDetails;
        $feedback_details = new Feedback\Entities\FeedbackDetails;
        $addfeedback = new Feedback\Services\SubmissionService($contact, $feedback_details);
        $result = $addfeedback->perform();
        print_r($result);
    },

    'GET /tests/full_page_algo/(:any)/(:num?)' => function($company_name, $page=false) { 

        $time_start = microtime(True);

        $test = new Feedback\Services\HostedService($company_name);
        $test->page_number = $page;
        $test->starting_units_onload = 5;
        $test->debug = True;
        $test->fetch_hosted_feedback(); 
        $test->build_data();

        $time_end = microtime(True);
        $time = $time_end - $time_start;
        Helpers::dump("Algorithm: ".$time." seconds");

    },

    'GET /tests/url_in_string' => function() {
        $str = "My name is mathew of http://mathew.com and http://www.dickie.com";
        $str = Helpers::html_cleaner($str);
        Helpers::dump($str);
    },

    'GET /tests/hosted_feedback_cache_invalidate' => function() { 
        $test = new Feedback\Services\HostedService(1);
        $test->invalidate_hosted_feeds_cache(); 
    },

    'GET /tests/company_info/(:any)' => function($company_id) {
        $company = new Company\Repositories\DBCompany;
        $company_info = $company->get_company_info($company_id);
        Helpers::dump($company_info);
    },

    'GET /tests/mobile' => function() {
        $is_mobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.
                            '|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                            '|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
        if($is_mobile) {
            Helpers::dump("Mobile Browser Detected");     
        } 
    },

    'GET /tests/urllinker' => function() {
        $urllinker = new UrlLinker\UrlLinker;
        $text = "<p> <ul>Dan is gay http://pwet.com</ul> </p>";
        Helpers::dump($urllinker->html_escape_linkurls($text));
        Helpers::dump(Helpers::html_cleaner($text));
    },

    'GET /tests/widget_themes' => function() {
        $test = new Widget\Repositories\DBWidgetThemes;         
        $test->build_menu_structure(); 
        $ref = $test->perform(); 
        Helpers::dump($ref);
        foreach($ref as $main_themes) {    
            Helpers::dump($main_themes);
        }
        /*
        Helpers::dump($test->get_parent('matte'));
        */
    },

    'GET /tests/a_matter_of_time' => function() {
        $dummy_data = Array('name' => 'mathew', 'age' => 30, 'sex' => 'frequently');
        $dvo = new Widget\Entities\DisplayValueObject($dummy_data);
        $fvo = new Widget\Entities\FormValueObjec($dummy_data);
        Helpers::dump($j);
    },

    'GET /tests/hosted_settings' => function() {
        $hosted_settings_data = Array(
            'companyId'  => 3
          , 'theme_type' => 'dark'
          , 'header_text' => 'Awww yeaaa mah nigguhs Leica is cute'
          , 'submit_form_text' => 'Share your feeds with us...'
          , 'submit_form_question' => 'What do you think of our niggarly services'
        );
        $hosted = new Widget\Repositories\DBHostedSettings;
        $hosted->set_hosted_settings($hosted_settings_data);
        $hosted->save();
        Helpers::dump($hosted->record_exists());
    },

    //reserved route for Leica and Ryan testing
    'GET /tests/leica' => function() {
        return View::make('tests/leica_view');
    },

    'GET /tests/ryan' => function() {
        return View::make('tests/ryan_view');
    },

    'GET /tests/aryann' => function() {
        return View::make('tests/aryann_view');
    }
);
