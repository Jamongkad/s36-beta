<?php namespace Email\Services;

use Email\Entities\Types\EmailData;
use Email\Entities\NewFeedbackSubmission;
use Email\Entities\PublishedFeedback;
use Email\Entities\RequestFeedback;
use Email\Entities\Invitation;
use Email\Entities\FastForward;
use Email\Entities\Reply;
use Email\Entities\ResendPassword;

class EmailService { 

    private $opts;
    public $addresses, $message, $feedback;

    public function __construct(EmailData $email_data) { 
        $this->email_data = $email_data;
    }
    
    public function send_email() {

        if($this->email_data->get_type() == 'Email\Entities\NewFeedbackSubmissionData') {
            $email = new NewFeedbackSubmission;
            $email->gather($this->email_data);
            return $email->send();
        } 

        if($this->email_data->get_type() == 'Email\Entities\PublishedFeedbackData') {
            $email = new PublishedFeedback;
            $email->gather($this->email_data);
            return $email->send();
        } 

        if($this->email_data->get_type() == 'Email\Entities\RequestFeedbackData') {
            $email = new RequestFeedback;
            $email->gather($this->email_data);
            return $email->send();
        }

        if($this->email_data->get_type() == 'Email\Entities\InvitationData') {
            $email = new Invitation;
            $email->gather($this->email_data);
            return $email->send();
        }

        if($this->email_data->get_type() == 'Email\Entities\FastForwardData') {
            $email = new FastForward;
            $email->gather($this->email_data);
            return $email->send();
        }

        if($this->email_data->get_type() == 'Email\Entities\ReplyData') {
            $email = new Reply;
            $email->gather($this->email_data);
            return $email->send();
        }

        if($this->email_data->get_type() == 'Email\Entities\ResendPasswordData') {
            $email = new ResendPassword;
            $email->gather($this->email_data);
            return $email->send();
        }
    }
}
