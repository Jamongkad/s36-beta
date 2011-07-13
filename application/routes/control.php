<?php

return array(
    'GET /control/update_user_pwd' => function() {

        $password = crypt("password");
        return DB::table("User", "master")->where('username', '=', 'budi')
                                          ->update(Array('password' => $password));

    },
);
