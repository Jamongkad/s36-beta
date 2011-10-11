<?php

class EmailTest extends EnhanceTestFixture {
    
    public function testEmail() {
        $target = Enhance::getCodeCoverageWrapper('Email');
    }

    public function testUser() { 
        $target = Enhance::getCodeCoverageWrapper('User');
        $test = $target->pull_user_emails_by_company_id(2);
        Helpers::show_data($test);
        Assert::isNotNull($test);
    }

    public function testNewNotificationEmail() {

        $user = new User;
        $email = $user->pull_user_emails_by_company_id(2);

        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);

        $target = new NewFeedbackSubmission($email, $feedback, "36Stories Feedback Notification");
        $test = $target->get_message(); 
        Assert::contains('body', $test);
    }
}
