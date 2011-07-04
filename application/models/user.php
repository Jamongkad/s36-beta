<?php

class User {
    public function pull_users($users) { 
        $user = DB::table('User', 'slave')->where_in('userId', $users)->get();
        return $user;
    }
}
