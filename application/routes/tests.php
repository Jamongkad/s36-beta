<?php

return array(
    'GET /tests/test_blob' => function() { 
        Package::load('EnhanceTestFramework');
        Enhance::runTests();
    },

    'GET /tests/test_email' => function() {

        $email = new Email;
        $user = new User;
        $email = $user->pull_user_emails_by_company_id(2);

        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);

        $opts = (object)Array(
            'addresses' => $email
          , 'message'   => $feedback
          , 'email_type' => 'NewFeedbackSubmission' 
        );

        $factory = new EmailFactory($opts);
        $email_page = $factory->execute();

        return $email_page[1]->get_message();
    },
);
