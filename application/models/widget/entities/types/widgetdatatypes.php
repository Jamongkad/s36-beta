<?php namespace Widget\Entities\Types;

use Widget\Repositories\DBWidget;

abstract class WidgetDataTypes {

    private $_data, $_dbw, $_id, $_widgetkey;

    public function __construct($data) {
        $this->_data = $data;     
        $this->_dbw = new DBWidget;
    }

    public function save() { 
        $insert_id = $this->_dbw->save_widget($this->_data);
        $this->_dbw->insert_ancestor($insert_id, $insert_id);
        $this->_id = $insert_id; 
    }

    public function update() {
        $this->_dbw->update_widget_by_id($this->_data->widgetkey, $this->_data);
        $obj = $this->_dbw->fetch_widget_by_id($this->_data->widgetkey);
        $this->_id = $obj->widgetstoreid;
    }

    public function delete() {
        $this->_dbw->delete_widget($this->_data->widgetkey);
    }

    public function adopt(WidgetDataTypes $child) { 
        //add this child set path length to one
        $this->_dbw->insert_ancestor($this->_id, $child->get_widget_id(), 1);
    }

    public function get_widget_id() {
        return $this->_id;     
    }

    public function emit() { 
        $obj = $this->_dbw->fetch_widget_by_id($this->_id, $data_return='widgetstoreid');
        return Array('widget_type' => 'display', 'widget' => $obj);
    }

}
