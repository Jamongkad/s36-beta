<?php
    
    namespace Feedback\Entities;
    use Helpers;
    
    class FeedbackActionsData{
        
        public $data;
        
        public function __construct($action, $input){
            
            $common_data['ip_address'] = Helpers::get_client_ip();
            $common_data['feedbackId'] = $input->feedbackId;
            
            $action_data['flag'] = $common_data;
            $action_data['flag']['flagged'] = 1;
            
            $action_data['unflag'] = $common_data;
            $action_data['unflag']['flagged'] = null;
            
            $action_data['vote'] = $common_data;
            $action_data['vote']['useful'] = 1;
            
            $action_data['unvote'] = $common_data;
            $action_data['unvote']['useful'] = null;
            
            if( ! array_key_exists($action, $action_data) ) return;
            
            $this->data = (object) $action_data[$action];
            
        }
        
    }
    
?>