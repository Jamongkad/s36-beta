<?php

class Feedback {
    public static function pull_feedback($user_id) { 
        $conn = DB::connection('master');
        $feedback = $conn->query("
            SELECT 
                  Feedback.feedbackId
                , Category.intName
                , Category.name AS category
                , Status.name AS status
                , Feedback.priority AS priority
                , Feedback.text
                , Feedback.dtAdded
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
                        Status
                        ON Feedback.statusId = Status.statusId
                    INNER JOIN
                        Contact
                        ON Contact.contactId = Feedback.contactId 
                        AND Contact.siteId = Site.siteId
                    WHERE 1=1
                        AND User.userId = $user_id
                    GROUP BY
                        Feedback.feedbackId
                    ORDER BY
                        Feedback.dtAdded DESC
        ");

        return $feedback->fetchAll(PDO::FETCH_CLASS);
    }
}
