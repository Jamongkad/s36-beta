<?php

return array(

    'GET /message/get_msgs' => function() {
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);

        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->get_messages();
        echo $sm->jsonify();
    }

    , 'GET /message/get_msg' => function() { 
        if($id = Input::get('id')) { 
            $dbm = new Message\Repositories\DBMessage(Input::get('type'));
            $dbmset = new Message\Services\SettingMessage($dbm);
            $dbmset->get($id);
            echo $dbmset->jsonify();
        }
    }
   
    , 'POST /message/save_msg' => function() {

        $dbm = new Message\Repositories\DBMessage(Input::get('msgtype'));
        $sm = new Message\Services\SettingMessage($dbm);       
        if(Input::get('id')) {
            $sm->update(Input::get('id'), Input::get('text'));
            $sm->get(Input::get('id'));
        } else { 
            $sm->save(Input::get('text'));
            $sm->last_insert();
        }

        echo $sm->jsonify();
    }

    , 'POST /message/delete_msg' => function() {  
        $type = Input::get('type'); 
        $dbm = new Message\Repositories\DBMessage($type);
        $sm = new Message\Services\SettingMessage($dbm);       
        $sm->delete(Input::get('id'));
    }
);
