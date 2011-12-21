<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        print_r(Config::get('application.url'));
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),
);
