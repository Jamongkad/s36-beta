<?php

//$user = new S36Auth();
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

    'GET /([A-Za-z]+)' => function($company) { 
        print_r(Input::get());
        return View::of_layout()->partial('contents', 'home/login', Array('company' => $company));       
    },

    'GET /([A-Za-z]+)/login' => function($company) {
        $auth = new S36Auth;
        if($auth->check()) { 
            return View::of_layout()->partial('contents', 'dashboard/index');       
        } else {
            return View::of_layout()->partial('contents', 'home/login', Array('company' => $company));      
        }		
    },

    'POST /([A-Za-z]+)/login' => function($company) {
        $input = Input::get();
        $test = S36Auth::login($input['username'], $input['password'], Array('company' => $company));

        if(S36Auth::check()) {
            return Redirect::to('dashboard');           
        } else {
            return Redirect::to($company.'/login');
        }

    },
    
    'GET /([A-Za-z]+)/logout' => function($company) {
        S36Auth::logout();
        return Redirect::to($company.'/login');
    },

    'GET /help' => Array('name' => 'help', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'help/help_index_view');
    }),

    'GET /complete' => function() { 
        return View::of_home_layout()->partial('contents', 'home/user_auth_thankyou_view');       
    }
);
