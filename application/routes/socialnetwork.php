<?php
session_start();
Package::load('eden');
eden()->setLoader();

//Config::get('application.fb_id')
define('TW_KEY','xWBm4zMz9q3cgiTnzZf6Rg');
define('TW_SECRET','TbCPpdcteB4pRAXqQGba8njhDYmg7LjfHq7YLgKlE');
define('TW_CALLBACK',URL::to('socialnetwork/twitter/'));
return array(
    /*
    /TWITTER
    */
    'GET /socialnetwork/twitter' => function(){
        $auth = eden('twitter')->auth(TW_KEY,TW_SECRET);
        if(!isset($_SESSION['tw_access_token'], $_SESSION['tw_access_secret'])) {
            if(!isset($_SESSION['tw_request_secret'])) {
                $token = $auth->getRequestToken(TW_CALLBACK);
                $_SESSION['tw_request_secret'] = $token['oauth_token_secret'];
                $login = $auth->getLoginUrl($token['oauth_token']);
                return Redirect::to($login);
                exit();
            }
           
        if(isset($_GET['oauth_token'], $_GET['oauth_verifier'])) {
                $token = $auth->getAccessToken($_GET['oauth_token'], $_SESSION['tw_request_secret'], $_GET['oauth_verifier']);
                $_SESSION['tw_access_token']   = $token['oauth_token'];
                $_SESSION['tw_access_secret']  = $token['oauth_token_secret'];
                unset($_SESSION['tw_request_secret']);
                echo '<script type="text/javascript">window.close();</script>';
            }
        }
        if(isset($_SESSION['tw_access_token']) && isset($_SESSION['tw_access_secret'])){
                echo '<script type="text/javascript">window.close();</script>';
        }
    },

    'GET /socialnetwork/twitter/userinfo' => function(){
        if(isset($_SESSION['tw_access_token']) && isset($_SESSION['tw_access_secret'])){
            $users = eden('twitter')->users(TW_KEY,TW_SECRET,$_SESSION['tw_access_token'], $_SESSION['tw_access_secret']);
            echo json_encode($users->getCredentials());
        }
    },
);

