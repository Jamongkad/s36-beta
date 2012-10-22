<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use Twitter\Twitter;
use \Feedback\Entities\FeedbackNode;

class TWFeedback {
    public function __construct() { 
        $tf->data->twitter = new Twitter\Twitter;
    }
}
