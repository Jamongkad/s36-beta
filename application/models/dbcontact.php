<?php

class DBContact extends S36DataObject {

    public function insert_new_contact($opts) {
         $id = DB::table('Contact', 'master')->insert_get_id($opts);
         return $id; 
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

    public function fetch_contacts($limit, $offset, $search_term=false) { 
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 

        $search_query = null;

        if($search_term) {
            $search_query = sprintf("AND Contact.email LIKE '%%%s%%' OR Contact.firstname LIKE '%%%s%%' OR Contact.lastname LIKE '%%%s%%'", 
                                     $this->escape($search_term), $this->escape($search_term), $this->escape($search_term));
        }

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
                User
                    ON User.companyId = Site.companyId
            INNER JOIN
                Country
                    ON Country.countryId = Contact.countryId 
            WHERE 1=1
                AND User.userId = :user_id
                $search_query
            GROUP BY
                Contact.email
            ORDER BY 
                Contact.contactId DESC
            LIMIT :offset, :limit
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $this->user_id);
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
                 Contact.contactId
               , LCASE(Contact.email)
               , Feedback.feedbackId
               , Category.name AS category
               , Category.categoryId
               , Feedback.status AS status
               , Feedback.dtAdded AS date
               , CASE
                    WHEN Feedback.priority < 30 THEN "low"
                    WHEN Feedback.priority >= 30 AND Feedback.priority <= 60 THEN "medium"
                    WHEN Feedback.priority > 60 AND Feedback.priority <= 100 THEN "high"
                 END AS priority
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
               , Country.name AS countryname
               , Country.code AS countrycode
               , Site.siteId AS siteid
               , Feedback.text 
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
                User
                    ON User.companyId = Company.companyId
            INNER JOIN
                Category
                    ON Category.categoryId = Feedback.categoryId 
            WHERE 1=1 
                AND Contact.firstName = :first_name
                AND LCASE(Contact.email) = :email
                AND User.userId = :user_id
            ORDER BY
                Feedback.dtAdded DESC
        ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":user_id", $this->user_id);
        $sth->bindParam(":first_name", $obj->name); 
        $sth->bindParam(":email", $obj->email);
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

        $profile_img = new Widget\ProfileImage();
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

class ContactMetrics {

    private $contacts_model;

    public function __construct() {
        $this->contacts_model = new DBContact; 
    }

    public function render_metric_bar() {

        $company_id = S36Auth::user()->companyid;

        $metric = new Metric;
        $metric->company_id = $company_id;

        $contact_count = $this->contacts_model->count_total_contacts();

        return View::make('partials/contact_metricbar_view', Array(
            'contact_count' => $contact_count
          , 'metric' => $metric->fetch_metrics()
        ));
    }
}
