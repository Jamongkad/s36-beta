<?php namespace Contact\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB;
use ZebraPagination\ZebraPagination;

class DBContact extends S36DataObject {

    public function insert_new_contact($opts) {
        if($opts)
            return DB::table('Contact', 'master')->insert_get_id($opts);
    }

    public function count_total_contacts() { 
        $sql = "
            SELECT
               SQL_CALC_FOUND_ROWS
               Contact.email
            FROM 
                Contact
            INNER JOIN
                Feedback
                    On Feedback.contactId = Contact.contactId
            INNER JOIN
                Site
                    ON Site.siteId = Feedback.siteId
            INNER JOIN
                User
                    On User.companyId = Site.companyId
            WHERE 1=1
                AND User.userId = :user_id
            GROUP BY
                Contact.email
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $this->user_id);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
         
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $result_obj = new StdClass; 
        $result_obj->total_rows = $row_count->fetchColumn();

        return $result_obj;
    }

    public function total_contacts_by_company($company_id) {
        $sql = "
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  Contact.contactId
            FROM 
                Contact
                    INNER JOIN
                        Site
                        ON Site.siteId = Contact.siteId 
                    INNER JOIN
                        Company
                        ON Company.companyId = Site.companyId
             WHERE 1=1
                 AND Company.companyId = :company_id
             GROUP BY
                 Contact.email;
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $sth->execute();

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        return $row_count->fetchColumn();
    }
    
    //A function must do one thing and do it well.
    public function fetch_contacts($offset, $limit) { 
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 

        $sql = "
            SELECT
                SQL_CALC_FOUND_ROWS
                Contact.contactId
              , Contact.email 
              , Contact.firstname
              , Contact.lastname
              , Contact.avatar
              , GROUP_CONCAT(Feedback.feedbackId ORDER BY Feedback.dtAdded DESC SEPARATOR '|') AS feedbackIds
              , COUNT(Feedback.feedbackId) AS feedbackIdCount
            FROM 
                Contact
            INNER JOIN
                Feedback
                    On Feedback.contactId = Contact.contactId
            INNER JOIN
                Site
                    ON Site.siteId = Contact.siteId
            INNER JOIN
                Company
                    ON Company.companyId = Site.companyId
            INNER JOIN
                Country
                    ON Country.countryId = Contact.countryId 
            WHERE 1=1
                AND Company.companyId = :company_id
            GROUP BY
                Contact.email, Contact.firstName, Contact.lastName
            ORDER BY 
                Contact.contactId DESC
            LIMIT :offset, :limit
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->company_id);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");

        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->total_rows = $row_count->fetchColumn();

        return $result_obj;
    }

    public function search_contacts($search_term, $offset, $limit) {

        $sql = "
            SELECT
                SQL_CALC_FOUND_ROWS
                Contact.contactId
              , Contact.email 
              , Contact.firstname
              , Contact.lastname
              , Contact.avatar
              , GROUP_CONCAT(DISTINCT Feedback.feedbackId ORDER BY Feedback.feedbackId DESC SEPARATOR '|') AS feedbackIds
              , COUNT(Feedback.feedbackId) AS feedbackIdCount
            FROM 
                Contact
            INNER JOIN
                Feedback
                    On Feedback.contactId = Contact.contactId
            INNER JOIN
                Site
                    ON Site.siteId = Contact.siteId
            INNER JOIN
                Company
                    ON Company.companyId = Site.companyId
            INNER JOIN
                Country
                    ON Country.countryId = Contact.countryId 
            WHERE 1=1
                AND Company.companyId = :company_id
                AND Contact.email LIKE :search
            GROUP BY
                Contact.email
            ORDER BY 
                Contact.contactId DESC
            LIMIT :offset, :limit
        ";

        $search_term = '%'.$search_term.'%';

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->company_id);
        $sth->bindParam(':search', $search_term);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);

        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");

        $result_obj = new StdClass;
        $result_obj->result = $result;
        $result_obj->total_rows = $row_count->fetchColumn();

        return $result_obj;
    }

    public function get_contact_feedback($obj) {
        $sql = '
            SELECT 
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
            FROM 
                Contact 
            INNER JOIN
                Feedback
                    ON Feedback.contactId = Contact.contactId
            INNER JOIN
                Site
                    ON Site.siteId = Contact.siteId
            INNER JOIN
                Company 
                    ON Company.companyId = Site.companyId
            INNER JOIN
                 Country
                    ON Contact.countryId = Country.countryId
            INNER JOIN
                Category
                    ON Category.categoryId = Feedback.categoryId 
            WHERE 1=1 
                AND Contact.firstName = :first_name
                AND LCASE(Contact.email) = :email
                AND Company.companyId = :company_id
                AND Feedback.isDeleted = 0
            ORDER BY
                Feedback.dtAdded DESC
            LIMIT :offset, :limit
        ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":first_name", $obj->name); 
        $sth->bindParam(":email", $obj->email);
        $sth->bindParam(":company_id", $this->company_id); 
        $sth->bindParam(":offset", $obj->offset);
        $sth->bindParam(":limit", $obj->limit);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);

        return $result;
    }

    public function get_contact_info($email, $multiple=false) {
       $sql = " 
        SELECT 
              Contact.contactId
            , Contact.siteId
            , Contact.email 
            , Contact.firstname
            , Contact.lastname
            , Contact.avatar
            , Contact.position
            , Contact.companyName
            , Country.name
            , Country.countryId
        FROM 
            Contact
        INNER JOIN
            Feedback
                ON Feedback.contactId = Contact.contactId
        INNER JOIN
            Site
                ON Site.siteId = Contact.siteId
        INNER JOIN 
            Country
                ON Country.countryId = Contact.countryId
        INNER JOIN
            Company
                ON Company.companyId = Site.companyId
        INNER JOIN
            User
                ON User.companyId = Company.companyId
        WHERE 1=1
            AND lcase(Contact.email) = :email
            AND User.userId = :user_id
        ORDER BY
            Contact.contactId DESC 
       ";

       $sth = $this->dbh->prepare($sql);
       $sth->bindParam(":email", $email, PDO::PARAM_STR);
       $sth->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
       $sth->execute();

       if($multiple == true) { 
           $result = $sth->fetchAll(PDO::FETCH_CLASS); 
       } else {
           $result = $sth->fetch(PDO::FETCH_OBJ); 
       }
      
       return $result;
    }

    public function update_contact($data) {
     
        $str = 'SET ';
        foreach($data as $key => $value) {
           if($key != 'page') {
               $str .= "Contact.".$key.'='.(($value) ? "'".trim($value)."'" : "NULL").",";    
           } 
        }

        $column = trim($str, ",");

        $sql = "
            UPDATE Contact
                INNER JOIN
                    Feedback
                    ON Feedback.contactId = Contact.contactId
                INNER JOIN
                    Site
                    ON Site.siteId = Contact.siteId
                INNER JOIN 
                    Country
                    ON Country.countryId = Contact.countryId
                INNER JOIN
                    Company
                    ON Company.companyId = Site.companyId
                INNER JOIN
                    User
                    ON User.companyId = Company.companyId
                $column
                WHERE 1=1
                    AND User.userId = :user_id
                    AND LCASE(Contact.email) = :email
            ";
          
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->bindParam(':email', $data['email'], PDO::PARAM_STR); 
        $sth->execute();        
    }

    public function delete_contact($email) {

        $profile_img = new Profile\Services\ProfileImage();
        $avatars = $this->get_contact_info($email, $multiple=true);

        foreach($avatars as $avatar) {
            $profile_img->remove_profile_photo($avatar->avatar);
        }

        $delete_feedback_sql = "
            DELETE FROM 
                Feedback
            WHERE contactId IN (
                SELECT 
                    Contact.contactId       
                FROM 
                    Contact
                INNER JOIN
                    Site
                    ON Site.siteId = Contact.siteId
                INNER JOIN 
                    Country
                    ON Country.countryId = Contact.countryId
                INNER JOIN
                    Company
                    ON Company.companyId = Site.companyId
                INNER JOIN
                    User
                    ON User.companyId = Company.companyId
                WHERE 1=1
                    AND Contact.email = :email
                    AND User.userId = :user_id
            )
        ";

        $sth = $this->dbh->prepare($delete_feedback_sql);  
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->bindParam(':email', $email, PDO::PARAM_STR); 
        $sth->execute();        

        $delete_contact_sql = " 
            DELETE FROM
                Contact
            USING
                Contact
                    INNER JOIN
                    Site
                    ON Site.siteId = Contact.siteId
                INNER JOIN 
                    Country
                    ON Country.countryId = Contact.countryId
                INNER JOIN
                    Company
                    ON Company.companyId = Site.companyId
                INNER JOIN
                    User
                    ON User.companyId = Company.companyId
                WHERE 1=1
                    AND Contact.email = :email
                    AND User.userId = :user_id
        ";

        $sth = $this->dbh->prepare($delete_contact_sql);  
        $sth->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $sth->bindParam(':email', $email, PDO::PARAM_STR); 
        $sth->execute();
    }

}
