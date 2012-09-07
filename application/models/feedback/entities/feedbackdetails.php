<?php namespace Feedback\Entities;

use \Feedback\Entities\Types\FeedbackDataTypes;
use DBUser;
use Input, DB, Helpers, Package;
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
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => $this->post_data->get('rating')
          , 'text' => $feedback_text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => ($this->post_data->get('date_change')) ? date('Y-m-d H:i:s', strtotime($this->post_data->get('date_change'))) : date('Y-m-d H:i:s')
        );
    }
    /*
    public function write_new_feedback() {  
        $this->new_feedback_id = DB::table('Feedback')->insert_get_id($this->feedback_data);

        $post = (object) Array(
            'feedback_text' => $this->feedback_text
          , 'feed_id' => $this->new_feedback_id
        );

        $feedbackservice = new FeedbackService($this->dbfeedback, $this->dbbadwords);
        $feedbackservice->save_feedback($post);
    }

    public function send_email_notification() { 
        $submission_data = new NewFeedbackSubmissionData; 
        $feedback = $this->dbfeedback->pull_feedback_by_id($this->new_feedback_id);
        $account_users = $this->dbuser->pull_user_emails_by_company_id($this->company_id);

        $submission_data->set_feedback($feedback)
                        ->set_sendtoaddresses($account_users);

        $emailservice = new EmailService($submission_data);
        $emailservice->send_email();
    }
    */
}
