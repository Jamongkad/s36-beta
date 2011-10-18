<?php

class EmailTest extends EnhanceTestFixture {
    
    public function testUser() { 
        $target = Enhance::getCodeCoverageWrapper('User');
        $test = $target->pull_user_emails_by_company_id(1);
        Assert::isNotNull($test);
    }

    public function testFeedback() { 
        $fb = new Feedback;
        $feedback = $fb->pull_feedback_by_id(66);
        Assert::isNotNull($feedback);
    }

    public function testNewNotificationEmail() {

        $vo = new NewFeedbackSubmissionData;
        $vo->company_id = 1;
        $vo->feedback_id = 66; 

        $factory = new EmailFactory($vo);
        $email_page = $factory->execute();
       
        Assert::contains('body', $email_page[1]->get_message());
    }

    public function testPublishedNotificationEmail() {

        $vo = new PublishedFeedbackNotificationData;
        $vo->company_id = 1;
        $vo->feedback_id = 66;
        $vo->publisher_email = "mathew@36stories.com";
       
        $factory = new EmailFactory($vo);
        $email_page = $factory->execute();
       
        Assert::contains('body', $email_page[1]->get_message());
    }

}
