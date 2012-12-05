<?php namespace Company\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBCompanySocialAccount extends S36DataObject {

    public function fetch_social_account($social) { 

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
    }

}
