<?php

class UserInfo {

    private $browser;

    public function __construct() {
        $this->browser = new Browser;
    }

    public function browser() {
        return $this->browser;
    }    

    public function get_ip_long() {
        return sprintf('%u', ip2long($this->get_real_ip_addr()));
    }

    public function get_ip_from_long($long) {
        return long2ip($long);
    }

    public function get_real_ip_addr() { 
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
}
