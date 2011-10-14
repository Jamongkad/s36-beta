<?php

return array(
    'GET /tests/test_blob' => function() { 
        Package::load('EnhanceTestFramework');
        Enhance::runTests();
    },

    'GET /tests/test_email_new' => function() {

        $email = new Email;
        $user = new User;
        $addresses = $user->pull_user_emails_by_company_id(1);

        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);

        Package::load('S36ValueObjects');

        $vo = new EmailData;

        $vo->addresses = $addresses;
        $vo->message = $feedback;
        $vo->email_type = 'NewFeedbackSubmission';

        $factory = new EmailFactory($vo);
        $email_page = $factory->execute();

        return $email_page[1]->get_message();
    },

    'GET /tests/test_email_published' => function() {

        $email = new Email;
        $user = new User;
        $addresses = $user->pull_user_emails_by_company_id(1);

        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);

        Package::load('S36ValueObjects');

        $vo = new EmailData;
        //Published Feedback Notification
        $vo->addresses = $addresses;
        $vo->message = $feedback;
        $vo->email_type = 'PublishedFeedbackNotification';
        $vo->publisher_email = "mathew@36stories.com";
       
        $factory = new EmailFactory($vo);
        $email_page = $factory->execute();
         
        return $email_page[1]->get_message();
    },
);
