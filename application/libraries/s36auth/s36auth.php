<?php namespace S36Auth;

use Session;
use DB;
use Hash;

class S36Auth {
    
    private $user;
    private $db_name;
    private $user_id;

    public function __construct() {
        $this->db_name = 'master';
        $this->user_id = 's36_user_id';
    }

    public function user() { 
        if(is_null($this->user) and Session::has($this->user_id)) {
            $this->user = DB::table('User', $this->db_name)->where('userId', '=', Session::get($this->user_id))->first();
        } 
        return $this->user;
    }

    public function login($username, $password) {
        
        $user = DB::table('User', $this->db_name)->where('email', '=', $username)
                                           ->or_where('username', '=', $username)->first();
        if(! is_null($user)) {
            $user_password = $user->password; 
            if(crypt($password, $user_password) === $user_password) {
                $this->user = $user;
                Session::put($this->user_id, $user->userid);
                return true; 
            }
        }

        return false;
    }

    public function logout() { 
        Session::forget($this->user_id);
        $this->user = Null;
    }

    public function check() {         
		return ( ! is_null($this->user()));
    }

    public static function register() {
        // use crypt...
    }
}
