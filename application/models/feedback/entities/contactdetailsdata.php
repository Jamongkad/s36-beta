<?php namespace Feedback\Entities;

class ContactDetailsData extends FeedbackDataAccess {

    public function __construct($post_data) {
        $this->post_data = $post_data;
    }
    
} 
