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
        
    }

    public function save() {

    }

    public function update() {
    
    }

    public function delete() {
        
    }
}
