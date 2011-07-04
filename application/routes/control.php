<?php

return array(
    'GET /control/update_user_pwd' => function() {

        $password = crypt("p455w0rd");
        return DB::table("User", "master")->where('username', '=', 'ryan')
                                          ->update(Array('password' => $password));

    },
);
