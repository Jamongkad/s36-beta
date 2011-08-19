<?php
//Going old school PDO. No flappy gearbox ORM's hahaha
class Feedback {

    private $dbh;
    private $user_id;

    public function __construct() {
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }
    
    //TODO: CODE SMELL consider using an object holder instead
    public function pull_feedback($limit=5, $offset=0, $filter=False, $choice=False, $site_id=False, $rating=False) {
      
        $rating_statement    = Null;
        $profanity_statement = Null;
        $flagged_statement   = Null;
        $rating_choices      = Null;
        $siteid_statement    = Null;
        
        $filed_statement       = 'AND Feedback.categoryId = 1';
        $mostcontent_statement = 'Feedback.dtAdded DESC';
        $is_deleted   = 0;
        $is_published = 0;
        $is_featured  = 0;

        if($site_id != False) {
           $siteid_statement = "AND Feedback.siteId = $site_id";
        }

        if($filter != False) {
   
            if( $rating and in_array($rating, range(1, 5)) ) { 
                $rating_statement = "AND Feedback.rating IN ($rating)";     
            }

            if(is_string($filter)) {
                if($filter == 'profanity' || $choice == 'profanity') {
                    $profanity_statement = "AND Feedback.hasProfanity = 1";
                }

                if($filter == 'mostcontent' || $choice == 'mostcontent') {
                    $mostcontent_statement = "LENGTH(textlength) DESC";
                }

                if($filter == 'flagged' || $choice == 'flagged') {
                    $flagged_statement = "AND Feedback.isFlagged = 1";
                }

                if($filter == 'filed' || $choice == 'filed') {
                    $filed_statement = "AND Feedback.categoryId != 1";
                }

                if($filter == 'positive' || $choice == 'positive') {
                    $rating_statement = "AND Feedback.rating IN (4,5)";     
                }

                if($filter == 'negative' || $choice == 'negative') {
                    $rating_statement = "AND Feedback.rating IN (1,2)";     
                }

                if($filter == 'neutral' || $choice == 'neutral') {
                    $rating_statement = "AND Feedback.rating IN (3)";     
                }

                if($filter == 'deleted') {
                    $is_deleted = 1; 
                }

                if($filter == 'published') {
                    $is_published = 1;     
                }

                if($filter == 'featured') {
                    $is_featured = 1; 
                }
            }
           
        }

        $sth = $this->dbh->prepare('
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
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Country.name AS countryname
                , Country.code AS countrycode
                , LENGTH(text) AS textlength
            FROM 
                User
                    INNER JOIN
                        Site
                        ON User.companyId = Site.companyId
                    INNER JOIN 
                        Feedback
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
                        '.$siteid_statement.'
                        AND User.userId = :user_id
                        AND Feedback.isDeleted = :is_deleted
                        AND Feedback.isPublished = :is_published
                        AND Feedback.isFeatured = :is_featured
                        '.$rating_statement.'
                        '.$profanity_statement.'
                        '.$flagged_statement.'
                        '.$filed_statement.'
                    GROUP BY
                        1
                    ORDER BY
                        '.$mostcontent_statement.'
                    LIMIT :offset, :limit 
        ');
      
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);       
        $sth->bindParam(':is_deleted', $is_deleted, PDO::PARAM_INT);
        $sth->bindParam(':is_published', $is_published, PDO::PARAM_INT);
        $sth->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();       

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $result = $sth->fetchAll(PDO::FETCH_CLASS);

        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj;

        /* DEBUG 
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
           $combined_statement = "AND Feedback.isPublished = 1 OR Feedback.isFeatured = 1";
        }

        $sth = $this->dbh->prepare('
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
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.email AS email
                , Contact.position AS position
                , Contact.website AS url
                , Contact.city AS city
                , Contact.companyName AS companyname
                , Country.name AS countryname
                , Country.code AS countrycode
                , LENGTH(text) AS textlength
            FROM 
                User
                    INNER JOIN
                        Site
                        ON User.companyId = Site.companyId
                    INNER JOIN 
                        Feedback
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
                        AND Site.siteId = :site_id 
                        AND User.companyId = :company_id
                        '.$published_statement.'
                        '.$featured_statement.'
                        '.$combined_statement.'
                    GROUP BY
                        1
                    ORDER BY  
                        Feedback.dtAdded 
                    LIMIT :offset, :limit 
        ');
        
        $sth->bindParam(':site_id', $opts['site_id'], PDO::PARAM_INT);
        $sth->bindParam(':company_id', $opts['company_id'], PDO::PARAM_INT);       
        //$sth->bindParam(':is_published', $opts['is_published'], PDO::PARAM_INT);
        //$sth->bindParam(':is_featured', $opts['is_featured'], PDO::PARAM_INT);
        $sth->bindParam(':limit', $opts['limit'], PDO::PARAM_INT);
        $sth->bindParam(':offset', $opts['offset'], PDO::PARAM_INT);
        $sth->execute();       

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $result = $sth->fetchAll(PDO::FETCH_CLASS);

        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->site_id = $opts['site_id'];
        $result_obj->company_id = $opts['company_id'];
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj;
    }

    public function pull_feedback_by_id($id) { 
        $sth = $this->dbh->prepare('
            SELECT 
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Feedback.status AS status
                , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                  END as priority
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.email AS email
                , Contact.position AS position
                , Contact.website AS url
                , Contact.city AS city
                , Contact.companyName AS companyname
                , Contact.avatar AS img
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
            FROM 
                User
                    INNER JOIN
                        Site
                        ON User.companyId = Site.companyId
                    INNER JOIN 
                        Feedback
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
                        AND Contact.siteId = Site.siteId
                        AND Feedback.feedbackId = :id
        ');

        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();       
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    //TODO: solidify this use USER_ID for company verification
    public function _change_feedback($column, $feedback_id, $state) {
        return $this->_toggle_state('Feedback', 'feedbackId', $feedback_id, $column, $state);
    }    

    public function _toggle_feedbackblock($column, $block_id, $state) { 
        return $this->_toggle_state('FeedbackBlock', 'feedbackblockId', $block_id, $column, $state);
    }

    public function _toggle_multiple($mode, $block_id) { 

        $lookup = Array(
            'inbox'   => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0'
          , 'publish' => 'SET isDeleted = 0, isPublished = 1, isFeatured = 0'
          , 'feature' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 1'
          , 'delete'  => 'SET isDeleted = 1, isPublished = 0, isFeatured = 0' 
          , 'restore' => 'SET isDeleted = 0, isPublished = 0, isFeatured = 0'
        );

        if(array_key_exists($mode, $lookup)) { $column = $lookup[$mode]; }
        $block_ids = implode(',', $block_id);
        
        $sql = "
            UPDATE Feedback
                INNER JOIN Site 
                    ON Site.siteId = Feedback.siteId
                INNER JOIN User
                    ON User.userId = :user_id
                    $column, categoryId = 1 
                WHERE 1=1
                    AND User.companyId = Site.companyId
                    AND Feedback.feedbackId IN ($block_ids)
        ";

        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->execute();       
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
                    WHERE 1=1
                        AND User.userId = :user_id
                        AND Feedback.isDeleted = 1
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
    
    //QUERY IS CORRECT!!
    public function undo_deleted_feedback() {
        $sth = $this->dbh->prepare('
            UPDATE 
            Feedback
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

    public function display_embedded_feedback_options() {
        $sth = $this->dbh->prepare("
                    SELECT 
                          FeedbackBlock.feedbackblockId 
                        , FeedbackBlock.displayName
                        , FeedbackBlock.displayImg
                        , FeedbackBlock.displayCompany
                        , FeedbackBlock.displayPosition
                        , FeedbackBlock.displayURL
                        , FeedbackBlock.displayCountry
                        , FeedbackBlock.displaySbmtDate
                    FROM 
                        User
                    INNER JOIN
                        Site
                        ON Site.companyId = User.companyId
                    INNER JOIN
                        Form
                        ON Form.formId = Site.defaultFormId
                    INNER JOIN
                        Theme
                        ON Theme.themeId = Form.themeId
                    INNER JOIN
                        FeedbackBlock
                        ON FeedbackBlock.siteId = Site.siteId
                            AND FeedbackBlock.themeId = Theme.themeId
                            AND FeedbackBlock.formId = Form.formId
                    WHERE 1=1
                        AND User.userId = :user_id
                ");
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
                , FeedbackBlock.displayName AS FeedbackBlockName
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
}
