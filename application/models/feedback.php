<?php
//Going old school PDO. No flappy gearbox ORM's hahaha
class Feedback {

    private $dbh;
    private $user_id;

    public function __construct() {
        $this->dbh = DB::connection('master');
        $this->user_id = S36Auth::user()->userid;
        
    }
    
    //TODO: Clean this shit up
    public function pull_feedback($limit=5, $offset=0, $filter=False, $choice=False) {
      
        $rating_statement = Null;
        $profanity_statement = Null;
        $flagged_statement = Null;
        $filed_statement = Null;
        $rating_choices = Null;
        
        $mostcontent_statement = 'Feedback.dtAdded DESC';
        $is_deleted = 0;
        $is_published = 0;
        $is_featured = 0;

        if($filter != False) {
   
            if(in_array($filter, range(1, 5)) or in_array($choice, range(1, 5))) {
                if($filter == 4 || $choice == 4) {
                    $rating_choices = '4,5';
                } 

                if($filter == 1 || $choice == 1) {
                    $rating_choices = '1,2';
                }

                if($filter == 3 || $choice == 3) {
                    $rating_choices = 3;
                }
               
                $rating_statement = "AND Feedback.rating IN ($rating_choices)";     
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
                        AND Contact.siteId = Site.siteId
                    INNER JOIN 
                        Country
                        ON Country.countryId = Contact.countryId
                    WHERE 1=1
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
                        AND Contact.siteId = Site.siteId
                    WHERE 1=1
                        AND Feedback.feedbackId = :id
        ');

        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();       
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    //TODO: solidify this use USER_ID for company verification
    public function _change_feedback($column, $feedback_id, $state) {
        DB::table('Feedback', 'master')
                  ->where('feedbackId', '=', $feedback_id)
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
    
    //TODO: Think of algorithm for this. Either set a timer for all feedback to be deleted. Or get total number of feedback. The higher the number
    //the lesser time it takes for the system to clean shit up. Maximum time cap at 1000 feedback. 
    public function remove_deleted_feedback() {}
    public function decay_deleted_feedabck() {}

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
}
