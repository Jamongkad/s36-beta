<?php namespace Feedback\Entities;

use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use \Feedback\Entities\Types\FeedbackDataTypes;
use Feedback\Services\FeedbackService;
use Feedback\Repositories\DBFeedback;
use DBBadWords, DBUser;
use Input, DB;

class FeedbackDetails extends FeedbackDataTypes {

    private $feedback_id, $contact_id, $company_id, $feedback_data;

    public function __construct() {
        $this->dbfeedback = new DBFeedback;     
        $this->dbbadwords = new DBBadWords;
        $this->dbuser = new DBUser;
    }

    public function set_contact_id($contact_id) {
        $this->contact_id = $contact_id;    
    }

    public function set_company_id($company_id) {
        $this->company_id = $company_id; 
    }
    
    public function read_data() {
        
        $permission = Input::get('permission');
     
        $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                         ->where('intName', '=', 'default')->first(Array('categoryId')); 
        $this->feedback_data = Array(
            'siteId' => Input::get('site_id')
          , 'contactId' => $this->contact_id
          , 'categoryId' => $category->categoryid
          , 'formId' => 1
          , 'status' => 'new'
          , 'rating' => Input::get('rating')
          , 'text' => Input::get('feedback')
          , 'permission' => ($permission) ? $permission : 3
          , 'dtAdded' => date('Y-m-d H:i:s')
        );
    }

    public function write_new_feedback() {  
        $this->new_feedback_id = DB::table('Feedback')->insert_get_id($this->feedback_data);

        $post = (object) Array(
            'feedback_text' => Input::get('feedback')
          , 'feed_id' => $this->new_feedback_id
        );

        $feedbackservice = new FeedbackService($this->dbfeedback, $this->dbbadwords);
        $feedbackservice->save_feedback($post);
    }

    public function send_email_notification() { 
        $submission_data = new NewFeedbackSubmissionData;
        $submission_data->set_feedback($this->dbfeedback->pull_feedback_by_id($this->new_feedback_id))
                        ->set_sendtoaddresses($this->dbuser->pull_user_emails_by_company_id($this->company_id));

        $emailservice = new EmailService($submission_data);
        $emailservice->send_email();
    }
}
