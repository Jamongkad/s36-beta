<?php

return array(
    'GET /control/create_new_account' => function() {
        $db = new DBAccount;
        $db->create_account();
    },

    'GET /control/regenerate_encrypt' => function() {
         
    },

    'GET /control/update_user_pwd' => function() {
        //$encrypt = new Crypter;
        $encrypt = new Encryption\Encryption;

        $email = 'ryanchua6@gmail.com';
        $password_string = 'p455w0rd';

        $password = crypt($password_string);

        $affected = DB::table("User", "master")->where('email', '=', $email)
                                               ->update(Array(
                                                  'password' => $password
                                                , 'encryptString' => $encrypt->encrypt($email."|".$password_string)
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

    'GET /control/fetch_user/(\d+)' => function($userId) {
        $encrypt = new Crypter;
        //$encrypt = new Encryption\Encryption;
        $user = DB::table('User', 'master')->where('userId', '=', $userId)->first();
        $string = $encrypt->decrypt($user->encryptstring);
        $string = (object)explode("|", $string);
        print_r($string);
    }
);
