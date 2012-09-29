<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass, DB, Config, Helpers;

class ReplyData extends EmailData {

    public $sendto;    
    public $from;
    public $bcc;
    public $message; 
    public $feedback;
    public $copyme;

    public function subject($subject) {
        $this->subject = $subject;
        return $this;     
    }

    public function sendto($send) {
        $this->sendto = $send;
        return $this;     
    }

    public function message($message) {
        $this->message = $message;     
        return $this;
    }

    public function feedbackdata($feedback_data) {
        $this->feedback = $feedback_data;     
        return $this;
    }

    public function from($user_object) {
        $this->from = $user_object;
        return $this;
    }

    public function copyme($email_me, $replyto) {
        if($email_me) {
            $this->sendto .= ",".$replyto;
        }
        return $this;
    }

    public function bcc($bcc) { 
        $bcc = substr($bcc, 0, -1);
        $bcc = explode(",", $bcc);
        $bcc = array_unique($bcc);
        $bcc = implode(",", $bcc);
        $this->bcc = $bcc;
        return $this;
    }
}
