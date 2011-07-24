<?php

$user = new S36Auth();
$view = View::make('partials/layout');

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
    'GET /' => function() use ($view) {
        $view->contents = View::make('home/login'); 
        return $view;
    }, 

    'GET /logout' => function() use($user) {
        $user->logout(); 
        return Redirect::to('/');
    },

    'POST /login' => function() use($user) {
        $input = Input::get();
        $user->login($input['username'], $input['password']);

        if($user->check()) {
            return Redirect::to('/dashboard');           
        } else {
            return Redirect::to('/');
        }

    },
);
