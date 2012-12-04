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
        });

        $tf->test("Feedback Inbox", function($tf)  {

            $social_services = Array(
                'tw' => $tf->data->twitter->pull_tweets_for('codiqa')
            );

            $tf->data->social = new Feedback\Services\SocialFeedback($social_services, new Feedback\Repositories\DBSocialFeedback);
            $tf->dump($tf->data->social->save_social_feeds('tw'));
            //$tf->data->social->clear_social_feeds('tw');
            /*
            $tf->dump($tf->data->social->save_social_feeds('facebook'));
            $tf->dump($tf->data->social->save_social_feeds('google'));
            */

            //$tf->dump($social_services['twitter']);
        });

        $tf->test("Twitter Feed Rate Status", function($tf)  {
            $rate_limit = $tf->data->twitter->get_rate_limit();
            $tf->dump($rate_limit);
        });

        $tf->run();
    },

    'GET /testify/hosted_feeds/(:any?)' => function($id=null) {
        $tf = new Testify("Hosted Feeds Test");
        $tf->beforeEach(function($tf) use ($id) {
            $mycompany = Config::get('application.subdomain');
            $razer = 'razer';
            $tf->data->hosted = new Feedback\Services\HostedService($mycompany);
            $tf->data->redis     = new redisent\Redis;
            $tf->data->key_name = $mycompany.":fullpage:data";
            $tf->data->page = $id;
        });

        $tf->test('Televised Feedback', function($tf) { 
            $tf->data->hosted->debug = True;
            $tf->data->hosted->page_number = $tf->data->page;
            $tf->data->hosted->build_data();
            $data = $tf->data->hosted->view_fragment();
            Helpers::dump($data);
        });    
        $tf->run();
    }, 

    'GET /testify/widgets' => function() { 
        $tf = new Testify("Widgets Test");
        
        $tf->beforeEach(function($tf) {
            $tf->data->dbw = new Widget\Repositories\DBWidget;
            $tf->data->widgetloader = new Widget\Services\WidgetLoader('47w09'); 
        });

        $tf->test('DBWidget', function($tf) {
            $tf->dump($tf->data->dbw);
            $tf->dump($tf->data->dbw->fetch_widget_by_id('47w09'));
            $tf->dump($tf->data->dbw->fetch_canonical_widget('mathew-staging'));
            $tf->dump($tf->data->widgetloader->load());
        });

        $tf->run();
    },

    'GET /testify/twitter_login' => function() { 
        $tf = new Testify("Twitter Login Test");
        
        $tf->beforeEach(function($tf) {
            $tf->data->twitter_key    = Config::get('application.dev_twitter_key');
            $tf->data->twitter_secret = Config::get('application.dev_twitter_secret');
            $tf->data->twitoauth = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret);
            $tf->data->companyid = 6;
        });

        $tf->test('Twitter', function($tf) { 

            $account = DB::Table('CompanyTwitterAccount', 'master')->where('companyId', '=', $tf->data->companyid)->first();
            
            if(!$account) {
                if(!Cookie::get('oauth_token_secret')) {   
                    $callback_url = Config::get('application.url').'/testify/twitter_login';
                    $token = $tf->data->twitoauth->getRequestToken($callback_url);
                    Cookie::put('oauth_token', $token['oauth_token']);
                    Cookie::put('oauth_token_secret', $token['oauth_token_secret']);
                    $login_url = $tf->data->twitoauth->getAuthorizeURL($token['oauth_token']);    
                    header('Location:'.$login_url);
                    exit;
                } else {
                    $twitoauth = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret
                                                , Cookie::get('oauth_token'), Cookie::get('oauth_token_secret'));
                    $token_credentials = $twitoauth->getAccessToken();

                    $tf->dump($token_credentials);
                    
                    if(!$account) { 
                        $data = Array(
                            'companyId' => $tf->data->companyid
                          , 'accountName' => $token_credentials['screen_name']
                          , 'oauthToken' => $token_credentials['oauth_token']
                          , 'oauthTokenSecret' => $token_credentials['oauth_token_secret']
                        );
                        DB::Table('CompanyTwitterAccount', 'master')->insert($data);
                    }

                    $connection = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret
                                                 , $token_credentials['oauth_token'], $token_credentials['oauth_token_secret']);
                    
                    $tf->dump($connection->get('account/verify_credentials'));
            
                    $tweets = $connection->get('statuses/home_timeline');
                    $collection = Array();
                    foreach($tweets as $tweet) {
                        $dt = new DateTime($tweet->created_at);
                        $node = new StdClass;
                        $node->id             = $tweet->id_str;
                        $node->firstname      = $tweet->user->name;
                        $node->screen_name    = $tweet->user->screen_name;
                        $node->avatar         = $tweet->user->profile_image_url_https;
                        $node->text           = $tweet->text;
                        $node->twit_date      = $tweet->created_at;
                        $node->feed_type      = 'tw';
                        $node->daysago        = Helpers::relative_time($dt->getTimestamp());
                        $node->date           = $dt->format("Y-m-d H:i:s");
                        $node->head_date      = $dt->format("d.m.Y");
                        $node->unix_timestamp = $dt->getTimestamp();
                        $node->datetimeobj    = $dt; 
                        $collection[] = $node;
                    }
                    $tf->dump($collection); 
                }                
            } else { 
                $tf->dump($account);
                $connection = new TwitterOAuth($tf->data->twitter_key, $tf->data->twitter_secret, $account->oauth_token, $account->oauth_token_secret);
                $tf->dump($connection);
            }
        });

        $tf->run();
    }

);
