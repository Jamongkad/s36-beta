<?php

class Feedback {

    public static function pull_feedback($user_id, $limit=5, $offset=0) {

        $dbh = DB::connection('master');    
        $sth = $dbh->prepare('
            SELECT 
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Feedback.status AS status
                , Feedback.priority AS priority
                , Feedback.text
                , Feedback.dtAdded AS date
                , Feedback.rating
                , Feedback.isFeatured
                , Contact.firstName AS firstname
                , Contact.lastName AS lastname
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
                        AND User.userId = :user_id
                    GROUP BY
                        1
                    ORDER BY
                        Feedback.dtAdded DESC
                    LIMIT :limit OFFSET :offset
        ');
 
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();       

        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
