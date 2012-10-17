<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Filters
	|--------------------------------------------------------------------------
	|
	| Filters provide a convenient method for filtering access to your route
	| functions. To make your life easier, we have already setup basic filters
	| for authentication and CSRF protection.
	|
	| For more information, check out: http://laravel.com/docs/basics/routes#filters
	|
	*/

	'before' => function($response)
	{
		// Do stuff before every request is executed.	
	},


	'after' => function($response)
	{
		// Do stuff after every request is executed.
	},


	'auth' => function()
	{
		return ( ! Auth::check()) ? Redirect::to_login() : null;
	},


	'csrf' => function()
	{
		return (Input::get('csrf_token') !== Form::raw_token()) ? Response::make(View::make('error/500'), 500) : null;
	},

    //S36 Defined Filters
    's36_auth' => function() {
        if(S36Auth::check()) {
            return null;     
        } else {
            //we should not be able to reach this point. And if so find a solution immediately
            return Redirect::to('login');   
        }
    },

    's36_is_admin' => function() { 
        return (S36Auth::user()->itemname != "Admin") ? Redirect::to('admin') : Null;
    },

    's36_auth_rest' => function() {
    	$auth = Cookie::get('authcookie');
        if(isset($auth) && !empty($auth) && (S36Auth::user()->encryptstring==$auth)) {
            return null;     
        } else {
            return json_encode(array(
				'success'	=>	false,
				'message'	=>	'Authentication failed',
				'data'		=>	null
			));
        }
    },
);
