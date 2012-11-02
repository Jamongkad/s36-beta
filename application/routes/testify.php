<?php

return array(
    'GET /testify/contact' => function() { 
        $tf = new Testify("Contact Module Refactor");
        //requirements for contact key first:lastname:email:city:country
        //use redis hash to pull out records of a company's contacts
        //increment by 1 if contact key exists, create new one if not
        //create single contact identity for CRUD operations
        //aggregate feedback under contact identity
        //TODO: 09-13-2012 this feature will be temporarily closed off until further notice.
        $tf->run();
    },

    'GET /testify/publishservice' => function() { 

        $feedback_id = 522; 
        $company_id = 6;
        $user_id    = 15;
        $status = 'publish';

        $tf = new Testify("Feedback Publish Service Tests");
        $tf->beforeEach(function($tf) use ($feedback_id, $company_id, $user_id) {
            $tf->data->pub = new Feedback\Services\PublishService($feedback_id, $company_id, $user_id);              
        });
       
        $tf->test('Service Test', function($tf) {
            $tf->assert($tf->data->pub->perform());
        });
        
        //clean up
        $tf->afterEach(function($tf) use ($feedback_id, $company_id, $user_id, $status) {
            $tf->data->fba = new Feedback\Services\FeedbackActivity($user_id, $feedback_id, $status);
            $tf->data->fba->delete_activity();
            $tf->data->feedstate = new Feedback\Services\FeedbackState('inbox', Array(Array('feedid' => $feedback_id)), $company_id);
            $tf->data->feedstate->change_state();
        });

        $tf->run(); 
    },

    'GET /testify/settingmessage' => function() {

        $tf = new Testify("Setting Message Services Test");

        $tf->beforeEach(function($tf) {
            $tf->data->sm = new Message\Services\SettingMessage('rqs');       
        });
        
        $tf->test('Service Test', function($tf) {
            $tf->assert($tf->data->sm);
        });
        
        $tf->test('Test Get Message', function($tf) {
            $tf->data->sm->get_messages();
            $tf->dump($tf->data->sm->jsonify());
        });

        $tf->run(); 
    },

    'GET /testify/email' => function() {       

        $tf = new Testify("Email Test Service");

        $tf->beforeEach(function($tf) {
            $tf->data->feedback = new Feedback\Repositories\DBFeedback;
            $tf->data->replydata = new Email\Entities\ReplyData;
        });

        $tf->test('Email Test', function($tf) {  

            $replyto = "wrm932@gmail.com";
            $bcc = null;//"wrm932@gmail.com,karen_cayamanda@yahoo.com,klemengkid@gmail.com,";
            $tf->data->replydata
                      ->subject("Hey Mathew what's up?")
                      ->bcc($bcc)
                      ->sendto("wrm932@gmail.com")
                      ->copyme(1, $replyto)
                      ->from( 
                          (object) Array(
                            "replyto" => $replyto 
                          , "username"  => "Mathew"
                          ) 
                        )
                      ->message("Mathew is a kewl dude.")
                      ->feedbackdata($tf->data->feedback->pull_feedback_by_id(528));            

            $tf->dump($tf->data->replydata);  
            $emailservice = new Email\Services\EmailService($tf->data->replydata); 
            $tf->assert($emailservice->send_email());  
        });

        $tf->run();  
    },

    'GET /testify/message' => function() {  
        $tf = new Testify("Message Services/DB");

        $tf->beforeEach(function($tf) {
            $type = "rqs";
            $tf->data->dbm = new Message\Repositories\DBMessage($type);
            $tf->data->rdm = new Message\Repositories\RDMessage($type);       
        });
 
        $tf->test("SettingMessage Test", function($tf)  {
             
            $tf->data->dbmset = new Message\Services\SettingMessage($tf->data->dbm);
            $tf->data->dbmset->get_messages();
            $tf->dump($tf->data->dbmset->jsonify());
           
            $tf->data->rdmset = new Message\Services\SettingMessage($tf->data->rdm);
            $tf->data->rdmset->get_messages();
            $tf->dump($tf->data->rdmset->jsonify());
        });

        $tf->run();  
    },

    'GET /testify/inbox' => function() {  
        $tf = new Testify("Inbox Service");
        $tf->beforeEach(function($tf) {
            $tf->data->inbox_service = new Feedback\Services\InboxService;
        });

        $tf->test("Inbox Testing", function($tf)  {
            
            $filters = array(
                  'limit'=> 3
                , 'site_id'=> false 
                , 'filter'=> 'all' //(new arrivals) all (show only) featured published
                , 'choice'=> false //positive negative neutral profanity flagged mostcontent
                , 'date'  => false //date_new date_old
                , 'rating' => false //5 4 3 2 1
                , 'category' => false 
                , 'priority' => false //low medium high
                , 'status' => false //new inprogress closed
                , 'company_id' => 6
            );

            $tf->data->inbox_service->ignore_cache = True;
            $tf->data->inbox_service->set_filters($filters);
            $feedback = $tf->data->inbox_service->present_feedback();
            $tf->dump($feedback);
        });
        $tf->run();
    },

    'GET /testify/dbfeedback' => function() { 
        $tf = new Testify("New Inbox Test");

        $tf->beforeEach(function($tf) {
            $tf->data->feedback = new Feedback\Repositories\DBFeedback;
            $tf->data->pagination = new ZebraPagination;
            $tf->data->inboxservice = new Feedback\Services\InboxService;
            $tf->data->twitter    = new Feedback\Repositories\TWFeedback; 
            $tf->data->stub       = new Feedback\Repositories\Stub;
            $tf->data->redis      = new redisent\Redis;
        });

        $tf->test("Feedback Inbox", function($tf)  {

            $feedback_struct = array(
                'limit' => 300
              , 'offset' => Input::get('o')
              , 'step' => 100
            );

            $filters = array(
                  'limit'=> $feedback_struct['limit']
                , 'offset' => $feedback_struct['offset']
                , 'site_id'=> false 
                , 'filter'=> 'all' //(new arrivals) all (show only) featured published
                , 'choice'=> false //positive negative neutral profanity flagged mostcontent
                , 'date'  => false //date_new date_old
                , 'rating' => false //5 4 3 2 1
                , 'category' => false 
                , 'priority' => false //low medium high
                , 'status' => false //new inprogress closed
                , 'company_id' => 1
            );

            $checked_filters = $tf->data->inboxservice->_check_filters($filters);
            $feeds = $tf->data->feedback->gather_feedback($checked_filters);
            $mtwfeeds  = $tf->data->twitter->pull_twits_for('microsourcing');
            $ctwfeeds  = $tf->data->twitter->pull_twits_for('codiqa');
            $tests = Array($feeds->result, $mtwfeeds->result);

            $comb = Array();
            foreach($tests as $val) {
                foreach($val as $d)  {
                    $comb[] = $d;
                }
            } 

            usort($comb, function($a, $b) {
                $t1 = $a->unix_timestamp;
                $t2 = $b->unix_timestamp;
                return $t2 - $t1;
            });

            //$tf->dump(count($comb));
            //$tf->dump($feeds->total_rows);
            $tf->dump(range(0, $feedback_struct['limit'], $feedback_struct['step'])); 

            $tf->data->pagination->variable_name('p');
            $tf->data->pagination->selectable_pages(2);
            $tf->data->pagination->records(count($comb));
            $tf->data->pagination->offset_step(0);
            $tf->data->pagination->records_per_page(10);
            $tf->data->pagination->get_page();
            $tf->dump($tf->data->pagination);
            $tf->dump($tf->data->pagination->render());

            $children = Array();
            foreach(new LimitIterator(new ArrayIterator($comb), (($tf->data->pagination->get_page() - 1) * 10), 10) as $fr) { 
                $children[$fr->head_date]['date_format'] = $fr->head_date;
                $children[$fr->head_date]['daysago'] = $fr->daysago;
                $children[$fr->head_date]['dtadded'] = $fr->date;
                $children[$fr->head_date]['children'][] = $fr;
                $children[$fr->head_date]['children_count'] = count($children[$fr->head_date]['children']);
            }

            $tf->dump($children);

        });

        $tf->run();
    }
);
