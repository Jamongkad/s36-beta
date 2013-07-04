<?php

use Message\Entities\Types\Inbox\Notification;
use Message\Entities\MessageList;
use Message\Services\MessageDirector;

$feedback = new Feedback\Repositories\DBFeedback;
$category = new DBCategory;
$dbwidget = new Widget\Repositories\DBWidget;
$badwords = new DBBadWords;
$redis = new redisent\Redis;
$auth = S36Auth::user();
$inbox = new Message\Entities\UserInbox("{$auth->username}:messages");
$company_name = Config::get('application.subdomain');

return array(
    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($feedback, $category) {

        //Reply messages
        $sm = new Message\Services\SettingMessage(new Message\Repositories\DBMessage('msg'));
        $sm->get_messages();
         
        return View::of_layout()->partial('contents', 'feedback/modifyfeedback', Array(
             'feedback' => $feedback->pull_feedback_by_id($id)
           , 'categories' => $category->pull_site_categories()
           , 'status' => DB::table('Status', 'master')->get()
           , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high')
           , 'admin_check' => S36Auth::user()
           , 'reply_message' => json_encode($sm->jsonify())
        ));
    }),

    'GET /feedback/load_reply_form' => function() {
        return View::make('feedback/partials/replyform_index');
    },

    'GET /feedback/get_replybody' => function() use ($feedback) {
        $data = Array(
            'user' => S36Auth::user()
          , 'feedid' => Input::get('feedid')
          , 'feedback' => $feedback->pull_feedback_by_id(Input::get('feedid'))
        );
        echo json_encode($data);
    },

    'GET /feedback/load_edit_form/(:any?)' => function($id=Null) {
        return View::make('feedback/partials/editform_view');
    },

    'POST /feedback/edit_feedback_text' => function() use ($feedback, $badwords) {
        $post = (object)Input::get();
        $feedbackservice = new Feedback\Services\FeedbackService($feedback, $badwords);
        $feedbackservice->save_feedback($post);
    },
    
    //mothafucking route is used in modifyfeedback tab
    'GET /feedback/change_state/(\w+)/(\d+)' => function($state, $id) use($feedback) {
        if($state == 'flag') { 
            return $feedback->_change_feedback('isFlagged', $id, Input::get('state'));
        } else {   
            $feed_obj = Array('feedid' => $id);
            $feedbackstate = new Feedback\Services\FeedbackState($state, Array($feed_obj), S36Auth::user()->companyid);
            $feedbackstate->change_state();
            $feedbackstate->write_summary();
        }
    },

    //Ajax Routes...
    'GET /feedback/bust_hostfeed_data' => function() use ($company_name) { 
        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->bust_hostfeed_data();
    },

    'POST /feedback/changestatus' => function() use ($feedback) { 
        $feedback->_change_feedback('status', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/changepriority' => function() use ($feedback) { 
        $feedback->_change_feedback('priority', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/flagfeedback' => function() use ($feedback) {  
        $feed = Input::get('feed_data');

        $feed_ids   = Array($feed['id']);
        $cat_id     = $feed['catid'];
        $mode       = $feed['status'];
        $company_id = (Input::get('company_id')) ? Input::get('company_id') : S36Auth::user()->companyid;

        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feed_ids, $company_id, $cat_id);
        $feedbackstate->change_state();
        $feedbackstate->write_summary(); 
    },
     
    'POST /feedback/change_feedback_state' => function() use ($feedback) { 
        $feed = Input::get('feed_data');
        $undo_flag = Input::get('undo');
    
        $feed_ids   = (is_array($feed['id'])) ? $feed['id'] : Array($feed['id']);
        $cat_id     = $feed['catid'];
        $mode       = ($undo_flag == "true") ? $feed['origin'] : $feed['status'];
        $company_id = (Input::get('company_id')) ? Input::get('company_id') : S36Auth::user()->companyid;

        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feed_ids, $company_id, $cat_id);
        //$feedbackstate->change_state();
        //$feedbackstate->write_summary();  
    },

    'POST /feedback/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('status') == "true") {
            $state = 1;    
        }
        $feedback->_change_feedback(  Input::get('column')
                                    , Input::get('feedid')
                                    , $state );
    },

    'POST /feedback/lock_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('status') == "true") {    
            $state = 1;
        }
        $feedback->toggle_indlock(Input::get('feedid'), $state);
    },

    'POST /feedback/fire_multiple' => function() use ($feedback) {
        $feed_ids = Input::get('feed_ids');
        $mode     = Input::get('col');  

        $fire = new Feedback\Services\FireMultiple($feedback, $feed_ids, $mode);
        return $fire->execute();
    },

    'POST /feedback/change_feedback_date' => function() use ($feedback) {
        $date = date("Y-m-d H:i:s", strtotime(Input::get('change_date')));
        $affected = DB::table('Feedback', 'master')
            ->where('feedbackId', '=', Input::get('feedback_id'))
            ->update(Array('dtAdded' => $date));
        return $affected;
    },
 
    'GET /feedback/deletefeedback/(:num)' => function($id) use ($feedback) {
        $feed_obj = Array('feedid' => $id);
        $feedbackstate = new Feedback\Services\FeedbackState('delete', Array($feed_obj), S36Auth::user()->companyid);
        $feedbackstate->change_state();
        $feedbackstate->write_summary();

        return Redirect::to('inbox/deleted/all');  
    },

    'GET /feedback/undodelete/(:any)' => function($id) use ($feedback) {  
        if($id == "all") {
            $feedback->undo_deleted_feedback();
        } else {
            $feedback->_change_feedback('isDeleted', $id, 0);     
        } 
    },

    'GET /feedback/reply_to/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($feedback) { 

        $feedback_data = $feedback->pull_feedback_by_id($id);

        return View::of_layout()->partial('contents', 'feedback/reply_to_view', Array(
            'user' => S36Auth::user()
          , 'feedback' => $feedback_data 
          , 'feedid' => $id
          , 'errors' => Array()
          , 'input' => Array('subject' => null, 'message' => null)
        ));

    }),

    'POST /feedback/reply_to' => Array('do' => function() use ($feedback) { 

        $email = Input::get('email'); 

        $replydata = new Email\Entities\ReplyData; 
        $replydata->subject($email['subject'])
                  ->bcc($email['bcc'])
                  ->sendto($email['emailto'])
                  ->copyme((array_key_exists('email_me', $email)) ? $email['email_me'] : null, $email['replyto'])
                  ->from( 
                      (object) Array(
                        "replyto" => $email['replyto']
                      , "username"  => ucfirst($email['username'])
                      ) 
                    )
                  ->message($email['message'])
                  ->feedbackdata(json_decode($email['feedbackdata']));            
        $emailservice = new Email\Services\EmailService($replydata);  
        return $emailservice->send_email(); 
    }),

    'POST /feedback/fastforward' => Array('needs' => 'S36ValueObjects', 'do' => function() use ($feedback, $auth) {
        $data = (object)Input::get();
        $fastdata = new Email\Entities\FastForwardData;

        $fastdata->sendto = $data->email;
        $fastdata->from = ucfirst($auth->username);
        $fastdata->email_comment = "Feedback has been fast-forwarded to you for your review.";//$data->email_comment;
        $fastdata->feedback = $feedback->pull_feedback_by_id($data->feedid);
        $fastdata->companyid = $auth->companyid;
        $fastdata->make_forward_url();

        $emailservice = new Email\Services\EmailService($fastdata);
        return $emailservice->send_email();
    }),

    'GET /feedback/get_feedback_count' => Array('do' => function() use ($inbox, $redis, $company_name) {  
        if($redis->hget("$company_name:feedback_count", "count") != 0) {
            echo json_encode(Array( 'msg' => $inbox->read("inbox:notification:newfeedback") ));     
        } 
    }),

    'GET /feedback/mark_inbox_as_read' => Array('do' => function() use ($inbox, $redis, $company_name) {  
        //delete feedback count calculator
        $redis->del("$company_name:feedback_count");
        $redis->del("$company_name:new_feedback");
        echo json_encode(Array( 'msg' => $inbox->edit("inbox:notification:newfeedback", "") ));
    }),

    'POST /feedback/redis_feedback_process' => function() use ($inbox, $redis, $company_name) {
        $key = "$company_name:new_feedback";
        $group = Input::get('feedids');
        $collection = Array();
        foreach($group as $k) {
            $redis->srem($key, $k['feedid']);
        }
        $feedbackcount = count($redis->smembers($key));
        $redis->hmset("$company_name:feedback_count", "count", $feedbackcount);

        $mq    = new MessageList;
        $mq->add_message( new Notification("{$feedbackcount} New Feedback", "inbox:notification:newfeedback") );
        $director = new MessageDirector;
        $director->distribute_messages($mq); 
    },
);
