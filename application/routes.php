<?php

use Feedback\Entities\FeedbackNode;

$feedback = new Feedback\Repositories\DBFeedback;
$hosted_settings = new Hosted\Repositories\DBHostedSettings;
$dbw = new Widget\Repositories\DBWidget;
$company = new Company\Repositories\DBCompany;
$company_social = new Company\Repositories\DBCompanySocialAccount;
$dbadmin_reply = new Feedback\Repositories\DBAdminReply;
$company_name = Config::get('application.subdomain');
$hosted_page_url = Config::get('application.url');
$fullpage =  new Hosted\Services\Fullpage;
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
    'GET /' => function() use($company_name, $hosted_settings, $company, $user, $feedback, $company_social, $hosted_page_url, $fullpage) {
        //consider placing this into a View Object
        $company_info = $company->get_company_info($company_name); 

        //hosted settings 
        $panel = $hosted_settings->get_panel_settings($company_info->companyid);

        //Feeds
        $feeds = $feedback->televised_feedback_alt($company_name);
        $hosted = new Feedback\Services\HostedService($company_name, $feeds->result, $panel->theme_name); 
        $hosted->page_number = 1; 
        $hosted->bust_hostfeed_data();
        $hosted->build_data();
        $feeds = $hosted->fetch_data_by_set();        
        $feed_advance_count = $hosted->determine_feed_advance();


        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name
                                                       , $company_info->fullpagecompanyname
                                                       , $company_info->domain);

        $fullpagedata = new Hosted\Services\FullpageData(Array(
             'company_name' => $company_info->company_name
           , 'company_id'   => $company_info->companyid
        ));

        $feedbackReports = new \Feedback\Repositories\DBFeedbackReports;
        
        $widget_loader = new Widget\Services\WidgetLoader($company_info->widgetkey, $load_submission_form=True);

        echo View::of_fullpage_layout()->partial('contents', 'hosted/hosted_feedback_fullpage_view', Array(  
                                                    'company'           => $company_info
                                                  , 'company_social'    => $company_social
                                                  , 'user'              => $user
                                                  , 'feeds'             => $feeds 
                                                  , 'feed_count'        => $fullpagedata->calculate_metrics()
                                                  , 'company_header'    => $header_view
                                                  , 'hosted_page_url'   => $hosted_page_url
                                                  , 'fullpage_css'      => $fullpage->get_fullpage_css($company_info->companyid)
                                                  , 'fullpage_patterns' => $fullpage->get_fullpage_pattern()
                                                  , 'reportTypes'       => $feedbackReports->get_reportTypes()
                                                  , 'panel'             => $panel 
                                                  , 'feed_advance_count'=> $feed_advance_count
                                                  , 'widget_loader'     => $widget_loader
                                                ));
        
        // increment page view count of company.
        $company->incr_page_view($company_info->companyid);
    },
    
    'GET /get_fullpage_css' => function() use($company_name, $company, $fullpage){
        $company_info = $company->get_company_info($company_name);
        echo $fullpage->get_fullpage_css($company_info->companyid);
    },
    
    'GET /get_panel_settings' => function() use($hosted_settings, $user){
        return $hosted_settings->get_panel_settings($user->companyid, 'json');
    },
    
    'POST /update_panel_settings' => function() use($hosted_settings, $user){
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action';
        
        $input = Input::get();
        $update = $hosted_settings->update_panel_settings($user->companyid, (object)$input);
        return json_encode($input);
    },

    'POST /admin_reply' => Array('name' => 'admin_reply', 'before' => 's36_auth', 'do' => function() use ($dbadmin_reply) {
        $feedbackId = Input::get('feedbackId');
        $adminReply = Input::get('adminReply');
        $userId = Input::get('userId');
        if(!empty($feedbackId) && !empty($adminReply) ) {
            $dbadmin_reply->add_admin_reply(array(
                 'feedbackId' => $feedbackId
               , 'adminReply' => $adminReply
               , 'userId' => $userId
            ));
            return json_encode($dbadmin_reply->get_admin_reply($feedbackId));
        }
    }),

    'GET /delete_admin_reply/(:any?)' => function($feedid) use ($dbadmin_reply) {
        return $dbadmin_reply->delete_admin_reply($feedid);
    },

    'POST /update_desc' => function() use($user, $hosted_settings){
        // if the user is not logged in, return error msg.
        if( ! is_object($user) ) return 'You should be logged in to do this action'; 
        
        $data = Input::get();
        $hosted_settings->update_desc($data, $user->companyid);
    },
    
    'POST /feedback_action/report_feedback' => function() use ($feedback) {
        $feedbackReports = new \Feedback\Repositories\DBFeedbackReports;
        $report = Input::get();
        $data   = array(
            'feedbackId'    =>$report['feedback_id'],
            'reportType'    =>$report['report_type'],
            'reportIp'      =>Helpers::get_client_ip(),
            'reportName'    =>(isset($report['report_user']['name'])) ? $report['report_user']['name'] : '',
            'reportEmail'   =>(isset($report['report_user']['email'])) ? $report['report_user']['email'] : '',
            'reportCompany' =>(isset($report['report_user']['company'])) ? $report['report_user']['company'] : '',
            'reportComments'=>(isset($report['report_user']['comments'])) ? $report['report_user']['comments'] : ''
        );

        $result = $feedbackReports->addReport($data);
        return json_encode($result);
    },
    'POST /feedback_action/unflag' => function() use ($feedback) {
        $feedbackReports = new \Feedback\Repositories\DBFeedbackReports;
        $report = Input::get();
        $data   = array(
            'feedbackId'    =>$report['feedback_id'],
            'reportIp'      =>Helpers::get_client_ip()
            );
        $result = $feedbackReports->removeReport($data);
        return json_encode($result);
    },
    
    'POST /feedback_action/vote' => function() use ($feedback) {
        $fd = new Feedback\Entities\FeedbackActionsData('vote', (object)Input::get() );
        if( ! is_null($fd->data) ) $feedback->exec_feedback_action($fd->data); 
    },
    
    'GET /submit/(:any)' => function($widgetkey) use ($hosted_settings, $dbw, $company) {
        $widgetloader = new Widget\Services\WidgetLoader($widgetkey, $load_submission_form=True); 
        $widget = $widgetloader->load();        

        return View::of_company_layout()->partial('contents', 'hosted/hosted_feedback_form_view', Array()); 
        /*
        $company_info = $company->get_company_info($company_name);
        $header_view = new Hosted\Services\CompanyHeader($company_info->company_name, $company_info->fullpagecompanyname, $company_info->domain);
        */
    },

    'POST /submit_feedback' => function() use($company_name, $company, $hosted_settings){
        
        // validate the submitted feedback data.
        $submission_service = new Feedback\Services\SubmissionService(Input::get());
        if( ! $submission_service->validate_feedback_data() ) return json_encode( array('error_msg' => $submission_service->error_msg) );
        
        
        /* stash this in a service somewhere...too much shit happening */
        $addfeedback         = new Feedback\Services\SubmissionService(Input::get());
        $feedback            = $addfeedback->perform();                

        $company_info         = $company->get_company_info($company_name);
        $hosted_settings_info = $hosted_settings->fetch_hosted_settings($company_info->companyid);
        
        $feedback_redirect   = Redirect::to('single/'.$feedback->id);
        $website_redirect    = Redirect::to('');

        $obj = new StdClass;
        $obj->company_name      = $company_name; 
        $obj->feedback_url      = $feedback_redirect->response->headers['Location'];
        $obj->website_url       = $website_redirect->response->headers['Location'];

        $tw_query = http_build_query(array(
            'url'       => $obj->feedback_url,
            'text'      => 'I recommend '.$obj->company_name.', just sent them some great feedback over at '.$obj->website_url.'. Go check them out!'
        ));

        $obj->tweet_button  = '<a href="https://twitter.com/share?'.$tw_query.'" class="twitter-share-button" data-size="large" data-count="none"><img src="/img/btn-tw-tweet.png" /></a>';
        $fb_iframe = '<iframe src="//www.facebook.com/plugins/like.php?href='.urlencode($obj->feedback_url).'&amp;send=false&amp;layout=standard&amp;width=390&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId='.Config::get('application.fb_id').'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:390px; height:35px;" allowTransparency="true"></iframe>';
        $obj->share_button = $fb_iframe;
        echo json_encode($obj);

        //remove some session variables used in submission form
        Session::forget('uploaded_avatar');
    },
    
    'GET /single/(:num)' => function($id) use ($user, $feedback, $company, $fullpage, $hosted_settings) { 
        
        $feedbackReports = new \Feedback\Repositories\DBFeedbackReports;
        $feedback  = $feedback->pull_feedback_by_id($id);
        
        //if no feedback then redirect back to home page.
        if(!$feedback) {
            return Redirect::to('/');     
        }
       
        $company   = $company->get_company_info($feedback->companyid);
        $feed_data = new FeedbackNode($feedback);
        $fb_id     = Config::get('application.fb_id');
        $panel = $hosted_settings->get_panel_settings($feedback->companyid);
        
        $widget_loader = new Widget\Services\WidgetLoader($company->widgetkey, $load_submission_form=True);

        return View::make('hosted/hosted_feedback_single_view', Array(
            'company'           => $company
          , 'user'              => $user
          , 'feedback'          => $feed_data->generate()
          , 'fb_id'             => $fb_id
          , 'panel'             => $hosted_settings->get_panel_settings($feedback->companyid)
          , 'fullpage_css'      => $fullpage->get_fullpage_css($feedback->companyid)
          , 'reportTypes'       => $feedbackReports->get_reportTypes()
          , 'widget_loader'     => $widget_loader
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
        if($forward_to = Input::get('forward_to')) { 
            if($forward_to == 'me') { 
                return Redirect::to('/');
            }
        } else {
            return Redirect::to('login');     
        } 
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
                                                       , 'warning' => 'Email does not exist.'
                                                       , 'company' => $company_name));
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
        if($forward_to == 'me') { 
            return Redirect::to('/');
        }
        return Redirect::to($forward_to);
    } else {
        //return Redirect::to('dashboard');
        // redirect to inbox by default.
        return Redirect::to('inbox');     
    } 
}
