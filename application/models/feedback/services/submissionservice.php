<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Contact\Repositories\DBContact;
use Feedback\Entities\ContactDetails;
use Halcyonic;
use DBUser, DBBadWords, DBMetric;
use Helpers, Input, S36Auth, DB;
use Underscore, redisent;

class SubmissionService {
   
    private $contact;

    public function __construct(ContactDetails $contact) {
        $this->contact = $contact;     
    }
}
