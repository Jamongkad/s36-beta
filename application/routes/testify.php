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

    'GET /testify/activity' => function() { 
        $tf = new Testify("Feedback Activity Tests");
         
        $feedback_id = 522; 
        $company_id = 6;
        $user_id    = 15;
        $status = 'publish';

        $tf->beforeEach(function($tf) use ($feedback_id, $company_id, $user_id, $status) {
            $tf->data->fba = new Feedback\Services\FeedbackActivity($user_id, $feedback_id, $status);;  
        });
        
        $tf->test('Before logging in activity', function($tf) {
            $t = $tf->data->fba->check_activity_status();
            $tf->assertFalse($t);
        });

        $tf->test('Logging in activity', function($tf) { 
            $t = $tf->data->fba->log_activity();
            $tf->assert($t);

            $act = $tf->data->fba->check_activity_status();
            $tf->assert($act);

            $status = $tf->data->fba->check_activity_status();
            $tf->dump($status);
        });

        $tf->test('After logging in activity with database cleanup', function($tf) {
            $t = $tf->data->fba->check_activity_status();
            $tf->assertFalse($t);
        });

        $tf->test('Feedback Activity Test: Full Operation', function($tf) {
            $act = $tf->data->fba->check_activity_status();
            $tf->assertFalse($act);

            $t = $tf->data->fba->log_activity();
            $tf->assert($t); 
        });

        //Clean up at aisle Activity!!
        $tf->afterEach(function($tf) {
            $tf->data->fba->delete_activity();
        });

        $tf->run();
    },

    'GET /testify/publish' => function() {

        $feedback_id = 522; 
        $company_id = 6;
        $user_id    = 15;

        $tf = new Testify("Feedback Publish Tests");

        $tf->beforeEach(function($tf) use ($feedback_id, $company_id, $user_id) { 
            $tf->data->pub = new Feedback\Services\PublishService($feedback_id, $company_id, $user_id);     
            $tf->data->feedstate = new Feedback\Services\FeedbackState('publish', Array('feedid' => $feedback_id), $company_id);
        });

        $tf->test('Feedback State Test', function($tf) { 
            $tf->assert($tf->data->feedstate->change_state());
        });
        
        /*
        $tf->test('Test Publish', function($tf) {
            $t = $tf->data->pub->perform();
            $tf->assert();   
        });
        */

        $tf->run(); 
    }


);
