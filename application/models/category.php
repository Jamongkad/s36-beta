<?php

class Category {
    public function pull_site_categories($user_id) {
        $dbh = DB::connection('master');     
        $sth = $dbh->prepare("
            SELECT 
                Category.categoryId
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
