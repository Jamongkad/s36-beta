<?php
    
    namespace Feedback\Entities;
    use Helpers;
    
    class FeedbackActionsData{
        
        public $flagged = 1;
        public $useful = 1;
        public $ip_address;
        public $feedbackId;
        
        public $flag_insert_data;
        public $vote_insert_data;
        
        
        public function __construct($input){
            
            $this->flag_insert_data['feedbackId'] = $this->feedbackId = $input->feedbackId;
            $this->flag_insert_data['ip_address'] = $this->ip_address = Helpers::get_client_ip();
            
            $this->vote_insert_data = $this->flag_insert_data;
            
            $this->flag_insert_data['flagged'] = $this->flagged;
            $this->vote_insert_data['useful'] = $this->useful;
            
        }
        
    }
    
?>