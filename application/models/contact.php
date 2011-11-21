<?php

class Contact extends S36DataObject {

    public function insert_new_contact($opts) {
         $id = DB::table('Contact', 'master')->insert_get_id($opts);
         return $id; 
    }

    public function fetch_contacts($limit, $offset) { 
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 
        $sql = "
            SELECT
                SQL_CALC_FOUND_ROWS
                Contact.email 
              , Contact.firstname
              , Contact.lastname
              , Contact.avatar
              , GROUP_CONCAT(DISTINCT Feedback.feedbackId ORDER BY Feedback.feedbackId DESC SEPARATOR '|') AS feedbackIds
              , GROUP_CONCAT(
                    CASE 
                        WHEN Feedback.rating = 1 THEN 'POOR' 
                        WHEN Feedback.rating = 2 THEN 'POOR'
                        WHEN Feedback.rating = 3 THEN 'AVERAGE'
                        WHEN Feedback.rating = 4 THEN 'GOOD'
                        WHEN Feedback.rating = 5 THEN 'EXCELLENT'
                    END  
                    ORDER BY Feedback.feedbackId DESC SEPARATOR '|'
                ) AS ratings
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
}
