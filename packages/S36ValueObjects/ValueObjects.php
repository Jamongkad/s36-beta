<?php 

abstract class EmailData {

    public $publisher_email;

    public function get_type() {
        return get_class($this);
    }
}

class NewFeedbackSubmissionData extends EmailData {}

class PublishedFeedbackNotificationData extends EmailData { 
    public $publisher_email = null;
}
