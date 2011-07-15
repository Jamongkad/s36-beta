<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(

    'GET /inbox' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function() use ($user, $view) {
        $feedback = new Feedback;
        $user_id = $user->user()->userid;
        
        $view->contents = View::make('inbox/index');
        $view->contents->feedback = $feedback->pull_feedback($user_id, 10);
        return $view;
    }),
);
