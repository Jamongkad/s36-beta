<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB;

class DBSocialFeedback extends S36DataObject {
   
    public function convert($data) {
        try { 
            $this->dbh->beginTransaction();

            //check if socialId exists in FeedbackContactOrigin table if not continue...
            $social_id_exists = DB::Table('FeedbackContactOrigin', $this->db_name)
                                         ->where('socialId', '=', $data->id)
                                         ->first();
            
            if(!$social_id_exists) {
                $contact = Array(
                    'firstName' => $data->firstname
                  , 'siteId' => 8
                  , 'countryId' => 895
                  , 'avatar'    => $data->avatar 
                  , 'profileLink' => 'http://twitter.com/'.$data->screen_name
                  , 'loginType'   => 'tw'
                  , 'website' => 'http://twitter.com'
                );  

                $contact_insert_id = DB::table('Contact', $this->db_name)->insert_get_id($contact);

                $feedback = Array(
                    'text' => $data->text
                  , 'siteId' => 8
                  , 'dtAdded' => $data->date
                  , 'contactId' => $contact_insert_id
                  , 'categoryId' => 6
                  , 'status' => 'new'
                  , 'permission' => 0
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

}
