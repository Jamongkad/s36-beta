<?php namespace Company\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

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

    public function update_companyinfo($post) {
        //do an update 
        DB::Table('Company', 'master')
            ->where('companyId', '=', $post->companyid)
            ->update(Array( 
                'description'  => $post->company_desc
              , 'fullpageCompanyName' => $post->fullpagecompanyname
              , 'social_links' => $post->social_links 
              , 'fb_link' => $post->fb_link
              , 'twit_link' => $post->twit_link
              , 'logo' => $post->logo
            )); 
    }

    public function get_company_info($company_id) {

        if(is_numeric($company_id)) {
            $company_sql = "Company.companyId = :company_id";
        } else { 
            $company_sql = "Company.name = :company_id";
        }

        $sql = "
            SELECT 
                * 
              , Company.name AS company_name 
            FROM 
                Company
            INNER JOIN
                Site
                    ON Site.companyId = Company.companyId
            WHERE 1=1
                AND $company_sql
            LIMIT 1
        ";
        $sth = $this->dbh->prepare($sql);     

        $sth->bindParam(':company_id', $company_id);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    } 
}
