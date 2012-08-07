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
       $subdomain = ($_GET['subdomain']) ? $_GET['subdomain'] : $this->http_subdomain();
       print_r($subdomain);
       
       //Development
       if($my_url[1] == '36storiesdev' && $my_url[2] == 'localhost') {
           $obj->hostname = '36storiesdev';
           $obj->host = 'http://'.$subdomain.'.36storiesdev.localhost';
           $obj->db   = Array(
                'host' => 'localhost'//'173.255.211.107'
              , 'username' => 'root'//'mathew'
              , 'password' => 'brx4*svv'
           );
           $obj->deploy_env = 'http://'.$subdomain.'.36storiesdev.localhost';
           $obj->env_name = 'local';
           $obj->fb_id = '171323469605899';
           $obj->fb_secret = 'b60766ccb12c32c92029a773f7716be8';
           return $obj;
       }
       
       //Staging
       if($my_url[1] == 'gearfish') {
           $obj->hostname = $my_url[1];
           $obj->host = 'https://'.$subdomain.'.gearfish.com';
           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
           );
           $obj->deploy_env = 'https://dev.gearfish.com';
           $obj->env_name = 'dev';
           $obj->fb_id = '171323469605899';
           $obj->fb_secret = 'b60766ccb12c32c92029a773f7716be8';
           return $obj;
       }
       

       if($this->host_host == 'mathew-staging.gearfish.com') {
           $obj->hostname = $my_url[1];
           $obj->host = 'https://'.$subdomain.'.gearfish.com';
           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
           );
           $obj->deploy_env = 'https://dev.gearfish.com';
           $obj->env_name = 'dev';
           $obj->fb_id = '171323469605899';
           $obj->fb_secret = 'b60766ccb12c32c92029a773f7716be8';
           return $obj;
       }
       
       //Production
       if($my_url[1] == '36storiesapp') {
           $obj->hostname = $my_url[1];
           $obj->host = 'http://'.$subdomain.'.36storiesapp.com';
           $obj->db   = Array(
                'host' => 'localhost'
              , 'username' => 'root'
              , 'password' => 'brx4*svv'
           );
           //$obj->deploy_env = 'http://1.36storiesapp.com';
           $obj->deploy_env = 'http://feedback.36storiesapp.com';
           $obj->env_name = 'prod';
           $obj->fb_id = '259670914062599';
           $obj->fb_secret   = '8e0666032461a99fb538e5f38ac7ef93';
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
  
   public function http_subdomain() {     
        //$sub = $_SERVER['HTTP_HOST'];
        $parsed_url = parse_url($this->http_host);
        $host = explode('.', $parsed_url['path']);
        return $host[0];
   }
}
