<?php namespace Feedback\Entities;

use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use \Feedback\Entities\Types\FeedbackDataTypes;
use Feedback\Services\FeedbackService;
use Feedback\Repositories\DBFeedback;
use DBBadWords, DBUser;
use Input, DB, Helpers, Package;
use SimpleArray;

Package::load('HTMLPurifier');

class FeedbackDetails extends FeedbackDataTypes {

    private $feedback_id, $contact_id, $company_id, $feedback_data, $feedback_text;

    public function __construct($post_data) {
        $this->post_data = new SimpleArray($post_data);
        $this->dbfeedback = new DBFeedback;     
        $this->dbbadwords = new DBBadWords;
        $this->dbuser = new DBUser; 
    }
    /*
    public function set_contact_id($contact_id) {
        $this->contact_id = $contact_id;    
    }

    public function set_company_id($company_id) {
        $this->company_id = $company_id; 
    }
    */ 
    public function generate_data() {

        $permission = $this->post_data->get('permission');
        $category = DB::Table('Category')->where('companyId', '=', $this->post_data->get('company_id'))
                                         ->where('intName', '=', 'default')->first(Array('categoryId')); 

        $this->feedback_text = Helpers::html_cleaner($this->post_data->get('feedback'));

        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        $this->feedback_text = $purifier->purify($this->feedback_text);
        
        return Array(
            'siteId' => $this->post_data->get('site_id')
          , 'contactId' => $this->contact_id
          , 'categoryId' => $category->categoryid
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => $this->post_data->get('rating')
          , 'text' => $this->feedback_text
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
