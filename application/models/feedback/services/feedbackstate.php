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
    );

    private $category_vars = Array('categoryId', 'intName', 'name');

    public function __construct($mode, $block_id, $company_id, $category_id=False) {
        $this->mode = $mode;     
        $this->block_id    = $block_id;
        $this->company_id  = $company_id;
        $this->category_id = $category_id;
        $this->feedback    = new DBFeedback;
        $this->dashboard   = new DBDashboard($company_id);
    } 

    public function change_state() {        
        if(is_array($this->category_id)) { 
            $counter = 0;
            Helpers::dump($this->mode);
            foreach($this->category_id as $catid) {
                $category = DB::Table('Category')->where('categoryId', '=', $catid)
                                                 ->first($this->category_vars);

                $rules = $this->state_change_rules();
                $column = $rules.$this->_sql_statement_attach($category->categoryid);
                $feedid = $this->block_id[$counter++];
                $this->feedback->_toggle_single($column, $feedid);
            }
        } else { 
            $feed_obj = $this->feedback_state_obj();
            Helpers::dump($feed_obj);
            //return $this->feedback->_toggle_multiple($feed_obj);
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

    public function state_change_rules() { 
        if(array_key_exists($this->mode, $this->lookup)) { 
            return $this->lookup[$this->mode]; 
        }
    }

    public function block_id_query() { 
        return implode(',', array_fill(0, count($this->block_id), '?'));
    }
}
