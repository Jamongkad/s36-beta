<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Contact\Repositories\DBContact;
use Feedback\Entities\ContactDetails;
use Halcyonic;
use DBUser, DBBadWords, DBMetric;
use Helpers, Input, S36Auth, DB;
use Underscore, redisent;

class SubmissionService {
   
    private $company_id;

    public function __construct(ContactDetails $contact) {
        $this->company_id = Input::get('company_id');
        $this->dbh = DB::connection('master')->pdo;
        $this->contact = $contact;     
        $this->dbcontact = new DBContact; 
    }

    public function perform() {
        $this->dbh->beginTransaction();

        $contact_info = $this->contact->read_data();
        print_r($contact_info);
        $contact_id = $this->dbcontact->insert_new_contact($contact_info);
        print_r($contact_id);

        $this->dbh->commit();
    }

    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
