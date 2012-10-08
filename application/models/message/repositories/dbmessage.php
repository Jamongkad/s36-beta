<?php namespace Message\Repositories;

use PDO, StdClass, Exception; 
use S36DataObject\S36DataObject, Helpers, DB, Package;


Package::load('HTMLPurifier');

class DBMessage extends S36DataObject {    
    
    private $result;
    private $last_insert_result;
    private $text_limit = 3;

    public function __construct($msg_type) {
        parent::__construct();
        $this->msg_type = $msg_type;
        $config = \HTMLPurifier_Config::createDefault();
        $this->purifier = new \HTMLPurifier($config);
    }

    public function get_messages() {
        $sql = "SELECT 
                  * 
                FROM 
                    MessageSettings
                WHERE 1=1
                    AND companyId = :company_id
                    AND msgtype = :msg_type
                ORDER BY msgid ASC";

        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);       
        $sth->bindParam(':msg_type', $this->msg_type, PDO::PARAM_STR);       
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_CLASS); 
        
        $tree = Array();
        foreach($result as $value) {
            $leaf = new StdClass;
            $text = ucfirst(strtolower($value->msgtext));

            $leaf->text = $text;
            $leaf->short_text = Helpers::limit_text($text, $this->text_limit);
            $leaf->id   = $value->msgid;
            $tree[] = $leaf; 
        }

        $this->result = $tree;
    }

    public function save($msg) {

        $sql = "INSERT INTO MessageSettings (msgtype, msgtext, companyId) VALUES(:msg_type, :msg_text, :company_id)";    
        $sth = $this->dbh->prepare($sql); 
        $msg = $this->purifier->purify($msg);
        $sth->bindParam(':msg_type', $this->msg_type, PDO::PARAM_STR);       
        $sth->bindParam(':msg_text', $msg, PDO::PARAM_STR);       
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);       
        $sth->execute();

        $last_insert_id = $this->dbh->query("SELECT LAST_INSERT_ID()");
        $this->last_insert_result = $this->_get_leaf($last_insert_id->fetchColumn());
    }

    public function delete($msgid) {
        $sql = "DELETE FROM MessageSettings WHERE 1=1 AND msgid = :msgid";     
        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':msgid', $msgid, PDO::PARAM_INT);       
        $sth->execute();
    }

    public function update($msgid, $msg) {
        $sql = "UPDATE MessageSettings SET msgtext = :msg_text WHERE 1=1 AND msgid = :msgid";      
        $msg = $this->purifier->purify($msg);
        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':msgid', $msgid, PDO::PARAM_INT);       
        $sth->bindParam(':msg_text', $msg, PDO::PARAM_STR);       
        $sth->execute();
    }

    public function get($msgid) {
        $this->result = $this->_get_leaf($msgid);
    }

    public function last_insert() { 
        $this->result = $this->last_insert_result;
    }

    public function jsonify() {
        return json_encode($this->result);
    }

    public function _get_leaf($msgid) {

        $sql = "SELECT * FROM MessageSettings WHERE 1=1 AND msgid = :msgid AND companyId = :company_id";
        $sth = $this->dbh->prepare($sql); 
        $sth->bindParam(':msgid', $msgid, PDO::PARAM_INT);       
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);       
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);

        $leaf = new StdClass;
        $text = ucfirst(strtolower($result->msgtext));

        $leaf->text = $text;
        $leaf->short_text = Helpers::limit_text($text, $this->text_limit);
        $leaf->id   = $result->msgid;

        return $leaf; 
    }
}
