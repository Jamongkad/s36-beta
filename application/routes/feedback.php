<?php

$feedback = new Feedback\Repositories\DBFeedback;
$category = new DBCategory;
$dbwidget = new Widget\Repositories\DBWidget;
$badwords = new DBBadWords;

use Feedback\Entities\ContactDetails;
use Feedback\Entities\FeedbackDetails;
use Halcyonic\Services\HalcyonicService;

return array(
    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($feedback, $category) {
         
        return View::of_layout()->partial('contents', 'feedback/modifyfeedback', Array(
             'feedback' => $feedback->pull_feedback_by_id($id)
           , 'categories' => $category->pull_site_categories()
           , 'status' => DB::table('Status', 'master')->get()
           , 'priority_obj' => (object)Array(0 => 'low', 60 => 'medium', 100 => 'high')
           , 'admin_check' => S36Auth::user()
        ));
    }),

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
        }
    },

    'GET /feedback/requestfeedback' => Array('before' => 's36_auth', 'do' => function() use ($dbwidget) { 
        $company_id = S36Auth::user()->companyid;
 
        return View::of_layout()->partial('contents', 'feedback/requestfeedback_view', Array(
            'sites' => DB::Table('Site', 'master')->where('companyId', '=', $company_id)->get()
          , 'submission_widgets' => $dbwidget->fetch_widgets_by_company() 
          , 'errors' => Array()
          , 'input' => Array('first_name' => null, 'last_name' => null, 'email' => null, 'message' => "")
        ));
    }),

    'POST /feedback/requestfeedback' => Array('needs' => 'S36ValueObjects', 'do' => function() use ($dbwidget) {
        $data = Input::get();
        $underscore = new Underscore\Underscore;
        $company_id = S36Auth::user()->companyid;
        $widgets = $underscore->first($dbwidget->fetch_widgets_by_company()->form_widgets->widget->widgets);
        $site = DB::Table('Site', 'master')->where('companyId', '=', $company_id)->first();
        
        /*
        $metric = new DBMetric;
        $metric->company_id = $company_id 
        $metric->increment_request();  
        */
    
        $request_data = new Email\Entities\RequestFeedbackData;
        $request_data->sendto = (object) Array(
            'first_name' => $data['first_name']
          , 'last_name' => $data['last_name']
          , 'email' => $data['email']
        );
        $request_data->message = $data['message'];
        $request_data->from = S36Auth::user(); 
        $request_data->sites = $site->siteid;
        $request_data->widgetkey = $widgets->widgetkey;
        
        $emailservice = new Email\Services\EmailService($request_data);
        return $emailservice->send_email();
        /*
        $rules = Array(
            'first_name' => 'required'
          , 'last_name' => 'required'
          , 'email' => 'required|email'
          , 'message' => 'required'
        );

        $validator = Validator::make($data, $rules);
        if(! $validator->valid() ) {
            return View::of_layout()->partial('contents', 'feedback/requestfeedback_view', Array(
                'sites' => DB::Table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
              , 'submission_widgets' => $dbwidget->fetch_widgets_by_company() 
              , 'errors' => $validator->errors
              , 'input' => $data
            ));
        } else {      
         
            $metric = new DBMetric;
            $metric->company_id = $auth->user()->companyid;
            $metric->increment_request();  
        
            $request_data = new Email\Entities\RequestFeedbackData;
            $request_data->sendto = (object) Array(
                'first_name' => $data['first_name']
              , 'last_name' => $data['last_name']
              , 'email' => $data['email']
            );
            $request_data->message = $data['message'];
            $request_data->from = S36Auth::user(); 
            $request_data->sites = $data['site_id'];
            $request_data->widgetkey = $data['widgetkey'];
            
            $emailservice = new Email\Services\EmailService($request_data);
            $emailservice->send_email();
            return View::of_layout()->partial('contents', 'feedback/requestfeedback_thankyou_view',
                                              array("linkback" => "requestfeedback"));  
        }
        */
    }),

    'GET /feedback/addfeedback' => Array('before' => 's36_auth', 'do' => function() {
        $company_id = S36Auth::user()->companyid;
        return View::of_layout()->partial('contents', 'feedback/addfeedback_view', Array(
            'sites' => DB::Table('Site', 'master')->where('companyId', '=', $company_id)->get()
          , 'countries' => DB::Table('Country', 'master')->get()
          , 'company_id' => $company_id
          , 'errors' => Array()
          , 'input' => Array('first_name' => null, 'last_name' => null, 'email' => null, 'feedback' => "", 'city' => null)
        ));
    }),

    'POST /feedback/addfeedback' => Array('do' => function() { 
        $data = Input::get();
        $rules = Array(
            'first_name' => 'required'
          , 'email' => 'email'
          , 'feedback' => 'required'
          , 'city' => 'required'
          , 'country' => 'required'
        );

        $validator = Validator::make($data, $rules);
        if(! $validator->valid() ) {
            return View::of_layout()->partial('contents', 'feedback/addfeedback_view', Array(
                'sites' => DB::Table('Site', 'master')->where('companyId', '=', $data['company_id'])->get()
              , 'countries' => DB::Table('Country', 'master')->get()
              , 'company_id' => $data['company_id']
              , 'errors' => $validator->errors
              , 'input' => $data
            ));
        } else {
            $addfeedback = new Feedback\Services\SubmissionService(Input::get());
            $addfeedback->perform(); 
            return Redirect::to('inbox/all');  
        }
    }),

    //Ajax Routes...
    'GET /feedback/bust_hostfeed_data' => function() { 
        $company_name = Config::get('application.subdomain');
        $hosted = new Feedback\Services\HostedService($company_name);
        $hosted->bust_hostfeed_data();
    },

    'POST /feedback/changestatus' => function() use ($feedback) { 
        $feedback->_change_feedback('status', Input::get('feed_id'), Input::get('select_val'));
    },

    'POST /feedback/changepriority' => function() use ($feedback) { 
        $rating_table = Array(
            'low' => 0
          , 'medium' => 60
          , 'high' => 100
        ); 
        $feedback->_change_feedback('priority', Input::get('feed_id'), $rating_table[Input::get('select_val')]);
    },

    'POST /feedback/flagfeedback' => function() use ($feedback) {  
        $feed_id = Input::get('feed_ids'); 
        $id = array_map(function($obj) { return $obj['feedid']; }, $feed_id);
        $feedback->_change_feedback('isFlagged', $id[0], Input::get('state'));
    },
     
    'POST /feedback/change_feedback_state' => function() use ($feedback) { 
        $feed_ids   = Input::get('feed_ids');
        $cat_id     = Input::get('cat_id');
        $mode       = Input::get('mode');         
        $company_id = (Input::get('company_id')) ? Input::get('company_id') : S36Auth::user()->companyid;

        $feedbackstate = new Feedback\Services\FeedbackState($mode, $feed_ids, $company_id, $cat_id);
        $feedbackstate->change_state();
    },

    'POST /feedback/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val')) {
            $state = 1;    
        }
        $feedback->_change_feedback(  Input::get('column_name')
                                    , Input::get('feedid')
                                    , $state );
    },

    'POST /feedback/lock_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val')) {
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
        $bcc = Input::get('bcc');

        $feedback_data = $feedback->pull_feedback_by_id(Input::get('feedbackid')); 

        $replydata = new Email\Entities\ReplyData; 
        $replydata->subject = Input::get('subject');

        if($bcc) { 
            $bcc = substr($bcc, 0, -1);
            $bcc = explode(",", $bcc);
            $bcc = array_unique($bcc);
            $replydata->bcc = $bcc;
        }

        $copyme = null;
        if(Input::get('email_me')) {
            $copyme = ",".Input::get('replyto');
        }
        
        $replydata->sendto = Input::get('emailto').$copyme;
        $replydata->from = (object) Array(
            "replyto" => Input::get('replyto')
          , "username"  => ucfirst(Input::get('username'))
        );
        $replydata->message = Input::get('message');
        $replydata->feedback = $feedback_data;

        $emailservice = new Email\Services\EmailService($replydata);  
        $emailservice->send_email(); 
        return true;
        /*
        Helpers::dump(Input::get());
        $data = Input::get();
        $feedback_data = $feedback->pull_feedback_by_id($data['feedbackid']); 

        $rules = array(
            'subject' => 'required'
          , 'message' => 'required'
        );
 
        $validator = validator::make($data, $rules);
        
        if(!$validator->valid()) {
            $user = S36Auth::user();         
            return View::of_layout()->partial('contents', 'feedback/reply_to_view', Array(
                'user' => $user 
              , 'feedback' => $feedback_data 
              , 'feedid' => $data['feedbackid']
              , 'errors' => $validator->errors
              , 'input' => $data
            ));
        } else { 
            $replydata = new Email\Entities\ReplyData;
            
            $replydata->subject = $data['subject'];
            $replydata->bcc = $data['bcc'];
            $replydata->sendto = $data['emailto'] ;
            $replydata->from = (object) Array(
                "replyto" => $data['replyto'] 
              , "username"  => ucfirst($data['username'])
            );
            $replydata->message = $data['message'];
            $replydata->feedback = $feedback_data;
 
            $emailservice = new Email\Services\EmailService($replydata);  
            $emailservice->send_email(); 
            return View::of_layout()->partial('contents', 'feedback/requestfeedback_thankyou_view',
                                              array("linkback" => "reply_to/".$data['feedbackid']));  
        }
        */ 
    }),

    'POST /feedback/fastforward' => Array('needs' => 'S36ValueObjects', 'do' => function() use ($feedback) {
        $data = (object)Input::get();
        $auth = new S36Auth;

        $fastdata = new Email\Entities\FastForwardData;

        $fastdata->sendto = $data->email;
        $fastdata->from = ucfirst($auth->user()->username);
        $fastdata->email_comment = $data->email_comment;
        $fastdata->feedback = $feedback->pull_feedback_by_id($data->feed_id);
        $fastdata->receiver_details();
        $fastdata->make_forward_url();

        $emailservice = new Email\Services\EmailService($fastdata);
        $emailservice->send_email();
    }) 
);
