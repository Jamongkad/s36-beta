<?php namespace Company\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBCompanySocialAccount extends S36DataObject {

    public function fetch_social_account($social) { 
        //if user is logged in
        if($this->company_id) {
            $sql = "SELECT * FROM CompanySocialAccount 
                    WHERE 1=1 
                        AND CompanySocialAccount.companyId = :company_id
                        AND CompanySocialAccount.socialAccountOrigin = :origin
                    LIMIT 1";

            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':company_id', $this->company_id);
            $sth->bindParam(':origin', $social);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_OBJ);
            return $result; 
        } else {
            $sql = "SELECT * FROM CompanySocialAccount 
                    INNER JOIN
                        Company
                        ON CompanySocialAccount.companyId = Company.companyId
                    WHERE 1=1 
                        AND Company.name = :company_name
                        AND CompanySocialAccount.socialAccountOrigin = :origin
                    LIMIT 1";
            
            $sth->bindParam(':company_name', $this->company_name);
            $sth->bindParam(':origin', $social);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_OBJ);
            return $result; 
        }
    }

    public function save_social_account($data) { 
        return DB::Table('CompanySocialAccount', 'master')->insert($data); 
    }

    public function delete_social_account() {
        return DB::Table('CompanySocialAccount', 'master')->where('CompanySocialAccount.companyId', '=', $this->company_id)->delete();     
    }

}
