<?php

return array (
    'GET /settings' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        $user = S36Auth::user();
        return View::of_layout()->partial('contents', 'settings/settings_index_view', Array(
            'user' => $user
        ));
    }),

    'POST /settings/savesettings' => function() {
        Helpers::show_data(Input::get());
    },

    'GET /settings/upgrade' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

    'GET /settings/change_card' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

    'GET /settings/cancel_account' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

);
