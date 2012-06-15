<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackDetails;
use Halcyonic\Services\HalcyonicService;
use DBDashboard;
use Helpers, Input, DB;

class SubmissionService {
   
    private $company_id;

    public function __construct(ContactDetails $contact, FeedbackDetails $feedback_details) {
        $this->company_id = Input::get('company_id');
        $this->contact_details = $contact;     
        $this->feedback_details = $feedback_details;

        $this->dbh = DB::connection('master')->pdo;
    }

    public function perform() {
        $this->dbh->beginTransaction();
        
        $this->contact_details->read_data(); 
        $this->contact_details->write_new_contact();
        $this->feedback_details->set_contact_id($this->contact_details->get_contact_id());
        $this->feedback_details->set_company_id($this->company_id);
        $this->feedback_details->read_data();
        $this->feedback_details->write_new_feedback();
        $this->feedback_details->send_email_notification();

        $dash = new DBDashboard; 
        $dash->company_id = $this->company_id;
        $dash->write_summary();

        //Upon new feedback always invalidate cache       
        $halcyon = new HalcyonicService($this->company_id);
        $halcyon->save_latest_feedid();

        $this->dbh->commit();
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
