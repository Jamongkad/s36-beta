<?php

$feedback = new Feedback;
$category = new Category;

return array(
    'GET /feedback/modifyfeedback/(:num)' => Array('before' => 's36_auth', 'do' => function($id) use ($feedback, $category) {             
        return View::of_layout()->partial('contents', 'feedback/modifyfeedback', Array(
             'feedback' => $feedback->pull_feedback_by_id($id)
           , 'categories' => $category->pull_site_categories()
        ));
    }),

    'POST /feedback/edit_feedback_text' => function() {

        $badwords = new BadWords;
        $post = Input::get();

        $feed_id = $post['feed_id'];
        $text    = $post['feedback_text'];

        $badwords->profanity_detection($text, $feed_id); 
    },

    'GET /feedback/change_state/(\w+)/(\d+)' => function($state, $id) {
        $feedback = new Feedback;
        $feed_obj = Array('feedid' => $id);
        $result = $feedback->_toggle_multiple($state, Array($feed_obj));
        return Redirect::to('feedback/modifyfeedback/'.$id); 
    },

    'GET /feedback/requestfeedback' => Array('before' => 's36_auth', 'do' => function() { 
        return View::of_layout()->partial('contents', 'feedback/requestfeedback_view', Array(
            'sites' => DB::Table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
          , 'errors' => Array()
          , 'input' => Array('firstname' => null, 'lastname' => null, 'email' => null, 'custom_message' => "")
        ));
    }),

    'POST /feedback/requestfeedback' => Array('needs' => 'S36ValueObjects', 'do' => function() {
        $data = Input::get();
        $rules = Array(
            'firstname' => 'required'
          , 'lastname' => 'required'
          , 'email' => 'required|email'
          , 'custom_message' => 'required'
        );

        $validator = Validator::make($data, $rules);
        if(! $validator->valid() ) {
            return View::of_layout()->partial('contents', 'feedback/requestfeedback_view', Array(
                'sites' => DB::Table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get()
              , 'errors' => $validator->errors
              , 'input' => $data
            ));
        } else {      

            $auth = new S36Auth; 

            $metric = new Metric;
            $metric->company_id = $auth->user()->companyid;
            $metric->increment_request();  
        
            $vo = new RequestFeedbackData;
            $vo->first_name = $data['firstname'];
            $vo->last_name  = $data['lastname'];

            $factory = new EmailFactory($vo);

            $email_obj = new StdClass;
            $email_obj->email = $data['email'];

            $message_obj = new StdClass;
            $message_obj->custom_message = $data['custom_message'];
            $message_obj->user = $auth->user();
            $message_obj->company = $auth->user_company();
            $message_obj->sites = $data['site_id'];

            $factory->addresses = Array($email_obj);
            $factory->message = $message_obj;
            $email_page = $factory->execute();
     
            $emailer = new Email($email_page);
            $emailer->process_email();
            
            return View::of_layout()->partial('contents', 'feedback/requestfeedback_thankyou_view');
        }
    }),

    'GET /feedback/addfeedback' => Array('before' => 's36_auth', 'do' => function() {

        $company_id = S36Auth::user()->companyid;
        return View::of_layout()->partial('contents', 'feedback/addfeedback_view', Array(
            'sites' => DB::Table('Site', 'master')->where('companyId', '=', $company_id)->get()
          , 'countries' => DB::Table('Country', 'master')->get()
          , 'company_id' => $company_id
        ));
    }),

    'POST /feedback/addfeedback' => Array('needs' => 'S36ValueObjects', 'do' => function() { 
        $addfeedback = new AddFeedback;
        $addfeedback->create_feedback_with_profile();
        return Redirect::to('feedback/addfeedback'); 
    }),

    'GET /feedback/deletedfeedback' => Array('before' => 's36_auth', 'do' => function() use ($feedback) { 
        $undo_result = $feedback->fetch_deleted_feedback();
        echo "<pre>";
        echo print_r($undo_result);
        echo "</pre>";
    }),

    //Ajax Routes...
    'POST /feedback/changecat/(:num)/(:num)' => function($cat_id, $feed_id) use ($feedback) {
        //TODO: this could be better 
        $feed_obj = Array('feedid' => $feed_id);

        if($cat_id == 1) {
            $feedback->_toggle_multiple('fileas', Array($feed_obj), ",isArchived = 0, categoryId = $cat_id");     
        } else {  
            $feedback->_toggle_multiple('fileas', Array($feed_obj), ",isArchived = 1, categoryId = $cat_id");     
        }
 
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
        $feed_ids = Input::get('feed_ids');
        $cat_id   = Input::get('cat_id');
        $cat_state = Input::get('catstate');
        $mode     = Input::get('mode');         

        if($cat_state == "default") {
            //echo "Default Category";
            return $feedback->_toggle_multiple($mode, $feed_ids, ",isArchived = 0, categoryId = $cat_id");     
        } 
        
        if($cat_state != "default" && $cat_state != null){
            //echo "Archived Category";
            return $feedback->_toggle_multiple($mode, $feed_ids, ",isArchived = 1, categoryId = $cat_id");          
        }
       
        if($cat_state == null) {
            //echo "Inbox Operation";
            return $feedback->_toggle_multiple($mode, $feed_ids, ", categoryId = $cat_id");      
        }

    },

    'POST /feedback/toggle_feedback_display' => function() use ($feedback) {
        $state = 0;
        if(Input::get('check_val') == 'true') {
            $state = 1;    
        }
        $feedback->_change_feedback(  Input::get('column_name')
                                    , Input::get('feedid')
                                    , $state );
    },

    'POST /feedback/fire_multiple' => function() use ($feedback) {
        $feed_ids = Input::get('feed_ids');
        $mode     = Input::get('col'); 
        $cat_id   = Input::get('cat_id');

        if($mode == 'remove') {
            $feedback->_permanent_delete($feed_ids);
        } else {
            $feedback->_toggle_multiple($mode, $feed_ids, ", categoryId = $cat_id");
        } 
    },
    
    'GET /feedback/deletefeedback/(:num)' => function($id) use ($feedback) {
        $feedback->_change_feedback('isDeleted', $id, 1);
        $undo_result = $feedback->fetch_deleted_feedback();
        echo json_encode($undo_result);
    },

    'GET /feedback/undodelete/(:any)' => function($id) use ($feedback) {  
        if($id == "all") {
            $feedback->undo_deleted_feedback();
        } else {
            $feedback->_change_feedback('isDeleted', $id, 0);     
        } 
    },

    'GET /feedback/restorefeedback/(:num)' => function($id) use ($feedback) {
        $feedback->_change_feedback('isDeleted', $id, 0);      
        return Redirect::to('inbox/deleted'); 
    },

    'GET /feedback/removefeedback/(:num)' => function($id) use ($feedback) {
        $feedback->permanently_remove_feedback($id);
        return Redirect::to('inbox/deleted'); 
    },

    'POST /feedback/fastforward' => function() {
        Helpers::show_data(Input::get());
    }
);
