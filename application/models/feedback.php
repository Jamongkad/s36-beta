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
                  Feedback.feedbackId AS id
                , Category.intName
                , Category.name AS category
                , Feedback.status AS status
                , Feedback.priority AS priority
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

    public function pull_feedback_by_id($id) { 
        $sth = $this->dbh->prepare('
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

    public function change_feedback_cat($feedback_id, $cat_id) {
        $sth = $this->dbh->prepare("
            UPDATE Feedback 
            SET 
                Feedback.categoryId = :cat_id
                WHERE Feedback.feedbackId = :feedback_id
        ");

        $sth->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $sth->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $sth->execute();       
    }

    public function make_sticky($feedback_id, $state) {

        $stickState = Null;

        if($state == "Make Sticky") { $stickState = 1; }
        
        if($state == "Stickied") { $stickState = 0; }
       
        $sth = $this->dbh->prepare("
            UPDATE Feedback 
            SET 
                Feedback.isSticked = :state
                WHERE Feedback.feedbackId = :feedback_id
        ");

        $sth->bindParam(':state', $stickState, PDO::PARAM_INT);
        $sth->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $sth->execute();       
    }

    public function change_feedback_status($feedback_id, $status) {
        $sth = $this->dbh->prepare("
            UPDATE Feedback 
            SET 
                Feedback.status = :status
                WHERE Feedback.feedbackId = :feedback_id
        ");

        $sth->bindParam(':status', $status, PDO::PARAM_STR);
        $sth->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $sth->execute();       
    }
}
