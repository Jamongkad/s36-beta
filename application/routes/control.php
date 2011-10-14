<?php

return array(
    'GET /control/update_user_pwd' => function() {
        $encrypt = new Crypter;
        $password_string = "p455w0rd";
        $password = crypt($password_string);

        return DB::table("User", "master")->where('username', '=', 'budi')
                                          ->update(Array(
                                              'password' => $password
                                            , 'encryptString' => $encrypt->encrypt("wrm932@gmail.com"."|".$password_string)
                                          ));

    },

    'GET /control/insert_new_user/(\d+)' => function($companyId) {
        $encrypt = new Crypter;
        $password_string = "p455w0rd";
        $password = crypt($password_string);
        $email = "leicaaah18@gmail.com";
        
        $opts = Array(
            'companyId' => $companyId
          , 'username' => 'leica'
          , 'password' => $password
          , 'email'  => $email
          , 'encryptString' => $encrypt->encrypt($email."|".$password_string)
          , 'fullName' => "Leica Chang"
          , 'title' => 'Community Manager'
          , 'imId' => 4

        );
        DB::Table('User', 'master')->insert($opts);
    },

    'GET /control/fetch_user/(\d+)' => function($userId) {
        $encrypt = new Crypter;
        $user = DB::table('User', 'master')->where('userId', '=', $userId)->first();
        $string = $encrypt->decrypt($user->encryptstring);
        $string = (object)explode("|", $string);
        print_r($string);
    }
);
