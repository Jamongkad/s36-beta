<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;
use StdClass;

class SettingMessage {
    
    private $redis;
    private $hash_key; 
    private $company;
    private $msg_type;
    private $hash_nm;

    public function __construct($msg_type) {
        $this->redis    = new redisent\Redis; 
        $this->company  = Config::get('application.subdomain');
        $this->hash_key = "msg-".Helpers::randid();
        $this->msg_type = $msg_type;
        $this->hash_nm  = $this->company.':settings:'.$this->msg_type;
    }

    public function get_messages() { 
        $collection = Array();
        foreach($this->redis->hkeys($this->hash_nm) as $val) {
            $final_data = new StdClass;
            $final_data->text = $this->redis->hget($this->hash_nm, $val);
            $final_data->id   = $val;
            $collection[] = $final_data;
        }

        echo json_encode($collection);
    }
}
