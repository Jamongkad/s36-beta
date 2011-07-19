<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() use ($user, $view) {
        $view->contents = View::make('dashboard/index');
        return $view;
    }),
);
