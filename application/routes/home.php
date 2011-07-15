<?php

$user = new S36Auth();
$view = View::make('partials/layout');

return array(

    'GET /login' => function() use ($view) {
        $view->contents = View::make('home/login'); 
        return $view;
    }, 

    'GET /logout' => function() use($user) {
        $user->logout(); 
        return Redirect::to('/login');
    },

    'POST /login' => function() use($user) {
        $input = Input::get();
        $user->login($input['username'], $input['password']);

        if($user->check()) {
            return Redirect::to('/dashboard');           
        } else {
            return Redirect::to('/login');
        }

    },
     
    'GET /test' => function() use($user) {
        print_r($user->user());
        print_r($user->check());
        return View::make('home/test');
    },

    'GET /test_login' => function() use($user) { 
        print_r($user->login("ryan", "p455w0rd"));
    },

    'GET /test_json_request' => function() {
        $obj = new StdClass; 
        $obj->firstname = $_GET['name'];
        $obj->lastname = $_GET['lastname'];
        $obj->email = "wrm932@gmail.com";

        $response = "callback(". json_encode($obj)  .");";
        echo $response;
    },

    'GET /feedback' => function() use($user) {
        $user_id = $user->user()->userid;
        $user_model = new Feedback;
        print_r($user_model->pull_feedback($user_id));
    },

);
