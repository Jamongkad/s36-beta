<?php

Package::load('S36ValueObjects');

return array(
    'GET /tests/test_blob' => function() { 
        Package::load('EnhanceTestFramework');
        Enhance::runTests();
    },

    'GET /tests/test_email_new' => function() {

        $vo = new NewFeedbackSubmissionData;

        $factory = new EmailFactory($vo);
        $factory->company_id = 1;
        $factory->feedback_id = 66;
        $email_pages = $factory->execute();
       
        //return $email_pages[1]->get_message();
        $email = new Email($email_pages);
        $email->process_email();
    },

    'GET /tests/test_email_published' => function() {

        $vo = new PublishedFeedbackNotificationData;
        $vo->publisher_email = "mathew@36stories.com";
       
        $factory = new EmailFactory($vo);
        $factory->company_id = 1;
        $factory->feedback_id = 66;
        $email_page = $factory->execute();
         
        return $email_page[1]->get_message();
    },
);
