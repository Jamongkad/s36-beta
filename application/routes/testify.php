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
    
    'GET /testify/feedbackreports' => function() {     
        $tf = new Testify("Feedback Reports");

        $tf->beforeEach(function($tf) {
            $tf->data->fr = new Feedback\Repositories\DBFeedbackReports;
            $tf->data->underscore = new Underscore\Underscore;
        });
        
        $tf->test('Test', function($tf) {
            $reports = $tf->data->fr->get_reports_by_companyid(6);
            $result = $tf->data->underscore->groupBy($reports, 'feedbackid');
            $tf->assert(array_key_exists(20000, $result));
            $tf->assert(array_key_exists(1300, $result));
            $tf->dump($result);
        });
        

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

    'GET /testify/email/(:any?)' => function($id=Null) {       

        $tf = new Testify("Email Test Service");

        $tf->beforeEach(function($tf) use ($id) {
            $tf->data->feedback = new Feedback\Repositories\DBFeedback;
            $tf->data->dbuser    = new DBUser;
            $tf->data->id = $id;
        });

        $tf->test('Email Test', function($tf) {  
            $feedback = $tf->data->feedback->pull_feedback_by_id($tf->data->id);
            $accounts = $tf->data->dbuser->pull_user_emails_by_company_id(6);

            $submission_data = new Email\Entities\NewFeedbackSubmissionData; 
            $submission_data->set_feedback($feedback)
                            ->set_sendtoaddresses($accounts);
 
            $emailservice = new Email\Services\EmailService($submission_data);
            $emailservice->send_email();

            $autopublish = new Email\Entities\AutopublishData; 
            $autopublish->set_feedback($feedback)
                            ->set_sendtoaddresses($accounts);
 
            $emailservice = new Email\Services\EmailService($autopublish);
            $emailservice->send_email();
        });

        $tf->run();  
    },

    'GET /testify/message' => function() {  
        $tf = new Testify("Message Services/DB");

        $tf->beforeEach(function($tf) {
            $type = "msg";
            $tf->data->dbm = new Message\Repositories\DBMessage($type);
        });
 
        $tf->test("SettingMessage Test", function($tf)  {
             
            $tf->data->dbmset = new Message\Services\SettingMessage($tf->data->dbm);

            $tf->data->dbmset->get_messages();
            $tf->dump($tf->data->dbmset->jsonify());

            $tf->data->dbmset->get(28);
            $tf->dump($tf->data->dbmset->jsonify());
            $tf->dump($tf->data->dbmset->dbresult());
           
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
                , 'filter' => 'published' //(new arrivals) all (show only) featured published
                , 'choice' => 'all' //positive negative neutral profanity flagged mostcontent
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
            $tf->dump($social_services);
            /*
            $tf->data->social = new Feedback\Services\SocialFeedback($social_services, new Feedback\Repositories\DBSocialFeedback);
            $tf->dump($tf->data->social->save_social_feeds());

            $tf->dump($social_services['twitter']);
            */

        });

        $tf->run();
    },

    'GET /testify/hostedfeeds/(:any?)' => function($page=null) {
        $tf = new Testify("Hosted Feeds Test");
        $tf->beforeEach(function($tf) use ($page) {
            $tf->data->dbfeedback = new Feedback\Repositories\DBFeedback;  
        });

        $tf->test('Televised Feedback', function($tf) use($page) {  

            $company_name = Config::get('application.subdomain');

            $fb = $tf->data->dbfeedback->televised_feedback_alt($company_name);

            $hosted = new Feedback\Services\HostedService($company_name, $fb->result, 'Treble');
            $hosted->page_number = $page; 
            $hosted->debug = True; 
            $hosted->dump_build_data = True; 
            $hosted->build_data();

            /*
            $feeds = $hosted->fetch_data_by_set();        
            $tf->dump($feeds);
            */
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
            $result = $dbfeedback->pull_feedback_by_id($feedid);
            $tf->dump($result);
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
 
    'GET /testify/messageservice' => function() { 

        $tf = new Testify("Message Service");  

        $tf->beforeEach(function($tf) { 
            $tf->data->redis = new redisent\Redis;
        });

        $tf->test("MessageService: Testing Inbox Message Increment", function($tf) { 
            /*
            $tf->data->redis->hincrby("mathew-staging:feedback_count", "count", 1);
            $result = $tf->data->redis->hget("mathew-staging:feedback_count", "count");
            $tf->dump($result);
            */

            $result = $tf->data->redis->smembers("mathew-staging:new_feedback");
            $tf->dump($result);
            $feedback_count = count($result);
            $tf->dump($feedback_count);
            $tf->data->redis->hmset("mathew-staging:feedback_count", "count", $feedback_count);
        });
        /*
        $tf->test("MessageService: Inserting Message", function($tf) { 
            $im = new Message\Entities\Types\Inbox\Notification("8 New Feedback", "inbox:notification:newfeedback");
            $st = new Message\Entities\Types\Inbox\Stub("8 New Stubs", "inbox:notification:stub");

            $mq = new Message\Entities\MessageList;
            $mq->add_message($im);
            $mq->add_message($st);

            $director = new Message\Services\MessageDirector;
            $director->distribute_messages($mq); 
        }); 

        */
        $tf->test("MessageService: Reading Message", function($tf) { 
            $auth = S36Auth::user();
            $inbox = new Message\Entities\UserInbox("{$auth->username}:messages"); 
            Helpers::dump($inbox->read_all());
            Helpers::dump($inbox->read("inbox:notification:newfeedback"));
        });

        $tf->run();          
    },

    'GET /testify/quickinbox' => function() { 
        $tf = new Testify("Quick Inbox");  

        $tf->beforeEach(function($tf) {
            $tf->data->hosted_settings = new Hosted\Repositories\DBHostedSettings;
            $tf->data->dbfeedback = new Feedback\Repositories\DBFeedback;
        });
        

        $tf->test("Quick Inbox: DBFeedback", function($tf) {  
            $filter = Array(
                'company_id'     => 6
              //, 'rating'         => 'positive'
              , 'privacy_policy' => 'all'
            );
            $feedback = $tf->data->dbfeedback->newfeedback_by_company($filter); 
            $tf->dump($feedback);
        });

        $tf->run();          
    },

    'GET /testify/dbdash' => function() {
        
        $tf = new Testify("DBDashboard Test");  

        $tf->beforeEach(function($tf) {
            $tf->data->dbdashboard = new DBDashboard(6);
            $tf->data->feedback = new Feedback\Repositories\DBFeedback;
            $tf->data->contact = new Contact\Repositories\DBContact;
       });

        $tf->test("Test", function($tf) {
            $tf->dump($tf->data->dbdashboard->get_feedback_scores());
            /*
            $tf->dump($tf->data->dbdashboard->get_geochart_scores());
            $tf->dump($tf->data->dbdashboard->check_summary());
            $tf->dump($tf->data->feedback->total_feedback_by_company(6));
            */
        });

        $tf->run();
    },

    'GET /testify/twitteroauth' => function() { 
        $tf = new Testify("Twitter OAuth");  

        $tf->beforeEach(function($tf) { 
            $tf->data->redis = new redisent\Redis;
            $tf->data->social_account = new Company\Repositories\DBCompanySocialAccount;
            $tf->data->redis_oauth_key = Config::get('application.subdomain').':twitter:oauth';
            $tf->data->twitter_key    = Config::get('application.dev_twitter_key');
            $tf->data->twitter_secret = Config::get('application.dev_twitter_secret');
        });
        
        $tf->test("Test", function($tf) {

            $twitoauth = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret);

            if($tf->data->redis->hgetall($tf->data->redis_oauth_key) == false) {    
                $callback_url = Config::get('application.url').'/testify/twitteroauth';
                $token = $twitoauth->getRequestToken($callback_url);
                $login_url = $twitoauth->getAuthorizeURL($token['oauth_token'], $sign_in_with_twitter=False);     

                $tf->data->redis->hset($tf->data->redis_oauth_key, 'oauth_token', $token['oauth_token']);
                $tf->data->redis->hset($tf->data->redis_oauth_key, 'oauth_token_secret', $token['oauth_token_secret']);

                $tf->dump($token);
                $tf->dump($login_url); 
            } else {
                $token = $tf->data->redis->hget($tf->data->redis_oauth_key, 'oauth_token');
                $token_secret = $tf->data->redis->hget($tf->data->redis_oauth_key, 'oauth_token_secret');

                $connection = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret, $token, $token_secret); 
                $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);

                $tf->dump($_REQUEST);
                $tf->dump($token_credentials);

                $account = $tf->data->social_account->fetch_social_account('twitter');
                if(!$account) { 
                    $user = S36Auth::user(); 

                    $twitter_account_data = Array( 
                        'accountName' => $token_credentials['screen_name']
                      , 'oauthToken' => $token_credentials['oauth_token']
                      , 'oauthTokenSecret' => $token_credentials['oauth_token_secret']
                    );

                    $data = Array(
                        'companyId' => $user->companyid
                      , 'socialAccountOrigin' => 'twitter'
                      , 'socialAccountValue' => Helpers::wrap($twitter_account_data)
                    );

                    $tf->data->social_account->save_social_account($data);
                }
                $tf->data->redis->del($tf->data->redis_oauth_key);
            }

        });

        $tf->test("Long Lasting Credentials", function($tf) { 
            $account = $tf->data->social_account->fetch_social_account('twitter');
            if($account) { 
                $token_credentials = Helpers::unwrap($account->socialaccountvalue);
                $me = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret, $token_credentials['oauthToken'], $token_credentials['oauthTokenSecret']);
                $account = $me->get('account/verify_credentials');
                $tweets = $me->get('statuses/home_timeline');
                $tf->dump($account);
                $tf->dump($tweets); 
            }
        });

        $tf->run();
    }

);
