<?php

class PermissionFactory {
    
    private $input = Array();

    protected $fill_all = Array('approve' => 0, 'delete' => 0, 'fastforward' => 0, 'flag' => 0);
    protected $fill_one = Array('approve' => 0);


    public function __construct(Array $input) {
        if(array_key_exists('perms', $input)) {
            $this->input = $input['perms'];                   
        }
    }

    public function build() {

        $this->_fill_emptiness();
        $result = Array();
        $result_array = Array();

        foreach($this->input as $key => $perms) { 
            if($key == 'inbox') {
                $inbox = new InboxPermission($perms, $this->fill_all);
                $result[$key] = $inbox->expose_rules();
            }
        
            if($key == 'feature') {
                $feature = new FeaturePermission($perms, $this->fill_all);
                $result[$key] = $feature->expose_rules();
            }
            
            if($key == 'feedsetup') {
                $feedsetup = new FeedsetupPermission($perms, $this->fill_one);
                $result[$key] = $feedsetup->expose_rules();
            }

            if($key == 'contact') {
                $contact = new ContactPermission($perms, $this->fill_one);
                $result[$key] = $contact->expose_rules();
            }

            if($key == 'setting') {
                $setting = new SettingPermission($perms, $this->fill_one);
                $result[$key] = $setting->expose_rules();
            }
       
        }

        foreach($result as $key => $value) {
            foreach($value as $k => $v) {
                $result_array[$key."_".$k] = $v;     
            }
           
        }

        return $result_array;
    }

    private function _fill_emptiness() { 
        if(!array_key_exists('inbox', $this->input)) {
            $this->input['inbox'] = $this->fill_all; 
        }

        if(!array_key_exists('feature', $this->input)) {
            $this->input['feature'] = $this->fill_all; 
        }

        if(!array_key_exists('feedsetup', $this->input)) {
            $this->input['feedsetup'] = $this->fill_one; 
        }

        if(!array_key_exists('contact', $this->input)) {
            $this->input['contact'] = $this->fill_one; 
        }

        if(!array_key_exists('setting', $this->input)) {
            $this->input['setting'] = $this->fill_one; 
        }
    }
    
}

abstract class PermissionType {
    private $permission_keys = Array();
    private $perms = Array();

    public function __construct(Array $perms, Array $permission_keys) {
        $this->perms = $perms;     
        $this->permission_keys = $permission_keys;
    }

    public function expose_rules() {
        foreach($this->permission_keys as $key_rule => $key_value) { 
            if(!array_key_exists($key_rule, $this->perms)) {
                $this->perms[$key_rule] = 0;
            }
        }

        return $this->perms; 
    }
}

class InboxPermission extends PermissionType {}

class FeaturePermission extends PermissionType {}

class FeedsetupPermission extends PermissionType {}

class ContactPermission extends PermissionType {}

class SettingPermission extends PermissionType {}
