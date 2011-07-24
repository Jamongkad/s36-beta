<?php
//Going old school PDO. No flappy gearbox ORM's hahaha
class Feedback {

    private $dbh;

    public function __construct() {
        $this->dbh = DB::connection('master');
    }

    public function pull_feedback($user_id, $limit=5, $offset=0) {
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
                  END as priority
                , Feedback.text
                , Feedback.dtAdded AS date
                , Feedback.rating
                , Feedback.isFeatured
                , Feedback.isFlagged
                , Feedback.isPublished
                , Feedback.isArchived
                , Feedback.isSticked
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
                , Country.name AS countryname
                , Country.code as countrycode
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
                    GROUP BY
                        1
                    ORDER BY
                        Feedback.dtAdded DESC
                    LIMIT :offset, :limit 
        ');
 
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();       

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        //print_r($row_count->fetchColumn());
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        //return $result;
        $result_obj = new StdClass;
        $result_obj->result = $result;
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
                , Feedback.text
                , Feedback.dtAdded AS date
                , Feedback.rating
                , Feedback.isFeatured
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

    public function _change_feedback($column, $feedback_id, $state) {
        DB::table('Feedback', 'master')
                  ->where('feedbackId', '=', $feedback_id)
                  ->update(array($column => $state));
    }    

    public function fetched_delete_feedback($user_id) {
        
        $sth = $this->dbh->prepare('
            SELECT 
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
 
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->execute();       

        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
