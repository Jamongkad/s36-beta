<?php namespace Message\Services;

use Exception;

class SettingMessage {

    private $datastore;
    
    public function __construct($datastore) {

        if(!$datastore) {
            throw new Exception('Message Type is required!');
        }

        $this->datastore = $datastore;
    }

    public function get_messages() { 
        $this->datastore->get_messages();
    }

    public function save($msg) { 
        $this->datastore->save($msg);
    }

    public function delete($msgid) {   
        $this->datastore->delete($msgid);
    }

    public function update($msgid, $msg) {  
        $this->datastore->update($msgid, $msg);
    }

    public function get($msgid) { 
        $this->datastore->get($msgid);
    }

    public function last_insert() {  
        $this->datastore->last_insert();
    }

    public function jsonify() {
        return $this->datastore->jsonify();
    }

    public function dbresult() {
        return $this->datastore->dbresult();
    }
}
