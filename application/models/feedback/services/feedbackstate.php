<?php namespace Feedback\Services;

use DB;

class FeedbackState {

    private $lookup = Array(
        'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1'
      , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1'
      , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0, isArchived = 0'
      , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1, isArchived = 0'
      , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0, isFlagged = 0, isSticked = 0, isArchived = 0, indLock = 0'
      , 'fileas'  => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0'
      , 'flag'    => 'SET isFlagged = 1'
    );

    public function __construct($mode, $block_id, $company_id) {
        $this->mode = $mode;     
        $this->block_id = $block_id;
        $this->company_id = $company_id;
    } 

    public function set_data() {

        $category_id = $this->expose_default_category_id();
        
        /*
        $lookup = Array(
            'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1, categoryId = '.$categoryId.''
          , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 1, categoryId = '.$categoryId.''
          , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0, isArchived = 0, categoryId = '.$categoryId.''
          , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1, isArchived = 0, categoryId = '.$categoryId.''
          , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0, isFlagged = 0
                                           , isSticked = 0, isArchived = 0, indLock = 0, categoryId = '.$categoryId.''
          , 'fileas'  => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0'.$extra
          , 'flag'    => 'SET isFlagged = 1'
        );
        */
    }

    public function expose_default_category_id() { 
        $category = DB::Table('Category')->where('companyId', '=', $this->company_id)
                                         ->where('intName', '=', 'default')->first(Array('categoryId'));
        return $category->categoryid;
    }

    public function state_change_rules() { 
        if(array_key_exists($this->mode, $this->lookup)) { 
            return $this->lookup[$this->mode]; 
        }
    }

    public function process_data() {
  
        $column = null;
        if(array_key_exists($mode, $lookup)) { $column = $lookup[$mode]; }

        $in_query = implode(',', array_fill(0, count($block_id), '?'));
         
        print_r($column);
    }
}
