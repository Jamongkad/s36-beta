<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use DB, Helpers, Package;
use SimpleArray;

Package::load('HTMLPurifier');

class FeedbackDetails extends FeedbackDataTypes {

    private $feedback_id, $contact_id, $company_id, $feedback_data, $feedback_text;

    public function __construct(SimpleArray $post_data) {
        $this->post_data = $post_data;
    }

    public function generate_data() {

        $permission = $this->post_data->get('permission');
        $category = DB::Table('Category')->where('companyId', '=', $this->post_data->get('company_id'))
                                         ->where('intName', '=', 'default')->first(Array('categoryId')); 

        $feedback_text = Helpers::html_cleaner($this->post_data->get('feedback'));

        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        $feedback_text = $purifier->purify($feedback_text);
        
        return Array(
            'siteId' => $this->post_data->get('site_id')
          , 'contactId' => Null
          , 'categoryId' => $category->categoryid
          , 'companyId' => $this->post_data->get('company_id')
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => $this->post_data->get('rating')
          , 'text' => $feedback_text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => ($this->post_data->get('date_change')) ? date('Y-m-d H:i:s', strtotime($this->post_data->get('date_change'))) : date('Y-m-d H:i:s')
        );
    }
}
