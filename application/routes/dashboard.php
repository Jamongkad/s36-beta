<?php

return array(
    'GET /dashboard' => Array('name' => 'dashboard', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'dashboard/index');
    }),
);
