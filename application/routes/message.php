<?php

return array(

    'GET /message/get_msgs' => function() {
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);
        //$rdm = new Message\Repositories\RDMessage($type);       
        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->get_messages();
        echo $sm->jsonify();
    }

    , 'POST /message/save_msg' => function() {
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);
        //$rdm = new Message\Repositories\RDMessage($type);       
        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->save(Input::get('msg'));
        $sm->last_insert();
        echo $sm->jsonify();
    }

    , 'POST /message/update_reply_msg' => function() {
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);
        //$rdm = new Message\Repositories\RDMessage($type);       
        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->update(Input::get('id'), Input::get('msg'));
        $sm->get(Input::get('id'));
        echo $sm->jsonify();
    }

    , 'POST /message/delete_msg' => function() {
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);
        //$rdm = new Message\Repositories\RDMessage($type);       
        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->delete(Input::get('id'));
    }
);
