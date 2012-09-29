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
            $tf->data->fba = new Feedback\Services\FeedbackActivity($user_id, $feedback_id, $status);;  
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
            $tf->data->slug = new Email\Entities\Slug;
        });

        $tf->test('Email Test', function($tf) { 

            $bcc = 'leicaaah18@gmail.com,klemengkid@gmail.com,';
            $bcc = substr($bcc, 0, -1);
            $bcc = explode(",", $bcc);
            $bcc = array_unique($bcc);
            $bcc = implode(",", $bcc);

            $email_data = new StdClass;
            $email_data->sendto  = "wrm932@gmail.com";

            $email_data->from = (object) Array(
                "replyto" => "mathew@36stories.com"
            );

            $email_data->bcc = $bcc;
            $tf->data->slug->gather($email_data);
            $tf->dump($tf->data->slug);
            $tf->assert($tf->data->slug->send());
        });

        $tf->run();  
    },
);
