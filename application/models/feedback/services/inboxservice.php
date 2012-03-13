<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, ZebraPagination\ZebraPagination, S36Auth, Input, Exception;

class InboxService {

    private $limit = 10;
    private $filters = Array();

    public function __construct() {
        $this->dbfeedback = new DBFeedback;     
        $this->pagination = new ZebraPagination;
        $this->input = Input::get(); 
    }

    public function set_filters(Array $filters) {
        $this->filters = $this->_check_filters($filters);
    }

    public function present_feedback() {
        if ($this->filters) {
            //pass filters to dbfeedback     
            return $this->filters;
        }
    }

    public function _check_filters(Array $filters) {
        $filter_structure = Array(
            'all' => 'all'
          , 'published' => 'published'
          , 'featured'  => 'featured'
          , 'filed'   => 'filed'
          , 'deleted' => 'deleted'
        );

        $choice_structure = Array(
            'all' => 'all'
          , 'positive' => 'positive'
          , 'negative' => 'negative'
          , 'neutral'  => 'neutral'
          , 'profanity' => 'profanity'
          , 'flagged'   => 'flagged'
          , 'date_new' => 'date_new'
          , 'date_old' => 'date_old'
          , 'mostcontent' => 'mostcontent'
        );

        $filters['filed_statement'] = ($filters['filter'] == 'filed') ? 'AND Category.intName != "default"' : 'AND Category.intName = "default"';       

        if ($filters['filter'] and $filters['choice']) {
            //check against filter structure     
            if (!array_key_exists($filters['filter'], $filter_structure)) {
                throw new Exception("{$filters['filter']} not a valid filter structure data type.");
            } 
            
            if (!array_key_exists($filters['choice'], $choice_structure)) {
                throw new Exception("{$filters['choice']} not a valid choice structure data type.");
            } 

            if ($filters['filter'] == 'featured') {
                $filters['featured'] = 1;
            }

            if ($filters['filter'] == 'published') {
                $filters['published'] = 1;
            }

            if ($filters['filter'] == 'deleted') {
                $filters['deleted'] = 1;
            }

        }

        if ($filters['filter'] and $filters['choice'] == false) {
            //check against choice structure     
            if (!array_key_exists($filters['filter'], $choice_structure)) {
                throw new Exception("{$filters['filter']} not a valid choice structure data type.");
            } else {
                $filters['choice'] = $filters['filter'];
                unset($filters['filter']);
            } 
        }

        $sql_statement = Null;
        $rating_statement = Null;
        $default_date_statement = "Feedback.dtAdded DESC";;

        if($filters['rating'] and !in_array($filters['choice'], Array('positive', 'negative', 'neutral'))) { 
            $rating_statement = "AND Feedback.rating = {$filters['rating']}";
        }
        
        if($filters['choice'] == 'profanity') {
            $sql_statement = "AND Feedback.hasProfanity = 1";
        } 

        if($filters['choice'] == 'flagged') {
            $sql_statement = "AND Feedback.isFlagged = 1";
        }

        if ($filters['choice'] == 'positive')  {
            $sql_statement = "AND Feedback.rating IN (4,5)";
        }

        if ($filters['choice'] == 'negative') { 
            $sql_statement = "AND Feedback.rating IN (1,2)";
        }

        if ($filters['choice'] == 'neutral') { 
            $sql_statement = "AND Feedback.rating = 3";
        }

        if ($filters['choice'] == 'date_new') {
            $default_date_statement = null;
            $sql_statement = "Feedback.dtAdded DESC";
        }

        if ($filters['choice'] == 'date_old') {  
            $default_date_statement = null;
            $sql_statement = "Feedback.dtAdded ASC";
        }

        if ($filters['choice'] == 'mostcontent') {
            $default_date_statement = null;
            $sql_statement = "word_count DESC";
        }
        //$sql_statement = ($filters['choice'] == 'mostcontent') ? 'word_count DESC' : 'Feedback.dtAdded DESC'; 
        $filters['default_date_statement'] = $default_date_statement;
        $filters['rating_statement'] = $rating_statement;
        $filters['sql_statement'] = $sql_statement;

        return $filters;

    }
}
