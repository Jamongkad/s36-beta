<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        //print_r(Config::get('application.deploy_env'));
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),
);
