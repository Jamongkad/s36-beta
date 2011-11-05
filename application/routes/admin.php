<?php

return array(
    'GET /admin' => Array('name' => 'admin', 'before' => 's36_auth', 'do' => function() {
        $company_id = S36Auth::user()->companyid;
        $admins = DB::Table('User', 'master')
                      ->join('AuthAssignment', 'AuthAssignment.userId', '=', 'User.userId')
                      ->where('User.companyId', '=', $company_id)->get();



        return View::of_layout()->partial('contents', 'admin/admin_index_view', Array(
            'admins' => $admins
        ));

    }),

    'GET /admin/add_admin' => Array('name' => 'add_admin', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'admin/add_admin_view', Array(
            'ims' => DB::Table('IM', 'master')->get()
        ));
    }),

    'POST /admin/add_admin' => function() {
       Helpers::show_data(Input::get());
    }

    'GET /admin/edit_admin/([0-9]+)' => Array('name' => 'edit_admin', 'before' => 's36_auth', 'do' => function($id) {
        print_r($id);
    }),

);
