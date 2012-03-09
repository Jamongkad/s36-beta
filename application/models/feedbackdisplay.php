<?php

class FeedbackDisplay { 
    private $grouped_dates, $feedback;
    public function __construct() {
        $this->dbfeedback = new DBFeedback;
    }

    public function display_feedback() {

        $limit   = 10;
        $offset  = 0;
        $filter = 'inbox';
        $choice = 'positive';
        $site_id = False;
        $rating  = False;
    
        if(Input::get('limit'))   $limit   = (int)Input::get('limit');
        if(Input::get('site_id')) $site_id = (int)Input::get('site_id');
        if(Input::get('rating'))  $rating  = (int)Input::get('rating');

        $this->grouped_dates = $this->dbfeedback->pull_feedback_grouped_by_date();
        $this->feedback = $this->dbfeedback->pull_feedback(array(
            'limit'=> $limit
          , 'offset'=> $offset
          , 'filter'=> $filter
          , 'choice'=> $choice
          , 'site_id'=> $site_id
          , 'rating'=> $rating
        ));

        $data = Array();
        foreach($this->grouped_dates as $dates) { 
            $data[$dates->date_format] = Array();
            //echo $dates->date_format."<br/>";
            foreach($this->feedback->result as $feed) { 
                $unix = strtotime($feed->date);
                $date = date("m.d.Y", $unix);
                //echo "----".$date."<br/>";

                if($date == $dates->date_format) {
                    $data[$dates->date_format][] = $feed;    
                }

                
            }
        }
        return $data;

        //return $this;
    }
}
