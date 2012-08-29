<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config;
use Company\Repositories\DBCompany;

class CompanyHeader {
   public function __construct($company_name, $domain) {
       $this->company_name = $company_name; 
       $this->domain = $domain;
       $this->deploy_env = Config::get('application.deploy_env');
       $this->hostname = Config::get('application.hostname');
   }

   public function __toString() {
       return View::make('hosted/partials/hosted_feedback_header_view', Array(
           'company_name' => $this->company_name
         , 'hostname' => $this->hostname
         , 'deploy_env' => $this->deploy_env
         , 'domain' => $this->domain 
       ));     
   }
}
