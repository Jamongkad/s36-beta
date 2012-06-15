<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Input, DB;

class FeedbackDetails extends FeedbackDataTypes {

    private $contact_id, $company_id, $feedback_data;

    public function set_contact_id($contact_id) {
        $this->contact_id = $contact_id;    
    }

    public function set_company_id($company_id) {
        $this->company_id = $company_id; 
    }
    
    public function read_data() {
        
        $permission = Input::get('permission');
        $text = Input::get('feedback');
        
        $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                         ->where('intName', '=', 'default')->first(Array('categoryId')); 
        $this->feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $this->contact_id
          , 'categoryId' => $category->categoryid
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => $text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => date('Y-m-d H:i:s')
        );
    }
}
