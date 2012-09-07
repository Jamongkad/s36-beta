<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataAccess;

class FeedbackDetailsData extends FeedbackDataAccess {

    public function __construct($post_data) {
        $this->post_data = $post_data;
    }
    
} 
