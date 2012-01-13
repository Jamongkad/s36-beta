<?php

class DBDashboard extends S36DataObject {


   public function get_dashboard_scores($company_id) {
       $result = new StdClass;     
       $result->feedback_scores = $this->get_feedback_scores($company_id); 
       $result->geochart_scores = $this->get_geochart_scores($company_id);

       return $result;
   }

   public function get_feedback_scores($company_id) {
       $sth = $this->dbh->prepare("
              SELECT 
                COUNT(Feedback.feedbackId) AS pending
              , SUM(IF(Feedback.rating BETWEEN 4 AND 5, 1, 0)) AS excellent
              , SUM(IF(Feedback.rating = 3, 1, 0)) AS average
              , SUM(IF(Feedback.rating BETWEEN 1 AND 2, 1, 0)) AS poor
              , SUM(Feedback.isPublished) AS published
              , SUM(Feedback.isFeatured) AS featured
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
                AND Feedback.dtAdded >= DATE_SUB(NOW(), INTERVAL 1 MONTH)     
       ");

        $sth->bindParam(":company_id", $company_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
   }

   public function get_geochart_scores($company_id) { 
       $sth = $this->dbh->prepare("
            SELECT 
                Contact.countryId 
              , Site.name
              , Company.name
              , Country.name
              , Country.code
              , COUNT(Feedback.feedbackId) AS feedbackCnt
            FROM 
                Contact 
            INNER JOIN
                Site
                    On Contact.siteId = Site.siteId
            INNER JOIN
                Company
                    ON Site.companyId = Company.companyId
            INNER JOIN
                Country
                    ON Country.countryId = Contact.countryId
            INNER JOIN
                Feedback
                    ON Feedback.contactId = Contact.contactId
            WHERE 1=1
                AND Contact.countryId != 895
                AND Company.companyId = :company_id
            GROUP BY
                Contact.countryId
            ORDER BY 
                feedbackCnt DESC      
       ");

        $sth->bindParam(":company_id", $company_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
   }
}
