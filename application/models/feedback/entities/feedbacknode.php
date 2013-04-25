<?php namespace Feedback\Entities;

use StdClass;
use Helpers;
use \Feedback\Repositories\DBFeedbackReports;

class FeedbackNode {

    private $data;

    public function __construct($data) {
        $this->data = $data;     
        $this->reports = new FeedbackReports; 
    }

    public function generate() {
        
        $reports = $this->reports->get_reports_by_companyid(6);
        Helpers::dump($reports);

        $node = new StdClass; 
        foreach($this->data as $key => $value) {
            if($key) { 
                $node->$key = $value;
                if($key == 'metadata' || $key == 'attachments') {
                    $node->$key = json_decode($value);
                }
            } 
        }
        return $node;
    }    
}
