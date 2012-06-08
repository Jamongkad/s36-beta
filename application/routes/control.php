<?php

return array(
    'GET /control/create_new_account' => function() {
        $db = new DBAccount;
        $db->create_account();
    },

    'GET /control/regenerate_encrypt' => function() {
         
    },

    'GET /control/update_user_pwd' => function() {
        $encrypt = new Encryption\Encryption;

        $emails = Array('charlesandkeith@gmail.com');
        $password_string = 'charlesandkeith668';

        foreach($emails as $email) { 
            $password = crypt($password_string);
            $affected = DB::table("User", "master")->where('email', '=', $email)
                                                   ->update(Array(
                                                      'password' => $password
                                                    , 'encryptString' => $encrypt->encrypt($email."|".$password_string)
                                                   ));
        }
        return $affected;
    },

    'GET /control/update_bulk_user_pwd/(\d+)' => function($user_id) { 
        $encrypt = new Encryption\Encryption;
        $user = DB::table('User', 'master')->where('userId', '=', $user_id)->first();        
        $password_string = $user->username."668"; 
        $password = crypt($password_string);
        $affected = DB::table("User", "master")->where('userId', '=', $user->userid)
                                               ->update(Array(
                                                  'password' => $password
                                                , 'encryptString' => $encrypt->encrypt($user->email."|".$password_string)
                                               ));
        return $affected;
    },

    'GET /control/insert_new_user/(\d+)' => function($companyId) {
        $encrypt = new Crypter;
        $password_string = "bimshop668";
        $password = crypt($password_string);
        $email = "stevensze@bimshop.com.sg";
        
        $opts = Array(
            'companyId' => $companyId
          , 'username' => 'steven'
          , 'account_owner' => 1
          , 'password' => $password
          , 'email'  => $email
          , 'encryptString' => $encrypt->encrypt($email."|".$password_string)
          , 'fullName' => "Steven Sze"
          , 'title' => 'CEO'
          , 'imId' => 1
        );

        $user_id = DB::Table('User', 'master')->insert_get_id($opts);
        DB::Table('AuthAssignment', 'master')->insert(Array('itemname' => 'Admin', 'userId' => $user_id));
    },

    'GET /control/fetch_user_old/(\d+)' => function($userId) {
        $encrypt = new Crypter;
       
        $user = DB::table('User', 'master')->where('userId', '=', $userId)->first();
        $string = $encrypt->decrypt($user->encryptstring);
        $string = (object)explode("|", $string);
        print_r($string);
    },

    'GET /control/fetch_user_new/(\d+)' => function($userId) {
        $encrypt = new Encryption\Encryption;

        $user = DB::table('User', 'master')->where('userId', '=', $userId)->first();
        $string = $encrypt->decrypt($user->encryptstring);
        $string = (object)explode("|", $string);
        print_r($string);
    }
);
