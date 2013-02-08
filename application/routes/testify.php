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
                  'limit'   => 3
                , 'site_id' => false 
                , 'filter' => 'all' //(new arrivals) all (show only) featured published
                , 'choice' => false //positive negative neutral profanity flagged mostcontent
                , 'date'   => false //date_new date_old
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

    'GET /testify/drivers' => function() { 
        $tf = new Testify("Inbox Drivers Test");

        $tf->beforeEach(function($tf) {
            $tf->data->twitter   = new Feedback\Repositories\TWFeedback; 
            $tf->data->stub      = new Feedback\Repositories\Stub; 
            $tf->data->companyid = 6;
        });

        $tf->test("Feedback Inbox", function($tf)  {

            $social_services = Array(
                'tw' => $tf->data->twitter->pull_tweets()
            );
            $social = new Feedback\Services\SocialFeedback($social_services, new Feedback\Repositories\DBSocialFeedback);
            $tf->dump($social_services['tw']);
            $tf->assert($social->save_social_feeds('tw'));
            /*
            $tf->data->social = new Feedback\Services\SocialFeedback($social_services, new Feedback\Repositories\DBSocialFeedback);
            $tf->dump($tf->data->social->save_social_feeds());
            */
            $tf->dump($social_services['twitter']);
        });

        $tf->test("Twitter Feed Rate Status", function($tf)  {
            $rate_limit = $tf->data->twitter->get_rate_limit();
            $tf->dump($rate_limit);
        });

        $tf->run();
    },

    'GET /testify/hosted_feeds/(:any?)' => function($page=null) {
        $tf = new Testify("Hosted Feeds Test");
        $tf->beforeEach(function($tf) use ($page) {
            $mycompany = Config::get('application.subdomain');
            $tf->data->hosted = new Feedback\Services\HostedService($mycompany);
            $tf->data->redis     = new redisent\Redis;
            $tf->data->key_name = $mycompany.":fullpage:data";
            $tf->data->page = $page;
        });

        $tf->test('Televised Feedback', function($tf) { 
            $tf->data->hosted->dump_build_data = True; 
            $tf->data->hosted->page_number = $tf->data->page;
            $tf->data->hosted->bust_hostfeed_data();
            $tf->data->hosted->build_data(); 
            $set = $tf->data->hosted->fetch_data_by_set();
            $tf->dump($set);
        });    
        $tf->run();
    }, 

    'GET /testify/widgets' => function() { 
        $tf = new Testify("Widgets Test");
        
        $tf->beforeEach(function($tf) {
            $tf->data->dbw = new Widget\Repositories\DBWidget;

        });

        $tf->test('DBWidget Alt a937i', function($tf) {
            $widgetloader = new Widget\Services\WidgetLoader('a937i', $load_submission_form=True); 
            $tf->dump($widgetloader->load());
        });

        $tf->test('DBWidget Alt upnjz', function($tf) {
            $widgetloader = new Widget\Services\WidgetLoader('upnjz', $load_submission_form=True); 
            $tf->dump($widgetloader->load());
        });

        $tf->test('DBWidget Canonical', function($tf) {
            $widgetloader = new Widget\Services\WidgetLoader('mathew-staging', $load_submission_form=True, $load_canonical=True); 
            $tf->dump($widgetloader->load());
        });
         
        $tf->test('Widget Creation', function($tf) {
        /*
            $data = Array(
                'widget_type' => 'display'
              , 'company_id' => 6
              , 'site_id' => 8
              , 'display_widgetkey' => Null
              , 'submit_widgetkey' => Null
              , 'widget_select' => 'embed'
              , 'theme_type' => 'form-contrast'
              , 'perms' => Array(
                    'feedbacksetupdisplay'  => Array(
                        'displayname' => 1
                      , 'displayimg' => 1
                      , 'displaycompany' => 1
                      , 'displayposition' => 1
                      , 'displayurl' => 1
                      , 'displaycountry' => 1
                      , 'displaysbmtdate' => 1
                    )
                )
              , 'theme_name' => 'Pewts'
              , 'form_text' => 'adshdkashd'
              , 'embed_effects' => 1
              , 'embed_type' => 'embedded'
              , 'embed_block_type' => 'embed_block_y'
              , 'submit_form_text' => 'asdasd'
              , 'submit_form_question' => 'Is Kennwel gay?'
            );
            
            $display_data = new Widget\Entities\DisplayValueObject($data);
            $form_data    = new Widget\Entities\FormValueObject($data);

            $display = new Widget\Entities\DisplayWidget;
            $display->set_widgetdata($display_data->data());

            $form = new Widget\Entities\FormWidget; 
            $form->set_widgetdata($form_data->data());

            $display->save();
            $form->save();
            $display->adopt($form);
            
            echo json_encode(Array(
                 'display' => $display->emit()
               , 'submit' => $form->emit()
            ));     
        */
        });

        $tf->run();
    },

    'GET /testify/social_account' => function() {
        $tf = new Testify("Social Account DB Test");

        $tf->beforeEach(function($tf) {
            $tf->data->dbw = new Company\Repositories\DBCompanySocialAccount;
        });

        $tf->test('DBWidget', function($tf) {
            $tf->dump($tf->data->dbw->fetch_social_account('twitter'));
            $tf->dump($tf->data->dbw->fetch_social_account('facebook'));
        });

        $tf->run();          
    },

    'GET /testify/formbuilder' => function() {

        $tf = new Testify("Form Builder");  

        $tf->test('Form Structure', function($tf) {
            $fake_db_vals = Array( 'form_structure' => '[
                {"cssClass":"input_text","required":"undefined","values":"First Name"}
               ,{"cssClass":"input_text","required":"undefined","values":"Last Name"}
               ,{"cssClass":"textarea","required":"undefined","values":"Bio"}
               ,{"cssClass":"checkbox","required":"checked","title":"What\'s on your pizza?",
                   "values":{
                       "2":{"value":"Extra Cheese","baseline":"checked"}
                      ,"3":{"value":"Pepperoni","baseline":"checked"}
                      ,"4":{"value":"Beef","baseline":"checked"}
                    }
                }
               ,{"cssClass":"radio","required":"checked","title":"What\'s on your pizza?",
                   "values":{
                       "2":{"value":"Extra Cheese","baseline":"undefined"}
                      ,"3":{"value":"Pepperoni","baseline":"checked"}
                      ,"4":{"value":"Beef","baseline":"undefined"}
                    }
                }
            ]');
            $form_render = new Widget\Services\Formbuilder\Formbuilder($fake_db_vals);
            $tf->dump($form_render->render_html());
        });

        $tf->run();          
    },

    'GET /testify/feedback/(:any?)' => function($feedid) { 
        $tf = new Testify("Feedback Functions");  
        $tf->test("Delete Feedback", function($tf) use ($feedid) {
            $dbfeedback = new Feedback\Repositories\DBFeedback;  
            //$result = $dbfeedback->pull_feedback_by_id($feedid);
            //$tf->dump($result);
            $dbfeedback->permanently_remove_feedback($feedid);
        });

        $tf->run();         
    },

    'GET /testify/adminreply' => function() {
        $tf = new Testify("Admin Reply");  
        $tf->beforeEach(function($tf) {
            $tf->data->dbadminreply = new Feedback\Repositories\DBAdminReply;
        });

        $tf->test("Testing Admin Reply", function($tf) {
            $data = array(
                'feedbackId' => 1101
               ,'adminReply' => "All the extra love that you gave me."
            );

            $tf->assert($tf->data->dbadminreply->get_admin_reply(1101));
            $tf->dump($tf->data->dbadminreply->add_admin_reply($data));
            $tf->assert($tf->data->dbadminreply->email_admin_reply('mathew@36stories.com', 1101));
        });
        
        $tf->run();         
    },

    'GET /testify/total_newfeedback' => function() {
        $tf = new Testify("Total New Feedback");  
        $tf->beforeEach(function($tf) {
            $tf->data->dbfeedback = new Feedback\Repositories\DBFeedback;
        });

        $tf->test("Testing New Feedback Count ", function($tf) { 
            $count = $tf->data->dbfeedback->total_newfeedback_by_company(); 
            $tf->dump($count);
        });
        
        $tf->run();          
    },
    
    'GET /testify/messageservice' => function() { 

        $tf = new Testify("Message Service");  

        $tf->test("MessageService: Inserting Message", function($tf) { 

            $im = new Message\Entities\Types\Inbox\Notification("8 New Feedback", "inbox:notification:newfeedback");
            $st = new Message\Entities\Types\Inbox\Stub("8 New Stubs", "inbox:notification:stub");

            $mq = new Message\Entities\MessageList;
            $mq->add_message($im);
            $mq->add_message($st);

            $director = new Message\Services\MessageDirector;
            $director->distribute_messages($mq); 

        }); 

        $tf->test("MessageService: Reading Message", function($tf) { 
            $auth = S36Auth::user();
            $inbox = new Message\Entities\UserInbox("{$auth->username}:messages");
            $inbox->edit("inbox:notification:newfeedback", "8 New Feedback");
            Helpers::dump($inbox->read_all());
            Helpers::dump($inbox->read("inbox:notification:newfeedback"));
        });
        $tf->run();          
    },

    'GET /testify/quickinbox' => function() { 
        $tf = new Testify("Quick Inbox");  

        $tf->beforeEach(function($tf) {
            $tf->data->dbfeedback = new Feedback\Repositories\DBFeedback;
        });
 
        $tf->test("Quick Inbox: DBFeedback", function($tf) {  
            $count = $tf->data->dbfeedback->total_newfeedback_by_company(); 
            $tf->dump($count);
        });

        $tf->run();          
    }
);
