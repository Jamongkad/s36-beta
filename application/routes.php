<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is the public API of your application. To add functionality to your
	| application, you just add to the array located in this file.
	|
	| It's a breeze. Simply tell Laravel the request URIs it should respond to.
	|
	| Need more breathing room? Organize your routes in their own directory.
	| Here's how: http://laravel.com/docs/start/routes#organize
	|
	*/
    'GET /' => function() { 
        $company = Input::get('subdomain');
        $auth = new S36Auth;

        if($auth->check()) { 
            return Redirect::to('dashboard');     
        } else { 
            return Redirect::to('login');     
        }		

    },

    'GET /login' => function() {
        $auth = new S36Auth;
        $company = Input::get('subdomain');

        if($auth->check()) { 
            return View::of_layout()->partial('contents', 'dashboard/dashboard_index_view');       
        } else {
            return View::of_layout()->partial('contents', 'home/login', Array('company' => $company, 'errors' => array(), 'warning' => null));      
        }		

    },

    'POST /login' => function() {
        $input = Input::get();        
        $auth = new S36Auth;

        $rules = Array(
            'username' => 'required'
          , 'password' => 'required'
        );
 
        $validator = Validator::make($input, $rules);

        if(!$validator->valid()) { 
            return View::of_layout()->partial('contents', 'home/login', Array(  'company' => $_GET['subdomain']
                                                                              , 'errors' => $validator->errors
                                                                              , 'warning' => null));      
        } else {

            $auth->login($input['username'], $input['password'], Array('company' => $_GET['subdomain'])); 

            if($auth->check()) {

                $user_id = $auth->user()->userid;
                $company_id = $auth->user()->companyid;

                $halcyon = new Halcyonic\Services\HalcyonicService($company_id);
                $halcyon->set_user_feedcount($user_id);

                if($forward_to = Input::get('forward_to')) {
                    return Redirect::to($forward_to);
                } else {
                    return Redirect::to('dashboard');     
                } 
                
            } else {
                return View::of_layout()->partial('contents', 'home/login', Array(  'company' => $_GET['subdomain']
                                                                                  , 'errors' => Array()
                                                                                  , 'warning' => 'Invalid login - try again.')); 
            } 
        }
    },
    
    'GET /logout' => function() {
        S36Auth::logout();
        return Redirect::to('login');
    },

    'GET /help' => Array('name' => 'help', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'help/help_index_view');
    }),

    'GET /complete' => function() { 
        return View::of_home_layout()->partial('contents', 'home/user_auth_thankyou_view');       
    },

    'GET /resend_password' => function() {  
        return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array('errors'  => Array(), 'warning' => null));       
    },

    'POST /resend_password' => function() {
        $admin = new DBadmin; 
        $data = Input::get();

        $rules = Array(
            'email' => 'required|email'
        );
 
        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array('errors' => $validator->errors, 'warning' => null));
        } else {
            $opts = new StdClass; 
            $opts->username = $data['email'];
            $opts->options = Array('company' => $_GET['subdomain']);
            $user = $admin->fetch_admin_details($opts);

            if(!$user) { 
                return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array('errors' => Array()
                                                       , 'warning' => 'Email does not exist.'));
            }
        
            $data = new Email\Entities\ResendPasswordData;
            $data->user_data = $user;
            $data->get_host();
            $data->reset_key();

            $emailservice = new Email\Services\EmailService($data);
            $emailservice->send_email();  
            //success!
            return View::of_home_layout()->partial('contents', 'home/resend_password_sent_view');        
        }

    },
    
    'GET /password_reset' => function() { 
        $data = Input::get();
        $encrypt = new Crypter;

        $params = explode("|", $encrypt->decrypt($data['k']));
        //I am the only key to user passwords!!! MWHAHAHA
        if($params[0] === "jamongkad") {  
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                'subdomain' => $data['subdomain'], 'email' => $data['email'], 'user_id' => $params[1], 'errors' => array()
            ));       
        }
       
    },

    'POST /password_reset' => function() {  
        $data = Input::get();
        $encrypt = new Crypter;

        $rules = Array(
            'password' => 'required|min:8|confirmed'
        );

        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                'subdomain' => $data['company'], 'email' => $data['email'], 'user_id' => $data['user_id'], 'errors' => $validator->errors
            ));        
        } else {

            $user = DB::table('User', 'master')->where('User.userId', '=', $data['user_id'])->first();

            $personal_data = Array( 
                'username' => strtolower($user->username)
              , 'password' => crypt($data['password'])
              , 'encryptString' => $encrypt->encrypt(strtolower($user->username)."|".$data['password'])
            );

            DB::table('User', 'master')
                ->where('User.userId', '=', $data['user_id'])
                ->update($personal_data);

            return View::of_home_layout()->partial('contents', 'home/reset_password_success_view');        
        }
    }
);
