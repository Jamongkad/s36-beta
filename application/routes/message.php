<?php

use Message\Services;

return array(
    'POST /message/save_msg' => function() {
        /*
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->save(Input::get('msg'));
        $sm->last_insert();
        echo $sm->jsonify();
        */
        Helpers::dump(Input::get());
    },

    'POST /message/update_reply_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->update(Input::get('id'), Input::get('msg'));
        $sm->get(Input::get('id'));
        echo $sm->jsonify();
    },

    'GET /message/get_msgs' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->get_messages();
        echo $sm->jsonify();
    },

    'POST /message/delete_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->delete(Input::get('id'));
    }
);
