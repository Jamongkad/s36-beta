<?php

class Permission {

    private $result_array = Array();
    
    public function __construct($input) { 
        $this->supplier = new PermissionSupplier($input);
    }

    public function expose_perms($key) {
        $this->result_array[] = $this->cherry_pick($key, true);
    }

    public function build() {
        $result = array();
        foreach($this->result_array as $pieces) {
            foreach($pieces as $key => $value) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    
    //cherry pick array in two different flavors!!
    public function cherry_pick($key, $key_type=False) {

        $data = $this->supplier->load();    
        if(array_key_exists($key, $data)) {
            if($key_type == false) {
                //return ordinary array with permissions
                return $data[$key];           
            } else {
                //return array for database insertion, keys match db columns
                $result = Array();
                foreach($data[$key] as $k => $v) {
                    $result[$key."_".$k] = $v;
                }

                return $result;
            }
           
        } 
    }

}
 
class PermissionSupplier {

    private $config_array = Array();

    public function __construct($input) {
        $this->input = $input;     

        $this->config_array = Array(
                'inbox'     => new InboxPermission()
              , 'feedsetup' => new FeedsetupPermission()
              , 'contact'   => new ContactPermission()
              , 'setting'   => new SettingPermission() 
              , 'feedbacksetupdisplay' => new FeedbackDisplayPermission()
        );
    }

    public function load() {
        return $this->_fill_emptiness();
    }

    private function _fill_emptiness() { 

        foreach ($this->config_array as $key => $object) { 
            if (!array_key_exists($key, $this->input)) {
                $this->input[$key] = $object->expose_keys();
            } else {
                $this->input[$key] = $object->expose_rules($this->input);
            }
        }

        return $this->input;

    } 
}

abstract class PermissionType {
    protected $permission_keys = Array();
    private $perms = Array();

    public function expose_keys() {
        return $this->permission_keys;     
    }
}

class InboxPermission extends PermissionType { 

    protected $permission_keys = Array('approve' => 0, 'feature' => 0, 'delete' => 0, 'fastforward' => 0, 'flag' => 0);

    public function expose_rules($perms) {

        $this->perms = $perms['inbox'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}

class FeaturePermission extends PermissionType {
    
    protected $permission_keys = Array('approve' => 0, 'delete' => 0, 'fastforward' => 0, 'flag' => 0);

    public function expose_rules($perms) {

        $this->perms = $perms['feature'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}

class FeedsetupPermission extends PermissionType {
    
    protected $permission_keys = Array('approve' => 0);

    public function expose_rules($perms) {

        $this->perms = $perms['feedsetup'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}

class ContactPermission extends PermissionType {
    
    protected $permission_keys = Array('approve' => 0);

    public function expose_rules($perms) {

        $this->perms = $perms['contact'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}

class SettingPermission extends PermissionType {
    
    protected $permission_keys = Array('approve' => 0);

    public function expose_rules($perms) {

        $this->perms = $perms['setting'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}

class FeedbackDisplayPermission extends PermissionType {
    
    protected $permission_keys = Array(  'displayname' => 0
                                       , 'displayurl' => 0
                                       , 'displayimg' => 0
                                       , 'displaycountry' => 0
                                       , 'displaycompany' => 0
                                       , 'displaysbmtdate' => 0
                                       , 'displayposition' => 0
                                    );

    public function expose_rules($perms) {

        $this->perms = $perms['feedbacksetupdisplay'];

        foreach ($this->permission_keys as $key_rule => $key_value) { 
            if (!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms;  
    }
}
