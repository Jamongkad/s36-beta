<?php

class Contact extends S36DataObject {

    public function insert_new_contact($opts) {
         $id = DB::table('Contact', 'master')->insert_get_id($opts);
         return $id; 
    }

    public function fetch_contacts() { 
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 
        $sql = "
            SELECT
                Contact.email 
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
        ";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $this->user_id);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result; 
    }
}
