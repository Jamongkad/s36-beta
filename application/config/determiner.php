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
       $subdomain = (isset($_GET['subdomain'])) ? $_GET['subdomain'] : $this->http_subdomain();
           
       $obj->hostname = $my_url[1];
       $obj->subdomain = $subdomain;
       $obj->host = 'https://'.$subdomain.'.gearfish.com';
       $obj->deploy_env = 'https://'.$subdomain.'.gearfish.com';

       //Staging || Development
       if($this->http_host == 'mathew-dev.gearfish.com') {      
           $obj->hostname = $my_url[1];
           $obj->subdomain = $subdomain;
           $obj->host = 'http://'.$subdomain.'.gearfish.com';
           $obj->deploy_env = 'http://'.$subdomain.'.gearfish.com';

           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
             , 'db' => 's36_mathew'
           );

           $obj->env_name = 'dev';
           $obj->fb_id = '238865422903471';
           $obj->fb_secret = '8d466d68dd088e4b7425f295fcf9d194';
           return $obj;
       }

       if($this->http_host == 'mathew-staging.gearfish.com') {      
           $obj->db   = Array(
               'host' => '173.255.254.8'//'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
             , 'db' => 's36'//'s36_mathew'
           );

           $obj->env_name = 'dev';
           $obj->fb_id = '238865422903471';
           $obj->fb_secret = '8d466d68dd088e4b7425f295fcf9d194';
           return $obj;
       }
       
       if($this->http_host == 'dan-staging.gearfish.com') { 
           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
             , 'db' => 's36'
           );
           $obj->env_name = 'dev';
           $obj->fb_id = '171323469605899';
           $obj->fb_secret = 'b60766ccb12c32c92029a773f7716be8';
           return $obj;
       }

       if($this->http_host == 'robert-staging.gearfish.com') { 
           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
             , 'db' => 's36_robert'
           );
           $obj->env_name = 'dev';
           $obj->fb_id = '201862876610477';
           $obj->fb_secret = 'abb9a2a6b21385ed820beaac8f332d9a';
           return $obj;
       }

       if($my_url[1] == 'gearfish') {
           $obj->db   = Array(
               'host' => 'localhost'
             , 'username' => 'root'
             , 'password' => 'brx4*svv'
             , 'db' => 's36'
           );
           $obj->deploy_env = 'https://dev.gearfish.com';
           $obj->env_name = 'dev';
           $obj->fb_id = '171323469605899';
           $obj->fb_secret = 'b60766ccb12c32c92029a773f7716be8';
           return $obj;
       }
     
       //Production
       if($my_url[1] == '36storiesapp') {
           $obj->host = 'https://'.$subdomain.'.36storiesapp.com';
           $obj->db   = Array(
                'host' => 'localhost'
              , 'username' => 'root'
              , 'password' => 'brx4*svv'
              , 'db' => 's36'
           );

           $obj->deploy_env = 'https://feedback.36storiesapp.com';
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
        $parsed_url = parse_url($this->http_host);
        $host = explode('.', $parsed_url['path']);
        return $host[0];
   }
}
