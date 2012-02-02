<?php

class DBWidget extends S36DataObject {    

    public function save_widget($widget_obj) {

        $widget_key = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);

        $sql = "INSERT INTO WidgetStore (widgetKey, widgetType, companyId, siteId, widgetObjString) 
                VALUES (:widget_key, :widget_type, :company_id, :site_id, :widget_string)";
        $widget_obj_string = base64_encode(serialize($widget_obj));

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_type', $widget_obj->widget_type, PDO::PARAM_STR);
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->bindParam(':site_id', $widget_obj->site_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->execute();

        /*
        $last_insert_id = $this->dbh->lastInsertId();
        return $last_insert_id;
        */
    }

    public function update_widget_by_id($widget_key, $widget_obj) {
        $widget_obj_string = base64_encode(serialize($widget_obj));
        $sql = "UPDATE WidgetStore
                    SET widgetObjString = :widget_string  
                WHERE 1=1
                    AND widgetKey = :widget_key";
        
        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->execute();
    }

    public function fetch_widget_by_id($widget_key) {     
        $query = DB::Table('WidgetStore')->where('widgetKey', '=', $widget_key)->first();
        return $query;
    }

    public function fetch_widgets_by_company() {
        $widgets = new StdClass;
        $widgets->display_widgets = $this->_fetch_widgets_by('display');
        $widgets->form_widgets = $this->_fetch_widgets_by('submit');
        return $widgets;
    }

    public function _fetch_widgets_by($widget_type) { 
        $sql = "
            SELECT 
                widgetStoreId
              , widgetKey
              , companyId
              , siteId
              , widgetObjString
            FROM 
                WidgetStore
            WHERE 1=1
                AND companyId = :company_id
                AND widgetType = :widget_type
            ORDER BY widgetStoreId DESC
            LIMIT 3
        ";

        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_type', $widget_type, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $data = Array();
        foreach ($result as $rows) {
            $obj = base64_decode($rows->widgetobjstring);
            $obj = unserialize($obj); 
            $rows->widget_obj = $obj;
            $data[] = $rows; 
        }
        
        return $data;
    }
}
