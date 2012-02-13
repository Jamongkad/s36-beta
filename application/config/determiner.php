<?php

class Determiner {

   public $http_host;

   public function __construct() {
       $this->http_host = $_SERVER['SERVER_NAME'];
       $this->d = $this->_host();
   }

   public function _host() {

       $obj = new StdClass; 
       $my_url = explode(".", $this->http_host);
       $subdomain = $_GET['subdomain'];

       if($my_url[1] == 'gearfish') {
           $obj->host = 'http://'.$subdomain.'.gearfish.com';
           $obj->db   = 'localhost';
           $obj->deploy_env = 'http://dev.gearfish.com';
           $obj->env_name = 'dev';
           return $obj;
       }

       if($my_url[1] == '36stories' && $my_url[2] == 'localhost') {
           $obj->host = 'http://'.$subdomain.'.36stories.localhost';
           $obj->db   = 'localhost';
           $obj->deploy_env = 'http://'.$subdomain.'.36stories.localhost';//'http://dev.gearfish.com';
           $obj->env_name = 'local';
           return $obj;
       }

       if($my_url[1] == '36storiesapp') {
           $obj->host = 'http://'.$subdomain.'.36storiesapp.com';
           $obj->db   = 'localhost';
           $obj->deploy_env = 'http://1.36storiesapp.com';
           $obj->env_name = 'prod';
           return $obj;
       }

       //AWS PRODUCTION
       /*
       $pattern = '#([a-z]+\.|https?:\/\/){1}[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}(\S*)#i';
       preg_match_all($pattern, $this->http_host, $matches, PREG_PATTERN_ORDER);  
       if($matches[0]) {
           $obj->host = 'http://app.36stories.com';
           $obj->db   = 'prod-db1.c7lrkmoeb1l2.us-west-1.rds.amazonaws.com';
           return $obj;
       }
       */ 
   }

}
