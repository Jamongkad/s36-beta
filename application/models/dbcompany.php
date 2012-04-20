<?php

class DBCompany extends S36DataObject {
    public function update_company_emails($post) {
        DB::Table('Company', 'master') 
            ->where('companyId', '=', $post->companyid)
            ->update(Array(
                'ffEmail1' => $post->ffEmail1
              , 'ffEmail2' => $post->ffEmail2
              , 'ffEmail3' => $post->ffEmail3
              , 'alias1' => $post->alias1
              , 'alias2' => $post->alias2
              , 'alias3' => $post->alias3
              , 'replyTo' => $post->replyTo
            ));
    }

    public function get_company_info($company_id) {
        $sql = "
            SELECT 
                *
            FROM
                Company
            INNER JOIN
                Site
                    ON Site.companyId = Site.companyId
            WHERE 1=1
                AND Company.companyId = :company_id
                AND Site.companyId = :site_id
        ";
        $sth = $this->dbh->prepare($sql);     

        $sth->bindParam(':company_id', $company_id);
        $sth->bindParam(':site_id', $company_id)
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
   
}
