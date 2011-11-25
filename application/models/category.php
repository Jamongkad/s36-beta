<?php

class Category extends S36DataObject {
    

    public function pull_site_categories() {

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

        $sth->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }
}
