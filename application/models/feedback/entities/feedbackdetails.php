<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use Underscore\Underscore;
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

        /*start autoposting*/
        $hosted = new \Widget\Repositories\DBHostedSettings;
        $hosted->set_hosted_settings(Array('companyId' => $this->post_data->get('company_id')));
        $hosted_settings = $hosted->hosted_settings();

        $isPublished = 0;
        if($hosted_settings->autopost_enable == 1) {
            $isPublished = ($this->post_data->get('rating') < $hosted_settings->autopost_rating) ? 0 : 1;
        }
        /*end autoposting*/

        /*metadata grouping*/
        $metadata = Null;
        if($this->post_data->get('metadata')) { 
            $_ = new Underscore; 
            $group = $_->groupBy($this->post_data->get('metadata'), 'type'); 
            $collection = Array();
            foreach($group as $key => $value) {
                $collection[$key] = $_->groupBy($value, 'name');
            }
            $metadata = json_encode($collection);
        }

        return Array(
            'siteId'        => $this->post_data->get('site_id')
          , 'companyId'     => $this->post_data->get('company_id')
          , 'contactId'     => Null
          , 'categoryId'    => $category->categoryid
          , 'companyId'     => $this->post_data->get('company_id')
          , 'formId'        => 1
          , 'status'        => 'new'
          , 'isRecommended' => $this->post_data->get('recommend')
          , 'isPublished'   => $isPublished
          , 'rating'        => $this->post_data->get('rating')
          , 'text'          => $feedback_text
          , 'permission'    => ($permission) ? $permission : 1
          , 'dtAdded'       => ($this->post_data->get('date_change')) ? date('Y-m-d H:i:s', strtotime($this->post_data->get('date_change'))) : date('Y-m-d H:i:s')
          , 'attachments'   => json_encode($this->post_data->get('attachments'))
          , 'metadata'      => $metadata
          , 'title'         => $this->post_data->get('title')
        );
    }
}
