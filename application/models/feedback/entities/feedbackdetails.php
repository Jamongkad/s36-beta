<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Input, DB, UserInfo, Profile\Services\ProfileImage;

class FeedbackDetails extends FeedbackDataTypes {

    public function set_contact_id($id) {
        $this->contact_id = $id;    
    }

}
