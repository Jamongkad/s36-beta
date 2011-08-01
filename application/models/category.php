<?php

class Category {
    
    private $dbh;

    public function __construct() {
        $this->dbh = DB::connection('master');
    }

    public function pull_site_categories() {
        $dbh = DB::connection('master');     

        $user_id = S36Auth::user()->userid;

        $sth = $this->dbh->prepare("
            SELECT 
                Category.categoryId AS id
                , Category.siteId
                , Category.intName
                , Category.name
                , Category.changeable
            FROM 
                User 
            INNER JOIN
                Company
                ON Company.companyId = User.companyId
            INNER JOIN
                Site
                On Company.companyId = Site.companyId
            INNER JOIN
                Category
                On Category.siteId = Site.siteId
            WHERE 1=1
                AND User.userId = :user_id;
        ");

        $sth->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
