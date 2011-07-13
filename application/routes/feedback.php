<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(
    'GET /feedback/feature/(:num)' => function($id) use($user) {
        print_r($id);
    },
);
