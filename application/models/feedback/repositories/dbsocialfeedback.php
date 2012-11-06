<?php namespace Feedback\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB;

class DBSocialFeedback extends S36DataObject {
   
    public function convert($data) {
        try { 
            $this->dbh->beginTransaction();
             
            $contact = Array(
                'firstName' => $data->firstname
              , 'siteId' => 8
              , 'countryId' => 895
              , 'avatar'    => $data->avatar 
              , 'profileLink' => 'http://twitter.com/'.$data->screen_name
              , 'loginType'   => 'tw'
              , 'website' => 'http://twitter.com'
            );  

            $contact_insert_id = DB::table('Contact', 'master')->insert_get_id($contact);

            $feedback = Array(
                'text' => $data->text
              , 'siteId' => 8
              , 'dtAdded' => $data->date
              , 'contactId' => $contact_insert_id
              , 'categoryId' => 6
              , 'status' => 'new'
              , 'permission' => 0
            );

            $feedback_insert_id = DB::table('Feedback', 'master')->insert_get_id($feedback);
 
            $this->dbh->commit();
        } catch(PDOException $e) {
            $this->dbh->rollBack();
        }
    }

}
