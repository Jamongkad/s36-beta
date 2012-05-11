<?php namespace Company\Services;

use Input, Exception, Helpers, StdClass;
use Company\Repositories\DBCompany;

class CompanySettings {
    
    private $files;

    public function upload_companylogo($files)  {
        $this->files = $files; 
    }
}
