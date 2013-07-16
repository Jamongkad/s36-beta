<?php namespace Feedback\Services;

use DB, StdClass, Helpers;
use Feedback\Repositories\DBFeedback;
use DBDashboard;

class FeedbackState {

    private $lookup = Array(
        'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1, isNew = 0'
      , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1, isNew = 0'
      , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0, isArchived = 0, isNew = 0'
      , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1, isArchived = 0, isNew = 0'
      , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0, isFlagged = 0, isSticked = 0, isArchived = 0, indLock = 0, isNew = 0'
      , 'fileas'  => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isArchived = 1, isNew = 0'
      , 'flag'    => 'SET isFlagged = 1'
      , 'unflag'    => 'SET isFlagged = 0'
    );

    private $category_vars = Array('categoryId', 'intName', 'name');

    public function __construct($mode, $block_id, $company_id, $category_id=False, $isflagged=False) {
        $this->mode        = $mode;     
        $this->block_id    = $block_id;
        $this->company_id  = $company_id;
        $this->category_id = $category_id;
        $this->isflagged   = $isflagged;
        $this->feedback    = new DBFeedback;
        $this->dashboard   = new DBDashboard($company_id);
    } 

    public function change_state() {        
        if(is_array($this->category_id)) { 
            Helpers::dump($this->flag_statement());
            //this means we are undoing feedback and want to return their original filed status id. This is under the Filed folder only.
            /*
            $counter = 0;
            foreach($this->category_id as $catid) {
                if($this->mode != "fileas") { 
                    $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                                     ->where('intName', '=', 'default')->first($this->category_vars);
                } else { 
                    $category = DB::Table('Category')->where('categoryId', '=', $catid)
                                                     ->first($this->category_vars);
                }
                $rules = $this->state_change_rules();
                $column = $rules.$this->_sql_statement_attach($category->categoryid);
                $feedid = $this->block_id[$counter++];

             
                Helpers::dump($column);
                Helpers::dump($feedid);
            
                
                if($this->feedback->_toggle_single($column, $feedid)) {
                    echo json_encode(Array("feedback_status_change" => "success", "column" => $column, "feedid" => $feedid));
                } else { 
                    echo json_encode(Array("feedback_status_change" => "failed"));
                }
            }
            */
        } elseif(is_array($this->mode)) {
            Helpers::dump($this->flag_statement());
            //this means we are undoing feedback and want to return their original status. This is under the Published folder only.
            /*
            $counter = 0;
            foreach($this->mode as $state) {
                $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                                 ->where('intName', '=', 'default')->first($this->category_vars);
                $rules = $this->lookup[$state];
                $column = $rules.$this->_sql_statement_attach($category->categoryid);
                $feedid = $this->block_id[$counter++]; 

             
                Helpers::dump($column);
                Helpers::dump($feedid);
            
                if($this->feedback->_toggle_single($column, $feedid)) {
                    echo json_encode(Array("feedback_status_change" => "success", "column" => $column, "feedid" => $feedid));
                } else { 
                    echo json_encode(Array("feedback_status_change" => "failed"));
                }
            }
            */
        } else { 
            Helpers::dump($this->flag_statement());
            //Normal operations. Only being used in both Inbox and Deleted folders.
            /*
            if($this->mode != 'remove') { 
                $feed_obj = $this->feedback_state_obj();
            
                Helpers::dump($feed_obj);
                Helpers::dump($this->mode);
             
                if($this->feedback->_toggle_multiple($feed_obj)) {
                    echo json_encode(Array("feedback_status_change" => "success", "column" => $this->mode, "feedobj" => $feed_obj));
                } else { 
                    echo json_encode(Array("feedback_status_change" => "failed"));
                }
            } else { 
            //Normal operations will permanently delete feedback. Deleted folder only.
                foreach($this->block_id as $feed_id) {
                    //Helpers::dump($feed_id);
                    $this->feedback->permanently_remove_feedback($feed_id);    
                } 
                //Helpers::dump($this->mode);
            }
            */
        }
    }

    public function write_summary() {
        //write dashboard summary
        $this->dashboard->write_summary(); 
    }

    public function feedback_state_obj() {

        $rules = $this->state_change_rules();
        
        $result = new StdClass;

        if($this->mode == 'fileas') { 
            $selected_category = $this->selected_category();
            $result->column = $rules.$this->_sql_statement_attach($selected_category->categoryid);
        } else { 
            $default_category = $this->default_category();
            $result->column = $rules.$this->_sql_statement_attach($default_category->categoryid);
        }

        $result->block_id = $this->block_id;
        $result->query = $this->block_id_query();
        return $result;     
    }

    public function _sql_statement_attach($category_id) {
        return ", categoryId = ".$category_id;
    }

    public function default_category() { 
        $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                         ->where('intName', '=', 'default')->first($this->category_vars);
        return $category;
    }

    public function selected_category() { 
        $category = DB::Table('Category')->where('categoryId', '=', $this->category_id)
                                         ->first($this->category_vars);
        return $category;
    }

    public function flag_statement() {
        if(isset($this->isflagged)) {
            return ($this->isflagged == "flag") ? ", isFlagged = 1" : ", isFlagged = 0";     
        } 
    }

    public function state_change_rules() { 
        if(array_key_exists($this->mode, $this->lookup)) { 
            return $this->lookup[$this->mode]; 
        }
    }

    public function block_id_query() { 
        return implode(',', array_fill(0, count($this->block_id), '?'));
    }
}
