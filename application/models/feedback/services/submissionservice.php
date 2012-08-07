<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackDetails;
use Halcyonic\Services\HalcyonicService;
use DBDashboard;
use Helpers, Input, DB;

class SubmissionService {
   
    private $company_id;

    public function __construct(ContactDetails $contact, FeedbackDetails $feedback_details, DBDashboard $dbdashboard, HalcyonicService $halcyonic) {
        $this->company_id = Input::get('company_id');
        $this->contact_details = $contact;     
        $this->dbdashboard = $dbdashboard;
        $this->halcyonic = $halcyonic;
        $this->feedback_details = $feedback_details;
    }

    public function perform() {        
        $this->contact_details->read_data(); 

        $this->contact_details->write_new_contact();
     
        $this->feedback_details->set_contact_id($this->contact_details->get_contact_id());
        $this->feedback_details->set_company_id($this->company_id);
        $this->feedback_details->read_data();
        $this->feedback_details->write_new_feedback();
        $this->feedback_details->send_email_notification();

        $this->dbdashboard->company_id = $this->company_id;
        $this->dbdashboard->write_summary();

        //Upon new feedback always invalidate cache       
        $this->halcyonic->company_id = $this->company_id;
        $this->halcyonic->save_latest_feedid();
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
