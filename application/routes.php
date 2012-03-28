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
        return View::of_layout()->partial('contents', 'home/login', Array('company' => $company));       
    },

    'GET /login' => function() {
        $auth = new S36Auth;
        $company = Input::get('subdomain');

        if($auth->check()) { 
            return View::of_layout()->partial('contents', 'dashboard/index');       
        } else {
            return View::of_layout()->partial('contents', 'home/login', Array('company' => $company));      
        }		

    },

    'POST /login' => function() {
        $input = Input::get();        
        $auth = new S36Auth;
        $auth->login($input['username'], $input['password'], Array('company' => $_GET['subdomain'])); 
        if($auth->check()) {
            return Redirect::to('dashboard');           
        } else {
            return Redirect::to('login');
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
    }
);
