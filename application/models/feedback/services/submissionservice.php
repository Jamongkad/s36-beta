<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Contact\Repositories\DBContact;
use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackDetails;
use Halcyonic;
use DBUser, DBBadWords, DBMetric;
use Helpers, Input, S36Auth, DB;
use Underscore, redisent;

class SubmissionService {
   
    private $company_id;

    public function __construct(ContactDetails $contact, FeedbackDetails $feedback_details) {
        $this->company_id = Input::get('company_id');
        $this->contact_details = $contact;     
        $this->feedback_details = $feedback_details;

        $this->dbh = DB::connection('master')->pdo;
        $this->dbcontact = new DBContact; 
    }

    public function perform() {
        $this->dbh->beginTransaction();

        $this->contact_details->read_data();
        print_r($this->contact_details);
        //$contact_id = $this->dbcontact->insert_new_contact($contact_info);
        $contact_id = 313;
        $this->feedback_details->set_contact_id($contact_id);
        $this->feedback_details->set_company_id($this->company_id);
        print_r($this->feedback_details);

        $this->dbh->commit();
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
