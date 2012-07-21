<?php namespace Feedback\Services;

use DB, StdClass, Helpers;
use Feedback\Repositories\DBFeedback;

class FeedbackState {

    private $lookup = Array(
        'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1'
      , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1'
      , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0, isArchived = 0'
      , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1, isArchived = 0'
      , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0, isFlagged = 0, isSticked = 0, isArchived = 0, indLock = 0'
      , 'fileas'  => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isArchived = 1'
      , 'flag'    => 'SET isFlagged = 1'
    );

    private $category_vars = Array('categoryId', 'intName', 'name');

    public function __construct($mode, $block_id, $company_id, $category_id) {
        $this->mode = $mode;     
        $this->block_id = $block_id;
        $this->company_id = $company_id;
        $this->category_id = $category_id;
        $this->feedback = new DBFeedback;
    } 

    public function change_state() {        
        $feed_obj = $this->feedback_state_obj();
        return $this->feedback->_toggle_multiple($feed_obj);
    }

    public function feedback_state_obj() {
        $rules = $this->state_change_rules();
        
        $result = new StdClass;
        if($this->mode == 'fileas') { 
            //echo "Archived Category";
            $selected_category = $this->selected_category();
            $result->column = $rules.$this->_sql_statement_attach($selected_category->categoryid);
        } else { 
            //echo "Default Category";
            $default_category = $this->default_category();
            $result->column = $rules.$this->_sql_statement_attach($default_category->categoryid);
        }
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
