<?php
    
    namespace Hosted\Repositories;
    use DB, Config;
    
    class DBFullpageBackground{
        
        private $company_name;
        private $query_field;
        private $query_value;
        private $uploaded_background_dir;
        private $pattern_dir;
        
        function __construct($query_value){
            
            if( is_int($query_value) ) $this->query_field = 'Company.companyId';
            if( is_string($query_value) ) $this->query_field = 'Company.name';
            
            $this->query_value = $query_value;
            
            $this->uploaded_background_dir = Config::get('application.hosted_background');
            $this->pattern_dir = Config::get('application.fullpage_pattern_dir');
            
        }
        
        function get_data(){
            
            $data = DB::table('Company')
                    ->join('HostedSettings', 'Company.companyId', '=', 'HostedSettings.companyId')
                    ->where($this->query_field, '=', $this->query_value)
                    ->first(array(
                        'active_background', 
                        'background_image',
                        'background_pattern',
                        'page_bg_position',
                        'page_bg_repeat',
                        'page_bg_color',
                        'page_bg_color_opacity'
                    ));
                    
            $data->page_bg_image = null;
            if($data->active_background == 'image') $data->page_bg_image = $this->uploaded_background_dir . '/' . $data->background_image;
            if($data->active_background == 'pattern') $data->page_bg_image = '/' . $this->pattern_dir . '/' . $data->background_pattern;
            // that extra / before $this->pattern_dir on the above line is intended.
            // $this->uploaded_background_dir starts with /, $this->pattern_dir does not
            // therefore causing bg url problem in single page.
            
            return $data;
            
        }
        
    }
?>