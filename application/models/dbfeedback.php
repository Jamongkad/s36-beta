<?php
class DBFeedback extends S36DataObject {
 
    public function pull_feedback($opts) {
      
        $rating_statement    = Null;
        $profanity_statement = Null;
        $flagged_statement   = Null;
        $rating_choices      = Null;
        $siteid_statement    = Null;
        
        $filed_statement       = 'AND Category.intName = "default"';
        $mostcontent_statement = 'Feedback.dtAdded DESC';
        $is_deleted   = 0;
        $is_published = 0;
        $is_featured  = 0;

        if($opts['site_id'] != False) {
           $siteid_statement = "AND Feedback.siteId = {$opts['site_id']}";
        }

        if($opts['filter'] != False) {
   
            if( $opts['rating'] and in_array($opts['rating'], range(1, 5)) ) { 
                $rating_statement = "AND Feedback.rating IN ({$opts['rating']})";     
            }

            if(is_string($opts['filter'])) {
                if($opts['filter'] == 'profanity' || $opts['choice'] == 'profanity') {
                    $profanity_statement = "AND Feedback.hasProfanity = 1";
                }

                if($opts['filter'] == 'mostcontent' || $opts['choice'] == 'mostcontent') {
                    $mostcontent_statement = "LENGTH(textlength) DESC";
                }

                if($opts['filter'] == 'flagged' || $opts['choice'] == 'flagged') {
                    $flagged_statement = "AND Feedback.isFlagged = 1";
                }

                if($opts['filter'] == 'filed' || $opts['choice'] == 'filed') {
                    $filed_statement = 'AND Category.intName != "default"'; 
                }

                if($opts['filter'] == 'positive' || $opts['choice'] == 'positive') {
                    $rating_statement = "AND Feedback.rating IN (4,5)";     
                }

                if($opts['filter'] == 'negative' || $opts['choice'] == 'negative') {
                    $rating_statement = "AND Feedback.rating IN (1,2)";     
                }

                if($opts['filter'] == 'neutral' || $opts['choice'] == 'neutral') {
                    $rating_statement = "AND Feedback.rating IN (3)";     
                }

                if($opts['filter'] == 'deleted') {
                    $is_deleted = 1; 
                }

                if($opts['filter'] == 'published') {
                    $is_published = 1;     
                }

                if($opts['filter'] == 'featured') {
                    $is_featured = 1; 
                }
            }
           
        }
        $sql = '  
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Category.categoryId
                , Feedback.status AS status
                , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                  END AS priority
                , Feedback.text
                , Feedback.dtAdded AS date
                , CASE 
                    WHEN Feedback.permission = 1 THEN "FULL PERMISSION"
                    WHEN Feedback.permission = 2 THEN "LIMITED PERMISSION"
                    WHEN Feedback.permission = 3 THEN "PRIVATE"
                  END AS permission
                , CASE 
                    WHEN Feedback.rating = 1 THEN "POOR"
                    WHEN Feedback.rating = 2 THEN "POOR"
                    WHEN Feedback.rating = 3 THEN "AVERAGE"
                    WHEN Feedback.rating = 4 THEN "GOOD"
                    WHEN Feedback.rating = 5 THEN "EXCELLENT"
                  END AS rating
                , Feedback.isFeatured
                , Feedback.isFlagged
                , Feedback.isPublished
                , Feedback.isArchived
                , Feedback.isSticked
                , Feedback.isDeleted
                , Contact.contactId AS contactid
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.avatar AS avatar
                , Contact.loginType
                , Contact.profileLink
                , Country.name AS countryname
                , Country.code AS countrycode
                , Site.siteId AS siteid
                , LENGTH(text) AS textlength
            FROM 
                Feedback
                    INNER JOIN 
                        Site
                        ON Site.siteId = Feedback.siteId 
                    INNER JOIN
                        Category
                        ON Category.categoryId = Feedback.categoryId 
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    INNER JOIN 
                        Country
                        ON Country.countryId = Contact.countryId
                    INNER JOIN
                        Company
                        ON Company.companyId = Site.companyId
                    WHERE 1=1
                        '.$siteid_statement.'
                        AND Company.companyId = :company_id
                        AND Feedback.isDeleted = :is_deleted
                        AND Feedback.isPublished = :is_published
                        AND Feedback.isFeatured = :is_featured
                        '.$rating_statement.'
                        '.$profanity_statement.'
                        '.$flagged_statement.'
                        '.$filed_statement.'
                    ORDER BY
                        '.$mostcontent_statement.'
                    LIMIT :offset, :limit 
        ';
 
        $sth = $this->dbh->prepare($sql);      
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);       
        $sth->bindParam(':is_deleted', $is_deleted, PDO::PARAM_INT);
        $sth->bindParam(':is_published', $is_published, PDO::PARAM_INT);
        $sth->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $sth->bindParam(':limit', $opts['limit'], PDO::PARAM_INT);
        $sth->bindParam(':offset', $opts['offset'], PDO::PARAM_INT);
        $sth->execute();       

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $result = $sth->fetchAll(PDO::FETCH_CLASS);

        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->total_rows = $row_count->fetchColumn();

        /*
        print_r($rating_statement);
        print_r($profanity_statement);
        print_r($flagged_statement);
        print_r($mostcontent_statement);
        print_r($filed_statement);
        print_r("<br/>");
        print_r("rating_choices: ".$rating_choices."<br/>");
        print_r("is_deleted: ".$is_deleted."<br/>");
        print_r("is_published: ".$is_published."<br/>");
        print_r("is_featured: ".$is_featured."<br/>"); 
        */

        return $result_obj;
    }

    public function pull_feedback_by_company($opts) {

        $published_statement = Null;
        $featured_statement = Null;
        $combined_statement = Null;

        if($opts['is_published'] == 1 && $opts['is_featured'] == 0) {
           $published_statement = "AND Feedback.isPublished = 1";
        }

        if($opts['is_published'] == 0 && $opts['is_featured'] == 1) {
           $featured_statement = "AND Feedback.isFeatured = 1";
        }
 
        if($opts['is_published'] == 1 && $opts['is_featured'] == 1) {
           $combined_statement = "AND (Feedback.isPublished = 1 OR Feedback.isFeatured = 1)";
        }

        $sql = '
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Feedback.status AS status
                , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                  END AS priority
                , Feedback.text
                , Feedback.dtAdded AS date
                , Feedback.rating
                , Feedback.isFeatured
                , Feedback.isFlagged
                , Feedback.isPublished
                , Feedback.isArchived
                , Feedback.isSticked
                , Feedback.isDeleted
                , Feedback.displayName
                , Feedback.displayImg
                , Feedback.displayCompany
                , Feedback.displayPosition
                , Feedback.displayURL
                , Feedback.displayCountry
                , Feedback.displaySbmtDate
                , Feedback.indLock
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.email AS email
                , Contact.position AS position
                , Contact.website AS url
                , Contact.city AS city
                , Contact.companyName AS companyname
                , Contact.avatar AS avatar
                , Contact.loginType
                , Country.name AS countryname
                , Country.code AS countrycode
                , LENGTH(text) AS textlength
            FROM 
                Feedback
                    INNER JOIN 
                        Feedback
                        ON Feedback.siteId = Site.siteId
                    INNER JOIN
                        Category
                        ON Feedback.categoryId = Category.categoryId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    INNER JOIN 
                        Country
                        ON Country.countryId = Contact.countryId
                    INNER JOIN
                        Company
                        ON Company.companyId = Site.companyId
                    WHERE 1=1
                        AND Site.siteId = :site_id 
                        AND Company.companyId = :company_id
                        '.$published_statement.'
                        '.$featured_statement.'
                        '.$combined_statement.'
                    ORDER BY  
                        Feedback.dtAdded DESC
        ';

        $sth = $this->dbh->prepare($sql);
        
        $sth->bindParam(':site_id', $opts['site_id'], PDO::PARAM_INT);
        $sth->bindParam(':company_id', $opts['company_id'], PDO::PARAM_INT);       
        $sth->execute();       

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $feedback_block_display = DB::Table('FeedbackBlock', 'master')->where('siteid', '=', $opts['site_id'])->first();

        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->block_display = $feedback_block_display; 
        $result_obj->site_id = $opts['site_id'];
        $result_obj->company_id = $opts['company_id'];
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj;
    }

    public function pull_feedback_by_id($feedback_id) { 
        $sth = $this->dbh->prepare('
            SELECT 
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Category.categoryId
                , Feedback.status AS status
                , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                  END as priority
                , CASE 
                    WHEN Feedback.permission = 1 THEN "FULL PERMISSION"
                    WHEN Feedback.permission = 2 THEN "LIMITED PERMISSION"
                    WHEN Feedback.permission = 3 THEN "PRIVATE"
                  END AS permission
                , CASE 
                    WHEN Feedback.permission = 1 THEN "full-permission"
                    WHEN Feedback.permission = 2 THEN "limited-permission"
                    WHEN Feedback.permission = 3 THEN "private-permission"
                  END AS permission_css
                , CASE 
                    WHEN Feedback.rating = 1 THEN "POOR"
                    WHEN Feedback.rating = 2 THEN "POOR"
                    WHEN Feedback.rating = 3 THEN "AVERAGE"
                    WHEN Feedback.rating = 4 THEN "GOOD"
                    WHEN Feedback.rating = 5 THEN "EXCELLENT"
                  END AS str_rating
                , Contact.contactId
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.email AS email
                , Contact.position AS position
                , Contact.website AS url
                , Contact.city AS city
                , Contact.companyName AS companyname
                , Contact.avatar AS avatar
                , Contact.loginType
                , Contact.ipaddress
                , Contact.browser
                , Site.siteId
                , Feedback.text
                , Feedback.dtAdded AS date
                , Feedback.rating
                , Feedback.isFeatured
                , Feedback.isFlagged
                , Feedback.isPublished
                , Feedback.isArchived
                , Feedback.isSticked
                , Feedback.isDeleted
                , Feedback.displayName
                , Feedback.displayImg
                , Feedback.displayCompany
                , Feedback.displayPosition
                , Feedback.displayURL
                , Feedback.displayCountry
                , Feedback.displaySbmtDate
                , Country.code AS countrycode
                , Country.name AS countryname
                , Site.name AS sitename
                , Site.domain AS sitedomain
            FROM 
                Feedback
                    INNER JOIN
                        Site
                        ON Site.siteId = Feedback.siteId
                    INNER JOIN
                        Category
                        ON Feedback.categoryId = Category.categoryId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    INNER JOIN
                        Country
                        ON Country.countryId = Contact.countryId
                    WHERE 1=1
                        AND Feedback.feedbackId = :feedback_id
        ');

        $sth->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $sth->execute();       
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    //TODO: solidify this use USER_ID for company verification
    public function _change_feedback($column, $feedback_id, $state) {
        //release indLock for block display
        $this->_release_indlock($feedback_id);
        return $this->_toggle_state('Feedback', 'feedbackId', $feedback_id, $column, $state);
    }    

    private function _release_indlock($feedback_id) { 
        DB::table('Feedback', 'master')
                  ->where('feedbackId', '=', $feedback_id)
                  ->update(array('indLock' => 0));    
    }

    public function _toggle_feedbackblock($column, $block_id, $state) { 
        return $this->_toggle_state('FeedbackBlock', 'feedbackblockId', $block_id, $column, $state);
    }

    public function _toggle_multiple($mode, $block_id, $extra=False) { 

        //We need this to reset internal category id to default
        $category = DB::Table('Category')->where('companyId', '=', S36Auth::user()->companyid)
                                         ->where('intName', '=', 'default')->first(Array('categoryId'));

        $categoryId = $category->categoryid;
        //TODO consolidate inbox and restore nigguh
        $lookup = Array(
            'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 0, categoryId = '.$categoryId.''
          , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0, isFlagged = 0, isArchived = 0, indLock = 0, categoryId = '.$categoryId.''
          , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0, isArchived = 0, categoryId = '.$categoryId.''
          , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1, isArchived = 0, categoryId = '.$categoryId.''
          , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0, isFlagged = 0, isSticked = 0, isArchived = 0, indLock = 0, categoryId = '.$categoryId.''
          , 'fileas'  => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0'.$extra
          , 'flag'    => 'SET isFlagged = 1'
        );

        if(array_key_exists($mode, $lookup)) { $column = $lookup[$mode]; }

        $ids = array_map(function($obj) { return $obj['feedid']; }, $block_id);
        $block_ids = implode(',', $ids);

        $sql = "
            UPDATE Feedback
                INNER JOIN Site 
                    ON Site.siteId = Feedback.siteId
                INNER JOIN User
                    ON User.userId = :user_id
                    $column
                WHERE 1=1
                    AND User.companyId = Site.companyId
                    AND Feedback.feedbackId IN ($block_ids)
        ";

        //Helpers::show_data($sql);
        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->execute();       
    }

    //TODO: Add statement that will delete avatar photos as well.
    public function _permanent_delete($opts) { 
        $ids = array_map(function($obj) { return $obj['feedid']; }, $opts);
        $block_ids = implode(',', $ids);
        
        $avatar_sql = "
            SELECT 
                Feedback.feedbackId
              , Contact.contactId
              , Contact.avatar
            FROM 
                Feedback
            INNER JOIN
                Contact
                    ON Feedback.contactId = Contact.contactId
            WHERE 1=1
                AND Feedback.feedbackId IN ($block_ids)
        ";

        $sth = $this->dbh->prepare($avatar_sql);
        $sth->execute();
        $avatar_result = $sth->fetchAll(PDO::FETCH_CLASS);

        $contact_ids = array_map(function($obj) { return $obj->contactid; }, $avatar_result);
        $contact_ids = implode(',', $contact_ids);

        $avatar_names = array_map(function($obj) { return $obj->avatar; }, $avatar_result);
        
        $profile_img = new Widget\ProfileImage();
        foreach($avatar_names as $avatar_name) {
            $profile_img->remove_profile_photo($avatar_name);
        }
 
        $contact_sql = "
           DELETE FROM 
               Contact
           WHERE 1=1
               AND Contact.contactId IN ($contact_ids) 
        ";

        $sth = $this->dbh->prepare($contact_sql);
        $sth->execute();

        $delete_sql = "
            DELETE FROM 
                Feedback 
            WHERE 1=1
                AND Feedback.isDeleted = 1
                AND Feedback.feedbackId IN ($block_ids)
        ";

        $sth = $this->dbh->prepare($delete_sql);
        $sth->execute();

    }

    public function permanently_remove_feedback($id) { 
        $feedback = DB::table('Feedback', 'master')
                        ->join('Contact', 'Feedback.contactId', '=', 'Contact.contactId')
                        ->where('Feedback.feedbackId', '=', $id)
                        ->first();

        //delete profile photos...
        $profile_img = new Widget\ProfileImage();
        $profile_img->remove_profile_photo($feedback->avatar);

        DB::table('Contact')->where('Contact.contactId', '=', $feedback->contactid)
                            ->delete();

        DB::table('Feedback')->where('Feedback.feedbackId', '=', $id)
                             ->where('Feedback.isDeleted', '=', 1)
                             ->delete();
    }

    private function _toggle_state($table, $where_column, $id, $column, $state) {  
        DB::table($table, 'master')
                  ->where($where_column, '=', $id)
                  ->update(array($column => $state));    
    }

    public function fetch_deleted_feedback() {
        
        $sth = $this->dbh->prepare('
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  Feedback.feedbackId AS id
            FROM 
                User
                    INNER JOIN
                        Site
                        ON User.companyId = Site.companyId
                    INNER JOIN 
                        Feedback
                        ON Site.siteId = Feedback.siteId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    WHERE 1=1
                        AND User.userId = :user_id
                        AND Feedback.isDeleted = 1
                        AND Feedback.isPublished = 0 
                        AND Feedback.isFeatured = 0
                        AND Feedback.isFlagged = 0
                        AND Feedback.isSticked = 0
                        AND Feedback.isArchived = 0
                    ORDER BY
                        Feedback.dtAdded DESC
        ');
 
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->execute();       
 
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj;
    }
    
    public function undo_deleted_feedback() {
        $sth = $this->dbh->prepare('
            UPDATE Feedback
                INNER JOIN Site 
                    ON Site.siteId = Feedback.siteId
                INNER JOIN User
                    ON User.userId = :user_id
                    AND User.companyId = Site.companyId
                SET Feedback.isDeleted = 0
        ');

        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->execute();
    }
    
    //TODO: Think of an algorithm for this. Either set a timer for all feedback to be deleted. Or get total number of feedback. The higher the number
    //the lesser time it takes for the system to clean shit up. Maximum time cap at 1000 feedback. 
    public function remove_deleted_feedback() {}
    public function decay_deleted_feedback() {}

    public function tag_feedback_with_profanity($user_id) {
        $sth = $this->dbh->prepare("
            UPDATE 
            Feedback
                INNER JOIN Site 
                    ON Site.siteId = Feedback.siteId
                INNER JOIN User
                    ON User.userId = :user_id
                   AND User.companyId = Site.companyId
                INNER JOIN BadWords
                    ON Feedback.text LIKE CONCAT('%', BadWords.word, '%')
                SET Feedback.hasProfanity = 1
        ");

        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function display_embedded_feedback_options($site_id) {
        $sth = $this->dbh->prepare("
                    SELECT 
                          Site.siteId
                        , User.userId
                        , FeedbackBlock.feedbackblockId 
                        , FeedbackBlock.displayName
                        , FeedbackBlock.displayImg
                        , FeedbackBlock.displayCompany
                        , FeedbackBlock.displayPosition
                        , FeedbackBlock.displayURL
                        , FeedbackBlock.displayCountry
                        , FeedbackBlock.displaySbmtDate
                    FROM 
                        FeedbackBlock
                    INNER JOIN
                        Site
                            ON Site.siteId = FeedbackBlock.siteId
                    INNER JOIN
                        Company
                            ON Company.companyId = Site.companyId
                    INNER JOIN
                        User
                            ON User.companyId = Company.companyId
                    WHERE 1=1
                        AND Site.siteId = :site_id
                        AND User.userId = :user_id 
                ");
        $sth->bindParam(':site_id', $site_id, PDO::PARAM_INT);
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT); 
        $sth->execute();
        
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //This function will be called by JS to display feedback on user's site.
    public function show_embedded_feedback_block($company_id) {
            $sth = $this->dbh->prepare("
            SELECT 
                Feedback.feedbackId
                , Feedba3kBlock.displayName AS FeedbackBlockName
                , Feedback.displayName AS FeedbackName
                , FeedbackBlock.displayURL AS FeedbackBlockURL
                , Feedback.displayURL AS FeedbackURL
            FROM 
                 Feedback
            INNER JOIN 
                 Form
                 ON Form.formId = Feedback.formId
            INNER JOIN
                 Site
                 ON Site.siteId = Feedback.siteId
            INNER JOIN 
                 Theme
                 ON Theme.themeId = Form.themeId
            INNER JOIN
                 FeedbackBlock
                 ON FeedbackBlock.siteId = Site.siteId
                AND FeedbackBlock.themeId = Theme.themeId
                AND FeedbackBlock.formId = Form.formId
            INNER JOIN
                Company
                ON Company.companyId = Site.companyId
            WHERE 1=1
                AND Company.companyId = :company_id
                AND Feedback.isPublished = 1
                AND Feedback.isDeleted != 1
            ");
        
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }

    public function contact_detection($opts) {
        $ids = array_map(function($obj) { return $obj['feedid']; }, $opts);
        $block_ids = implode(',', $ids);
        $sql = "
            DELETE FROM 
                Feedback 
            WHERE 1=1
                AND Feedback.isDeleted = 1
                AND Feedback.feedbackId IN ($block_ids)
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->execute();
    }

    public function total_feedback_by_company($company_id) {
        $sql = "   
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  Feedback.feedbackId
            FROM 
                Feedback
                    INNER JOIN
                        Site
                        ON Site.siteId = Feedback.siteId 
                    INNER JOIN
                        Company
                        ON Company.companyId = Site.companyId
             WHERE 1=1
                 AND Company.companyId = :company_id            
        ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        return $row_count->fetchColumn();
    }
}
