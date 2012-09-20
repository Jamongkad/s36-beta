<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;
use StdClass;

class SettingMessage {
    
    private $redis;
    private $hash_key; 
    private $company;
    private $hash_nm;

    public function __construct($msg_type) {
        $this->redis    = new redisent\Redis;  
        $this->hash_key = "msg-".Helpers::randid();
        $this->company = Config::get('application.subdomain'); 
        $this->hash_nm  = $this->company.':settings:'.$msg_type;
    }

    public function save_message($msg) { 
        $this->redis->hset($this->hash_nm, $this->hash_key, $msg);
    }

    public function get_messages() { 
        $collection = Array();
        foreach($this->redis->hkeys($this->hash_nm) as $val) {
            $final_data = new StdClass;
            $final_data->text = $this->redis->hget($this->hash_nm, $val);
            $final_data->id   = $val;
            $collection[] = $final_data;
        }

        return json_encode($collection);
    }

    public function last_insert() { 
        $final_data = Array();
        $final_data['text'] = $redis->hget($this->hash_nm, $this->hash_key);
        $final_data['id'] = $this->hash_key;

        return json_encode($final_data);
    }
}
