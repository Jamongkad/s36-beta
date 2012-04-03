<?php

class DBUser extends S36DataObject {
    public function pull_users($users) { 
        $user = DB::table('User', 'master')->where_in('userId', $users)->get();
        return $user;
    }

    public function pull_user($user_obj) {    
        $user = DB::table('User', 'master')
                    ->where('username', '=', $user_obj->username)
                    ->where('companyId', '=', $user_obj->company_id)
                    ->first();
        return $user;
    }

    public function pull_user_emails_by_company_id($company_id) {
        return DB::table('User', 'master')->where('companyId', '=', $company_id)->get();
    }
}
