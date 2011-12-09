<?php

class Category extends S36DataObject {
    

    public function pull_site_categories() {

        $sth = $this->dbh->prepare("
            SELECT 
                  Category.categoryId AS id
                , Category.intName
                , Category.name
                , Category.changeable
            FROM 
                Category
            INNER JOIN
                Company
                    ON Company.companyId = Category.companyId
            INNER JOIN
                User
                    ON User.companyId = Company.companyId
            WHERE 1=1
                AND User.userId = :user_id
            ORDER BY 
                Category.name 
        ");

        $sth->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }

    public function write_category_name($ctgy_nm, $companyId) {
        /*
        $opts = Array(
            'companyId' => $companyId
          , 'intName' => strtolower($ctgy_nm)
          , 'name' => ucfirst($ctgy_nm)
          , 'changeable' => 1
        );

        $result_id = DB::table('Category', 'master')->insert_get_id($opts);
        */
        $result_id = 99;

        $rename_link = HTML::link('settings/rename_ctgy/'.$result_id, 'Rename', Array('class' => 'rename-ctgy'));
        $delete_link = HTML::link('settings/delete_ctgy/'.$result_id, 'Delete', Array('class' => 'delete-ctgy'));

        return "<div class='grids padded' style='padding-bottom:10px;'>
                    <div class='g1of3'>
                        <strong class='ctgy-name'>$ctgy_nm</strong>
                    </div>
                    <div class='g1of3 align-center'> 
                        $rename_link | $delete_link
                    </div>                    
                </div>"; 
    }
}
