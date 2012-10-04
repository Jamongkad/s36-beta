<?php

use Message\Services;

return array(
    'POST /message/save_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->save(Input::get('msg'));
        $sm->last_insert();
        echo $sm->jsonify();
    }

    , 'POST /message/update_reply_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->update(Input::get('id'), Input::get('msg'));
        $sm->get(Input::get('id'));
        echo $sm->jsonify();
    }

    , 'GET /message/get_msgs' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->get_messages();
        Helpers::dump($sm);
        //echo $sm->jsonify();
    }

    , 'POST /message/delete_msg' => function() {
        $sm = new Message\Services\SettingMessage(Input::get('type'));       
        $sm->delete(Input::get('id'));
    }

    , 'GET /message/reply_view/(:any)' => function($feedid) {

        $sm = new Message\Services\SettingMessage('msg');       
        $sm->get_messages();
        $reply_message = json_decode($sm->jsonify());
        $admin_check = S36Auth::user();

        $fb = new Feedback\Repositories\DBFeedback;
        $feed = $fb->pull_feedback_by_id($feedid);
 
        $str = '';
        $str .= Form::open('feedback/reply_to', 'POST', array('class' => 'reply-form', 'ng-controller' => 'ReplyCtrl'));
        $str .= View::make('feedback/reply_to_view', array(
            'user' => $admin_check, 'feedback'=> $feed, 'reply_message' => $reply_message
        ));
        $str .= Form::close();
        echo $str;
    }
);
