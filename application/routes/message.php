<?php

use Message\Services;

return array(
    'POST /message/save_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->save_message(Input::get('msg'));
        $sm->last_insert();
        echo $sm->jsonify();
    },

    'POST /message/update_reply_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->update_message(Input::get('id'), Input::get('msg'));
    },

    'GET /message/get_msgs' => function() {
        $redis = new redisent\Redis;
        $key = Config::get('application.subdomain').":settings:msg";
        $data = $redis->hgetall($key);

        $collection = Array();
        foreach($redis->hkeys($key) as $val) {
            $final_data = Array();
            $final_data['text'] = $redis->hget($key, $val);
            $final_data['id'] = $val;
            $collection[] = $final_data;
        }

        echo json_encode($collection);
    },

    'GET /message/delete_msg/(:any)' => function($id) {
        $redis = new redisent\Redis;
        $key = Config::get('application.subdomain').":settings:msg";
        $redis->hdel($key, $id); 
    }
);
