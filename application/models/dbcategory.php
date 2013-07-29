<?php

class DBCategory extends S36DataObject {
    
    public function pull_site_categories() {

        $sth = $this->dbh->prepare("
            SELECT 
                  Category.categoryId AS id
                , Category.intName
                , Category.name
                , Category.changeable
            FROM 
                Category
            WHERE 1=1 
                AND Category.companyId = :company_id
                AND Category.intName != 'default'
            ORDER BY 
                Category.categoryId
        ");

        $sth->bindParam(":company_id", $this->company_id, PDO::PARAM_INT);
        $sth->execute();
 
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }

    public function write_category_name($ctgy_nm) {
        $category_count = $this->_category_count();
        $status = '';

        if($category_count->category_count != 6) { 
            $opts = Array(
                'companyId' => $this->company_id
              , 'intName' => strtolower($ctgy_nm)
              , 'name' => ucfirst($ctgy_nm)
              , 'changeable' => 1
            );

            $result = DB::table('Category', 'master')->insert_get_id($opts);
            if($result) {
                $status = "success";
            } else {
                $status = "failed"; 
            }
            echo json_encode(Array('status' => $status, 'count' => $category_count));
        } else { 
            echo json_encode(Array('status' => 'max', 'count' => $category_count));
        }
    }

    public function _category_count() {
        $sql = "SELECT COUNT(categoryId) AS category_count FROM Category WHERE 1=1 AND companyId = :company_id AND changeable = 1";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":company_id", $this->company_id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update_category_name($ctgy_nm, $ctgy_id) {
        DB::Table('Category', 'master')
            ->where('categoryId', '=', $ctgy_id)
            ->update(Array( 
                'intName' => strtolower($ctgy_nm)
              , 'name' => ucfirst($ctgy_nm)
            ));
    }

    public function delete_category_name($ctgy_id) {
        DB::Table('Category', 'master')     
            ->where('categoryId', '=', $ctgy_id)
            ->delete();
    }
}
