<?php

class Contact extends S36DataObject {

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

    public function fetch_contacts($limit, $offset) { 
        $this->dbh->query("SET GLOBAL group_concat_max_len=1048576"); 
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
        $sql = "
            SELECT 
                 Contact.contactId
               , LCASE(Contact.email)
               , Feedback.feedbackId
               , Contact.firstName
               , Contact.lastName
               , Contact.avatar
               , Country.name
               , Country.code
               , Site.siteId
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
            WHERE 1=1 
                AND Contact.firstName = :first_name
                AND LCASE(Contact.email) = :email
                AND User.userId = :user_id
            ORDER BY
                Feedback.dtAdded DESC
        ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":user_id", $this->user_id);
        $sth->bindParam(":first_name", $obj->name); 
        $sth->bindParam(":email", $obj->email);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);

        return $result;
    }

}

class ContactMetrics {

    private $contacts_model;

    public function __construct() {
        $this->contacts_model = new Contact; 
    }

    public function render_metric_bar() {
        $contact_count = $this->contacts_model->count_total_contacts();
        return View::make('partials/contact_metricbar_view', Array(
            'contact_count' => $contact_count
        ));
    }
}
