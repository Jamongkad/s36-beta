<?php namespace Feedback\Services;

use DB;

class FeedbackState {
    public function process_data($mode, $block_id, $company_id, $extra=False) {
        $category = DB::Table('Category')->where('companyId', '=', $company_id)
                                         ->where('intName', '=', 'default')->first(Array('categoryId'));

        $categoryId = $category->categoryid;

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
        
        $column = null;
        if(array_key_exists($mode, $lookup)) { $column = $lookup[$mode]; }

        $in_query = implode(',', array_fill(0, count($block_id), '?'));
         
        print_r($column);
    }
}
