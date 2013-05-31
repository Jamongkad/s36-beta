<?php
    
    namespace Hosted\Repositories;
    use DB;
    
    class DBFullpageCover{
        
        private $company_name;
        
        function __construct($company_name){
            
            $this->company_name = $company_name;
            
        }
        
        function get_data(){
            
            return DB::table('Company')
                    ->join('HostedSettings', 'Company.companyId', '=', 'HostedSettings.companyId')
                    ->where('name', '=', $this->company_name)
                    ->first();
            
        }
    
        
    }
    
?>