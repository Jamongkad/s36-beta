<?php

class Determiner {

   public $http_host;

   public function __construct() {
       $this->http_host = $_SERVER['SERVER_NAME'];
       $this->d = $this->_host();
   }

   public function _host() {

       $obj = new StdClass; 

       if($this->http_host == 'dev.36stories.localhost') {
           $obj->host =  'http://dev.36stories.localhost';    
           $obj->db   = 'localhost';
           return $obj;
       }
       
       //DEV
       if($this->http_host == 'gearfish.com') {
           $obj->host = 'http://gearfish.com/s36-beta/public';     
           $obj->db   = 'localhost';
           return $obj;
       }
      
       //STAGING
       if($this->http_host == 'ec2-50-18-107-194.us-west-1.compute.amazonaws.com') {
           $obj->host = 'http://ec2-50-18-107-194.us-west-1.compute.amazonaws.com/s36-beta/public';
           $obj->db   = 'stagedb.c7lrkmoeb1l2.us-west-1.rds.amazonaws.com';
       }
       //PRODUCTION
       $pattern = '#([a-z]+\.|https?:\/\/){1}[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}(\S*)#i';
       preg_match_all($pattern, $this->http_host, $matches, PREG_PATTERN_ORDER);  
       if($matches[0]) {
           $obj->host = 'http://app.36stories.com';
           $obj->db   = 'prod-db1.c7lrkmoeb1l2.us-west-1.rds.amazonaws.com';
       }

   }

}
