<?php

return array(
    'GET /admin' => Array('name' => 'admin', 'before' => 's36_auth', 'do' => function() {
        $admin = S36Auth::user();
        $company_id = $admin->companyid;
        $role = $admin->itemname;

        $admins = DB::Table('User', 'master')
                      ->join('AuthAssignment', 'AuthAssignment.userId', '=', 'User.userId')
                      ->where('User.companyId', '=', $company_id)->get();

        return View::of_layout()->partial('contents', 'admin/admin_index_view', Array('admins' => $admins, 'user_id' => $admin->userid, 'role' => $role));
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
          , 'email' => 'required|email|s36email'
          , 'password' => 'required|min:8|confirmed'
          , 'title' => 'required'
        );

        $validator = Validator::make($data, $rules, Array('s36email' => 'This email is already taken.'));
        
        if(!$validator->valid()) {
            return View::of_layout()->partial('contents', 'admin/add_admin_view', Array(
                'ims' => DB::Table('IM', 'master')->get() , 'errors' => $validator->errors
              , 'input' => $data, 'admin' => $user
            ));
        }     

        $admin = new Admin;
        $admin->input_data = (object)$data;
        $admin->perms_data = $perms;
        return $admin->save();
    },

    'GET /admin/edit_admin/([0-9]+)' => Array('name' => 'edit_admin', 'before' => 's36_auth', 'do' => function($id) {
        $user = S36Auth::user();
        $admin = new Admin;
        $details = $admin->fetch_admin_details_by_id($id);
        
        return View::of_layout()->partial('contents', 'admin/edit_admin_view', Array(
            'admin_details' => $details, 'ims' => DB::Table('IM', 'master')->get()
          , 'errors' => Array(), 'admin' => $user
        ));
     }),

     'POST /admin/edit_admin' => function() {
         $user = S36Auth::user(); 
         $data = Input::get();
         $admin = new Admin;

         $details = $admin->fetch_admin_details_by_id($data['userId']);

         $perm_factory = new Permission($data);
         $perms = $perm_factory->build();

         $rules = Array(
             'username' => 'required'
           , 'fullName' => 'required'
           , 'email' => 'required|email'
           , 'password' => 'min:8|confirmed'
           , 'title' => 'required'
         );

         $validator = Validator::make($data, $rules);
         if(!$validator->valid()) {
             return View::of_layout()->partial('contents', 'admin/edit_admin_view', Array(
                'admin_details' => $details, 'ims' => DB::Table('IM', 'master')->get()
              , 'errors' => $validator->errors, 'admin' => $user
             ));
         }     

         $admin->perms_data = $perms;
         $admin->input_data = (object)$data; 
         return $admin->update($user); 
     },

     'POST /admin/delete_existing_avatar' => function() {
         $data = Input::get(); 
         $avatar = $data['avatar'];
         $profile_img = new Widget\ProfileImage();
         $profile_img->remove_profile_photo($avatar);
     },

     'POST /admin/test_invite_email' => Array('needs' => 'S36ValueObjects', 'do' => function() {
         //once done switch to form open url in add_admin_view
         $data = Input::get(); 
         $admin = new Admin;
         $admin->input_data = (object)$data;
         return $admin->_send_welcome_email();
     })
);
