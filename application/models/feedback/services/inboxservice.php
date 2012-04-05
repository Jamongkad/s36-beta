<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, ZebraPagination\ZebraPagination, S36Auth, Input, Exception, Helpers, DB, StdClass;

class InboxService {

    private $limit = 10;
    private $filters = Array();

    private $filter_structure = Array(
            'all' => 'all'
          , 'published' => 'published'
          , 'featured'  => 'featured'
          , 'filed'   => 'filed'
          , 'deleted' => 'deleted'
    );

    private $choice_structure = Array(
        'all' => 'all'
      , 'positive' => 'positive'
      , 'negative' => 'negative'
      , 'neutral'  => 'neutral'
      , 'profanity' => 'profanity'
      , 'flagged'   => 'flagged'
      , 'mostcontent' => 'mostcontent'
    );

    private $date_structure = Array(
        'date_new' => 'date_new'
      , 'date_old' => 'date_old'
    );

    public function __construct() {
        $this->dbfeedback = new DBFeedback;     
        $this->pagination = new ZebraPagination;
    }

    public function set_filters(Array $filters) {
        $this->filters = $this->_check_filters($filters);
    }

    public function present_feedback() {
        if ($this->filters) {
            //pass filters to dbfeedback     
            $this->pagination->selectable_pages(4);
            $offset = ($this->pagination->get_page() - 1) * $this->filters['limit'];

            $this->filters['offset'] = $offset;
            $date_result = $this->dbfeedback->pull_feedback_grouped_dates($this->filters);
            $feed_result = $this->dbfeedback->pull_feedback($this->filters);

            $this->pagination->records($feed_result->total_rows);
            $this->pagination->records_per_page($this->filters['limit']);
            
            $data = Array();
            foreach($date_result as $dates) { 
                $head = new StdClass;
                $head->head_date = $dates->date_format;
                $head->unix_timestamp = $dates->unix_timestamp;
                $head->daysago = $dates->daysago;
                $head->children = Array();

                foreach($feed_result->result as $feed) { 
                    $unix = strtotime($feed->date);
                    $date = date("m.d.Y", $unix);
                    if($date == $dates->date_format) {
                        $head->children[] = $feed;    
                    }                
                } 
           
                if($head->children) {
                    $data[] = $head;     
                }  
            }

            $data_obj = new StdClass;
            $data_obj->result = $data;
            $data_obj->num_rows = $feed_result->total_rows;
            $data_obj->pagination = $this->pagination->render();
            return $data_obj;
        }
    }

    //I am sorry but filters are hard (-_-) TODO GET BACK TO THIS!!
    public function _check_filters(Array $filters) {

        $date_statement = "Feedback.rating DESC";
        $grouped_date_statement = "Feedback.dtAdded DESC";

        $filters['filed_statement'] = ($filters['filter'] == 'filed') ? 'AND Category.intName != "default"' : 'AND Category.intName = "default"';       
        $filters['featured'] = 0;
        $filters['published'] = 0;
        $filters['deleted'] = 0;

        if ($filters['filter'] and $filters['choice']) {
            //check against filter structure     
            if (!array_key_exists($filters['filter'], $this->filter_structure)) {
                throw new Exception("{$filters['filter']} not a valid filter structure data type.");
            } 
            
            if (!array_key_exists($filters['choice'], $this->choice_structure)) {
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
            if (!array_key_exists($filters['filter'], $this->choice_structure)) {
                throw new Exception("{$filters['filter']} not a valid choice structure data type.");
            } else {
                $filters['choice'] = $filters['filter'];
                unset($filters['filter']);
            } 
        }

        if ($filters['date']) {
            if (!array_key_exists($filters['date'], $this->date_structure)) {
                throw new Exception("{$filters['date']} not a valid date structure data type.");
            } else {                
                if($filters['choice'] == 'mostcontent') {

                    if($filters['date'] == 'date_new' ) {
                        $date_statement = "Feedback.dtAdded DESC, word_count DESC";
                    }

                    if($filters['date'] == 'date_old' ) {
                        $date_statement = "Feedback.dtAdded ASC, word_count DESC";    
                        $grouped_date_statement = "Feedback.dtAdded ASC";
                    } 
                } else { 

                    if ($filters['date'] == 'date_new') {
                        $date_statement = "Feedback.dtAdded DESC";
                    }

                    if ($filters['date'] == 'date_old') {  
                        $date_statement = "Feedback.dtAdded ASC";
                        $grouped_date_statement = "Feedback.dtAdded ASC";
                    }
                }
            } 
        }

        if ($filters['choice'] == 'mostcontent' && !$filters['date']) {
            $date_statement = "word_count DESC";
            $grouped_date_statement = "Feedback.dtAdded DESC";
        }

        //anchor statements 
        $sql_statement = call_user_func(function($filters) { 
            if($filters['choice'] == 'profanity') {
                return "AND Feedback.hasProfanity = 1";
            } 

            if($filters['choice'] == 'flagged') {
                return "AND Feedback.isFlagged = 1";
            }

            if ($filters['choice'] == 'positive' && !$filters['rating'])  {
                return "AND Feedback.rating IN (4,5)";
            }

            if ($filters['choice'] == 'negative' && !$filters['rating']) { 
                return "AND Feedback.rating IN (1,2)";
            }

            if ($filters['choice'] == 'neutral' && !$filters['rating']) { 
                return "AND Feedback.rating = 3";
            }

            return null;
        }, $filters); 

        //ephemeral statements
        $numeric_check = function($id) {
            if( !is_numeric($id) ) {
                throw new \InvalidArgumentException("Site ID is integers only playah!");
            } 
        };

        $siteid_statement = $this->_sql_statement_decorator($filters['site_id'], function($id) {  
            return "AND Feedback.siteId = $id";  
        }, $numeric_check);

        $rating_statement = $this->_sql_statement_decorator($filters['rating'], function($rating) {  
            return "AND Feedback.rating = $rating";
        }, $numeric_check);

         
        $priority_statement = $this->_sql_statement_decorator($filters['priority'], function($choice) {
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

        });

        $category_statement = $this->_sql_statement_decorator($filters['category'], function($category) { 
            return "AND Category.intName = $category";      
        });

        $status_statement = $this->_sql_statement_decorator($filters['status'], function($status) { 
            return "AND Feedback.status = $status";
        });

        $filters['status_statement']   = $status_statement;
        $filters['priority_statement'] = $priority_statement;
        $filters['date_statement']     = $date_statement;
        $filters['grouped_date_statement'] = $grouped_date_statement; 
        $filters['siteid_statement']   = $siteid_statement;
        $filters['rating_statement']   = $rating_statement;
        $filters['category_statement'] = $category_statement;
        $filters['sql_statement']      = $sql_statement;

        return $filters;
    }

    private function _sql_statement_decorator($vector, $callback, $callback_filter=False) { 
        if($vector = Helpers::sanitize($vector)) {
            if($callback_filter and is_callable($callback_filter)) {
                call_user_func($callback_filter, $vector);      
            }

            if(is_callable($callback)) { 
                return call_user_func($callback, $this->dbfeedback->quote($vector));     
            } 

        }  else {
            return null;     
        }
    }
}
