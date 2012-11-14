<?php namespace Widget\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth, Exception;

class DBHostedSettings extends S36DataObject {

    private $hosted_settings;

    public function set_hosted_settings($hosted_settings)  {
        $this->hosted_settings = $hosted_settings;    
    }

    public function save() { 
        if($this->hosted_settings) { 
            if(!$this->record_exists()) 
                DB::table('HostedSettings', $this->db_name)->insert($this->hosted_settings);           
            else
                $this->update();
        } else {
            throw new Exception("Please provided a Hosted Settings array.");
        }
    } 

    public function update() {
        $sql = "UPDATE HostedSettings 
                    SET 
                        theme_name = :theme_name
                      , header_text = :header_text 
                      , submit_form_text = :submit_form_text 
                      , submit_form_question = :submit_form_question
                      , background_image = :background_image
                WHERE 1=1 
                    AND companyId = :company_id";

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->hosted_settings['companyId'], PDO::PARAM_INT);       
        $sth->bindParam(':theme_name', $this->hosted_settings['theme_name'], PDO::PARAM_STR);
        $sth->bindParam(':header_text', $this->hosted_settings['header_text'], PDO::PARAM_STR);       
        $sth->bindParam(':submit_form_text', $this->hosted_settings['submit_form_text'], PDO::PARAM_STR);       
        $sth->bindParam(':submit_form_question', $this->hosted_settings['submit_form_question'], PDO::PARAM_STR);
        $sth->bindParam(':background_image', $this->hosted_settings['background_image'], PDO::PARAM_STR);       
        $sth->execute();
    }

    public function record_exists() {
        $sql = "SELECT 
                    companyId
                  , theme_name
                  , header_text
                  , submit_form_text
                  , background_image
                  , TRIM(submit_form_question) AS submit_form_question
                FROM 
                    HostedSettings 
                WHERE 1=1 
                    AND companyId = :company_id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', S36Auth::user()->companyid, PDO::PARAM_INT);       
        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_OBJ); 
        return $result;
    }
    
    //this method makes more sense....retrieves hosted settings
    public function hosted_settings() {
        return $this->record_exists();
    }

}
