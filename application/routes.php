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
    'GET /' => function() {
        $auth = new S36Auth;
        if($auth->check()) { 
            return View::of_layout()->partial('contents', 'dashboard/index');       
        } else {
            return View::of_layout()->partial('contents', 'home/login');      
        }		
    },

    'GET /logout' => function() {
        S36Auth::logout();
        return Redirect::to('/');
    },

    'POST /login' => function() {
        $input = Input::get();
        S36Auth::login($input['username'], $input['password']);

        if(S36Auth::check()) {
            return Redirect::to('/dashboard');           
        } else {
            return Redirect::to('/');
        }
    },

    'GET /settings' => Array('name' => 'settings', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'settings/settings_index_view');
    }),

    'GET /help' => Array('name' => 'help', 'before' => 's36_auth', 'do' => function() {
        return View::of_layout()->partial('contents', 'help/help_index_view');
    }),
);
