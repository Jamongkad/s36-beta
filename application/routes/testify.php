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
            $tf->data->pub = new Feedback\Services\PublishService($feedback_id, $company_id, $user_id); 
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

        $tf->test('Publishing Service Test: Full Operation', function($tf) {
            $act = $tf->data->fba->check_activity_status();
            $tf->assert($act);

            $t = $tf->data->fba->log_activity();
            $tf->assert($t); 
        });

        //Clean up at aisle Activity!!
        $tf->afterEach(function($tf) {
            $tf->data->fba->delete_activity();
        });

        $tf->run();
    }
);
