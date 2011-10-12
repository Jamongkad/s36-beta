<?php

class EmailTest extends EnhanceTestFixture {
    
    public function __construct() {
        $this->target = Enhance::getCodeCoverageWrapper('Email');
    }

    public function testUser() { 
        $target = Enhance::getCodeCoverageWrapper('User');
        $test = $target->pull_user_emails_by_company_id(1);
        //Helpers::show_data($test);
        Assert::isNotNull($test);
    }

    public function testFeedback() { 
        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);
        //Helpers::show_data($feedback);
        Assert::isNotNull($feedback);
    }

    public function testNewNotificationEmail() {

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

        Assert::contains('body', $email_page[0]->get_message());
    }
}
