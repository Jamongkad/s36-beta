<?php namespace Feedback\Entities;

use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use \Feedback\Entities\Types\FeedbackDataTypes;
use Feedback\Services\FeedbackService;
use Feedback\Repositories\DBFeedback;
use DBBadWords, DBUser;
use Input, DB, Helpers, Package;

Package::load('HTMLPurifier');

class FeedbackDetails extends FeedbackDataTypes {

    private $feedback_id, $contact_id, $company_id, $feedback_data, $feedback_text;

    public function __construct($post_data) {
        $this->post_data = $post_data;
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
        
        $permission = Input::get('permission');     
        $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                         ->where('intName', '=', 'default')->first(Array('categoryId')); 

        $this->feedback_text = Helpers::html_cleaner(Input::get('feedback'));

        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        $this->feedback_text = $purifier->purify($this->feedback_text);
        
        $this->feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $this->contact_id
          , 'categoryId' => $category->categoryid
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => $this->feedback_text
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => date('Y-m-d H:i:s')
        );

        return $this->feedback_data;
    }

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
}
