<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Input, DB;

class FeedbackDetails extends FeedbackDataTypes {

    public function set_contact_id($id) {
        $this->contact_id = $id;    
    }

}
