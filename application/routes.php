<?php

$feedback = new Feedback\Repositories\DBFeedback;
$hosted_settings = new Widget\Repositories\DBHostedSettings;
$dbw = new Widget\Repositories\DBWidget;
$company = new Company\Repositories\DBCompany;
$company_social = new Company\Repositories\DBCompanySocialAccount;
$company_name = Config::get('application.subdomain');
Package::load('eden');
eden()->setLoader();

$user = S36Auth::user();

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
    'GET /' => function() use($company_name, $hosted_settings, $company, $user, $feedback, $company_social) {
        //consider placing this into a View Object
        $company_info = $company->get_company_info($company_name);
        $hosted = new Feedback\Services\HostedService($company_name); 
        //Feeds 
        $hosted->page_number = 1;
        $hosted->build_data();
        $feeds = $hosted->fetch_data_by_set();

        //hosted settings
        $hosted_settings->set_hosted_settings(Array('companyId' => $company_info->companyid));
        $hosted_settings_info = $hosted_settings->hosted_settings();
    
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name
                                                       , $company_info->fullpagecompanyname
                                                       , $company_info->domain);

        $meta = new Hosted\Services\HostedMetadata(Array(
             'company_name' => $company_info->company_name
           , 'company_id' => $company_info->companyid
        ));

        $meta->calculate_metrics();

        echo View::of_fullpage_layout()->partial('contents', 'hosted/hosted_feedback_fullpage_view', Array(  
                                                    'company'         => $company_info
                                                  , 'company_social'  => $company_social
                                                  , 'user'            => $user
                                                  , 'feeds'           => $feeds 
                                                  , 'feed_count'      => $meta->perform()
                                                  , 'company_header'  => $header_view
                                                  , 'hosted'          => $hosted_settings_info));        
    },
    
    'POST /update_desc_header' => function() use($user, $company){ 
        // don't proceed if the user is not logged in.
        // return 1 for error checking.
        if( ! is_object($user) ) return 1;
        
        $data = Input::get();
        $company->update_desc_header($data, $user->companyid); 
    },
     
    'GET /(:any)/submit' => function($company_name) use ($hosted_settings, $dbw, $company) {
        $widgetloader = new Widget\Services\WidgetLoader($company_name, $load_submission_form=True, $load_canonical=True); 
        $widget = $widgetloader->load();

        $company_info = $company->get_company_info($company_name);
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name, $company_info->fullpagecompanyname, $company_info->domain);
        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array(
                                                      'widget' => $widget->render_hosted()
                                                    , 'company_header' => $header_view)); 
    },

    'POST /submit_feedback' => function() use($company_name, $company, $hosted_settings){
        //Helpers::dump(Input::get('metadata'));

        if(Input::has('metadata')) {
            $_ = new Underscore; 
            $group = $_->groupBy(Input::get('metadata'), 'name'); 
            Helpers::dump(json_encode($group));
            Helpers::dump($group);
        }   

        /*
        $addfeedback         = new Feedback\Services\SubmissionService(Input::get());
        $feedback            = $addfeedback->perform();

        $company_info        = $company->get_company_info($company_name);
        $hosted_settings->set_hosted_settings(Array('companyId' => $company_info->companyid));
        $hosted_settings_info = $hosted_settings->hosted_settings();

        $feedback_redirect   = Redirect::to('single/'.$feedback->feedbackid);
        $website_redirect    = Redirect::to('');

        $obj = new StdClass;
        $obj->company_name      = $company_info->company_name;
        $obj->feedback_url      = $feedback_redirect->response->headers['Location'];
        $obj->website_url       = $website_redirect->response->headers['Location'];

        $tw_query = http_build_query(array(
                    'url'       =>$obj->feedback_url,
                    'text'      =>'I recommend '.$obj->company_name.', just sent them some great feedback over at '.$obj->website_url.'. Go check them out!'
        ));
        $fb_query = http_build_query(array(
                    'app_id'        => '396019640480197',
                    'link'          => $obj->feedback_url,
                    'picture'       => 'https://robert-staging.gearfish.com/img/36logo2.png',
                    'name'          => $obj->company_name,
                    'caption'       => $hosted_settings_info->header_text,
                    'description'   => 'I recommend '.$obj->company_name.', just sent them some great feedback over at '.$obj->website_url.'. Go check them out!',
                    'redirect_uri'  => $obj->feedback_url
        ));
        $obj->tweet_button      = '<a href="https://twitter.com/share?'.$tw_query.'" class="twitter-share-button" data-size="large" data-count="none"><img src="/img/btn-tw-tweet.png" /></a>';
        $obj->share_button      = '<a href="https://www.facebook.com/dialog/feed?'.$fb_query.'"><img src="/img/fb-share-btn.png" /></a>';

        echo json_encode($obj);
        */
    },
    
    'GET /single/(:num)' => function($id) use ($feedback, $hosted_settings, $company) { 

        $feedback = $feedback->pull_feedback_by_id($id);
        $company_info = $company->get_company_info($feedback->companyid);

        $fb_id = Config::get('application.fb_id');

        $hosted_settings->set_hosted_settings(Array('companyId' => $feedback->companyid));  
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name, $company_info->fullpagecompanyname, $company_info->domain);

        return View::make('hosted/hosted_feedback_single_view', Array(
            'feedback' => $feedback 
          , 'company_header' => $header_view 
          , 'fb_id' => $fb_id
          , 'hosted' => $hosted_settings->hosted_settings()
        ));
    },

    'GET /login' => function() use($company_name) {
        $auth = new S36Auth;
        if($auth->check()) { 
            return forward_or_dash();
        } else {
            return View::of_home_layout()->partial('contents', 'home/login', Array(
                'company' => $company_name, 'errors' => array(), 'warning' => null
            ));      
        }		

    },

    'POST /login' => function() use($company_name) {
        $input = Input::get();        
        $auth = new S36Auth;

        $rules = Array(
            'username' => 'required'
          , 'password' => 'required'
        );
 
        $validator = Validator::make($input, $rules);

        if(!$validator->valid()) { 
            return View::of_home_layout()->partial('contents', 'home/login', Array(  
                                                       'company' => $company_name
                                                     , 'errors' => $validator->errors
                                                     , 'warning' => null));      
        } else {

            $auth->login($input['username'], $input['password'], Array('company' => $company_name)); 

            if($auth->check()) {

                $user_id = $auth->user()->userid;
                $company_id = $auth->user()->companyid;

                $halcyon = new Halcyonic\Services\HalcyonicService;
                $halcyon->company_id = $company_id;
                $halcyon->set_user_feedcount($user_id);
                
                return forward_or_dash();
            } else {
                return View::of_home_layout()->partial('contents', 'home/login', Array(  
                    'company' => $company_name
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
        return View::of_home_layout()->partial('contents', 'help/help_index_view');
    }),

    'GET /complete' => function() { 
        return View::of_home_layout()->partial('contents', 'home/user_auth_thankyou_view');       
    },

    'GET /resend_password' => function() use($company_name) {  
        return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                   'errors'  => Array()
                                                 , 'warning' => null
                                                 , 'company' => $company_name));       
    },

    'POST /resend_password' => function() use($company_name) {
        $admin = new DBadmin; 
        $data = Input::get();
        $rules = Array('email' => 'required|email');
 
        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                       'errors' => $validator->errors
                                                     , 'warning' => null
                                                     , 'company' => $company_name));
        } else {
            $opts = new StdClass; 
            $opts->username = $data['email'];
            $opts->options = Array('company' => $company_name);
            $user = $admin->fetch_admin_details($opts);

            if(!$user) { 
                return View::of_home_layout()->partial('contents', 'home/resend_password_view', Array(
                                                         'errors' => Array()
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
    
    'GET /password_reset' => function() use($company_name) { 
        $data = Input::get();
        $encrypt = new Encryption\Encryption;

        $params = explode("|", $encrypt->decrypt($data['k']));
        //I am the only key to user passwords!!! MWHAHAHA
        if($params[0] === "jamongkad") {  
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                                                       'subdomain' => $company_name
                                                     , 'email' => $data['email']
                                                     , 'user_id' => $params[1]
                                                     , 'errors' => array()));       
        }
       
    },

    'POST /password_reset' => function() {  
        $data = Input::get();
        $encrypt = new Encryption\Encryption;

        $rules = Array(
            'password' => 'required|min:8|confirmed'
        );

        $validator = Validator::make($data, $rules);
        if(!$validator->valid()) {
            return View::of_home_layout()->partial('contents', 'home/password_reset_view', Array(
                                                       'subdomain' => $data['company']
                                                     , 'email' => $data['email']
                                                     , 'user_id' => $data['user_id']
                                                     , 'errors' => $validator->errors));        
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
    },
);

function forward_or_dash() { 
    if($forward_to = Input::get('forward_to')) {
        return Redirect::to($forward_to);
    } else {
        return Redirect::to('dashboard');     
    } 
}
