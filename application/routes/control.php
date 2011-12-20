<?php

return array(
    'GET /control/create_new_account' => function() {
        print_r("Creating New Account");
        $db = new DBAccount;
        Helpers::show_data($db->create_account());
    },

    'GET /control/update_user_pwd' => function() {
        $encrypt = new Crypter;
        $password_string = "p455w0rd";
        $password = crypt($password_string);

        $names = array("leica", "mathew", "budi", "ryan", "nicholas");
        //$names = array('nicholas');

        foreach($names as $name) { 
            DB::table("User", "master")->where('username', '=', $name)
                                       ->update(Array(
                                          'password' => $password
                                        , 'encryptString' => $encrypt->encrypt($name."|".$password_string)
                                       ));
        }


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
