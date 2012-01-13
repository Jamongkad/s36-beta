<?php

class DBDashboard extends S36DataObject {
   
   public $company_id;

   public function get_dashboard_scores() {
       $result = new StdClass;     
       $result->feedback_scores = $this->get_feedback_scores(); 
       $result->geochart_scores = $this->get_geochart_scores();
       return $result;
   }

   public function get_feedback_scores() {
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

       $sth->bindParam(":company_id", $this->company_id, PDO::PARAM_INT);
       $sth->execute();
 
       $result = $sth->fetch(PDO::FETCH_OBJ);
       return $result;
   }

   public function get_geochart_scores() { 
       $sth = $this->dbh->prepare("
            SELECT 
                Contact.countryId 
              , Site.domain AS url
              , Company.name AS companyName
              , Company.companyId AS companyId
              , Country.name AS countryName
              , Country.code AS countryCode
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

       $sth->bindParam(":company_id", $this->company_id, PDO::PARAM_INT);
       $sth->execute(); 
       $result = $sth->fetchAll(PDO::FETCH_CLASS);
       return $result;
   }

   public function summary_exists() {
       $sth = $this->dbh->prepare("SELECT dashboardId FROM DashboardSummary WHERE companyId = :company_id LIMIT 1");
       $sth->bindParam(":company_id", $this->company_id, PDO::PARAM_INT);
       $sth->execute();
       return $sth->fetch(PDO::FETCH_OBJ);
   }

   public function write_summary() {        
       $geoscore = $this->get_geochart_scores();
       if($geoscore) {
           $insert_data = Array();
           $insert_query = Array();
           foreach($geoscore as $rows) {
               $insert_query[] = '(?, ?, ?, ?, ?)';
               $insert_data[] = $this->company_id;
               $insert_data[] = $rows->countryid; 
               $insert_data[] = $rows->countryname;
               $insert_data[] = $rows->countrycode; 
               $insert_data[] = $rows->feedbackcnt;
           }

           return $insert_data;
       }
   }

   public function update_summary() {
       
   }
}
