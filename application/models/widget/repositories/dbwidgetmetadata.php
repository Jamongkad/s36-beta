<?php namespace Widget\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBWidgetMetadata extends S36DataObject {

    private $table = 'WidgetFormMetadata';
    private $db    = 'master';

    public function __construct($widgetstore_id, $company_id, $form_structure_data) {
        parent::__construct();
        $this->widgetstore_id = $widgetstore_id;
        $this->company_id = $company_id;
        $this->form_structure_data = $form_structure_data;
    }

    public function metadata_exists() {
        return DB::table($this->table, $this->db)->where('widgetStoreId', '=', $this->widgetstore_id)->first();
    }

    public function save() {
        return DB::table($this->table, $this->db)->insert(Array(
            'widgetStoreId' => $this->widgetstore_id 
          , 'companyId'     => $this->company_id
          , 'formStructure' => $this->form_structure_data
        ));

    }

    public function update() { 
        return DB::table($this->table, $this->db)
                   ->where('widgetStoreId', '=', $this->widgetstore_id)
                   ->where('companyId', '=', $this->company_id)
                   ->update(array('formStructure' => $this->form_structure_data));
    }

    public function delete() { 
        return DB::table($this->table, $this->db)
                   ->where('widgetStoreId', '=', $this->widgetstore_id)
                   ->delete();
    }
}
