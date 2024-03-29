<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config;
use Company\Repositories\DBCompany;

class CompanyHeader {
   public function __construct($company_name, $fullpage_company_name, $domain) {
       $this->company_name = $company_name; 
       $this->fullpage_company_name = $fullpage_company_name;
       $this->domain = $domain;
       $this->deploy_env = Config::get('application.deploy_env');
       $this->hostname = Config::get('application.hostname');
       $this->sample_name = Input::get('sample_name');
   }

   public function __toString() {
       return View::make('hosted/partials/hosted_feedback_header_view', Array(
           'company_name' => $this->company_name
         , 'fullpage_company_name' => $this->fullpage_company_name
         , 'hostname' => $this->hostname
         , 'deploy_env' => $this->deploy_env
         , 'domain' => $this->domain 
         , 'sample_name' => $this->sample_name
       ))->get();     
   }
}
