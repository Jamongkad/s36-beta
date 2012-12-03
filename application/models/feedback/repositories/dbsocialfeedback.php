<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, Helpers, DB, Config;
use PDO, StdClass;

class DBSocialFeedback extends S36DataObject {
   
    public function convert($data) {
        try { 
            $this->dbh->beginTransaction();
            
            $site_sql = "SELECT s.siteId FROM Company AS c INNER JOIN Site AS s ON c.companyId = s.companyId WHERE c.name = :company_name";
            $sth = $this->dbh->prepare($site_sql); 
            $sth->bindParam(":company_name", $this->company_name, PDO::PARAM_STR);
            $sth->execute();
            $site_id = $sth->fetch(PDO::FETCH_OBJ); 
 
            $ctgy_sql = "SELECT 
                             ctg.categoryId 
                         FROM 
                             Company AS cmp 
                         INNER JOIN 
                             Category AS ctg ON ctg.companyId = cmp.companyId 
                         WHERE 1=1 
                             AND cmp.name = :company_name and ctg.intName = 'default'";

            $sth = $this->dbh->prepare($ctgy_sql); 
            $sth->bindParam(":company_name", $this->company_name, PDO::PARAM_STR);
            $sth->execute();
            $ctgy_id = $sth->fetch(PDO::FETCH_OBJ); 

            $social_id_exists = DB::Table('FeedbackContactOrigin', $this->db_name)
                                         ->where('socialId', '=', $data->id)
                                         ->first();

             //check if socialId exists in FeedbackContactOrigin table if not continue...           
            if(!$social_id_exists) {
                
                $contact = Array(
                    'firstName' => $data->firstname
                  , 'siteId'    => $site_id->siteid
                  , 'countryId' => 895
                  , 'avatar'    => $data->avatar 
                  , 'profileLink' => 'http://twitter.com/'.$data->screen_name
                  , 'loginType'   => 'tw'
                  , 'website'     => 'http://twitter.com'
                );  

                $contact_insert_id = DB::table('Contact', $this->db_name)->insert_get_id($contact);

                $feedback = Array(
                    'text'    => $data->text
                  , 'siteId'  => $site_id->siteid
                  , 'dtAdded' => $data->date
                  , 'contactId'  => $contact_insert_id
                  , 'categoryId' => $ctgy_id->categoryid
                  , 'status'     => 'new'
                  , 'permission' => 1
                  , 'rating'     => 5
                );

                $feedback_insert_id = DB::table('Feedback', $this->db_name)->insert_get_id($feedback);

                $origin = Array(
                    'contactId'  => $contact_insert_id 
                  , 'feedbackId' => $feedback_insert_id
                  , 'origin'     => 'tw'
                  , 'socialId'   => $data->id
                );

                DB::table('FeedbackContactOrigin', $this->db_name)->insert_get_id($origin);  
            }

            $this->dbh->commit();
        } catch(PDOException $e) {
            $this->dbh->rollBack();
        }
    }
    
    public function delete_all() {
        $sql = "
            DELETE 
                Feedback, Contact, FeedbackContactOrigin 
            FROM 
                Feedback 
            INNER JOIN 
                Contact 
                ON Contact.contactId = Feedback.contactId 
            INNER JOIN
                Site
                ON Feedback.siteId = Site.siteId
            INNER JOIN
                Company
                ON Company.companyId = Site.companyId
            INNER JOIN 
                FeedbackContactOrigin 
                ON FeedbackContactOrigin.contactId = Feedback.contactId 
            WHERE 1=1 
                AND FeedbackContactOrigin.origin = 'tw'
                AND Company.name = :company_name
        ";

        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(":company_name", $this->company_name, PDO::PARAM_STR);
        return $sth->execute();
    }
}
