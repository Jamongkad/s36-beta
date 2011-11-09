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
        $user = S36Auth::user();
        return View::of_layout()->partial('contents', 'admin/add_admin_view', Array(
            'ims' => DB::Table('IM', 'master')->get()
          , 'errors' => Array()
          , 'input' => Array('username' => null, 'fullName' => null, 'email' => null, 'password' => null, 'title' => null)
          , 'admin' => $user
        ));
    }),

    'POST /admin/add_admin' => function() {
        $data = Input::get();
        $user = S36Auth::user();

        $perm_factory = new Permission($data);
        $perms = $perm_factory->build();

        $rules = Array(
            'username' => 'required'
          , 'fullName' => 'required'
          , 'email' => 'required|email|unique:User,email'
          , 'password' => 'required|min:8|confirmed'
          , 'title' => 'required'
        );

        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            Helpers::show_data($validator->errors);

            return View::of_layout()->partial('contents', 'admin/add_admin_view', Array(
                'ims' => DB::Table('IM', 'master')->get()
              , 'errors' => $validator->errors
              , 'input' => $data
              , 'admin' => $user
            ));

        }     
        
        $admin = new Admin;
        $admin->input_data = (object)$data;
        $admin->perms_data = $perms;
        return $admin->save();

    },

    'GET /admin/edit_admin/([0-9]+)' => Array('name' => 'edit_admin', 'before' => 's36_auth', 'do' => function($id) {
        print_r($id);
    }),

);
