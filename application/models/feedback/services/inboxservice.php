<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, ZebraPagination\ZebraPagination, S36Auth, Input, Exception, Helpers, DB;

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
            //return $this->dbfeedback->pull_feedback($this->filters);
        }
    }

    //I am sorry but filters are hard (-_-)
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
          , 'mostcontent' => 'mostcontent'
        );

        $date_structure = Array(
            'date_new' => 'date_new'
          , 'date_old' => 'date_old'
        );

        $sql_statement = Null;
        $rating_statement = Null;
        $date_statement = "Feedback.dtAdded DESC";;

        $filters['filed_statement'] = ($filters['filter'] == 'filed') ? 'AND Category.intName != "default"' : 'AND Category.intName = "default"';       
        $filters['featured'] = 0;
        $filters['published'] = 0;
        $filters['deleted'] = 0;

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

        if ($filters['date']) {
            if (!array_key_exists($filters['date'], $date_structure)) {
                throw new Exception("{$filters['date']} not a valid date structure data type.");
            } else {                
                if($filters['choice'] == 'mostcontent') {

                    if($filters['date'] == 'date_new' ) {
                        $date_statement = "Feedback.dtAdded DESC, word_count DESC";
                    }

                    if($filters['date'] == 'date_old' ) {
                        $date_statement = "Feedback.dtAdded ASC, word_count DESC";    
                    } 
                } else { 

                    if ($filters['date'] == 'date_new') {
                        $date_statement = "Feedback.dtAdded DESC";
                    }

                    if ($filters['date'] == 'date_old') {  
                        $date_statement = "Feedback.dtAdded ASC";
                    }
                }

            } 
        }


        if ($filters['choice'] == 'mostcontent' && !$filters['date']) {
            $date_statement = "word_count DESC";
        }

        //anchor statements 
        if($filters['choice'] == 'profanity') {
            $sql_statement = "AND Feedback.hasProfanity = 1";
        } 

        if($filters['choice'] == 'flagged') {
            $sql_statement = "AND Feedback.isFlagged = 1";
        }

        if ($filters['choice'] == 'positive' && !$filters['rating'])  {
            $sql_statement = "AND Feedback.rating IN (4,5)";
        }

        if ($filters['choice'] == 'negative' && !$filters['rating']) { 
            $sql_statement = "AND Feedback.rating IN (1,2)";
        }

        if ($filters['choice'] == 'neutral' && !$filters['rating']) { 
            $sql_statement = "AND Feedback.rating = 3";
        }

        //ephemeral statements
        $rating_statement = $this->_sql_statement_helper(function($rating) {  
            return "AND Feedback.rating = $rating";
        }, $filters['rating']);

         
        $priority_statement = $this->_sql_statement_helper(function($choice) {
            $choice = trim($choice, "'");

            if($choice === 'low') {
                return "AND (Feedback.priority >= 0 AND Feedback.priority <= 30)";     
            }

            if($choice == "medium") { 
                return "AND (Feedback.priority >= 30 AND Feedback.priority <= 60)";     
            }
            
            if($choice == "high") { 
                return "AND (Feedback.priority > 60 AND Feedback.priority <= 100)";     
            }

        }, $filters['priority']);


        $category_statement = $this->_sql_statement_helper(function($category) { 
            return "AND Category.intName = $category";      
        }, $filters['category']);

        $status_statement = $this->_sql_statement_helper(function($status) { 
            return "AND Feedback.status = $status";
        }, $filters['status']);

        $siteid_statement = $this->_sql_statement_helper(function($id) {
            return "AND Feedback.siteId = $id";  
        }, $filters['site_id']);

        $filters['status_statement']   = $status_statement;
        $filters['priority_statement'] = $priority_statement;
        $filters['date_statement']     = $date_statement;
        $filters['siteid_statement']   = $siteid_statement;
        $filters['rating_statement']   = $rating_statement;
        $filters['category_statement'] = $category_statement;
        $filters['sql_statement']      = $sql_statement;

        return $filters;
    }

    private function _sql_statement_helper($callback, $vector) { 
        if($vector = Helpers::sanitize($vector)) {
            $vector = $this->dbfeedback->quote($vector);
            if(is_callable($callback)) {
                return call_user_func($callback, $vector);     
            } 
        }  else {
            return null;     
        }
    }
}
