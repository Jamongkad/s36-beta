<?php

class DBWidget extends S36DataObject {    

    public function push_widget_db($data) {

        $data_object = (object)$data;

        if(!$widgetkey = $data['widgetkey']) {
            //save widget 
            $save_result = $this->save_widget( $data_object );         
            echo json_encode( $save_result ); 
            //echo json_encode(Array('status' => 'save'));
        } else {
            //update widget      
            $update_result = $this->update_widget_by_id( $widgetkey, $data_object );
            echo json_encode( $update_result );   
            //echo json_encode(Array('status' => 'update'));
        } 
    }

    public function delete_widget($widget_id) {
        $sql = "DELETE FROM WidgetStore WHERE widgetStoreId = :widget_store_id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':widget_store_id', $widget_id, PDO::PARAM_STR);
        $sth->execute();
    }

    public function save_widget($widget_obj) {

        $widget_key = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);

        $sql = "INSERT INTO WidgetStore (widgetKey, widgetType, companyId, siteId, widgetObjString) 
                VALUES (:widget_key, :widget_type, :company_id, :site_id, :widget_string)";
        $widget_obj_string = base64_encode(serialize($widget_obj));

        //$this->dbh->beginTransaction();

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_type', $widget_obj->widget_type, PDO::PARAM_STR);
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->bindParam(':site_id', $widget_obj->site_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->execute();

        $last_insert_id = $this->dbh->lastInsertId();
        $this->_insert_ancestor($last_insert_id);

        $obj = $this->fetch_widget_by_id($last_insert_id); 

        //$this->dbh->commit();

        return Array('status' => 'save', 'widget' => $obj);
    }

    public function _insert_ancestor($last_insert_id) { 
        $closure_sql = "INSERT INTO WidgetClosure (ancestor_id, descendant_id) VALUES (:ancestor_id, :descendant_id)"; 
        $sth = $this->dbh->prepare($closure_sql);
        $sth->bindParam(':ancestor_id', $last_insert_id, PDO::PARAM_INT);
        $sth->bindParam(':descendant_id', $last_insert_id, PDO::PARAM_INT);
        $sth->execute();
    }

    public function update_widget_by_id($widget_key, $widget_obj) {
        $widget_obj_string = base64_encode(serialize($widget_obj));
        $sql = "UPDATE WidgetStore
                    SET widgetObjString = :widget_string, siteId = :site_id
                WHERE 1=1
                    AND widgetKey = :widget_key";
        
        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->bindParam(':site_id', $widget_obj->site_id, PDO::PARAM_STR);
        $sth->execute();
        return Array('status' => 'update', 'widget' => $widget_obj);
    }

    public function fetch_widget_by_id($widget_key) {     
        $sql = "
            SELECT 
                  WidgetStore.widgetStoreId
                , WidgetStore.widgetKey
                , WidgetStore.widgetObjString
                , WidgetClosure.path_length
            FROM 
                WidgetStore
            INNER JOIN
                WidgetClosure
                    ON WidgetStore.widgetStoreId = WidgetClosure.descendant_id
            WHERE 1=1
                AND WidgetClosure.ancestor_id = (
                    SELECT 
                        WidgetStoreId
                    FROM
                        WidgetStore
                    WHERE 
                        WidgetStore.widgetKey = :widget_key
                )
            ORDER BY
                WidgetStore.widgetStoreId DESC
        ";
 
        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->execute();
        
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
 
        $child = Array();
        foreach($result as $rows) {
            if ( $rows->path_length == 0 ) { 
                $node = $this->_load_object_code($rows->widgetobjstring);
                $node->widgetstoreid = $rows->widgetstoreid; 
            } else {
                $my_kid = $this->_load_object_code($rows->widgetobjstring);
                $my_kid->widgetstoreid = $rows->widgetstoreid;
                $child[] = $my_kid; 
            }

            $node->children = null;
            if ($child) {
                $node->children = $child;
            }
                
        }

        return $node;
 
        /*
        $query = DB::Table('WidgetStore') 
                     ->where('widgetKey', '=', $widget_key)
                     ->or_where('widgetStoreId', '=', $widget_key)
                     ->first();

        $obj = base64_decode($query->widgetobjstring);
        $obj = unserialize($obj); 
        $query->widgetobj = $obj; 

        //remove this shit....
        if($obj->embed_type == 'embedded') {
            if($obj->embed_block_type == 'embed_block_x') {
                $query->width = 780; 
                $query->height = 320;
            }

            if($obj->embed_block_type == 'embed_block_y') {
                $query->width = 250; 
                $query->height = 500; 
            }
        }

        if($obj->embed_type == 'modal') {
            $query->width = 760; 
            $query->height = 500;  
        }

        if($obj->embed_type == 'form') { 
            $query->width = 447; 
            $query->height = 590;  
        }

        return $query;
        */
    }

    public function fetch_widgets_by_company() {
        $widgets = new StdClass;
        $widgets->display_widgets = $this->fetch_paginated_widgets('display');
        $widgets->form_widgets = $this->fetch_paginated_widgets('submit');
        return $widgets;
    }

    public function fetch_widgets_by($widget_type, $limit=3, $offset=0) { 
        $sql = " 
            SELECT 
            SQL_CALC_FOUND_ROWS
                WidgetStore.widgetStoreId
                , WidgetStore.widgetKey
                , WidgetStore.companyId
                , WidgetStore.siteId
                , WidgetStore.widgetObjString
            FROM 
                WidgetStore
            INNER JOIN
                WidgetClosure
                    ON WidgetStore.widgetStoreId = WidgetClosure.descendant_id
            WHERE 1=1
                AND companyId = :company_id
                AND widgetType = :widget_type
            GROUP BY 
                WidgetStore.widgetStoreId
            HAVING 
                NOT COUNT(*) > 1
            ORDER BY 
                WidgetStore.widgetStoreId DESC 
            LIMIT :offset, :limit 
        ";

        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_type', $widget_type, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $data = Array();
        foreach ($result as $rows) {
            $obj = base64_decode($rows->widgetobjstring);
            $obj = unserialize($obj); 
            $rows->widget_obj = $obj;
            $data[] = $rows; 
        }

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $row_count = $row_count->fetchColumn();
        
        $data_holder = new StdClass;
        $data_holder->widgets = $data;
        $data_holder->total_rows = $row_count;
        return $data_holder;
    }

    public function fetch_paginated_widgets($type, $limit=5) {

        $pagination = new ZebraPagination;  
        $pagination->method('url');
        $pagination->base_url('/feedsetup/ajax_overview/'.$type);
        $pagination->selectable_pages(5);

        $offset = ($pagination->get_page() - 1) * $limit;

        $widgets = $this->fetch_widgets_by($type, $limit, $offset);

        $pagination->records($widgets->total_rows);
        $pagination->records_per_page($limit);

        $result = new stdClass;
        $result->widget = $widgets;
        $result->pagination = $pagination->render();

        return $result; 
    }

    private function _load_object_code($widget_obj_string) {      
        $obj = base64_decode($widget_obj_string);
        $obj = unserialize($obj); 
        return $obj;
    }
}
