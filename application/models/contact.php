<?php

class Contact {

    private $dbh;
    private $user_id;
 
    public function __construct() {
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }


    public function insert_new_contact($opts) {
         $sql = "INSERT INTO Contact (siteId, firstName, lastName, email, countryId, position, city, companyName, website, avatar) 
                              VALUES (:siteId, :firstName, :lastName, :email, :countryId, :position, :city, :companyName, :website, :avatar)";

         $stmt = $this->dbh->prepare($sql);

         $countryCode = DB::table('Country', 'master')->where('code', '=', $opts->countryId)->first();
 
         $stmt->bindParam(':siteId', $opts->site_id);
         $stmt->bindParam(':firstName', $opts->firstName);
         $stmt->bindParam(':lastName', $opts->lastName);
         $stmt->bindParam(':email', $opts->email);
         $stmt->bindParam(':countryId', $countryCode->countryid);
         $stmt->bindParam(':position', $opts->position);
         $stmt->bindParam(':city', $opts->city);
         $stmt->bindParam(':companyName', $opts->companyName);
         $stmt->bindParam(':website', $opts->website);
         $stmt->bindParam(':avatar', $opts->avatar);
         $result = $stmt->execute(); 

         //print_r($this->dbh->lastInsertId());
    }
}
