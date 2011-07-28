<?php

$user = new S36Auth();

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() use ($user) {
        return View::make('partials/layout')->partial('contents', 'dashboard/index');
    }),
);
