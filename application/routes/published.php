<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /published' => Array('name' => 'inbox', 'before' => 's36_auth', 'do' => function() use ($user, $view) {
        $view->contents = View::make('published/index');
        return $view;
    })
);
