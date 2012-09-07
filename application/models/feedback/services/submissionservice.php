<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackDetails;
use Feedback\Entities\ContactDetailsData, Feedback\Entities\FeedbackDetailsData;
use Halcyonic\Services\HalcyonicService;
use DBDashboard;
use Helpers, Input, DB;

class SubmissionService {
   
    private $company_id;
    /*
    public function __construct(ContactDetails $contact, FeedbackDetails $feedbackdetails, DBDashboard $dbdashboard, HalcyonicService $halcyonic) {
        //TODO: This is bad. Remove this shit from the class.
        $this->company_id       = Input::get('company_id');
        $this->contact_details  = $contact;     
        $this->dbdashboard      = $dbdashboard;
        $this->halcyonic        = $halcyonic;
        $this->feedback_details = $feedbackdetails;
    }
    */
    public function __construct($post_input) {
        $this->dbdashboard      = new DBDashboard;
        $this->halcyonic        = new HalcyonicService; 
        $this->contact_details_data  = new ContactDetails($post_input);
        $this->feedback_details_data = new FeedbackDetails($post_input);
    }

    public function perform() {        
        /*
        $this->contact_details_data->generate_data();
        $this->feedback_details->generate_data();

        $this->contact_details  = new ContactDetails($contact_details_data);
        $new_contact = $this->contact_details->create_contact();

        $this->feedback_details = new FeedbackDetails($feedback_details_data); 
        $this->feedback_details->attach($new_contact);
        $this->feedback_details->create_feedback();
        $this->feedback_details->send_email_notification();

        $this->dbdashboard->company_id = $this->company_id;
        $this->dbdashboard->write_summary();

        //Upon new feedback always invalidate cache       
        $this->halcyonic->company_id = $this->company_id;
        $this->halcyonic->save_latest_feedid();
        */
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
