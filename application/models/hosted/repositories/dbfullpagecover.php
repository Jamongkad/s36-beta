<?php
    
    namespace Hosted\Repositories;
    use DB, S36Auth;
    
    class DBFullpageCover{
        
        private $company_name;
        private $query_field;
        private $query_value;
        
        function __construct($query_value){
            
            if( is_int($query_value) ) $this->query_field = 'Company.companyId';
            if( is_string($query_value) ) $this->query_field = 'Company.name';
            
            $this->query_value = $query_value;
            
        }
        
        function get_data(){
            
            $data = DB::table('Company')
                    ->join('HostedSettings', 'Company.companyId', '=', 'HostedSettings.companyId')
                    ->where($this->query_field, '=', $this->query_value)
                    ->first(array(
                        'coverphoto_src', 
                        'coverphoto_top',
                        'facebook_url',
                        'twitter_url',
                        'logo'
                    ));
                    
            $data->user = S36Auth::user();
            
            return $data;
            
        }
    
        
    }
    
?>