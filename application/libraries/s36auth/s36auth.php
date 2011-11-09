<?php namespace S36Auth;

use Session;
use DB;
use Hash;

class S36Auth {
    
    public static $user;
    private static $db_name = 'master';
    private static $user_id = 's36_user_id';

    public static function user() { 
        if(is_null(static::$user) and Session::has(static::$user_id)) {
            static::$user = DB::table('User', static::$db_name)
                ->join('AuthAssignment', 'User.userId', '=', 'AuthAssignment.userid')
                ->where('User.userId', '=', Session::get(static::$user_id))->first();
        } 
        return static::$user;
    }

    public static function user_company() { 
        return DB::table('User', static::$db_name)->join('Company', 'Company.companyId', '=', 'User.companyId')
                                ->where('User.userId', '=', Session::get(static::$user_id))->first(array('Company.name', 'Company.billTo'));
    }

    public static function user_site() { 
        return DB::table('User', static::$db_name)->join('Site', 'Site.companyId', '=', 'User.companyId')
                                ->where('User.userId', '=', Session::get(static::$user_id))->get(Array('Site.siteId'));
    }

    public static function login($username, $password) {
        
        $user = DB::table('User', static::$db_name)->where('email', '=', $username)
                                                   ->or_where('username', '=', $username)
                                                   ->first();
        if(! is_null($user)) {
            $user_password = $user->password; 
            if(crypt($password, $user_password) === $user_password) {
                static::$user = $user;
                Session::put(static::$user_id, $user->userid);
                return true; 
            }
        }

        return false;
    }

    public static function logout() { 
        Session::forget(static::$user_id);
        static::$user = Null;
    }

    public static function check() {         
		return ( ! is_null(static::user()));
    }

    public static function register() {
        // use crypt...
    }
}
