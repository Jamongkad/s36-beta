<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackDetails;
use Feedback\Services\FeedbackService;
use Halcyonic\Services\HalcyonicService; 
use Feedback\Repositories\DBFeedback;
use DBBadWords, DBDashboard, DBUser;
use Helpers, Input, DB;
use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use SimpleArray;

class SubmissionService {
   
    public function __construct($post_input) {
        $this->post_data        = new SimpleArray($post_input);
        $this->dbdashboard      = new DBDashboard;
        $this->halcyonic        = new HalcyonicService; 
        $this->contact_details  = new ContactDetails($this->post_data);
        $this->feedback_details = new FeedbackDetails($this->post_data);
        $this->dbfeedback       = new DBFeedback;
        $this->dbuser           = new DBUser; 
    }

    public function perform() {        

        $contact_data  = $this->contact_details->generate_data();
        $feedback_data = $this->feedback_details->generate_data();
        $feedback_data['contactId'] = $contact_data['contact_id'];

        $new_feedback_id = DB::table('Feedback')->insert_get_id($feedback_data);
        $post = (object) Array('feedback_text' => $feedback_data['text'], 'feed_id' => $new_feedback_id);

        $feedbackservice = new FeedbackService(new DBFeedback, new DBBadWords);
        $feedbackservice->save_feedback($post);

        $submission_data = new NewFeedbackSubmissionData; 

        $feedback = $this->dbfeedback->pull_feedback_by_id($new_feedback_id);
        $account_users = $this->dbuser->pull_user_emails_by_company_id($this->post_data->get('company_id'));

        $submission_data->set_feedback($feedback)
                        ->set_sendtoaddresses($account_users);

        $emailservice = new EmailService($submission_data);
        $emailservice->send_email();
  
        $this->dbdashboard->company_id = $this->post_data->get('company_id');
        $this->dbdashboard->write_summary();

        //Upon new feedback always invalidate cache       
        $this->halcyonic->company_id = $this->post_data->get('company_id');
        $this->halcyonic->save_latest_feedid(); 
        return ($feedbackservice) ? DB::table('Feedback')->where('feedbackId','=',$new_feedback_id)->first() : false;
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
