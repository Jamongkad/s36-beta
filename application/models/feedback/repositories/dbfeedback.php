<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth, Widget;
use \Feedback\Entities\FeedbackNode;
use \Profile\Services\ProfileImage;
use Underscore\Underscore;
use Exception;

class DBFeedback extends S36DataObject {

    private $select_vars = '
                  SQL_CALC_FOUND_ROWS
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Category.categoryId
                , CASE 
                    WHEN Feedback.status = "new" THEN "New"
                    WHEN Feedback.status = "inprogress" THEN "In Progress"
                    WHEN Feedback.status = "closed" THEN "Closed"
                  END AS status
                , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                  END AS priority
                , TRIM(REPLACE(REPLACE(Feedback.text, "\n", " "), "\r", " ")) AS text
                , Feedback.dtAdded AS date
                , DATE_FORMAT(Feedback.dtAdded, GET_FORMAT(DATE, "EUR")) AS head_date_format 
                , CASE
                      WHEN dtAdded between date_sub(now(), INTERVAL 60 minute) and now() 
                          THEN concat(minute(TIMEDIFF(now(), dtAdded)), " minutes ago")
                       WHEN datediff(now(), dtAdded) = 1 
                          THEN "Yesterday"
                       WHEN dtAdded between date_sub(now(), INTERVAL 24 hour) and now() 
                          THEN concat(hour(TIMEDIFF(NOW(), dtAdded)), " hours ago")
                       WHEN dtAdded between date_sub(now(), INTERVAL 1 MONTH) and now()
                          THEN concat(datediff(now(), dtAdded)," days ago")
                       WHEN dtAdded between date_sub(now(), INTERVAL 1 YEAR) and now()
                          THEN concat(period_diff(date_format(now(), "%Y%m"), date_format(dtAdded, "%Y%m")), " months ago") 
                       WHEN dtAdded >= CURDATE()
                          THEN "future event" 
                       ELSE    
                          "about a year ago"
                  END as daysAgo
                , UNIX_TIMESTAMP(dtAdded) AS unix_timestamp
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
                , CASE 
                    WHEN Feedback.permission = 1 THEN "full-permission"
                    WHEN Feedback.permission = 2 THEN "limited-permission"
                    WHEN Feedback.permission = 3 THEN "private-permission"
                  END AS permission_css
                , Feedback.permission AS perm_val
                , Feedback.isFeatured
                , Feedback.isFlagged
                , Feedback.isPublished
                , Feedback.isRecommended
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
                , Feedback.attachments
                , Feedback.metadata
                , FeedbackAdminReply.adminReply
                , Contact.contactId AS contactid
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Contact.email AS email
                , Contact.profileLink
                , Contact.position AS position
                , Contact.website AS url
                , Contact.city AS city
                , Contact.companyName AS companyname
                , Contact.avatar AS avatar
                , Contact.loginType
                , Contact.ipaddress
                , Contact.browser
                , Country.name AS countryname
                , Country.code AS countrycode
                , Contact.ipaddress
                , Contact.browser
                , Contact.avatar AS avatar
                , Site.siteId AS siteid
                , Site.name AS sitename
                , Site.domain AS sitedomain
                , FeedbackContactOrigin.origin AS origin
                , FeedbackContactOrigin.socialId AS socialid
                , LENGTH(TRIM(REPLACE(REPLACE(Feedback.text, "\n", " "), "\r", " "))) - LENGTH(REPLACE(TRIM(REPLACE(REPLACE(Feedback.text, "\n", " "), "\r", " ")) , " ", "")) + 1 AS word_count
                ';
    
    //DB Reads
    public function pull_feedback_grouped_dates($opts) {
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 
         
        $is_published_filter = false;
        if(array_key_exists('filter', $opts)) {
            if($opts['filter'] == 'published') { 
                $is_published_filter = true;
            }  
        } 

        if($is_published_filter) {
            $inbox_statements = "AND (Feedback.isPublished = 1 OR Feedback.isFeatured = 1) 
                                 AND Feedback.isDeleted = 0";
        } else { 
            $inbox_statements = '
                    AND Feedback.isDeleted = :is_deleted
                    AND Feedback.isPublished = :is_published
                    AND Feedback.isFeatured = :is_featured
                ';
        }
    
        $date_sql = '
            SELECT   
                SQL_CALC_FOUND_ROWS
                DATE_FORMAT(dtAdded, GET_FORMAT(DATE, "EUR")) AS date_format 
              , GROUP_CONCAT(DISTINCT Feedback.feedbackId ORDER BY Feedback.rating DESC SEPARATOR "|") AS feedbackIds
              , dtAdded
              , CASE
                    WHEN dtAdded between date_sub(now(), INTERVAL 60 minute) and now() 
                        THEN concat(minute(TIMEDIFF(now(), dtAdded)), " minutes ago")
                    WHEN datediff(now(), dtAdded) = 1 
                        THEN "Yesterday"
                    WHEN dtAdded between date_sub(now(), INTERVAL 24 hour) and now() 
                        THEN concat(hour(TIMEDIFF(NOW(), dtAdded)), " hours ago")
                    WHEN dtAdded between date_sub(now(), INTERVAL 1 MONTH) and now()
                        THEN concat(datediff(now(), dtAdded)," days ago")
                    WHEN dtAdded between date_sub(now(), INTERVAL 1 YEAR) and now()
                        THEN concat(period_diff(date_format(now(), "%Y%m"), date_format(dtAdded, "%Y%m")), " months ago") 
                    WHEN dtAdded > CURDATE()
                        THEN "future event"
                    ELSE    
                        "about a year ago"
                END as daysAgo
              , UNIX_TIMESTAMP(dtAdded) AS unix_timestamp
            FROM 
                Feedback
            INNER JOIN
                Site
                    ON Site.siteId = Feedback.siteId
            INNER JOIN 
                Company
                    ON Company.companyId = Site.companyId
            INNER JOIN
                Category
                   ON Category.categoryId = Feedback.categoryId
            INNER JOIN
                Contact
                   ON Contact.contactId = Feedback.contactId 
            INNER JOIN
                FeedbackContactOrigin
                   ON Feedback.contactid  = FeedbackContactOrigin.contactid
                   AND Feedback.feedbackId = FeedbackContactOrigin.feedbackId
            INNER JOIN 
                Country
                   ON Country.countryId = Contact.countryId
            WHERE 1=1
                AND Company.companyId = :company_id
                '.$opts['siteid_statement'].'
                '.$inbox_statements.'
                '.$opts['rating_statement'].'
                '.$opts['filed_statement'].'
                '.$opts['category_statement'].'
                '.$opts['status_statement'].'
                '.$opts['priority_statement'].'
                '.$opts['sql_statement'].'
            GROUP BY 
                date_format 
            ORDER BY 
                '.$opts['date_statement'].' 
            LIMIT :offset, :limit
        ';

        $company_id = $this->company_id;

        if (!$this->company_id) {
            $company_id = $opts['company_id'];
        }

        $sth = $this->dbh->prepare($date_sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);       
         
        if (!$is_published_filter) { 
            $sth->bindParam(':is_deleted', $opts['deleted'], PDO::PARAM_INT);
            $sth->bindParam(':is_published', $opts['published'], PDO::PARAM_INT);
            $sth->bindParam(':is_featured', $opts['featured'], PDO::PARAM_INT);
        }

        $sth->bindparam(':limit', $opts['limit'], PDO::PARAM_INT);
        $sth->bindparam(':offset', $opts['offset'], PDO::PARAM_INT);
        $sth->execute();

        $date_result = $sth->fetchAll(PDO::FETCH_CLASS); 
        $row_count   = $this->dbh->query("SELECT FOUND_ROWS()");
        $result_obj  = new StdClass;
        $result_obj->result = $date_result;
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj; 
    }

    //TODO: Caching Candidate -> Priority Number One
    public function pull_feedback_by_company(array $opts=null) {
        $published_statement =   Null;
        $featured_statement  =   Null;
        $combined_statement  =   Null;
        $siteid_statement    =   Null;
 
        if($opts['is_published'] == 1 && $opts['is_featured'] == 0) {
           $published_statement = "AND Feedback.isPublished = 1";
        }

        if($opts['is_published'] == 0 && $opts['is_featured'] == 1) {
           $featured_statement = "AND Feedback.isFeatured = 1";
        }
 
        if($opts['is_published'] == 1 && $opts['is_featured'] == 1) {
           $combined_statement = "AND (Feedback.isPublished = 1 OR Feedback.isFeatured = 1)";
        }
        
        $inbox_statements = null;
        if($opts['is_published'] == 0 && $opts['is_featured'] == 0) { 
            $inbox_statements = '
                AND Feedback.isDeleted = :is_deleted
                AND Feedback.isPublished = :is_published
                AND Feedback.isFeatured = :is_featured
            ';
        }

        $sql = '
            SELECT 
                '.$this->select_vars.'
            FROM 
                Feedback
                    LEFT JOIN
                        FeedbackAdminReply
                        ON FeedbackAdminReply.feedbackId = Feedback.feedbackId
                    INNER JOIN 
                        Site
                        ON Feedback.siteId = Site.siteId
                    INNER JOIN
                        Category
                        ON Feedback.categoryId = Category.categoryId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    INNER JOIN
                        FeedbackContactOrigin
                        ON Feedback.contactid  = FeedbackContactOrigin.contactid
                       AND Feedback.feedbackId = FeedbackContactOrigin.feedbackId
                    INNER JOIN 
                        Country
                        ON Country.countryId = Contact.countryId
                    INNER JOIN
                        Company
                        ON Company.companyId = Site.companyId
                    WHERE 1=1
                        AND Company.companyId = :company_id
                        '.$inbox_statements.'
                        '.$siteid_statement.'
                        '.$published_statement.'
                        '.$featured_statement.'
                        '.$combined_statement.'
                    ORDER BY  
                        Feedback.dtAdded DESC
        '; 
        $sth = $this->dbh->prepare($sql);

        $company_id = $this->company_id;

        if (!$this->company_id) {
            $company_id = $opts['company_id'];
        }

        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);

        if ($opts['is_published'] == 0 && $opts['is_featured'] == 0) { 
            $zero = 0;
            $sth->bindParam(':is_deleted', $zero, PDO::PARAM_INT);
            $sth->bindParam(':is_published', $zero, PDO::PARAM_INT);
            $sth->bindParam(':is_featured', $zero, PDO::PARAM_INT);
        }

        $sth->execute();       
        
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $results = $sth->fetchAll(PDO::FETCH_CLASS);
         
        $result_obj = new StdClass;
        $result_obj->company_id = $opts['company_id'];
        $result_obj->total_rows = $row_count->fetchColumn();
        $result_obj->result = $this->_return_feedback_nodes($results);
        return $result_obj;       
    }
    
    public function pull_feedback_group($feedbackids) {

        $ids      = explode("|", $feedbackids);
        $in_query = implode(',', array_fill(0, count($ids), '?'));

        $sth = $this->dbh->prepare('
            SELECT
                '.$this->select_vars.'
            FROM
                Feedback
                    LEFT JOIN
                        FeedbackAdminReply
                        ON FeedbackAdminReply.feedbackId = Feedback.feedbackId
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
                        FeedbackContactOrigin
                        ON Feedback.contactid  = FeedbackContactOrigin.contactid
                       AND Feedback.feedbackId = FeedbackContactOrigin.feedbackId
                    INNER JOIN
                        Country
                        ON Country.countryId = Contact.countryId
                    WHERE 1=1
                        AND Feedback.feedbackId IN ('.$in_query.')
                    ORDER BY
                        Feedback.dtAdded DESC
        ');

        foreach($ids as $k => $id) {
            $sth->bindValue(($k+1), $id);
        }

        $sth->execute();
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $results = $sth->fetchAll(PDO::FETCH_CLASS);
        
        return $this->_return_feedback_nodes($results);
    }

    public function pull_feedback_by_id($feedback_id) { 
        $sth = $this->dbh->prepare('
            SELECT 
                '.$this->select_vars.'
                , Company.companyId
                , Company.name AS company_name
                , Company.billTo AS company_billto
                , Company.description AS company_description
                , Company.logo AS company_logo 
            FROM 
                Feedback
                    LEFT JOIN
                        FeedbackAdminReply
                        ON FeedbackAdminReply.feedbackId = Feedback.feedbackId
                    INNER JOIN
                        Site
                        ON Site.siteId = Feedback.siteId
                    INNER JOIN
                        Company
                        ON Company.companyId  = Site.companyId
                    INNER JOIN
                        Category
                        ON Feedback.categoryId = Category.categoryId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                    INNER JOIN
                        FeedbackContactOrigin
                        ON Feedback.contactid  = FeedbackContactOrigin.contactid
                       AND Feedback.feedbackId = FeedbackContactOrigin.feedbackId
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
    
    //duplication??
    public function total_newfeedback_by_company($company_id=False) {
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
                 AND Feedback.isDeleted = 0
                 AND Feedback.isPublished = 0 
                 AND Feedback.isFeatured = 0
                 AND Feedback.isFlagged = 0
                 AND Feedback.isSticked = 0
                 AND Feedback.isArchived = 0
        ";
        $sth = $this->dbh->prepare($sql);

        if($this->company_id) {
            $company_id = $this->company_id;
        }

        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        return $row_count->fetchColumn(); 
    }

    public function fetch_latest_feedback_id($company_id) {
        $sth = $this->dbh->prepare('
            SELECT 
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
            ORDER BY 
                Feedback.dtAdded DESC 
            LIMIT 1
        ');

        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }

    public function televised_feedback_alt($company_name) { 
        $sql = ' 
            SELECT
                '.$this->select_vars.' 
                , (SELECT COUNT(useful) FROM FeedbackActions WHERE Feedback.feedbackId = FeedbackActions.feedbackId) AS vote_count
                , FeedbackActions.useful 
                , FeedbackActions.flagged AS flagged_as_inappr
                , FeedbackAdminReply.userId AS admin_userid
                , FeedbackAdminReply.adminReply AS admin_reply
                , User.username AS admin_username
                , User.fullName AS admin_fullname
                , User.email AS admin_email 
                , User.email AS admin_email 
                , Company.name AS admin_companyname 
                , Company.fullpageCompanyName AS admin_fullpagecompanyname 
            FROM 
                Feedback
            LEFT JOIN
                FeedbackAdminReply
                ON FeedbackAdminReply.feedbackId = Feedback.feedbackId
            LEFT JOIN
                User
                ON FeedbackAdminReply.userId = User.userId
            INNER JOIN
                Site
                ON Site.siteId = Feedback.siteId
            INNER JOIN 
                Company
                ON Company.companyId = Site.companyId
            INNER JOIN
                Category
                ON Category.categoryId = Feedback.categoryId
            INNER JOIN
                Contact
                ON Contact.contactId = Feedback.contactId 
            INNER JOIN
                FeedbackContactOrigin
                ON Feedback.contactid  = FeedbackContactOrigin.contactid
                AND Feedback.feedbackId = FeedbackContactOrigin.feedbackId
            INNER JOIN 
                Country
                ON Country.countryId = Contact.countryId  
            LEFT JOIN
                FeedbackActions
                ON Feedback.feedbackId = FeedbackActions.feedbackId
                AND FeedbackActions.ip_address = :client_ip
            WHERE 1=1
                AND Company.name = :company_name
                AND (Feedback.isFeatured = 1 OR Feedback.isPublished = 1)
            GROUP BY
                FeedbackActions.useful
            ORDER BY 
                Feedback.dtAdded DESC 
        ';
        
        $client_ip = Helpers::get_client_ip();
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_name', $company_name, PDO::PARAM_STR);
        $sth->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
        $sth->execute();

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");

        $result_obj = new StdClass;
        $result_obj->result = $this->_return_feedback_nodes($sth->fetchAll(PDO::FETCH_CLASS));
        $result_obj->total_rows = $row_count->fetchColumn();
        return $result_obj; 
    }

    public function count_todays_feedback($company_id) {
        $sql = "
            SELECT COUNT(*) as feed_count FROM Feedback
            INNER JOIN Site ON Site.siteId = Feedback.siteId
            INNER JOIN Company ON Company.companyId = Site.companyId
            WHERE 1=1
                AND Feedback.dtAdded BETWEEN date_sub(now(), INTERVAL 24 hour) AND now()
                AND Company.companyId = :company_id
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute(); 
        return $sth->fetch(PDO::FETCH_OBJ);
    }
    
    //DB WRITES
    public function _change_feedback($column, $feedback_id, $state) {
        //release indLock for block display
        $this->_release_indlock($feedback_id, 0);
        return $this->_toggle_state('Feedback', 'feedbackId', $feedback_id, $column, $state);
    }    

    public function toggle_indlock($feedback_id, $state) {
        return $this->_release_indlock($feedback_id, $state);
    } 

    private function _release_indlock($feedback_id, $state) { 
        DB::table('Feedback', 'master')
                  ->where('feedbackId', '=', $feedback_id)
                  ->update(array('indLock' => $state));    
    }

    public function _toggle_multiple($feedbackstate) { 
        //We need this to reset internal category id to default
        $column   = $feedbackstate->column;
        $in_query = $feedbackstate->query;
        $sql = "UPDATE Feedback $column WHERE 1=1 AND Feedback.feedbackId IN ($in_query)";
        $sth = $this->dbh->prepare($sql); 
        foreach($feedbackstate->block_id as $k => $id) {
            $sth->bindValue(($k+1), $id['feedid']);
        }
        return $sth->execute();       
    }

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
        
        $profile_img = new Profile\Services\ProfileImage();
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

    private function _toggle_state($table, $where_column, $id, $column, $state) {  
        DB::table($table, 'master')
                  ->where($where_column, '=', $id)
                  ->update(array($column => $state));    
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

    public function update_feedback($id, $fields){
        return DB::table('Feedback','master')
                    ->where('feedbackId','=',$id)
                    ->update($fields);
    }

    public function update_feedback_text($feedback_id, $text, $is_profane)  { 
        $affected = DB::table('Feedback', 'master')
            ->where('feedbackId', '=', $feedback_id)
            ->update(Array(
                  'text' => $text
                , 'hasProfanity' => ($is_profane) ? 1 : 0
            ));
        return $affected;
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

    public function permanently_remove_feedback($id) { 

        $feedback = DB::table('Feedback', 'master')
                        ->join('Contact', 'Feedback.contactId', '=', 'Contact.contactId')
                        ->where('Feedback.feedbackId', '=', $id)
                        ->first();

        if($feedback) {
            if($feedback->avatar) { 
                //delete profile photos...
                $profile_img = new ProfileImage();
                $profile_img->remove_profile_photo($feedback->avatar);
            }

            DB::table('FeedbackContactOrigin')->where('FeedbackContactOrigin.feedbackId', '=', $id)->delete();  
            DB::table('Contact')->where('Contact.contactId', '=', $feedback->contactid)->delete();
            DB::table('FeedbackActivity')->where('FeedbackActivity.feedbackId', '=', $id)->delete();
            //Previously I wanted feedback deleted with isDeleted column set to 1. Let's do a hard delete instead...
            DB::table('Feedback')->where('Feedback.feedbackId', '=', $id)
                                 //->where('Feedback.isDeleted', '=', 1)
                                 ->delete();
            
            //let's make sure to add a query for removing tags from the MetadataTags table if need be
            DB::table('FeedbackMetadataTagMap')->where('FeedbackMetadataTagMap.feedbackId', '=', $id)->delete(); 
        } else {
            throw new Exception("Feedback does not exist. Cannot carry on with deletion!");
        }
    }

    public function insert_new_feedback($feedback_data) { 
        if($feedback_data) 
            return DB::table('Feedback')->insert_get_id($feedback_data);
    }

    public function _return_feedback_nodes($feedback) { 

        $collection = Array();
        $node = Null;

        foreach($feedback as $data)  {
            $node = new FeedbackNode($data);
            $collection[] = $node->generate();
        }

        return $collection;
    }
 
    // get record of user's action on the feedback.
    public function get_feedback_actions($data) { 
        $result = DB::table('FeedbackActions')
            ->where('ip_address', '=', $data->ip_address)
            ->where('feedbackId', '=', $data->feedbackId)
            ->first();
        
        return $result; 
    }
    
    
    // do feedback action.
    public function exec_feedback_action($type, $data) {
        
        $action_data = Array();

        // set the distinct data needed in feedback actions.
        $action_data['flag']['field'] = 'flagged';
        $action_data['flag']['insert_data'] = $data->flag_insert_data; 
    
        $action_data['vote']['field'] = 'useful';
        $action_data['vote']['insert_data'] = $data->vote_insert_data;
        
        // if the type of action doesn't exist, don't proceed.
        if( ! array_key_exists($type, $action_data) ) return;
        
        
        // get record of user's action on the feedback.
        $result = $this->get_feedback_actions($data);
        
        // if the feedback action was already done, don't proceed.
        if( ! is_null($result) && $result->$action_data[$type]['field'] == 1 ) return;
        
        // if the feedback action hasn't been done, do it.
        if( ! is_null($result) && $result->$action_data[$type]['field'] != 1 ){
            
            DB::table('FeedbackActions')
                ->where('ip_address', '=', $data->ip_address)
                ->where('feedbackId', '=', $data->feedbackId)
                ->update( $action_data[$type]['insert_data'] );
            
        // if no action has been done on the feedback, insert a new action record.
        }elseif( is_null($result) ){
            
            DB::table('FeedbackActions')->insert( $action_data[$type]['insert_data'] );
            
        }
        
    }
    
}
