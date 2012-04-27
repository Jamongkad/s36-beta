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
        Helpers::dump($emailservice->send_email()); 
    },

    'GET /tests/test_email_published' => function() {    
        $user = new DBUser; 
        $feedback = new Feedback\Repositories\DBFeedback;
         
        $published_data = new Email\Entities\PublishedFeedbackData;
        $published_data->set_publisher_email("ryanchua6@gmail.com")
                       ->set_feedback($feedback->pull_feedback_by_id(90))
                       ->set_sendtoaddresses($user->pull_user_emails_by_company_id(2));
    
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
        $feedback = new Feedback\Repositories\DBFeedback;
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
            , 'filter'=> 'all'
            , 'choice'=> false
            , 'date'  => false
            , 'rating' => false
            , 'category' => false
            , 'priority' => false //low medium high
            , 'status' => false //new inprogress closed
            , 'company_id' => $company_id
        );

        $inbox_service->set_filters($filters);
        Helpers::dump($inbox_service->present_feedback());

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
        $feedid = $redis->smembers("hosted:feeds:3");
        Helpers::dump($feedid);
        foreach($feedid as $feeds) {
            Helpers::dump(json_decode($feeds));
        }
    }, 

    'GET /tests/imagine' => function() {
        $imagine = new Imagine\Gd\Imagine();
        Helpers::dump($imagine);

        $size = new Imagine\Image\Box(40, 40);
        Helpers::dump($size);
    },

    'GET /tests/full_page_algo/(:num)' => function($company_id) { 
        $time_start = microtime(True);
        $test = new Feedback\Services\HostedService($company_id);
        $feeds = $test->fetch_hosted_feedback(); 
        Helpers::dump($feeds);
        $time_end = microtime(True);
        $time = $time_end - $time_start;
        Helpers::dump("Algorithm: ".$time." seconds");
    },

    'GET /tests/hosted_feedback_cache_invalidate' => function() { 
        $test = new Feedback\Services\HostedService(1);
        $test->invalidate_hosted_feeds_cache(); 
    },

    //reserved route for Leica and Ryan testing
    'GET /tests/leica' => function() {
        return View::make('tests/leica_view');
    },

    'GET /tests/ryan' => function() {
        return View::make('tests/ryan_view');
    }

);
