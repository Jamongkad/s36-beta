<?php
session_start();
Package::load('eden');
eden()->setLoader();
return array(
	
    'GET /socialnetwork/facebook/(:any)' => function($action){
        

        $fb_key         = '396019640480197';
        $fb_secret      = 'ad2631876e1a3a21d4b669447f4dc389';
        $return_url     = 'http://robert-staging.gearfish.com/socialnetwork/facebook/login';

        switch($action){
            case 'login':
                $auth = eden('facebook')->auth($fb_key,$fb_secret,$return_url);
                if(!isset($_GET['code']) && !isset($_SESSION['fb_token'])) {
                    $login = $auth->getLoginUrl();
                    //echo json_encode(array('url'=>$login));
                    return Redirect::to($login);
                }
                if(isset($_GET['code'])) {
                    $access = $auth->getAccess($_GET['code']);
                    $_SESSION['fb_token'] = $access['access_token'];

                    $graph = eden('facebook')->graph($_SESSION['fb_token']);
                    $userInfo = $graph->getUser();
                    echo json_encode($userInfo);
                    
                }
                break;
        }
    },

    'GET /socialnetwork/test' => function(){
        session_destroy();
    },
    'GET /socialnetwork/twitter' => function(){
            $auth = eden('twitter')->auth('xWBm4zMz9q3cgiTnzZf6Rg','TbCPpdcteB4pRAXqQGba8njhDYmg7LjfHq7YLgKlE');
            if(!isset($_SESSION['access_token'], $_SESSION['access_secret'])) {
                if(!isset($_SESSION['request_secret'])) {
                    $oauth_callback = 'http://robert-staging.gearfish.com/socialnetwork/twitter/';
                    $token = $auth->getRequestToken($oauth_callback);
                    $_SESSION['request_secret'] = $token['oauth_token_secret'];
                    $login = $auth->getLoginUrl($token['oauth_token']);
                    return Redirect::to($login);
                    exit;
                }
               
            if(isset($_GET['oauth_token'], $_GET['oauth_verifier'])) {
                    $token = $auth->getAccessToken($_GET['oauth_token'], $_SESSION['request_secret'], $_GET['oauth_verifier']);
                    $_SESSION['access_token']   = $token['oauth_token'];
                    $_SESSION['access_secret']  = $token['oauth_token_secret'];
                    unset($_SESSION['request_secret']);
                    echo '<script type="text/javascript">window.close();</script>';
                }
            }
            if(isset($_SESSION['access_token']) && isset($_SESSION['access_secret'])){
                    echo '<script type="text/javascript">window.close();</script>';
            }
    },

    'GET /socialnetwork/twitter/userinfo' => function(){
        if(isset($_SESSION['access_token']) && isset($_SESSION['access_secret'])){
            $users = eden('twitter')->users('xWBm4zMz9q3cgiTnzZf6Rg','TbCPpdcteB4pRAXqQGba8njhDYmg7LjfHq7YLgKlE',$_SESSION['access_token'], $_SESSION['access_secret']);
            echo json_encode($users->getCredentials());
            //echo "<pre>";print_r($users->getCredentials());echo "</pre>";
        }
    },

);

