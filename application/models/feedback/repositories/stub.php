<?php namespace Feedback\Repositories;

use \Feedback\Entities\FeedbackNode;
use DateTime;
use Package, Helpers, Config, Pimple;

class Stub {
    public function pull_stubs() {

        $stub_dates = Array(
            "2012-10-24 11:36:38"
          , "2012-10-23 10:20:58"
          , "2012-10-02 11:20:58"
        );
        
        $stubs = Array();
        $i = 0;
        foreach($stub_dates as $dates) {

            $d = new DateTime($dates);
            $node = new FeedbackNode;
            $node->id             = $i++;
            $node->firstname      = "Irene Paredes";
            $node->text           = "oh hey!";
            $node->twit_date      = $dates;
            $node->daysago        = Helpers::relative_time($d->getTimestamp());
            $node->date           = $d->format("Y-m-d H:i:s");
            $node->head_date      = $d->format("d.m.Y");
            $node->unix_timestamp = $d->getTimestamp();
            $node->datetimeobj    = $d; 
            $stubs[] = $node;
        }

        return $stubs; 
    }
}
